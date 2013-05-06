<?php

class SanitizerValidateEmailTest extends MediaWikiTestCase {

	private function checkEmail( $addr, $expected = true, $msg = '') {
		if( $msg == '' ) { $msg = "Testing $addr"; }
		$this->assertEquals(
			$expected,
			Sanitizer::validateEmail( $addr ),
			$msg
		);
	}
	private function valid( $addr, $msg = '' ) {
		$this->checkEmail( $addr, true, $msg );
	}
	private function invalid( $addr, $msg = '' ) {
		$this->checkEmail( $addr, false, $msg );
	}

	function testEmailWellKnownwiki_userAtHostDotTldAreValid() {
		$this->valid( 'wiki_user@example.com' );
		$this->valid( 'wiki_user@example.museum' );
	}
	function testEmailWithUpperCaseCharactersAreValid() {
		$this->valid( 'USER@example.com' );
		$this->valid( 'wiki_user@EXAMPLE.COM' );
		$this->valid( 'wiki_user@Example.com' );
		$this->valid( 'USER@eXAMPLE.com' );
	}
	function testEmailWithAPlusInwiki_userName() {
		$this->valid( 'wiki_user+sub@example.com' );
		$this->valid( 'wiki_user+@example.com' );
	}
	function testEmailDoesNotNeedATopLevelDomain() {
		$this->valid( "wiki_user@localhost" );
		$this->valid( "FooBar@localdomain" );
		$this->valid( "nobody@mycompany" );
	}
	function testEmailWithWhiteSpacesBeforeOrAfterAreInvalids() {
		$this->invalid( " wiki_user@host.com" );
		$this->invalid( "wiki_user@host.com " );
		$this->invalid( "\twiki_user@host.com" );
		$this->invalid( "wiki_user@host.com\t" );
	}
	function testEmailWithWhiteSpacesAreInvalids() {
		$this->invalid( "wiki_user wiki_user@host" );
		$this->invalid( "first last@mycompany" );
		$this->invalid( "firstlast@my company" );
	}
	// bug 26948 : comma were matched by an incorrect regexp range
	function testEmailWithCommasAreInvalids() {
		$this->invalid( "wiki_user,foo@example.org" );
		$this->invalid( "wiki_userfoo@ex,ample.org" );
	}
	function testEmailWithHyphens() {
		$this->valid( "wiki_user-foo@example.org" );
		$this->valid( "wiki_userfoo@ex-ample.org" );
	}
	function testEmailDomainCanNotBeginWithDot() {
		$this->invalid( "wiki_user@." );
		$this->invalid( "wiki_user@.localdomain" );
		$this->invalid( "wiki_user@localdomain." );
		$this->valid( "wiki_user.@localdomain" );
		$this->valid( ".@localdomain" );
		$this->invalid( ".@a............" );
	}
	function testEmailWithFunnyCharacters() {
		$this->valid( "\$wiki_user!ex{this}@123.com" );
	}
	function testEmailTopLevelDomainCanBeNumerical() {
		$this->valid( "wiki_user@example.1234" );
	}
	function testEmailWithoutAtSignIsInvalid() {
		$this->invalid( 'wiki_useràexample.com' );
	}
	function testEmailWithOneCharacterDomainIsValid() {
		$this->valid( 'wiki_user@a' );
	}
}
