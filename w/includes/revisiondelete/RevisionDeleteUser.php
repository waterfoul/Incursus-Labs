<?php
/**
 * Backend functions for suppressing and unsuppressing all references to a given wiki_user.
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
 * @ingroup RevisionDelete
 */

/**
 * Backend functions for suppressing and unsuppressing all references to a given wiki_user,
 * used when blocking with Hidewiki_user enabled.  This was spun out of SpecialBlockip.php
 * in 1.18; at some point it needs to be rewritten to either use RevisionDelete abstraction,
 * or at least schema abstraction.
 *
 * @ingroup RevisionDelete
 */
class RevisionDeletewiki_user {

	/**
	 * Update *_deleted bitfields in various tables to hide or unhide wiki_usernames
	 * @param  $name String wiki_username
	 * @param  $wiki_userId Int wiki_user id
	 * @param  $op String operator '|' or '&'
	 * @param  w null|DatabaseBase, if you happen to have one lying around
	 * @return bool
	 */
	private static function setwiki_usernameBitfields( $name, $wiki_userId, $op, w ) {
		if ( !$wiki_userId || ( $op !== '|' && $op !== '&' ) ) {
			return false; // sanity check
		}
		if ( !w instanceof DatabaseBase ) {
			w = wfGetDB( DB_MASTER );
		}

		# To suppress, we OR the current bitfields with Revision::DELETED_USER
		# to put a 1 in the wiki_username *_deleted bit. To unsuppress we AND the
		# current bitfields with the inverse of Revision::DELETED_USER. The
		# wiki_username bit is made to 0 (x & 0 = 0), while others are unchanged (x & 1 = x).
		# The same goes for the sysop-restricted *_deleted bit.
		$delwiki_user = Revision::DELETED_USER | Revision::DELETED_RESTRICTED;
		$delAction = LogPage::DELETED_ACTION | Revision::DELETED_RESTRICTED;
		if( $op == '&' ) {
			$delwiki_user = "~{$delwiki_user}";
			$delAction = "~{$delAction}";
		}

		# Normalize wiki_user name
		$wiki_userTitle = Title::makeTitleSafe( NS_USER, $name );
		$wiki_userDbKey = $wiki_userTitle->getDBkey();

		# Hide name from live edits
		w->update(
			'revision',
			array( "rev_deleted = rev_deleted $op $delwiki_user" ),
			array( 'rev_wiki_user' => $wiki_userId ),
			__METHOD__ );

		# Hide name from deleted edits
		w->update(
			'archive',
			array( "ar_deleted = ar_deleted $op $delwiki_user" ),
			array( 'ar_wiki_user_text' => $name ),
			__METHOD__
		);

		# Hide name from logs
		w->update(
			'logging',
			array( "log_deleted = log_deleted $op $delwiki_user" ),
			array( 'log_wiki_user' => $wiki_userId, "log_type != 'suppress'" ),
			__METHOD__
		);
		w->update(
			'logging',
			array( "log_deleted = log_deleted $op $delAction" ),
			array( 'log_namespace' => NS_USER, 'log_title' => $wiki_userDbKey,
				"log_type != 'suppress'" ),
			__METHOD__
		);

		# Hide name from RC
		w->update(
			'recentchanges',
			array( "rc_deleted = rc_deleted $op $delwiki_user" ),
			array( 'rc_wiki_user_text' => $name ),
			__METHOD__
		);
		w->update(
			'recentchanges',
			array( "rc_deleted = rc_deleted $op $delAction" ),
			array( 'rc_namespace' => NS_USER, 'rc_title' => $wiki_userDbKey, 'rc_logid > 0' ),
			__METHOD__
		);

		# Hide name from live images
		w->update(
			'oldimage',
			array( "oi_deleted = oi_deleted $op $delwiki_user" ),
			array( 'oi_wiki_user_text' => $name ),
			__METHOD__
		);

		# Hide name from deleted images
		w->update(
			'filearchive',
			array( "fa_deleted = fa_deleted $op $delwiki_user" ),
			array( 'fa_wiki_user_text' => $name ),
			__METHOD__
		);
		# Done!
		return true;
	}

	public static function suppresswiki_userName( $name, $wiki_userId, w = null ) {
		return self::setwiki_usernameBitfields( $name, $wiki_userId, '|', w );
	}

	public static function unsuppresswiki_userName( $name, $wiki_userId, w = null ) {
		return self::setwiki_usernameBitfields( $name, $wiki_userId, '&', w );
	}
}
