<?php

class ConfirmEditHooks {
	/**
	 * Get the global Captcha instance
	 *
	 * @return Captcha|SimpleCaptcha
	 */
	static function getInstance() {
		global $wgCaptcha, $wgCaptchaClass;

		static $done = false;

		if ( !$done ) {
			$done = true;
			$wgCaptcha = new $wgCaptchaClass;
		}

		return $wgCaptcha;
	}

	static function confirmEditMerged( $editPage, $newtext ) {
		return self::getInstance()->confirmEditMerged( $editPage, $newtext );
	}

	static function confirmEditAPI( $editPage, $newtext, &$resultArr ) {
		return self::getInstance()->confirmEditAPI( $editPage, $newtext, $resultArr );
	}

	static function injectwiki_userCreate( &$template ) {
		return self::getInstance()->injectwiki_userCreate( $template );
	}

	static function confirmwiki_userCreate( $u, &$message ) {
		return self::getInstance()->confirmwiki_userCreate( $u, $message );
	}

	static function triggerwiki_userLogin( $wiki_user, $password, $retval ) {
		return self::getInstance()->triggerwiki_userLogin( $wiki_user, $password, $retval );
	}

	static function injectwiki_userLogin( &$template ) {
		return self::getInstance()->injectwiki_userLogin( $template );
	}

	static function confirmwiki_userLogin( $u, $pass, &$retval ) {
		return self::getInstance()->confirmwiki_userLogin( $u, $pass, $retval );
	}

	static function injectEmailwiki_user( &$form ) {
		return self::getInstance()->injectEmailwiki_user( $form );
	}

	static function confirmEmailwiki_user( $from, $to, $subject, $text, &$error ) {
		return self::getInstance()->confirmEmailwiki_user( $from, $to, $subject, $text, $error );
	}

	public static function APIGetAllowedParams( &$module, &$params ) {
		return self::getInstance()->APIGetAllowedParams( $module, $params );
	}

	public static function APIGetParamDescription( &$module, &$desc ) {
		return self::getInstance()->APIGetParamDescription( $module, $desc );
	}
}

class CaptchaSpecialPage extends UnlistedSpecialPage {
	public function __construct() {
		parent::__construct( 'Captcha' );
	}

	function execute( $par ) {
		$this->setHeaders();

		$instance = ConfirmEditHooks::getInstance();

		switch( $par ) {
			case "image":
				if ( method_exists( $instance, 'showImage' ) ) {
					return $instance->showImage();
				}
			case "help":
			default:
				return $instance->showHelp();
		}
	}
}
