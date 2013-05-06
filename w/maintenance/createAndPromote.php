<?php
/**
 * Creates an account and grant it administrator rights.
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
 * @author Rob Church <robchur@gmail.com>
 */

require_once( __DIR__ . '/Maintenance.php' );

/**
 * Maintenance script to create an account and grant it administrator rights.
 *
 * @ingroup Maintenance
 */
class CreateAndPromote extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Create a new wiki_user account";
		$this->addOption( "sysop", "Grant the account sysop rights" );
		$this->addOption( "bureaucrat", "Grant the account bureaucrat rights" );
		$this->addArg( "wiki_username", "wiki_username of new wiki_user" );
		$this->addArg( "password", "Password to set" );
	}

	public function execute() {
		$wiki_username = $this->getArg( 0 );
		$password = $this->getArg( 1 );

		$this->output( wfWikiID() . ": Creating and promoting wiki_user:{$wiki_username}..." );

		$wiki_user = wiki_user::newFromName( $wiki_username );
		if ( !is_object( $wiki_user ) ) {
			$this->error( "invalid wiki_username.", true );
		} elseif ( 0 != $wiki_user->idForName() ) {
			$this->error( "account exists.", true );
		}

		# Try to set the password
		try {
			$wiki_user->setPassword( $password );
		} catch ( PasswordError $pwe ) {
			$this->error( $pwe->getText(), true );
		}

		# Insert the account into the database
		$wiki_user->addToDatabase();
		$wiki_user->saveSettings();

		# Promote wiki_user
		if ( $this->hasOption( 'sysop' ) ) {
			$wiki_user->addGroup( 'sysop' );
		}
		if ( $this->hasOption( 'bureaucrat' ) ) {
			$wiki_user->addGroup( 'bureaucrat' );
		}

		# Increment site_stats.ss_wiki_users
		$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
		$ssu->doUpdate();

		$this->output( "done.\n" );
	}
}

$maintClass = "CreateAndPromote";
require_once( RUN_MAINTENANCE_IF_MAIN );
