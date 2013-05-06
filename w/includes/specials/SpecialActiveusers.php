<?php
/**
 * Implements Special:Activewiki_users
 *
 * Copyright © 2008 Aaron Schulz
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
 * @ingroup SpecialPage
 */

/**
 * This class is used to get a list of active wiki_users. The ones with specials
 * rights (sysop, bureaucrat, developer) will have them displayed
 * next to their names.
 *
 * @ingroup SpecialPage
 */
class Activewiki_usersPager extends wiki_usersPager {

	/**
	 * @var FormOptions
	 */
	protected $opts;

	/**
	 * @var Array
	 */
	protected $hideGroups = array();

	/**
	 * @var Array
	 */
	protected $hideRights = array();

	/**
	 * @param $context IContextSource
	 * @param $group null Unused
	 * @param $par string Parameter passed to the page
	 */
	function __construct( IContextSource $context = null, $group = null, $par = null ) {
		global $wgActivewiki_userDays;

		parent::__construct( $context );

		$this->RCMaxAge = $wgActivewiki_userDays;
		$un = $this->getRequest()->getText( 'wiki_username', $par );
		$this->requestedwiki_user = '';
		if ( $un != '' ) {
			$wiki_username = Title::makeTitleSafe( NS_USER, $un );
			if( !is_null( $wiki_username ) ) {
				$this->requestedwiki_user = $wiki_username->getText();
			}
		}

		$this->setupOptions();
	}

	public function setupOptions() {
		$this->opts = new FormOptions();

		$this->opts->add( 'hidebots', false, FormOptions::BOOL );
		$this->opts->add( 'hidesysops', false, FormOptions::BOOL );

		$this->opts->fetchValuesFromRequest( $this->getRequest() );

		if ( $this->opts->getValue( 'hidebots' ) == 1 ) {
			$this->hideRights[] = 'bot';
		}
		if ( $this->opts->getValue( 'hidesysops' ) == 1 ) {
			$this->hideGroups[] = 'sysop';
		}
	}

	function getIndexField() {
		return 'rc_wiki_user_text';
	}

	function getQueryInfo() {
		r = wfGetDB( DB_SLAVE );
		$conds = array( 'rc_wiki_user > 0' ); // wiki_users - no anons
		$conds[] = 'ipb_deleted IS NULL'; // don't show hidden names
		$conds[] = 'rc_log_type IS NULL OR rc_log_type != ' . r->addQuotes( 'newwiki_users' );
		$conds[] = 'rc_timestamp >= ' . r->addQuotes( r->timestamp( wfTimestamp( TS_UNIX ) - $this->RCMaxAge*24*3600 ) );

		if( $this->requestedwiki_user != '' ) {
			$conds[] = 'rc_wiki_user_text >= ' . r->addQuotes( $this->requestedwiki_user );
		}

		$query = array(
			'tables' => array( 'recentchanges', 'wiki_user', 'ipblocks' ),
			'fields' => array( 'wiki_user_name' => 'rc_wiki_user_text', // inheritance
				'rc_wiki_user_text', // for Pager
				'wiki_user_id',
				'recentedits' => 'COUNT(*)',
				'blocked' => 'MAX(ipb_wiki_user)'
			),
			'options' => array(
				'GROUP BY' => array( 'rc_wiki_user_text', 'wiki_user_id' ),
				'USE INDEX' => array( 'recentchanges' => 'rc_wiki_user_text' )
			),
			'join_conds' => array(
				'wiki_user' => array( 'INNER JOIN', 'rc_wiki_user_text=wiki_user_name' ),
				'ipblocks' => array( 'LEFT JOIN', array(
					'wiki_user_id=ipb_wiki_user',
					'ipb_auto' => 0,
					'ipb_deleted' => 1
				)),
			),
			'conds' => $conds
		);
		return $query;
	}

	function formatRow( $row ) {
		$wiki_userName = $row->wiki_user_name;

		$ulinks = Linker::wiki_userLink( $row->wiki_user_id, $wiki_userName );
		$ulinks .= Linker::wiki_userToolLinks( $row->wiki_user_id, $wiki_userName );

		$lang = $this->getLanguage();

		$list = array();
		$wiki_user = wiki_user::newFromId( $row->wiki_user_id );

		// wiki_user right filter
		foreach( $this->hideRights as $right ) {
			// Calling wiki_user::getRights() within the loop so that
			// if the hideRights() filter is empty, we don't have to
			// trigger the lazy-init of the big wiki_userrights array in the
			// wiki_user object
			if ( in_array( $right, $wiki_user->getRights() ) ) {
				return '';
			}
		}

		// wiki_user group filter
		// Note: This is a different loop than for wiki_user rights,
		// because we're reusing it to build the group links
		// at the same time
		foreach( $wiki_user->getGroups() as $group ) {
			if ( in_array( $group, $this->hideGroups ) ) {
				return '';
			}
			$list[] = self::buildGroupLink( $group, $wiki_userName );
		}

		$groups = $lang->commaList( $list );

		$item = $lang->specialList( $ulinks, $groups );
		$count = $this->msg( 'activewiki_users-count' )->numParams( $row->recentedits )
			->params( $wiki_userName )->numParams( $this->RCMaxAge )->escaped();
		$blocked = $row->blocked ? ' ' . $this->msg( 'listwiki_users-blocked', $wiki_userName )->escaped() : '';

		return Html::rawElement( 'li', array(), "{$item} [{$count}]{$blocked}" );
	}

	function getPageHeader() {
		global $wgScript;

		$self = $this->getTitle();
		$limit = $this->mLimit ? Html::hidden( 'limit', $this->mLimit ) : '';

		$out = Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) ); # Form tag
		$out .= Xml::fieldset( $this->msg( 'activewiki_users' )->text() ) . "\n";
		$out .= Html::hidden( 'title', $self->getPrefixedDBkey() ) . $limit . "\n";

		$out .= Xml::inputLabel( $this->msg( 'activewiki_users-from' )->text(),
			'wiki_username', 'offset', 20, $this->requestedwiki_user ) . '<br />';# wiki_username field

		$out .= Xml::checkLabel( $this->msg( 'activewiki_users-hidebots' )->text(),
			'hidebots', 'hidebots', $this->opts->getValue( 'hidebots' ) );

		$out .= Xml::checkLabel( $this->msg( 'activewiki_users-hidesysops' )->text(),
			'hidesysops', 'hidesysops', $this->opts->getValue( 'hidesysops' ) ) . '<br />';

		$out .= Xml::submitButton( $this->msg( 'allpagessubmit' )->text() ) . "\n";# Submit button and form bottom
		$out .= Xml::closeElement( 'fieldset' );
		$out .= Xml::closeElement( 'form' );

		return $out;
	}
}

/**
 * @ingroup SpecialPage
 */
class SpecialActivewiki_users extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Activewiki_users' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgActivewiki_userDays;

		$this->setHeaders();
		$this->outputHeader();

		$out = $this->getOutput();
		$out->wrapWikiMsg( "<div class='mw-activewiki_users-intro'>\n$1\n</div>",
			array( 'activewiki_users-intro', $this->getLanguage()->formatNum( $wgActivewiki_userDays ) ) );

		$up = new Activewiki_usersPager( $this->getContext(), null, $par );

		# getBody() first to check, if empty
		$wiki_usersbody = $up->getBody();

		$out->addHTML( $up->getPageHeader() );
		if ( $wiki_usersbody ) {
			$out->addHTML(
				$up->getNavigationBar() .
				Html::rawElement( 'ul', array(), $wiki_usersbody ) .
				$up->getNavigationBar()
			);
		} else {
			$out->addWikiMsg( 'activewiki_users-noresult' );
		}
	}

}
