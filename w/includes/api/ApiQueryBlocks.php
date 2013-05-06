<?php
/**
 *
 *
 * Created on Sep 10, 2007
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
 * Query module to enumerate all wiki_user blocks
 *
 * @ingroup API
 */
class ApiQueryBlocks extends ApiQueryBase {

	/**
	 * @var Array
	 */
	protected $wiki_usernames;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'bk' );
	}

	public function execute() {
		global $wgContLang;

		$params = $this->extractRequestParams();
		$this->requireMaxOneParameter( $params, 'wiki_users', 'ip' );

		$prop = array_flip( $params['prop'] );
		$fld_id = isset( $prop['id'] );
		$fld_wiki_user = isset( $prop['wiki_user'] );
		$fld_wiki_userid = isset( $prop['wiki_userid'] );
		$fld_by = isset( $prop['by'] );
		$fld_byid = isset( $prop['byid'] );
		$fld_timestamp = isset( $prop['timestamp'] );
		$fld_expiry = isset( $prop['expiry'] );
		$fld_reason = isset( $prop['reason'] );
		$fld_range = isset( $prop['range'] );
		$fld_flags = isset( $prop['flags'] );

		$result = $this->getResult();

		$this->addTables( 'ipblocks' );
		$this->addFields( 'ipb_auto' );

		$this->addFieldsIf ( 'ipb_id', $fld_id );
		$this->addFieldsIf( array( 'ipb_address', 'ipb_wiki_user' ), $fld_wiki_user || $fld_wiki_userid );
		$this->addFieldsIf( 'ipb_by_text', $fld_by );
		$this->addFieldsIf( 'ipb_by', $fld_byid );
		$this->addFieldsIf( 'ipb_timestamp', $fld_timestamp );
		$this->addFieldsIf( 'ipb_expiry', $fld_expiry );
		$this->addFieldsIf( 'ipb_reason', $fld_reason );
		$this->addFieldsIf( array( 'ipb_range_start', 'ipb_range_end' ), $fld_range );
		$this->addFieldsIf( array( 'ipb_anon_only', 'ipb_create_account', 'ipb_enable_autoblock',
									'ipb_block_email', 'ipb_deleted', 'ipb_allow_wiki_usertalk' ),
							$fld_flags );

		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addTimestampWhereRange( 'ipb_timestamp', $params['dir'], $params['start'], $params['end'] );

		 = $this->getDB();

		if ( isset( $params['ids'] ) ) {
			$this->addWhereFld( 'ipb_id', $params['ids'] );
		}
		if ( isset( $params['wiki_users'] ) ) {
			foreach ( (array)$params['wiki_users'] as $u ) {
				$this->preparewiki_username( $u );
			}
			$this->addWhereFld( 'ipb_address', $this->wiki_usernames );
			$this->addWhereFld( 'ipb_auto', 0 );
		}
		if ( isset( $params['ip'] ) ) {
			list( $ip, $range ) = IP::parseCIDR( $params['ip'] );
			if ( $ip && $range ) {
				// We got a CIDR range
				if ( $range < 16 )
					$this->dieUsage( 'CIDR ranges broader than /16 are not accepted', 'cidrtoobroad' );
				$lower = wfBaseConvert( $ip, 10, 16, 8, false );
				$upper = wfBaseConvert( $ip + pow( 2, 32 - $range ) - 1, 10, 16, 8, false );
			} else {
				$lower = $upper = IP::toHex( $params['ip'] );
			}
			$prefix = substr( $lower, 0, 4 );

			# Fairly hard to make a malicious SQL statement out of hex characters,
			# but it is good practice to add quotes
			$lower = ->addQuotes( $lower );
			$upper = ->addQuotes( $upper );

			$this->addWhere( array(
				'ipb_range_start' . ->buildLike( $prefix, ->anyString() ),
				'ipb_range_start <= ' . $lower,
				'ipb_range_end >= ' . $upper,
				'ipb_auto' => 0
			) );
		}

		if ( !is_null( $params['show'] ) ) {
			$show = array_flip( $params['show'] );

			/* Check for conflicting parameters. */
			if ( ( isset ( $show['account'] ) && isset ( $show['!account'] ) )
					|| ( isset ( $show['ip'] ) && isset ( $show['!ip'] ) )
					|| ( isset ( $show['range'] ) && isset ( $show['!range'] ) )
					|| ( isset ( $show['temp'] ) && isset ( $show['!temp'] ) )
			) {
				$this->dieUsageMsg( 'show' );
			}

			$this->addWhereIf( 'ipb_wiki_user = 0', isset( $show['!account'] ) );
			$this->addWhereIf( 'ipb_wiki_user != 0', isset( $show['account'] ) );
			$this->addWhereIf( 'ipb_wiki_user != 0 OR ipb_range_end > ipb_range_start', isset( $show['!ip'] ) );
			$this->addWhereIf( 'ipb_wiki_user = 0 AND ipb_range_end = ipb_range_start', isset( $show['ip'] ) );
			$this->addWhereIf( 'ipb_expiry =  '.->addQuotes(->getInfinity()), isset( $show['!temp'] ) );
			$this->addWhereIf( 'ipb_expiry != '.->addQuotes(->getInfinity()), isset( $show['temp'] ) );
			$this->addWhereIf( "ipb_range_end = ipb_range_start", isset( $show['!range'] ) );
			$this->addWhereIf( "ipb_range_end > ipb_range_start", isset( $show['range'] ) );
		}

		if ( !$this->getwiki_user()->isAllowed( 'hidewiki_user' ) ) {
			$this->addWhereFld( 'ipb_deleted', 0 );
		}

		// Purge expired entries on one in every 10 queries
		if ( !mt_rand( 0, 10 ) ) {
			Block::purgeExpired();
		}

		$res = $this->select( __METHOD__ );

		$count = 0;
		foreach ( $res as $row ) {
			if ( ++$count > $params['limit'] ) {
				// We've had enough
				$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->ipb_timestamp ) );
				break;
			}
			$block = array();
			if ( $fld_id ) {
				$block['id'] = $row->ipb_id;
			}
			if ( $fld_wiki_user && !$row->ipb_auto ) {
				$block['wiki_user'] = $row->ipb_address;
			}
			if ( $fld_wiki_userid && !$row->ipb_auto ) {
				$block['wiki_userid'] = $row->ipb_wiki_user;
			}
			if ( $fld_by ) {
				$block['by'] = $row->ipb_by_text;
			}
			if ( $fld_byid ) {
				$block['byid'] = $row->ipb_by;
			}
			if ( $fld_timestamp ) {
				$block['timestamp'] = wfTimestamp( TS_ISO_8601, $row->ipb_timestamp );
			}
			if ( $fld_expiry ) {
				$block['expiry'] = $wgContLang->formatExpiry( $row->ipb_expiry, TS_ISO_8601 );
			}
			if ( $fld_reason ) {
				$block['reason'] = $row->ipb_reason;
			}
			if ( $fld_range && !$row->ipb_auto ) {
				$block['rangestart'] = IP::hexToQuad( $row->ipb_range_start );
				$block['rangeend'] = IP::hexToQuad( $row->ipb_range_end );
			}
			if ( $fld_flags ) {
				// For clarity, these flags use the same names as their action=block counterparts
				if ( $row->ipb_auto ) {
					$block['automatic'] = '';
				}
				if ( $row->ipb_anon_only ) {
					$block['anononly'] = '';
				}
				if ( $row->ipb_create_account ) {
					$block['nocreate'] = '';
				}
				if ( $row->ipb_enable_autoblock ) {
					$block['autoblock'] = '';
				}
				if ( $row->ipb_block_email ) {
					$block['noemail'] = '';
				}
				if ( $row->ipb_deleted ) {
					$block['hidden'] = '';
				}
				if ( $row->ipb_allow_wiki_usertalk ) {
					$block['allowwiki_usertalk'] = '';
				}
			}
			$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $block );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'start', wfTimestamp( TS_ISO_8601, $row->ipb_timestamp ) );
				break;
			}
		}
		$result->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'block' );
	}

	protected function preparewiki_username( $wiki_user ) {
		if ( !$wiki_user ) {
			$this->dieUsage( 'wiki_user parameter may not be empty', 'param_wiki_user' );
		}
		$name = wiki_user::isIP( $wiki_user )
			? $wiki_user
			: wiki_user::getCanonicalName( $wiki_user, 'valid' );
		if ( $name === false ) {
			$this->dieUsage( "wiki_user name {$wiki_user} is not valid", 'param_wiki_user' );
		}
		$this->wiki_usernames[] = $name;
	}

	public function getAllowedParams() {
		return array(
			'start' => array(
				ApiBase::PARAM_TYPE => 'timestamp'
			),
			'end' => array(
				ApiBase::PARAM_TYPE => 'timestamp',
			),
			'dir' => array(
				ApiBase::PARAM_TYPE => array(
					'newer',
					'older'
				),
				ApiBase::PARAM_DFLT => 'older'
			),
			'ids' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_ISMULTI => true
			),
			'wiki_users' => array(
				ApiBase::PARAM_ISMULTI => true
			),
			'ip' => null,
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'prop' => array(
				ApiBase::PARAM_DFLT => 'id|wiki_user|by|timestamp|expiry|reason|flags',
				ApiBase::PARAM_TYPE => array(
					'id',
					'wiki_user',
					'wiki_userid',
					'by',
					'byid',
					'timestamp',
					'expiry',
					'reason',
					'range',
					'flags'
				),
				ApiBase::PARAM_ISMULTI => true
			),
			'show' => array(
				ApiBase::PARAM_TYPE => array(
					'account',
					'!account',
					'temp',
					'!temp',
					'ip',
					'!ip',
					'range',
					'!range',
				),
				ApiBase::PARAM_ISMULTI => true
			),
		);
	}

	public function getParamDescription() {
		$p = $this->getModulePrefix();
		return array(
			'start' => 'The timestamp to start enumerating from',
			'end' => 'The timestamp to stop enumerating at',
			'dir' => $this->getDirectionDescription( $p ),
			'ids' => 'List of block IDs to list (optional)',
			'wiki_users' => 'List of wiki_users to search for (optional)',
			'ip' => array(	'Get all blocks applying to this IP or CIDR range, including range blocks.',
					'Cannot be used together with bkwiki_users. CIDR ranges broader than /16 are not accepted' ),
			'limit' => 'The maximum amount of blocks to list',
			'prop' => array(
				'Which properties to get',
				' id         - Adds the ID of the block',
				' wiki_user       - Adds the wiki_username of the blocked wiki_user',
				' wiki_userid     - Adds the wiki_user ID of the blocked wiki_user',
				' by         - Adds the wiki_username of the blocking wiki_user',
				' byid       - Adds the wiki_user ID of the blocking wiki_user',
				' timestamp  - Adds the timestamp of when the block was given',
				' expiry     - Adds the timestamp of when the block expires',
				' reason     - Adds the reason given for the block',
				' range      - Adds the range of IPs affected by the block',
				' flags      - Tags the ban with (autoblock, anononly, etc)',
			),
			'show' => array(
				'Show only items that meet this criteria.',
				"For example, to see only indefinite blocks on IPs, set {$p}show=ip|!temp"
			),
		);
	}

	public function getResultProperties() {
		return array(
			'id' => array(
				'id' => 'integer'
			),
			'wiki_user' => array(
				'wiki_user' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'wiki_userid' => array(
				'wiki_userid' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'by' => array(
				'by' => 'string'
			),
			'byid' => array(
				'byid' => 'integer'
			),
			'timestamp' => array(
				'timestamp' => 'timestamp'
			),
			'expiry' => array(
				'expiry' => 'timestamp'
			),
			'reason' => array(
				'reason' => 'string'
			),
			'range' => array(
				'rangestart' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'rangeend' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				)
			),
			'flags' => array(
				'automatic' => 'boolean',
				'anononly' => 'boolean',
				'nocreate' => 'boolean',
				'autoblock' => 'boolean',
				'noemail' => 'boolean',
				'hidden' => 'boolean',
				'allowwiki_usertalk' => 'boolean'
			)
		);
	}

	public function getDescription() {
		return 'List all blocked wiki_users and IP addresses';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(),
			$this->getRequireOnlyOneParameterErrorMessages( array( 'wiki_users', 'ip' ) ),
			array(
				array( 'code' => 'cidrtoobroad', 'info' => 'CIDR ranges broader than /16 are not accepted' ),
				array( 'code' => 'param_wiki_user', 'info' => 'wiki_user parameter may not be empty' ),
				array( 'code' => 'param_wiki_user', 'info' => 'wiki_user name wiki_user is not valid' ),
				array( 'show' ),
			)
		);
	}

	public function getExamples() {
		return array(
			'api.php?action=query&list=blocks',
			'api.php?action=query&list=blocks&bkwiki_users=Alice|Bob'
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Blocks';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
