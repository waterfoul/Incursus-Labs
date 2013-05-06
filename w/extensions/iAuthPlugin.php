<?php

    /* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

    /**
     * AuthPlugin converted into a interface. I left the original header
     * because the changes I made were very minor.
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
     * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
     * http://www.gnu.org/copyleft/gpl.html
     *
     * @package MediaWiki
     * @subpackage Auth_PHPBB
     * @author Nicholas Dunnaway
     * @copyright 2007 php|uber.leet
     * @license http://www.gnu.org/copyleft/gpl.html
     * @CVS: $Id: iAuthPlugin.php,v 1.0.0 2007/10/01 16:46:22 nkd Exp $
     * @link http://uber.leetphp.com
     * @version $Revision: 1.0.0 $
     *
     */


/**
 */
# Copyright (C) 2004 Brion Vibber <brion@pobox.com>
# http://www.mediawiki.org/
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 * Authentication plugin interface. Instantiate a subclass of AuthPlugin
 * and set $wgAuth to it to authenticate against some external tool.
 *
 * The default behavior is not to do anything, and use the local wiki_user
 * database for all authentication. A subclass can require that all
 * accounts authenticate externally, or use it only as a fallback; also
 * you can transparently create internal wiki accounts the first time
 * someone logs in who can be authenticated externally.
 *
 * This interface is new, and might change a bit before 1.4.0 final is
 * done...
 *
 */
interface iAuthPlugin {

	/**
	 * Check whether there exists a wiki_user account with the given name.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $wiki_username String: wiki_username.
	 * @return bool
	 * @public
	 */
	public function wiki_userExists( $wiki_username );

	/**
	 * Check if a wiki_username+password pair is a valid login.
	 * The name will be normalized to MediaWiki's requirements, so
	 * you might need to munge it (for instance, for lowercase initial
	 * letters).
	 *
	 * @param $wiki_username String: wiki_username.
	 * @param $password String: wiki_user password.
	 * @return bool
	 * @public
	 */
	public function authenticate( $wiki_username, $password );

	/**
	 * Modify options in the login template.
	 *
	 * @param $template wiki_userLoginTemplate object.
	 * @public
	 */
	public function modifyUITemplate( &$template );

	/**
	 * Set the domain this plugin is supposed to use when authenticating.
	 *
	 * @param $domain String: authentication domain.
	 * @public
	 */
	public function setDomain( $domain );

	/**
	 * Check to see if the specific domain is a valid domain.
	 *
	 * @param $domain String: authentication domain.
	 * @return bool
	 * @public
	 */
	public function validDomain( $domain );

	/**
	 * When a wiki_user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external wiki_user database.
	 *
	 * The wiki_user object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param wiki_user $wiki_user
	 * @public
	 */
	public function updatewiki_user( &$wiki_user );

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
	 * @return bool
	 * @public
	 */
	public function autoCreate();

	/**
	 * Can wiki_users change their passwords?
	 *
	 * @return bool
	 */
	public function allowPasswordChange();

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
	 * @public
	 */
	public function setPassword( $wiki_user, $password );

	/**
	 * Update wiki_user information in the external authentication database.
	 * Return true if successful.
	 *
	 * @param $wiki_user wiki_user object.
	 * @return bool
	 * @public
	 */
	public function updateExternalDB( $wiki_user );

	/**
	 * Check to see if external accounts can be created.
	 * Return true if external accounts can be created.
	 * @return bool
	 * @public
	 */
	public function canCreateAccounts();

	/**
	 * Add a wiki_user to the external authentication database.
	 * Return true if successful.
	 *
	 * @param wiki_user $wiki_user - only the name should be assumed valid at this point
	 * @param string $password
	 * @param string $email
	 * @param string $realname
	 * @return bool
	 * @public
	 */
	public function addwiki_user( $wiki_user, $password, $email='', $realname='' );

	/**
	 * Return true to prevent logins that don't authenticate here from being
	 * checked against the local database's password fields.
	 *
	 * This is just a question, and shouldn't perform any actions.
	 *
	 * @return bool
	 * @public
	 */
	public function strict();

	/**
	 * When creating a wiki_user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external wiki_user database.
	 *
	 * The wiki_user object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param $wiki_user wiki_user object.
	 * @param $autocreate bool True if wiki_user is being autocreated on login
	 * @public
	 */
	public function initwiki_user( &$wiki_user, $autocreate=false );

	/**
	 * If you want to munge the case of an account name before the final
	 * check, now is your chance.
	 */
	public function getCanonicalName( $wiki_username );
}

?>
