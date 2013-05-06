<?php
/**
 * Init the wiki_user_editcount database field based on the number of rows in the
 * revision table.
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

class InitEditCount extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addOption( 'quick', 'Force the update to be done in a single query' );
		$this->addOption( 'background', 'Force replication-friendly mode; may be inefficient but
		avoids locking tables or lagging slaves with large updates;
		calculates counts on a slave if possible.

Background mode will be automatically used if the server is MySQL 4.0
(which does not support subqueries) or if multiple servers are listed
in the load balancer, usually indicating a replication environment.' );
		$this->mDescription = "Batch-recalculate wiki_user_editcount fields from the revision table";
	}

	public function execute() {
		w = wfGetDB( DB_MASTER );
		$wiki_user = w->tableName( 'wiki_user' );
		$revision = w->tableName( 'revision' );

		ver = w->getServerVersion();

		// Autodetect mode...
		$backgroundMode = wfGetLB()->getServerCount() > 1 ||
			( w instanceof DatabaseMysql && version_compare( ver, '4.1' ) < 0 );

		if ( $this->hasOption( 'background' ) ) {
			$backgroundMode = true;
		} elseif ( $this->hasOption( 'quick' ) ) {
			$backgroundMode = false;
		}

		if ( $backgroundMode ) {
			$this->output( "Using replication-friendly background mode...\n" );

			r = wfGetDB( DB_SLAVE );
			$chunkSize = 100;
			$lastwiki_user = r->selectField( 'wiki_user', 'MAX(wiki_user_id)', '', __METHOD__ );

			$start = microtime( true );
			$migrated = 0;
			for ( $min = 0; $min <= $lastwiki_user; $min += $chunkSize ) {
				$max = $min + $chunkSize;
				$result = r->query(
					"SELECT
						wiki_user_id,
						COUNT(rev_wiki_user) AS wiki_user_editcount
					FROM $wiki_user
					LEFT OUTER JOIN $revision ON wiki_user_id=rev_wiki_user
					WHERE wiki_user_id > $min AND wiki_user_id <= $max
					GROUP BY wiki_user_id",
					__METHOD__ );

				foreach ( $result as $row ) {
					w->update( 'wiki_user',
						array( 'wiki_user_editcount' => $row->wiki_user_editcount ),
						array( 'wiki_user_id' => $row->wiki_user_id ),
						__METHOD__ );
					++$migrated;
				}

				$delta = microtime( true ) - $start;
				$rate = ( $delta == 0.0 ) ? 0.0 : $migrated / $delta;
				$this->output( sprintf( "%s %d (%0.1f%%) done in %0.1f secs (%0.3f accounts/sec).\n",
					wfWikiID(),
					$migrated,
					min( $max, $lastwiki_user ) / $lastwiki_user * 100.0,
					$delta,
					$rate ) );

				wfWaitForSlaves();
			}
		} else {
			// Subselect should work on modern MySQLs etc
			$this->output( "Using single-query mode...\n" );
			$sql = "UPDATE $wiki_user SET wiki_user_editcount=(SELECT COUNT(*) FROM $revision WHERE rev_wiki_user=wiki_user_id)";
			w->query( $sql );
		}

		$this->output( "Done!\n" );
	}
}

$maintClass = "InitEditCount";
require_once( RUN_MAINTENANCE_IF_MAIN );
