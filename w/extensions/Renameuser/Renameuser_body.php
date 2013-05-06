<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Renamewiki_user extension\n";
	exit( 1 );
}

/**
 * Special page allows authorised wiki_users to rename
 * wiki_user accounts
 */
class SpecialRenamewiki_user extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Renamewiki_user', 'renamewiki_user' );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 */
	public function execute( $par ) {
		global $wgOut, $wgwiki_user, $wgRequest, $wgContLang;
		global $wgCapitalLinks;

		$this->setHeaders();
		$wgOut->addWikiMsg( 'renamewiki_user-summary' );

		if ( !$wgwiki_user->isAllowed( 'renamewiki_user' ) ) {
			$wgOut->permissionRequired( 'renamewiki_user' );
			return;
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if( $wgwiki_user->isBlocked() ){
			$wgOut->blockedPage();
		}

		$showBlockLog = $wgRequest->getBool( 'submit-showBlockLog' );
		$oldnamePar = trim( str_replace( '_', ' ', $wgRequest->getText( 'oldwiki_username', $par ) ) );
		$oldwiki_username = Title::makeTitle( NS_USER, $oldnamePar );
		// Force uppercase of newwiki_username, otherwise wikis with wgCapitalLinks=false can create lc wiki_usernames
		$newwiki_username = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $wgRequest->getText( 'newwiki_username' ) ) );
		$oun = is_object( $oldwiki_username ) ? $oldwiki_username->getText() : '';
		$nun = is_object( $newwiki_username ) ? $newwiki_username->getText() : '';
		$token = $wgwiki_user->editToken();
		$reason = $wgRequest->getText( 'reason' );

		$move_checked = $wgRequest->getBool( 'movepages', !$wgRequest->wasPosted());
		$suppress_checked = $wgRequest->getCheck( 'suppressredirect' );

		$warnings = array();
		if ( $oun && $nun && !$wgRequest->getCheck( 'confirmaction' )  ) {
			wfRunHooks( 'Renamewiki_userWarning', array( $oun, $nun, &$warnings ) );
		}

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl(), 'id' => 'renamewiki_user' ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'renamewiki_user' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-renamewiki_user-table' ) ) .
			"<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'renamewiki_userold' ), 'oldwiki_username' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'oldwiki_username', 20, $oun, array( 'type' => 'text', 'tabindex' => '1' ) ) . ' ' .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'renamewiki_usernew' ), 'newwiki_username' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'newwiki_username', 20, $nun, array( 'type' => 'text', 'tabindex' => '2' ) ) .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'renamewiki_userreason' ), 'reason' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'reason', 40, $reason, array( 'type' => 'text', 'tabindex' => '3', 'maxlength' => 255 ) ) .
				"</td>
			</tr>"
		);
		if ( $wgwiki_user->isAllowed( 'move' ) ) {
			$wgOut->addHTML( "
				<tr>
					<td>&#160;
					</td>
					<td class='mw-input'>" .
						Xml::checkLabel( wfMsg( 'renamewiki_usermove' ), 'movepages', 'movepages',
							$move_checked, array( 'tabindex' => '4' ) ) .
					"</td>
				</tr>"
			);

			if ( $wgwiki_user->isAllowed( 'suppressredirect' ) ) {
				$wgOut->addHTML( "
					<tr>
						<td>&#160;
						</td>
						<td class='mw-input'>" .
							Xml::checkLabel( wfMsg( 'renamewiki_usersuppress' ), 'suppressredirect', 'suppressredirect',
								$suppress_checked, array( 'tabindex' => '5' ) ) .
						"</td>
					</tr>"
				);
			}
		}
		if ( $warnings ) {
			$warningsHtml = array();
			foreach ( $warnings as $warning )
				$warningsHtml[] = is_array( $warning ) ?
					call_user_func_array( 'wfMsgWikiHtml', $warning ) :
					wfMsgHtml( $warning );
			$wgOut->addHTML( "
				<tr>
					<td class='mw-label'>" . wfMsgWikiHtml( 'renamewiki_userwarnings' ) . "
					</td>
					<td class='mw-input'>" .
						'<ul style="color: red; font-weight: bold"><li>' .
							implode( '</li><li>', $warningsHtml ) . '</li></ul>' .
					"</td>
				</tr>"
			);
			$wgOut->addHTML( "
				<tr>
					<td>&#160;
					</td>
					<td class='mw-input'>" .
						Xml::checkLabel( wfMsg( 'renamewiki_userconfirm' ), 'confirmaction', 'confirmaction',
							false, array( 'tabindex' => '6' ) ) .
					"</td>
				</tr>"
			);
		}
		$wgOut->addHTML( "
			<tr>
				<td>&#160;
				</td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'renamewiki_usersubmit' ), array( 'name' => 'submit',
						'tabindex' => '7', 'id' => 'submit' ) ) .
					' ' .
					Xml::submitButton(
						wfMsg( 'renamewiki_user-submit-blocklog' ),
						array (
							'name' => 'submit-showBlockLog',
							'id' => 'submit-showBlockLog',
							'tabindex' => '8'
						)
					) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Html::hidden( 'token', $token ) .
			Xml::closeElement( 'form' ) . "\n"
		);

		// Show block log if requested
		if ( $showBlockLog && is_object( $oldwiki_username ) ) {
			$this->showLogExtract( $oldwiki_username, 'block', $wgOut ) ;
			return;
		}

		if ( $wgRequest->getText( 'token' ) === '' ) {
			# They probably haven't even submitted the form, so don't go further.
			return;
		} elseif ( $warnings ) {
			# Let wiki_user read warnings
			return;
		} elseif ( !$wgRequest->wasPosted() || !$wgwiki_user->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>", 'renamewiki_user-error-request' );
			return;
		} elseif ( !is_object( $oldwiki_username ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renamewiki_usererrorinvalid', $wgRequest->getText( 'oldwiki_username' ) ) );
			return;
		} elseif ( !is_object( $newwiki_username ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renamewiki_usererrorinvalid', $wgRequest->getText( 'newwiki_username' ) ) );
			return;
		} elseif ( $oldwiki_username->getText() == $newwiki_username->getText() ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>", 'renamewiki_user-error-same-wiki_user' );
			return;
		}

		// Suppress wiki_username validation of old wiki_username
		$oldwiki_user = wiki_user::newFromName( $oldwiki_username->getText(), false );
		$newwiki_user = wiki_user::newFromName( $newwiki_username->getText(), 'creatable' );

		// It won't be an object if for instance "|" is supplied as a value
		if ( !is_object( $oldwiki_user ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renamewiki_usererrorinvalid', $oldwiki_username->getText() ) );
			return;
		}
		if ( !is_object( $newwiki_user ) || !wiki_user::isCreatableName( $newwiki_user->getName() ) ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renamewiki_usererrorinvalid', $newwiki_username->getText() ) );
			return;
		}

		// Check for the existence of lowercase oldwiki_username in database.
		// Until r19631 it was possible to rename a wiki_user to a name with first character as lowercase
		if ( $oldwiki_username->getText() !== $wgContLang->ucfirst( $oldwiki_username->getText() ) ) {
			// oldwiki_username was entered as lowercase -> check for existence in table 'wiki_user'
			r = wfGetDB( DB_SLAVE );
			$uid = r->selectField( 'wiki_user', 'wiki_user_id',
				array( 'wiki_user_name' => $oldwiki_username->getText() ),
				__METHOD__ );
			if ( $uid === false ) {
				if ( !$wgCapitalLinks ) {
					$uid = 0; // We are on a lowercase wiki but lowercase wiki_username does not exists
				} else {
					// We are on a standard uppercase wiki, use normal
					$uid = $oldwiki_user->idForName();
					$oldwiki_username = Title::makeTitleSafe( NS_USER, $oldwiki_user->getName() );
				}
			}
		} else {
			// oldwiki_username was entered as upperase -> standard procedure
			$uid = $oldwiki_user->idForName();
		}

		if ( $uid == 0 ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renamewiki_usererrordoesnotexist', $oldwiki_username->getText() ) );
			return;
		}

		if ( $newwiki_user->idForName() != 0 ) {
			$wgOut->wrapWikiMsg( "<div class=\"errorbox\">$1</div>",
				array( 'renamewiki_usererrorexists', $newwiki_username->getText() ) );
			return;
		}

		// Always get the edits count, it will be used for the log message
		$contribs = wiki_user::edits( $uid );

		// Give other affected extensions a chance to validate or abort
		if ( !wfRunHooks( 'Renamewiki_userAbort', array( $uid, $oldwiki_username->getText(), $newwiki_username->getText() ) ) ) {
			return;
		}

		// Do the heavy lifting...
		$rename = new Renamewiki_userSQL( $oldwiki_username->getText(), $newwiki_username->getText(), $uid );
		if ( !$rename->rename() ) {
			return;
		}

		// If this wiki_user is renaming his/herself, make sure that Title::moveTo()
		// doesn't make a bunch of null move edits under the old name!
		if ( $wgwiki_user->getId() == $uid ) {
			$wgwiki_user->setName( $newwiki_username->getText() );
		}

		// Log this rename
		$log = new LogPage( 'renamewiki_user' );
		$log->addEntry( 'renamewiki_user', $oldwiki_username, wfMsgExt( 'renamewiki_user-log', array( 'parsemag', 'content' ),
			$wgContLang->formatNum( $contribs ), $reason ), $newwiki_username->getText() );

		// Move any wiki_user pages
		if ( $wgRequest->getCheck( 'movepages' ) && $wgwiki_user->isAllowed( 'move' ) ) {
			r = wfGetDB( DB_SLAVE );

			$pages = r->select(
				'page',
				array( 'page_namespace', 'page_title' ),
				array(
					'page_namespace IN (' . NS_USER . ',' . NS_USER_TALK . ')',
					'(page_title ' . r->buildLike( $oldwiki_username->getDBkey() . '/', r->anyString() ) .
						' OR page_title = ' . r->addQuotes( $oldwiki_username->getDBkey() ) . ')'
				),
				__METHOD__
			);

			$suppressRedirect = false;

			if ( $wgRequest->getCheck( 'suppressredirect' ) && $wgwiki_user->isAllowed( 'suppressredirect' ) ) {
				$suppressRedirect = true;
			}

			$output = '';
			foreach ( $pages as $row ) {
				$oldPage = Title::makeTitleSafe( $row->page_namespace, $row->page_title );
				$newPage = Title::makeTitleSafe( $row->page_namespace,
					preg_replace( '!^[^/]+!', $newwiki_username->getDBkey(), $row->page_title ) );
				# Do not autodelete or anything, title must not exist
				if ( $newPage->exists() && !$oldPage->isValidMoveTarget( $newPage ) ) {
					$link = Linker::linkKnown( $newPage );
					$output .= Html::rawElement(
								'li',
								array( 'class' => 'mw-renamewiki_user-pe' ),
								wfMessage( 'renamewiki_user-page-exists' )->rawParams( $link )->escaped()
							);
				} else {
					$success = $oldPage->moveTo(
								$newPage,
								false,
								wfMessage(
									'renamewiki_user-move-log',
									$oldwiki_username->getText(),
									$newwiki_username->getText() )->inContentLanguage()->text(),
								!$suppressRedirect
							);
					if ( $success === true ) {
						# oldPage is not known in case of redirect suppression
						$oldLink = Linker::link( $oldPage, null, array(), array( 'redirect' => 'no' ) );

						# newPage is always known because the move was successful
						$newLink = Linker::linkKnown( $newPage );

						$output .= Html::rawElement(
									'li',
									array( 'class' => 'mw-renamewiki_user-pm' ),
									wfMessage( 'renamewiki_user-page-moved' )->rawParams( $oldLink, $newLink )->escaped()
								);
					} else {
						$oldLink = Linker::linkKnown( $oldPage );
						$newLink = Linker::link( $newPage );
						$output .= Html::rawElement(
									'li', array( 'class' => 'mw-renamewiki_user-pu' ),
									wfMessage( 'renamewiki_user-page-unmoved' )->rawParams( $oldLink, $newLink )->escaped()
								);
					}
				}
			}
			if ( $output ) {
				$wgOut->addHTML( Html::rawElement( 'ul', array(), $output ) );
			}
		}

		// Output success message stuff :)
		$wgOut->wrapWikiMsg( "<div class=\"successbox\">$1</div><br style=\"clear:both\" />",
			array( 'renamewiki_usersuccess', $oldwiki_username->getText(), $newwiki_username->getText() ) );
	}

	/**
	 * @param $wiki_username Title
	 * @param $type
	 * @param $out OutputPage
	 */
	function showLogExtract( $wiki_username, $type, &$out ) {
		# Show relevant lines from the logs:
		$out->addHTML( Xml::element( 'h2', null, LogPage::logName( $type ) ) . "\n" );
		LogEventsList::showLogExtract( $out, $type, $wiki_username->getPrefixedText() );
	}
}

class Renamewiki_userSQL {
	/**
	  * The old wiki_username
	  *
	  * @var string
	  * @access private
	  */
	var $old;

	/**
	  * The new wiki_username
	  *
	  * @var string
	  * @access private
	  */
	var $new;

	/**
	  * The wiki_user ID
	  *
	  * @var integer
	  * @access private
	  */
	var $uid;

	/**
	  * The the tables => fields to be updated
	  *
	  * @var array
	  * @access private
	  */
	var $tables;

	/**
	 * Constructor
	 *
	 * @param $old string The old wiki_username
	 * @param $new string The new wiki_username
	 * @param $uid
	 */
	function __construct( $old, $new, $uid ) {
		$this->old = $old;
		$this->new = $new;
		$this->uid = $uid;

		$this->tables = array(); // Immediate updates
		$this->tables['image'] = array( 'img_wiki_user_text', 'img_wiki_user' );
		$this->tables['oldimage'] = array( 'oi_wiki_user_text', 'oi_wiki_user' );
		$this->tables['filearchive'] = array('fa_wiki_user_text','fa_wiki_user');
		$this->tablesJob = array(); // Slow updates
		// If this wiki_user has a large number of edits, use the jobqueue
		if ( wiki_user::edits( $this->uid ) > RENAMEUSER_CONTRIBJOB ) {
			$this->tablesJob['revision'] = array( 'rev_wiki_user_text', 'rev_wiki_user', 'rev_timestamp' );
			$this->tablesJob['archive'] = array( 'ar_wiki_user_text', 'ar_wiki_user', 'ar_timestamp' );
			$this->tablesJob['logging'] = array( 'log_wiki_user_text', 'log_wiki_user', 'log_timestamp' );
		} else {
			$this->tables['revision'] = array( 'rev_wiki_user_text', 'rev_wiki_user' );
			$this->tables['archive'] = array( 'ar_wiki_user_text', 'ar_wiki_user' );
			$this->tables['logging'] = array( 'log_wiki_user_text', 'log_wiki_user' );
		}
		// Recent changes is pretty hot, deadlocks occur if done all at once
		if ( wfQueriesMustScale() ) {
			$this->tablesJob['recentchanges'] = array( 'rc_wiki_user_text', 'rc_wiki_user', 'rc_timestamp' );
		} else {
			$this->tables['recentchanges'] = array( 'rc_wiki_user_text', 'rc_wiki_user' );
		}

		wfRunHooks( 'Renamewiki_userSQL', array( $this ) );
	}

	/**
	 * Do the rename operation
	 */
	function rename() {
		global $wgMemc, $wgAuth, $wgUpdateRowsPerJob;

		wfProfileIn( __METHOD__ );

		w = wfGetDB( DB_MASTER );
		w->begin();
		wfRunHooks( 'Renamewiki_userPreRename', array( $this->uid, $this->old, $this->new ) );

		// Rename and touch the wiki_user before re-attributing edits,
		// this avoids wiki_users still being logged in and making new edits while
		// being renamed, which leaves edits at the old name.
		w->update( 'wiki_user',
			array( 'wiki_user_name' => $this->new, 'wiki_user_touched' => w->timestamp() ),
			array( 'wiki_user_name' => $this->old ),
			__METHOD__
		);
		if ( !w->affectedRows() ) {
			w->rollback();
			return false;
		}
		// Reset token to break login with central auth systems.
		// Again, avoids wiki_user being logged in with old name.
		$wiki_user = wiki_user::newFromId( $this->uid );
		$authwiki_user = $wgAuth->getwiki_userInstance( $wiki_user );
		$authwiki_user->resetAuthToken();

		// Delete from memcached.
		$wgMemc->delete( wfMemcKey( 'wiki_user', 'id', $this->uid ) );

		// Update ipblock list if this wiki_user has a block in there.
		w->update( 'ipblocks',
			array( 'ipb_address' => $this->new ),
			array( 'ipb_wiki_user' => $this->uid, 'ipb_address' => $this->old ),
			__METHOD__ );
		// Update this wiki_users block/rights log. Ideally, the logs would be historical,
		// but it is really annoying when wiki_users have "clean" block logs by virtue of
		// being renamed, which makes admin tasks more of a pain...
		$oldTitle = Title::makeTitle( NS_USER, $this->old );
		$newTitle = Title::makeTitle( NS_USER, $this->new );
		w->update( 'logging',
			array( 'log_title' => $newTitle->getDBkey() ),
			array( 'log_type' => array( 'block', 'rights' ),
				'log_namespace' => NS_USER,
				'log_title' => $oldTitle->getDBkey() ),
			__METHOD__ );
		// Do immediate updates!
		foreach ( $this->tables as $table => $fieldSet ) {
			list( $nameCol, $wiki_userCol ) = $fieldSet;
			w->update( $table,
				array( $nameCol => $this->new ),
				array( $nameCol => $this->old, $wiki_userCol => $this->uid ),
				__METHOD__
			);
		}

		// Increase time limit (like Checkwiki_user); this can take a while...
		if ( $this->tablesJob ) {
			wfSuppressWarnings();
			set_time_limit( 120 );
			wfRestoreWarnings();
		}

		$jobs = array(); // jobs for all tables
		// Construct jobqueue updates...
		// FIXME: if a bureaucrat renames a wiki_user in error, he/she
		// must be careful to wait until the rename finishes before
		// renaming back. This is due to the fact the the job "queue"
		// is not really FIFO, so we might end up with a bunch of edits
		// randomly mixed between the two new names. Some sort of rename
		// lock might be in order...
		foreach ( $this->tablesJob as $table => $params ) {
			$wiki_userTextC = $params[0]; // some *_wiki_user_text column
			$wiki_userIDC = $params[1]; // some *_wiki_user column
			$timestampC = $params[2]; // some *_timestamp column

			$res = w->select( $table,
				array( $timestampC ),
				array( $wiki_userTextC => $this->old, $wiki_userIDC => $this->uid ),
				__METHOD__,
				array( 'ORDER BY' => "$timestampC ASC" )
			);

			$jobParams = array();
			$jobParams['table'] = $table;
			$jobParams['column'] = $wiki_userTextC;
			$jobParams['uidColumn'] = $wiki_userIDC;
			$jobParams['timestampColumn'] = $timestampC;
			$jobParams['oldname'] = $this->old;
			$jobParams['newname'] = $this->new;
			$jobParams['wiki_userID'] = $this->uid;
			// Timestamp column data for index optimizations
			$jobParams['minTimestamp'] = '0';
			$jobParams['maxTimestamp'] = '0';
			$jobParams['count'] = 0;

			// Insert jobs into queue!
			while ( true ) {
				$row = w->fetchObject( $res );
				if ( !$row ) {
					# If there are any job rows left, add it to the queue as one job
					if ( $jobParams['count'] > 0 ) {
						$jobs[] = Job::factory( 'renamewiki_user', $oldTitle, $jobParams );
					}
					break;
				}
				# Since the ORDER BY is ASC, set the min timestamp with first row
				if ( $jobParams['count'] == 0 ) {
					$jobParams['minTimestamp'] = $row->$timestampC;
				}
				# Keep updating the last timestamp, so it should be correct
				# when the last item is added.
				$jobParams['maxTimestamp'] = $row->$timestampC;
				# Update row counter
				$jobParams['count']++;
				# Once a job has $wgUpdateRowsPerJob rows, add it to the queue
				if ( $jobParams['count'] >= $wgUpdateRowsPerJob ) {
					$jobs[] = Job::factory( 'renamewiki_user', $oldTitle, $jobParams );
					$jobParams['minTimestamp'] = '0';
					$jobParams['maxTimestamp'] = '0';
					$jobParams['count'] = 0;
				}
			}
			w->freeResult( $res );
		}

		if ( count( $jobs ) > 0 ) {
			Job::safeBatchInsert( $jobs ); // don't commit yet
		}

		// Commit the transaction
		w->commit();

		// Delete from memcached again to make sure
		$wgMemc->delete( wfMemcKey( 'wiki_user', 'id', $this->uid ) );

		// Clear caches and inform authentication plugins
		$wiki_user = wiki_user::newFromId( $this->uid );
		$wgAuth->updateExternalDB( $wiki_user );
		wfRunHooks( 'Renamewiki_userComplete', array( $this->uid, $this->old, $this->new ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
