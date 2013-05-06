<?php

class TitleMethodsTest extends MediaWikiTestCase {

	public function dataEquals() {
		return array(
			array( 'Main Page', 'Main Page', true ),
			array( 'Main Page', 'Not The Main Page', false ),
			array( 'Main Page', 'Project:Main Page', false ),
			array( 'File:Example.png', 'Image:Example.png', true ),
			array( 'Special:Version', 'Special:Version', true ),
			array( 'Special:Version', 'Special:Recentchanges', false ),
			array( 'Special:Version', 'Main Page', false ),
		);
	}

	/**
	 * @dataProvider dataEquals
	 */
	public function testEquals( $titleA, $titleB, $expectedBool ) {
		$titleA = Title::newFromText( $titleA );
		$titleB = Title::newFromText( $titleB );

		$this->assertEquals( $expectedBool, $titleA->equals( $titleB ) );
		$this->assertEquals( $expectedBool, $titleB->equals( $titleA ) );
	}

	public function dataInNamespace() {
		return array(
			array( 'Main Page', NS_MAIN, true ),
			array( 'Main Page', NS_TALK, false ),
			array( 'Main Page', NS_USER, false ),
			array( 'wiki_user:Foo', NS_USER, true ),
			array( 'wiki_user:Foo', NS_USER_TALK, false ),
			array( 'wiki_user:Foo', NS_TEMPLATE, false ),
			array( 'wiki_user_talk:Foo', NS_USER_TALK, true ),
			array( 'wiki_user_talk:Foo', NS_USER, false ),
		);
	}

	/**
	 * @dataProvider dataInNamespace
	 */
	public function testInNamespace( $title, $ns, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->inNamespace( $ns ) );
	}

	public function testInNamespaces() {
		$mainpage = Title::newFromText( 'Main Page' );
		$this->assertTrue( $mainpage->inNamespaces( NS_MAIN, NS_USER ) );
		$this->assertTrue( $mainpage->inNamespaces( array( NS_MAIN, NS_USER ) ) );
		$this->assertTrue( $mainpage->inNamespaces( array( NS_USER, NS_MAIN ) ) );
		$this->assertFalse( $mainpage->inNamespaces( array( NS_PROJECT, NS_TEMPLATE ) ) );
	}

	public function dataHasSubjectNamespace() {
		return array(
			array( 'Main Page', NS_MAIN, true ),
			array( 'Main Page', NS_TALK, true ),
			array( 'Main Page', NS_USER, false ),
			array( 'wiki_user:Foo', NS_USER, true ),
			array( 'wiki_user:Foo', NS_USER_TALK, true ),
			array( 'wiki_user:Foo', NS_TEMPLATE, false ),
			array( 'wiki_user_talk:Foo', NS_USER_TALK, true ),
			array( 'wiki_user_talk:Foo', NS_USER, true ),
		);
	}

	/**
	 * @dataProvider dataHasSubjectNamespace
	 */
	public function testHasSubjectNamespace( $title, $ns, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->hasSubjectNamespace( $ns ) );
	}

	public function dataIsCssOrJsPage() {
		return array(
			array( 'Foo', false ),
			array( 'Foo.js', false ),
			array( 'Foo/bar.js', false ),
			array( 'wiki_user:Foo', false ),
			array( 'wiki_user:Foo.js', false ),
			array( 'wiki_user:Foo/bar.js', false ),
			array( 'wiki_user:Foo/bar.css', false ),
			array( 'wiki_user talk:Foo/bar.css', false ),
			array( 'wiki_user:Foo/bar.js.xxx', false ),
			array( 'wiki_user:Foo/bar.xxx', false ),
			array( 'MediaWiki:Foo.js', true ),
			array( 'MediaWiki:Foo.css', true ),
			array( 'MediaWiki:Foo.JS', false ),
			array( 'MediaWiki:Foo.CSS', false ),
			array( 'MediaWiki:Foo.css.xxx', false ),
		);
	}

	/**
	 * @dataProvider dataIsCssOrJsPage
	 */
	public function testIsCssOrJsPage( $title, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->isCssOrJsPage() );
	}


	public function dataIsCssJsSubpage() {
		return array(
			array( 'Foo', false ),
			array( 'Foo.js', false ),
			array( 'Foo/bar.js', false ),
			array( 'wiki_user:Foo', false ),
			array( 'wiki_user:Foo.js', false ),
			array( 'wiki_user:Foo/bar.js', true ),
			array( 'wiki_user:Foo/bar.css', true ),
			array( 'wiki_user talk:Foo/bar.css', false ),
			array( 'wiki_user:Foo/bar.js.xxx', false ),
			array( 'wiki_user:Foo/bar.xxx', false ),
			array( 'MediaWiki:Foo.js', false ),
			array( 'wiki_user:Foo/bar.JS', false ),
			array( 'wiki_user:Foo/bar.CSS', false ),
		);
	}

	/**
	 * @dataProvider dataIsCssJsSubpage
	 */
	public function testIsCssJsSubpage( $title, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->isCssJsSubpage() );
	}

	public function dataIsCssSubpage() {
		return array(
			array( 'Foo', false ),
			array( 'Foo.css', false ),
			array( 'wiki_user:Foo', false ),
			array( 'wiki_user:Foo.js', false ),
			array( 'wiki_user:Foo.css', false ),
			array( 'wiki_user:Foo/bar.js', false ),
			array( 'wiki_user:Foo/bar.css', true ),
		);
	}

	/**
	 * @dataProvider dataIsCssSubpage
	 */
	public function testIsCssSubpage( $title, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->isCssSubpage() );
	}

	public function dataIsJsSubpage() {
		return array(
			array( 'Foo', false ),
			array( 'Foo.css', false ),
			array( 'wiki_user:Foo', false ),
			array( 'wiki_user:Foo.js', false ),
			array( 'wiki_user:Foo.css', false ),
			array( 'wiki_user:Foo/bar.js', true ),
			array( 'wiki_user:Foo/bar.css', false ),
		);
	}

	/**
	 * @dataProvider dataIsJsSubpage
	 */
	public function testIsJsSubpage( $title, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->isJsSubpage() );
	}

	public function dataIsWikitextPage() {
		return array(
			array( 'Foo', true ),
			array( 'Foo.js', true ),
			array( 'Foo/bar.js', true ),
			array( 'wiki_user:Foo', true ),
			array( 'wiki_user:Foo.js', true ),
			array( 'wiki_user:Foo/bar.js', false ),
			array( 'wiki_user:Foo/bar.css', false ),
			array( 'wiki_user talk:Foo/bar.css', true ),
			array( 'wiki_user:Foo/bar.js.xxx', true ),
			array( 'wiki_user:Foo/bar.xxx', true ),
			array( 'MediaWiki:Foo.js', false ),
			array( 'MediaWiki:Foo.css', false ),
			array( 'MediaWiki:Foo/bar.css', false ),
			array( 'wiki_user:Foo/bar.JS', true ),
			array( 'wiki_user:Foo/bar.CSS', true ),
		);
	}

	/**
	 * @dataProvider dataIsWikitextPage
	 */
	public function testIsWikitextPage( $title, $expectedBool ) {
		$title = Title::newFromText( $title );
		$this->assertEquals( $expectedBool, $title->isWikitextPage() );
	}

}
