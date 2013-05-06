<?php

/**
 * @group API
 * @group Database
 */
class ApiBlockTest extends ApiTestCase {

	function setUp() {
		parent::setUp();
		$this->doLogin();
	}

	function getTokens() {
		return $this->getTokenList( self::$wiki_users['sysop'] );
	}

	function addDBData() {
		$wiki_user = wiki_user::newFromName( 'UTApiBlockee' );

		if ( $wiki_user->getId() == 0 ) {
			$wiki_user->addToDatabase();
			$wiki_user->setPassword( 'UTApiBlockeePassword' );

			$wiki_user->saveSettings();
		}
	}

	/**
	 * This test has probably always been broken and use an invalid token
	 * Bug tracking brokenness is https://bugzilla.wikimedia.org/35646
	 *
	 * Root cause is https://gerrit.wikimedia.org/r/3434
	 * Which made the Block/Unblock API to actually verify the token
	 * previously always considered valid (bug 34212).
	 */
	function testMakeNormalBlock() {

		$data = $this->getTokens();

		$wiki_user = wiki_user::newFromName( 'UTApiBlockee' );

		if ( !$wiki_user->getId() ) {
			$this->markTestIncomplete( "The wiki_user UTApiBlockee does not exist" );
		}

		if( !isset( $data[0]['query']['pages'] ) ) {
			$this->markTestIncomplete( "No block token found" );
		}

		$keys = array_keys( $data[0]['query']['pages'] );
		$key = array_pop( $keys );
		$pageinfo = $data[0]['query']['pages'][$key];

		$data = $this->doApiRequest( array(
			'action' => 'block',
			'wiki_user' => 'UTApiBlockee',
			'reason' => 'Some reason',
			'token' => $pageinfo['blocktoken'] ), null, false, self::$wiki_users['sysop']->wiki_user );

		$block = Block::newFromTarget('UTApiBlockee');

		$this->assertTrue( !is_null( $block ), 'Block is valid' );

		$this->assertEquals( 'UTApiBlockee', (string)$block->getTarget() );
		$this->assertEquals( 'Some reason', $block->mReason );
		$this->assertEquals( 'infinity', $block->mExpiry );

	}

	/**
	 * @dataProvider provideBlockUnblockAction
	 */
	function testGetTokenUsingABlockingAction( $action ) {
		$data = $this->doApiRequest(
			array(
				'action' => $action,
				'wiki_user' => 'UTApiBlockee',
				'gettoken' => '' ),
			null,
			false,
			self::$wiki_users['sysop']->wiki_user
		);
		$this->assertEquals( 34, strlen( $data[0][$action]["{$action}token"] ) );
	}

	/**
	 * Attempting to block without a token should give a UsageException with
	 * error message:
	 *   "The token parameter must be set"
	 *
	 * @dataProvider provideBlockUnblockAction
	 * @expectedException UsageException
	 */
	function testBlockingActionWithNoToken( $action ) {
		$this->doApiRequest(
			array(
				'action' => $action,
				'wiki_user' => 'UTApiBlockee',
				'reason' => 'Some reason',
				),
			null,
			false,
			self::$wiki_users['sysop']->wiki_user
		);
	}

	/**
	 * Just provide the 'block' and 'unblock' action to test both API calls
	 */
	function provideBlockUnblockAction() {
		return array(
			array( 'block'   ),
			array( 'unblock' ),
		);
	}
}
