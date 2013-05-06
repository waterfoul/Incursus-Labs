<?php
/**
 * Pick a database that has pending jobs
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
 * @todo Make this work on PostgreSQL and maybe other database servers
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/Maintenance.php' );

/**
 * Maintenance script that picks a database that has pending jobs.
 *
 * @ingroup Maintenance
 */
class nextJobDB extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pick a database that has pending jobs";
		$this->addOption( 'type', "The type of job to search for", false, true );
	}

	public function execute() {
		global $wgMemc;
		$type = $this->getOption( 'type', false );

		$memcKey = 'jobqueue:dbs:v2';
		$pendingDBs = $wgMemc->get( $memcKey );

		// If the cache entry wasn't present, or in 1% of cases otherwise,
		// regenerate the cache.
		if ( !$pendingDBs || mt_rand( 0, 100 ) == 0 ) {
			$pendingDBs = $this->getPendingDbs();
			$wgMemc->set( $memcKey, $pendingDBs, 300 );
		}

		if ( !$pendingDBs ) {
			return;
		}

		do {
			$again = false;

			if ( $type === false ) {
				$candidates = call_user_func_array( 'array_merge', $pendingDBs );
			} elseif ( isset( $pendingDBs[$type] ) ) {
				$candidates = $pendingDBs[$type];
			} else {
				$candidates = array();
			}
			if ( !$candidates ) {
				return;
			}

			$candidates = array_values( $candidates );
			 = $candidates[ mt_rand( 0, count( $candidates ) - 1 ) ];
			if ( !$this->checkJob( $type,  ) ) {
				// This job is not available in the current database. Remove it from
				// the cache.
				if ( $type === false ) {
					foreach ( $pendingDBs as $type2 => s ) {
						$pendingDBs[$type2] = array_diff( $pendingDBs[$type2], array(  ) );
					}
				} else {
					$pendingDBs[$type] = array_diff( $pendingDBs[$type], array(  ) );
				}

				$wgMemc->set( $memcKey, $pendingDBs, 300 );
				$again = true;
			}
		} while ( $again );

		$this->output(  . "\n" );
	}

	/**
	 * Check if the specified database has a job of the specified type in it.
	 * The type may be false to indicate "all".
	 * @param $type string
	 * @param Name string
	 * @return bool
	 */
	function checkJob( $type, Name ) {
		$lb = wfGetLB( Name );
		 = $lb->getConnection( DB_MASTER, array(), Name );
		if ( $type === false ) {
			$conds = Job::defaultQueueConditions( );
		} else {
			$conds = array( 'job_cmd' => $type );
		}


		$exists = (bool) ->selectField( 'job', '1', $conds, __METHOD__ );
		$lb->reuseConnection(  );
		return $exists;
	}

	/**
	 * Get all databases that have a pending job
	 * @return array
	 */
	private function getPendingDbs() {
		global $wgLocalDatabases;
		$pendingDBs = array();
		# Cross-reference DBs by master DB server
		sByMaster = array();
		foreach ( $wgLocalDatabases as  ) {
			$lb = wfGetLB(  );
			sByMaster[$lb->getServerName( 0 )][] = ;
		}

		foreach ( sByMaster as s ) {
			Conn = wfGetDB( DB_MASTER, array(), s[0] );

			# Padding row for MySQL bug
			$pad = str_repeat( '-', 40 );
			$sql = "(SELECT '$pad' as db, '$pad' as job_cmd)";
			foreach ( s as $wikiId ) {
				if ( $sql != '' ) {
					$sql .= ' UNION ';
				}

				list( Name, $tablePrefix ) = wfSplitWikiID( $wikiId );
				Conn->tablePrefix( $tablePrefix );
				$jobTable = Conn->tableName( 'job' );

				$sql .= "(SELECT DISTINCT '$wikiId' as db, job_cmd FROM Name.$jobTable GROUP BY job_cmd)";
			}
			$res = Conn->query( $sql, __METHOD__ );
			$first = true;
			foreach ( $res as $row ) {
				if ( $first ) {
					// discard padding row
					$first = false;
					continue;
				}
				$pendingDBs[$row->job_cmd][] = $row->db;
			}
		}
		return $pendingDBs;
	}
}

$maintClass = "nextJobDb";
require_once( RUN_MAINTENANCE_IF_MAIN );
