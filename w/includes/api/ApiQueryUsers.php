<?php
/**
 *
 *
 * Created on July 30, 2007
 *
 * Copyright © 2007 Roan Kattouw "<Firstname>.<Lastname>@gmail.com"
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
 * Query module to get information about a list of wiki_users
 *
 * @ingroup API
 */
class ApiQuerywiki_users extends ApiQueryBase {

	private $tokenFunctions, $prop;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'us' );
	}

	/**
	 * Get an array mapping token names to their handler functions.
	 * The prototype for a token function is func($wiki_user)
	 * it should return a token or false (permission denied)
	 * @return Array tokenname => function
	 */
	protected function getTokenFunctions() {
		// Don't call the hooks twice
		if ( isset( $this->tokenFunctions ) ) {
			return $this->tokenFunctions;
		}

		// If we're in JSON callback mode, no tokens can be obtained
		if ( !is_null( $this->getMain()->getRequest()->getVal( 'callback' ) ) ) {
			return array();
		}

		$this->tokenFunctions = array(
			'wiki_userrights' => array( 'ApiQuerywiki_users', 'getwiki_userrightsToken' ),
		);
		wfRunHooks( 'APIQuerywiki_usersTokens', array( &$this->tokenFunctions ) );
		return $this->tokenFunctions;
	}

	/**
	 * @param $wiki_user wiki_user
	 * @return String
	 */
	public static function getwiki_userrightsToken( $wiki_user ) {
		global $wgwiki_user;
		// Since the permissions check for wiki_userrights is non-trivial,
		// don't bother with it here
		return $wgwiki_user->getEditToken( $wiki_user->getName() );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( !is_null( $params['prop'] ) ) {
			$this->prop = array_flip( $params['prop'] );
		} else {
			$this->prop = array();
		}

		$wiki_users = (array)$params['wiki_users'];
		$goodNames = $done = array();
		$result = $this->getResult();
		// Canonicalize wiki_user names
		foreach ( $wiki_users as $u ) {
			$n = wiki_user::getCanonicalName( $u );
			if ( $n === false || $n === '' ) {
				$vals = array( 'name' => $u, 'invalid' => '' );
				$fit = $result->addValue( array( 'query', $this->getModuleName() ),
						null, $vals );
				if ( !$fit ) {
					$this->setContinueEnumParameter( 'wiki_users',
							implode( '|', array_diff( $wiki_users, $done ) ) );
					$goodNames = array();
					break;
				}
				$done[] = $u;
			} else {
				$goodNames[] = $n;
			}
		}

		$result = $this->getResult();

		if ( count( $goodNames ) ) {
			$this->addTables( 'wiki_user' );
			$this->addFields( wiki_user::selectFields() );
			$this->addWhereFld( 'wiki_user_name', $goodNames );

			if ( isset( $this->prop['groups'] ) || isset( $this->prop['rights'] ) ) {
				$this->addTables( 'wiki_user_groups' );
				$this->addJoinConds( array( 'wiki_user_groups' => array( 'LEFT JOIN', 'ug_wiki_user=wiki_user_id' ) ) );
				$this->addFields( 'ug_group' );
			}

			$this->showHiddenwiki_usersAddBlockInfo( isset( $this->prop['blockinfo'] ) );

			$data = array();
			$res = $this->select( __METHOD__ );

			foreach ( $res as $row ) {
				$wiki_user = wiki_user::newFromRow( $row );
				$name = $wiki_user->getName();

				$data[$name]['wiki_userid'] = $wiki_user->getId();
				$data[$name]['name'] = $name;

				if ( isset( $this->prop['editcount'] ) ) {
					$data[$name]['editcount'] = intval( $wiki_user->getEditCount() );
				}

				if ( isset( $this->prop['registration'] ) ) {
					$data[$name]['registration'] = wfTimestampOrNull( TS_ISO_8601, $wiki_user->getRegistration() );
				}

				if ( isset( $this->prop['groups'] ) ) {
					if ( !isset( $data[$name]['groups'] ) ) {
						$data[$name]['groups'] = $wiki_user->getAutomaticGroups();
					}

					if ( !is_null( $row->ug_group ) ) {
						// This row contains only one group, others will be added from other rows
						$data[$name]['groups'][] = $row->ug_group;
					}
				}

				if ( isset( $this->prop['implicitgroups'] ) && !isset( $data[$name]['implicitgroups'] ) ) {
					$data[$name]['implicitgroups'] =  $wiki_user->getAutomaticGroups();
				}

				if ( isset( $this->prop['rights'] ) ) {
					if ( !isset( $data[$name]['rights'] ) ) {
						$data[$name]['rights'] = wiki_user::getGroupPermissions( $wiki_user->getAutomaticGroups() );
					}

					if ( !is_null( $row->ug_group ) ) {
						$data[$name]['rights'] = array_unique( array_merge( $data[$name]['rights'],
							wiki_user::getGroupPermissions( array( $row->ug_group ) ) ) );
					}
				}
				if ( $row->ipb_deleted ) {
					$data[$name]['hidden'] = '';
				}
				if ( isset( $this->prop['blockinfo'] ) && !is_null( $row->ipb_by_text ) ) {
					$data[$name]['blockid'] = $row->ipb_id;
					$data[$name]['blockedby'] = $row->ipb_by_text;
					$data[$name]['blockedbyid'] = $row->ipb_by;
					$data[$name]['blockreason'] = $row->ipb_reason;
					$data[$name]['blockexpiry'] = $row->ipb_expiry;
				}

				if ( isset( $this->prop['emailable'] ) && $wiki_user->canReceiveEmail() ) {
					$data[$name]['emailable'] = '';
				}

				if ( isset( $this->prop['gender'] ) ) {
					$gender = $wiki_user->getOption( 'gender' );
					if ( strval( $gender ) === '' ) {
						$gender = 'unknown';
					}
					$data[$name]['gender'] = $gender;
				}

				if ( !is_null( $params['token'] ) ) {
					$tokenFunctions = $this->getTokenFunctions();
					foreach ( $params['token'] as $t ) {
						$val = call_wiki_user_func( $tokenFunctions[$t], $wiki_user );
						if ( $val === false ) {
							$this->setWarning( "Action '$t' is not allowed for the current wiki_user" );
						} else {
							$data[$name][$t . 'token'] = $val;
						}
					}
				}
			}
		}

		// Second pass: add result data to $retval
		foreach ( $goodNames as $u ) {
			if ( !isset( $data[$u] ) ) {
				$data[$u] = array( 'name' => $u );
				$urPage = new wiki_userrightsPage;
				$iwwiki_user = $urPage->fetchwiki_user( $u );

				if ( $iwwiki_user instanceof wiki_userRightsProxy ) {
					$data[$u]['interwiki'] = '';

					if ( !is_null( $params['token'] ) ) {
						$tokenFunctions = $this->getTokenFunctions();

						foreach ( $params['token'] as $t ) {
							$val = call_wiki_user_func( $tokenFunctions[$t], $iwwiki_user );
							if ( $val === false ) {
								$this->setWarning( "Action '$t' is not allowed for the current wiki_user" );
							} else {
								$data[$u][$t . 'token'] = $val;
							}
						}
					}
				} else {
					$data[$u]['missing'] = '';
				}
			} else {
				if ( isset( $this->prop['groups'] ) && isset( $data[$u]['groups'] ) ) {
					$result->setIndexedTagName( $data[$u]['groups'], 'g' );
				}
				if ( isset( $this->prop['implicitgroups'] ) && isset( $data[$u]['implicitgroups'] ) ) {
					$result->setIndexedTagName( $data[$u]['implicitgroups'], 'g' );
				}
				if ( isset( $this->prop['rights'] ) && isset( $data[$u]['rights'] ) ) {
					$result->setIndexedTagName( $data[$u]['rights'], 'r' );
				}
			}

			$fit = $result->addValue( array( 'query', $this->getModuleName() ),
					null, $data[$u] );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'wiki_users',
						implode( '|', array_diff( $wiki_users, $done ) ) );
				break;
			}
			$done[] = $u;
		}
		return $result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'wiki_user' );
	}

	/**
	* Gets all the groups that a wiki_user is automatically a member of (implicit groups)
	*
	* @deprecated since 1.20; call wiki_user::getAutomaticGroups() directly.
	* @param $wiki_user wiki_user
	* @return array
	*/
	public static function getAutoGroups( $wiki_user ) {
		wfDeprecated( __METHOD__, '1.20' );

		return $wiki_user->getAutomaticGroups();
	}

	public function getCacheMode( $params ) {
		if ( isset( $params['token'] ) ) {
			return 'private';
		} else {
			return 'anon-public-wiki_user-private';
		}
	}

	public function getAllowedParams() {
		return array(
			'prop' => array(
				ApiBase::PARAM_DFLT => null,
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'blockinfo',
					'groups',
					'implicitgroups',
					'rights',
					'editcount',
					'registration',
					'emailable',
					'gender',
				)
			),
			'wiki_users' => array(
				ApiBase::PARAM_ISMULTI => true
			),
			'token' => array(
				ApiBase::PARAM_TYPE => array_keys( $this->getTokenFunctions() ),
				ApiBase::PARAM_ISMULTI => true
			),
		);
	}

	public function getParamDescription() {
		return array(
			'prop' => array(
				'What pieces of information to include',
				'  blockinfo      - Tags if the wiki_user is blocked, by whom, and for what reason',
				'  groups         - Lists all the groups the wiki_user(s) belongs to',
				'  implicitgroups - Lists all the groups a wiki_user is automatically a member of',
				'  rights         - Lists all the rights the wiki_user(s) has',
				'  editcount      - Adds the wiki_user\'s edit count',
				'  registration   - Adds the wiki_user\'s registration timestamp',
				'  emailable      - Tags if the wiki_user can and wants to receive e-mail through [[Special:Emailwiki_user]]',
				'  gender         - Tags the gender of the wiki_user. Returns "male", "female", or "unknown"',
			),
			'wiki_users' => 'A list of wiki_users to obtain the same information for',
			'token' => 'Which tokens to obtain for each wiki_user',
		);
	}

	public function getResultProperties() {
		$props = array(
			'' => array(
				'wiki_userid' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'name' => 'string',
				'invalid' => 'boolean',
				'hidden' => 'boolean',
				'interwiki' => 'boolean',
				'missing' => 'boolean'
			),
			'editcount' => array(
				'editcount' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'registration' => array(
				'registration' => array(
					ApiBase::PROP_TYPE => 'timestamp',
					ApiBase::PROP_NULLABLE => true
				)
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
				),
				'blockedexpiry' => array(
					ApiBase::PROP_TYPE => 'timestamp',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'emailable' => array(
				'emailable' => 'boolean'
			),
			'gender' => array(
				'gender' => array(
					ApiBase::PROP_TYPE => array(
						'male',
						'female',
						'unknown'
					),
					ApiBase::PROP_NULLABLE => true
				)
			)
		);

		self::addTokenProperties( $props, $this->getTokenFunctions() );

		return $props;
	}

	public function getDescription() {
		return 'Get information about a list of wiki_users';
	}

	public function getExamples() {
		return 'api.php?action=query&list=wiki_users&uswiki_users=brion|TimStarling&usprop=groups|editcount|gender';
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:wiki_users';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
