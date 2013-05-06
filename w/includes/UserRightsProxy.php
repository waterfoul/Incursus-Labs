<?php
/**
 * Representation of an wiki_user on a other locally-hosted wiki.
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
 * Cut-down copy of wiki_user interface for local-interwiki-database
 * wiki_user rights manipulation.
 */
class wiki_userRightsProxy {

	/**
	 * Constructor.
	 *
	 * @see newFromId()
	 * @see newFromName()
	 * @param  DatabaseBase: db connection
	 * @param $database String: database name
	 * @param $name String: wiki_user name
	 * @param $id Integer: wiki_user ID
	 */
	private function __construct( , $database, $name, $id ) {
		$this->db = ;
		$this->database = $database;
		$this->name = $name;
		$this->id = intval( $id );
		$this->newOptions = array();
	}

	/**
	 * Accessor for $this->database
	 *
	 * @return String: database name
	 */
	public function getDBName() {
		return $this->database;
	}

	/**
	 * Confirm the selected database name is a valid local interwiki database name.
	 *
	 * @param $database String: database name
	 * @return Boolean
	 */
	public static function validDatabase( $database ) {
		global $wgLocalDatabases;
		return in_array( $database, $wgLocalDatabases );
	}

	/**
	 * Same as wiki_user::whoIs()
	 *
	 * @param $database String: database name
	 * @param $id Integer: wiki_user ID
	 * @param $ignoreInvalidDB Boolean: if true, don't check if $database is in $wgLocalDatabases
	 * @return String: wiki_user name or false if the wiki_user doesn't exist
	 */
	public static function whoIs( $database, $id, $ignoreInvalidDB = false ) {
		$wiki_user = self::newFromId( $database, $id, $ignoreInvalidDB );
		if( $wiki_user ) {
			return $wiki_user->name;
		} else {
			return false;
		}
	}

	/**
	 * Factory function; get a remote wiki_user entry by ID number.
	 *
	 * @param $database String: database name
	 * @param $id Integer: wiki_user ID
	 * @param $ignoreInvalidDB Boolean: if true, don't check if $database is in $wgLocalDatabases
	 * @return wiki_userRightsProxy or null if doesn't exist
	 */
	public static function newFromId( $database, $id, $ignoreInvalidDB = false ) {
		return self::newFromLookup( $database, 'wiki_user_id', intval( $id ), $ignoreInvalidDB );
	}

	/**
	 * Factory function; get a remote wiki_user entry by name.
	 *
	 * @param $database String: database name
	 * @param $name String: wiki_user name
	 * @param $ignoreInvalidDB Boolean: if true, don't check if $database is in $wgLocalDatabases
	 * @return wiki_userRightsProxy or null if doesn't exist
	 */
	public static function newFromName( $database, $name, $ignoreInvalidDB = false ) {
		return self::newFromLookup( $database, 'wiki_user_name', $name, $ignoreInvalidDB );
	}

	/**
	 * @param $database
	 * @param $field
	 * @param $value
	 * @param $ignoreInvalidDB bool
	 * @return null|wiki_userRightsProxy
	 */
	private static function newFromLookup( $database, $field, $value, $ignoreInvalidDB = false ) {
		 = self::getDB( $database, $ignoreInvalidDB );
		if(  ) {
			$row = ->selectRow( 'wiki_user',
				array( 'wiki_user_id', 'wiki_user_name' ),
				array( $field => $value ),
				__METHOD__ );
			if( $row !== false ) {
				return new wiki_userRightsProxy( , $database,
					$row->wiki_user_name,
					intval( $row->wiki_user_id ) );
			}
		}
		return null;
	}

	/**
	 * Open a database connection to work on for the requested wiki_user.
	 * This may be a new connection to another database for remote wiki_users.
	 *
	 * @param $database String
	 * @param $ignoreInvalidDB Boolean: if true, don't check if $database is in $wgLocalDatabases
	 * @return DatabaseBase or null if invalid selection
	 */
	public static function getDB( $database, $ignoreInvalidDB = false ) {
		global $wgDBname;
		if( self::validDatabase( $database ) ) {
			if( $database == $wgDBname ) {
				// Hmm... this shouldn't happen though. :)
				return wfGetDB( DB_MASTER );
			} else {
				return wfGetDB( DB_MASTER, array(), $database );
			}
		}
		return null;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return bool
	 */
	public function isAnon() {
		return $this->getId() == 0;
	}

	/**
	 * Same as wiki_user::getName()
	 *
	 * @return String
	 */
	public function getName() {
		return $this->name . '@' . $this->database;
	}

	/**
	 * Same as wiki_user::getwiki_userPage()
	 *
	 * @return Title object
	 */
	public function getwiki_userPage() {
		return Title::makeTitle( NS_USER, $this->getName() );
	}

	/**
	 * Replaces wiki_user::getwiki_userGroups()
	 * @return array
	 */
	function getGroups() {
		$res = $this->db->select( 'wiki_user_groups',
			array( 'ug_group' ),
			array( 'ug_wiki_user' => $this->id ),
			__METHOD__ );
		$groups = array();
		foreach ( $res as $row ) {
			$groups[] = $row->ug_group;
		}
		return $groups;
	}

	/**
	 * Replaces wiki_user::addwiki_userGroup()
	 */
	function addGroup( $group ) {
		$this->db->insert( 'wiki_user_groups',
			array(
				'ug_wiki_user' => $this->id,
				'ug_group' => $group,
			),
			__METHOD__,
			array( 'IGNORE' ) );
	}

	/**
	 * Replaces wiki_user::removewiki_userGroup()
	 */
	function removeGroup( $group ) {
		$this->db->delete( 'wiki_user_groups',
			array(
				'ug_wiki_user' => $this->id,
				'ug_group' => $group,
			),
			__METHOD__ );
	}

	/**
	 * Replaces wiki_user::setOption()
	 */
	public function setOption( $option, $value ) {
		$this->newOptions[$option] = $value;
	}

	public function saveSettings() {
		$rows = array();
		foreach ( $this->newOptions as $option => $value ) {
			$rows[] = array(
				'up_wiki_user' => $this->id,
				'up_property' => $option,
				'up_value' => $value,
			);
		}
		$this->db->replace( 'wiki_user_properties',
			array( array( 'up_wiki_user', 'up_property' ) ),
			$rows, __METHOD__
		);
		$this->invalidateCache();
	}

	/**
	 * Replaces wiki_user::touchwiki_user()
	 */
	function invalidateCache() {
		$this->db->update( 'wiki_user',
			array( 'wiki_user_touched' => $this->db->timestamp() ),
			array( 'wiki_user_id' => $this->id ),
			__METHOD__ );

		global $wgMemc;
		$key = wfForeignMemcKey( $this->database, false, 'wiki_user', 'id', $this->id );
		$wgMemc->delete( $key );
	}
}
