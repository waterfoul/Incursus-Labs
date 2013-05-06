<?php
if ( !defined( 'MEDIAWIKI' ) ) die();
/**
 * A Special Page extension to rename wiki_users, runnable by wiki_users with renamewiki_user
 * rights
 *
 * @file
 * @ingroup Extensions
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgAvailableRights[] = 'renamewiki_user';
$wgGroupPermissions['bureaucrat']['renamewiki_user'] = true;

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Renamewiki_user',
	'author'         => array( 'Ævar Arnfjörð Bjarmason', 'Aaron Schulz' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Renamewiki_user',
	'descriptionmsg' => 'renamewiki_user-desc',
);

# Internationalisation files
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Renamewiki_user'] = $dir . 'Renamewiki_user.i18n.php';
$wgExtensionMessagesFiles['Renamewiki_userAliases'] = $dir . 'Renamewiki_user.alias.php';

/**
 * wiki_users with more than this number of edits will have their rename operation
 * deferred via the job queue.
 */
define( 'RENAMEUSER_CONTRIBJOB', 5000 );

# Add a new log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                          = 'renamewiki_user';
$wgLogNames['renamewiki_user']              = 'renamewiki_userlogpage';
$wgLogHeaders['renamewiki_user']            = 'renamewiki_userlogpagetext';
# $wgLogActions['renamewiki_user/renamewiki_user'] = 'renamewiki_userlogentry';
$wgLogActionsHandlers['renamewiki_user/renamewiki_user'] = 'wfRenamewiki_userLogActionText'; // deal with old breakage

/**
 * @param $type
 * @param $action
 * @param $title Title
 * @param $skin Skin
 * @param $params array
 * @param $filterWikilinks bool
 * @return String
 */
function wfRenamewiki_userLogActionText( $type, $action, $title = null, $skin = null, $params = array(), $filterWikilinks = false ) {
	if ( !$title || $title->getNamespace() !== NS_USER ) {
		$rv = ''; // handled in comment, the old way
	} else {
		$titleLink = $skin ?
			$skin->makeLinkObj( $title, htmlspecialchars( $title->getPrefixedText() ) ) : htmlspecialchars( $title->getText() );
		# Add title to params
		array_unshift( $params, $titleLink );
		$rv = wfMsg( 'renamewiki_userlogentry', $params );
	}
	return $rv;
}

$wgAutoloadClasses['SpecialRenamewiki_user'] = dirname( __FILE__ ) . '/Renamewiki_user_body.php';
$wgAutoloadClasses['Renamewiki_userJob'] = dirname( __FILE__ ) . '/Renamewiki_userJob.php';
$wgSpecialPages['Renamewiki_user'] = 'SpecialRenamewiki_user';
$wgSpecialPageGroups['Renamewiki_user'] = 'wiki_users';
$wgJobClasses['renamewiki_user'] = 'Renamewiki_userJob';

$wgHooks['ShowMissingArticle'][] = 'wfRenamewiki_userShowLog';
$wgHooks['ContributionsToolLinks'][] = 'wfRenamewiki_userOnContribsLink';

/**
 * Show a log if the wiki_user has been renamed and point to the new wiki_username.
 * Don't show the log if the $oldwiki_userName exists as a wiki_user.
 *
 * @param $article Article
 */
function wfRenamewiki_userShowLog( $article ) {
	global $wgOut;
	$title = $article->getTitle();
	$oldwiki_user = wiki_user::newFromName( $title->getBaseText() );
	if ( ($title->getNamespace() == NS_USER || $title->getNamespace() == NS_USER_TALK ) && ($oldwiki_user && $oldwiki_user->isAnon() )) {
		// Get the title for the base wiki_userpage
		$page = Title::makeTitle( NS_USER, str_replace( ' ', '_', $title->getBaseText() ) )->getPrefixedDBkey();
		LogEventsList::showLogExtract( $wgOut, 'renamewiki_user', $page, '', array( 'lim' => 10, 'showIfEmpty' => false,
			'msgKey' => array( 'renamewiki_user-renamed-notice', $title->getBaseText() ) ) );
	}
	return true;
}

/**
 * @param $id
 * @param $nt Title
 * @param $tools
 * @return bool
 */
function wfRenamewiki_userOnContribsLink( $id, $nt, &$tools ) {
	global $wgwiki_user;

	if ( $wgwiki_user->isAllowed( 'renamewiki_user' ) && $id ) {
		$tools[] = Linker::link(
			SpecialPage::getTitleFor( 'Renamewiki_user' ),
			wfMsg( 'renamewiki_user-linkoncontribs' ),
			array( 'title' => wfMsgExt( 'renamewiki_user-linkoncontribs-text', 'parseinline' ) ),
			array( 'oldwiki_username' => $nt->getText() )
		);
	}
	return true;
}
