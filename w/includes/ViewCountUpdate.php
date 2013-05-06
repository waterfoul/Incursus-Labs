<?php
/**
 * Update for the 'page_counter' field
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
 */

/**
 * Update for the 'page_counter' field, when $wgDisableCounters is false.
 *
 * Depending on $wgHitcounterUpdateFreq, this will directly increment the
 * 'page_counter' field or use the 'hitcounter' table and then collect the data
 * from that table to update the 'page_counter' field in a batch operation.
 */
class ViewCountUpdate implements DeferrableUpdate {
	protected $id;

	/**
	 * Constructor
	 *
	 * @param $id Integer: page ID to increment the view count
	 */
	public function __construct( $id ) {
		$this->id = intval( $id );
	}

	/**
	 * Run the update
	 */
	public function doUpdate() {
		global $wgHitcounterUpdateFreq;

		w = wfGetDB( DB_MASTER );

		if ( $wgHitcounterUpdateFreq <= 1 || w->getType() == 'sqlite' ) {
			w->update( 'page', array( 'page_counter = page_counter + 1' ), array( 'page_id' => $this->id ), __METHOD__ );
			return;
		}

		# Not important enough to warrant an error page in case of failure
		$oldignore = w->ignoreErrors( true );

		w->insert( 'hitcounter', array( 'hc_id' => $this->id ), __METHOD__ );

		$checkfreq = intval( $wgHitcounterUpdateFreq / 25 + 1 );
		if ( rand() % $checkfreq == 0 && w->lastErrno() == 0 ) {
			$this->collect();
		}

		w->ignoreErrors( $oldignore );
	}

	protected function collect() {
		global $wgHitcounterUpdateFreq;

		w = wfGetDB( DB_MASTER );

		$rown = w->selectField( 'hitcounter', 'COUNT(*)', array(), __METHOD__ );

		if ( $rown < $wgHitcounterUpdateFreq ) {
			return;
		}

		wfProfileIn( __METHOD__ . '-collect' );
		$old_wiki_user_abort = ignore_wiki_user_abort( true );

		w->lockTables( array(), array( 'hitcounter' ), __METHOD__, false );

		Type = w->getType();
		$tabletype = Type == 'mysql' ? "ENGINE=HEAP " : '';
		$hitcounterTable = w->tableName( 'hitcounter' );
		$acchitsTable = w->tableName( 'acchits' );
		$pageTable = w->tableName( 'page' );

		w->query( "CREATE TEMPORARY TABLE $acchitsTable $tabletype AS " .
			"SELECT hc_id,COUNT(*) AS hc_n FROM $hitcounterTable " .
			'GROUP BY hc_id', __METHOD__ );
		w->delete( 'hitcounter', '*', __METHOD__ );
		w->unlockTables( __METHOD__ );

		if ( Type == 'mysql' ) {
			w->query( "UPDATE $pageTable,$acchitsTable SET page_counter=page_counter + hc_n " .
				'WHERE page_id = hc_id', __METHOD__ );
		} else {
			w->query( "UPDATE $pageTable SET page_counter=page_counter + hc_n " .
				"FROM $acchitsTable WHERE page_id = hc_id", __METHOD__ );
		}
		w->query( "DROP TABLE $acchitsTable", __METHOD__ );

		ignore_wiki_user_abort( $old_wiki_user_abort );
		wfProfileOut( __METHOD__ . '-collect' );
	}
}
