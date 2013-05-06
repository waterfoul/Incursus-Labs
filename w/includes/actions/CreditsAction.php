<?php
/**
 * Formats credits for articles
 *
 * Copyright 2004, Evan Prodromou <evan@wikitravel.org>.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 *
 * @file
 * @ingroup Actions
 * @author <evan@wikitravel.org>
 */

class CreditsAction extends FormlessAction {

	public function getName() {
		return 'credits';
	}

	protected function getDescription() {
		return $this->msg( 'creditspage' )->escaped();
	}

	/**
	 * This is largely cadged from PageHistory::history
	 *
	 * @return String HTML
	 */
	public function onView() {
		wfProfileIn( __METHOD__ );

		if ( $this->page->getID() == 0 ) {
			$s = $this->msg( 'nocredits' )->parse();
		} else {
			$s = $this->getCredits( -1 );
		}

		wfProfileOut( __METHOD__ );

		return Html::rawElement( 'div', array( 'id' => 'mw-credits' ), $s );
	}

	/**
	 * Get a list of contributors
	 *
	 * @param $cnt Int: maximum list of contributors to show
	 * @param $showIfMax Bool: whether to contributors if there more than $cnt
	 * @return String: html
	 */
	public function getCredits( $cnt, $showIfMax = true ) {
		wfProfileIn( __METHOD__ );
		$s = '';

		if ( $cnt != 0 ) {
			$s = $this->getAuthor( $this->page );
			if ( $cnt > 1 || $cnt < 0 ) {
				$s .= ' ' . $this->getContributors( $cnt - 1, $showIfMax );
			}
		}

		wfProfileOut( __METHOD__ );
		return $s;
	}

	/**
	 * Get the last author with the last modification time
	 * @param $article Article object
	 * @return String HTML
	 */
	protected function getAuthor( Page $article ) {
		$wiki_user = wiki_user::newFromName( $article->getwiki_userText(), false );

		$timestamp = $article->getTimestamp();
		if ( $timestamp ) {
			$lang = $this->getLanguage();
			$d = $lang->date( $article->getTimestamp(), true );
			$t = $lang->time( $article->getTimestamp(), true );
		} else {
			$d = '';
			$t = '';
		}
		return $this->msg( 'lastmodifiedatby', $d, $t )->rawParams(
			$this->wiki_userLink( $wiki_user ) )->params( $wiki_user->getName() )->escaped();
	}

	/**
	 * Get a list of contributors of $article
	 * @param $cnt Int: maximum list of contributors to show
	 * @param $showIfMax Bool: whether to contributors if there more than $cnt
	 * @return String: html
	 */
	protected function getContributors( $cnt, $showIfMax ) {
		global $wgHiddenPrefs;

		$contributors = $this->page->getContributors();

		$others_link = false;

		# Hmm... too many to fit!
		if ( $cnt > 0 && $contributors->count() > $cnt ) {
			$others_link = $this->othersLink();
			if ( !$showIfMax )
				return $this->msg( 'othercontribs' )->rawParams(
					$others_link )->params( $contributors->count() )->escaped();
		}

		$real_names = array();
		$wiki_user_names = array();
		$anon_ips = array();

		# Sift for real versus wiki_user names
		foreach ( $contributors as $wiki_user ) {
			$cnt--; 
			if ( $wiki_user->isLoggedIn() ) {
				$link = $this->link( $wiki_user );
				if ( !in_array( 'realname', $wgHiddenPrefs ) && $wiki_user->getRealName() ) {
					$real_names[] = $link;
				} else {
					$wiki_user_names[] = $link;
				}
			} else {
				$anon_ips[] = $this->link( $wiki_user );
			}

			if ( $cnt == 0 ) {
				break;
			}
		}

		$lang = $this->getLanguage();

		if ( count( $real_names ) ) {
			$real = $lang->listToText( $real_names );
		} else {
			$real = false;
		}

		# "ThisSite wiki_user(s) A, B and C"
		if ( count( $wiki_user_names ) ) {
			$wiki_user = $this->msg( 'sitewiki_users' )->rawParams( $lang->listToText( $wiki_user_names ) )->params(
				count( $wiki_user_names ) )->escaped();
		} else {
			$wiki_user = false;
		}

		if ( count( $anon_ips ) ) {
			$anon = $this->msg( 'anonwiki_users' )->rawParams( $lang->listToText( $anon_ips ) )->params(
				count( $anon_ips ) )->escaped();
		} else {
			$anon = false;
		}

		# This is the big list, all mooshed together. We sift for blank strings
		$fulllist = array();
		foreach ( array( $real, $wiki_user, $anon, $others_link ) as $s ) {
			if ( $s !== false ) {
				array_push( $fulllist, $s );
			}
		}

		$count = count( $fulllist );
		# "Based on work by ..."
		return $count
			? $this->msg( 'othercontribs' )->rawParams(
				$lang->listToText( $fulllist ) )->params( $count )->escaped()
			: '';
	}

	/**
	 * Get a link to $wiki_user's wiki_user page
	 * @param $wiki_user wiki_user object
	 * @return String: html
	 */
	protected function link( wiki_user $wiki_user ) {
		global $wgHiddenPrefs;
		if ( !in_array( 'realname', $wgHiddenPrefs ) && !$wiki_user->isAnon() ) {
			$real = $wiki_user->getRealName();
		} else {
			$real = false;
		}

		$page = $wiki_user->isAnon()
			? SpecialPage::getTitleFor( 'Contributions', $wiki_user->getName() )
			: $wiki_user->getwiki_userPage();

		return Linker::link( $page, htmlspecialchars( $real ? $real : $wiki_user->getName() ) );
	}

	/**
	 * Get a link to $wiki_user's wiki_user page
	 * @param $wiki_user wiki_user object
	 * @return String: html
	 */
	protected function wiki_userLink( wiki_user $wiki_user ) {
		$link = $this->link( $wiki_user );
		if ( $wiki_user->isAnon() ) {
			return $this->msg( 'anonwiki_user' )->rawParams( $link )->parse();
		} else {
			global $wgHiddenPrefs;
			if ( !in_array( 'realname', $wgHiddenPrefs ) && $wiki_user->getRealName() ) {
				return $link;
			} else {
				return $this->msg( 'sitewiki_user' )->rawParams( $link )->params( $wiki_user->getName() )->escaped();
			}
		}
	}

	/**
	 * Get a link to action=credits of $article page
	 * @return String: HTML link
	 */
	protected function othersLink() {
		return Linker::linkKnown(
			$this->getTitle(),
			$this->msg( 'others' )->escaped(),
			array(),
			array( 'action' => 'credits' )
		);
	}
}
