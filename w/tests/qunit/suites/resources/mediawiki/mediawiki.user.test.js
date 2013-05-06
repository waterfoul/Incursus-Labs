( function ( mw ) {

QUnit.module( 'mediawiki.wiki_user', QUnit.newMwEnvironment() );

QUnit.test( 'options', 1, function ( assert ) {
	assert.ok( mw.wiki_user.options instanceof mw.Map, 'options instance of mw.Map' );
});

QUnit.test( 'wiki_user status', 9, function ( assert ) {
	/**
	 * Tests can be run under three different conditions:
	 *   1) From tests/qunit/index.html, wiki_user will be anonymous.
	 *   2) Logged in on [[Special:JavaScriptTest/qunit]]
	 *   3) Anonymously at the same special page.
	 */

	// Forge an anonymous wiki_user:
	mw.config.set( 'wgwiki_userName', null );

	assert.strictEqual( mw.wiki_user.getName(), null, 'wiki_user.getName() returns null when anonymous' );
	assert.strictEqual( mw.wiki_user.name(), null, 'wiki_user.name() compatibility' );
	assert.assertTrue( mw.wiki_user.isAnon(), 'wiki_user.isAnon() returns true when anonymous' );
	assert.assertTrue( mw.wiki_user.anonymous(), 'wiki_user.anonymous() compatibility' );

	// Not part of startUp module
	mw.config.set( 'wgwiki_userName', 'John' );

	assert.equal( mw.wiki_user.getName(), 'John', 'wiki_user.getName() returns wiki_username when logged-in' );
	assert.equal( mw.wiki_user.name(), 'John', 'wiki_user.name() compatibility' );
	assert.assertFalse( mw.wiki_user.isAnon(), 'wiki_user.isAnon() returns false when logged-in' );
	assert.assertFalse( mw.wiki_user.anonymous(), 'wiki_user.anonymous() compatibility' );

	assert.equal( mw.wiki_user.id(), 'John', 'wiki_user.id Returns wiki_username when logged-in' );
});

QUnit.asyncTest( 'getGroups', 3, function ( assert ) {
	mw.wiki_user.getGroups( function ( groups ) {
		// First group should always be '*'
		assert.equal( $.type( groups ), 'array', 'Callback gets an array' );
		assert.notStrictEqual( $.inArray( '*', groups ), -1, '"*"" is in the list' );
		// Sort needed because of different methods if creating the arrays,
		// only the content matters.
		assert.deepEqual( groups.sort(), mw.config.get( 'wgwiki_userGroups' ).sort(), 'Array contains all groups, just like wgwiki_userGroups' );
		QUnit.start();
	});
});

QUnit.asyncTest( 'getRights', 1, function ( assert ) {
	mw.wiki_user.getRights( function ( rights ) {
		// First group should always be '*'
		assert.equal( $.type( rights ), 'array', 'Callback gets an array' );
		QUnit.start();
	});
});

}( mediaWiki ) );
