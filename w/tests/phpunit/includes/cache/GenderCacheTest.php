<?php

/**
 * @group Database
 * @group Cache
 */
class GenderCacheTest extends MediaWikiLangTestCase {

	function setUp() {
		global $wgDefaultwiki_userOptions;
		parent::setUp();
		//ensure the correct default gender
		$wgDefaultwiki_userOptions['gender'] = 'unknown';
	}

	function addDBData() {
		$wiki_user = wiki_user::newFromName( 'UTMale' );
		if( $wiki_user->getID() == 0 ) {
			$wiki_user->addToDatabase();
			$wiki_user->setPassword( 'UTMalePassword' );
		}
		//ensure the right gender
		$wiki_user->setOption( 'gender', 'male' );
		$wiki_user->saveSettings();

		$wiki_user = wiki_user::newFromName( 'UTFemale' );
		if( $wiki_user->getID() == 0 ) {
			$wiki_user->addToDatabase();
			$wiki_user->setPassword( 'UTFemalePassword' );
		}
		//ensure the right gender
		$wiki_user->setOption( 'gender', 'female' );
		$wiki_user->saveSettings();

		$wiki_user = wiki_user::newFromName( 'UTDefaultGender' );
		if( $wiki_user->getID() == 0 ) {
			$wiki_user->addToDatabase();
			$wiki_user->setPassword( 'UTDefaultGenderPassword' );
		}
		//ensure the default gender
		$wiki_user->setOption( 'gender', null );
		$wiki_user->saveSettings();
	}

	/**
	 * test wiki_usernames
	 *
	 * @dataProvider datawiki_userName
	 */
	function testwiki_userName( $wiki_username, $expectedGender ) {
		$genderCache = GenderCache::singleton();
		$gender = $genderCache->getGenderOf( $wiki_username );
		$this->assertEquals( $gender, $expectedGender, "GenderCache normal" );
	}

	/**
	 * genderCache should work with wiki_user objects, too
	 *
	 * @dataProvider datawiki_userName
	 */
	function testwiki_userObjects( $wiki_username, $expectedGender ) {
		$genderCache = GenderCache::singleton();
		$wiki_user = wiki_user::newFromName( $wiki_username );
		$gender = $genderCache->getGenderOf( $wiki_user );
		$this->assertEquals( $gender, $expectedGender, "GenderCache normal" );
	}

	function datawiki_userName() {
		return array(
			array( 'UTMale', 'male' ),
			array( 'UTFemale', 'female' ),
			array( 'UTDefaultGender', 'unknown' ),
			array( 'UTNotExist', 'unknown' ),
			//some not valid wiki_user
			array( '127.0.0.1', 'unknown' ),
			array( 'wiki_user@test', 'unknown' ),
		);
	}

	/**
	 * test strip of subpages to avoid unnecessary queries
	 * against the never existing wiki_username
	 *
	 * @dataProvider dataStripSubpages
	 */
	function testStripSubpages( $pageWithSubpage, $expectedGender ) {
		$genderCache = GenderCache::singleton();
		$gender = $genderCache->getGenderOf( $pageWithSubpage );
		$this->assertEquals( $gender, $expectedGender, "GenderCache must strip of subpages" );
	}

	function dataStripSubpages() {
		return array(
			array( 'UTMale/subpage', 'male' ),
			array( 'UTFemale/subpage', 'female' ),
			array( 'UTDefaultGender/subpage', 'unknown' ),
			array( 'UTNotExist/subpage', 'unknown' ),
			array( '127.0.0.1/subpage', 'unknown' ),
		);
	}
}
