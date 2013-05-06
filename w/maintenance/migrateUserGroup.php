<?php
/**
 * Re-assign wiki_users from an old group to a new one
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
 * Maintenance script that re-assigns wiki_users from an old group to a new one.
 *
 * @ingroup Maintenance
 */
class Migratewiki_userGroup extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Re-assign wiki_users from an old group to a new one";
		$this->addArg( 'oldgroup', 'Old wiki_user group key', true );
		$this->addArg( 'newgroup', 'New wiki_user group key', true );
		$this->setBatchSize( 200 );
	}

	public function execute() {
		$count = 0;
		$oldGroup = $this->getArg( 0 );
		$newGroup = $this->getArg( 1 );
		w = wfGetDB( DB_MASTER );
		$start = w->selectField( 'wiki_user_groups', 'MIN(ug_wiki_user)',
			array( 'ug_group' => $oldGroup ), __FUNCTION__ );
		$end = w->selectField( 'wiki_user_groups', 'MAX(ug_wiki_user)',
			array( 'ug_group' => $oldGroup ), __FUNCTION__ );
		if ( $start === null ) {
			$this->error( "Nothing to do - no wiki_users in the '$oldGroup' group", true );
		}
		# Do remaining chunk
		$end += $this->mBatchSize - 1;
		$blockStart = $start;
		$blockEnd = $start + $this->mBatchSize - 1;
		// Migrate wiki_users over in batches...
		while ( $blockEnd <= $end ) {
			$this->output( "Doing wiki_users $blockStart to $blockEnd\n" );
			w->begin( __METHOD__ );
			w->update( 'wiki_user_groups',
				array( 'ug_group' => $newGroup ),
				array( 'ug_group' => $oldGroup,
					"ug_wiki_user BETWEEN $blockStart AND $blockEnd" ),
				__METHOD__,
				array( 'IGNORE' )
			);
			$count += w->affectedRows();
			w->delete( 'wiki_user_groups',
				array( 'ug_group' => $oldGroup,
					"ug_wiki_user BETWEEN $blockStart AND $blockEnd" ),
				__METHOD__
			);
			$count += w->affectedRows();
			w->commit( __METHOD__ );
			$blockStart += $this->mBatchSize;
			$blockEnd += $this->mBatchSize;
			wfWaitForSlaves();
		}
		$this->output( "Done! $count wiki_user(s) in group '$oldGroup' are now in '$newGroup' instead.\n" );
	}
}

$maintClass = "Migratewiki_userGroup";
require_once( RUN_MAINTENANCE_IF_MAIN );
