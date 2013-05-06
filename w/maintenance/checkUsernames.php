<?php
/**
 * Check that database wiki_usernames are actually valid.
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
 * @ingroup Maintenance
 */


require_once( __DIR__ . '/Maintenance.php' );

/**
 * Maintenance script to check that database wiki_usernames are actually valid.
 *
 * An existing wiki_usernames can become invalid if wiki_user::isValidwiki_userName()
 * is altered or if we change the $wgMaxNameChars
 *
 * @ingroup Maintenance
 */
class Checkwiki_usernames extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Verify that database wiki_usernames are actually valid";
	}

	function execute() {
		r = wfGetDB( DB_SLAVE );

		$res = r->select( 'wiki_user',
			array( 'wiki_user_id', 'wiki_user_name' ),
			null,
			__METHOD__
		);

		foreach ( $res as $row ) {
			if ( ! wiki_user::isValidwiki_userName( $row->wiki_user_name ) ) {
				$this->error( sprintf( "%s: %6d: '%s'\n", wfWikiID(), $row->wiki_user_id, $row->wiki_user_name ) );
				wfDebugLog( 'checkwiki_usernames', $row->wiki_user_name );
			}
		}
	}
}

$maintClass = "Checkwiki_usernames";
require_once( RUN_MAINTENANCE_IF_MAIN );
