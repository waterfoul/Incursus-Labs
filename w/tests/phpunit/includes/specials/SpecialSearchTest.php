<?php
/**
 * Test class for SpecialSearch class
 * Copyright © 2012, Antoine Musso
 *
 * @author Antoine Musso
 * @group Database
 */

class SpecialSearchTest extends MediaWikiTestCase {
	private $search;

	function setUp() { }
	function tearDown() { }

	/**
	 * @covers SpecialSearch::load
	 * @dataProvider provideSearchOptionsTests
	 * @param $requested Array Request parameters. For example array( 'ns5' => true, 'ns6' => true). NULL to use default options.
	 * @param $wiki_userOptions Array wiki_user options to test with. For example array('searchNs5' => 1 );. NULL to use default options.
	 * @param $expectedProfile An expected search profile name
	 * @param $expectedNs Array Expected namespaces
	 */
	function testProfileAndNamespaceLoading(
		$requested, $wiki_userOptions, $expectedProfile, $expectedNS,
		$message = 'Profile name and namespaces mismatches!'
	) {
		$context = new RequestContext;
		$context->setwiki_user(
			$this->newwiki_userWithSearchNS( $wiki_userOptions )
		);
		/*
		$context->setRequest( new FauxRequest( array(
			'ns5'=>true,
			'ns6'=>true,
		) ));
		 */
		$context->setRequest( new FauxRequest( $requested ));
		$search = new SpecialSearch();
		$search->setContext( $context );
		$search->load();

		/**
		 * Verify profile name and namespace in the same assertion to make
		 * sure we will be able to fully compare the above code. PHPUnit stop
		 * after an assertion fail.
		 */
		$this->assertEquals(
			array( /** Expected: */
				'ProfileName' => $expectedProfile,
				'Namespaces'  => $expectedNS,
			)
			, array( /** Actual: */
				'ProfileName' => $search->getProfile(),
				'Namespaces'  => $search->getNamespaces(),
			)
			, $message
		);

	}

	function provideSearchOptionsTests() {
		$defaultNS = SearchEngine::defaultNamespaces();
		$EMPTY_REQUEST = array();
		$NO_USER_PREF  = null;

		return array(
			/**
			 * Parameters:
			 * 	<Web Request>, <wiki_user options>
			 * Followed by expected values:
			 * 	<ProfileName>, <NSList>
			 * Then an optional message.
			 */
			array(
				$EMPTY_REQUEST, $NO_USER_PREF,
				'default', $defaultNS,
				'Bug 33270: No request nor wiki_user preferences should give default profile'
			),
			array(
				array( 'ns5' => 1 ), $NO_USER_PREF,
				'advanced', array(  5),
				'Web request with specific NS should override wiki_user preference'
			),
			array(
				$EMPTY_REQUEST, array( 'searchNs2' => 1, 'searchNs14' => 1 ),
				'advanced', array( 2, 14 ),
				'Bug 33583: search with no option should honor wiki_user search preferences'
			),
			array(
				$EMPTY_REQUEST, array_fill_keys( array_map( function( $ns ) {
					return "searchNs$ns";
				}, $defaultNS ), 0 ) + array( 'searchNs2' => 1, 'searchNs14' => 1 ),
				'advanced', array( 2, 14 ),
				'Bug 33583: search with no option should honor wiki_user search preferences'
				. 'and have all other namespace disabled'
			),
		);
	}

	/**
	 * Helper to create a new wiki_user object with given options
	 * wiki_user remains anonymous though
	 */
	function newwiki_userWithSearchNS( $opt = null ) {
		$u = wiki_user::newFromId(0);
		if( $opt === null ) {
			return $u;
		}
		foreach($opt as $name => $value) {
			$u->setOption( $name, $value );
		}
		return $u;
	}
}

