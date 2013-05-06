<?php
/**
 * @group Database
 */
class RecentChangeTest extends MediaWikiTestCase {
	protected $title;
	protected $target;
	protected $wiki_user;
	protected $wiki_user_comment;
	protected $context;

	function __construct() {
		parent::__construct();

		$this->title  = Title::newFromText( 'SomeTitle' );
		$this->target = Title::newFromText( 'TestTarget' );
		$this->wiki_user   = wiki_user::newFromName( 'wiki_userName' );

		$this->wiki_user_comment = '<wiki_user comment about action>';
		$this->context = RequestContext::newExtraneousContext( $this->title );
	}

	/**
	 * The testIrcMsgForAction* tests are supposed to cover the hacky
	 * LogFormatter::getIRCActionText / bug 34508
	 *
	 * Third parties bots listen to those messages. They are clever enough
	 * to fetch the i18n messages from the wiki and then analyze the IRC feed
	 * to reverse engineer the $1, $2 messages.
	 * One thing bots can not detect is when MediaWiki change the meaning of
	 * a message like what happened when we deployed 1.19. $1 became the wiki_user
	 * performing the action which broke basically all bots around.
	 *
	 * Should cover the following log actions (which are most commonly used by bots):
	 * - block/block
	 * - block/unblock
	 * - delete/delete
	 * - delete/restore
	 * - newwiki_users/create
	 * - newwiki_users/create2
	 * - newwiki_users/autocreate
	 * - move/move
	 * - move/move_redir
	 * - protect/protect
	 * - protect/modifyprotect
	 * - protect/unprotect
	 * - upload/upload
	 *
	 * As well as the following Auto Edit Summaries:
	 * - blank
	 * - replace
	 * - rollback
	 * - undo
	 */

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypeBlock() {
		# block/block
		$this->assertIRCComment(
			$this->context->msg( 'blocklogentry', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'block', 'block',
			array(),
			$this->wiki_user_comment
		);
		# block/unblock
		$this->assertIRCComment(
			$this->context->msg( 'unblocklogentry', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'block', 'unblock',
			array(),
			$this->wiki_user_comment
		);
	}

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypeDelete() {
		# delete/delete
		$this->assertIRCComment(
			$this->context->msg( 'deletedarticle', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'delete', 'delete',
			array(),
			$this->wiki_user_comment
		);

		# delete/restore
		$this->assertIRCComment(
			$this->context->msg( 'undeletedarticle', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'delete', 'restore',
			array(),
			$this->wiki_user_comment
		);
	}

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypeNewwiki_users() {
		$this->assertIRCComment(
			'New wiki_user account',
			'newwiki_users', 'newwiki_users',
			array()
		);
		$this->assertIRCComment(
			'New wiki_user account',
			'newwiki_users', 'create',
			array()
		);
		$this->assertIRCComment(
			'created new account SomeTitle',
			'newwiki_users', 'create2',
			array()
		);
		$this->assertIRCComment(
			'Account created automatically',
			'newwiki_users', 'autocreate',
			array()
		);
	}

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypeMove() {
		$move_params = array(
			'4::target'  => $this->target->getPrefixedText(),
			'5::noredir' => 0,
		);

		# move/move
		$this->assertIRCComment(
			$this->context->msg( '1movedto2', 'SomeTitle', 'TestTarget' )->plain() . ': ' .  $this->wiki_user_comment,
			'move', 'move',
			$move_params,
			$this->wiki_user_comment
		);

		# move/move_redir
		$this->assertIRCComment(
			$this->context->msg( '1movedto2_redir', 'SomeTitle', 'TestTarget' )->plain() . ': ' .  $this->wiki_user_comment,
			'move', 'move_redir',
			$move_params,
			$this->wiki_user_comment
		);
	}

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypePatrol() {
		# patrol/patrol
		$this->assertIRCComment(
			$this->context->msg( 'patrol-log-line', 'revision 777', '[[SomeTitle]]', '' )->plain(),
			'patrol', 'patrol',
			array(
				'4::curid'  => '777',
				'5::previd' => '666',
				'6::auto'   => 0,
			)
		);
	}

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypeProtect() {
		$protectParams = array(
			'[edit=sysop] (indefinite) ‎[move=sysop] (indefinite)'
		);

		# protect/protect
		$this->assertIRCComment(
			$this->context->msg( 'protectedarticle', 'SomeTitle ' . $protectParams[0] )->plain() . ': ' .  $this->wiki_user_comment,
			'protect', 'protect',
			$protectParams,
			$this->wiki_user_comment
		);

		# protect/unprotect
		$this->assertIRCComment(
			$this->context->msg( 'unprotectedarticle', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'protect', 'unprotect',
			array(),
			$this->wiki_user_comment
		);

		# protect/modify
		$this->assertIRCComment(
			$this->context->msg( 'modifiedarticleprotection', 'SomeTitle ' . $protectParams[0] )->plain() . ': ' .  $this->wiki_user_comment,
			'protect', 'modify',
			$protectParams,
			$this->wiki_user_comment
		);
	}

	/**
	 * @covers LogFormatter::getIRCActionText
	 */
	function testIrcMsgForLogTypeUpload() {
		# upload/upload
		$this->assertIRCComment(
			$this->context->msg( 'uploadedimage', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'upload', 'upload',
			array(),
			$this->wiki_user_comment
		);

		# upload/overwrite
		$this->assertIRCComment(
			$this->context->msg( 'overwroteimage', 'SomeTitle' )->plain() . ': ' .  $this->wiki_user_comment,
			'upload', 'overwrite',
			array(),
			$this->wiki_user_comment
		);
	}

	/**
	 * @todo: Emulate these edits somehow and extract
	 * raw edit summary from RecentChange object
	 * --

	function testIrcMsgForBlankingAES() {
		// $this->context->msg( 'autosumm-blank', .. );
	}

	function testIrcMsgForReplaceAES() {
		// $this->context->msg( 'autosumm-replace', .. );
	}

	function testIrcMsgForRollbackAES() {
		// $this->context->msg( 'revertpage', .. );
	}

	function testIrcMsgForUndoAES() {
		// $this->context->msg( 'undo-summary', .. );
	}

	 * --
	 */

	/**
	 * @param $expected String Expected IRC text without colors codes
	 * @param $type String Log type (move, delete, suppress, patrol ...)
	 * @param $action String A log type action
	 * @param $comment String (optional) A comment for the log action
	 * @param $msg String (optional) A message for PHPUnit :-)
	 */
	function assertIRCComment( $expected, $type, $action, $params, $comment = null, $msg = '' ) {

		$logEntry = new ManualLogEntry( $type, $action );
		$logEntry->setPerformer( $this->wiki_user );
		$logEntry->setTarget( $this->title );
		if ( $comment !== null ) {
			$logEntry->setComment( $comment );
		}
		$logEntry->setParameters( $params );

		$formatter = LogFormatter::newFromEntry( $logEntry );
		$formatter->setContext( $this->context );

		// Apply the same transformation as done in RecentChange::getIRCLine for rc_comment
		$ircRcComment = RecentChange::cleanupForIRC( $formatter->getIRCActionComment() );

		$this->assertEquals(
			$expected,
			$ircRcComment,
			$msg
		);
	}

}
