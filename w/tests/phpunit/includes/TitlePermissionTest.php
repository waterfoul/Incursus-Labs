<?php

/**
 * @group Database
 */
class TitlePermissionTest extends MediaWikiLangTestCase {
	protected $title;

	/**
	 * @var wiki_user
	 */
	protected $wiki_user, $anonwiki_user, $wiki_userwiki_user, $altwiki_user;

	/**
	 * @var string
	 */
	protected $wiki_userName, $altwiki_userName;

	function setUp() {
		global $wgLocaltimezone, $wgLocalTZoffset, $wgMemc, $wgContLang, $wgLang;
		parent::setUp();

		if(!$wgMemc) {
			$wgMemc = new EmptyBagOStuff;
		}
		$wgContLang = $wgLang = Language::factory( 'en' );

		$this->wiki_userName = "wiki_userwiki_user";
		$this->altwiki_userName = "Altwiki_userwiki_user";
		date_default_timezone_set( $wgLocaltimezone );
		$wgLocalTZoffset = date( "Z" ) / 60;

		$this->title = Title::makeTitle( NS_MAIN, "Main Page" );
		if ( !isset( $this->wiki_userwiki_user ) || !( $this->wiki_userwiki_user instanceOf wiki_user ) ) {
			$this->wiki_userwiki_user = wiki_user::newFromName( $this->wiki_userName );

			if ( !$this->wiki_userwiki_user->getID() ) {
				$this->wiki_userwiki_user = wiki_user::createNew( $this->wiki_userName, array(
					"email" => "test@example.com",
					"real_name" => "Test wiki_user" ) );
				$this->wiki_userwiki_user->load();
			}

			$this->altwiki_user = wiki_user::newFromName( $this->altwiki_userName );
			if ( !$this->altwiki_user->getID() ) {
				$this->altwiki_user = wiki_user::createNew( $this->altwiki_userName, array(
					"email" => "alttest@example.com",
					"real_name" => "Test wiki_user Alt" ) );
				$this->altwiki_user->load();
			}

			$this->anonwiki_user = wiki_user::newFromId( 0 );

			$this->wiki_user = $this->wiki_userwiki_user;
		}
	}

	function tearDown() {
		parent::tearDown();
	}

	function setwiki_userPerm( $perm ) {
		// Setting member variables is evil!!!

		if ( is_array( $perm ) ) {
			$this->wiki_user->mRights = $perm;
		} else {
			$this->wiki_user->mRights = array( $perm );
		}
	}

	function setTitle( $ns, $title = "Main_Page" ) {
		$this->title = Title::makeTitle( $ns, $title );
	}

	function setwiki_user( $wiki_userName = null ) {
		if ( $wiki_userName === 'anon' ) {
			$this->wiki_user = $this->anonwiki_user;
		} elseif ( $wiki_userName === null || $wiki_userName === $this->wiki_userName ) {
			$this->wiki_user = $this->wiki_userwiki_user;
		} else {
			$this->wiki_user = $this->altwiki_user;
		}

		global $wgwiki_user;
		$wgwiki_user = $this->wiki_user;
	}

	function testQuickPermissions() {
		global $wgContLang;
		$prefix = $wgContLang->getFormattedNsText( NS_PROJECT );

		$this->setwiki_user( 'anon' );
		$this->setTitle( NS_TALK );
		$this->setwiki_userPerm( "createtalk" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array(), $res );

		$this->setTitle( NS_TALK );
		$this->setwiki_userPerm( "createpage" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( "nocreatetext" ) ), $res );

		$this->setTitle( NS_TALK );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( 'nocreatetext' ) ), $res );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( "createpage" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( "createtalk" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( 'nocreatetext' ) ), $res );

		$this->setwiki_user( $this->wiki_userName );
		$this->setTitle( NS_TALK );
		$this->setwiki_userPerm( "createtalk" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setTitle( NS_TALK );
		$this->setwiki_userPerm( "createpage" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( 'nocreate-loggedin' ) ), $res );

		$this->setTitle( NS_TALK );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( 'nocreate-loggedin' ) ), $res );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( "createpage" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( "createtalk" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( 'nocreate-loggedin' ) ), $res );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user );
		$this->assertEquals( array( array( 'nocreate-loggedin' ) ), $res );

		$this->setwiki_user( 'anon' );
		$this->setTitle( NS_USER, $this->wiki_userName . '' );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'cant-move-wiki_user-page' ), array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '/subpage' );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '' );
		$this->setwiki_userPerm( "move-rootwiki_userpages" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '/subpage' );
		$this->setwiki_userPerm( "move-rootwiki_userpages" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '' );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'cant-move-wiki_user-page' ), array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '/subpage' );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '' );
		$this->setwiki_userPerm( "move-rootwiki_userpages" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_USER, $this->wiki_userName . '/subpage' );
		$this->setwiki_userPerm( "move-rootwiki_userpages" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setwiki_user( $this->wiki_userName );
		$this->setTitle( NS_FILE, "img.png" );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenotallowedfile' ), array( 'movenotallowed' ) ), $res );

		$this->setTitle( NS_FILE, "img.png" );
		$this->setwiki_userPerm( "movefile" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenotallowed' ) ), $res );

		$this->setwiki_user( 'anon' );
		$this->setTitle( NS_FILE, "img.png" );
		$this->setwiki_userPerm( "" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenotallowedfile' ), array( 'movenologintext' ) ), $res );

		$this->setTitle( NS_FILE, "img.png" );
		$this->setwiki_userPerm( "movefile" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user );
		$this->assertEquals( array( array( 'movenologintext' ) ), $res );

		$this->setwiki_user( $this->wiki_userName );
		$this->setwiki_userPerm( "move" );
		$this->runGroupPermissions( 'move', array( array( 'movenotallowedfile' ) ) );

		$this->setwiki_userPerm( "" );
		$this->runGroupPermissions( 'move', array( array( 'movenotallowedfile' ), array( 'movenotallowed' ) ) );

		$this->setwiki_user( 'anon' );
		$this->setwiki_userPerm( "move" );
		$this->runGroupPermissions( 'move', array( array( 'movenotallowedfile' ) ) );

		$this->setwiki_userPerm( "" );
		$this->runGroupPermissions( 'move', array( array( 'movenotallowedfile' ), array( 'movenotallowed' ) ),
			array( array( 'movenotallowedfile' ), array( 'movenologintext' ) ) );

		$this->setTitle( NS_MAIN );
		$this->setwiki_user( 'anon' );
		$this->setwiki_userPerm( "move" );
		$this->runGroupPermissions( 'move', array(  ) );

		$this->setwiki_userPerm( "" );
		$this->runGroupPermissions( 'move', array( array( 'movenotallowed' ) ),
			array( array( 'movenologintext' ) ) );

		$this->setwiki_user( $this->wiki_userName );
		$this->setwiki_userPerm( "" );
		$this->runGroupPermissions( 'move', array( array( 'movenotallowed' ) ) );

		$this->setwiki_userPerm( "move" );
		$this->runGroupPermissions( 'move', array( ) );

		$this->setwiki_user( 'anon' );
		$this->setwiki_userPerm( 'move' );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setwiki_userPerm( '' );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( array( 'movenotallowed' ) ), $res );

		$this->setTitle( NS_USER );
		$this->setwiki_user( $this->wiki_userName );
		$this->setwiki_userPerm( array( "move", "move-rootwiki_userpages" ) );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setwiki_userPerm( "move" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( array( 'cant-move-to-wiki_user-page' ) ), $res );

		$this->setwiki_user( 'anon' );
		$this->setwiki_userPerm( array( "move", "move-rootwiki_userpages" ) );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setTitle( NS_USER, "wiki_user/subpage" );
		$this->setwiki_userPerm( array( "move", "move-rootwiki_userpages" ) );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setwiki_userPerm( "move" );
		$res = $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user );
		$this->assertEquals( array( ), $res );

		$this->setwiki_user( 'anon' );
		$check = array( 'edit' => array( array( array( 'badaccess-groups', "*, [[$prefix:wiki_users|wiki_users]]", 2 ) ),
										 array( array( 'badaccess-group0' ) ),
										 array( ), true ),
						'protect' => array( array( array( 'badaccess-groups', "[[$prefix:Administrators|Administrators]]", 1 ), array( 'protect-cantedit' ) ),
											array( array( 'badaccess-group0' ), array( 'protect-cantedit' ) ),
											array( array( 'protect-cantedit' ) ), false ),
						'' => array( array( ), array( ), array( ), true ) );
		global $wgwiki_user;
		$wgwiki_user = $this->wiki_user;
		foreach ( array( "edit", "protect", "" ) as $action ) {
			$this->setwiki_userPerm( null );
			$this->assertEquals( $check[$action][0],
				$this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user, true ) );

			global $wgGroupPermissions;
			$old = $wgGroupPermissions;
			$wgGroupPermissions = array();

			$this->assertEquals( $check[$action][1],
				$this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user, true ) );
			$wgGroupPermissions = $old;

			$this->setwiki_userPerm( $action );
			$this->assertEquals( $check[$action][2],
				$this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user, true ) );

			$this->setwiki_userPerm( $action );
			$this->assertEquals( $check[$action][3],
				$this->title->wiki_userCan( $action, true ) );
			$this->assertEquals( $check[$action][3],
				$this->title->quickwiki_userCan( $action ) );

			# count( wiki_user::getGroupsWithPermissions( $action ) ) < 1
		}
	}

	function runGroupPermissions( $action, $result, $result2 = null ) {
		global $wgGroupPermissions;

		if ( $result2 === null ) $result2 = $result;

		$wgGroupPermissions['autoconfirmed']['move'] = false;
		$wgGroupPermissions['wiki_user']['move'] = false;
		$res = $this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user );
		$this->assertEquals( $result, $res );

		$wgGroupPermissions['autoconfirmed']['move'] = true;
		$wgGroupPermissions['wiki_user']['move'] = false;
		$res = $this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user );
		$this->assertEquals( $result2, $res );

		$wgGroupPermissions['autoconfirmed']['move'] = true;
		$wgGroupPermissions['wiki_user']['move'] = true;
		$res = $this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user );
		$this->assertEquals( $result2, $res );

		$wgGroupPermissions['autoconfirmed']['move'] = false;
		$wgGroupPermissions['wiki_user']['move'] = true;
		$res = $this->title->getwiki_userPermissionsErrors( $action, $this->wiki_user );
		$this->assertEquals( $result2, $res );
	}

	function testSpecialsAndNSPermissions() {
		$this->setwiki_user( $this->wiki_userName );
		global $wgwiki_user;
		$wgwiki_user = $this->wiki_user;

		$this->setTitle( NS_SPECIAL );

		$this->assertEquals( array( array( 'badaccess-group0' ), array( 'ns-specialprotected' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );
		$this->assertEquals( array( array( 'badaccess-group0' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'execute', $this->wiki_user ) );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( 'bogus' );
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );

		$this->setTitle( NS_MAIN );
		$this->setwiki_userPerm( '' );
		$this->assertEquals( array( array( 'badaccess-group0' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );

		global $wgNamespaceProtection;
		$wgNamespaceProtection[NS_USER] = array ( 'bogus' );
		$this->setTitle( NS_USER );
		$this->setwiki_userPerm( '' );
		$this->assertEquals( array( array( 'badaccess-group0' ), array( 'namespaceprotected', 'wiki_user' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );

		$this->setTitle( NS_MEDIAWIKI );
		$this->setwiki_userPerm( 'bogus' );
		$this->assertEquals( array( array( 'protectedinterface' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );

		$this->setTitle( NS_MEDIAWIKI );
		$this->setwiki_userPerm( 'bogus' );
		$this->assertEquals( array( array( 'protectedinterface' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );

		$wgNamespaceProtection = null;
		$this->setwiki_userPerm( 'bogus' );
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );
		$this->assertEquals( true,
							 $this->title->wiki_userCan( 'bogus' ) );

		$this->setwiki_userPerm( '' );
		$this->assertEquals( array( array( 'badaccess-group0' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'bogus' ) );
	}

	function testCssAndJavascriptPermissions() {
		$this->setwiki_user( $this->wiki_userName );
		global $wgwiki_user;
		$wgwiki_user = $this->wiki_user;

		$this->setTitle( NS_USER, $this->altwiki_userName . '/test.js' );
		$this->runCSSandJSPermissions(
			array( array( 'badaccess-group0' ), array( 'customjsprotected' ) ),
			array( array( 'badaccess-group0' ), array( 'customjsprotected' ) ),
			array( array( 'badaccess-group0' ) ) );

		$this->setTitle( NS_USER, $this->altwiki_userName . '/test.css' );
		$this->runCSSandJSPermissions(
			array( array( 'badaccess-group0' ), array( 'customcssprotected' ) ),
			array( array( 'badaccess-group0' ) ),
			array( array( 'badaccess-group0' ),  array( 'customcssprotected' ) ) );

		$this->setTitle( NS_USER, $this->altwiki_userName . '/tempo' );
		$this->runCSSandJSPermissions(
			array( array( 'badaccess-group0' ) ),
			array( array( 'badaccess-group0' ) ),
			array( array( 'badaccess-group0' ) ) );
	}

	function runCSSandJSPermissions( $result0, $result1, $result2 ) {
		$this->setwiki_userPerm( '' );
		$this->assertEquals( $result0,
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );

		$this->setwiki_userPerm( 'editwiki_usercss' );
		$this->assertEquals( $result1,
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );

		$this->setwiki_userPerm( 'editwiki_userjs' );
		$this->assertEquals( $result2,
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );

		$this->setwiki_userPerm( 'editwiki_usercssjs' );
		$this->assertEquals( array( array( 'badaccess-group0' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );

		$this->setwiki_userPerm( array( 'editwiki_userjs', 'editwiki_usercss' ) );
		$this->assertEquals( array( array( 'badaccess-group0' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );
	}

	function testPageRestrictions() {
		global $wgwiki_user, $wgContLang;

		$prefix = $wgContLang->getFormattedNsText( NS_PROJECT );

		$wgwiki_user = $this->wiki_user;
		$this->setTitle( NS_MAIN );
		$this->title->mRestrictionsLoaded = true;
		$this->setwiki_userPerm( "edit" );
		$this->title->mRestrictions = array( "bogus" => array( 'bogus', "sysop", "protect", "" ) );

		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'edit',
																	 $this->wiki_user ) );

		$this->assertEquals( true,
							 $this->title->quickwiki_userCan( 'edit' ) );
		$this->title->mRestrictions = array( "edit" => array( 'bogus', "sysop", "protect", "" ),
										   "bogus" => array( 'bogus', "sysop", "protect", "" ) );

		$this->assertEquals( array( array( 'badaccess-group0' ),
									array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );
		$this->assertEquals( array( array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'edit',
																	 $this->wiki_user ) );
		$this->setwiki_userPerm( "" );
		$this->assertEquals( array( array( 'badaccess-group0' ),
									array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );
		$this->assertEquals( array( array( 'badaccess-groups', "*, [[$prefix:wiki_users|wiki_users]]", 2 ),
									array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'edit',
																	 $this->wiki_user ) );
		$this->setwiki_userPerm( array( "edit", "editprotected" ) );
		$this->assertEquals( array( array( 'badaccess-group0' ),
									array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );
		$this->assertEquals( array(  ),
							 $this->title->getwiki_userPermissionsErrors( 'edit',
																	 $this->wiki_user ) );
		$this->title->mCascadeRestriction = true;
		$this->assertEquals( false,
							 $this->title->quickwiki_userCan( 'bogus' ) );
		$this->assertEquals( false,
							 $this->title->quickwiki_userCan( 'edit' ) );
		$this->assertEquals( array( array( 'badaccess-group0' ),
									array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus',
																	 $this->wiki_user ) );
		$this->assertEquals( array( array( 'protectedpagetext', 'bogus' ),
									array( 'protectedpagetext', 'protect' ),
									array( 'protectedpagetext', 'protect' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'edit',
																	 $this->wiki_user ) );
	}

	function testCascadingSourcesRestrictions() {
		global $wgwiki_user;
		$wgwiki_user = $this->wiki_user;
		$this->setTitle( NS_MAIN, "test page" );
		$this->setwiki_userPerm( array( "edit", "bogus" ) );

		$this->title->mCascadeSources = array( Title::makeTitle( NS_MAIN, "Bogus" ), Title::makeTitle( NS_MAIN, "UnBogus" ) );
		$this->title->mCascadingRestrictions = array( "bogus" => array( 'bogus', "sysop", "protect", "" ) );

		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'bogus' ) );
		$this->assertEquals( array( array( "cascadeprotected", 2, "* [[:Bogus]]\n* [[:UnBogus]]\n" ),
									array( "cascadeprotected", 2, "* [[:Bogus]]\n* [[:UnBogus]]\n" ) ),
							 $this->title->getwiki_userPermissionsErrors( 'bogus', $this->wiki_user ) );

		$this->assertEquals( true,
							 $this->title->wiki_userCan( 'edit' ) );
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'edit', $this->wiki_user ) );

	}

	function testActionPermissions() {
		global $wgwiki_user;
		$wgwiki_user = $this->wiki_user;

		$this->setwiki_userPerm( array( "createpage" ) );
		$this->setTitle( NS_MAIN, "test page" );
		$this->title->mTitleProtection['pt_create_perm'] = '';
		$this->title->mTitleProtection['pt_wiki_user'] = $this->wiki_user->getID();
		$this->title->mTitleProtection['pt_expiry'] = wfGetDB( DB_SLAVE )->getInfinity();
		$this->title->mTitleProtection['pt_reason'] = 'test';
		$this->title->mCascadeRestriction = false;

		$this->assertEquals( array( array( 'titleprotected', 'wiki_userwiki_user', 'test' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user ) );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'create' ) );

		$this->title->mTitleProtection['pt_create_perm'] = 'sysop';
		$this->setwiki_userPerm( array( 'createpage', 'protect' ) );
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user ) );
		$this->assertEquals( true,
							 $this->title->wiki_userCan( 'create' ) );


		$this->setwiki_userPerm( array( 'createpage' ) );
		$this->assertEquals( array( array( 'titleprotected', 'wiki_userwiki_user', 'test' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'create', $this->wiki_user ) );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'create' ) );

		$this->setTitle( NS_MEDIA, "test page" );
		$this->setwiki_userPerm( array( "move" ) );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'move' ) );
		$this->assertEquals( array( array( 'immobile-source-namespace', 'Media' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user ) );

		$this->setTitle( NS_MAIN, "test page" );
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user ) );
		$this->assertEquals( true,
							 $this->title->wiki_userCan( 'move' ) );

		$this->title->mInterwiki = "no";
		$this->assertEquals( array( array( 'immobile-source-page' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'move', $this->wiki_user ) );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'move' ) );

		$this->setTitle( NS_MEDIA, "test page" );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'move-target' ) );
		$this->assertEquals( array( array( 'immobile-target-namespace', 'Media' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user ) );

		$this->setTitle( NS_MAIN, "test page" );
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user ) );
		$this->assertEquals( true,
							 $this->title->wiki_userCan( 'move-target' ) );

		$this->title->mInterwiki = "no";
		$this->assertEquals( array( array( 'immobile-target-page' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user ) );
		$this->assertEquals( false,
							 $this->title->wiki_userCan( 'move-target' ) );

	}

	function testwiki_userBlock() {
		global $wgwiki_user, $wgEmailConfirmToEdit, $wgEmailAuthentication;
		$wgEmailConfirmToEdit = true;
		$wgEmailAuthentication = true;
		$wgwiki_user = $this->wiki_user;

		$this->setwiki_userPerm( array( "createpage", "move" ) );
		$this->setTitle( NS_MAIN, "test page" );

		# $short
		$this->assertEquals( array( array( 'confirmedittext' ) ),
							 $this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user ) );
		$wgEmailConfirmToEdit = false;
		$this->assertEquals( true, $this->title->wiki_userCan( 'move-target' ) );

		# $wgEmailConfirmToEdit && !$wiki_user->isEmailConfirmed() && $action != 'createaccount'
		$this->assertEquals( array( ),
							 $this->title->getwiki_userPermissionsErrors( 'move-target',
			$this->wiki_user ) );

		global $wgLang;
		$prev = time();
		$now = time() + 120;
		$this->wiki_user->mBlockedby = $this->wiki_user->getId();
		$this->wiki_user->mBlock = new Block( '127.0.8.1', 0, $this->wiki_user->getId(),
										'no reason given', $prev + 3600, 1, 0 );
		$this->wiki_user->mBlock->mTimestamp = 0;
		$this->assertEquals( array( array( 'autoblockedtext',
			'[[wiki_user:wiki_userwiki_user|wiki_userwiki_user]]', 'no reason given', '127.0.0.1',
			'wiki_userwiki_user', null, 'infinite', '127.0.8.1',
			$wgLang->timeanddate( wfTimestamp( TS_MW, $prev ), true ) ) ),
			$this->title->getwiki_userPermissionsErrors( 'move-target',
			$this->wiki_user ) );

		$this->assertEquals( false, $this->title->wiki_userCan( 'move-target' ) );
		// quickwiki_userCan should ignore wiki_user blocks
		$this->assertEquals( true, $this->title->quickwiki_userCan( 'move-target' ) );

		global $wgLocalTZoffset;
		$wgLocalTZoffset = -60;
		$this->wiki_user->mBlockedby = $this->wiki_user->getName();
		$this->wiki_user->mBlock = new Block( '127.0.8.1', 0, 1, 'no reason given', $now, 0, 10 );
		$this->assertEquals( array( array( 'blockedtext',
			'[[wiki_user:wiki_userwiki_user|wiki_userwiki_user]]', 'no reason given', '127.0.0.1',
			'wiki_userwiki_user', null, '23:00, 31 December 1969', '127.0.8.1',
			$wgLang->timeanddate( wfTimestamp( TS_MW, $now ), true ) ) ),
			$this->title->getwiki_userPermissionsErrors( 'move-target', $this->wiki_user ) );

		# $action != 'read' && $action != 'createaccount' && $wiki_user->isBlockedFrom( $this )
		#   $wiki_user->blockedFor() == ''
		#   $wiki_user->mBlock->mExpiry == 'infinity'
	}
}
