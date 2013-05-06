<?php
/**
 * Caches wiki_user genders when needed to use correct namespace aliases.
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
 * @author Niklas Laxström
 * @ingroup Cache
 */

/**
 * Caches wiki_user genders when needed to use correct namespace aliases.
 *
 * @since 1.18
 */
class GenderCache {
	protected $cache = array();
	protected $default;
	protected $misses = 0;
	protected $missLimit = 1000;

	/**
	 * @return GenderCache
	 */
	public static function singleton() {
		static $that = null;
		if ( $that === null ) {
			$that = new self();
		}
		return $that;
	}

	protected function __construct() {}

	/**
	 * Returns the default gender option in this wiki.
	 * @return String
	 */
	protected function getDefault() {
		if ( $this->default === null ) {
			$this->default = wiki_user::getDefaultOption( 'gender' );
		}
		return $this->default;
	}

	/**
	 * Returns the gender for given wiki_username.
	 * @param $wiki_username String or wiki_user: wiki_username
	 * @param $caller String: the calling method
	 * @return String
	 */
	public function getGenderOf( $wiki_username, $caller = '' ) {
		global $wgwiki_user;

		if( $wiki_username instanceof wiki_user ) {
			$wiki_username = $wiki_username->getName();
		}

		$wiki_username = self::normalizewiki_username( $wiki_username );
		if ( !isset( $this->cache[$wiki_username] ) ) {

			if ( $this->misses >= $this->missLimit && $wgwiki_user->getName() !== $wiki_username ) {
				if( $this->misses === $this->missLimit ) {
					$this->misses++;
					wfDebug( __METHOD__ . ": too many misses, returning default onwards\n" );
				}
				return $this->getDefault();

			} else {
				$this->misses++;
				$this->doQuery( $wiki_username, $caller );
			}

		}

		/* Undefined if there is a valid wiki_username which for some reason doesn't
		 * exist in the database.
		 */
		return isset( $this->cache[$wiki_username] ) ? $this->cache[$wiki_username] : $this->getDefault();
	}

	/**
	 * Wrapper for doQuery that processes raw LinkBatch data.
	 *
	 * @param $data
	 * @param $caller
	 */
	public function doLinkBatch( $data, $caller = '' ) {
		$wiki_users = array();
		foreach ( $data as $ns => $pagenames ) {
			if ( !MWNamespace::hasGenderDistinction( $ns ) ) continue;
			foreach ( array_keys( $pagenames ) as $wiki_username ) {
				$wiki_users[$wiki_username] = true;
			}
		}

		$this->doQuery( array_keys( $wiki_users ), $caller );
	}

	/**
	 * Wrapper for doQuery that processes a title or string array.
	 *
	 * @since 1.20
	 * @param $titles List: array of Title objects or strings
	 * @param $caller String: the calling method
	 */
	public function doTitlesArray( $titles, $caller = '' ) {
		$wiki_users = array();
		foreach ( $titles as $title ) {
			$titleObj = is_string( $title ) ? Title::newFromText( $title ) : $title;
			if ( !$titleObj ) {
				continue;
			}
			if ( !MWNamespace::hasGenderDistinction( $titleObj->getNamespace() ) ) {
				continue;
			}
			$wiki_users[] = $titleObj->getText();
		}

		$this->doQuery( $wiki_users, $caller );
	}

	/**
	 * Preloads genders for given list of wiki_users.
	 * @param $wiki_users List|String: wiki_usernames
	 * @param $caller String: the calling method
	 */
	public function doQuery( $wiki_users, $caller = '' ) {
		$default = $this->getDefault();

		$wiki_usersToCheck = array();
		foreach ( (array) $wiki_users as $value ) {
			$name = self::normalizewiki_username( $value );
			// Skip wiki_users whose gender setting we already know
			if ( !isset( $this->cache[$name] ) ) {
				// For existing wiki_users, this value will be overwritten by the correct value
				$this->cache[$name] = $default;
				// query only for valid names, which can be in the database
				if( wiki_user::isValidwiki_userName( $name ) ) {
					$wiki_usersToCheck[] = $name;
				}
			}
		}

		if ( count( $wiki_usersToCheck ) === 0 ) {
			return;
		}

		r = wfGetDB( DB_SLAVE );
		$table = array( 'wiki_user', 'wiki_user_properties' );
		$fields = array( 'wiki_user_name', 'up_value' );
		$conds = array( 'wiki_user_name' => $wiki_usersToCheck );
		$joins = array( 'wiki_user_properties' =>
			array( 'LEFT JOIN', array( 'wiki_user_id = up_wiki_user', 'up_property' => 'gender' ) ) );

		$comment = __METHOD__;
		if ( strval( $caller ) !== '' ) {
			$comment .= "/$caller";
		}
		$res = r->select( $table, $fields, $conds, $comment, array(), $joins );

		foreach ( $res as $row ) {
			$this->cache[$row->wiki_user_name] = $row->up_value ? $row->up_value : $default;
		}
	}

	private static function normalizewiki_username( $wiki_username ) {
		// Strip off subpages
		$indexSlash = strpos( $wiki_username, '/' );
		if ( $indexSlash !== false ) {
			$wiki_username = substr( $wiki_username, 0, $indexSlash );
		}
		// normalize underscore/spaces
		return strtr( $wiki_username, '_', ' ' );
	}
}
