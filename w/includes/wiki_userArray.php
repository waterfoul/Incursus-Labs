<?php
/**
 * Classes to walk into a list of wiki_user objects.
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

abstract class wiki_userArray implements Iterator {
	/**
	 * @param $res ResultWrapper
	 * @return wiki_userArrayFromResult
	 */
	static function newFromResult( $res ) {
		$wiki_userArray = null;
		if ( !wfRunHooks( 'wiki_userArrayFromResult', array( &$wiki_userArray, $res ) ) ) {
			return null;
		}
		if ( $wiki_userArray === null ) {
			$wiki_userArray = self::newFromResult_internal( $res );
		}
		return $wiki_userArray;
	}

	/**
	 * @param $ids array
	 * @return wiki_userArrayFromResult
	 */
	static function newFromIDs( $ids ) {
		$ids = array_map( 'intval', (array)$ids ); // paranoia
		if ( !$ids ) {
			// Database::select() doesn't like empty arrays
			return new ArrayIterator(array());
		}
		r = wfGetDB( DB_SLAVE );
		$res = r->select( 'wiki_user', '*', array( 'wiki_user_id' => $ids ),
			__METHOD__ );
		return self::newFromResult( $res );
	}

	/**
	 * @param $res
	 * @return wiki_userArrayFromResult
	 */
	protected static function newFromResult_internal( $res ) {
		return new wiki_userArrayFromResult( $res );
	}
}

class wiki_userArrayFromResult extends wiki_userArray {

	/**
	 * @var ResultWrapper
	 */
	var $res;
	var $key, $current;

	/**
	 * @param $res ResultWrapper
	 */
	function __construct( $res ) {
		$this->res = $res;
		$this->key = 0;
		$this->setCurrent( $this->res->current() );
	}

	/**
	 * @param  $row
	 * @return void
	 */
	protected function setCurrent( $row ) {
		if ( $row === false ) {
			$this->current = false;
		} else {
			$this->current = wiki_user::newFromRow( $row );
		}
	}

	/**
	 * @return int
	 */
	public function count() {
		return $this->res->numRows();
	}

	/**
	 * @return wiki_user
	 */
	function current() {
		return $this->current;
	}

	function key() {
		return $this->key;
	}

	function next() {
		$row = $this->res->next();
		$this->setCurrent( $row );
		$this->key++;
	}

	function rewind() {
		$this->res->rewind();
		$this->key = 0;
		$this->setCurrent( $this->res->current() );
	}

	/**
	 * @return bool
	 */
	function valid() {
		return $this->current !== false;
	}
}
