<?php
/**
 * Maintenance script to clean up after incomplete wiki_user renames
 * Sometimes wiki_user edits are left lying around under the old name,
 * check for that and assign them to the new wiki_username
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
 * @ingroup Maintenance
 * @author Ariel Glenn <ariel@wikimedia.org>
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class Renamewiki_userCleanup extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Maintenance script to finish incomplete rename wiki_user, in particular to reassign edits that were missed";
		$this->addOption( 'oldwiki_user', 'Old wiki_user name', true, true );
		$this->addOption( 'newwiki_user', 'New wiki_user name', true, true );
		$this->addOption( 'olduid', 'Old wiki_user id in revision records (DANGEROUS)', false, true );
		$this->mBatchSize = 1000;
	}

	public function execute() {
		$this->output( "Rename wiki_user Cleanup starting...\n\n" );
		$oldwiki_user = wiki_user::newFromName( $this->getOption( 'oldwiki_user' ) );
		$newwiki_user = wiki_user::newFromName( $this->getOption( 'newwiki_user' ) );
		$olduid = $this->getOption( 'olduid' );

		$this->checkwiki_userExistence( $oldwiki_user, $newwiki_user );
		$this->checkRenameLog( $oldwiki_user, $newwiki_user );

		if ( $olduid ) {
			$this->doUpdates( $oldwiki_user, $newwiki_user, $olduid );
		}
		$this->doUpdates( $oldwiki_user, $newwiki_user, $newwiki_user->getId() );
		$this->doUpdates( $oldwiki_user, $newwiki_user, 0 );
		
		print "Done!\n";
		exit(0);
	}

	/**
	 * @param $oldwiki_user wiki_user
	 * @param $newwiki_user wiki_user
	 */
	public function checkwiki_userExistence( $oldwiki_user, $newwiki_user ) {
		if ( !$newwiki_user->getId() ) {
			$this->error( "No such wiki_user: " . $this->getOption( 'newwiki_user' ), true );
			exit(1);
		}
		if ($oldwiki_user->getId() ) {
			print "WARNING!!: Old wiki_user still exists: " . $this->getOption( 'oldwiki_user' ) . "\n";
			print "proceed anyways? We'll only re-attribute edits that have the new wiki_user uid (or 0)";
			print " or the uid specified by the caller, and the old wiki_user name.  [N/y]   ";
			$stdin = fopen ("php://stdin","rt");
			$line = fgets($stdin);
			fclose($stdin);
			if ( $line[0] != "Y" && $line[0] != "y" ) {
				print "Exiting at wiki_user's request\n";
				exit(0);
			}
		}
	}

	/**
	 * @param $oldwiki_user wiki_user
	 * @param $newwiki_user wiki_user
	 */
	public function checkRenameLog( $oldwiki_user, $newwiki_user ) {
		r = wfGetDB( DB_SLAVE );

		$oldTitle = Title::makeTitle( NS_USER, $oldwiki_user->getName() );

		$result = r->select( 'logging', '*',
			array( 'log_type' => 'renamewiki_user',
				'log_action'    => 'renamewiki_user',
				'log_namespace' => NS_USER,
				'log_title'     => $oldTitle->getDBkey(),
				'log_params'    => $newwiki_user->getName()
			     ),
			__METHOD__
		);
		if (! $result || ! $result->numRows() ) {
			// try the old format
			$result = r->select( 'logging', '*',
			array( 'log_type' => 'renamewiki_user',
				'log_action'    => 'renamewiki_user',
				'log_namespace' => NS_USER,
				'log_title'     => $oldwiki_user->getName(),
			     ),
				__METHOD__
			);
			if (! $result ||  ! $result->numRows() ) {
				print "No log entry found for a rename of ".$oldwiki_user->getName()." to ".$newwiki_user->getName().", proceed anyways??? [N/y] ";
				$stdin = fopen ("php://stdin","rt");
				$line = fgets($stdin);
				fclose($stdin);
				if ( $line[0] != "Y" && $line[0] != "y" ) {
					print "Exiting at wiki_user's request\n";
					exit(1);
				}
			} else {
				foreach ( $result as $row ) {
					print "Found possible log entry of the rename, please check: ".$row->log_title." with comment ".$row->log_comment." on $row->log_timestamp\n";
				}
			}
		} else {
			foreach ( $result as $row ) {
				print "Found log entry of the rename: ".$oldwiki_user->getName()." to ".$newwiki_user->getName()." on $row->log_timestamp\n";
			}
		}
		if ($result && $result->numRows() > 1) {
			print "More than one rename entry found in the log, not sure what to do. Continue anyways? [N/y]  ";
			$stdin = fopen ("php://stdin","rt");
			$line = fgets($stdin);
			fclose($stdin);
			if ( $line[0] != "Y" && $line[0] != "y" ) {
				print "Exiting at wiki_user's request\n";
				exit(1);
			}
		}
	}

	/**
	 * @param $oldwiki_user wiki_user
	 * @param $newwiki_user wiki_user
	 * @param $uid
	 */
	public function doUpdates( $oldwiki_user, $newwiki_user, $uid ) {
		$this->updateTable( 'revision', 'rev_wiki_user_text', 'rev_wiki_user', 'rev_timestamp', $oldwiki_user, $newwiki_user, $uid );
		$this->updateTable( 'archive', 'ar_wiki_user_text', 'ar_wiki_user', 'ar_timestamp',  $oldwiki_user, $newwiki_user, $uid );
		$this->updateTable( 'logging', 'log_wiki_user_text', 'log_wiki_user', 'log_timestamp', $oldwiki_user, $newwiki_user, $uid );
		$this->updateTable( 'image', 'img_wiki_user_text', 'img_wiki_user', 'img_timestamp', $oldwiki_user, $newwiki_user, $uid );
		$this->updateTable( 'oldimage', 'oi_wiki_user_text', 'oi_wiki_user', 'oi_timestamp', $oldwiki_user, $newwiki_user, $uid );
		$this->updateTable( 'filearchive', 'fa_wiki_user_text','fa_wiki_user', 'fa_timestamp', $oldwiki_user, $newwiki_user, $uid );
	}

	/**
	 * @param $table
	 * @param $wiki_usernamefield
	 * @param $wiki_useridfield
	 * @param $timestampfield
	 * @param $oldwiki_user wiki_user
	 * @param $newwiki_user wiki_user
	 * @param $uid
	 * @return int
	 */
	public function updateTable( $table, $wiki_usernamefield, $wiki_useridfield, $timestampfield, $oldwiki_user, $newwiki_user, $uid ) {
		w = wfGetDB( DB_MASTER );

		$contribs = w->selectField( $table, 'count(*)',
			array( $wiki_usernamefield => $oldwiki_user->getName(), $wiki_useridfield => $uid ), __METHOD__ );

		if ( $contribs == 0 ) {
			print "No edits to be re-attributed from table $table for uid $uid\n" ;
			return(0);
		}

		print "Found $contribs edits to be re-attributed from table $table for uid $uid\n";
		if ( $uid != $newwiki_user->getId() ) {
			print "If you proceed, the uid field will be set to that of the new wiki_user name (i.e. ".$newwiki_user->getId().") in these rows.\n";
		}

		print "Proceed? [N/y]  ";
		$stdin = fopen ("php://stdin","rt");
		$line = fgets($stdin);
		fclose($stdin);
		if ( $line[0] != "Y" && $line[0] != "y" ) {
			print "Skipping at wiki_user's request\n";
			return(0);
		}

		$selectConds = array( $wiki_usernamefield => $oldwiki_user->getName(), $wiki_useridfield => $uid );
		$updateFields = array( $wiki_usernamefield => $newwiki_user->getName(), $wiki_useridfield => $newwiki_user->getId() );

		while ( $contribs > 0 ) {
			print "Doing batch of up to approximately ".$this->mBatchSize."\n";
			print "Do this batch? [N/y]  ";
			$stdin = fopen ("php://stdin","rt");
			$line = fgets($stdin);
			fclose($stdin);
			if ( $line[0] != "Y" && $line[0] != "y" ) {
				print "Skipping at wiki_user's request\n";
				return(0);
			}
			w->begin();
			$result = w->select( $table, $timestampfield, $selectConds , __METHOD__,
				array( 'ORDER BY' => $timestampfield.' DESC', 'LIMIT' => $this->mBatchSize ) );
			if (! $result) {
				print "There were rows for updating but now they are gone. Skipping.\n";
				w->rollback();
				return(0);
			}
			$result->seek($result->numRows() -1 );
			$row = $result->fetchObject();
			$timestamp = $row->$timestampfield;
			$updateCondsWithTime = array_merge( $selectConds, array ("$timestampfield >= $timestamp") );
			$success = w->update( $table, $updateFields, $updateCondsWithTime, __METHOD__ );
			if ( $success ) {
				$rowsDone = w->affectedRows();
				w->commit();
			} else {
				print "Problem with the update, rolling back and exiting\n";
				w->rollback();
				exit(1);
			}
			//$contribs = wiki_user::edits( $oldwiki_user->getId() );
			$contribs = w->selectField( $table, 'count(*)', $selectConds, __METHOD__ );
			print "Updated $rowsDone edits; $contribs edits remaining to be re-attributed\n";
		}
		return(0);
	}

}

$maintClass = "Renamewiki_userCleanup";
require_once( RUN_MAINTENANCE_IF_MAIN );
