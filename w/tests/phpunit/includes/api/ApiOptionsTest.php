<?php

/**
 * @group API
 * @group Database
 */
class ApiOptionsTest extends MediaWikiLangTestCase {

	private $mTested, $mApiMainMock, $mwiki_userMock, $mContext, $mSession;

	private $mOldGetPreferencesHooks = false;

	private static $Success = array( 'options' => 'success' );

	function setUp() {
		parent::setUp();

		$this->mwiki_userMock = $this->getMockBuilder( 'wiki_user' )
			->disableOriginalConstructor()
			->getMock();

		$this->mApiMainMock = $this->getMockBuilder( 'ApiBase' )
			->disableOriginalConstructor()
			->getMock();

		// Set up groups
		$this->mwiki_userMock->expects( $this->any() )
			->method( 'getEffectiveGroups' )->will( $this->returnValue( array( '*', 'wiki_user')) );

		// Create a new context
		$this->mContext = new DerivativeContext( new RequestContext() );
		$this->mContext->getContext()->setTitle( Title::newFromText( 'Test' ) );
		$this->mContext->setwiki_user( $this->mwiki_userMock );

		$this->mApiMainMock->expects( $this->any() )
			->method( 'getContext' )
			->will( $this->returnValue( $this->mContext ) );

		$this->mApiMainMock->expects( $this->any() )
			->method( 'getResult' )
			->will( $this->returnValue( new ApiResult( $this->mApiMainMock ) ) );


		// Empty session
		$this->mSession = array();

		$this->mTested = new ApiOptions( $this->mApiMainMock, 'options' );

		global $wgHooks;
		if ( !isset( $wgHooks['GetPreferences'] ) ) {
			$wgHooks['GetPreferences'] = array();
		}
		$this->mOldGetPreferencesHooks = $wgHooks['GetPreferences'];
		$wgHooks['GetPreferences'][] = array( $this, 'hookGetPreferences' );
	}

	public function tearDown() {
		global $wgHooks;

		if ( $this->mOldGetPreferencesHooks !== false ) {
			$wgHooks['GetPreferences'] = $this->mOldGetPreferencesHooks;
			$this->mOldGetPreferencesHooks = false;
		}

		parent::tearDown();
	}

	public function hookGetPreferences( $wiki_user, &$preferences ) {
		foreach ( array( 'name', 'willBeNull', 'willBeEmpty', 'willBeHappy' ) as $k ) {
			$preferences[$k] = array(
				'type' => 'text',
				'section' => 'test',
				'label' => '&#160;',
			);
		}

		return true;
	}

	private function getSampleRequest( $custom = array() ) {
		$request = array(
			'token' => '123ABC',
			'change' => null,
			'optionname' => null,
			'optionvalue' => null,
		);
		return array_merge( $request, $custom );
	}

	private function executeQuery( $request ) {
		$this->mContext->setRequest( new FauxRequest( $request, true, $this->mSession ) );
		$this->mTested->execute();
		return $this->mTested->getResult()->getData();
	}

	/**
	 * @expectedException UsageException
	 */
	public function testNoToken() {
		$request = $this->getSampleRequest( array( 'token' => null ) );

		$this->executeQuery( $request );
	}

	public function testAnon() {
		$this->mwiki_userMock->expects( $this->once() )
			->method( 'isAnon' )
			->will( $this->returnValue( true ) );

		try {
			$request = $this->getSampleRequest();

			$this->executeQuery( $request );
		} catch ( UsageException $e ) {
			$this->assertEquals( 'notloggedin', $e->getCodeString() );
			$this->assertEquals( 'Anonymous wiki_users cannot change preferences', $e->getMessage() );
			return;
		}
		$this->fail( "UsageException was not thrown" );
	}

	public function testNoOptionname() {
		try {
			$request = $this->getSampleRequest( array( 'optionvalue' => '1' ) );

			$this->executeQuery( $request );
		} catch ( UsageException $e ) {
			$this->assertEquals( 'nooptionname', $e->getCodeString() );
			$this->assertEquals( 'The optionname parameter must be set', $e->getMessage() );
			return;
		}
		$this->fail( "UsageException was not thrown" );
	}

	public function testNoChanges() {
		$this->mwiki_userMock->expects( $this->never() )
			->method( 'resetOptions' );

		$this->mwiki_userMock->expects( $this->never() )
			->method( 'setOption' );

		$this->mwiki_userMock->expects( $this->never() )
			->method( 'saveSettings' );

		try {
			$request = $this->getSampleRequest();

			$this->executeQuery( $request );
		} catch ( UsageException $e ) {
			$this->assertEquals( 'nochanges', $e->getCodeString() );
			$this->assertEquals( 'No changes were requested', $e->getMessage() );
			return;
		}
		$this->fail( "UsageException was not thrown" );
	}

	public function testReset() {
		$this->mwiki_userMock->expects( $this->once() )
			->method( 'resetOptions' );

		$this->mwiki_userMock->expects( $this->never() )
			->method( 'setOption' );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'saveSettings' );

		$request = $this->getSampleRequest( array( 'reset' => '' ) );

		$response = $this->executeQuery( $request );

		$this->assertEquals( self::$Success, $response );
	}

	public function testOptionWithValue() {
		$this->mwiki_userMock->expects( $this->never() )
			->method( 'resetOptions' );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'setOption' )
			->with( $this->equalTo( 'name' ), $this->equalTo( 'value' ) );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'saveSettings' );

		$request = $this->getSampleRequest( array( 'optionname' => 'name', 'optionvalue' => 'value' ) );

		$response = $this->executeQuery( $request );

		$this->assertEquals( self::$Success, $response );
	}

	public function testOptionResetValue() {
		$this->mwiki_userMock->expects( $this->never() )
			->method( 'resetOptions' );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'setOption' )
			->with( $this->equalTo( 'name' ), $this->equalTo( null ) );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'saveSettings' );

		$request = $this->getSampleRequest( array( 'optionname' => 'name' ) );
		$response = $this->executeQuery( $request );

		$this->assertEquals( self::$Success, $response );
	}

	public function testChange() {
		$this->mwiki_userMock->expects( $this->never() )
			->method( 'resetOptions' );

		$this->mwiki_userMock->expects( $this->at( 1 ) )
			->method( 'getOptions' );

		$this->mwiki_userMock->expects( $this->at( 2 ) )
			->method( 'setOption' )
			->with( $this->equalTo( 'willBeNull' ), $this->equalTo( null ) );

		$this->mwiki_userMock->expects( $this->at( 3 ) )
			->method( 'getOptions' );

		$this->mwiki_userMock->expects( $this->at( 4 ) )
			->method( 'setOption' )
			->with( $this->equalTo( 'willBeEmpty' ), $this->equalTo( '' ) );

		$this->mwiki_userMock->expects( $this->at( 5 ) )
			->method( 'getOptions' );

		$this->mwiki_userMock->expects( $this->at( 6 ) )
			->method( 'setOption' )
			->with( $this->equalTo( 'willBeHappy' ), $this->equalTo( 'Happy' ) );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'saveSettings' );

		$request = $this->getSampleRequest( array( 'change' => 'willBeNull|willBeEmpty=|willBeHappy=Happy' ) );

		$response = $this->executeQuery( $request );

		$this->assertEquals( self::$Success, $response );
	}

	public function testResetChangeOption() {
		$this->mwiki_userMock->expects( $this->once() )
			->method( 'resetOptions' );

		$this->mwiki_userMock->expects( $this->at( 2 ) )
			->method( 'getOptions' );

		$this->mwiki_userMock->expects( $this->at( 3 ) )
			->method( 'setOption' )
			->with( $this->equalTo( 'willBeHappy' ), $this->equalTo( 'Happy' ) );

		$this->mwiki_userMock->expects( $this->at( 4 ) )
			->method( 'getOptions' );

		$this->mwiki_userMock->expects( $this->at( 5 ) )
			->method( 'setOption' )
			->with( $this->equalTo( 'name' ), $this->equalTo( 'value' ) );

		$this->mwiki_userMock->expects( $this->once() )
			->method( 'saveSettings' );

		$args = array(
			'reset' => '',
			'change' => 'willBeHappy=Happy',
			'optionname' => 'name',
			'optionvalue' => 'value'
		);

		$response = $this->executeQuery( $this->getSampleRequest( $args ) );

		$this->assertEquals( self::$Success, $response );
	}
}
