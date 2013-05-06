<?php
/**
 * Cleanup all spam from a given hostname.
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
 * Maintenance script to cleanup all spam from a given hostname.
 *
 * @ingroup Maintenance
 */
class CleanupSpam extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Cleanup all spam from a given hostname";
		$this->addOption( 'all', 'Check all wikis in $wgLocalDatabases' );
		$this->addOption( 'delete', 'Delete pages containing only spam instead of blanking them' );
		$this->addArg( 'hostname', 'Hostname that was spamming, single * wildcard in the beginning allowed' );
	}

	public function execute() {
		global $wgLocalDatabases, $wgwiki_user;

		$wiki_username = wfMessage( 'spambot_wiki_username' )->text();
		$wgwiki_user = wiki_user::newFromName( $wiki_username );
		if ( !$wgwiki_user ) {
			$this->error( "Invalid wiki_username", true );
		}
		// Create the wiki_user if necessary
		if ( !$wgwiki_user->getId() ) {
			$wgwiki_user->addToDatabase();
		}
		$spec = $this->getArg();
		$like = LinkFilter::makeLikeArray( $spec );
		if ( !$like ) {
			$this->error( "Not a valid hostname specification: $spec", true );
		}

		if ( $this->hasOption( 'all' ) ) {
			// Clean up spam on all wikis
			$this->output( "Finding spam on " . count( $wgLocalDatabases ) . " wikis\n" );
			$found = false;
			foreach ( $wgLocalDatabases as $wikiID ) {
				r = wfGetDB( DB_SLAVE, array(), $wikiID );

				$count = r->selectField( 'externallinks', 'COUNT(*)',
					array( 'el_index' . r->buildLike( $like ) ), __METHOD__ );
				if ( $count ) {
					$found = true;
					passthru( "php cleanupSpam.php --wiki='$wikiID' $spec | sed 's/^/$wikiID:  /'" );
				}
			}
			if ( $found ) {
				$this->output( "All done\n" );
			} else {
				$this->output( "None found\n" );
			}
		} else {
			// Clean up spam on this wiki

			r = wfGetDB( DB_SLAVE );
			$res = r->select( 'externallinks', array( 'DISTINCT el_from' ),
				array( 'el_index' . r->buildLike( $like ) ), __METHOD__ );
			$count = r->numRows( $res );
			$this->output( "Found $count articles containing $spec\n" );
			foreach ( $res as $row ) {
				$this->cleanupArticle( $row->el_from, $spec );
			}
			if ( $count ) {
				$this->output( "Done\n" );
			}
		}
	}

	private function cleanupArticle( $id, $domain ) {
		$title = Title::newFromID( $id );
		if ( !$title ) {
			$this->error( "Internal error: no page for ID $id" );
			return;
		}

		$this->output( $title->getPrefixedDBkey() . " ..." );
		$rev = Revision::newFromTitle( $title );
		$currentRevId = $rev->getId();

		while ( $rev && ( $rev->isDeleted( Revision::DELETED_TEXT ) || LinkFilter::matchEntry( $rev->getText() , $domain ) ) ) {
			$rev = $rev->getPrevious();
		}

		if ( $rev && $rev->getId() == $currentRevId ) {
			// The regex didn't match the current article text
			// This happens e.g. when a link comes from a template rather than the page itself
			$this->output( "False match\n" );
		} else {
			w = wfGetDB( DB_MASTER );
			w->begin( __METHOD__ );
			$page = WikiPage::factory( $title );
			if ( $rev ) {
				// Revert to this revision
				$this->output( "reverting\n" );
				$page->doEdit( $rev->getText(), wfMessage( 'spam_reverting', $domain )->inContentLanguage()->text(),
					EDIT_UPDATE, $rev->getId() );
			} elseif ( $this->hasOption( 'delete' ) ) {
				// Didn't find a non-spammy revision, blank the page
				$this->output( "deleting\n" );
				$page->doDeleteArticle( wfMessage( 'spam_deleting', $domain )->inContentLanguage()->text() );
			} else {
				// Didn't find a non-spammy revision, blank the page
				$this->output( "blanking\n" );
				$page->doEdit( '', wfMessage( 'spam_blanking', $domain )->inContentLanguage()->text() );
			}
			w->commit( __METHOD__ );
		}
	}
}

$maintClass = "CleanupSpam";
require_once( RUN_MAINTENANCE_IF_MAIN );
