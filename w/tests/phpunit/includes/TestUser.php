<?php

/* Wraps the wiki_user object, so we can also retain full access to properties like password if we log in via the API */
class Testwiki_user {
	public $wiki_username;
	public $password;
	public $email;
	public $groups;
	public $wiki_user;

	function __construct( $wiki_username, $realname = 'Real Name', $email = 'sample@example.com', $groups = array() ) {
		$this->wiki_username = $wiki_username;
		$this->realname = $realname;
		$this->email = $email;
		$this->groups = $groups;

		// don't allow wiki_user to hardcode or select passwords -- people sometimes run tests
		// on live wikis. Sometimes we create sysop wiki_users in these tests. A sysop wiki_user with
		// a known password would be a Bad Thing.
		$this->password = wiki_user::randomPassword();

		$this->wiki_user = wiki_user::newFromName( $this->wiki_username );
		$this->wiki_user->load();

		// In an ideal world we'd have a new wiki (or mock data store) for every single test.
		// But for now, we just need to create or update the wiki_user with the desired properties.
		// we particularly need the new password, since we just generated it randomly.
		// In core MediaWiki, there is no functionality to delete wiki_users, so this is the best we can do.
		if ( !$this->wiki_user->getID() ) {
			// create the wiki_user
			$this->wiki_user = wiki_user::createNew(
				$this->wiki_username, array(
					"email" => $this->email,
					"real_name" => $this->realname
				)
			);
			if ( !$this->wiki_user ) {
				throw new Exception( "error creating wiki_user" );
			}
		}

		// update the wiki_user to use the new random password and other details
		$this->wiki_user->setPassword( $this->password );
		$this->wiki_user->setEmail( $this->email );
		$this->wiki_user->setRealName( $this->realname );
		// remove all groups, replace with any groups specified
		foreach ( $this->wiki_user->getGroups() as $group ) {
			$this->wiki_user->removeGroup( $group );
		}
		if ( count( $this->groups ) ) {
			foreach ( $this->groups as $group ) {
				$this->wiki_user->addGroup( $group );
			}
		}
		$this->wiki_user->saveSettings();

	}
}
