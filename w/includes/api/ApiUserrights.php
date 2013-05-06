<?php

/**
 *
 *
 * Created on Mar 24, 2009
 *
 * Copyright © 2009 Roan Kattouw "<Firstname>.<Lastname>@gmail.com"
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
 * @ingroup API
 */
class Apiwiki_userrights extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	private $mwiki_user = null;

	public function execute() {
		$params = $this->extractRequestParams();

		$wiki_user = $this->getUrwiki_user();

		$form = new wiki_userrightsPage;
		$r['wiki_user'] = $wiki_user->getName();
		$r['wiki_userid'] = $wiki_user->getId();
		list( $r['added'], $r['removed'] ) =
			$form->doSavewiki_userGroups(
				$wiki_user, (array)$params['add'],
				(array)$params['remove'], $params['reason'] );

		$result = $this->getResult();
		$result->setIndexedTagName( $r['added'], 'group' );
		$result->setIndexedTagName( $r['removed'], 'group' );
		$result->addValue( null, $this->getModuleName(), $r );
	}

	/**
	 * @return wiki_user
	 */
	private function getUrwiki_user() {
		if ( $this->mwiki_user !== null ) {
			return $this->mwiki_user;
		}

		$params = $this->extractRequestParams();

		$form = new wiki_userrightsPage;
		$status = $form->fetchwiki_user( $params['wiki_user'] );
		if ( !$status->isOK() ) {
			$errors = $status->getErrorsArray();
			$this->dieUsageMsg( $errors[0] );
		} else {
			$wiki_user = $status->value;
		}

		$this->mwiki_user = $wiki_user;
		return $wiki_user;
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array (
			'wiki_user' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'add' => array(
				ApiBase::PARAM_TYPE => wiki_user::getAllGroups(),
				ApiBase::PARAM_ISMULTI => true
			),
			'remove' => array(
				ApiBase::PARAM_TYPE => wiki_user::getAllGroups(),
				ApiBase::PARAM_ISMULTI => true
			),
			'token' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'reason' => array(
				ApiBase::PARAM_DFLT => ''
			)
		);
	}

	public function getParamDescription() {
		return array(
			'wiki_user' => 'wiki_user name',
			'add' => 'Add the wiki_user to these groups',
			'remove' => 'Remove the wiki_user from these groups',
			'token' => 'A wiki_userrights token previously retrieved through list=wiki_users',
			'reason' => 'Reason for the change',
		);
	}

	public function getDescription() {
		return 'Add/remove a wiki_user to/from groups';
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return $this->getUrwiki_user()->getName();
	}

	public function getExamples() {
		return array(
			'api.php?action=wiki_userrights&wiki_user=FooBot&add=bot&remove=sysop|bureaucrat&token=123ABC'
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:wiki_user_group_membership';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
