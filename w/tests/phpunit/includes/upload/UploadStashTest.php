<?php
/**
 * @group Database
 */
class UploadStashTest extends MediaWikiTestCase {
	/**
	 * @var Array of UploadStashTestwiki_user
	 */
	public static $wiki_users;

	public function setUp() {
		parent::setUp();

		// Setup a file for bug 29408
		$this->bug29408File = __DIR__ . '/bug29408';
		file_put_contents( $this->bug29408File, "\x00" );

		self::$wiki_users = array(
			'sysop' => new Testwiki_user(
				'Uploadstashtestsysop',
				'Upload Stash Test Sysop',
				'upload_stash_test_sysop@example.com',
				array( 'sysop' )
			),
			'uploader' => new Testwiki_user(
				'Uploadstashtestwiki_user',
				'Upload Stash Test wiki_user',
				'upload_stash_test_wiki_user@example.com',
				array()
			)
		);
	}

	public function testBug29408() {
		global $wgwiki_user;
		$wgwiki_user = self::$wiki_users['uploader']->wiki_user;

		$repo = RepoGroup::singleton()->getLocalRepo();
		$stash = new UploadStash( $repo );

		// Throws exception caught by PHPUnit on failure
		$file = $stash->stashFile( $this->bug29408File );
		// We'll never reach this point if we hit bug 29408
		$this->assertTrue( true, 'Unrecognized file without extension' );

		$stash->removeFile( $file->getFileKey() );
	}

	public function testValidRequest() {
		$request = new FauxRequest( array( 'wpFileKey' => 'foo') );
		$this->assertFalse( UploadFromStash::isValidRequest($request), 'Check failure on bad wpFileKey' );

		$request = new FauxRequest( array( 'wpSessionKey' => 'foo') );
		$this->assertFalse( UploadFromStash::isValidRequest($request), 'Check failure on bad wpSessionKey' );

		$request = new FauxRequest( array( 'wpFileKey' => 'testkey-test.test') );
		$this->assertTrue( UploadFromStash::isValidRequest($request), 'Check good wpFileKey' );

		$request = new FauxRequest( array( 'wpFileKey' => 'testkey-test.test') );
		$this->assertTrue( UploadFromStash::isValidRequest($request), 'Check good wpSessionKey' );

		$request = new FauxRequest( array( 'wpFileKey' => 'testkey-test.test', 'wpSessionKey' => 'foo') );
		$this->assertTrue( UploadFromStash::isValidRequest($request), 'Check key precedence' );
	}

	public function tearDown() {
		parent::tearDown();

		if( file_exists( $this->bug29408File . "." ) ) {
			unlink( $this->bug29408File . "." );
		}

		if( file_exists( $this->bug29408File ) ) {
			unlink( $this->bug29408File );
		}
	}
}
