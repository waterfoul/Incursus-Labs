<?php
/**
 * Fix the wiki_user_registration field.
 * In particular, for values which are NULL, set them to the date of the first edit
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
 * Maintenance script that fixes the wiki_user_registration field.
 *
 * @ingroup Maintenance
 */
class Fixwiki_userRegistration extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Fix the wiki_user_registration field";
	}

	public function execute() {
		r = wfGetDB( DB_SLAVE );
		w = wfGetDB( DB_MASTER );

		// Get wiki_user IDs which need fixing
		$res = r->select( 'wiki_user', 'wiki_user_id', 'wiki_user_registration IS NULL', __METHOD__ );
		foreach ( $res as $row ) {
			$id = $row->wiki_user_id;
			// Get first edit time
			$timestamp = r->selectField( 'revision', 'MIN(rev_timestamp)', array( 'rev_wiki_user' => $id ), __METHOD__ );
			// Update
			if ( !empty( $timestamp ) ) {
				w->update( 'wiki_user', array( 'wiki_user_registration' => $timestamp ), array( 'wiki_user_id' => $id ), __METHOD__ );
				$this->output( "$id $timestamp\n" );
			} else {
				$this->output( "$id NULL\n" );
			}
		}
		$this->output( "\n" );
	}
}

$maintClass = "Fixwiki_userRegistration";
require_once( RUN_MAINTENANCE_IF_MAIN );
