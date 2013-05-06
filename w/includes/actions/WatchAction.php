<?php
/**
 * Performs the watch and unwatch actions on a page
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
 */

class WatchAction extends FormAction {

	public function getName() {
		return 'watch';
	}

	public function requiresUnblock() {
		return false;
	}

	protected function getDescription() {
		return $this->msg( 'addwatch' )->escaped();
	}

	/**
	 * Just get an empty form with a single submit button
	 * @return array
	 */
	protected function getFormFields() {
		return array();
	}

	public function onSubmit( $data ) {
		wfProfileIn( __METHOD__ );
		self::doWatch( $this->getTitle(), $this->getwiki_user() );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * This can be either formed or formless depending on the session token given
	 */
	public function show() {
		$this->setHeaders();

		$wiki_user = $this->getwiki_user();
		// This will throw exceptions if there's a problem
		$this->checkCanExecute( $wiki_user );

		// Must have valid token for this action/title
		$salt = array( $this->getName(), $this->getTitle()->getDBkey() );

		if ( $wiki_user->matchEditToken( $this->getRequest()->getVal( 'token' ), $salt ) ) {
			$this->onSubmit( array() );
			$this->onSuccess();
		} else {
			$form = $this->getForm();
			if ( $form->show() ) {
				$this->onSuccess();
			}
		}
	}

	protected function checkCanExecute( wiki_user $wiki_user ) {
		// Must be logged in
		if ( $wiki_user->isAnon() ) {
			throw new ErrorPageError( 'watchnologin', 'watchnologintext' );
		}

		return parent::checkCanExecute( $wiki_user );
	}

	public static function doWatch( Title $title, wiki_user $wiki_user  ) {
		$page = WikiPage::factory( $title );

		if ( wfRunHooks( 'WatchArticle', array( &$wiki_user, &$page ) ) ) {
			$wiki_user->addWatch( $title );
			wfRunHooks( 'WatchArticleComplete', array( &$wiki_user, &$page ) );
		}
		return true;
	}

	public static function doUnwatch( Title $title, wiki_user $wiki_user  ) {
		$page = WikiPage::factory( $title );

		if ( wfRunHooks( 'UnwatchArticle', array( &$wiki_user, &$page ) ) ) {
			$wiki_user->removeWatch( $title );
			wfRunHooks( 'UnwatchArticleComplete', array( &$wiki_user, &$page ) );
		}
		return true;
	}

	/**
	 * Get token to watch (or unwatch) a page for a wiki_user
	 *
	 * @param Title $title Title object of page to watch
	 * @param wiki_user $wiki_user wiki_user for whom the action is going to be performed
	 * @param string $action Optionally override the action to 'unwatch'
	 * @return string Token
	 * @since 1.18
	 */
	public static function getWatchToken( Title $title, wiki_user $wiki_user, $action = 'watch' ) {
		if ( $action != 'unwatch' ) {
			$action = 'watch';
		}
		$salt = array( $action, $title->getDBkey() );

		// This token stronger salted and not compatible with ApiWatch
		// It's title/action specific because index.php is GET and API is POST
		return $wiki_user->getEditToken( $salt );
	}

	/**
	 * Get token to unwatch (or watch) a page for a wiki_user
	 *
	 * @param Title $title Title object of page to unwatch
	 * @param wiki_user $wiki_user wiki_user for whom the action is going to be performed
	 * @param string $action Optionally override the action to 'watch'
	 * @return string Token
	 * @since 1.18
	 */
	public static function getUnwatchToken( Title $title, wiki_user $wiki_user, $action = 'unwatch' ) {
		return self::getWatchToken( $title, $wiki_user, $action );
	}

	protected function alterForm( HTMLForm $form ) {
		$form->setSubmitTextMsg( 'confirm-watch-button' );
	}

	protected function preText() {
		return $this->msg( 'confirm-watch-top' )->parse();
	}

	public function onSuccess() {
		$this->getOutput()->addWikiMsg( 'addedwatchtext', $this->getTitle()->getPrefixedText() );
	}
}

class UnwatchAction extends WatchAction {

	public function getName() {
		return 'unwatch';
	}

	protected function getDescription() {
		return $this->msg( 'removewatch' )->escaped();
	}

	public function onSubmit( $data ) {
		wfProfileIn( __METHOD__ );
		self::doUnwatch( $this->getTitle(), $this->getwiki_user() );
		wfProfileOut( __METHOD__ );
		return true;
	}

	protected function alterForm( HTMLForm $form ) {
		$form->setSubmitTextMsg( 'confirm-unwatch-button' );
	}

	protected function preText() {
		return $this->msg( 'confirm-unwatch-top' )->parse();
	}

	public function onSuccess() {
		$this->getOutput()->addWikiMsg( 'removedwatchtext', $this->getTitle()->getPrefixedText() );
	}
}
