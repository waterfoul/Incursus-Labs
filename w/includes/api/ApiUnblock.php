<?php
/**
 *
 *
 * Created on Sep 7, 2007
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
 * API module that facilitates the unblocking of wiki_users. Requires API write mode
 * to be enabled.
 *
 * @ingroup API
 */
class ApiUnblock extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	/**
	 * Unblocks the specified wiki_user or provides the reason the unblock failed.
	 */
	public function execute() {
		$wiki_user = $this->getwiki_user();
		$params = $this->extractRequestParams();

		if ( $params['gettoken'] ) {
			$res['unblocktoken'] = $wiki_user->getEditToken();
			$this->getResult()->addValue( null, $this->getModuleName(), $res );
			return;
		}

		if ( is_null( $params['id'] ) && is_null( $params['wiki_user'] ) ) {
			$this->dieUsageMsg( 'unblock-notarget' );
		}
		if ( !is_null( $params['id'] ) && !is_null( $params['wiki_user'] ) ) {
			$this->dieUsageMsg( 'unblock-idandwiki_user' );
		}

		if ( !$wiki_user->isAllowed( 'block' ) ) {
			$this->dieUsageMsg( 'cantunblock' );
		}
		# bug 15810: blocked admins should have limited access here
		if ( $wiki_user->isBlocked() ) {
			$status = SpecialBlock::checkUnblockSelf( $params['wiki_user'], $wiki_user );
			if ( $status !== true ) {
				$this->dieUsageMsg( $status );
			}
		}

		$data = array(
			'Target' => is_null( $params['id'] ) ? $params['wiki_user'] : "#{$params['id']}",
			'Reason' => $params['reason']
		);
		$block = Block::newFromTarget( $data['Target'] );
		$retval = SpecialUnblock::processUnblock( $data, $this->getContext() );
		if ( $retval !== true ) {
			$this->dieUsageMsg( $retval[0] );
		}

		$res['id'] = $block->getId();
		$target = $block->getType() == Block::TYPE_AUTO ? '' : $block->getTarget();
		$res['wiki_user'] = $target instanceof wiki_user ? $target->getName() : $target;
		$res['wiki_userid'] = $target instanceof wiki_user ? $target->getId() : 0;
		$res['reason'] = $params['reason'];
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
			'id' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			'wiki_user' => null,
			'token' => null,
			'gettoken' => array(
				ApiBase::PARAM_DFLT => false,
				ApiBase::PARAM_DEPRECATED => true,
			),
			'reason' => '',
		);
	}

	public function getParamDescription() {
		$p = $this->getModulePrefix();
		return array(
			'id' => "ID of the block you want to unblock (obtained through list=blocks). Cannot be used together with {$p}wiki_user",
			'wiki_user' => "wiki_username, IP address or IP range you want to unblock. Cannot be used together with {$p}id",
			'token' => "An unblock token previously obtained through prop=info",
			'gettoken' => 'If set, an unblock token will be returned, and no other action will be taken',
			'reason' => 'Reason for unblock',
		);
	}

	public function getResultProperties() {
		return array(
			'' => array(
				'unblocktoken' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'id' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'wiki_user' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				),
				'wiki_userid' => array(
					ApiBase::PROP_TYPE => 'integer',
					ApiBase::PROP_NULLABLE => true
				),
				'reason' => array(
					ApiBase::PROP_TYPE => 'string',
					ApiBase::PROP_NULLABLE => true
				)
			)
		);
	}

	public function getDescription() {
		return 'Unblock a wiki_user';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'unblock-notarget' ),
			array( 'unblock-idandwiki_user' ),
			array( 'cantunblock' ),
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
			'api.php?action=unblock&id=105',
			'api.php?action=unblock&wiki_user=Bob&reason=Sorry%20Bob'
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/API:Block';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}
}
