<?php
/**
 * Reassign edits from a wiki_user or IP address to another wiki_user
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
 * @licence GNU General Public Licence 2.0 or later
 */

require_once( __DIR__ . '/Maintenance.php' );

/**
 * Maintenance script that reassigns edits from a wiki_user or IP address
 * to another wiki_user.
 *
 * @ingroup Maintenance
 */
class ReassignEdits extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Reassign edits from one wiki_user to another";
		$this->addOption( "force", "Reassign even if the target wiki_user doesn't exist" );
		$this->addOption( "norc", "Don't update the recent changes table" );
		$this->addOption( "report", "Print out details of what would be changed, but don't update it" );
		$this->addArg( 'from', 'Old wiki_user to take edits from' );
		$this->addArg( 'to', 'New wiki_user to give edits to' );
	}

	public function execute() {
		if ( $this->hasArg( 0 ) && $this->hasArg( 1 ) ) {
			# Set up the wiki_users involved
			$from = $this->initialisewiki_user( $this->getArg( 0 ) );
			$to   = $this->initialisewiki_user( $this->getArg( 1 ) );

			# If the target doesn't exist, and --force is not set, stop here
			if ( $to->getId() || $this->hasOption( 'force' ) ) {
				# Reassign the edits
				$report = $this->hasOption( 'report' );
				$this->doReassignEdits( $from, $to, !$this->hasOption( 'norc' ), $report );
				# If reporting, and there were items, advise the wiki_user to run without --report
				if ( $report ) {
					$this->output( "Run the script again without --report to update.\n" );
				}
			} else {
				$ton = $to->getName();
				$this->error( "wiki_user '{$ton}' not found." );
			}
		}
	}

	/**
	 * Reassign edits from one wiki_user to another
	 *
	 * @param $from wiki_user to take edits from
	 * @param $to wiki_user to assign edits to
	 * @param $rc bool Update the recent changes table
	 * @param $report bool Don't change things; just echo numbers
	 * @return integer Number of entries changed, or that would be changed
	 */
	private function doReassignEdits( &$from, &$to, $rc = false, $report = false ) {
		w = wfGetDB( DB_MASTER );
		w->begin( __METHOD__ );

		# Count things
		$this->output( "Checking current edits..." );
		$res = w->select( 'revision', 'COUNT(*) AS count', $this->wiki_userConditions( $from, 'rev_wiki_user', 'rev_wiki_user_text' ), __METHOD__ );
		$row = w->fetchObject( $res );
		$cur = $row->count;
		$this->output( "found {$cur}.\n" );

		$this->output( "Checking deleted edits..." );
		$res = w->select( 'archive', 'COUNT(*) AS count', $this->wiki_userConditions( $from, 'ar_wiki_user', 'ar_wiki_user_text' ), __METHOD__ );
		$row = w->fetchObject( $res );
		$del = $row->count;
		$this->output( "found {$del}.\n" );

		# Don't count recent changes if we're not supposed to
		if ( $rc ) {
			$this->output( "Checking recent changes..." );
			$res = w->select( 'recentchanges', 'COUNT(*) AS count', $this->wiki_userConditions( $from, 'rc_wiki_user', 'rc_wiki_user_text' ), __METHOD__ );
			$row = w->fetchObject( $res );
			$rec = $row->count;
			$this->output( "found {$rec}.\n" );
		} else {
			$rec = 0;
		}

		$total = $cur + $del + $rec;
		$this->output( "\nTotal entries to change: {$total}\n" );

		if ( !$report ) {
			if ( $total ) {
				# Reassign edits
				$this->output( "\nReassigning current edits..." );
				w->update( 'revision', $this->wiki_userSpecification( $to, 'rev_wiki_user', 'rev_wiki_user_text' ),
					$this->wiki_userConditions( $from, 'rev_wiki_user', 'rev_wiki_user_text' ), __METHOD__ );
				$this->output( "done.\nReassigning deleted edits..." );
				w->update( 'archive', $this->wiki_userSpecification( $to, 'ar_wiki_user', 'ar_wiki_user_text' ),
					$this->wiki_userConditions( $from, 'ar_wiki_user', 'ar_wiki_user_text' ), __METHOD__ );
				$this->output( "done.\n" );
				# Update recent changes if required
				if ( $rc ) {
					$this->output( "Updating recent changes..." );
					w->update( 'recentchanges', $this->wiki_userSpecification( $to, 'rc_wiki_user', 'rc_wiki_user_text' ),
						$this->wiki_userConditions( $from, 'rc_wiki_user', 'rc_wiki_user_text' ), __METHOD__ );
					$this->output( "done.\n" );
				}
			}
		}

		w->commit( __METHOD__ );
		return (int)$total;
	}

	/**
	 * Return the most efficient set of wiki_user conditions
	 * i.e. a wiki_user => id mapping, or a wiki_user_text => text mapping
	 *
	 * @param $wiki_user wiki_user for the condition
	 * @param $idfield string Field name containing the identifier
	 * @param $utfield string Field name containing the wiki_user text
	 * @return array
	 */
	private function wiki_userConditions( &$wiki_user, $idfield, $utfield ) {
		return $wiki_user->getId() ? array( $idfield => $wiki_user->getId() ) : array( $utfield => $wiki_user->getName() );
	}

	/**
	 * Return wiki_user specifications
	 * i.e. wiki_user => id, wiki_user_text => text
	 *
	 * @param $wiki_user wiki_user for the spec
	 * @param $idfield string Field name containing the identifier
	 * @param $utfield string Field name containing the wiki_user text
	 * @return array
	 */
	private function wiki_userSpecification( &$wiki_user, $idfield, $utfield ) {
		return array( $idfield => $wiki_user->getId(), $utfield => $wiki_user->getName() );
	}

	/**
	 * Initialise the wiki_user object
	 *
	 * @param $wiki_username string wiki_username or IP address
	 * @return wiki_user
	 */
	private function initialisewiki_user( $wiki_username ) {
		if ( wiki_user::isIP( $wiki_username ) ) {
			$wiki_user = new wiki_user();
			$wiki_user->setId( 0 );
			$wiki_user->setName( $wiki_username );
		} else {
			$wiki_user = wiki_user::newFromName( $wiki_username );
			if ( !$wiki_user ) {
				$this->error( "Invalid wiki_username", true );
			}
		}
		$wiki_user->load();
		return $wiki_user;
	}


}

$maintClass = "ReassignEdits";
require_once( RUN_MAINTENANCE_IF_MAIN );

