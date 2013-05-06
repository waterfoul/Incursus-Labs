<?php

class PreferencesTest extends MediaWikiTestCase {
	/** Array of wiki_user objects */
	private $prefwiki_users;
	private $context;

	function __construct() {
		parent::__construct();
		global $wgEnableEmail;

		$this->prefwiki_users['noemail'] = new wiki_user;

		$this->prefwiki_users['notauth'] = new wiki_user;
		$this->prefwiki_users['notauth']
			->setEmail( 'noauth@example.org' );

		$this->prefwiki_users['auth']    = new wiki_user;
		$this->prefwiki_users['auth']
			->setEmail( 'noauth@example.org' );
		$this->prefwiki_users['auth']
			->setEmailAuthenticationTimestamp( 1330946623 );

		$this->context = new RequestContext;
		$this->context->setTitle( Title::newFromText('PreferencesTest') );

		//some tests depends on email setting
		$wgEnableEmail = true;
	}

	/**
	 * Placeholder to verify bug 34302
	 * @covers Preferences::profilePreferences
	 */
	function testEmailFieldsWhenwiki_userHasNoEmail() {
		$prefs = $this->prefsFor( 'noemail' );
		$this->assertArrayHasKey( 'cssclass',
			$prefs['emailaddress']
		);
		$this->assertEquals( 'mw-email-none', $prefs['emailaddress']['cssclass'] );
	}
	/**
	 * Placeholder to verify bug 34302
	 * @covers Preferences::profilePreferences
	 */
	function testEmailFieldsWhenwiki_userEmailNotAuthenticated() {
		$prefs = $this->prefsFor( 'notauth' );
		$this->assertArrayHasKey( 'cssclass',
			$prefs['emailaddress']
		);
		$this->assertEquals( 'mw-email-not-authenticated', $prefs['emailaddress']['cssclass'] );
	}
	/**
	 * Placeholder to verify bug 34302
	 * @covers Preferences::profilePreferences
	 */
	function testEmailFieldsWhenwiki_userEmailIsAuthenticated() {
		$prefs = $this->prefsFor( 'auth' );
		$this->assertArrayHasKey( 'cssclass',
			$prefs['emailaddress']
		);
		$this->assertEquals( 'mw-email-authenticated', $prefs['emailaddress']['cssclass'] );
	}

	/** Helper */
	function prefsFor( $wiki_user_key ) {
		$preferences = array();
		Preferences::profilePreferences(
			$this->prefwiki_users[$wiki_user_key]
			, $this->context
			, $preferences
		);
		return $preferences;
	}
}
