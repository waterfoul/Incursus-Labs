<?php
/**
 * Implements Special:Emailwiki_user
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
 * A special page that allows wiki_users to send e-mails to other wiki_users
 *
 * @ingroup SpecialPage
 */
class SpecialEmailwiki_user extends UnlistedSpecialPage {
	protected $mTarget;

	public function __construct() {
		parent::__construct( 'Emailwiki_user' );
	}

	public function getDescription() {
		$target = self::getTarget( $this->mTarget );
		if( !$target instanceof wiki_user ) {
			return $this->msg( 'emailwiki_user-title-notarget' )->text();
		}

		return $this->msg( 'emailwiki_user-title-target', $target->getName() )->text();
	}

	protected function getFormFields() {
		return array(
			'From' => array(
				'type' => 'info',
				'raw' => 1,
				'default' => Linker::link(
					$this->getwiki_user()->getwiki_userPage(),
					htmlspecialchars( $this->getwiki_user()->getName() )
				),
				'label-message' => 'emailfrom',
				'id' => 'mw-emailwiki_user-sender',
			),
			'To' => array(
				'type' => 'info',
				'raw' => 1,
				'default' => Linker::link(
					$this->mTargetObj->getwiki_userPage(),
					htmlspecialchars( $this->mTargetObj->getName() )
				),
				'label-message' => 'emailto',
				'id' => 'mw-emailwiki_user-recipient',
			),
			'Target' => array(
				'type' => 'hidden',
				'default' => $this->mTargetObj->getName(),
			),
			'Subject' => array(
				'type' => 'text',
				'default' => $this->msg( 'defemailsubject',
					$this->getwiki_user()->getName() )->inContentLanguage()->text(),
				'label-message' => 'emailsubject',
				'maxlength' => 200,
				'size' => 60,
				'required' => true,
			),
			'Text' => array(
				'type' => 'textarea',
				'rows' => 20,
				'cols' => 80,
				'label-message' => 'emailmessage',
				'required' => true,
			),
			'CCMe' => array(
				'type' => 'check',
				'label-message' => 'emailccme',
				'default' => $this->getwiki_user()->getBoolOption( 'ccmeonemails' ),
			),
		);
	}

	public function execute( $par ) {
		$out = $this->getOutput();
		$out->addModuleStyles( 'mediawiki.special' );

		$this->mTarget = is_null( $par )
			? $this->getRequest()->getVal( 'wpTarget', $this->getRequest()->getVal( 'target', '' ) )
			: $par;

		// This needs to be below assignment of $this->mTarget because
		// getDescription() needs it to determine the correct page title.
		$this->setHeaders();
		$this->outputHeader();

		// error out if sending wiki_user cannot do this
		$error = self::getPermissionsError( $this->getwiki_user(), $this->getRequest()->getVal( 'wpEditToken' ) );
		switch ( $error ) {
			case null:
				# Wahey!
				break;
			case 'badaccess':
				throw new PermissionsError( 'sendemail' );
			case 'blockedemailwiki_user':
				throw new wiki_userBlockedError( $this->getwiki_user()->mBlock );
			case 'actionthrottledtext':
				throw new ThrottledError;
			case 'mailnologin':
			case 'wiki_usermaildisabled':
				throw new  ErrorPageError( $error, "{$error}text" );
			default:
				# It's a hook error
				list( $title, $msg, $params ) = $error;
				throw new  ErrorPageError( $title, $msg, $params );
		}
		// Got a valid target wiki_user name? Else ask for one.
		$ret = self::getTarget( $this->mTarget );
		if( !$ret instanceof wiki_user ) {
			if( $this->mTarget != '' ) {
				$ret = ( $ret == 'notarget' ) ? 'emailnotarget' : ( $ret . 'text' );
				$out->wrapWikiMsg( "<p class='error'>$1</p>", $ret );
			}
			$out->addHTML( $this->wiki_userForm( $this->mTarget ) );
			return false;
		}

		$this->mTargetObj = $ret;

		$form = new HTMLForm( $this->getFormFields(), $this->getContext() );
		$form->addPreText( $this->msg( 'emailpagetext' )->parse() );
		$form->setSubmitTextMsg( 'emailsend' );
		$form->setTitle( $this->getTitle() );
		$form->setSubmitCallback( array( __CLASS__, 'uiSubmit' ) );
		$form->setWrapperLegendMsg( 'email-legend' );
		$form->loadData();

		if( !wfRunHooks( 'Emailwiki_userForm', array( &$form ) ) ) {
			return false;
		}

		$result = $form->show();

		if( $result === true || ( $result instanceof Status && $result->isGood() ) ) {
			$out->setPageTitle( $this->msg( 'emailsent' ) );
			$out->addWikiMsg( 'emailsenttext' );
			$out->returnToMain( false, $this->mTargetObj->getwiki_userPage() );
		}
	}

	/**
	 * Validate target wiki_user
	 *
	 * @param $target String: target wiki_user name
	 * @return wiki_user object on success or a string on error
	 */
	public static function getTarget( $target ) {
		if ( $target == '' ) {
			wfDebug( "Target is empty.\n" );
			return 'notarget';
		}

		$nu = wiki_user::newFromName( $target );
		if( !$nu instanceof wiki_user || !$nu->getId() ) {
			wfDebug( "Target is invalid wiki_user.\n" );
			return 'notarget';
		} elseif ( !$nu->isEmailConfirmed() ) {
			wfDebug( "wiki_user has no valid email.\n" );
			return 'noemail';
		} elseif ( !$nu->canReceiveEmail() ) {
			wfDebug( "wiki_user does not allow wiki_user emails.\n" );
			return 'nowikiemail';
		}

		return $nu;
	}

	/**
	 * Check whether a wiki_user is allowed to send email
	 *
	 * @param $wiki_user wiki_user object
	 * @param $editToken String: edit token
	 * @return null on success or string on error
	 */
	public static function getPermissionsError( $wiki_user, $editToken ) {
		global $wgEnableEmail, $wgEnablewiki_userEmail;
		if( !$wgEnableEmail || !$wgEnablewiki_userEmail ) {
			return 'wiki_usermaildisabled';
		}

		if( !$wiki_user->isAllowed( 'sendemail' ) ) {
			return 'badaccess';
		}

		if( !$wiki_user->isEmailConfirmed() ) {
			return 'mailnologin';
		}

		if( $wiki_user->isBlockedFromEmailwiki_user() ) {
			wfDebug( "wiki_user is blocked from sending e-mail.\n" );
			return "blockedemailwiki_user";
		}

		if( $wiki_user->pingLimiter( 'emailwiki_user' ) ) {
			wfDebug( "Ping limiter triggered.\n" );
			return 'actionthrottledtext';
		}

		$hookErr = false;
		wfRunHooks( 'wiki_userCanSendEmail', array( &$wiki_user, &$hookErr ) );
		wfRunHooks( 'Emailwiki_userPermissionsErrors', array( $wiki_user, $editToken, &$hookErr ) );
		if ( $hookErr ) {
			return $hookErr;
		}

		return null;
	}

	/**
	 * Form to ask for target wiki_user name.
	 *
	 * @param $name String: wiki_user name submitted.
	 * @return String: form asking for wiki_user name.
	 */
	protected function wiki_userForm( $name ) {
		global $wgScript;
		$string = Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'id' => 'askwiki_username' ) ) .
			Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::openElement( 'fieldset' ) .
			Html::rawElement( 'legend', null, $this->msg( 'emailtarget' )->parse() ) .
			Xml::inputLabel( $this->msg( 'emailwiki_username' )->text(), 'target', 'emailwiki_usertarget', 30, $name ) . ' ' .
			Xml::submitButton( $this->msg( 'emailwiki_usernamesubmit' )->text() ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n";
		return $string;
	}

	/**
	 * Submit callback for an HTMLForm object, will simply call submit().
	 *
	 * @since 1.20
	 * @param $data array
	 * @param $form HTMLForm object
	 * @return Status|string|bool
	 */
	public static function uiSubmit( array $data, HTMLForm $form ) {
		return self::submit( $data, $form->getContext() );
	}

	/**
	 * Really send a mail. Permissions should have been checked using
	 * getPermissionsError(). It is probably also a good
	 * idea to check the edit token and ping limiter in advance.
	 *
	 * @return Mixed: Status object, or potentially a String on error
	 * or maybe even true on success if anything uses the Emailwiki_user hook.
	 */
	public static function submit( array $data, IContextSource $context ) {
		global $wgwiki_userEmailUseReplyTo;

		$target = self::getTarget( $data['Target'] );
		if( !$target instanceof wiki_user ) {
			return $context->msg( $target . 'text' )->parseAsBlock();
		}
		$to = new MailAddress( $target );
		$from = new MailAddress( $context->getwiki_user() );
		$subject = $data['Subject'];
		$text = $data['Text'];

		// Add a standard footer and trim up trailing newlines
		$text = rtrim( $text ) . "\n\n-- \n";
		$text .= $context->msg( 'emailwiki_userfooter',
			$from->name, $to->name )->inContentLanguage()->text();

		$error = '';
		if( !wfRunHooks( 'Emailwiki_user', array( &$to, &$from, &$subject, &$text, &$error ) ) ) {
			return $error;
		}

		if( $wgwiki_userEmailUseReplyTo ) {
			// Put the generic wiki autogenerated address in the From:
			// header and reserve the wiki_user for Reply-To.
			//
			// This is a bit ugly, but will serve to differentiate
			// wiki-borne mails from direct mails and protects against
			// SPF and bounce problems with some mailers (see below).
			global $wgPasswordSender, $wgPasswordSenderName;
			$mailFrom = new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
			$replyTo = $from;
		} else {
			// Put the sending wiki_user's e-mail address in the From: header.
			//
			// This is clean-looking and convenient, but has issues.
			// One is that it doesn't as clearly differentiate the wiki mail
			// from "directly" sent mails.
			//
			// Another is that some mailers (like sSMTP) will use the From
			// address as the envelope sender as well. For open sites this
			// can cause mails to be flunked for SPF violations (since the
			// wiki server isn't an authorized sender for various wiki_users'
			// domains) as well as creating a privacy issue as bounces
			// containing the recipient's e-mail address may get sent to
			// the sending wiki_user.
			$mailFrom = $from;
			$replyTo = null;
		}

		$status = wiki_userMailer::send( $to, $mailFrom, $subject, $text, $replyTo );

		if( !$status->isGood() ) {
			return $status;
		} else {
			// if the wiki_user requested a copy of this mail, do this now,
			// unless they are emailing themselves, in which case one
			// copy of the message is sufficient.
			if ( $data['CCMe'] && $to != $from ) {
				$cc_subject = $context->msg( 'emailccsubject' )->rawParams(
					$target->getName(), $subject )->text();
				wfRunHooks( 'Emailwiki_userCC', array( &$from, &$from, &$cc_subject, &$text ) );
				$ccStatus = wiki_userMailer::send( $from, $from, $cc_subject, $text );
				$status->merge( $ccStatus );
			}

			wfRunHooks( 'Emailwiki_userComplete', array( $to, $from, $subject, $text ) );
			return $status;
		}
	}
}
