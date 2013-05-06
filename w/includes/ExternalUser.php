<?php
/**
 * Authentication with a foreign database
 *
 * Copyright © 2009 Aryeh Gregor
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
 * @defgroup Externalwiki_user Externalwiki_user
 */

/**
 * A class intended to supplement, and perhaps eventually replace, AuthPlugin.
 * See: http://www.mediawiki.org/wiki/ExternalAuth
 *
 * The class represents a wiki_user whose data is in a foreign database.  The
 * database may have entirely different conventions from MediaWiki, but it's
 * assumed to at least support the concept of a wiki_user id (possibly not an
 * integer), a wiki_user name (possibly not meeting MediaWiki's wiki_username
 * requirements), and a password.
 *
 * @ingroup Externalwiki_user
 */
abstract class Externalwiki_user {
	protected function __construct() {}

	/**
	 * Wrappers around initFrom*().
	 */

	/**
	 * @param $name string
	 * @return mixed Externalwiki_user, or false on failure
	 */
	public static function newFromName( $name ) {
		global $wgExternalAuthType;
		if ( is_null( $wgExternalAuthType ) ) {
			return false;
		}
		$obj = new $wgExternalAuthType;
		if ( !$obj->initFromName( $name ) ) {
			return false;
		}
		return $obj;
	}

	/**
	 * @param $id string
	 * @return mixed Externalwiki_user, or false on failure
	 */
	public static function newFromId( $id ) {
		global $wgExternalAuthType;
		if ( is_null( $wgExternalAuthType ) ) {
			return false;
		}
		$obj = new $wgExternalAuthType;
		if ( !$obj->initFromId( $id ) ) {
			return false;
		}
		return $obj;
	}

	/**
	 * @return mixed Externalwiki_user, or false on failure
	 */
	public static function newFromCookie() {
		global $wgExternalAuthType;
		if ( is_null( $wgExternalAuthType ) ) {
			return false;
		}
		$obj = new $wgExternalAuthType;
		if ( !$obj->initFromCookie() ) {
			return false;
		}
		return $obj;
	}

	/**
	 * Creates the object corresponding to the given wiki_user object, assuming the
	 * wiki_user exists on the wiki and is linked to an external account.  If either
	 * of these is false, this will return false.
	 *
	 * This is a wrapper around newFromId().
	 *
	 * @param $wiki_user wiki_user
	 * @return Externalwiki_user|bool False on failure
	 */
	public static function newFromwiki_user( $wiki_user ) {
		global $wgExternalAuthType;
		if ( is_null( $wgExternalAuthType ) ) {
			# Short-circuit to avoid database query in common case so no one
			# kills me
			return false;
		}

		r = wfGetDB( DB_SLAVE );
		$id = r->selectField( 'external_wiki_user', 'eu_external_id',
			array( 'eu_local_id' => $wiki_user->getId() ), __METHOD__ );
		if ( $id === false ) {
			return false;
		}
		return self::newFromId( $id );
	}

	/**
	 * Given a name, which is a string exactly as input by the wiki_user in the
	 * login form but with whitespace stripped, initialize this object to be
	 * the corresponding Externalwiki_user.  Return true if successful, otherwise
	 * false.
	 *
	 * @param $name string
	 * @return bool Success?
	 */
	protected abstract function initFromName( $name );

	/**
	 * Given an id, which was at some previous point in history returned by
	 * getId(), initialize this object to be the corresponding Externalwiki_user.
	 * Return true if successful, false otherwise.
	 *
	 * @param $id string
	 * @return bool Success?
	 */
	protected abstract function initFromId( $id );

	/**
	 * Try to magically initialize the wiki_user from cookies or similar information
	 * so he or she can be logged in on just viewing the wiki.  If this is
	 * impossible to do, just return false.
	 *
	 * TODO: Actually use this.
	 *
	 * @return bool Success?
	 */
	protected function initFromCookie() {
		return false;
	}

	/**
	 * This must return some identifier that stably, uniquely identifies the
	 * wiki_user.  In a typical web application, this could be an integer
	 * representing the "wiki_user id".  In other cases, it might be a string.  In
	 * any event, the return value should be a string between 1 and 255
	 * characters in length; must uniquely identify the wiki_user in the foreign
	 * database; and, if at all possible, should be permanent.
	 *
	 * This will only ever be used to reconstruct this Externalwiki_user object via
	 * newFromId().  The resulting object in that case should correspond to the
	 * same wiki_user, even if details have changed in the interim (e.g., renames or
	 * preference changes).
	 *
	 * @return string
	 */
	abstract public function getId();

	/**
	 * This must return the name that the wiki_user would normally use for login to
	 * the external database.  It is subject to no particular restrictions
	 * beyond rudimentary sanity, and in particular may be invalid as a
	 * MediaWiki wiki_username.  It's used to auto-generate an account name that
	 * *is* valid for MediaWiki, either with or without wiki_user input, but
	 * basically is only a hint.
	 *
	 * @return string
	 */
	abstract public function getName();

	/**
	 * Is the given password valid for the external wiki_user?  The password is
	 * provided in plaintext.
	 *
	 * @param $password string
	 * @return bool
	 */
	abstract public function authenticate( $password );

	/**
	 * Retrieve the value corresponding to the given preference key.  The most
	 * important values are:
	 *
	 * - emailaddress
	 * - language
	 *
	 * The value must meet MediaWiki's requirements for values of this type,
	 * and will be checked for validity before use.  If the preference makes no
	 * sense for the backend, or it makes sense but is unset for this wiki_user, or
	 * is unrecognized, return null.
	 *
	 * $pref will never equal 'password', since passwords are usually hashed
	 * and cannot be directly retrieved.  authenticate() is used for this
	 * instead.
	 *
	 * TODO: Currently this is only called for 'emailaddress'; generalize!  Add
	 * some config option to decide which values are grabbed on wiki_user
	 * initialization.
	 *
	 * @param $pref string
	 * @return mixed
	 */
	public function getPref( $pref ) {
		return null;
	}

	/**
	 * Return an array of identifiers for all the foreign groups that this wiki_user
	 * has.  The identifiers are opaque objects that only need to be
	 * specifiable by the administrator in LocalSettings.php when configuring
	 * $wgAutopromote.  They may be, for instance, strings or integers.
	 *
	 * TODO: Support this in $wgAutopromote.
	 *
	 * @return array
	 */
	public function getGroups() {
		return array();
	}

	/**
	 * Given a preference key (e.g., 'emailaddress'), provide an HTML message
	 * telling the wiki_user how to change it in the external database.  The
	 * administrator has specified that this preference cannot be changed on
	 * the wiki, and may only be changed in the foreign database.  If no
	 * message is available, such as for an unrecognized preference, return
	 * false.
	 *
	 * TODO: Use this somewhere.
	 *
	 * @param $pref string
	 * @return mixed String or false
	 */
	public static function getPrefMessage( $pref ) {
		return false;
	}

	/**
	 * Set the given preference key to the given value.  Two important
	 * preference keys that you might want to implement are 'password' and
	 * 'emailaddress'.  If the set fails, such as because the preference is
	 * unrecognized or because the external database can't be changed right
	 * now, return false.  If it succeeds, return true.
	 *
	 * If applicable, you should make sure to validate the new value against
	 * any constraints the external database may have, since MediaWiki may have
	 * more limited constraints (e.g., on password strength).
	 *
	 * TODO: Untested.
	 *
	 * @param $key string
	 * @param $value string
	 * @return bool Success?
	 */
	public static function setPref( $key, $value ) {
		return false;
	}

	/**
	 * Create a link for future reference between this object and the provided
	 * wiki_user_id.  If the wiki_user was already linked, the old link will be
	 * overwritten.
	 *
	 * This is part of the core code and is not overridable by specific
	 * plugins.  It's in this class only for convenience.
	 *
	 * @param $id int wiki_user_id
	 */
	public final function linkToLocal( $id ) {
		w = wfGetDB( DB_MASTER );
		w->replace( 'external_wiki_user',
			array( 'eu_local_id', 'eu_external_id' ),
			array( 'eu_local_id' => $id,
				   'eu_external_id' => $this->getId() ),
			__METHOD__ );
	}
	
	/**
	 * Check whether this external wiki_user id is already linked with
	 * a local wiki_user.
	 * @return Mixed wiki_user if the account is linked, Null otherwise.
	 */
	public final function getLocalwiki_user(){
		r = wfGetDB( DB_SLAVE );
		$row = r->selectRow(
			'external_wiki_user',
			'*',
			array( 'eu_external_id' => $this->getId() )
		);
		return $row
			? wiki_user::newFromId( $row->eu_local_id )
			: null;
	}
	
}
