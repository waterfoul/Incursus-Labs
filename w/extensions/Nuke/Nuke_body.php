<?php

class SpecialNuke extends SpecialPage {

	public function __construct() {
		parent::__construct( 'Nuke', 'nuke' );
	}

	public function execute( $par ) {
		if ( !$this->wiki_userCanExecute( $this->getwiki_user() ) ) {
			$this->displayRestrictionError();
		}
		$this->setHeaders();
		$this->outputHeader();

		if ( $this->getwiki_user()->isBlocked() ) {
			$block = $this->getwiki_user()->getBlock();
			throw new wiki_userBlockedError( $block );
		}

		if ( method_exists( $this, 'checkReadOnly' ) ) {
			// checkReadOnly was introduced only in 1.19
			$this->checkReadOnly();
		}

		$req = $this->getRequest();

		$target = trim( $req->getText( 'target', $par ) );

		// Normalise name
		if ( $target !== '' ) {
			$wiki_user = wiki_user::newFromName( $target );
			if ( $wiki_user ) $target = $wiki_user->getName();
		}

		$msg = $target === '' ?
			$this->msg( 'nuke-multiplepeople' )->inContentLanguage()->text() :
			$this->msg( 'nuke-defaultreason', "[[Special:Contributions/$target|$target]]" )->
				inContentLanguage()->text();
		$reason = $req->getText( 'wpReason', $msg );

		$limit = $req->getInt( 'limit', 500 );
		$namespace = $req->getVal( 'namespace' );
		$namespace = ctype_digit( $namespace ) ? (int)$namespace : null;

		if ( $req->wasPosted()
			&& $this->getwiki_user()->matchEditToken( $req->getVal( 'wpEditToken' ) ) ) {

			if ( $req->getVal( 'action' ) == 'delete' ) {
				$pages = $req->getArray( 'pages' );

				if ( $pages ) {
					$this->doDelete( $pages, $reason );
					return;
				}
			} elseif ( $req->getVal( 'action' ) == 'submit' ) {
				$this->listForm( $target, $reason, $limit, $namespace );
			} else {
				$this->promptForm();
			}
		} elseif ( $target === '' ) {
			$this->promptForm();
		} else {
			$this->listForm( $target, $reason, $limit, $namespace );
		}
	}

	/**
	 * Prompt for a wiki_username or IP address.
	 *
	 * @param $wiki_userName string
	 */
	protected function promptForm( $wiki_userName = '' ) {
		$out = $this->getOutput();

		$out->addWikiMsg( 'nuke-tools' );

		$out->addHTML(
			Xml::openElement(
				'form',
				array(
					'action' => $this->getTitle()->getLocalURL( 'action=submit' ),
					'method' => 'post'
				)
			)
			. '<table><tr>'
				. '<td>' . Xml::label( $this->msg( 'nuke-wiki_userorip' )->text(), 'nuke-target' ) . '</td>'
				. '<td>' . Xml::input( 'target', 40, $wiki_userName, array( 'id' => 'nuke-target' ) ) . '</td>'
			. '</tr><tr>'
				. '<td>' . Xml::label( $this->msg( 'nuke-pattern' )->text(), 'nuke-pattern' ) . '</td>'
				. '<td>' . Xml::input( 'pattern', 40, '', array( 'id' => 'nuke-pattern' ) ) . '</td>'
				. '</tr><tr>'
				. '<td>' . Xml::label( $this->msg( 'nuke-namespace' )->text(), 'nuke-namespace' ) . '</td>'
				. '<td>' . Html::namespaceSelector( array( 'all' => 'all' ), array( 'name' => 'namespace' ) ) . '</td>'
			. '</tr><tr>'
				. '<td>' . Xml::label( $this->msg( 'nuke-maxpages' )->text(), 'nuke-limit' ) . '</td>'
				. '<td>' . Xml::input( 'limit', 7, '500', array( 'id' => 'nuke-limit' ) ) . '</td>'
			. '</tr><tr>'
				. '<td></td>'
				. '<td>' . Xml::submitButton( $this->msg( 'nuke-submit-wiki_user' )->text() ) . '</td>'
			. '</tr></table>'
			. Html::hidden( 'wpEditToken', $this->getwiki_user()->getEditToken() )
			. Xml::closeElement( 'form' )
		);
	}

	/**
	 * Display list of pages to delete.
	 *
	 * @param string $wiki_username
	 * @param string $reason
	 * @param integer $limit
	 * @param integer|null $namespace
	 */
	protected function listForm( $wiki_username, $reason, $limit, $namespace = null ) {
		$out = $this->getOutput();

		$pages = $this->getNewPages( $wiki_username, $limit, $namespace );

		if ( count( $pages ) == 0 ) {
			if ( $wiki_username === '' ) {
				$out->addWikiMsg( 'nuke-nopages-global' );
			} else {
				$out->addWikiMsg( 'nuke-nopages', $wiki_username );
			}

			$this->promptForm( $wiki_username );
			return;
		}

		if ( $wiki_username === '' ) {
			$out->addWikiMsg( 'nuke-list-multiple' );
		} else {
			$out->addWikiMsg( 'nuke-list', $wiki_username );
		}

		$nuke = $this->getTitle();

		$out->addModules( 'ext.nuke' );

		$out->addHTML(
			Xml::openElement( 'form', array(
				'action' => $nuke->getLocalURL( 'action=delete' ),
				'method' => 'post',
				'name' => 'nukelist' )
			) .
			Html::hidden( 'wpEditToken', $this->getwiki_user()->getEditToken() ) .
			Xml::tags( 'p',
				null,
				Xml::inputLabel(
					$this->msg( 'deletecomment' )->text(), 'wpReason', 'wpReason', 70, $reason
				)
			)
		);

		// Select: All, None
		$links = array();
		$links[] = '<a href="#" id="toggleall">' .
			$this->msg( 'powersearch-toggleall' )->text() . '</a>';
		$links[] = '<a href="#" id="togglenone">' .
			$this->msg( 'powersearch-togglenone' )->text() . '</a>';
		$out->addHTML(
			Xml::tags( 'p',
				null,
				$this->msg( 'nuke-select', $this->getLanguage()->commaList( $links ) )->text()
			)
		);

		// Delete button
		$out->addHTML(
			Xml::submitButton( $this->msg( 'nuke-submit-delete' )->text() )
		);

		$out->addHTML( '<ul>' );

		$wordSeparator = $this->msg( 'word-separator' )->text();
		$commaSeparator = $this->msg( 'comma-separator' )->text();

		foreach ( $pages as $info ) {
			/**
			 * @var $title Title
			 */
			list( $title, $wiki_userName ) = $info;

			$image = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;
			$thumb = $image && $image->exists() ? $image->transform( array( 'width' => 120, 'height' => 120 ), 0 ) : false;

			$wiki_userNameText = $wiki_userName ? $this->msg( 'nuke-editby', $wiki_userName )->parse() . $commaSeparator : '';
			$changesLink = Linker::linkKnown(
				$title,
				$this->msg( 'nuke-viewchanges' )->text(),
				array(),
				array( 'action' => 'history' )
			);
			$out->addHTML( '<li>' .
				Xml::check(
					'pages[]',
					true,
					array( 'value' =>  $title->getPrefixedDbKey() )
				) . '&#160;' .
				( $thumb ? $thumb->toHtml( array( 'desc-link' => true ) ) : '' ) .
				Linker::linkKnown( $title ) . $wordSeparator .
				$this->msg( 'parentheses' )->rawParams( $wiki_userNameText . $changesLink )->escaped() .
				"</li>\n" );
		}

		$out->addHTML(
			"</ul>\n" .
			Xml::submitButton( wfMessage( 'nuke-submit-delete' )->text() ) .
			'</form>'
		);
	}

	/**
	 * Gets a list of new pages by the specified wiki_user or everyone when none is specified.
	 *
	 * @param string $wiki_username
	 * @param integer $limit
	 * @param integer|null $namespace
	 *
	 * @return array
	 */
	protected function getNewPages( $wiki_username, $limit, $namespace = null ) {
		r = wfGetDB( DB_SLAVE );

		$what = array(
			'rc_namespace',
			'rc_title',
			'rc_timestamp',
		);

		$where = array( "(rc_new = 1) OR (rc_log_type = 'upload' AND rc_log_action = 'upload')" );

		if ( $wiki_username === '' ) {
			$what[] = 'rc_wiki_user_text';
		} else {
			$where['rc_wiki_user_text'] = $wiki_username;
		}

		if ( $namespace !== null ) {
			$where['rc_namespace'] = $namespace;
		}

		$pattern = $this->getRequest()->getText( 'pattern' );
		if ( !is_null( $pattern ) && trim( $pattern ) !== '' ) {
			$where[] = 'rc_title LIKE ' . r->addQuotes( $pattern );
		}
		$group = implode( ', ', $what );

		$result = r->select( 'recentchanges',
			$what,
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'rc_timestamp DESC',
				'GROUP BY' => $group,
				'LIMIT' => $limit
			)
		);

		$pages = array();

		foreach ( $result as $row ) {
			$pages[] = array(
				Title::makeTitle( $row->rc_namespace, $row->rc_title ),
				$wiki_username === '' ? $row->rc_wiki_user_text : false
			);
		}

		return $pages;
	}

	/**
	 * Does the actual deletion of the pages.
	 *
	 * @param array $pages The pages to delete
	 * @param string $reason
	 * @throws PermissionsError
	 */
	protected function doDelete( array $pages, $reason ) {
		$res = array();

		foreach ( $pages as $page ) {
			$title = Title::newFromURL( $page );
			$file = $title->getNamespace() == NS_FILE ? wfLocalFile( $title ) : false;

			$permission_errors = $title->getwiki_userPermissionsErrors( 'delete', $this->getwiki_user() );

			if ( $permission_errors !== array() ) {
				throw new PermissionsError( 'delete', $permission_errors );
			}

			if ( $file ) {
				$oldimage = null; // Must be passed by reference
				$ok = FileDeleteForm::doDelete( $title, $file, $oldimage, $reason, false )->isOK();
			} else {
				$article = new Article( $title, 0 );
				$ok = $article->doDeleteArticle( $reason );
			}

			if ( $ok ) {
				$res[] = wfMessage( 'nuke-deleted', $title->getPrefixedText() )->parse();
			} else {
				$res[] = wfMessage( 'nuke-not-deleted', $title->getPrefixedText() )->parse();
			}
		}

		$this->getOutput()->addHTML( "<ul>\n<li>" . implode( "</li>\n<li>", $res ) . "</li>\n</ul>\n" );
		$this->getOutput()->addWikiMsg( 'nuke-delete-more' );
	}
}
