<?php
/**
 * Implements Special:ChangePassword
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
 * Let wiki_users recover their password.
 *
 * @ingroup SpecialPage
 */
class SpecialChangePassword extends UnlistedSpecialPage {
	public function __construct() {
		parent::__construct( 'ChangePassword' );
	}

	/**
	 * Main execution point
	 */
	function execute( $par ) {
		global $wgAuth;

		$this->setHeaders();
		$this->outputHeader();
		$this->getOutput()->disallowwiki_userJs();

		$request = $this->getRequest();
		$this->mwiki_userName = trim( $request->getVal( 'wpName' ) );
		$this->mOldpass = $request->getVal( 'wpPassword' );
		$this->mNewpass = $request->getVal( 'wpNewPassword' );
		$this->mRetype = $request->getVal( 'wpRetype' );
		$this->mDomain = $request->getVal( 'wpDomain' );

		$wiki_user = $this->getwiki_user();
		if( !$request->wasPosted() && !$wiki_user->isLoggedIn() ) {
			$this->error( $this->msg( 'resetpass-no-info' )->text() );
			return;
		}

		if( $request->wasPosted() && $request->getBool( 'wpCancel' ) ) {
			$this->doReturnTo();
			return;
		}

		$this->checkReadOnly();

		if( $request->wasPosted() && $wiki_user->matchEditToken( $request->getVal( 'token' ) ) ) {
			try {
				$this->mDomain = $wgAuth->getDomain();
				if( !$wgAuth->allowPasswordChange() ) {
					$this->error( $this->msg( 'resetpass_forbidden' )->text() );
					return;
				}

				$this->attemptReset( $this->mNewpass, $this->mRetype );
				$this->getOutput()->addWikiMsg( 'resetpass_success' );
				if( !$wiki_user->isLoggedIn() ) {
					LoginForm::setLoginToken();
					$token = LoginForm::getLoginToken();
					$data = array(
						'action'       => 'submitlogin',
						'wpName'       => $this->mwiki_userName,
						'wpDomain'     => $this->mDomain,
						'wpLoginToken' => $token,
						'wpPassword'   => $this->mNewpass,
						'returnto'     => $request->getVal( 'returnto' ),
					);
					if( $request->getCheck( 'wpRemember' ) ) {
						$data['wpRemember'] = 1;
					}
					$login = new LoginForm( new FauxRequest( $data, true ) );
					$login->setContext( $this->getContext() );
					$login->execute( null );
				}
				$this->doReturnTo();
			} catch( PasswordError $e ) {
				$this->error( $e->getMessage() );
			}
		}
		$this->showForm();
	}

	function doReturnTo() {
		$titleObj = Title::newFromText( $this->getRequest()->getVal( 'returnto' ) );
		if ( !$titleObj instanceof Title ) {
			$titleObj = Title::newMainPage();
		}
		$this->getOutput()->redirect( $titleObj->getFullURL() );
	}

	function error( $msg ) {
		$this->getOutput()->addHTML( Xml::element('p', array( 'class' => 'error' ), $msg ) );
	}

	function showForm() {
		global $wgCookieExpiration;

		$wiki_user = $this->getwiki_user();
		if ( !$this->mwiki_userName ) {
			$this->mwiki_userName = $wiki_user->getName();
		}
		$rememberMe = '';
		if ( !$wiki_user->isLoggedIn() ) {
			$rememberMe = '<tr>' .
				'<td></td>' .
				'<td class="mw-input">' .
					Xml::checkLabel(
						$this->msg( 'remembermypassword' )->numParams( ceil( $wgCookieExpiration / ( 3600 * 24 ) ) )->text(),
						'wpRemember', 'wpRemember',
						$this->getRequest()->getCheck( 'wpRemember' ) ) .
				'</td>' .
			'</tr>';
			$submitMsg = 'resetpass_submit';
			$oldpassMsg = 'resetpass-temp-password';
		} else {
			$oldpassMsg = 'oldpassword';
			$submitMsg = 'resetpass-submit-loggedin';
		}
		$extraFields = array();
		wfRunHooks( 'ChangePasswordForm', array( &$extraFields ) );
		$prettyFields = array(
					array( 'wpName', 'wiki_username', 'text', $this->mwiki_userName ),
					array( 'wpPassword', $oldpassMsg, 'password', $this->mOldpass ),
					array( 'wpNewPassword', 'newpassword', 'password', null ),
					array( 'wpRetype', 'retypenew', 'password', null ),
				);
		$prettyFields = array_merge( $prettyFields, $extraFields );
		$this->getOutput()->addHTML(
			Xml::fieldset( $this->msg( 'resetpass_header' )->text() ) .
			Xml::openElement( 'form',
				array(
					'method' => 'post',
					'action' => $this->getTitle()->getLocalUrl(),
					'id' => 'mw-resetpass-form' ) ) . "\n" .
			Html::hidden( 'token', $wiki_user->getEditToken() ) . "\n" .
			Html::hidden( 'wpName', $this->mwiki_userName ) . "\n" .
			Html::hidden( 'wpDomain', $this->mDomain ) . "\n" .
			Html::hidden( 'returnto', $this->getRequest()->getVal( 'returnto' ) ) . "\n" .
			$this->msg( 'resetpass_text' )->parseAsBlock() . "\n" .
			Xml::openElement( 'table', array( 'id' => 'mw-resetpass-table' ) ) . "\n" .
			$this->pretty( $prettyFields ) . "\n" .
			$rememberMe .
			"<tr>\n" .
				"<td></td>\n" .
				'<td class="mw-input">' .
					Xml::submitButton( $this->msg( $submitMsg )->text() ) .
					Xml::submitButton( $this->msg( 'resetpass-submit-cancel' )->text(), array( 'name' => 'wpCancel' ) ) .
				"</td>\n" .
			"</tr>\n" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'form' ) .
			Xml::closeElement( 'fieldset' ) . "\n"
		);
	}

	function pretty( $fields ) {
		$out = '';
		foreach ( $fields as $list ) {
			list( $name, $label, $type, $value ) = $list;
			if( $type == 'text' ) {
				$field = htmlspecialchars( $value );
			} else {
				$attribs = array( 'id' => $name );
				if ( $name == 'wpNewPassword' || $name == 'wpRetype' ) {
					$attribs = array_merge( $attribs,
						wiki_user::passwordChangeInputAttribs() );
				}
				if ( $name == 'wpPassword' ) {
					$attribs[] = 'autofocus';
				}
				$field = Html::input( $name, $value, $type, $attribs );
			}
			$out .= "<tr>\n";
			$out .= "\t<td class='mw-label'>";
			if ( $type != 'text' )
				$out .= Xml::label( $this->msg( $label )->text(), $name );
			else
				$out .=  $this->msg( $label )->escaped();
			$out .= "</td>\n";
			$out .= "\t<td class='mw-input'>";
			$out .= $field;
			$out .= "</td>\n";
			$out .= "</tr>";
		}
		return $out;
	}

	/**
	 * @throws PasswordError when cannot set the new password because requirements not met.
	 */
	protected function attemptReset( $newpass, $retype ) {
		$wiki_user = wiki_user::newFromName( $this->mwiki_userName );
		if( !$wiki_user || $wiki_user->isAnon() ) {
			throw new PasswordError( $this->msg( 'nosuchwiki_usershort', $this->mwiki_userName )->text() );
		}

		if( $newpass !== $retype ) {
			wfRunHooks( 'PrefsPasswordAudit', array( $wiki_user, $newpass, 'badretype' ) );
			throw new PasswordError( $this->msg( 'badretype' )->text() );
		}

		$throttleCount = LoginForm::incLoginThrottle( $this->mwiki_userName );
		if ( $throttleCount === true ) {
			throw new PasswordError( $this->msg( 'login-throttled' )->text() );
		}

		if( !$wiki_user->checkTemporaryPassword($this->mOldpass) && !$wiki_user->checkPassword($this->mOldpass) ) {
			wfRunHooks( 'PrefsPasswordAudit', array( $wiki_user, $newpass, 'wrongpassword' ) );
			throw new PasswordError( $this->msg( 'resetpass-wrong-oldpass' )->text() );
		}

		// Please reset throttle for successful logins, thanks!
		if ( $throttleCount ) {
			LoginForm::clearLoginThrottle( $this->mwiki_userName );
		}

		try {
			$wiki_user->setPassword( $this->mNewpass );
			wfRunHooks( 'PrefsPasswordAudit', array( $wiki_user, $newpass, 'success' ) );
			$this->mNewpass = $this->mOldpass = $this->mRetypePass = '';
		} catch( PasswordError $e ) {
			wfRunHooks( 'PrefsPasswordAudit', array( $wiki_user, $newpass, 'error' ) );
			throw new PasswordError( $e->getMessage() );
		}

		$wiki_user->setCookies();
		$wiki_user->saveSettings();
	}
}
