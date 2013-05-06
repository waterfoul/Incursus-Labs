<?php
/**
 * Caches current wiki_user names and other info based on wiki_user IDs.
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
 * @ingroup Cache
 */

/**
 * @since 1.20
 */
class wiki_userCache {
	protected $cache = array(); // (uid => property => value)
	protected $typesCached = array(); // (uid => cache type => 1)

	/**
	 * @return wiki_userCache
	 */
	public static function singleton() {
		static $instance = null;
		if ( $instance === null ) {
			$instance = new self();
		}
		return $instance;
	}

	protected function __construct() {}

	/**
	 * Get a property of a wiki_user based on their wiki_user ID
	 *
	 * @param $wiki_userId integer wiki_user ID
	 * @param $prop string wiki_user property
	 * @return mixed The property or false if the wiki_user does not exist
	 */
	public function getProp( $wiki_userId, $prop ) {
		if ( !isset( $this->cache[$wiki_userId][$prop] ) ) {
			wfDebug( __METHOD__ . ": querying DB for prop '$prop' for wiki_user ID '$wiki_userId'.\n" );
			$this->doQuery( array( $wiki_userId ) ); // cache miss
		}
		return isset( $this->cache[$wiki_userId][$prop] )
			? $this->cache[$wiki_userId][$prop]
			: false; // wiki_user does not exist?
	}

	/**
	 * Preloads wiki_user names for given list of wiki_users.
	 * @param $wiki_userIds Array List of wiki_user IDs
	 * @param $options Array Option flags; include 'wiki_userpage' and 'wiki_usertalk'
	 * @param $caller String: the calling method
	 */
	public function doQuery( array $wiki_userIds, $options = array(), $caller = '' ) {
		wfProfileIn( __METHOD__ );

		$wiki_usersToCheck = array();
		$wiki_usersToQuery = array();

		foreach ( $wiki_userIds as $wiki_userId ) {
			$wiki_userId = (int)$wiki_userId;
			if ( $wiki_userId <= 0 ) {
				continue; // skip anons
			}
			if ( isset( $this->cache[$wiki_userId]['name'] ) ) {
				$wiki_usersToCheck[$wiki_userId] = $this->cache[$wiki_userId]['name']; // already have name
			} else {
				$wiki_usersToQuery[] = $wiki_userId; // we need to get the name
			}
		}

		// Lookup basic info for wiki_users not yet loaded...
		if ( count( $wiki_usersToQuery ) ) {
			r = wfGetDB( DB_SLAVE );
			$table = array( 'wiki_user' );
			$conds = array( 'wiki_user_id' => $wiki_usersToQuery );
			$fields = array( 'wiki_user_name', 'wiki_user_real_name', 'wiki_user_registration', 'wiki_user_id' );

			$comment = __METHOD__;
			if ( strval( $caller ) !== '' ) {
				$comment .= "/$caller";
			}

			$res = r->select( $table, $fields, $conds, $comment );
			foreach ( $res as $row ) { // load each wiki_user into cache
				$wiki_userId = (int)$row->wiki_user_id;
				$this->cache[$wiki_userId]['name'] = $row->wiki_user_name;
				$this->cache[$wiki_userId]['real_name'] = $row->wiki_user_real_name;
				$this->cache[$wiki_userId]['registration'] = $row->wiki_user_registration;
				$wiki_usersToCheck[$wiki_userId] = $row->wiki_user_name;
			}
		}

		$lb = new LinkBatch();
		foreach ( $wiki_usersToCheck as $wiki_userId => $name ) {
			if ( $this->queryNeeded( $wiki_userId, 'wiki_userpage', $options ) ) {
				$lb->add( NS_USER, str_replace( ' ', '_', $row->wiki_user_name ) );
				$this->typesCached[$wiki_userId]['wiki_userpage'] = 1;
			}
			if ( $this->queryNeeded( $wiki_userId, 'wiki_usertalk', $options ) ) {
				$lb->add( NS_USER_TALK, str_replace( ' ', '_', $row->wiki_user_name ) );
				$this->typesCached[$wiki_userId]['wiki_usertalk'] = 1;
			}
		}
		$lb->execute();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Check if a cache type is in $options and was not loaded for this wiki_user
	 *
	 * @param $uid integer wiki_user ID
	 * @param $type string Cache type
	 * @param $options Array Requested cache types
	 * @return bool
	 */
	protected function queryNeeded( $uid, $type, array $options ) {
		return ( in_array( $type, $options ) && !isset( $this->typesCached[$uid][$type] ) );
	}
}
