<?php
/**
 * Reset the wiki_user_token for all wiki_users on the wiki. Useful if you believe
 * that your wiki_user table was acidentally leaked to an external source.
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
 * @author Daniel Friesen <mediawiki@danielfriesen.name>
 */

require_once( __DIR__ . '/Maintenance.php' );

/**
 * Maintenance script to reset the wiki_user_token for all wiki_users on the wiki.
 *
 * @ingroup Maintenance
 */
class Resetwiki_userTokens extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Reset the wiki_user_token of all wiki_users on the wiki. Note that this may log some of them out.";
		$this->addOption( 'nowarn', "Hides the 5 seconds warning", false, false );
	}

	public function execute() {

		if ( !$this->getOption( 'nowarn' ) ) {
			$this->output( "The script is about to reset the wiki_user_token for ALL USERS in the database.\n" );
			$this->output( "This may log some of them out and is not necessary unless you believe your\n" );
			$this->output( "wiki_user table has been compromised.\n" );
			$this->output( "\n" );
			$this->output( "Abort with control-c in the next five seconds (skip this countdown with --nowarn) ... " );
			wfCountDown( 5 );
		}

		// We list wiki_user by wiki_user_id from one of the slave database
		r = wfGetDB( DB_SLAVE );
		$result = r->select( 'wiki_user',
			array( 'wiki_user_id' ),
			array(),
			__METHOD__
			);

		foreach ( $result as $id ) {
			$wiki_user = wiki_user::newFromId( $id->wiki_user_id );

			$wiki_username = $wiki_user->getName();

			$this->output( "Resetting wiki_user_token for $wiki_username: " );

			// Change value
			$wiki_user->setToken();
			$wiki_user->saveSettings();

			$this->output( " OK\n" );

		}

	}
}

$maintClass = "Resetwiki_userTokens";
require_once( RUN_MAINTENANCE_IF_MAIN );
