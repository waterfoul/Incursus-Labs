<?php
/**
 * Authentication plugin interface
 *
 * Copyright © 2004 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * Authentication plugin interface. Instantiate a subclass of AuthPlugin
 * and set $wgAuth to it to authenticate against some external tool.
 *
 * The default behavior is not to do anything, and use the local wiki_user
 * database for all authentication. A subclass can require that all
 * accounts authenticate externally, or use it only as a fallback; also
 * you can transparently create internal wiki accounts the first time
 * someone logs in who can be authenticated externally.
 */
class AuthPlugin {

	/**
	 * @var string
	 */
	protected $domain;

	/**
	 * Check whether there exists a wiki_user account with the given name.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $wiki_username String: wiki_username.
	 * @return bool
	 */
	public function wiki_userExists( $wiki_username ) {
		# Override this!
		return false;
	}

	/**
	 * Check if a wiki_username+password pair is a valid login.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $wiki_username String: wiki_username.
	 * @param $password String: wiki_user password.
	 * @return bool
	 */
	public function authenticate( $wiki_username, $password ) {
		# Override this!
		return false;
	}

	/**
	 * Modify options in the login template.
	 *
	 * @param $template wiki_userLoginTemplate object.
	 * @param $type String 'signup' or 'login'. Added in 1.16.
	 */
	public function modifyUITemplate( &$template, &$type ) {
		# Override this!
		$template->set( 'usedomain', false );
	}

	/**
	 * Set the domain this plugin is supposed to use when authenticating.
	 *
	 * @param $domain String: authentication domain.
	 */
	public function setDomain( $domain ) {
		$this->domain = $domain;
	}

	/**
	 * Get the wiki_user's domain
	 *
	 * @return string
	 */
	public function getDomain() {
		if ( isset( $this->domain ) ) {
			return $this->domain;
		} else {
			return 'invaliddomain';
		}
	}

	/**
	 * Check to see if the specific domain is a valid domain.
	 *
	 * @param $domain String: authentication domain.
	 * @return bool
	 */
	public function validDomain( $domain ) {
		# Override this!
		return true;
	}

	/**
	 * When a wiki_user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external wiki_user database.
	 *
	 * The wiki_user object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param $wiki_user wiki_user object
	 * @return bool
	 */
	public function updatewiki_user( &$wiki_user ) {
		# Override this and do something
		return true;
	}

	/**
	 * Return true if the wiki should create a new local account automatically
	 * when asked to login a wiki_user who doesn't exist locally but does in the
	 * external auth database.
	 *
	 * If you don't automatically create accounts, you must still create
	 * accounts in some way. It's not possible to authenticate without
	 * a local account.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return Boolean
	 */
	public function autoCreate() {
		return false;
	}

	/**
	 * Allow a property change? Properties are the same as preferences
	 * and use the same keys. 'Realname' 'Emailaddress' and 'Nickname'
	 * all reference this.
	 *
	 * @param $prop string
	 *
	 * @return Boolean
	 */
	public function allowPropChange( $prop = '' ) {
		if ( $prop == 'realname' && is_callable( array( $this, 'allowRealNameChange' ) ) ) {
			return $this->allowRealNameChange();
		} elseif ( $prop == 'emailaddress' && is_callable( array( $this, 'allowEmailChange' ) ) ) {
			return $this->allowEmailChange();
		} elseif ( $prop == 'nickname' && is_callable( array( $this, 'allowNickChange' ) ) ) {
			return $this->allowNickChange();
		} else {
			return true;
		}
	}

	/**
	 * Can wiki_users change their passwords?
	 *
	 * @return bool
	 */
	public function allowPasswordChange() {
		return true;
	}

	/**
	 * Should MediaWiki store passwords in its local database?
	 *
	 * @return bool
	 */
	public function allowSetLocalPassword() {
		return true;
	}

	/**
	 * Set the given password in the authentication database.
	 * As a special case, the password may be set to null to request
	 * locking the password to an unusable value, with the expectation
	 * that it will be set later through a mail reset or other method.
	 *
	 * Return true if successful.
	 *
	 * @param $wiki_user wiki_user object.
	 * @param $password String: password.
	 * @return bool
	 */
	public function setPassword( $wiki_user, $password ) {
		return true;
	}

	/**
	 * Update wiki_user information in the external authentication database.
	 * Return true if successful.
	 *
	 * @param $wiki_user wiki_user object.
	 * @return Boolean
	 */
	public function updateExternalDB( $wiki_user ) {
		return true;
	}

	/**
	 * Check to see if external accounts can be created.
	 * Return true if external accounts can be created.
	 * @return Boolean
	 */
	public function canCreateAccounts() {
		return false;
	}

	/**
	 * Add a wiki_user to the external authentication database.
	 * Return true if successful.
	 *
	 * @param $wiki_user wiki_user: only the name should be assumed valid at this point
	 * @param $password String
	 * @param $email String
	 * @param $realname String
	 * @return Boolean
	 */
	public function addwiki_user( $wiki_user, $password, $email = '', $realname = '' ) {
		return true;
	}

	/**
	 * Return true to prevent logins that don't authenticate here from being
	 * checked against the local database's password fields.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return Boolean
	 */
	public function strict() {
		return false;
	}

	/**
	 * Check if a wiki_user should authenticate locally if the global authentication fails.
	 * If either this or strict() returns true, local authentication is not used.
	 *
	 * @param $wiki_username String: wiki_username.
	 * @return Boolean
	 */
	public function strictwiki_userAuth( $wiki_username ) {
		return false;
	}

	/**
	 * When creating a wiki_user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external wiki_user database.
	 *
	 * The wiki_user object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param $wiki_user wiki_user object.
	 * @param $autocreate Boolean: True if wiki_user is being autocreated on login
	 */
	public function initwiki_user( &$wiki_user, $autocreate = false ) {
		# Override this to do something.
	}

	/**
	 * If you want to munge the case of an account name before the final
	 * check, now is your chance.
	 * @param $wiki_username string
	 * @return string
	 */
	public function getCanonicalName( $wiki_username ) {
		return $wiki_username;
	}

	/**
	 * Get an instance of a wiki_user object
	 *
	 * @param $wiki_user wiki_user
	 *
	 * @return AuthPluginwiki_user
	 */
	public function getwiki_userInstance( wiki_user &$wiki_user ) {
		return new AuthPluginwiki_user( $wiki_user );
	}

	/**
	 * Get a list of domains (in HTMLForm options format) used.
	 *
	 * @return array
	 */
	public function domainList() {
		return array();
	}
}

class AuthPluginwiki_user {
	function __construct( $wiki_user ) {
		# Override this!
	}

	public function getId() {
		# Override this!
		return -1;
	}

	public function isLocked() {
		# Override this!
		return false;
	}

	public function isHidden() {
		# Override this!
		return false;
	}

	public function resetAuthToken() {
		# Override this!
		return true;
	}
}
