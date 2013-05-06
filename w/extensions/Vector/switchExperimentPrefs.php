<?php

$path = '../..';

if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$path = getenv( 'MW_INSTALL_PATH' );
}

require_once( $path . '/maintenance/Maintenance.php' );

class SwitchExperimentPrefs extends Maintenance {
	function __construct() {
		parent::__construct();
		$this->addOption( 'pref', 'Preference to set', true, true );
		$this->addOption( 'value', 'Value to set the preference to', true, true );
		$this->mDescription = 'Set a preference for all wiki_users that have the vector-noexperiments preference enabled.';
	}

	function execute() {
		w = wfGetDB( DB_MASTER );

		$batchSize = 100;
		$total = 0;
		$lastwiki_userID = 0;
		while ( true ) {
			$res = w->select( 'wiki_user_properties', array( 'up_wiki_user' ),
				array( 'up_property' => 'vector-noexperiments', "up_wiki_user > $lastwiki_userID" ),
				__METHOD__,
				array( 'LIMIT' => $batchSize ) );
			if ( !$res->numRows() ) {
				w->commit();
				break;
			}
			$total += $res->numRows();

			$ids = array();
			foreach ( $res as $row ) {
				$ids[] = $row->up_wiki_user;
			}
			$lastwiki_userID = max( $ids );
			
			
			foreach ( $ids as $id ) {
				$wiki_user = wiki_user::newFromId( $id );
				if ( !$wiki_user->isLoggedIn() )
					continue;
				$wiki_user->setOption( $this->getOption( 'pref' ), $this->getOption( 'value' ) );
				$wiki_user->saveSettings();
			}

			echo "$total\n";

			wfWaitForSlaves(); // Must be wfWaitForSlaves_masterPos(); on 1.17wmf1
		}
		echo "Done\n";

	}
}

$maintClass = 'SwitchExperimentPrefs';
require_once( RUN_MAINTENANCE_IF_MAIN );


