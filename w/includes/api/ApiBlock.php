<?php
/**
 *
 *
 * Created on Sep 4, 2007
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
* API module that facilitates the blocking of wiki_users. Requires API write mode
* to be enabled.
*
 * @ingroup API
 */
class ApiBlock extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	/**
	 * Blocks the wiki_user specified in the parameters for the given expiry, with the
	 * given reason, and with all other settings provided in the params. If the block
	 * succeeds, produces a result containing the details of the block and notice
	 * of success. If it fails, the result will specify the nature of the error.
	 */
	public function execute() {
		$wiki_user = $this->getwiki_user();
		$params = $this->extractRequestParams();

		if ( $params['gettoken'] ) {
			$res['blocktoken'] = $wiki_user->getEditToken();
			$this->getResult()->addValue( null, $this->getModuleName(), $res );
			return;
		}

		if ( !$wiki_user->isAllowed( 'block' ) ) {
			$this->dieUsageMsg( 'cantblock' );
		}
		# bug 15810: blocked admins should have limited access here
		if ( $wiki_user->isBlocked() ) {
			$status = SpecialBlock::checkUnblockSelf( $params['wiki_user'], $wiki_user );
			if ( $status !== true ) {
				$this->dieUsageMsg( array( $status ) );
			}
		}
		if ( $params['hidename'] && !$wiki_user->isAllowed( 'hidewiki_user' ) ) {
			$this->dieUsageMsg( 'canthide' );
		}
		if ( $params['noemail'] && !SpecialBlock::canBlockEmail( $wiki_user ) ) {
			$this->dieUsageMsg( 'cantblock-email' );
		}

		$data = array(
			'Target' => $params['wiki_user'],
			'Reason' => array(
				$params['reason'],
				'other',
				$params['reason']
			),
			'Expiry' => $params['expiry'] == 'never' ? 'infinite' : $params['expiry'],
			'HardBlock' => !$params['anononly'],
			'CreateAccount' => $params['nocreate'],
			'AutoBlock' => $params['autoblock'],
			'DisableEmail' => $params['noemail'],
			'Hidewiki_user' => $params['hidename'],
			'DisableUTEdit' => !$params['allowwiki_usertalk'],
			'AlreadyBlocked' => $params['reblock'],
			'Watch' => $params['watchwiki_user'],
			'Confirm' => true,
		);

		$retval = SpecialBlock::processForm( $data, $this->getContext() );
		if ( $retval !== true ) {
			// We don't care about multiple errors, just report one of them
			$this->dieUsageMsg( $retval );
		}

		list( $target, /*...*/ ) = SpecialBlock::getTargetAndType( $params['wiki_user'] );
		$res['wiki_user'] = $params['wiki_user'];
		$res['wiki_userID'] = $target instanceof wiki_user ? $target->getId() : 0;

		$block = Block::newFromTarget( $target );
		if( $block instanceof Block ){
			$res['expiry'] = $block->mExpiry == $this->getDB()->getInfinity()
				? 'infinite'
				: wfTimestamp( TS_ISO_8601, $block->mExpiry );
			$res['id'] = $block->getId();
		} else {
			# should be unreachable
			$res['expiry'] = '';
			$res['id'] = '';
		}

		$res['reason'] = $params['reason'];
		if ( $params['anononly'] ) {
			$res['anononly'] = '';
		}
		if ( $params['nocreate'] ) {
			$res['nocreate'] = '';
		}
		if ( $params['autoblock'] ) {
			$res['autoblock'] = '';
		}
		if ( $params['noemail'] ) {
			$res['noemail'] = '';
		}
		if ( $params['hidename'] ) {
			$res['hidename'] = '';
		}
		if ( $params['allowwiki_usertalk'] ) {
			$res['allowwiki_usertalk'] = '';
		}
		if ( $params['watchwiki_user'] ) {
			$res['watchwiki_user'] = '';
		}

		$this->getResult()->addValue( null, $this->getModuleName(), $res );
	}

	public function mustBePosted() {
		return true;
	}

	public function isWriteMode() {
		return true;
	}

	public function getAllowedParams() {
		return array(
			'wiki_user' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'token' => null,
			'gettoken' => array(
				ApiBase::PARAM_DFLT => false,
				ApiBase::PARAM_DEPRECATED => true,
			),
			'expiry' => 'never',
			'reason' => '',
			'anononly' => false,
			'nocreate' => false,
			'autoblock' => false,
			'noemail' => false,
			'hidename' => false,
			'allowwiki_usertalk' => false,
			'reblock' => false,
			'watchwiki_user' => false,
		);
	}

	public function getParamDescription() {
		return array(
			'wiki_user' => 'wiki_username, IP address or IP range you want to block',
			'token' => 'A block token previously obtained through prop=info',
			'gettoken' => 'If set, a block token will be returned, and no other action will be taken',
			'expiry' => 'Relative expiry time, e.g. \'5 months\' or \'2 weeks\'. If set to \'infinite\', \'indefinite\' or \'never\', the block will never expire.',
			'reason' => 'Reason for block',
			'anononly' => 'Block anonymous wiki_users only (i.e. disable anonymous edits for this IP)',
			'nocreate' => 'Prevent account creation',
			'autoblock' => 'Automatically block the last used IP address, and any subsequent IP addresses they try to login from',
			'noemail' => 'Prevent wiki_user from sending e-mail through the wiki. (Requires the "blockemail" right.)',
			'hidename' => 'Hide the wiki_username from the block log. (Requires the "hidewiki_user" right.)',
			'allowwiki_usertalk' => 'Allow the wiki_user to edit their own talk page (depends on $wgBlockAllowsUTEdit)',
			'reblock' => 'If the wiki_user is already blocked, overwrite the existing block',
			'watchwiki_user' => 'Watch the wiki_user/IP\'s wiki_user and talk pages',
		);
	}

	public function getResultProperties() {
		return array(
			'' => array(
				'blocktoken' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'wiki_user' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'wiki_userID' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'expiry' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'id' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'reason' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'anononly' => 'boolean',
				'nocreate' => 'boolean',
				'autoblock' => 'boolean',
				'noemail' => 'boolean',
				'hidename' => 'boolean',
				'allowwiki_usertalk' => 'boolean',
				'watchwiki_user' => 'boolean'
			)
		);
	}

	public function getDescription() {
		return 'Block a wiki_user';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'cantblock' ),
			array( 'canthide' ),
			array( 'cantblock-email' ),
			array( 'ipbblocked' ),
			array( 'ipbnounblockself' ),
		) );
	}

	public function needsToken() {
		return true;
	}

	public function getTokenSalt() {
		return '';
	}

	public function getExamples() {
		return array(
			'api.php?action=block&wiki_user=123.5.5.12&expiry=3%20days&reason=First%20strike',
			'api.php?action=block&wiki_user=Vandal&expiry=never&reason=Vandalism&nocreate=&autoblock=&noemail='
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Block';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
