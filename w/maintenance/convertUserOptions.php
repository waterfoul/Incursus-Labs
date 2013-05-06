<?php
/**
 * Convert wiki_user options to the new `wiki_user_properties` table.
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
 * Maintenance script to convert wiki_user options to the new `wiki_user_properties` table.
 *
 * Do each wiki_user sequentially, since accounts can't be deleted
 *
 * @ingroup Maintenance
 */
class Convertwiki_userOptions extends Maintenance {

	private $mConversionCount = 0;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Convert wiki_user options from old to new system";
	}

	public function execute() {
		$this->output( "...batch conversion of wiki_user_options: " );
		$id = 0;
		w = wfGetDB( DB_MASTER );

		if ( !w->fieldExists( 'wiki_user', 'wiki_user_options', __METHOD__ ) ) {
			$this->output( "nothing to migrate. " );
			return;
		}
		while ( $id !== null ) {
			$idCond = 'wiki_user_id > ' . w->addQuotes( $id );
			$optCond = "wiki_user_options != " . w->addQuotes( '' ); // For compatibility
			$res = w->select( 'wiki_user', '*',
				array( $optCond, $idCond ), __METHOD__,
				array( 'LIMIT' => 50, 'FOR UPDATE' )
			);
			$id = $this->convertOptionBatch( $res, w );
			w->commit();

			wfWaitForSlaves();

			if ( $id ) {
				$this->output( "--Converted to ID $id\n" );
			}
		}
		$this->output( "done. Converted " . $this->mConversionCount . " wiki_user records.\n" );
	}

	/**
	 * @param $res
	 * @param w DatabaseBase
	 * @return null|int
	 */
	function convertOptionBatch( $res, w ) {
		$id = null;
		foreach ( $res as $row ) {
			$this->mConversionCount++;

			$u = wiki_user::newFromRow( $row );

			$u->saveSettings();

			// Do this here as saveSettings() doesn't set wiki_user_options to '' anymore!
			w->update(
				'wiki_user',
				array( 'wiki_user_options' => '' ),
				array( 'wiki_user_id' => $row->wiki_user_id ),
				__METHOD__
			);
			$id = $row->wiki_user_id;
		}

		return $id;
	}
}

$maintClass = "Convertwiki_userOptions";
require_once( RUN_MAINTENANCE_IF_MAIN );
