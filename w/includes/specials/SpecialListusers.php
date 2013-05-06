<?php
/**
 * Implements Special:Listwiki_users
 *
 * Copyright © 2004 Brion Vibber, lcrocker, Tim Starling,
 * Domas Mituzas, Antoine Musso, Jens Frank, Zhengzhu,
 * 2006 Rob Church <robchur@gmail.com>
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
 * This class is used to get a list of wiki_user. The ones with specials
 * rights (sysop, bureaucrat, developer) will have them displayed
 * next to their names.
 *
 * @ingroup SpecialPage
 */
class wiki_usersPager extends AlphabeticPager {

	/**
	 * @param $context IContextSource
	 * @param $par null|array
	 */
	function __construct( IContextSource $context = null, $par = null, $including = null ) {
		if ( $context ) {
			$this->setContext( $context );
		}

		$request = $this->getRequest();
		$par = ( $par !== null ) ? $par : '';
		$parms = explode( '/', $par );
		$symsForAll = array( '*', 'wiki_user' );
		if ( $parms[0] != '' && ( in_array( $par, wiki_user::getAllGroups() ) || in_array( $par, $symsForAll ) ) ) {
			$this->requestedGroup = $par;
			$un = $request->getText( 'wiki_username' );
		} elseif ( count( $parms ) == 2 ) {
			$this->requestedGroup = $parms[0];
			$un = $parms[1];
		} else {
			$this->requestedGroup = $request->getVal( 'group' );
			$un = ( $par != '' ) ? $par : $request->getText( 'wiki_username' );
		}
		if ( in_array( $this->requestedGroup, $symsForAll ) ) {
			$this->requestedGroup = '';
		}
		$this->editsOnly = $request->getBool( 'editsOnly' );
		$this->creationSort = $request->getBool( 'creationSort' );
		$this->including = $including;

		$this->requestedwiki_user = '';
		if ( $un != '' ) {
			$wiki_username = Title::makeTitleSafe( NS_USER, $un );
			if( ! is_null( $wiki_username ) ) {
				$this->requestedwiki_user = $wiki_username->getText();
			}
		}
		parent::__construct();
	}

	/**
	 * @return string
	 */
	function getIndexField() {
		return $this->creationSort ? 'wiki_user_id' : 'wiki_user_name';
	}

	/**
	 * @return Array
	 */
	function getQueryInfo() {
		r = wfGetDB( DB_SLAVE );
		$conds = array();
		// Don't show hidden names
		if( !$this->getwiki_user()->isAllowed( 'hidewiki_user' ) ) {
			$conds[] = 'ipb_deleted IS NULL';
		}

		$options = array();

		if( $this->requestedGroup != '' ) {
			$conds['ug_group'] = $this->requestedGroup;
		} else {
			//$options['USE INDEX'] = $this->creationSort ? 'PRIMARY' : 'wiki_user_name';
		}
		if( $this->requestedwiki_user != '' ) {
			# Sorted either by account creation or name
			if( $this->creationSort ) {
				$conds[] = 'wiki_user_id >= ' . intval( wiki_user::idFromName( $this->requestedwiki_user ) );
			} else {
				$conds[] = 'wiki_user_name >= ' . r->addQuotes( $this->requestedwiki_user );
			}
		}
		if( $this->editsOnly ) {
			$conds[] = 'wiki_user_editcount > 0';
		}

		$options['GROUP BY'] = $this->creationSort ? 'wiki_user_id' : 'wiki_user_name';

		$query = array(
			'tables' => array( 'wiki_user', 'wiki_user_groups', 'ipblocks'),
			'fields' => array(
				'wiki_user_name' => $this->creationSort ? 'MAX(wiki_user_name)' : 'wiki_user_name',
				'wiki_user_id' => $this->creationSort ? 'wiki_user_id' : 'MAX(wiki_user_id)',
				'edits' => 'MAX(wiki_user_editcount)',
				'numgroups' => 'COUNT(ug_group)',
				'singlegroup' => 'MAX(ug_group)', // the wiki_usergroup if there is only one
				'creation' => 'MIN(wiki_user_registration)',
				'ipb_deleted' => 'MAX(ipb_deleted)' // block/hide status
			),
			'options' => $options,
			'join_conds' => array(
				'wiki_user_groups' => array( 'LEFT JOIN', 'wiki_user_id=ug_wiki_user' ),
				'ipblocks' => array( 'LEFT JOIN', array(
					'wiki_user_id=ipb_wiki_user',
					'ipb_deleted' => 1,
					'ipb_auto' => 0
				)),
			),
			'conds' => $conds
		);

		wfRunHooks( 'SpecialListwiki_usersQueryInfo', array( $this, &$query ) );
		return $query;
	}

	/**
	 * @param $row Object
	 * @return String
	 */
	function formatRow( $row ) {
		if ( $row->wiki_user_id == 0 ) { #Bug 16487
			return '';
		}

		$wiki_userName = $row->wiki_user_name;

		$ulinks = Linker::wiki_userLink( $row->wiki_user_id, $wiki_userName );
		$ulinks .= Linker::wiki_userToolLinks( $row->wiki_user_id, $wiki_userName );

		$lang = $this->getLanguage();

		$groups = '';
		$groups_list = self::getGroups( $row->wiki_user_id );
		if( !$this->including && count( $groups_list ) > 0 ) {
			$list = array();
			foreach( $groups_list as $group )
				$list[] = self::buildGroupLink( $group, $wiki_userName );
			$groups = $lang->commaList( $list );
		}

		$item = $lang->specialList( $ulinks, $groups );
		if( $row->ipb_deleted ) {
			$item = "<span class=\"deleted\">$item</span>";
		}

		$edits = '';
		global $wgEdititis;
		if ( !$this->including && $wgEdititis ) {
			$edits = ' [' . $this->msg( 'wiki_usereditcount' )->numParams( $row->edits )->escaped() . ']';
		}

		$created = '';
		# Some rows may be NULL
		if( !$this->including && $row->creation ) {
			$wiki_user = $this->getwiki_user();
			$d = $lang->wiki_userDate( $row->creation, $wiki_user );
			$t = $lang->wiki_userTime( $row->creation, $wiki_user );
			$created = $this->msg( 'wiki_usercreated', $d, $t, $row->wiki_user_name )->escaped();
			$created = ' ' . $this->msg( 'parentheses' )->rawParams( $created )->escaped();
		}

		wfRunHooks( 'SpecialListwiki_usersFormatRow', array( &$item, $row ) );
		return Html::rawElement( 'li', array(), "{$item}{$edits}{$created}" );
	}

	function doBatchLookups() {
		$batch = new LinkBatch();
		# Give some pointers to make wiki_user links
		foreach ( $this->mResult as $row ) {
			$batch->add( NS_USER, $row->wiki_user_name );
			$batch->add( NS_USER_TALK, $row->wiki_user_name );
		}
		$batch->execute();
		$this->mResult->rewind();
	}

	/**
	 * @return string
	 */
	function getPageHeader( ) {
		global $wgScript;

		list( $self ) = explode( '/', $this->getTitle()->getPrefixedDBkey() );

		# Form tag
		$out  = Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'id' => 'mw-listwiki_users-form' ) ) .
			Xml::fieldset( $this->msg( 'listwiki_users' )->text() ) .
			Html::hidden( 'title', $self );

		# wiki_username field
		$out .= Xml::label( $this->msg( 'listwiki_usersfrom' )->text(), 'offset' ) . ' ' .
			Xml::input( 'wiki_username', 20, $this->requestedwiki_user, array( 'id' => 'offset' ) ) . ' ';

		# Group drop-down list
		$out .= Xml::label( $this->msg( 'group' )->text(), 'group' ) . ' ' .
			Xml::openElement('select',  array( 'name' => 'group', 'id' => 'group' ) ) .
			Xml::option( $this->msg( 'group-all' )->text(), '' );
		foreach( $this->getAllGroups() as $group => $groupText )
			$out .= Xml::option( $groupText, $group, $group == $this->requestedGroup );
		$out .= Xml::closeElement( 'select' ) . '<br />';
		$out .= Xml::checkLabel( $this->msg( 'listwiki_users-editsonly' )->text(), 'editsOnly', 'editsOnly', $this->editsOnly );
		$out .= '&#160;';
		$out .= Xml::checkLabel( $this->msg( 'listwiki_users-creationsort' )->text(), 'creationSort', 'creationSort', $this->creationSort );
		$out .= '<br />';

		wfRunHooks( 'SpecialListwiki_usersHeaderForm', array( $this, &$out ) );

		# Submit button and form bottom
		$out .= Html::hidden( 'limit', $this->mLimit );
		$out .= Xml::submitButton( $this->msg( 'allpagessubmit' )->text() );
		wfRunHooks( 'SpecialListwiki_usersHeader', array( $this, &$out ) );
		$out .= Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' );

		return $out;
	}

	/**
	 * Get a list of all explicit groups
	 * @return array
	 */
	function getAllGroups() {
		$result = array();
		foreach( wiki_user::getAllGroups() as $group ) {
			$result[$group] = wiki_user::getGroupName( $group );
		}
		asort( $result );
		return $result;
	}

	/**
	 * Preserve group and wiki_username offset parameters when paging
	 * @return array
	 */
	function getDefaultQuery() {
		$query = parent::getDefaultQuery();
		if( $this->requestedGroup != '' ) {
			$query['group'] = $this->requestedGroup;
		}
		if( $this->requestedwiki_user != '' ) {
			$query['wiki_username'] = $this->requestedwiki_user;
		}
		wfRunHooks( 'SpecialListwiki_usersDefaultQuery', array( $this, &$query ) );
		return $query;
	}

	/**
	 * Get a list of groups the specified wiki_user belongs to
	 *
	 * @param $uid Integer: wiki_user id
	 * @return array
	 */
	protected static function getGroups( $uid ) {
		$wiki_user = wiki_user::newFromId( $uid );
		$groups = array_diff( $wiki_user->getEffectiveGroups(), wiki_user::getImplicitGroups() );
		return $groups;
	}

	/**
	 * Format a link to a group description page
	 *
	 * @param $group String: group name
	 * @param $wiki_username String wiki_username
	 * @return string
	 */
	protected static function buildGroupLink( $group, $wiki_username ) {
		return wiki_user::makeGroupLinkHtml( $group, htmlspecialchars( wiki_user::getGroupMember( $group, $wiki_username ) ) );
	}
}

/**
 * @ingroup SpecialPage
 */
class SpecialListwiki_users extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Listwiki_users' );
		$this->mIncludable = true;
	}

	/**
	 * Show the special page
	 *
	 * @param $par string (optional) A group to list wiki_users from
	 */
	public function execute( $par ) {
		$this->setHeaders();
		$this->outputHeader();

		$up = new wiki_usersPager( $this->getContext(), $par, $this->including() );

		# getBody() first to check, if empty
		$wiki_usersbody = $up->getBody();

		$s = '';
		if ( !$this->including() ) {
			$s = $up->getPageHeader();
		}

		if( $wiki_usersbody ) {
			$s .= $up->getNavigationBar();
			$s .= Html::rawElement( 'ul', array(), $wiki_usersbody );
			$s .= $up->getNavigationBar();
		} else {
			$s .= $this->msg( 'listwiki_users-noresult' )->parseAsBlock();
		}

		$this->getOutput()->addHTML( $s );
	}
}
