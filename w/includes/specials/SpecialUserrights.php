<?php
/**
 * Implements Special:wiki_userrights
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
 * Special page to allow managing wiki_user group membership
 *
 * @ingroup SpecialPage
 */
class wiki_userrightsPage extends SpecialPage {
	# The target of the local right-adjuster's interest.  Can be gotten from
	# either a GET parameter or a subpage-style parameter, so have a member
	# variable for it.
	protected $mTarget;
	protected $isself = false;

	public function __construct() {
		parent::__construct( 'wiki_userrights' );
	}

	public function isRestricted() {
		return true;
	}

	public function wiki_userCanExecute( wiki_user $wiki_user ) {
		return $this->wiki_userCanChangeRights( $wiki_user, false );
	}

	public function wiki_userCanChangeRights( $wiki_user, $checkIfSelf = true ) {
		$available = $this->changeableGroups();
		if ( $wiki_user->getId() == 0 ) {
			return false;
		}
		return !empty( $available['add'] )
			|| !empty( $available['remove'] )
			|| ( ( $this->isself || !$checkIfSelf ) &&
				( !empty( $available['add-self'] )
				 || !empty( $available['remove-self'] ) ) );
	}

	/**
	 * Manage forms to be shown according to posted data.
	 * Depending on the submit button used, call a form or a save function.
	 *
	 * @param $par Mixed: string if any subpage provided, else null
	 */
	public function execute( $par ) {
		// If the visitor doesn't have permissions to assign or remove
		// any groups, it's a bit silly to give them the wiki_user search prompt.

		$wiki_user = $this->getwiki_user();

		/*
		 * If the wiki_user is blocked and they only have "partial" access
		 * (e.g. they don't have the wiki_userrights permission), then don't
		 * allow them to use Special:wiki_userRights.
		 */
		if( $wiki_user->isBlocked() && !$wiki_user->isAllowed( 'wiki_userrights' ) ) {
			throw new wiki_userBlockedError( $wiki_user->getBlock() );
		}

		$request = $this->getRequest();

		if( $par !== null ) {
			$this->mTarget = $par;
		} else {
			$this->mTarget = $request->getVal( 'wiki_user' );
		}

		$available = $this->changeableGroups();

		if ( $this->mTarget === null ) {
			/*
			 * If the wiki_user specified no target, and they can only
			 * edit their own groups, automatically set them as the
			 * target.
			 */
			if ( !count( $available['add'] ) && !count( $available['remove'] ) )
				$this->mTarget = $wiki_user->getName();
		}

		if ( wiki_user::getCanonicalName( $this->mTarget ) == $wiki_user->getName() ) {
			$this->isself = true;
		}

		if( !$this->wiki_userCanChangeRights( $wiki_user, true ) ) {
			// @todo FIXME: There may be intermediate groups we can mention.
			$msg = $wiki_user->isAnon() ? 'wiki_userrights-nologin' : 'wiki_userrights-notallowed';
			throw new PermissionsError( null, array( array( $msg ) ) );
		}

		$this->checkReadOnly();

		$this->setHeaders();
		$this->outputHeader();

		$out = $this->getOutput();
		$out->addModuleStyles( 'mediawiki.special' );

		// show the general form
		if ( count( $available['add'] ) || count( $available['remove'] ) ) {
			$this->switchForm();
		}

		if( $request->wasPosted() ) {
			// save settings
			if( $request->getCheck( 'savewiki_usergroups' ) ) {
				$reason = $request->getVal( 'wiki_user-reason' );
				$tok = $request->getVal( 'wpEditToken' );
				if( $wiki_user->matchEditToken( $tok, $this->mTarget ) ) {
					$this->savewiki_userGroups(
						$this->mTarget,
						$reason
					);

					$out->redirect( $this->getSuccessURL() );
					return;
				}
			}
		}

		// show some more forms
		if( $this->mTarget !== null ) {
			$this->editwiki_userGroupsForm( $this->mTarget );
		}
	}

	function getSuccessURL() {
		return $this->getTitle( $this->mTarget )->getFullURL();
	}

	/**
	 * Save wiki_user groups changes in the database.
	 * Data comes from the editwiki_userGroupsForm() form function
	 *
	 * @param $wiki_username String: wiki_username to apply changes to.
	 * @param $reason String: reason for group change
	 * @return null
	 */
	function savewiki_userGroups( $wiki_username, $reason = '' ) {
		$status = $this->fetchwiki_user( $wiki_username );
		if( !$status->isOK() ) {
			$this->getOutput()->addWikiText( $status->getWikiText() );
			return;
		} else {
			$wiki_user = $status->value;
		}

		$allgroups = $this->getAllGroups();
		$addgroup = array();
		$removegroup = array();

		// This could possibly create a highly unlikely race condition if permissions are changed between
		//  when the form is loaded and when the form is saved. Ignoring it for the moment.
		foreach ( $allgroups as $group ) {
			// We'll tell it to remove all unchecked groups, and add all checked groups.
			// Later on, this gets filtered for what can actually be removed
			if ( $this->getRequest()->getCheck( "wpGroup-$group" ) ) {
				$addgroup[] = $group;
			} else {
				$removegroup[] = $group;
			}
		}

		$this->doSavewiki_userGroups( $wiki_user, $addgroup, $removegroup, $reason );
	}

	/**
	 * Save wiki_user groups changes in the database.
	 *
	 * @param $wiki_user wiki_user object
	 * @param $add Array of groups to add
	 * @param $remove Array of groups to remove
	 * @param $reason String: reason for group change
	 * @return Array: Tuple of added, then removed groups
	 */
	function doSavewiki_userGroups( $wiki_user, $add, $remove, $reason = '' ) {
		// Validate input set...
		$isself = ( $wiki_user->getName() == $this->getwiki_user()->getName() );
		$groups = $wiki_user->getGroups();
		$changeable = $this->changeableGroups();
		$addable = array_merge( $changeable['add'], $isself ? $changeable['add-self'] : array() );
		$removable = array_merge( $changeable['remove'], $isself ? $changeable['remove-self'] : array() );

		$remove = array_unique(
			array_intersect( (array)$remove, $removable, $groups ) );
		$add = array_unique( array_diff(
			array_intersect( (array)$add, $addable ),
			$groups )
		);

		$oldGroups = $wiki_user->getGroups();
		$newGroups = $oldGroups;

		// remove then add groups
		if( $remove ) {
			$newGroups = array_diff( $newGroups, $remove );
			foreach( $remove as $group ) {
				$wiki_user->removeGroup( $group );
			}
		}
		if( $add ) {
			$newGroups = array_merge( $newGroups, $add );
			foreach( $add as $group ) {
				$wiki_user->addGroup( $group );
			}
		}
		$newGroups = array_unique( $newGroups );

		// Ensure that caches are cleared
		$wiki_user->invalidateCache();

		wfDebug( 'oldGroups: ' . print_r( $oldGroups, true ) );
		wfDebug( 'newGroups: ' . print_r( $newGroups, true ) );
		wfRunHooks( 'wiki_userRights', array( &$wiki_user, $add, $remove ) );

		if( $newGroups != $oldGroups ) {
			$this->addLogEntry( $wiki_user, $oldGroups, $newGroups, $reason );
		}
		return array( $add, $remove );
	}


	/**
	 * Add a rights log entry for an action.
	 */
	function addLogEntry( $wiki_user, $oldGroups, $newGroups, $reason ) {
		$log = new LogPage( 'rights' );

		$log->addEntry( 'rights',
			$wiki_user->getwiki_userPage(),
			$reason,
			array(
				$this->makeGroupNameListForLog( $oldGroups ),
				$this->makeGroupNameListForLog( $newGroups )
			)
		);
	}

	/**
	 * Edit wiki_user groups membership
	 * @param $wiki_username String: name of the wiki_user.
	 */
	function editwiki_userGroupsForm( $wiki_username ) {
		$status = $this->fetchwiki_user( $wiki_username );
		if( !$status->isOK() ) {
			$this->getOutput()->addWikiText( $status->getWikiText() );
			return;
		} else {
			$wiki_user = $status->value;
		}

		$groups = $wiki_user->getGroups();

		$this->showEditwiki_userGroupsForm( $wiki_user, $groups );

		// This isn't really ideal logging behavior, but let's not hide the
		// interwiki logs if we're using them as is.
		$this->showLogFragment( $wiki_user, $this->getOutput() );
	}

	/**
	 * Normalize the input wiki_username, which may be local or remote, and
	 * return a wiki_user (or proxy) object for manipulating it.
	 *
	 * Side effects: error output for invalid access
	 * @return Status object
	 */
	public function fetchwiki_user( $wiki_username ) {
		global $wgwiki_userrightsInterwikiDelimiter;

		$parts = explode( $wgwiki_userrightsInterwikiDelimiter, $wiki_username );
		if( count( $parts ) < 2 ) {
			$name = trim( $wiki_username );
			$database = '';
		} else {
			list( $name, $database ) = array_map( 'trim', $parts );

			if( $database == wfWikiID() ) {
				$database = '';
			} else {
				if( !$this->getwiki_user()->isAllowed( 'wiki_userrights-interwiki' ) ) {
					return Status::newFatal( 'wiki_userrights-no-interwiki' );
				}
				if( !wiki_userRightsProxy::validDatabase( $database ) ) {
					return Status::newFatal( 'wiki_userrights-nodatabase', $database );
				}
			}
		}

		if( $name === '' ) {
			return Status::newFatal( 'nowiki_userspecified' );
		}

		if( $name[0] == '#' ) {
			// Numeric ID can be specified...
			// We'll do a lookup for the name internally.
			$id = intval( substr( $name, 1 ) );

			if( $database == '' ) {
				$name = wiki_user::whoIs( $id );
			} else {
				$name = wiki_userRightsProxy::whoIs( $database, $id );
			}

			if( !$name ) {
				return Status::newFatal( 'noname' );
			}
		} else {
			$name = wiki_user::getCanonicalName( $name );
			if( $name === false ) {
				// invalid name
				return Status::newFatal( 'nosuchwiki_usershort', $wiki_username );
			}
		}

		if( $database == '' ) {
			$wiki_user = wiki_user::newFromName( $name );
		} else {
			$wiki_user = wiki_userRightsProxy::newFromName( $database, $name );
		}

		if( !$wiki_user || $wiki_user->isAnon() ) {
			return Status::newFatal( 'nosuchwiki_usershort', $wiki_username );
		}

		return Status::newGood( $wiki_user );
	}

	function makeGroupNameList( $ids ) {
		if( empty( $ids ) ) {
			return $this->msg( 'rightsnone' )->inContentLanguage()->text();
		} else {
			return implode( ', ', $ids );
		}
	}

	function makeGroupNameListForLog( $ids ) {
		if( empty( $ids ) ) {
			return '';
		} else {
			return $this->makeGroupNameList( $ids );
		}
	}

	/**
	 * Output a form to allow searching for a wiki_user
	 */
	function switchForm() {
		global $wgScript;
		$this->getOutput()->addHTML(
			Html::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'name' => 'ulwiki_user', 'id' => 'mw-wiki_userrights-form1' ) ) .
			Html::hidden( 'title',  $this->getTitle()->getPrefixedText() ) .
			Xml::fieldset( $this->msg( 'wiki_userrights-lookup-wiki_user' )->text() ) .
			Xml::inputLabel( $this->msg( 'wiki_userrights-wiki_user-editname' )->text(), 'wiki_user', 'wiki_username', 30, str_replace( '_', ' ', $this->mTarget ) ) . ' ' .
			Xml::submitButton( $this->msg( 'editwiki_usergroup' )->text() ) .
			Html::closeElement( 'fieldset' ) .
			Html::closeElement( 'form' ) . "\n"
		);
	}

	/**
	 * Go through used and available groups and return the ones that this
	 * form will be able to manipulate based on the current wiki_user's system
	 * permissions.
	 *
	 * @param $groups Array: list of groups the given wiki_user is in
	 * @return Array:  Tuple of addable, then removable groups
	 */
	protected function splitGroups( $groups ) {
		list( $addable, $removable, $addself, $removeself ) = array_values( $this->changeableGroups() );

		$removable = array_intersect(
			array_merge( $this->isself ? $removeself : array(), $removable ),
			$groups
		); // Can't remove groups the wiki_user doesn't have
		$addable = array_diff(
			array_merge( $this->isself ? $addself : array(), $addable ),
			$groups
		); // Can't add groups the wiki_user does have

		return array( $addable, $removable );
	}

	/**
	 * Show the form to edit group memberships.
	 *
	 * @param $wiki_user      wiki_user or wiki_userRightsProxy you're editing
	 * @param $groups    Array:  Array of groups the wiki_user is in
	 */
	protected function showEditwiki_userGroupsForm( $wiki_user, $groups ) {
		$list = array();
		foreach( $groups as $group ) {
			$list[] = self::buildGroupLink( $group );
		}

		$autolist = array();
		if ( $wiki_user instanceof wiki_user ) {
			foreach( Autopromote::getAutopromoteGroups( $wiki_user ) as $group ) {
				$autolist[] = self::buildGroupLink( $group );
			}
		}

		$grouplist = '';
		$count = count( $list );
		if( $count > 0 ) {
			$grouplist = $this->msg( 'wiki_userrights-groupsmember', $count, $wiki_user->getName() )->parse();
			$grouplist = '<p>' . $grouplist  . ' ' . $this->getLanguage()->listToText( $list ) . "</p>\n";
		}
		$count = count( $autolist );
		if( $count > 0 ) {
			$autogrouplistintro = $this->msg( 'wiki_userrights-groupsmember-auto', $count, $wiki_user->getName() )->parse();
			$grouplist .= '<p>' . $autogrouplistintro  . ' ' . $this->getLanguage()->listToText( $autolist ) . "</p>\n";
		}

		$wiki_userToolLinks = Linker::wiki_userToolLinks(
				$wiki_user->getId(),
				$wiki_user->getName(),
				false, /* default for redContribsWhenNoEdits */
				Linker::TOOL_LINKS_EMAIL /* Add "send e-mail" link */
		);

		$this->getOutput()->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalURL(), 'name' => 'editGroup', 'id' => 'mw-wiki_userrights-form2' ) ) .
			Html::hidden( 'wiki_user', $this->mTarget ) .
			Html::hidden( 'wpEditToken', $this->getwiki_user()->getEditToken( $this->mTarget ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), $this->msg( 'wiki_userrights-editwiki_usergroup', $wiki_user->getName() )->text() ) .
			$this->msg( 'editingwiki_user' )->params( wfEscapeWikiText( $wiki_user->getName() ) )->rawParams( $wiki_userToolLinks )->parse() .
			$this->msg( 'wiki_userrights-groups-help', $wiki_user->getName() )->parse() .
			$grouplist .
			Xml::tags( 'p', null, $this->groupCheckboxes( $groups, $wiki_user ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-wiki_userrights-table-outer' ) ) .
				"<tr>
					<td class='mw-label'>" .
						Xml::label( $this->msg( 'wiki_userrights-reason' )->text(), 'wpReason' ) .
					"</td>
					<td class='mw-input'>" .
						Xml::input( 'wiki_user-reason', 60, $this->getRequest()->getVal( 'wiki_user-reason', false ),
							array( 'id' => 'wpReason', 'maxlength' => 255 ) ) .
					"</td>
				</tr>
				<tr>
					<td></td>
					<td class='mw-submit'>" .
						Xml::submitButton( $this->msg( 'savewiki_usergroups' )->text(),
							array( 'name' => 'savewiki_usergroups' ) + Linker::tooltipAndAccesskeyAttribs( 'wiki_userrights-set' ) ) .
					"</td>
				</tr>" .
			Xml::closeElement( 'table' ) . "\n" .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}

	/**
	 * Format a link to a group description page
	 *
	 * @param $group string
	 * @return string
	 */
	private static function buildGroupLink( $group ) {
		static $cache = array();
		if( !isset( $cache[$group] ) )
			$cache[$group] = wiki_user::makeGroupLinkHtml( $group, htmlspecialchars( wiki_user::getGroupName( $group ) ) );
		return $cache[$group];
	}

	/**
	 * Returns an array of all groups that may be edited
	 * @return array Array of groups that may be edited.
	 */
	protected static function getAllGroups() {
		return wiki_user::getAllGroups();
	}

	/**
	 * Adds a table with checkboxes where you can select what groups to add/remove
	 *
	 * @todo Just pass the wiki_username string?
	 * @param $wiki_usergroups Array: groups the wiki_user belongs to
	 * @param $wiki_user wiki_user a wiki_user object
	 * @return string XHTML table element with checkboxes
	 */
	private function groupCheckboxes( $wiki_usergroups, $wiki_user ) {
		$allgroups = $this->getAllGroups();
		$ret = '';

		# Put all column info into an associative array so that extensions can
		# more easily manage it.
		$columns = array( 'unchangeable' => array(), 'changeable' => array() );

		foreach( $allgroups as $group ) {
			$set = in_array( $group, $wiki_usergroups );
			# Should the checkbox be disabled?
			$disabled = !(
				( $set && $this->canRemove( $group ) ) ||
				( !$set && $this->canAdd( $group ) ) );
			# Do we need to point out that this action is irreversible?
			$irreversible = !$disabled && (
				( $set && !$this->canAdd( $group ) ) ||
				( !$set && !$this->canRemove( $group ) ) );

			$checkbox = array(
				'set' => $set,
				'disabled' => $disabled,
				'irreversible' => $irreversible
			);

			if( $disabled ) {
				$columns['unchangeable'][$group] = $checkbox;
			} else {
				$columns['changeable'][$group] = $checkbox;
			}
		}

		# Build the HTML table
		$ret .=	Xml::openElement( 'table', array( 'class' => 'mw-wiki_userrights-groups' ) ) .
			"<tr>\n";
		foreach( $columns as $name => $column ) {
			if( $column === array() )
				continue;
			$ret .= Xml::element( 'th', null, $this->msg( 'wiki_userrights-' . $name . '-col', count( $column ) )->text() );
		}
		$ret.= "</tr>\n<tr>\n";
		foreach( $columns as $column ) {
			if( $column === array() )
				continue;
			$ret .= "\t<td style='vertical-align:top;'>\n";
			foreach( $column as $group => $checkbox ) {
				$attr = $checkbox['disabled'] ? array( 'disabled' => 'disabled' ) : array();

				$member = wiki_user::getGroupMember( $group, $wiki_user->getName() );
				if ( $checkbox['irreversible'] ) {
					$text = $this->msg( 'wiki_userrights-irreversible-marker', $member )->escaped();
				} else {
					$text = htmlspecialchars( $member );
				}
				$checkboxHtml = Xml::checkLabel( $text, "wpGroup-" . $group,
					"wpGroup-" . $group, $checkbox['set'], $attr );
				$ret .= "\t\t" . ( $checkbox['disabled']
					? Xml::tags( 'span', array( 'class' => 'mw-wiki_userrights-disabled' ), $checkboxHtml )
					: $checkboxHtml
				) . "<br />\n";
			}
			$ret .= "\t</td>\n";
		}
		$ret .= Xml::closeElement( 'tr' ) . Xml::closeElement( 'table' );

		return $ret;
	}

	/**
	 * @param  $group String: the name of the group to check
	 * @return bool Can we remove the group?
	 */
	private function canRemove( $group ) {
		// $this->changeableGroups()['remove'] doesn't work, of course. Thanks,
		// PHP.
		$groups = $this->changeableGroups();
		return in_array( $group, $groups['remove'] ) || ( $this->isself && in_array( $group, $groups['remove-self'] ) );
	}

	/**
	 * @param $group string: the name of the group to check
	 * @return bool Can we add the group?
	 */
	private function canAdd( $group ) {
		$groups = $this->changeableGroups();
		return in_array( $group, $groups['add'] ) || ( $this->isself && in_array( $group, $groups['add-self'] ) );
	}

	/**
	 * Returns $this->getwiki_user()->changeableGroups()
	 *
	 * @return Array array( 'add' => array( addablegroups ), 'remove' => array( removablegroups ) , 'add-self' => array( addablegroups to self), 'remove-self' => array( removable groups from self) )
	 */
	function changeableGroups() {
		return $this->getwiki_user()->changeableGroups();
	}

	/**
	 * Show a rights log fragment for the specified wiki_user
	 *
	 * @param $wiki_user wiki_user to show log for
	 * @param $output OutputPage to use
	 */
	protected function showLogFragment( $wiki_user, $output ) {
		$rightsLogPage = new LogPage( 'rights' );
		$output->addHTML( Xml::element( 'h2', null, $rightsLogPage->getName()->text() ) );
		LogEventsList::showLogExtract( $output, 'rights', $wiki_user->getwiki_userPage() );
	}
}
