<?php
/**
 *
 *
 * Created on July 30, 2007
 *
 * Copyright © 2007 Yuri Astrakhan "<Firstname><Lastname>@gmail.com"
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * Query module to get information about the currently logged-in wiki_user
 *
 * @ingroup API
 */
class ApiQuerywiki_userInfo extends ApiQueryBase {

	private $prop = array();

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'ui' );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		$result = $this->getResult();

		if ( !is_null( $params['prop'] ) ) {
			$this->prop = array_flip( $params['prop'] );
		}

		$r = $this->getCurrentwiki_userInfo();
		$result->addValue( 'query', $this->getModuleName(), $r );
	}

	protected function getCurrentwiki_userInfo() {
		global $wgHiddenPrefs;
		$wiki_user = $this->getwiki_user();
		$result = $this->getResult();
		$vals = array();
		$vals['id'] = intval( $wiki_user->getId() );
		$vals['name'] = $wiki_user->getName();

		if ( $wiki_user->isAnon() ) {
			$vals['anon'] = '';
		}

		if ( isset( $this->prop['blockinfo'] ) ) {
			if ( $wiki_user->isBlocked() ) {
				$block = $wiki_user->getBlock();
				$vals['blockid'] = $block->getId();
				$vals['blockedby'] = $block->getByName();
				$vals['blockedbyid'] = $block->getBy();
				$vals['blockreason'] = $wiki_user->blockedFor();
			}
		}

		if ( isset( $this->prop['hasmsg'] ) && $wiki_user->getNewtalk() ) {
			$vals['messages'] = '';
		}

		if ( isset( $this->prop['groups'] ) ) {
			$vals['groups'] = $wiki_user->getEffectiveGroups();
			$result->setIndexedTagName( $vals['groups'], 'g' );	// even if empty
		}

		if ( isset( $this->prop['implicitgroups'] ) ) {
			$vals['implicitgroups'] = $wiki_user->getAutomaticGroups();
			$result->setIndexedTagName( $vals['implicitgroups'], 'g' );	// even if empty
		}

		if ( isset( $this->prop['rights'] ) ) {
			// wiki_user::getRights() may return duplicate values, strip them
			$vals['rights'] = array_values( array_unique( $wiki_user->getRights() ) );
			$result->setIndexedTagName( $vals['rights'], 'r' );	// even if empty
		}

		if ( isset( $this->prop['changeablegroups'] ) ) {
			$vals['changeablegroups'] = $wiki_user->changeableGroups();
			$result->setIndexedTagName( $vals['changeablegroups']['add'], 'g' );
			$result->setIndexedTagName( $vals['changeablegroups']['remove'], 'g' );
			$result->setIndexedTagName( $vals['changeablegroups']['add-self'], 'g' );
			$result->setIndexedTagName( $vals['changeablegroups']['remove-self'], 'g' );
		}

		if ( isset( $this->prop['options'] ) ) {
			$vals['options'] = $wiki_user->getOptions();
		}

		if ( isset( $this->prop['preferencestoken'] ) &&
			is_null( $this->getMain()->getRequest()->getVal( 'callback' ) )
		) {
			$vals['preferencestoken'] = $wiki_user->getEditToken( '', $this->getMain()->getRequest() );
		}

		if ( isset( $this->prop['editcount'] ) ) {
			$vals['editcount'] = intval( $wiki_user->getEditCount() );
		}

		if ( isset( $this->prop['ratelimits'] ) ) {
			$vals['ratelimits'] = $this->getRateLimits();
		}

		if ( isset( $this->prop['realname'] ) && !in_array( 'realname', $wgHiddenPrefs ) ) {
			$vals['realname'] = $wiki_user->getRealName();
		}

		if ( isset( $this->prop['email'] ) ) {
			$vals['email'] = $wiki_user->getEmail();
			$auth = $wiki_user->getEmailAuthenticationTimestamp();
			if ( !is_null( $auth ) ) {
				$vals['emailauthenticated'] = wfTimestamp( TS_ISO_8601, $auth );
			}
		}

		if ( isset( $this->prop['registrationdate'] ) ) {
			$regDate = $wiki_user->getRegistration();
			if ( $regDate !== false ) {
				$vals['registrationdate'] = wfTimestamp( TS_ISO_8601, $regDate );
			}
		}

		if ( isset( $this->prop['acceptlang'] ) ) {
			$langs = $this->getRequest()->getAcceptLang();
			$acceptLang = array();
			foreach ( $langs as $lang => $val ) {
				$r = array( 'q' => $val );
				ApiResult::setContent( $r, $lang );
				$acceptLang[] = $r;
			}
			$result->setIndexedTagName( $acceptLang, 'lang' );
			$vals['acceptlang'] = $acceptLang;
		}
		return $vals;
	}

	protected function getRateLimits() {
		global $wgRateLimits;
		$wiki_user = $this->getwiki_user();
		if ( !$wiki_user->isPingLimitable() ) {
			return array(); // No limits
		}

		// Find out which categories we belong to
		$categories = array();
		if ( $wiki_user->isAnon() ) {
			$categories[] = 'anon';
		} else {
			$categories[] = 'wiki_user';
		}
		if ( $wiki_user->isNewbie() ) {
			$categories[] = 'ip';
			$categories[] = 'subnet';
			if ( !$wiki_user->isAnon() )
				$categories[] = 'newbie';
		}
		$categories = array_merge( $categories, $wiki_user->getGroups() );

		// Now get the actual limits
		$retval = array();
		foreach ( $wgRateLimits as $action => $limits ) {
			foreach ( $categories as $cat ) {
				if ( isset( $limits[$cat] ) && !is_null( $limits[$cat] ) ) {
					$retval[$action][$cat]['hits'] = intval( $limits[$cat][0] );
					$retval[$action][$cat]['seconds'] = intval( $limits[$cat][1] );
				}
			}
		}
		return $retval;
	}

	public function getAllowedParams() {
		return array(
			'prop' => array(
				ApiBase::PARAM_DFLT => null,
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'blockinfo',
					'hasmsg',
					'groups',
					'implicitgroups',
					'rights',
					'changeablegroups',
					'options',
					'preferencestoken',
					'editcount',
					'ratelimits',
					'email',
					'realname',
					'acceptlang',
					'registrationdate'
				)
			)
		);
	}

	public function getParamDescription() {
		return array(
			'prop' => array(
				'What pieces of information to include',
				'  blockinfo        - Tags if the current wiki_user is blocked, by whom, and for what reason',
				'  hasmsg           - Adds a tag "message" if the current wiki_user has pending messages',
				'  groups           - Lists all the groups the current wiki_user belongs to',
				'  implicitgroups   - Lists all the groups the current wiki_user is automatically a member of',
				'  rights           - Lists all the rights the current wiki_user has',
				'  changeablegroups - Lists the groups the current wiki_user can add to and remove from',
				'  options          - Lists all preferences the current wiki_user has set',
				'  preferencestoken - Get a token to change current wiki_user\'s preferences',
				'  editcount        - Adds the current wiki_user\'s edit count',
				'  ratelimits       - Lists all rate limits applying to the current wiki_user',
				'  realname         - Adds the wiki_user\'s real name',
				'  email            - Adds the wiki_user\'s email address and email authentication date',
				'  acceptlang       - Echoes the Accept-Language header sent by the client in a structured format',
				'  registrationdate - Adds the wiki_user\'s registration date',
			)
		);
	}

	public function getResultProperties() {
		return array(
			ApiBase::PROP_LIST => false,
			'' => array(
				'id' => 'integer',
				'name' => 'string',
				'anon' => 'boolean'
			),
			'blockinfo' => array(
				'blockid' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'blockedby' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'blockedbyid' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'blockedreason' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'hasmsg' => array(
				'messages' => 'boolean'
			),
			'preferencestoken' => array(
				'preferencestoken' => 'string'
			),
			'editcount' => array(
				'editcount' => 'integer'
			),
			'realname' => array(
				'realname' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'email' => array(
				'email' => 'string',
				'emailauthenticated' => array(
					ApiBase::PROP_TYPE => 'timestamp',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'registrationdate' => array(
				'registrationdate' => array(
					ApiBase::PROP_TYPE => 'timestamp',
					ApiBase::PROP_NULLABLE => true
				)
			)
		);
	}

	public function getDescription() {
		return 'Get information about the current wiki_user';
	}

	public function getExamples() {
		return array(
			'api.php?action=query&meta=wiki_userinfo',
			'api.php?action=query&meta=wiki_userinfo&uiprop=blockinfo|groups|rights|hasmsg',
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Meta#wiki_userinfo_.2F_ui';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
