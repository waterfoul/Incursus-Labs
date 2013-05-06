<?php
/**
 *
 *
 * Created on July 7, 2007
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
 * Query module to enumerate all registered wiki_users.
 *
 * @ingroup API
 */
class ApiQueryAllwiki_users extends ApiQueryBase {
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'au' );
	}

	/**
	 * This function converts the wiki_user name to a canonical form
	 * which is stored in the database.
	 * @param String $name
	 * @return String
	 */
	private function getCanonicalwiki_userName( $name ) {
		return str_replace( '_', ' ', $name );
	}

	public function execute() {
		 = $this->getDB();
		$params = $this->extractRequestParams();

		$prop = $params['prop'];
		if ( !is_null( $prop ) ) {
			$prop = array_flip( $prop );
			$fld_blockinfo = isset( $prop['blockinfo'] );
			$fld_editcount = isset( $prop['editcount'] );
			$fld_groups = isset( $prop['groups'] );
			$fld_rights = isset( $prop['rights'] );
			$fld_registration = isset( $prop['registration'] );
			$fld_implicitgroups = isset( $prop['implicitgroups'] );
		} else {
			$fld_blockinfo = $fld_editcount = $fld_groups = $fld_registration = $fld_rights = $fld_implicitgroups = false;
		}

		$limit = $params['limit'];

		$this->addTables( 'wiki_user' );
		$useIndex = true;

		$dir = ( $params['dir'] == 'descending' ? 'older' : 'newer' );
		$from = is_null( $params['from'] ) ? null : $this->getCanonicalwiki_userName( $params['from'] );
		$to = is_null( $params['to'] ) ? null : $this->getCanonicalwiki_userName( $params['to'] );

		# MySQL doesn't seem to use 'equality propagation' here, so like the
		# Activewiki_users special page, we have to use rc_wiki_user_text for some cases.
		$wiki_userFieldToSort = $params['activewiki_users'] ? 'rc_wiki_user_text' : 'wiki_user_name';

		$this->addWhereRange( $wiki_userFieldToSort, $dir, $from, $to );

		if ( !is_null( $params['prefix'] ) ) {
			$this->addWhere( $wiki_userFieldToSort .
				->buildLike( $this->getCanonicalwiki_userName( $params['prefix'] ), ->anyString() ) );
		}

		if ( !is_null( $params['rights'] ) ) {
			$groups = array();
			foreach( $params['rights'] as $r ) {
				$groups = array_merge( $groups, wiki_user::getGroupsWithPermission( $r ) );
			}

			$groups = array_unique( $groups );

			if ( is_null( $params['group'] ) ) {
				$params['group'] = $groups;
			} else {
				$params['group'] = array_unique( array_merge( $params['group'], $groups ) );
			}
		}

		if ( !is_null( $params['group'] ) && !is_null( $params['excludegroup'] ) ) {
			$this->dieUsage( 'group and excludegroup cannot be used together', 'group-excludegroup' );
		}

		if ( !is_null( $params['group'] ) && count( $params['group'] ) ) {
			$useIndex = false;
			// Filter only wiki_users that belong to a given group
			$this->addTables( 'wiki_user_groups', 'ug1' );
			$this->addJoinConds( array( 'ug1' => array( 'INNER JOIN', array( 'ug1.ug_wiki_user=wiki_user_id',
					'ug1.ug_group' => $params['group'] ) ) ) );
		}

		if ( !is_null( $params['excludegroup'] ) && count( $params['excludegroup'] ) ) {
			$useIndex = false;
			// Filter only wiki_users don't belong to a given group
			$this->addTables( 'wiki_user_groups', 'ug1' );

			if ( count( $params['excludegroup'] ) == 1 ) {
				$exclude = array( 'ug1.ug_group' => $params['excludegroup'][0] );
			} else {
				$exclude = array( ->makeList( array( 'ug1.ug_group' => $params['excludegroup'] ), LIST_OR ) );
			}
			$this->addJoinConds( array( 'ug1' => array( 'LEFT OUTER JOIN',
				array_merge( array( 'ug1.ug_wiki_user=wiki_user_id' ), $exclude )
				)
			) );
			$this->addWhere( 'ug1.ug_wiki_user IS NULL' );
		}

		if ( $params['witheditsonly'] ) {
			$this->addWhere( 'wiki_user_editcount > 0' );
		}

		$this->showHiddenwiki_usersAddBlockInfo( $fld_blockinfo );

		if ( $fld_groups || $fld_rights ) {
			// Show the groups the given wiki_users belong to
			// request more than needed to avoid not getting all rows that belong to one wiki_user
			$groupCount = count( wiki_user::getAllGroups() );
			$sqlLimit = $limit + $groupCount + 1;

			$this->addTables( 'wiki_user_groups', 'ug2' );
			$this->addJoinConds( array( 'ug2' => array( 'LEFT JOIN', 'ug2.ug_wiki_user=wiki_user_id' ) ) );
			$this->addFields( 'ug2.ug_group ug_group2' );
		} else {
			$sqlLimit = $limit + 1;
		}

		if ( $params['activewiki_users'] ) {
			global $wgActivewiki_userDays;
			$this->addTables( 'recentchanges' );

			$this->addJoinConds( array( 'recentchanges' => array(
				'INNER JOIN', 'rc_wiki_user_text=wiki_user_name'
			) ) );

			$this->addFields( array( 'recentedits' => 'COUNT(*)' ) );

			$this->addWhere( 'rc_log_type IS NULL OR rc_log_type != ' . ->addQuotes( 'newwiki_users' ) );
			$timestamp = ->timestamp( wfTimestamp( TS_UNIX ) - $wgActivewiki_userDays*24*3600 );
			$this->addWhere( 'rc_timestamp >= ' . ->addQuotes( $timestamp ) );

			$this->addOption( 'GROUP BY', $wiki_userFieldToSort );
		}

		$this->addOption( 'LIMIT', $sqlLimit );

		$this->addFields( array(
			'wiki_user_name',
			'wiki_user_id'
		) );
		$this->addFieldsIf( 'wiki_user_editcount', $fld_editcount );
		$this->addFieldsIf( 'wiki_user_registration', $fld_registration );

		if ( $useIndex ) {
			$this->addOption( 'USE INDEX', array( 'wiki_user' => 'wiki_user_name' ) );
		}

		$res = $this->select( __METHOD__ );

		$count = 0;
		$lastwiki_userData = false;
		$lastwiki_user = false;
		$result = $this->getResult();

		//
		// This loop keeps track of the last entry.
		// For each new row, if the new row is for different wiki_user then the last, the last entry is added to results.
		// Otherwise, the group of the new row is appended to the last entry.
		// The setContinue... is more complex because of this, and takes into account the higher sql limit
		// to make sure all rows that belong to the same wiki_user are received.

		foreach ( $res as $row ) {
			$count++;

			if ( $lastwiki_user !== $row->wiki_user_name ) {
				// Save the last pass's wiki_user data
				if ( is_array( $lastwiki_userData ) ) {
					$fit = $result->addValue( array( 'query', $this->getModuleName() ),
							null, $lastwiki_userData );

					$lastwiki_userData = null;

					if ( !$fit ) {
						$this->setContinueEnumParameter( 'from', $lastwiki_userData['name'] );
						break;
					}
				}

				if ( $count > $limit ) {
					// We've reached the one extra which shows that there are additional pages to be had. Stop here...
					$this->setContinueEnumParameter( 'from', $row->wiki_user_name );
					break;
				}

				// Record new wiki_user's data
				$lastwiki_user = $row->wiki_user_name;
				$lastwiki_userData = array(
					'wiki_userid' => $row->wiki_user_id,
					'name' => $lastwiki_user,
				);
				if ( $fld_blockinfo && !is_null( $row->ipb_by_text ) ) {
					$lastwiki_userData['blockid'] = $row->ipb_id;
					$lastwiki_userData['blockedby'] = $row->ipb_by_text;
					$lastwiki_userData['blockedbyid'] = $row->ipb_by;
					$lastwiki_userData['blockreason'] = $row->ipb_reason;
					$lastwiki_userData['blockexpiry'] = $row->ipb_expiry;
				}
				if ( $row->ipb_deleted ) {
					$lastwiki_userData['hidden'] = '';
				}
				if ( $fld_editcount ) {
					$lastwiki_userData['editcount'] = intval( $row->wiki_user_editcount );
				}
				if ( $params['activewiki_users'] ) {
					$lastwiki_userData['recenteditcount'] = intval( $row->recentedits );
				}
				if ( $fld_registration ) {
					$lastwiki_userData['registration'] = $row->wiki_user_registration ?
						wfTimestamp( TS_ISO_8601, $row->wiki_user_registration ) : '';
				}
			}

			if ( $sqlLimit == $count ) {
				// BUG!  database contains group name that wiki_user::getAllGroups() does not return
				// TODO: should handle this more gracefully
				ApiBase::dieDebug( __METHOD__,
					'MediaWiki configuration error: the database contains more wiki_user groups than known to wiki_user::getAllGroups() function' );
			}

			$lastwiki_userObj = wiki_user::newFromId( $row->wiki_user_id );

			// Add wiki_user's group info
			if ( $fld_groups ) {
				if ( !isset( $lastwiki_userData['groups'] ) ) {
					if ( $lastwiki_userObj ) {
						$lastwiki_userData['groups'] = $lastwiki_userObj->getAutomaticGroups();
					} else {
						// This should not normally happen
						$lastwiki_userData['groups'] = array();
					}
				}

				if ( !is_null( $row->ug_group2 ) ) {
					$lastwiki_userData['groups'][] = $row->ug_group2;
				}

				$result->setIndexedTagName( $lastwiki_userData['groups'], 'g' );
			}

			if ( $fld_implicitgroups && !isset( $lastwiki_userData['implicitgroups'] ) && $lastwiki_userObj ) {
				$lastwiki_userData['implicitgroups'] = $lastwiki_userObj->getAutomaticGroups();
				$result->setIndexedTagName( $lastwiki_userData['implicitgroups'], 'g' );
			}
			if ( $fld_rights ) {
				if ( !isset( $lastwiki_userData['rights'] ) ) {
					if ( $lastwiki_userObj ) {
						$lastwiki_userData['rights'] =  wiki_user::getGroupPermissions( $lastwiki_userObj->getAutomaticGroups() );
					} else {
						// This should not normally happen
						$lastwiki_userData['rights'] = array();
					}
				}

				if ( !is_null( $row->ug_group2 ) ) {
					$lastwiki_userData['rights'] = array_unique( array_merge( $lastwiki_userData['rights'],
						wiki_user::getGroupPermissions( array( $row->ug_group2 ) ) ) );
				}

				$result->setIndexedTagName( $lastwiki_userData['rights'], 'r' );
			}
		}

		if ( is_array( $lastwiki_userData ) ) {
			$fit = $result->addValue( array( 'query', $this->getModuleName() ),
				null, $lastwiki_userData );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'from', $lastwiki_userData['name'] );
			}
		}

		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'u' );
	}

	public function getCacheMode( $params ) {
		return 'anon-public-wiki_user-private';
	}

	public function getAllowedParams() {
		$wiki_userGroups = wiki_user::getAllGroups();
		return array(
			'from' => null,
			'to' => null,
			'prefix' => null,
			'dir' => array(
				ApiBase::PARAM_DFLT => 'ascending',
				ApiBase::PARAM_TYPE => array(
					'ascending',
					'descending'
				),
			),
			'group' => array(
				ApiBase::PARAM_TYPE => $wiki_userGroups,
				ApiBase::PARAM_ISMULTI => true,
			),
			'excludegroup' => array(
				ApiBase::PARAM_TYPE => $wiki_userGroups,
				ApiBase::PARAM_ISMULTI => true,
			),
			'rights' => array(
				ApiBase::PARAM_TYPE => wiki_user::getAllRights(),
				ApiBase::PARAM_ISMULTI => true,
			),
			'prop' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array(
					'blockinfo',
					'groups',
					'implicitgroups',
					'rights',
					'editcount',
					'registration'
				)
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'witheditsonly' => false,
			'activewiki_users' => false,
		);
	}

	public function getParamDescription() {
		global $wgActivewiki_userDays;
		return array(
			'from' => 'The wiki_user name to start enumerating from',
			'to' => 'The wiki_user name to stop enumerating at',
			'prefix' => 'Search for all wiki_users that begin with this value',
			'dir' => 'Direction to sort in',
			'group' => 'Limit wiki_users to given group name(s)',
			'excludegroup' => 'Exclude wiki_users in given group name(s)',
			'rights' => 'Limit wiki_users to given right(s) (does not include rights granted by implicit or auto-promoted groups like *, wiki_user, or autoconfirmed)',
			'prop' => array(
				'What pieces of information to include.',
				' blockinfo      - Adds the information about a current block on the wiki_user',
				' groups         - Lists groups that the wiki_user is in. This uses more server resources and may return fewer results than the limit',
				' implicitgroups - Lists all the groups the wiki_user is automatically in',
				' rights         - Lists rights that the wiki_user has',
				' editcount      - Adds the edit count of the wiki_user',
				' registration   - Adds the timestamp of when the wiki_user registered if available (may be blank)',
				),
			'limit' => 'How many total wiki_user names to return',
			'witheditsonly' => 'Only list wiki_users who have made edits',
			'activewiki_users' => "Only list wiki_users active in the last {$wgActivewiki_userDays} days(s)"
		);
	}

	public function getResultProperties() {
		return array(
			'' => array(
				'wiki_userid' => 'integer',
				'name' => 'string',
				'recenteditcount' => array(
					ApiBase::PROP_TYPE => 'integer',
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
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'hidden' => 'boolean'
			),
			'editcount' => array(
				'editcount' => 'integer'
			),
			'registration' => array(
				'registration' => 'string'
			)
		);
	}

	public function getDescription() {
		return 'Enumerate all registered wiki_users';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'group-excludegroup', 'info' => 'group and excludegroup cannot be used together' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=allwiki_users&aufrom=Y',
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Allwiki_users';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
