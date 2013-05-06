<?php
/**
 * Helper methods for the deleteArchivedRevisions.php maintenance script.
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

/**
 * Helper methods for the deleteArchivedRevisions.php maintenance script.
 *
 * @ingroup Maintenance
 */
class DeleteArchivedRevisionsImplementation {

	/**
	 * Perform the delete on archived revisions.

	 * @param $maint Object An object (typically of class Maintenance)
	 * that implements two methods: handleOutput() and
	 * purgeRedundantText().  See Maintenance for a description of
	 * those methods.
	 */
	static public function doDelete( $maint ) {
		w = wfGetDB( DB_MASTER );

		w->begin( __METHOD__ );

		$tbl_arch = w->tableName( 'archive' );

		# Delete as appropriate
		$maint->handleOutput( "Deleting archived revisions... " );
		w->query( "DELETE FROM $tbl_arch" );

		$count = w->affectedRows();
		$deletedRows = $count != 0;

		$maint->handleOutput( "done. $count revisions deleted.\n" );

		# This bit's done
		# Purge redundant text records
		w->commit( __METHOD__ );
		if ( $deletedRows ) {
			$maint->purgeRedundantText( true );
		}
	}
}
