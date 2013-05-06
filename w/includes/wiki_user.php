<?php
/**
 * Implements the wiki_user class for the %MediaWiki software.
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
 */

/**
 * Int Number of characters in wiki_user_token field.
 * @ingroup Constants
 */
define( 'USER_TOKEN_LENGTH', 32 );

/**
 * Int Serialized record version.
 * @ingroup Constants
 */
define( 'MW_USER_VERSION', 8 );

/**
 * String Some punctuation to prevent editing from broken text-mangling proxies.
 * @ingroup Constants
 */
define( 'EDIT_TOKEN_SUFFIX', '+\\' );

/**
 * Thrown by wiki_user::setPassword() on error.
 * @ingroup Exception
 */
class PasswordError extends MWException {
	// NOP
}

/**
 * The wiki_user object encapsulates all of the wiki_user-specific settings (wiki_user_id,
 * name, rights, password, email address, options, last login time). Client
 * classes use the getXXX() functions to access these fields. These functions
 * do all the work of determining whether the wiki_user is logged in,
 * whether the requested option can be satisfied from cookies or
 * whether a database query is needed. Most of the settings needed
 * for rendering normal pages are set in the cookie to minimize use
 * of the database.
 */
class wiki_user {
	/**
	 * Global constants made accessible as class constants so that autoloader
	 * magic can be used.
	 */
	const USER_TOKEN_LENGTH = USER_TOKEN_LENGTH;
	const MW_USER_VERSION = MW_USER_VERSION;
	const EDIT_TOKEN_SUFFIX = EDIT_TOKEN_SUFFIX;

	/**
	 * Maximum items in $mWatchedItems
	 */
	const MAX_WATCHED_ITEMS_CACHE = 100;

	/**
	 * Array of Strings List of member variables which are saved to the
	 * shared cache (memcached). Any operation which changes the
	 * corresponding database fields must call a cache-clearing function.
	 * @showinitializer
	 */
	static $mCacheVars = array(
		// wiki_user table
		'mId',
		'mName',
		'mRealName',
		'mPassword',
		'mNewpassword',
		'mNewpassTime',
		'mEmail',
		'mTouched',
		'mToken',
		'mEmailAuthenticated',
		'mEmailToken',
		'mEmailTokenExpires',
		'mRegistration',
		'mEditCount',
		// wiki_user_groups table
		'mGroups',
		// wiki_user_properties table
		'mOptionOverrides',
	);

	/**
	 * Array of Strings Core rights.
	 * Each of these should have a corresponding message of the form
	 * "right-$right".
	 * @showinitializer
	 */
	static $mCoreRights = array(
		'apihighlimits',
		'autoconfirmed',
		'autopatrol',
		'bigdelete',
		'block',
		'blockemail',
		'bot',
		'browsearchive',
		'createaccount',
		'createpage',
		'createtalk',
		'delete',
		'deletedhistory',
		'deletedtext',
		'deletelogentry',
		'deleterevision',
		'edit',
		'editinterface',
		'editprotected',
		'editwiki_usercssjs', #deprecated
		'editwiki_usercss',
		'editwiki_userjs',
		'hidewiki_user',
		'import',
		'importupload',
		'ipblock-exempt',
		'markbotedits',
		'mergehistory',
		'minoredit',
		'move',
		'movefile',
		'move-rootwiki_userpages',
		'move-subpages',
		'nominornewtalk',
		'noratelimit',
		'override-export-depth',
		'passwordreset',
		'patrol',
		'patrolmarks',
		'protect',
		'proxyunbannable',
		'purge',
		'read',
		'reupload',
		'reupload-own',
		'reupload-shared',
		'rollback',
		'sendemail',
		'siteadmin',
		'suppressionlog',
		'suppressredirect',
		'suppressrevision',
		'unblockself',
		'undelete',
		'unwatchedpages',
		'upload',
		'upload_by_url',
		'wiki_userrights',
		'wiki_userrights-interwiki',
		'writeapi',
	);
	/**
	 * String Cached results of getAllRights()
	 */
	static $mAllRights = false;

	/** @name Cache variables */
	//@{
	var $mId, $mName, $mRealName, $mPassword, $mNewpassword, $mNewpassTime,
		$mEmail, $mTouched, $mToken, $mEmailAuthenticated,
		$mEmailToken, $mEmailTokenExpires, $mRegistration, $mEditCount,
		$mGroups, $mOptionOverrides;
	//@}

	/**
	 * Bool Whether the cache variables have been loaded.
	 */
	//@{
	var $mOptionsLoaded;

	/**
	 * Array with already loaded items or true if all items have been loaded.
	 */
	private $mLoadedItems = array();
	//@}

	/**
	 * String Initialization data source if mLoadedItems!==true. May be one of:
	 *  - 'defaults'   anonymous wiki_user initialised from class defaults
	 *  - 'name'       initialise from mName
	 *  - 'id'         initialise from mId
	 *  - 'session'    log in from cookies or session if possible
	 *
	 * Use the wiki_user::newFrom*() family of functions to set this.
	 */
	var $mFrom;

	/**
	 * Lazy-initialized variables, invalidated with clearInstanceCache
	 */
	var $mNewtalk, $mDatePreference, $mBlockedby, $mHash, $mRights,
		$mBlockreason, $mEffectiveGroups, $mImplicitGroups, $mFormerGroups, $mBlockedGlobally,
		$mLocked, $mHideName, $mOptions;

	/**
	 * @var WebRequest
	 */
	private $mRequest;

	/**
	 * @var Block
	 */
	var $mBlock;

	/**
	 * @var bool
	 */
	var $mAllowwiki_usertalk;

	/**
	 * @var Block
	 */
	private $mBlockedFromCreateAccount = false;

	/**
	 * @var Array
	 */
	private $mWatchedItems = array();

	static $idCacheByName = array();

	/**
	 * Lightweight constructor for an anonymous wiki_user.
	 * Use the wiki_user::newFrom* factory functions for other kinds of wiki_users.
	 *
	 * @see newFromName()
	 * @see newFromId()
	 * @see newFromConfirmationCode()
	 * @see newFromSession()
	 * @see newFromRow()
	 */
	function __construct() {
		$this->clearInstanceCache( 'defaults' );
	}

	/**
	 * @return String
	 */
	function __toString(){
		return $this->getName();
	}

	/**
	 * Load the wiki_user table data for this object from the source given by mFrom.
	 */
	public function load() {
		if ( $this->mLoadedItems === true ) {
			return;
		}
		wfProfileIn( __METHOD__ );

		# Set it now to avoid infinite recursion in accessors
		$this->mLoadedItems = true;

		switch ( $this->mFrom ) {
			case 'defaults':
				$this->loadDefaults();
				break;
			case 'name':
				if ( defined( 'HACL_HALOACL_VERSION' ) ) {
					$hacl = haclfDisableTitlePatch();
				}
				$this->mId = self::idFromName( $this->mName );
				if ( defined( 'HACL_HALOACL_VERSION' ) ) {
					haclfRestoreTitlePatch( $hacl );
				}
				if ( !$this->mId ) {
					# Nonexistent wiki_user placeholder object
					$this->loadDefaults( $this->mName );
				} else {
					$this->loadFromId();
				}
				break;
			case 'id':
				$this->loadFromId();
				break;
			case 'session':
				$this->loadFromSession();
				wfRunHooks( 'wiki_userLoadAfterLoadFromSession', array( $this ) );
				break;
			default:
				throw new MWException( "Unrecognised value for wiki_user->mFrom: \"{$this->mFrom}\"" );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Load wiki_user table data, given mId has already been set.
	 * @return Bool false if the ID does not exist, true otherwise
	 */
	public function loadFromId() {
		global $wgMemc;
		if ( $this->mId == 0 ) {
			$this->loadDefaults();
			return false;
		}

		# Try cache
		$key = wfMemcKey( 'wiki_user', 'id', $this->mId );
		$data = $wgMemc->get( $key );
		if ( !is_array( $data ) || $data['mVersion'] < MW_USER_VERSION ) {
			# Object is expired, load from DB
			$data = false;
		}

		if ( !$data ) {
			wfDebug( "wiki_user: cache miss for wiki_user {$this->mId}\n" );
			# Load from DB
			if ( !$this->loadFromDatabase() ) {
				# Can't load from ID, wiki_user is anonymous
				return false;
			}
			$this->saveToCache();
		} else {
			wfDebug( "wiki_user: got wiki_user {$this->mId} from cache\n" );
			# Restore from cache
			foreach ( self::$mCacheVars as $name ) {
				$this->$name = $data[$name];
			}
		}
		return true;
	}

	/**
	 * Save wiki_user data to the shared cache
	 */
	public function saveToCache() {
		$this->load();
		$this->loadGroups();
		$this->loadOptions();
		if ( $this->isAnon() ) {
			// Anonymous wiki_users are uncached
			return;
		}
		$data = array();
		foreach ( self::$mCacheVars as $name ) {
			$data[$name] = $this->$name;
		}
		$data['mVersion'] = MW_USER_VERSION;
		$key = wfMemcKey( 'wiki_user', 'id', $this->mId );
		global $wgMemc;
		$wgMemc->set( $key, $data );
	}

	/** @name newFrom*() static factory methods */
	//@{

	/**
	 * Static factory method for creation from wiki_username.
	 *
	 * This is slightly less efficient than newFromId(), so use newFromId() if
	 * you have both an ID and a name handy.
	 *
	 * @param $name String wiki_username, validated by Title::newFromText()
	 * @param $validate String|Bool Validate wiki_username. Takes the same parameters as
	 *    wiki_user::getCanonicalName(), except that true is accepted as an alias
	 *    for 'valid', for BC.
	 *
	 * @return wiki_user object, or false if the wiki_username is invalid
	 *    (e.g. if it contains illegal characters or is an IP address). If the
	 *    wiki_username is not present in the database, the result will be a wiki_user object
	 *    with a name, zero wiki_user ID and default settings.
	 */
	public static function newFromName( $name, $validate = 'valid' ) {
		if ( $validate === true ) {
			$validate = 'valid';
		}
		$name = self::getCanonicalName( $name, $validate );
		if ( $name === false ) {
			return false;
		} else {
			# Create unloaded wiki_user object
			$u = new wiki_user;
			$u->mName = $name;
			$u->mFrom = 'name';
			$u->setItemLoaded( 'name' );
			return $u;
		}
	}

	/**
	 * Static factory method for creation from a given wiki_user ID.
	 *
	 * @param $id Int Valid wiki_user ID
	 * @return wiki_user The corresponding wiki_user object
	 */
	public static function newFromId( $id ) {
		$u = new wiki_user;
		$u->mId = $id;
		$u->mFrom = 'id';
		$u->setItemLoaded( 'id' );
		return $u;
	}

	/**
	 * Factory method to fetch whichever wiki_user has a given email confirmation code.
	 * This code is generated when an account is created or its e-mail address
	 * has changed.
	 *
	 * If the code is invalid or has expired, returns NULL.
	 *
	 * @param $code String Confirmation code
	 * @return wiki_user object, or null
	 */
	public static function newFromConfirmationCode( $code ) {
		r = wfGetDB( DB_SLAVE );
		$id = r->selectField( 'wiki_user', 'wiki_user_id', array(
			'wiki_user_email_token' => md5( $code ),
			'wiki_user_email_token_expires > ' . r->addQuotes( r->timestamp() ),
			) );
		if( $id !== false ) {
			return wiki_user::newFromId( $id );
		} else {
			return null;
		}
	}

	/**
	 * Create a new wiki_user object using data from session or cookies. If the
	 * login credentials are invalid, the result is an anonymous wiki_user.
	 *
	 * @param $request WebRequest object to use; $wgRequest will be used if
	 *        ommited.
	 * @return wiki_user object
	 */
	public static function newFromSession( WebRequest $request = null ) {
		$wiki_user = new wiki_user;
		$wiki_user->mFrom = 'session';
		$wiki_user->mRequest = $request;
		return $wiki_user;
	}

	/**
	 * Create a new wiki_user object from a wiki_user row.
	 * The row should have the following fields from the wiki_user table in it:
	 * - either wiki_user_name or wiki_user_id to load further data if needed (or both)
	 * - wiki_user_real_name
	 * - all other fields (email, password, etc.)
	 * It is useless to provide the remaining fields if either wiki_user_id,
	 * wiki_user_name and wiki_user_real_name are not provided because the whole row
	 * will be loaded once more from the database when accessing them.
	 *
	 * @param $row Array A row from the wiki_user table
	 * @return wiki_user
	 */
	public static function newFromRow( $row ) {
		$wiki_user = new wiki_user;
		$wiki_user->loadFromRow( $row );
		return $wiki_user;
	}

	//@}

	/**
	 * Get the wiki_username corresponding to a given wiki_user ID
	 * @param $id Int wiki_user ID
	 * @return String|bool The corresponding wiki_username
	 */
	public static function whoIs( $id ) {
		return wiki_userCache::singleton()->getProp( $id, 'name' );
	}

	/**
	 * Get the real name of a wiki_user given their wiki_user ID
	 *
	 * @param $id Int wiki_user ID
	 * @return String|bool The corresponding wiki_user's real name
	 */
	public static function whoIsReal( $id ) {
		return wiki_userCache::singleton()->getProp( $id, 'real_name' );
	}

	/**
	 * Get database id given a wiki_user name
	 * @param $name String wiki_username
	 * @return Int|Null The corresponding wiki_user's ID, or null if wiki_user is nonexistent
	 */
	public static function idFromName( $name ) {
		$nt = Title::makeTitleSafe( NS_USER, $name );
		if( is_null( $nt ) ) {
			# Illegal name
			return null;
		}

		if ( isset( self::$idCacheByName[$name] ) ) {
			return self::$idCacheByName[$name];
		}

		r = wfGetDB( DB_SLAVE );
		$s = r->selectRow( 'wiki_user', array( 'wiki_user_id' ), array( 'wiki_user_name' => $nt->getText() ), __METHOD__ );

		if ( $s === false ) {
			$result = null;
		} else {
			$result = $s->wiki_user_id;
		}

		self::$idCacheByName[$name] = $result;

		if ( count( self::$idCacheByName ) > 1000 ) {
			self::$idCacheByName = array();
		}

		return $result;
	}

	/**
	 * Reset the cache used in idFromName(). For use in tests.
	 */
	public static function resetIdByNameCache() {
		self::$idCacheByName = array();
	}

	/**
	 * Does the string match an anonymous IPv4 address?
	 *
	 * This function exists for wiki_username validation, in order to reject
	 * wiki_usernames which are similar in form to IP addresses. Strings such
	 * as 300.300.300.300 will return true because it looks like an IP
	 * address, despite not being strictly valid.
	 *
	 * We match "\d{1,3}\.\d{1,3}\.\d{1,3}\.xxx" as an anonymous IP
	 * address because the usemod software would "cloak" anonymous IP
	 * addresses like this, if we allowed accounts like this to be created
	 * new wiki_users could get the old edits of these anonymous wiki_users.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isIP( $name ) {
		return preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.(?:xxx|\d{1,3})$/',$name) || IP::isIPv6($name);
	}

	/**
	 * Is the input a valid wiki_username?
	 *
	 * Checks if the input is a valid wiki_username, we don't want an empty string,
	 * an IP address, anything that containins slashes (would mess up subpages),
	 * is longer than the maximum allowed wiki_username size or doesn't begin with
	 * a capital letter.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isValidwiki_userName( $name ) {
		global $wgContLang, $wgMaxNameChars;

		# Disable HaloACL title check as the main and/or
		# wiki_user namespaces may be protected
		if ( defined( 'HACL_HALOACL_VERSION' ) ) {
			$hacl = haclfDisableTitlePatch();
		}
		
		if ( $name == ''
		|| wiki_user::isIP( $name )
		|| strpos( $name, '/' ) !== false
		|| strlen( $name ) > $wgMaxNameChars
		|| $name != $wgContLang->ucfirst( $name ) ) {
			wfDebugLog( 'wiki_username', __METHOD__ .
				": '$name' invalid due to empty, IP, slash, length, or lowercase" );
			if ( defined( 'HACL_HALOACL_VERSION' ) ) {
				haclfRestoreTitlePatch( $hacl );
			}
			return false;
		}


		// Ensure that the name can't be misresolved as a different title,
		// such as with extra namespace keys at the start.
		$parsed = Title::newFromText( $name );
		if( is_null( $parsed )
			|| $parsed->getNamespace()
			|| strcmp( $name, $parsed->getPrefixedText() ) ) {
			wfDebugLog( 'wiki_username', __METHOD__ .
				": '$name' invalid due to ambiguous prefixes" );
			if ( defined( 'HACL_HALOACL_VERSION' ) ) {
				haclfRestoreTitlePatch( $hacl );
			}
			return false;
		}

		// Check an additional blacklist of troublemaker characters.
		// Should these be merged into the title char list?
		$unicodeBlacklist = '/[' .
			'\x{0080}-\x{009f}' . # iso-8859-1 control chars
			'\x{00a0}' .          # non-breaking space
			'\x{2000}-\x{200f}' . # various whitespace
			'\x{2028}-\x{202f}' . # breaks and control chars
			'\x{3000}' .          # ideographic space
			'\x{e000}-\x{f8ff}' . # private use
			']/u';
		if( preg_match( $unicodeBlacklist, $name ) ) {
			wfDebugLog( 'wiki_username', __METHOD__ .
				": '$name' invalid due to blacklisted characters" );
			if ( defined( 'HACL_HALOACL_VERSION' ) ) {
				haclfRestoreTitlePatch( $hacl );
			}
			return false;
		}
		if ( defined( 'HACL_HALOACL_VERSION' ) ) {
			haclfRestoreTitlePatch( $hacl );
		}
		return true;
	}

	/**
	 * wiki_usernames which fail to pass this function will be blocked
	 * from wiki_user login and new account registrations, but may be used
	 * internally by batch processes.
	 *
	 * If an account already exists in this form, login will be blocked
	 * by a failure to pass this function.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isUsableName( $name ) {
		global $wgReservedwiki_usernames;
		// Must be a valid wiki_username, obviously ;)
		if ( !self::isValidwiki_userName( $name ) ) {
			return false;
		}

		static $reservedwiki_usernames = false;
		if ( !$reservedwiki_usernames ) {
			$reservedwiki_usernames = $wgReservedwiki_usernames;
			wfRunHooks( 'wiki_userGetReservedNames', array( &$reservedwiki_usernames ) );
		}

		// Certain names may be reserved for batch processes.
		foreach ( $reservedwiki_usernames as $reserved ) {
			if ( substr( $reserved, 0, 4 ) == 'msg:' ) {
				$reserved = wfMessage( substr( $reserved, 4 ) )->inContentLanguage()->text();
			}
			if ( $reserved == $name ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * wiki_usernames which fail to pass this function will be blocked
	 * from new account registrations, but may be used internally
	 * either by batch processes or by wiki_user accounts which have
	 * already been created.
	 *
	 * Additional blacklisting may be added here rather than in
	 * isValidwiki_userName() to avoid disrupting existing accounts.
	 *
	 * @param $name String to match
	 * @return Bool
	 */
	public static function isCreatableName( $name ) {
		global $wgInvalidwiki_usernameCharacters;

		// Ensure that the wiki_username isn't longer than 235 bytes, so that
		// (at least for the builtin skins) wiki_user javascript and css files
		// will work. (bug 23080)
		if( strlen( $name ) > 235 ) {
			wfDebugLog( 'wiki_username', __METHOD__ .
				": '$name' invalid due to length" );
			return false;
		}

		// Preg yells if you try to give it an empty string
		if( $wgInvalidwiki_usernameCharacters !== '' ) {
			if( preg_match( '/[' . preg_quote( $wgInvalidwiki_usernameCharacters, '/' ) . ']/', $name ) ) {
				wfDebugLog( 'wiki_username', __METHOD__ .
					": '$name' invalid due to wgInvalidwiki_usernameCharacters" );
				return false;
			}
		}

		return self::isUsableName( $name );
	}

	/**
	 * Is the input a valid password for this wiki_user?
	 *
	 * @param $password String Desired password
	 * @return Bool
	 */
	public function isValidPassword( $password ) {
		//simple boolean wrapper for getPasswordValidity
		return $this->getPasswordValidity( $password ) === true;
	}

	/**
	 * Given unvalidated password input, return error message on failure.
	 *
	 * @param $password String Desired password
	 * @return mixed: true on success, string or array of error message on failure
	 */
	public function getPasswordValidity( $password ) {
		global $wgMinimalPasswordLength, $wgContLang;

		static $blockedLogins = array(
			'wiki_userwiki_user' => 'Passpass', 'wiki_userwiki_user1' => 'Passpass1', # r75589
			'Apitestsysop' => 'testpass', 'Apitestwiki_user' => 'testpass' # r75605
		);

		$result = false; //init $result to false for the internal checks

		if( !wfRunHooks( 'isValidPassword', array( $password, &$result, $this ) ) )
			return $result;

		if ( $result === false ) {
			if( strlen( $password ) < $wgMinimalPasswordLength ) {
				return 'passwordtooshort';
			} elseif ( $wgContLang->lc( $password ) == $wgContLang->lc( $this->mName ) ) {
				return 'password-name-match';
			} elseif ( isset( $blockedLogins[ $this->getName() ] ) && $password == $blockedLogins[ $this->getName() ] ) {
				return 'password-login-forbidden';
			} else {
				//it seems weird returning true here, but this is because of the
				//initialization of $result to false above. If the hook is never run or it
				//doesn't modify $result, then we will likely get down into this if with
				//a valid password.
				return true;
			}
		} elseif( $result === true ) {
			return true;
		} else {
			return $result; //the isValidPassword hook set a string $result and returned true
		}
	}

	/**
	 * Does a string look like an e-mail address?
	 *
	 * This validates an email address using an HTML5 specification found at:
	 * http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#valid-e-mail-address
	 * Which as of 2011-01-24 says:
	 *
	 *     A valid e-mail address is a string that matches the ABNF production
	 *   1*( atext / "." ) "@" ldh-str *( "." ldh-str ) where atext is defined
	 *   in RFC 5322 section 3.2.3, and ldh-str is defined in RFC 1034 section
	 *   3.5.
	 *
	 * This function is an implementation of the specification as requested in
	 * bug 22449.
	 *
	 * Client-side forms will use the same standard validation rules via JS or
	 * HTML 5 validation; additional restrictions can be enforced server-side
	 * by extensions via the 'isValidEmailAddr' hook.
	 *
	 * Note that this validation doesn't 100% match RFC 2822, but is believed
	 * to be liberal enough for wide use. Some invalid addresses will still
	 * pass validation here.
	 *
	 * @param $addr String E-mail address
	 * @return Bool
	 * @deprecated since 1.18 call Sanitizer::isValidEmail() directly
	 */
	public static function isValidEmailAddr( $addr ) {
		wfDeprecated( __METHOD__, '1.18' );
		return Sanitizer::validateEmail( $addr );
	}

	/**
	 * Given unvalidated wiki_user input, return a canonical wiki_username, or false if
	 * the wiki_username is invalid.
	 * @param $name String wiki_user input
	 * @param $validate String|Bool type of validation to use:
	 *                - false        No validation
	 *                - 'valid'      Valid for batch processes
	 *                - 'usable'     Valid for batch processes and login
	 *                - 'creatable'  Valid for batch processes, login and account creation
	 *
	 * @return bool|string
	 */
	public static function getCanonicalName( $name, $validate = 'valid' ) {
		// <IntraACL>
		# Disable IntraACL title check as the main and/or
		# wiki_user namespaces may be protected
		if ( defined( 'HACL_HALOACL_VERSION' ) ) {
			$hacl = haclfDisableTitlePatch();
		}
		// </IntraACL>
		
		# Force wiki_usernames to capital
		global $wgContLang;
		$name = $wgContLang->ucfirst( $name );

		# Reject names containing '#'; these will be cleaned up
		# with title normalisation, but then it's too late to
		# check elsewhere
		if( strpos( $name, '#' ) !== false )
			return false;

		# Clean up name according to title rules
		$t = ( $validate === 'valid' ) ?
			Title::newFromText( $name ) : Title::makeTitle( NS_USER, $name );
		# Check for invalid titles
		if( is_null( $t ) ) {
			if ( defined( 'HACL_HALOACL_VERSION' ) ) {
				haclfRestoreTitlePatch( $hacl );
			}
			return false;
		}

		# Reject various classes of invalid names
		global $wgAuth;
		$name = $wgAuth->getCanonicalName( $t->getText() );

		switch ( $validate ) {
			case false:
				break;
			case 'valid':
				if ( !wiki_user::isValidwiki_userName( $name ) ) {
					$name = false;
				}
				break;
			case 'usable':
				if ( !wiki_user::isUsableName( $name ) ) {
					$name = false;
				}
				break;
			case 'creatable':
				if ( !wiki_user::isCreatableName( $name ) ) {
					$name = false;
				}
				break;
			default:
				throw new MWException( 'Invalid parameter value for $validate in ' . __METHOD__ );
		}
		if ( defined( 'HACL_HALOACL_VERSION' ) ) {
			haclfRestoreTitlePatch( $hacl );
		}
		return $name;
	}

	/**
	 * Count the number of edits of a wiki_user
	 * @todo It should not be static and some day should be merged as proper member function / deprecated -- domas
	 *
	 * @param $uid Int wiki_user ID to check
	 * @return Int the wiki_user's edit count
	 */
	public static function edits( $uid ) {
		wfProfileIn( __METHOD__ );
		r = wfGetDB( DB_SLAVE );
		// check if the wiki_user_editcount field has been initialized
		$field = r->selectField(
			'wiki_user', 'wiki_user_editcount',
			array( 'wiki_user_id' => $uid ),
			__METHOD__
		);

		if( $field === null ) { // it has not been initialized. do so.
			w = wfGetDB( DB_MASTER );
			$count = r->selectField(
				'revision', 'count(*)',
				array( 'rev_wiki_user' => $uid ),
				__METHOD__
			);
			w->update(
				'wiki_user',
				array( 'wiki_user_editcount' => $count ),
				array( 'wiki_user_id' => $uid ),
				__METHOD__
			);
		} else {
			$count = $field;
		}
		wfProfileOut( __METHOD__ );
		return $count;
	}

	/**
	 * Return a random password.
	 *
	 * @return String new random password
	 */
	public static function randomPassword() {
		global $wgMinimalPasswordLength;
		// Decide the final password length based on our min password length, stopping at a minimum of 10 chars
		$length = max( 10, $wgMinimalPasswordLength );
		// Multiply by 1.25 to get the number of hex characters we need
		$length = $length * 1.25;
		// Generate random hex chars
		$hex = MWCryptRand::generateHex( $length );
		// Convert from base 16 to base 32 to get a proper password like string
		return wfBaseConvert( $hex, 16, 32 );
	}

	/**
	 * Set cached properties to default.
	 *
	 * @note This no longer clears uncached lazy-initialised properties;
	 *       the constructor does that instead.
	 *
	 * @param $name string
	 */
	public function loadDefaults( $name = false ) {
		wfProfileIn( __METHOD__ );

		$this->mId = 0;
		$this->mName = $name;
		$this->mRealName = '';
		$this->mPassword = $this->mNewpassword = '';
		$this->mNewpassTime = null;
		$this->mEmail = '';
		$this->mOptionOverrides = null;
		$this->mOptionsLoaded = false;

		$loggedOut = $this->getRequest()->getCookie( 'LoggedOut' );
		if( $loggedOut !== null ) {
			$this->mTouched = wfTimestamp( TS_MW, $loggedOut );
		} else {
			$this->mTouched = '0'; # Allow any pages to be cached
		}

		$this->mToken = null; // Don't run cryptographic functions till we need a token
		$this->mEmailAuthenticated = null;
		$this->mEmailToken = '';
		$this->mEmailTokenExpires = null;
		$this->mRegistration = wfTimestamp( TS_MW );
		$this->mGroups = array();

		wfRunHooks( 'wiki_userLoadDefaults', array( $this, $name ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return whether an item has been loaded.
	 *
	 * @param $item String: item to check. Current possibilities:
	 *              - id
	 *              - name
	 *              - realname
	 * @param $all String: 'all' to check if the whole object has been loaded
	 *        or any other string to check if only the item is available (e.g.
	 *        for optimisation)
	 * @return Boolean
	 */
	public function isItemLoaded( $item, $all = 'all' ) {
		return ( $this->mLoadedItems === true && $all === 'all' ) ||
			( isset( $this->mLoadedItems[$item] ) && $this->mLoadedItems[$item] === true );
	}

	/**
	 * Set that an item has been loaded
	 *
	 * @param $item String
	 */
	private function setItemLoaded( $item ) {
		if ( is_array( $this->mLoadedItems ) ) {
			$this->mLoadedItems[$item] = true;
		}
	}

	/**
	 * Load wiki_user data from the session or login cookie. If there are no valid
	 * credentials, initialises the wiki_user as an anonymous wiki_user.
	 * @return Bool True if the wiki_user is logged in, false otherwise.
	 */
	private function loadFromSession() {
		global $wgExternalAuthType, $wgAutocreatePolicy;

		$result = null;
		wfRunHooks( 'wiki_userLoadFromSession', array( $this, &$result ) );
		if ( $result !== null ) {
			return $result;
		}

		if ( $wgExternalAuthType && $wgAutocreatePolicy == 'view' ) {
			$extwiki_user = Externalwiki_user::newFromCookie();
			if ( $extwiki_user ) {
				# TODO: Automatically create the wiki_user here (or probably a bit
				# lower down, in fact)
			}
		}

		$request = $this->getRequest();

		$cookieId = $request->getCookie( 'wiki_userID' );
		$sessId = $request->getSessionData( 'wswiki_userID' );

		if ( $cookieId !== null ) {
			$sId = intval( $cookieId );
			if( $sessId !== null && $cookieId != $sessId ) {
				$this->loadDefaults(); // Possible collision!
				wfDebugLog( 'loginSessions', "Session wiki_user ID ($sessId) and
					cookie wiki_user ID ($sId) don't match!" );
				return false;
			}
			$request->setSessionData( 'wswiki_userID', $sId );
		} elseif ( $sessId !== null && $sessId != 0 ) {
			$sId = $sessId;
		} else {
			$this->loadDefaults();
			return false;
		}

		if ( $request->getSessionData( 'wswiki_userName' ) !== null ) {
			$sName = $request->getSessionData( 'wswiki_userName' );
		} elseif ( $request->getCookie( 'wiki_userName' ) !== null ) {
			$sName = $request->getCookie( 'wiki_userName' );
			$request->setSessionData( 'wswiki_userName', $sName );
		} else {
			$this->loadDefaults();
			return false;
		}

		$proposedwiki_user = wiki_user::newFromId( $sId );
		if ( !$proposedwiki_user->isLoggedIn() ) {
			# Not a valid ID
			$this->loadDefaults();
			return false;
		}

		global $wgBlockDisablesLogin;
		if( $wgBlockDisablesLogin && $proposedwiki_user->isBlocked() ) {
			# wiki_user blocked and we've disabled blocked wiki_user logins
			$this->loadDefaults();
			return false;
		}

		if ( $request->getSessionData( 'wsToken' ) ) {
			$passwordCorrect = $proposedwiki_user->getToken( false ) === $request->getSessionData( 'wsToken' );
			$from = 'session';
		} elseif ( $request->getCookie( 'Token' ) ) {
			$passwordCorrect = $proposedwiki_user->getToken( false ) === $request->getCookie( 'Token' );
			$from = 'cookie';
		} else {
			# No session or persistent login cookie
			$this->loadDefaults();
			return false;
		}

		if ( ( $sName === $proposedwiki_user->getName() ) && $passwordCorrect ) {
			$this->loadFromwiki_userObject( $proposedwiki_user );
			$request->setSessionData( 'wsToken', $this->mToken );
			wfDebug( "wiki_user: logged in from $from\n" );
			return true;
		} else {
			# Invalid credentials
			wfDebug( "wiki_user: can't log in from $from, invalid credentials\n" );
			$this->loadDefaults();
			return false;
		}
	}

	/**
	 * Load wiki_user and wiki_user_group data from the database.
	 * $this->mId must be set, this is how the wiki_user is identified.
	 *
	 * @return Bool True if the wiki_user exists, false if the wiki_user is anonymous
	 */
	public function loadFromDatabase() {
		# Paranoia
		$this->mId = intval( $this->mId );

		/** Anonymous wiki_user */
		if( !$this->mId ) {
			$this->loadDefaults();
			return false;
		}

		r = wfGetDB( DB_MASTER );
		$s = r->selectRow( 'wiki_user', self::selectFields(), array( 'wiki_user_id' => $this->mId ), __METHOD__ );

		wfRunHooks( 'wiki_userLoadFromDatabase', array( $this, &$s ) );

		if ( $s !== false ) {
			# Initialise wiki_user table data
			$this->loadFromRow( $s );
			$this->mGroups = null; // deferred
			$this->getEditCount(); // revalidation for nulls
			return true;
		} else {
			# Invalid wiki_user_id
			$this->mId = 0;
			$this->loadDefaults();
			return false;
		}
	}

	/**
	 * Initialize this object from a row from the wiki_user table.
	 *
	 * @param $row Array Row from the wiki_user table to load.
	 */
	public function loadFromRow( $row ) {
		$all = true;

		$this->mGroups = null; // deferred

		if ( isset( $row->wiki_user_name ) ) {
			$this->mName = $row->wiki_user_name;
			$this->mFrom = 'name';
			$this->setItemLoaded( 'name' );
		} else {
			$all = false;
		}

		if ( isset( $row->wiki_user_real_name ) ) {
			$this->mRealName = $row->wiki_user_real_name;
			$this->setItemLoaded( 'realname' );
		} else {
			$all = false;
		}

		if ( isset( $row->wiki_user_id ) ) {
			$this->mId = intval( $row->wiki_user_id );
			$this->mFrom = 'id';
			$this->setItemLoaded( 'id' );
		} else {
			$all = false;
		}

		if ( isset( $row->wiki_user_editcount ) ) {
			$this->mEditCount = $row->wiki_user_editcount;
		} else {
			$all = false;
		}

		if ( isset( $row->wiki_user_password ) ) {
			$this->mPassword = $row->wiki_user_password;
			$this->mNewpassword = $row->wiki_user_newpassword;
			$this->mNewpassTime = wfTimestampOrNull( TS_MW, $row->wiki_user_newpass_time );
			$this->mEmail = $row->wiki_user_email;
			if ( isset( $row->wiki_user_options ) ) {
				$this->decodeOptions( $row->wiki_user_options );
			}
			$this->mTouched = wfTimestamp( TS_MW, $row->wiki_user_touched );
			$this->mToken = $row->wiki_user_token;
			if ( $this->mToken == '' ) {
				$this->mToken = null;
			}
			$this->mEmailAuthenticated = wfTimestampOrNull( TS_MW, $row->wiki_user_email_authenticated );
			$this->mEmailToken = $row->wiki_user_email_token;
			$this->mEmailTokenExpires = wfTimestampOrNull( TS_MW, $row->wiki_user_email_token_expires );
			$this->mRegistration = wfTimestampOrNull( TS_MW, $row->wiki_user_registration );
		} else {
			$all = false;
		}

		if ( $all ) {
			$this->mLoadedItems = true;
		}
	}

	/**
	 * Load the data for this wiki_user object from another wiki_user object.
	 *
	 * @param $wiki_user wiki_user
	 */
	protected function loadFromwiki_userObject( $wiki_user ) {
		$wiki_user->load();
		$wiki_user->loadGroups();
		$wiki_user->loadOptions();
		foreach ( self::$mCacheVars as $var ) {
			$this->$var = $wiki_user->$var;
		}
	}

	/**
	 * Load the groups from the database if they aren't already loaded.
	 */
	private function loadGroups() {
		if ( is_null( $this->mGroups ) ) {
			r = wfGetDB( DB_MASTER );
			$res = r->select( 'wiki_user_groups',
				array( 'ug_group' ),
				array( 'ug_wiki_user' => $this->mId ),
				__METHOD__ );
			$this->mGroups = array();
			foreach ( $res as $row ) {
				$this->mGroups[] = $row->ug_group;
			}
		}
	}

	/**
	 * Add the wiki_user to the group if he/she meets given criteria.
	 *
	 * Contrary to autopromotion by \ref $wgAutopromote, the group will be
	 *   possible to remove manually via Special:wiki_userRights. In such case it
	 *   will not be re-added automatically. The wiki_user will also not lose the
	 *   group if they no longer meet the criteria.
	 *
	 * @param $event String key in $wgAutopromoteOnce (each one has groups/criteria)
	 *
	 * @return array Array of groups the wiki_user has been promoted to.
	 *
	 * @see $wgAutopromoteOnce
	 */
	public function addAutopromoteOnceGroups( $event ) {
		global $wgAutopromoteOnceLogInRC;

		$toPromote = array();
		if ( $this->getId() ) {
			$toPromote = Autopromote::getAutopromoteOnceGroups( $this, $event );
			if ( count( $toPromote ) ) {
				$oldGroups = $this->getGroups(); // previous groups
				foreach ( $toPromote as $group ) {
					$this->addGroup( $group );
				}
				$newGroups = array_merge( $oldGroups, $toPromote ); // all groups

				$log = new LogPage( 'rights', $wgAutopromoteOnceLogInRC /* in RC? */ );
				$log->addEntry( 'autopromote',
					$this->getwiki_userPage(),
					'', // no comment
					// These group names are "list to texted"-ed in class LogPage.
					array( implode( ', ', $oldGroups ), implode( ', ', $newGroups ) )
				);
			}
		}
		return $toPromote;
	}

	/**
	 * Clear various cached data stored in this object.
	 * @param $reloadFrom bool|String Reload wiki_user and wiki_user_groups table data from a
	 *   given source. May be "name", "id", "defaults", "session", or false for
	 *   no reload.
	 */
	public function clearInstanceCache( $reloadFrom = false ) {
		$this->mNewtalk = -1;
		$this->mDatePreference = null;
		$this->mBlockedby = -1; # Unset
		$this->mHash = false;
		$this->mRights = null;
		$this->mEffectiveGroups = null;
		$this->mImplicitGroups = null;
		$this->mOptions = null;

		if ( $reloadFrom ) {
			$this->mLoadedItems = array();
			$this->mFrom = $reloadFrom;
		}
	}

	/**
	 * Combine the language default options with any site-specific options
	 * and add the default language variants.
	 *
	 * @return Array of String options
	 */
	public static function getDefaultOptions() {
		global $wgNamespacesToBeSearchedDefault, $wgDefaultwiki_userOptions, $wgContLang, $wgDefaultSkin;

		$defOpt = $wgDefaultwiki_userOptions;
		# default language setting
		$variant = $wgContLang->getDefaultVariant();
		$defOpt['variant'] = $variant;
		$defOpt['language'] = $variant;
		foreach( SearchEngine::searchableNamespaces() as $nsnum => $nsname ) {
			$defOpt['searchNs'.$nsnum] = !empty( $wgNamespacesToBeSearchedDefault[$nsnum] );
		}
		$defOpt['skin'] = $wgDefaultSkin;

		// FIXME: Ideally we'd cache the results of this function so the hook is only run once,
		// but that breaks the parser tests because they rely on being able to change $wgContLang
		// mid-request and see that change reflected in the return value of this function.
		// Which is insane and would never happen during normal MW operation, but is also not
		// likely to get fixed unless and until we context-ify everything.
		// See also https://www.mediawiki.org/wiki/Special:Code/MediaWiki/101488#c25275
		wfRunHooks( 'wiki_userGetDefaultOptions', array( &$defOpt ) );

		return $defOpt;
	}

	/**
	 * Get a given default option value.
	 *
	 * @param $opt String Name of option to retrieve
	 * @return String Default option value
	 */
	public static function getDefaultOption( $opt ) {
		$defOpts = self::getDefaultOptions();
		if( isset( $defOpts[$opt] ) ) {
			return $defOpts[$opt];
		} else {
			return null;
		}
	}


	/**
	 * Get blocking information
	 * @param $bFromSlave Bool Whether to check the slave database first. To
	 *                    improve performance, non-critical checks are done
	 *                    against slaves. Check when actually saving should be
	 *                    done against master.
	 */
	private function getBlockedStatus( $bFromSlave = true ) {
		global $wgProxyWhitelist, $wgwiki_user;

		if ( -1 != $this->mBlockedby ) {
			return;
		}

		wfProfileIn( __METHOD__ );
		wfDebug( __METHOD__.": checking...\n" );

		// Initialize data...
		// Otherwise something ends up stomping on $this->mBlockedby when
		// things get lazy-loaded later, causing false positive block hits
		// due to -1 !== 0. Probably session-related... Nothing should be
		// overwriting mBlockedby, surely?
		$this->load();

		# We only need to worry about passing the IP address to the Block generator if the
		# wiki_user is not immune to autoblocks/hardblocks, and they are the current wiki_user so we
		# know which IP address they're actually coming from
		if ( !$this->isAllowed( 'ipblock-exempt' ) && $this->getID() == $wgwiki_user->getID() ) {
			$ip = $this->getRequest()->getIP();
		} else {
			$ip = null;
		}

		# wiki_user/IP blocking
		$block = Block::newFromTarget( $this, $ip, !$bFromSlave );

		# Proxy blocking
		if ( !$block instanceof Block && $ip !== null && !$this->isAllowed( 'proxyunbannable' )
			&& !in_array( $ip, $wgProxyWhitelist ) )
		{
			# Local list
			if ( self::isLocallyBlockedProxy( $ip ) ) {
				$block = new Block;
				$block->setBlocker( wfMessage( 'proxyblocker' )->text() );
				$block->mReason = wfMessage( 'proxyblockreason' )->text();
				$block->setTarget( $ip );
			} elseif ( $this->isAnon() && $this->isDnsBlacklisted( $ip ) ) {
				$block = new Block;
				$block->setBlocker( wfMessage( 'sorbs' )->text() );
				$block->mReason = wfMessage( 'sorbsreason' )->text();
				$block->setTarget( $ip );
			}
		}

		if ( $block instanceof Block ) {
			wfDebug( __METHOD__ . ": Found block.\n" );
			$this->mBlock = $block;
			$this->mBlockedby = $block->getByName();
			$this->mBlockreason = $block->mReason;
			$this->mHideName = $block->mHideName;
			$this->mAllowwiki_usertalk = !$block->prevents( 'editownwiki_usertalk' );
		} else {
			$this->mBlockedby = '';
			$this->mHideName = 0;
			$this->mAllowwiki_usertalk = false;
		}

		# Extensions
		wfRunHooks( 'GetBlockedStatus', array( &$this ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Whether the given IP is in a DNS blacklist.
	 *
	 * @param $ip String IP to check
	 * @param $checkWhitelist Bool: whether to check the whitelist first
	 * @return Bool True if blacklisted.
	 */
	public function isDnsBlacklisted( $ip, $checkWhitelist = false ) {
		global $wgEnableSorbs, $wgEnableDnsBlacklist,
			$wgSorbsUrl, $wgDnsBlacklistUrls, $wgProxyWhitelist;

		if ( !$wgEnableDnsBlacklist && !$wgEnableSorbs )
			return false;

		if ( $checkWhitelist && in_array( $ip, $wgProxyWhitelist ) )
			return false;

		$urls = array_merge( $wgDnsBlacklistUrls, (array)$wgSorbsUrl );
		return $this->inDnsBlacklist( $ip, $urls );
	}

	/**
	 * Whether the given IP is in a given DNS blacklist.
	 *
	 * @param $ip String IP to check
	 * @param $bases String|Array of Strings: URL of the DNS blacklist
	 * @return Bool True if blacklisted.
	 */
	public function inDnsBlacklist( $ip, $bases ) {
		wfProfileIn( __METHOD__ );

		$found = false;
		// @todo FIXME: IPv6 ???  (http://bugs.php.net/bug.php?id=33170)
		if( IP::isIPv4( $ip ) ) {
			# Reverse IP, bug 21255
			$ipReversed = implode( '.', array_reverse( explode( '.', $ip ) ) );

			foreach( (array)$bases as $base ) {
				# Make hostname
				# If we have an access key, use that too (ProjectHoneypot, etc.)
				if( is_array( $base ) ) {
					if( count( $base ) >= 2 ) {
						# Access key is 1, base URL is 0
						$host = "{$base[1]}.$ipReversed.{$base[0]}";
					} else {
						$host = "$ipReversed.{$base[0]}";
					}
				} else {
					$host = "$ipReversed.$base";
				}

				# Send query
				$ipList = gethostbynamel( $host );

				if( $ipList ) {
					wfDebugLog( 'dnsblacklist', "Hostname $host is {$ipList[0]}, it's a proxy says $base!\n" );
					$found = true;
					break;
				} else {
					wfDebugLog( 'dnsblacklist', "Requested $host, not found in $base.\n" );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $found;
	}

	/**
	 * Check if an IP address is in the local proxy list
	 *
	 * @param $ip string
	 *
	 * @return bool
	 */
	public static function isLocallyBlockedProxy( $ip ) {
		global $wgProxyList;

		if ( !$wgProxyList ) {
			return false;
		}
		wfProfileIn( __METHOD__ );

		if ( !is_array( $wgProxyList ) ) {
			# Load from the specified file
			$wgProxyList = array_map( 'trim', file( $wgProxyList ) );
		}

		if ( !is_array( $wgProxyList ) ) {
			$ret = false;
		} elseif ( array_search( $ip, $wgProxyList ) !== false ) {
			$ret = true;
		} elseif ( array_key_exists( $ip, $wgProxyList ) ) {
			# Old-style flipped proxy list
			$ret = true;
		} else {
			$ret = false;
		}
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Is this wiki_user subject to rate limiting?
	 *
	 * @return Bool True if rate limited
	 */
	public function isPingLimitable() {
		global $wgRateLimitsExcludedIPs;
		if( in_array( $this->getRequest()->getIP(), $wgRateLimitsExcludedIPs ) ) {
			// No other good way currently to disable rate limits
			// for specific IPs. :P
			// But this is a crappy hack and should die.
			return false;
		}
		return !$this->isAllowed('noratelimit');
	}

	/**
	 * Primitive rate limits: enforce maximum actions per time period
	 * to put a brake on flooding.
	 *
	 * @note When using a shared cache like memcached, IP-address
	 * last-hit counters will be shared across wikis.
	 *
	 * @param $action String Action to enforce; 'edit' if unspecified
	 * @return Bool True if a rate limiter was tripped
	 */
	public function pingLimiter( $action = 'edit' ) {
		# Call the 'PingLimiter' hook
		$result = false;
		if( !wfRunHooks( 'PingLimiter', array( &$this, $action, $result ) ) ) {
			return $result;
		}

		global $wgRateLimits;
		if( !isset( $wgRateLimits[$action] ) ) {
			return false;
		}

		# Some groups shouldn't trigger the ping limiter, ever
		if( !$this->isPingLimitable() )
			return false;

		global $wgMemc, $wgRateLimitLog;
		wfProfileIn( __METHOD__ );

		$limits = $wgRateLimits[$action];
		$keys = array();
		$id = $this->getId();
		$ip = $this->getRequest()->getIP();
		$wiki_userLimit = false;

		if( isset( $limits['anon'] ) && $id == 0 ) {
			$keys[wfMemcKey( 'limiter', $action, 'anon' )] = $limits['anon'];
		}

		if( isset( $limits['wiki_user'] ) && $id != 0 ) {
			$wiki_userLimit = $limits['wiki_user'];
		}
		if( $this->isNewbie() ) {
			if( isset( $limits['newbie'] ) && $id != 0 ) {
				$keys[wfMemcKey( 'limiter', $action, 'wiki_user', $id )] = $limits['newbie'];
			}
			if( isset( $limits['ip'] ) ) {
				$keys["mediawiki:limiter:$action:ip:$ip"] = $limits['ip'];
			}
			$matches = array();
			if( isset( $limits['subnet'] ) && preg_match( '/^(\d+\.\d+\.\d+)\.\d+$/', $ip, $matches ) ) {
				$subnet = $matches[1];
				$keys["mediawiki:limiter:$action:subnet:$subnet"] = $limits['subnet'];
			}
		}
		// Check for group-specific permissions
		// If more than one group applies, use the group with the highest limit
		foreach ( $this->getGroups() as $group ) {
			if ( isset( $limits[$group] ) ) {
				if ( $wiki_userLimit === false || $limits[$group] > $wiki_userLimit ) {
					$wiki_userLimit = $limits[$group];
				}
			}
		}
		// Set the wiki_user limit key
		if ( $wiki_userLimit !== false ) {
			wfDebug( __METHOD__ . ": effective wiki_user limit: $wiki_userLimit\n" );
			$keys[ wfMemcKey( 'limiter', $action, 'wiki_user', $id ) ] = $wiki_userLimit;
		}

		$triggered = false;
		foreach( $keys as $key => $limit ) {
			list( $max, $period ) = $limit;
			$summary = "(limit $max in {$period}s)";
			$count = $wgMemc->get( $key );
			// Already pinged?
			if( $count ) {
				if( $count >= $max ) {
					wfDebug( __METHOD__ . ": tripped! $key at $count $summary\n" );
					if( $wgRateLimitLog ) {
						wfSuppressWarnings();
						file_put_contents( $wgRateLimitLog, wfTimestamp( TS_MW ) . ' ' . wfWikiID() . ': ' . $this->getName() . " tripped $key at $count $summary\n", FILE_APPEND );
						wfRestoreWarnings();
					}
					$triggered = true;
				} else {
					wfDebug( __METHOD__ . ": ok. $key at $count $summary\n" );
				}
			} else {
				wfDebug( __METHOD__ . ": adding record for $key $summary\n" );
				$wgMemc->add( $key, 0, intval( $period ) ); // first ping
			}
			$wgMemc->incr( $key );
		}

		wfProfileOut( __METHOD__ );
		return $triggered;
	}

	/**
	 * Check if wiki_user is blocked
	 *
	 * @param $bFromSlave Bool Whether to check the slave database instead of the master
	 * @return Bool True if blocked, false otherwise
	 */
	public function isBlocked( $bFromSlave = true ) { // hacked from false due to horrible probs on site
		return $this->getBlock( $bFromSlave ) instanceof Block && $this->getBlock()->prevents( 'edit' );
	}

	/**
	 * Get the block affecting the wiki_user, or null if the wiki_user is not blocked
	 *
	 * @param $bFromSlave Bool Whether to check the slave database instead of the master
	 * @return Block|null
	 */
	public function getBlock( $bFromSlave = true ){
		$this->getBlockedStatus( $bFromSlave );
		return $this->mBlock instanceof Block ? $this->mBlock : null;
	}

	/**
	 * Check if wiki_user is blocked from editing a particular article
	 *
	 * @param $title Title to check
	 * @param $bFromSlave Bool whether to check the slave database instead of the master
	 * @return Bool
	 */
	function isBlockedFrom( $title, $bFromSlave = false ) {
		global $wgBlockAllowsUTEdit;
		wfProfileIn( __METHOD__ );

		$blocked = $this->isBlocked( $bFromSlave );
		$allowwiki_usertalk = ( $wgBlockAllowsUTEdit ? $this->mAllowwiki_usertalk : false );
		# If a wiki_user's name is suppressed, they cannot make edits anywhere
		if ( !$this->mHideName && $allowwiki_usertalk && $title->getText() === $this->getName() &&
		  $title->getNamespace() == NS_USER_TALK ) {
			$blocked = false;
			wfDebug( __METHOD__ . ": self-talk page, ignoring any blocks\n" );
		}

		wfRunHooks( 'wiki_userIsBlockedFrom', array( $this, $title, &$blocked, &$allowwiki_usertalk ) );

		wfProfileOut( __METHOD__ );
		return $blocked;
	}

	/**
	 * If wiki_user is blocked, return the name of the wiki_user who placed the block
	 * @return String name of blocker
	 */
	public function blockedBy() {
		$this->getBlockedStatus();
		return $this->mBlockedby;
	}

	/**
	 * If wiki_user is blocked, return the specified reason for the block
	 * @return String Blocking reason
	 */
	public function blockedFor() {
		$this->getBlockedStatus();
		return $this->mBlockreason;
	}

	/**
	 * If wiki_user is blocked, return the ID for the block
	 * @return Int Block ID
	 */
	public function getBlockId() {
		$this->getBlockedStatus();
		return ( $this->mBlock ? $this->mBlock->getId() : false );
	}

	/**
	 * Check if wiki_user is blocked on all wikis.
	 * Do not use for actual edit permission checks!
	 * This is intented for quick UI checks.
	 *
	 * @param $ip String IP address, uses current client if none given
	 * @return Bool True if blocked, false otherwise
	 */
	public function isBlockedGlobally( $ip = '' ) {
		if( $this->mBlockedGlobally !== null ) {
			return $this->mBlockedGlobally;
		}
		// wiki_user is already an IP?
		if( IP::isIPAddress( $this->getName() ) ) {
			$ip = $this->getName();
		} elseif( !$ip ) {
			$ip = $this->getRequest()->getIP();
		}
		$blocked = false;
		wfRunHooks( 'wiki_userIsBlockedGlobally', array( &$this, $ip, &$blocked ) );
		$this->mBlockedGlobally = (bool)$blocked;
		return $this->mBlockedGlobally;
	}

	/**
	 * Check if wiki_user account is locked
	 *
	 * @return Bool True if locked, false otherwise
	 */
	public function isLocked() {
		if( $this->mLocked !== null ) {
			return $this->mLocked;
		}
		global $wgAuth;
		$authwiki_user = $wgAuth->getwiki_userInstance( $this );
		$this->mLocked = (bool)$authwiki_user->isLocked();
		return $this->mLocked;
	}

	/**
	 * Check if wiki_user account is hidden
	 *
	 * @return Bool True if hidden, false otherwise
	 */
	public function isHidden() {
		if( $this->mHideName !== null ) {
			return $this->mHideName;
		}
		$this->getBlockedStatus();
		if( !$this->mHideName ) {
			global $wgAuth;
			$authwiki_user = $wgAuth->getwiki_userInstance( $this );
			$this->mHideName = (bool)$authwiki_user->isHidden();
		}
		return $this->mHideName;
	}

	/**
	 * Get the wiki_user's ID.
	 * @return Int The wiki_user's ID; 0 if the wiki_user is anonymous or nonexistent
	 */
	public function getId() {
		if( $this->mId === null && $this->mName !== null
		&& wiki_user::isIP( $this->mName ) ) {
			// Special case, we know the wiki_user is anonymous
			return 0;
		} elseif( !$this->isItemLoaded( 'id' ) ) {
			// Don't load if this was initialized from an ID
			$this->load();
		}
		return $this->mId;
	}

	/**
	 * Set the wiki_user and reload all fields according to a given ID
	 * @param $v Int wiki_user ID to reload
	 */
	public function setId( $v ) {
		$this->mId = $v;
		$this->clearInstanceCache( 'id' );
	}

	/**
	 * Get the wiki_user name, or the IP of an anonymous wiki_user
	 * @return String wiki_user's name or IP address
	 */
	public function getName() {
		if ( $this->isItemLoaded( 'name', 'only' ) ) {
			# Special case optimisation
			return $this->mName;
		} else {
			$this->load();
			if ( $this->mName === false ) {
				# Clean up IPs
				$this->mName = IP::sanitizeIP( $this->getRequest()->getIP() );
			}
			return $this->mName;
		}
	}

	/**
	 * Set the wiki_user name.
	 *
	 * This does not reload fields from the database according to the given
	 * name. Rather, it is used to create a temporary "nonexistent wiki_user" for
	 * later addition to the database. It can also be used to set the IP
	 * address for an anonymous wiki_user to something other than the current
	 * remote IP.
	 *
	 * @note wiki_user::newFromName() has rougly the same function, when the named wiki_user
	 * does not exist.
	 * @param $str String New wiki_user name to set
	 */
	public function setName( $str ) {
		$this->load();
		$this->mName = $str;
	}

	/**
	 * Get the wiki_user's name escaped by underscores.
	 * @return String wiki_username escaped by underscores.
	 */
	public function getTitleKey() {
		return str_replace( ' ', '_', $this->getName() );
	}

	/**
	 * Check if the wiki_user has new messages.
	 * @return Bool True if the wiki_user has new messages
	 */
	public function getNewtalk() {
		$this->load();

		# Load the newtalk status if it is unloaded (mNewtalk=-1)
		if( $this->mNewtalk === -1 ) {
			$this->mNewtalk = false; # reset talk page status

			# Check memcached separately for anons, who have no
			# entire wiki_user object stored in there.
			if( !$this->mId ) {
				global $wgDisableAnonTalk;
				if( $wgDisableAnonTalk ) {
					// Anon newtalk disabled by configuration.
					$this->mNewtalk = false;
				} else {
					global $wgMemc;
					$key = wfMemcKey( 'newtalk', 'ip', $this->getName() );
					$newtalk = $wgMemc->get( $key );
					if( strval( $newtalk ) !== '' ) {
						$this->mNewtalk = (bool)$newtalk;
					} else {
						// Since we are caching this, make sure it is up to date by getting it
						// from the master
						$this->mNewtalk = $this->checkNewtalk( 'wiki_user_ip', $this->getName(), true );
						$wgMemc->set( $key, (int)$this->mNewtalk, 1800 );
					}
				}
			} else {
				$this->mNewtalk = $this->checkNewtalk( 'wiki_user_id', $this->mId );
			}
		}

		return (bool)$this->mNewtalk;
	}

	/**
	 * Return the talk page(s) this wiki_user has new messages on.
	 * @return Array of String page URLs
	 */
	public function getNewMessageLinks() {
		$talks = array();
		if( !wfRunHooks( 'wiki_userRetrieveNewTalks', array( &$this, &$talks ) ) ) {
			return $talks;
		} elseif( !$this->getNewtalk() ) {
			return array();
		}
		$utp = $this->getTalkPage();
		r = wfGetDB( DB_SLAVE );
		// Get the "last viewed rev" timestamp from the oldest message notification
		$timestamp = r->selectField( 'wiki_user_newtalk',
			'MIN(wiki_user_last_timestamp)',
			$this->isAnon() ? array( 'wiki_user_ip' => $this->getName() ) : array( 'wiki_user_id' => $this->getID() ),
			__METHOD__ );
		$rev = $timestamp ? Revision::loadFromTimestamp( r, $utp, $timestamp ) : null;
		return array( array( 'wiki' => wfWikiID(), 'link' => $utp->getLocalURL(), 'rev' => $rev ) );
	}

	/**
	 * Internal uncached check for new messages
	 *
	 * @see getNewtalk()
	 * @param $field String 'wiki_user_ip' for anonymous wiki_users, 'wiki_user_id' otherwise
	 * @param $id String|Int wiki_user's IP address for anonymous wiki_users, wiki_user ID otherwise
	 * @param $fromMaster Bool true to fetch from the master, false for a slave
	 * @return Bool True if the wiki_user has new messages
	 */
	protected function checkNewtalk( $field, $id, $fromMaster = false ) {
		if ( $fromMaster ) {
			 = wfGetDB( DB_MASTER );
		} else {
			 = wfGetDB( DB_SLAVE );
		}
		$ok = ->selectField( 'wiki_user_newtalk', $field,
			array( $field => $id ), __METHOD__ );
		return $ok !== false;
	}

	/**
	 * Add or update the new messages flag
	 * @param $field String 'wiki_user_ip' for anonymous wiki_users, 'wiki_user_id' otherwise
	 * @param $id String|Int wiki_user's IP address for anonymous wiki_users, wiki_user ID otherwise
	 * @param $curRev Revision new, as yet unseen revision of the wiki_user talk page. Ignored if null.
	 * @return Bool True if successful, false otherwise
	 */
	protected function updateNewtalk( $field, $id, $curRev = null ) {
		// Get timestamp of the talk page revision prior to the current one
		$prevRev = $curRev ? $curRev->getPrevious() : false;
		$ts = $prevRev ? $prevRev->getTimestamp() : null;
		// Mark the wiki_user as having new messages since this revision
		w = wfGetDB( DB_MASTER );
		w->insert( 'wiki_user_newtalk',
			array( $field => $id, 'wiki_user_last_timestamp' => w->timestampOrNull( $ts ) ),
			__METHOD__,
			'IGNORE' );
		if ( w->affectedRows() ) {
			wfDebug( __METHOD__ . ": set on ($field, $id)\n" );
			return true;
		} else {
			wfDebug( __METHOD__ . " already set ($field, $id)\n" );
			return false;
		}
	}

	/**
	 * Clear the new messages flag for the given wiki_user
	 * @param $field String 'wiki_user_ip' for anonymous wiki_users, 'wiki_user_id' otherwise
	 * @param $id String|Int wiki_user's IP address for anonymous wiki_users, wiki_user ID otherwise
	 * @return Bool True if successful, false otherwise
	 */
	protected function deleteNewtalk( $field, $id ) {
		w = wfGetDB( DB_MASTER );
		w->delete( 'wiki_user_newtalk',
			array( $field => $id ),
			__METHOD__ );
		if ( w->affectedRows() ) {
			wfDebug( __METHOD__ . ": killed on ($field, $id)\n" );
			return true;
		} else {
			wfDebug( __METHOD__ . ": already gone ($field, $id)\n" );
			return false;
		}
	}

	/**
	 * Update the 'You have new messages!' status.
	 * @param $val Bool Whether the wiki_user has new messages
	 * @param $curRev Revision new, as yet unseen revision of the wiki_user talk page. Ignored if null or !$val.
	 */
	public function setNewtalk( $val, $curRev = null ) {
		if( wfReadOnly() ) {
			return;
		}

		$this->load();
		$this->mNewtalk = $val;

		if( $this->isAnon() ) {
			$field = 'wiki_user_ip';
			$id = $this->getName();
		} else {
			$field = 'wiki_user_id';
			$id = $this->getId();
		}
		global $wgMemc;

		if( $val ) {
			$changed = $this->updateNewtalk( $field, $id, $curRev );
		} else {
			$changed = $this->deleteNewtalk( $field, $id );
		}

		if( $this->isAnon() ) {
			// Anons have a separate memcached space, since
			// wiki_user records aren't kept for them.
			$key = wfMemcKey( 'newtalk', 'ip', $id );
			$wgMemc->set( $key, $val ? 1 : 0, 1800 );
		}
		if ( $changed ) {
			$this->invalidateCache();
		}
	}

	/**
	 * Generate a current or new-future timestamp to be stored in the
	 * wiki_user_touched field when we update things.
	 * @return String Timestamp in TS_MW format
	 */
	private static function newTouchedTimestamp() {
		global $wgClockSkewFudge;
		return wfTimestamp( TS_MW, time() + $wgClockSkewFudge );
	}

	/**
	 * Clear wiki_user data from memcached.
	 * Use after applying fun updates to the database; caller's
	 * responsibility to update wiki_user_touched if appropriate.
	 *
	 * Called implicitly from invalidateCache() and saveSettings().
	 */
	private function clearSharedCache() {
		$this->load();
		if( $this->mId ) {
			global $wgMemc;
			$wgMemc->delete( wfMemcKey( 'wiki_user', 'id', $this->mId ) );
		}
	}

	/**
	 * Immediately touch the wiki_user data cache for this account.
	 * Updates wiki_user_touched field, and removes account data from memcached
	 * for reload on the next hit.
	 */
	public function invalidateCache() {
		if( wfReadOnly() ) {
			return;
		}
		$this->load();
		if( $this->mId ) {
			$this->mTouched = self::newTouchedTimestamp();

			w = wfGetDB( DB_MASTER );

			// Prevent contention slams by checking wiki_user_touched first
			$now = w->timestamp( $this->mTouched );
			$needsPurge = w->selectField( 'wiki_user', '1',
				array( 'wiki_user_id' => $this->mId, 'wiki_user_touched < ' . w->addQuotes( $now ) )
			);
			if ( $needsPurge ) {
				w->update( 'wiki_user',
					array( 'wiki_user_touched' => $now ),
					array( 'wiki_user_id' => $this->mId, 'wiki_user_touched < ' . w->addQuotes( $now ) ),
					__METHOD__
				);
			}

			$this->clearSharedCache();
		}
	}

	/**
	 * Validate the cache for this account.
	 * @param $timestamp String A timestamp in TS_MW format
	 *
	 * @return bool
	 */
	public function validateCache( $timestamp ) {
		$this->load();
		return ( $timestamp >= $this->mTouched );
	}

	/**
	 * Get the wiki_user touched timestamp
	 * @return String timestamp
	 */
	public function getTouched() {
		$this->load();
		return $this->mTouched;
	}

	/**
	 * Set the password and reset the random token.
	 * Calls through to authentication plugin if necessary;
	 * will have no effect if the auth plugin refuses to
	 * pass the change through or if the legal password
	 * checks fail.
	 *
	 * As a special case, setting the password to null
	 * wipes it, so the account cannot be logged in until
	 * a new password is set, for instance via e-mail.
	 *
	 * @param $str String New password to set
	 * @throws PasswordError on failure
	 *
	 * @return bool
	 */
	public function setPassword( $str ) {
		global $wgAuth;

		if( $str !== null ) {
			if( !$wgAuth->allowPasswordChange() ) {
				throw new PasswordError( wfMessage( 'password-change-forbidden' )->text() );
			}

			if( !$this->isValidPassword( $str ) ) {
				global $wgMinimalPasswordLength;
				$valid = $this->getPasswordValidity( $str );
				if ( is_array( $valid ) ) {
					$message = array_shift( $valid );
					$params = $valid;
				} else {
					$message = $valid;
					$params = array( $wgMinimalPasswordLength );
				}
				throw new PasswordError( wfMessage( $message, $params )->text() );
			}
		}

		if( !$wgAuth->setPassword( $this, $str ) ) {
			throw new PasswordError( wfMessage( 'externaldberror' )->text() );
		}

		$this->setInternalPassword( $str );

		return true;
	}

	/**
	 * Set the password and reset the random token unconditionally.
	 *
	 * @param $str String New password to set
	 */
	public function setInternalPassword( $str ) {
		$this->load();
		$this->setToken();

		if( $str === null ) {
			// Save an invalid hash...
			$this->mPassword = '';
		} else {
			$this->mPassword = self::crypt( $str );
		}
		$this->mNewpassword = '';
		$this->mNewpassTime = null;
	}

	/**
	 * Get the wiki_user's current token.
	 * @param $forceCreation Force the generation of a new token if the wiki_user doesn't have one (default=true for backwards compatibility)
	 * @return String Token
	 */
	public function getToken( $forceCreation = true ) {
		$this->load();
		if ( !$this->mToken && $forceCreation ) {
			$this->setToken();
		}
		return $this->mToken;
	}

	/**
	 * Set the random token (used for persistent authentication)
	 * Called from loadDefaults() among other places.
	 *
	 * @param $token String|bool If specified, set the token to this value
	 */
	public function setToken( $token = false ) {
		$this->load();
		if ( !$token ) {
			$this->mToken = MWCryptRand::generateHex( USER_TOKEN_LENGTH );
		} else {
			$this->mToken = $token;
		}
	}

	/**
	 * Set the password for a password reminder or new account email
	 *
	 * @param $str String New password to set
	 * @param $throttle Bool If true, reset the throttle timestamp to the present
	 */
	public function setNewpassword( $str, $throttle = true ) {
		$this->load();
		$this->mNewpassword = self::crypt( $str );
		if ( $throttle ) {
			$this->mNewpassTime = wfTimestampNow();
		}
	}

	/**
	 * Has password reminder email been sent within the last
	 * $wgPasswordReminderResendTime hours?
	 * @return Bool
	 */
	public function isPasswordReminderThrottled() {
		global $wgPasswordReminderResendTime;
		$this->load();
		if ( !$this->mNewpassTime || !$wgPasswordReminderResendTime ) {
			return false;
		}
		$expiry = wfTimestamp( TS_UNIX, $this->mNewpassTime ) + $wgPasswordReminderResendTime * 3600;
		return time() < $expiry;
	}

	/**
	 * Get the wiki_user's e-mail address
	 * @return String wiki_user's email address
	 */
	public function getEmail() {
		$this->load();
		wfRunHooks( 'wiki_userGetEmail', array( $this, &$this->mEmail ) );
		return $this->mEmail;
	}

	/**
	 * Get the timestamp of the wiki_user's e-mail authentication
	 * @return String TS_MW timestamp
	 */
	public function getEmailAuthenticationTimestamp() {
		$this->load();
		wfRunHooks( 'wiki_userGetEmailAuthenticationTimestamp', array( $this, &$this->mEmailAuthenticated ) );
		return $this->mEmailAuthenticated;
	}

	/**
	 * Set the wiki_user's e-mail address
	 * @param $str String New e-mail address
	 */
	public function setEmail( $str ) {
		$this->load();
		if( $str == $this->mEmail ) {
			return;
		}
		$this->mEmail = $str;
		$this->invalidateEmail();
		wfRunHooks( 'wiki_userSetEmail', array( $this, &$this->mEmail ) );
	}

	/**
	 * Set the wiki_user's e-mail address and a confirmation mail if needed.
	 *
	 * @since 1.20
	 * @param $str String New e-mail address
	 * @return Status
	 */
	public function setEmailWithConfirmation( $str ) {
		global $wgEnableEmail, $wgEmailAuthentication;

		if ( !$wgEnableEmail ) {
			return Status::newFatal( 'emaildisabled' );
		}

		$oldaddr = $this->getEmail();
		if ( $str === $oldaddr ) {
			return Status::newGood( true );
		}

		$this->setEmail( $str );

		if ( $str !== '' && $wgEmailAuthentication ) {
			# Send a confirmation request to the new address if needed
			$type = $oldaddr != '' ? 'changed' : 'set';
			$result = $this->sendConfirmationMail( $type );
			if ( $result->isGood() ) {
				# Say the the caller that a confirmation mail has been sent
				$result->value = 'eauth';
			}
		} else {
			$result = Status::newGood( true );
		}

		return $result;
	}

	/**
	 * Get the wiki_user's real name
	 * @return String wiki_user's real name
	 */
	public function getRealName() {
		if ( !$this->isItemLoaded( 'realname' ) ) {
			$this->load();
		}

		return $this->mRealName;
	}

	/**
	 * Set the wiki_user's real name
	 * @param $str String New real name
	 */
	public function setRealName( $str ) {
		$this->load();
		$this->mRealName = $str;
	}

	/**
	 * Get the wiki_user's current setting for a given option.
	 *
	 * @param $oname String The option to check
	 * @param $defaultOverride String A default value returned if the option does not exist
	 * @param $ignoreHidden Bool = whether to ignore the effects of $wgHiddenPrefs
	 * @return String wiki_user's current value for the option
	 * @see getBoolOption()
	 * @see getIntOption()
	 */
	public function getOption( $oname, $defaultOverride = null, $ignoreHidden = false ) {
		global $wgHiddenPrefs;
		$this->loadOptions();

		if ( is_null( $this->mOptions ) ) {
			if($defaultOverride != '') {
				return $defaultOverride;
			}
			$this->mOptions = wiki_user::getDefaultOptions();
		}

		# We want 'disabled' preferences to always behave as the default value for
		# wiki_users, even if they have set the option explicitly in their settings (ie they
		# set it, and then it was disabled removing their ability to change it).  But
		# we don't want to erase the preferences in the database in case the preference
		# is re-enabled again.  So don't touch $mOptions, just override the returned value
		if( in_array( $oname, $wgHiddenPrefs ) && !$ignoreHidden ){
			return self::getDefaultOption( $oname );
		}

		if ( array_key_exists( $oname, $this->mOptions ) ) {
			return $this->mOptions[$oname];
		} else {
			return $defaultOverride;
		}
	}

	/**
	 * Get all wiki_user's options
	 *
	 * @return array
	 */
	public function getOptions() {
		global $wgHiddenPrefs;
		$this->loadOptions();
		$options = $this->mOptions;

		# We want 'disabled' preferences to always behave as the default value for
		# wiki_users, even if they have set the option explicitly in their settings (ie they
		# set it, and then it was disabled removing their ability to change it).  But
		# we don't want to erase the preferences in the database in case the preference
		# is re-enabled again.  So don't touch $mOptions, just override the returned value
		foreach( $wgHiddenPrefs as $pref ){
			$default = self::getDefaultOption( $pref );
			if( $default !== null ){
				$options[$pref] = $default;
			}
		}

		return $options;
	}

	/**
	 * Get the wiki_user's current setting for a given option, as a boolean value.
	 *
	 * @param $oname String The option to check
	 * @return Bool wiki_user's current value for the option
	 * @see getOption()
	 */
	public function getBoolOption( $oname ) {
		return (bool)$this->getOption( $oname );
	}

	/**
	 * Get the wiki_user's current setting for a given option, as a boolean value.
	 *
	 * @param $oname String The option to check
	 * @param $defaultOverride Int A default value returned if the option does not exist
	 * @return Int wiki_user's current value for the option
	 * @see getOption()
	 */
	public function getIntOption( $oname, $defaultOverride=0 ) {
		$val = $this->getOption( $oname );
		if( $val == '' ) {
			$val = $defaultOverride;
		}
		return intval( $val );
	}

	/**
	 * Set the given option for a wiki_user.
	 *
	 * @param $oname String The option to set
	 * @param $val mixed New value to set
	 */
	public function setOption( $oname, $val ) {
		$this->load();
		$this->loadOptions();

		// Explicitly NULL values should refer to defaults
		if( is_null( $val ) ) {
			$defaultOption = self::getDefaultOption( $oname );
			if( !is_null( $defaultOption ) ) {
				$val = $defaultOption;
			}
		}

		$this->mOptions[$oname] = $val;
	}

	/**
	 * Reset all options to the site defaults
	 */
	public function resetOptions() {
		$this->load();

		$this->mOptions = self::getDefaultOptions();
		$this->mOptionsLoaded = true;
	}

	/**
	 * Get the wiki_user's preferred date format.
	 * @return String wiki_user's preferred date format
	 */
	public function getDatePreference() {
		// Important migration for old data rows
		if ( is_null( $this->mDatePreference ) ) {
			global $wgLang;
			$value = $this->getOption( 'date' );
			$map = $wgLang->getDatePreferenceMigrationMap();
			if ( isset( $map[$value] ) ) {
				$value = $map[$value];
			}
			$this->mDatePreference = $value;
		}
		return $this->mDatePreference;
	}

	/**
	 * Get the wiki_user preferred stub threshold
	 *
	 * @return int
	 */
	public function getStubThreshold() {
		global $wgMaxArticleSize; # Maximum article size, in Kb
		$threshold = intval( $this->getOption( 'stubthreshold' ) );
		if ( $threshold > $wgMaxArticleSize * 1024 ) {
			# If they have set an impossible value, disable the preference
			# so we can use the parser cache again.
			$threshold = 0;
		}
		return $threshold;
	}

	/**
	 * Get the permissions this wiki_user has.
	 * @return Array of String permission names
	 */
	public function getRights() {
		if ( is_null( $this->mRights ) ) {
			$this->mRights = self::getGroupPermissions( $this->getEffectiveGroups() );
			wfRunHooks( 'wiki_userGetRights', array( $this, &$this->mRights ) );
			// Force reindexation of rights when a hook has unset one of them
			$this->mRights = array_values( $this->mRights );
		}
		return $this->mRights;
	}

	/**
	 * Get the list of explicit group memberships this wiki_user has.
	 * The implicit * and wiki_user groups are not included.
	 * @return Array of String internal group names
	 */
	public function getGroups() {
		$this->load();
		$this->loadGroups();
		return $this->mGroups;
	}

	/**
	 * Get the list of implicit group memberships this wiki_user has.
	 * This includes all explicit groups, plus 'wiki_user' if logged in,
	 * '*' for all accounts, and autopromoted groups
	 * @param $recache Bool Whether to avoid the cache
	 * @return Array of String internal group names
	 */
	public function getEffectiveGroups( $recache = false ) {
		if ( $recache || is_null( $this->mEffectiveGroups ) ) {
			wfProfileIn( __METHOD__ );
			$this->mEffectiveGroups = array_unique( array_merge(
				$this->getGroups(), // explicit groups
				$this->getAutomaticGroups( $recache ) // implicit groups
			) );
			# Hook for additional groups
			wfRunHooks( 'wiki_userEffectiveGroups', array( &$this, &$this->mEffectiveGroups ) );
			wfProfileOut( __METHOD__ );
		}
		return $this->mEffectiveGroups;
	}

	/**
	 * Get the list of implicit group memberships this wiki_user has.
	 * This includes 'wiki_user' if logged in, '*' for all accounts,
	 * and autopromoted groups
	 * @param $recache Bool Whether to avoid the cache
	 * @return Array of String internal group names
	 */
	public function getAutomaticGroups( $recache = false ) {
		if ( $recache || is_null( $this->mImplicitGroups ) ) {
			wfProfileIn( __METHOD__ );
			$this->mImplicitGroups = array( '*' );
			if ( $this->getId() ) {
				$this->mImplicitGroups[] = 'wiki_user';

				$this->mImplicitGroups = array_unique( array_merge(
					$this->mImplicitGroups,
					Autopromote::getAutopromoteGroups( $this )
				) );
			}
			if ( $recache ) {
				# Assure data consistency with rights/groups,
				# as getEffectiveGroups() depends on this function
				$this->mEffectiveGroups = null;
			}
			wfProfileOut( __METHOD__ );
		}
		return $this->mImplicitGroups;
	}

	/**
	 * Returns the groups the wiki_user has belonged to.
	 *
	 * The wiki_user may still belong to the returned groups. Compare with getGroups().
	 *
	 * The function will not return groups the wiki_user had belonged to before MW 1.17
	 *
	 * @return array Names of the groups the wiki_user has belonged to.
	 */
	public function getFormerGroups() {
		if( is_null( $this->mFormerGroups ) ) {
			r = wfGetDB( DB_MASTER );
			$res = r->select( 'wiki_user_former_groups',
				array( 'ufg_group' ),
				array( 'ufg_wiki_user' => $this->mId ),
				__METHOD__ );
			$this->mFormerGroups = array();
			foreach( $res as $row ) {
				$this->mFormerGroups[] = $row->ufg_group;
			}
		}
		return $this->mFormerGroups;
	}

	/**
	 * Get the wiki_user's edit count.
	 * @return Int
	 */
	public function getEditCount() {
		if( $this->getId() ) {
			if ( !isset( $this->mEditCount ) ) {
				/* Populate the count, if it has not been populated yet */
				$this->mEditCount = wiki_user::edits( $this->mId );
			}
			return $this->mEditCount;
		} else {
			/* nil */
			return null;
		}
	}

	/**
	 * Add the wiki_user to the given group.
	 * This takes immediate effect.
	 * @param $group String Name of the group to add
	 */
	public function addGroup( $group ) {
		if( wfRunHooks( 'wiki_userAddGroup', array( $this, &$group ) ) ) {
			w = wfGetDB( DB_MASTER );
			if( $this->getId() ) {
				w->insert( 'wiki_user_groups',
					array(
						'ug_wiki_user'  => $this->getID(),
						'ug_group' => $group,
					),
					__METHOD__,
					array( 'IGNORE' ) );
			}
		}
		$this->loadGroups();
		$this->mGroups[] = $group;
		$this->mRights = wiki_user::getGroupPermissions( $this->getEffectiveGroups( true ) );

		$this->invalidateCache();
	}

	/**
	 * Remove the wiki_user from the given group.
	 * This takes immediate effect.
	 * @param $group String Name of the group to remove
	 */
	public function removeGroup( $group ) {
		$this->load();
		if( wfRunHooks( 'wiki_userRemoveGroup', array( $this, &$group ) ) ) {
			w = wfGetDB( DB_MASTER );
			w->delete( 'wiki_user_groups',
				array(
					'ug_wiki_user'  => $this->getID(),
					'ug_group' => $group,
				), __METHOD__ );
			// Remember that the wiki_user was in this group
			w->insert( 'wiki_user_former_groups',
				array(
					'ufg_wiki_user'  => $this->getID(),
					'ufg_group' => $group,
				),
				__METHOD__,
				array( 'IGNORE' ) );
		}
		$this->loadGroups();
		$this->mGroups = array_diff( $this->mGroups, array( $group ) );
		$this->mRights = wiki_user::getGroupPermissions( $this->getEffectiveGroups( true ) );

		$this->invalidateCache();
	}

	/**
	 * Get whether the wiki_user is logged in
	 * @return Bool
	 */
	public function isLoggedIn() {
		return $this->getID() != 0;
	}

	/**
	 * Get whether the wiki_user is anonymous
	 * @return Bool
	 */
	public function isAnon() {
		return !$this->isLoggedIn();
	}

	/**
	 * Check if wiki_user is allowed to access a feature / make an action
	 *
	 * @internal param \String $varargs permissions to test
	 * @return Boolean: True if wiki_user is allowed to perform *any* of the given actions
	 *
	 * @return bool
	 */
	public function isAllowedAny( /*...*/ ){
		$permissions = func_get_args();
		foreach( $permissions as $permission ){
			if( $this->isAllowed( $permission ) ){
				return true;
			}
		}
		return false;
	}

	/**
	 *
	 * @internal param $varargs string
	 * @return bool True if the wiki_user is allowed to perform *all* of the given actions
	 */
	public function isAllowedAll( /*...*/ ){
		$permissions = func_get_args();
		foreach( $permissions as $permission ){
			if( !$this->isAllowed( $permission ) ){
				return false;
			}
		}
		return true;
	}

	/**
	 * Internal mechanics of testing a permission
	 * @param $action String
	 * @return bool
	 */
	public function isAllowed( $action = '' ) {
		if ( $action === '' ) {
			return true; // In the spirit of DWIM
		}
		# Patrolling may not be enabled
		if( $action === 'patrol' || $action === 'autopatrol' ) {
			global $wgUseRCPatrol, $wgUseNPPatrol;
			if( !$wgUseRCPatrol && !$wgUseNPPatrol )
				return false;
		}
		# Use strict parameter to avoid matching numeric 0 accidentally inserted
		# by misconfiguration: 0 == 'foo'
		return in_array( $action, $this->getRights(), true );
	}

	/**
	 * Check whether to enable recent changes patrol features for this wiki_user
	 * @return Boolean: True or false
	 */
	public function useRCPatrol() {
		global $wgUseRCPatrol;
		return $wgUseRCPatrol && $this->isAllowedAny( 'patrol', 'patrolmarks' );
	}

	/**
	 * Check whether to enable new pages patrol features for this wiki_user
	 * @return Bool True or false
	 */
	public function useNPPatrol() {
		global $wgUseRCPatrol, $wgUseNPPatrol;
		return( ( $wgUseRCPatrol || $wgUseNPPatrol ) && ( $this->isAllowedAny( 'patrol', 'patrolmarks' ) ) );
	}

	/**
	 * Get the WebRequest object to use with this object
	 *
	 * @return WebRequest
	 */
	public function getRequest() {
		if ( $this->mRequest ) {
			return $this->mRequest;
		} else {
			global $wgRequest;
			return $wgRequest;
		}
	}

	/**
	 * Get the current skin, loading it if required
	 * @return Skin The current skin
	 * @todo FIXME: Need to check the old failback system [AV]
	 * @deprecated since 1.18 Use ->getSkin() in the most relevant outputting context you have
	 */
	public function getSkin() {
		wfDeprecated( __METHOD__, '1.18' );
		return RequestContext::getMain()->getSkin();
	}

	/**
	 * Get a WatchedItem for this wiki_user and $title.
	 *
	 * @param $title Title
	 * @return WatchedItem
	 */
	public function getWatchedItem( $title ) {
		$key = $title->getNamespace() . ':' . $title->getDBkey();

		if ( isset( $this->mWatchedItems[$key] ) ) {
			return $this->mWatchedItems[$key];
		}

		if ( count( $this->mWatchedItems ) >= self::MAX_WATCHED_ITEMS_CACHE ) {
			$this->mWatchedItems = array();
		}

		$this->mWatchedItems[$key] = WatchedItem::fromwiki_userTitle( $this, $title );
		return $this->mWatchedItems[$key];
	}

	/**
	 * Check the watched status of an article.
	 * @param $title Title of the article to look at
	 * @return Bool
	 */
	public function isWatched( $title ) {
		return $this->getWatchedItem( $title )->isWatched();
	}

	/**
	 * Watch an article.
	 * @param $title Title of the article to look at
	 */
	public function addWatch( $title ) {
		$this->getWatchedItem( $title )->addWatch();
		$this->invalidateCache();
	}

	/**
	 * Stop watching an article.
	 * @param $title Title of the article to look at
	 */
	public function removeWatch( $title ) {
		$this->getWatchedItem( $title )->removeWatch();
		$this->invalidateCache();
	}

	/**
	 * Clear the wiki_user's notification timestamp for the given title.
	 * If e-notif e-mails are on, they will receive notification mails on
	 * the next change of the page if it's watched etc.
	 * @param $title Title of the article to look at
	 */
	public function clearNotification( &$title ) {
		global $wgUseEnotif, $wgShowUpdatedMarker;

		# Do nothing if the database is locked to writes
		if( wfReadOnly() ) {
			return;
		}

		if( $title->getNamespace() == NS_USER_TALK &&
			$title->getText() == $this->getName() ) {
			if( !wfRunHooks( 'wiki_userClearNewTalkNotification', array( &$this ) ) )
				return;
			$this->setNewtalk( false );
		}

		if( !$wgUseEnotif && !$wgShowUpdatedMarker ) {
			return;
		}

		if( $this->isAnon() ) {
			// Nothing else to do...
			return;
		}

		// Only update the timestamp if the page is being watched.
		// The query to find out if it is watched is cached both in memcached and per-invocation,
		// and when it does have to be executed, it can be on a slave
		// If this is the wiki_user's newtalk page, we always update the timestamp
		$force = '';
		if ( $title->getNamespace() == NS_USER_TALK &&
			$title->getText() == $this->getName() )
		{
			$force = 'force';
		}

		$this->getWatchedItem( $title )->resetNotificationTimestamp( $force );
	}

	/**
	 * Resets all of the given wiki_user's page-change notification timestamps.
	 * If e-notif e-mails are on, they will receive notification mails on
	 * the next change of any watched page.
	 */
	public function clearAllNotifications() {
		global $wgUseEnotif, $wgShowUpdatedMarker;
		if ( !$wgUseEnotif && !$wgShowUpdatedMarker ) {
			$this->setNewtalk( false );
			return;
		}
		$id = $this->getId();
		if( $id != 0 )  {
			w = wfGetDB( DB_MASTER );
			w->update( 'watchlist',
				array( /* SET */
					'wl_notificationtimestamp' => null
				), array( /* WHERE */
					'wl_wiki_user' => $id
				), __METHOD__
			);
		# 	We also need to clear here the "you have new message" notification for the own wiki_user_talk page
		#	This is cleared one page view later in Article::viewUpdates();
		}
	}

	/**
	 * Set this wiki_user's options from an encoded string
	 * @param $str String Encoded options to import
	 *
	 * @deprecated in 1.19 due to removal of wiki_user_options from the wiki_user table
	 */
	private function decodeOptions( $str ) {
		wfDeprecated( __METHOD__, '1.19' );
		if( !$str )
			return;

		$this->mOptionsLoaded = true;
		$this->mOptionOverrides = array();

		// If an option is not set in $str, use the default value
		$this->mOptions = self::getDefaultOptions();

		$a = explode( "\n", $str );
		foreach ( $a as $s ) {
			$m = array();
			if ( preg_match( "/^(.[^=]*)=(.*)$/", $s, $m ) ) {
				$this->mOptions[$m[1]] = $m[2];
				$this->mOptionOverrides[$m[1]] = $m[2];
			}
		}
	}

	/**
	 * Set a cookie on the wiki_user's client. Wrapper for
	 * WebResponse::setCookie
	 * @param $name String Name of the cookie to set
	 * @param $value String Value to set
	 * @param $exp Int Expiration time, as a UNIX time value;
	 *                   if 0 or not specified, use the default $wgCookieExpiration
	 */
	protected function setCookie( $name, $value, $exp = 0 ) {
		$this->getRequest()->response()->setcookie( $name, $value, $exp );
	}

	/**
	 * Clear a cookie on the wiki_user's client
	 * @param $name String Name of the cookie to clear
	 */
	protected function clearCookie( $name ) {
		$this->setCookie( $name, '', time() - 86400 );
	}

	/**
	 * Set the default cookies for this session on the wiki_user's client.
	 *
	 * @param $request WebRequest object to use; $wgRequest will be used if null
	 *        is passed.
	 */
	public function setCookies( $request = null ) {
		if ( $request === null ) {
			$request = $this->getRequest();
		}

		$this->load();
		if ( 0 == $this->mId ) return;
		if ( !$this->mToken ) {
			// When token is empty or NULL generate a new one and then save it to the database
			// This allows a wiki to re-secure itself after a leak of it's wiki_user table or $wgSecretKey
			// Simply by setting every cell in the wiki_user_token column to NULL and letting them be
			// regenerated as wiki_users log back into the wiki.
			$this->setToken();
			$this->saveSettings();
		}
		$session = array(
			'wswiki_userID' => $this->mId,
			'wsToken' => $this->mToken,
			'wswiki_userName' => $this->getName()
		);
		$cookies = array(
			'wiki_userID' => $this->mId,
			'wiki_userName' => $this->getName(),
		);
		if ( 1 == $this->getOption( 'rememberpassword' ) ) {
			$cookies['Token'] = $this->mToken;
		} else {
			$cookies['Token'] = false;
		}

		wfRunHooks( 'wiki_userSetCookies', array( $this, &$session, &$cookies ) );

		foreach ( $session as $name => $value ) {
			$request->setSessionData( $name, $value );
		}
		foreach ( $cookies as $name => $value ) {
			if ( $value === false ) {
				$this->clearCookie( $name );
			} else {
				$this->setCookie( $name, $value );
			}
		}
	}

	/**
	 * Log this wiki_user out.
	 */
	public function logout() {
		if( wfRunHooks( 'wiki_userLogout', array( &$this ) ) ) {
			$this->doLogout();
		}
	}

	/**
	 * Clear the wiki_user's cookies and session, and reset the instance cache.
	 * @see logout()
	 */
	public function doLogout() {
		$this->clearInstanceCache( 'defaults' );

		$this->getRequest()->setSessionData( 'wswiki_userID', 0 );

		$this->clearCookie( 'wiki_userID' );
		$this->clearCookie( 'Token' );

		# Remember when wiki_user logged out, to prevent seeing cached pages
		$this->setCookie( 'LoggedOut', wfTimestampNow(), time() + 86400 );
	}

	/**
	 * Save this wiki_user's settings into the database.
	 * @todo Only rarely do all these fields need to be set!
	 */
	public function saveSettings() {
		global $wgAuth;

		$this->load();
		if ( wfReadOnly() ) { return; }
		if ( 0 == $this->mId ) { return; }

		$this->mTouched = self::newTouchedTimestamp();
		if ( !$wgAuth->allowSetLocalPassword() ) {
			$this->mPassword = '';
		}

		w = wfGetDB( DB_MASTER );
		w->update( 'wiki_user',
			array( /* SET */
				'wiki_user_name' => $this->mName,
				'wiki_user_password' => $this->mPassword,
				'wiki_user_newpassword' => $this->mNewpassword,
				'wiki_user_newpass_time' => w->timestampOrNull( $this->mNewpassTime ),
				'wiki_user_real_name' => $this->mRealName,
				'wiki_user_email' => $this->mEmail,
				'wiki_user_email_authenticated' => w->timestampOrNull( $this->mEmailAuthenticated ),
				'wiki_user_touched' => w->timestamp( $this->mTouched ),
				'wiki_user_token' => strval( $this->mToken ),
				'wiki_user_email_token' => $this->mEmailToken,
				'wiki_user_email_token_expires' => w->timestampOrNull( $this->mEmailTokenExpires ),
			), array( /* WHERE */
				'wiki_user_id' => $this->mId
			), __METHOD__
		);

		$this->saveOptions();

		wfRunHooks( 'wiki_userSaveSettings', array( $this ) );
		$this->clearSharedCache();
		$this->getwiki_userPage()->invalidateCache();
	}

	/**
	 * If only this wiki_user's wiki_username is known, and it exists, return the wiki_user ID.
	 * @return Int
	 */
	public function idForName() {
		$s = trim( $this->getName() );
		if ( $s === '' ) return 0;

		r = wfGetDB( DB_SLAVE );
		$id = r->selectField( 'wiki_user', 'wiki_user_id', array( 'wiki_user_name' => $s ), __METHOD__ );
		if ( $id === false ) {
			$id = 0;
		}
		return $id;
	}

	/**
	 * Add a wiki_user to the database, return the wiki_user object
	 *
	 * @param $name String wiki_username to add
	 * @param $params Array of Strings Non-default parameters to save to the database as wiki_user_* fields:
	 *   - password             The wiki_user's password hash. Password logins will be disabled if this is omitted.
	 *   - newpassword          Hash for a temporary password that has been mailed to the wiki_user
	 *   - email                The wiki_user's email address
	 *   - email_authenticated  The email authentication timestamp
	 *   - real_name            The wiki_user's real name
	 *   - options              An associative array of non-default options
	 *   - token                Random authentication token. Do not set.
	 *   - registration         Registration timestamp. Do not set.
	 *
	 * @return wiki_user object, or null if the wiki_username already exists
	 */
	public static function createNew( $name, $params = array() ) {
		$wiki_user = new wiki_user;
		$wiki_user->load();
		if ( isset( $params['options'] ) ) {
			$wiki_user->mOptions = $params['options'] + (array)$wiki_user->mOptions;
			unset( $params['options'] );
		}
		w = wfGetDB( DB_MASTER );
		$seqVal = w->nextSequenceValue( 'wiki_user_wiki_user_id_seq' );

		$fields = array(
			'wiki_user_id' => $seqVal,
			'wiki_user_name' => $name,
			'wiki_user_password' => $wiki_user->mPassword,
			'wiki_user_newpassword' => $wiki_user->mNewpassword,
			'wiki_user_newpass_time' => w->timestampOrNull( $wiki_user->mNewpassTime ),
			'wiki_user_email' => $wiki_user->mEmail,
			'wiki_user_email_authenticated' => w->timestampOrNull( $wiki_user->mEmailAuthenticated ),
			'wiki_user_real_name' => $wiki_user->mRealName,
			'wiki_user_token' => strval( $wiki_user->mToken ),
			'wiki_user_registration' => w->timestamp( $wiki_user->mRegistration ),
			'wiki_user_editcount' => 0,
			'wiki_user_touched' => w->timestamp( self::newTouchedTimestamp() ),
		);
		foreach ( $params as $name => $value ) {
			$fields["wiki_user_$name"] = $value;
		}
		w->insert( 'wiki_user', $fields, __METHOD__, array( 'IGNORE' ) );
		if ( w->affectedRows() ) {
			$newwiki_user = wiki_user::newFromId( w->insertId() );
		} else {
			$newwiki_user = null;
		}
		return $newwiki_user;
	}

	/**
	 * Add this existing wiki_user object to the database
	 */
	public function addToDatabase() {
		$this->load();

		$this->mTouched = self::newTouchedTimestamp();

		w = wfGetDB( DB_MASTER );
		$seqVal = w->nextSequenceValue( 'wiki_user_wiki_user_id_seq' );
		w->insert( 'wiki_user',
			array(
				'wiki_user_id' => $seqVal,
				'wiki_user_name' => $this->mName,
				'wiki_user_password' => $this->mPassword,
				'wiki_user_newpassword' => $this->mNewpassword,
				'wiki_user_newpass_time' => w->timestampOrNull( $this->mNewpassTime ),
				'wiki_user_email' => $this->mEmail,
				'wiki_user_email_authenticated' => w->timestampOrNull( $this->mEmailAuthenticated ),
				'wiki_user_real_name' => $this->mRealName,
				'wiki_user_token' => strval( $this->mToken ),
				'wiki_user_registration' => w->timestamp( $this->mRegistration ),
				'wiki_user_editcount' => 0,
				'wiki_user_touched' => w->timestamp( $this->mTouched ),
			), __METHOD__
		);
		$this->mId = w->insertId();

		// Clear instance cache other than wiki_user table data, which is already accurate
		$this->clearInstanceCache();

		$this->saveOptions();
	}

	/**
	 * If this wiki_user is logged-in and blocked,
	 * block any IP address they've successfully logged in from.
	 * @return bool A block was spread
	 */
	public function spreadAnyEditBlock() {
		if ( $this->isLoggedIn() && $this->isBlocked() ) {
			return $this->spreadBlock();
		}
		return false;
	}

	/**
	 * If this (non-anonymous) wiki_user is blocked,
	 * block the IP address they've successfully logged in from.
	 * @return bool A block was spread
	 */
	protected function spreadBlock() {
		wfDebug( __METHOD__ . "()\n" );
		$this->load();
		if ( $this->mId == 0 ) {
			return false;
		}

		$wiki_userblock = Block::newFromTarget( $this->getName() );
		if ( !$wiki_userblock ) {
			return false;
		}

		return (bool)$wiki_userblock->doAutoblock( $this->getRequest()->getIP() );
	}

	/**
	 * Generate a string which will be different for any combination of
	 * wiki_user options which would produce different parser output.
	 * This will be used as part of the hash key for the parser cache,
	 * so wiki_users with the same options can share the same cached data
	 * safely.
	 *
	 * Extensions which require it should install 'PageRenderingHash' hook,
	 * which will give them a chance to modify this key based on their own
	 * settings.
	 *
	 * @deprecated since 1.17 use the ParserOptions object to get the relevant options
	 * @return String Page rendering hash
	 */
	public function getPageRenderingHash() {
		wfDeprecated( __METHOD__, '1.17' );

		global $wgUseDynamicDates, $wgRenderHashAppend, $wgLang, $wgContLang;
		if( $this->mHash ){
			return $this->mHash;
		}

		// stubthreshold is only included below for completeness,
		// since it disables the parser cache, its value will always
		// be 0 when this function is called by parsercache.

		$confstr =        $this->getOption( 'math' );
		$confstr .= '!' . $this->getStubThreshold();
		if ( $wgUseDynamicDates ) { # This is wrong (bug 24714)
			$confstr .= '!' . $this->getDatePreference();
		}
		$confstr .= '!' . ( $this->getOption( 'numberheadings' ) ? '1' : '' );
		$confstr .= '!' . $wgLang->getCode();
		$confstr .= '!' . $this->getOption( 'thumbsize' );
		// add in language specific options, if any
		$extra = $wgContLang->getExtraHashOptions();
		$confstr .= $extra;

		// Since the skin could be overloading link(), it should be
		// included here but in practice, none of our skins do that.

		$confstr .= $wgRenderHashAppend;

		// Give a chance for extensions to modify the hash, if they have
		// extra options or other effects on the parser cache.
		wfRunHooks( 'PageRenderingHash', array( &$confstr ) );

		// Make it a valid memcached key fragment
		$confstr = str_replace( ' ', '_', $confstr );
		$this->mHash = $confstr;
		return $confstr;
	}

	/**
	 * Get whether the wiki_user is explicitly blocked from account creation.
	 * @return Bool|Block
	 */
	public function isBlockedFromCreateAccount() {
		$this->getBlockedStatus();
		if( $this->mBlock && $this->mBlock->prevents( 'createaccount' ) ){
			return $this->mBlock;
		}

		# bug 13611: if the IP address the wiki_user is trying to create an account from is
		# blocked with createaccount disabled, prevent new account creation there even
		# when the wiki_user is logged in
		if( $this->mBlockedFromCreateAccount === false ){
			$this->mBlockedFromCreateAccount = Block::newFromTarget( null, $this->getRequest()->getIP() );
		}
		return $this->mBlockedFromCreateAccount instanceof Block && $this->mBlockedFromCreateAccount->prevents( 'createaccount' )
			? $this->mBlockedFromCreateAccount
			: false;
	}

	/**
	 * Get whether the wiki_user is blocked from using Special:Emailwiki_user.
	 * @return Bool
	 */
	public function isBlockedFromEmailwiki_user() {
		$this->getBlockedStatus();
		return $this->mBlock && $this->mBlock->prevents( 'sendemail' );
	}

	/**
	 * Get whether the wiki_user is allowed to create an account.
	 * @return Bool
	 */
	function isAllowedToCreateAccount() {
		return $this->isAllowed( 'createaccount' ) && !$this->isBlockedFromCreateAccount();
	}

	/**
	 * Get this wiki_user's personal page title.
	 *
	 * @return Title: wiki_user's personal page title
	 */
	public function getwiki_userPage() {
		return Title::makeTitle( NS_USER, $this->getName() );
	}

	/**
	 * Get this wiki_user's talk page title.
	 *
	 * @return Title: wiki_user's talk page title
	 */
	public function getTalkPage() {
		$title = $this->getwiki_userPage();
		return $title->getTalkPage();
	}

	/**
	 * Determine whether the wiki_user is a newbie. Newbies are either
	 * anonymous IPs, or the most recently created accounts.
	 * @return Bool
	 */
	public function isNewbie() {
		return !$this->isAllowed( 'autoconfirmed' );
	}

	/**
	 * Check to see if the given clear-text password is one of the accepted passwords
	 * @param $password String: wiki_user password.
	 * @return Boolean: True if the given password is correct, otherwise False.
	 */
	public function checkPassword( $password ) {
		global $wgAuth, $wgLegacyEncoding;
		$this->load();

		// Even though we stop people from creating passwords that
		// are shorter than this, doesn't mean people wont be able
		// to. Certain authentication plugins do NOT want to save
		// domain passwords in a mysql database, so we should
		// check this (in case $wgAuth->strict() is false).
		if( !$this->isValidPassword( $password ) ) {
			return false;
		}

		if( $wgAuth->authenticate( $this->getName(), $password ) ) {
			return true;
		} elseif( $wgAuth->strict() ) {
			/* Auth plugin doesn't allow local authentication */
			return false;
		} elseif( $wgAuth->strictwiki_userAuth( $this->getName() ) ) {
			/* Auth plugin doesn't allow local authentication for this wiki_user name */
			return false;
		}
		if ( self::comparePasswords( $this->mPassword, $password, $this->mId ) ) {
			return true;
		} elseif ( $wgLegacyEncoding ) {
			# Some wikis were converted from ISO 8859-1 to UTF-8, the passwords can't be converted
			# Check for this with iconv
			$cp1252Password = iconv( 'UTF-8', 'WINDOWS-1252//TRANSLIT', $password );
			if ( $cp1252Password != $password &&
				self::comparePasswords( $this->mPassword, $cp1252Password, $this->mId ) )
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Check if the given clear-text password matches the temporary password
	 * sent by e-mail for password reset operations.
	 *
	 * @param $plaintext string
	 *
	 * @return Boolean: True if matches, false otherwise
	 */
	public function checkTemporaryPassword( $plaintext ) {
		global $wgNewPasswordExpiry;

		$this->load();
		if( self::comparePasswords( $this->mNewpassword, $plaintext, $this->getId() ) ) {
			if ( is_null( $this->mNewpassTime ) ) {
				return true;
			}
			$expiry = wfTimestamp( TS_UNIX, $this->mNewpassTime ) + $wgNewPasswordExpiry;
			return ( time() < $expiry );
		} else {
			return false;
		}
	}

	/**
	 * Alias for getEditToken.
	 * @deprecated since 1.19, use getEditToken instead.
	 *
	 * @param $salt String|Array of Strings Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return String The new edit token
	 */
	public function editToken( $salt = '', $request = null ) {
		wfDeprecated( __METHOD__, '1.19' );
		return $this->getEditToken( $salt, $request );
	}

	/**
	 * Initialize (if necessary) and return a session token value
	 * which can be used in edit forms to show that the wiki_user's
	 * login credentials aren't being hijacked with a foreign form
	 * submission.
	 *
	 * @since 1.19
	 *
	 * @param $salt String|Array of Strings Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return String The new edit token
	 */
	public function getEditToken( $salt = '', $request = null ) {
		if ( $request == null ) {
			$request = $this->getRequest();
		}

		if ( $this->isAnon() ) {
			return EDIT_TOKEN_SUFFIX;
		} else {
			$token = $request->getSessionData( 'wsEditToken' );
			if ( $token === null ) {
				$token = MWCryptRand::generateHex( 32 );
				$request->setSessionData( 'wsEditToken', $token );
			}
			if( is_array( $salt ) ) {
				$salt = implode( '|', $salt );
			}
			return md5( $token . $salt ) . EDIT_TOKEN_SUFFIX;
		}
	}

	/**
	 * Generate a looking random token for various uses.
	 *
	 * @param $salt String Optional salt value
	 * @return String The new random token
	 * @deprecated since 1.20; Use MWCryptRand for secure purposes or wfRandomString for pesudo-randomness
	 */
	public static function generateToken( $salt = '' ) {
		return MWCryptRand::generateHex( 32 );
	}

	/**
	 * Check given value against the token value stored in the session.
	 * A match should confirm that the form was submitted from the
	 * wiki_user's own login session, not a form submission from a third-party
	 * site.
	 *
	 * @param $val String Input value to compare
	 * @param $salt String Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return Boolean: Whether the token matches
	 */
	public function matchEditToken( $val, $salt = '', $request = null ) {
		$sessionToken = $this->getEditToken( $salt, $request );
		if ( $val != $sessionToken ) {
			wfDebug( "wiki_user::matchEditToken: broken session data\n" );
		}
		return $val == $sessionToken;
	}

	/**
	 * Check given value against the token value stored in the session,
	 * ignoring the suffix.
	 *
	 * @param $val String Input value to compare
	 * @param $salt String Optional function-specific data for hashing
	 * @param $request WebRequest object to use or null to use $wgRequest
	 * @return Boolean: Whether the token matches
	 */
	public function matchEditTokenNoSuffix( $val, $salt = '', $request = null ) {
		$sessionToken = $this->getEditToken( $salt, $request );
		return substr( $sessionToken, 0, 32 ) == substr( $val, 0, 32 );
	}

	/**
	 * Generate a new e-mail confirmation token and send a confirmation/invalidation
	 * mail to the wiki_user's given address.
	 *
	 * @param $type String: message to send, either "created", "changed" or "set"
	 * @return Status object
	 */
	public function sendConfirmationMail( $type = 'created' ) {
		global $wgLang;
		$expiration = null; // gets passed-by-ref and defined in next line.
		$token = $this->confirmationToken( $expiration );
		$url = $this->confirmationTokenUrl( $token );
		$invalidateURL = $this->invalidationTokenUrl( $token );
		$this->saveSettings();

		if ( $type == 'created' || $type === false ) {
			$message = 'confirmemail_body';
		} elseif ( $type === true ) {
			$message = 'confirmemail_body_changed';
		} else {
			$message = 'confirmemail_body_' . $type;
		}

		return $this->sendMail( wfMessage( 'confirmemail_subject' )->text(),
			wfMessage( $message,
				$this->getRequest()->getIP(),
				$this->getName(),
				$url,
				$wgLang->timeanddate( $expiration, false ),
				$invalidateURL,
				$wgLang->date( $expiration, false ),
				$wgLang->time( $expiration, false ) )->text() );
	}

	/**
	 * Send an e-mail to this wiki_user's account. Does not check for
	 * confirmed status or validity.
	 *
	 * @param $subject String Message subject
	 * @param $body String Message body
	 * @param $from String Optional From address; if unspecified, default $wgPasswordSender will be used
	 * @param $replyto String Reply-To address
	 * @return Status
	 */
	public function sendMail( $subject, $body, $from = null, $replyto = null ) {
		if( is_null( $from ) ) {
			global $wgPasswordSender, $wgPasswordSenderName;
			$sender = new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
		} else {
			$sender = new MailAddress( $from );
		}

		$to = new MailAddress( $this );
		return wiki_userMailer::send( $to, $sender, $subject, $body, $replyto );
	}

	/**
	 * Generate, store, and return a new e-mail confirmation code.
	 * A hash (unsalted, since it's used as a key) is stored.
	 *
	 * @note Call saveSettings() after calling this function to commit
	 * this change to the database.
	 *
	 * @param &$expiration \mixed Accepts the expiration time
	 * @return String New token
	 */
	private function confirmationToken( &$expiration ) {
		global $wgwiki_userEmailConfirmationTokenExpiry;
		$now = time();
		$expires = $now + $wgwiki_userEmailConfirmationTokenExpiry;
		$expiration = wfTimestamp( TS_MW, $expires );
		$this->load();
		$token = MWCryptRand::generateHex( 32 );
		$hash = md5( $token );
		$this->mEmailToken = $hash;
		$this->mEmailTokenExpires = $expiration;
		return $token;
	}

	/**
	* Return a URL the wiki_user can use to confirm their email address.
	 * @param $token String Accepts the email confirmation token
	 * @return String New token URL
	 */
	private function confirmationTokenUrl( $token ) {
		return $this->getTokenUrl( 'ConfirmEmail', $token );
	}

	/**
	 * Return a URL the wiki_user can use to invalidate their email address.
	 * @param $token String Accepts the email confirmation token
	 * @return String New token URL
	 */
	private function invalidationTokenUrl( $token ) {
		return $this->getTokenUrl( 'InvalidateEmail', $token );
	}

	/**
	 * Internal function to format the e-mail validation/invalidation URLs.
	 * This uses a quickie hack to use the
	 * hardcoded English names of the Special: pages, for ASCII safety.
	 *
	 * @note Since these URLs get dropped directly into emails, using the
	 * short English names avoids insanely long URL-encoded links, which
	 * also sometimes can get corrupted in some browsers/mailers
	 * (bug 6957 with Gmail and Internet Explorer).
	 *
	 * @param $page String Special page
	 * @param $token String Token
	 * @return String Formatted URL
	 */
	protected function getTokenUrl( $page, $token ) {
		// Hack to bypass localization of 'Special:'
		if ( defined( 'HACL_HALOACL_VERSION' ) ) {
			$hacl = haclfDisableTitlePatch();
		}
		$title = Title::makeTitle( NS_MAIN, "Special:$page/$token" );
		if ( defined( 'HACL_HALOACL_VERSION' ) ) {
			haclfRestoreTitlePatch($hacl);
		}
		return $title->getCanonicalUrl();
	}

	/**
	 * Mark the e-mail address confirmed.
	 *
	 * @note Call saveSettings() after calling this function to commit the change.
	 *
	 * @return bool
	 */
	public function confirmEmail() {
		$this->setEmailAuthenticationTimestamp( wfTimestampNow() );
		wfRunHooks( 'ConfirmEmailComplete', array( $this ) );
		return true;
	}

	/**
	 * Invalidate the wiki_user's e-mail confirmation, and unauthenticate the e-mail
	 * address if it was already confirmed.
	 *
	 * @note Call saveSettings() after calling this function to commit the change.
	 * @return bool Returns true
	 */
	function invalidateEmail() {
		$this->load();
		$this->mEmailToken = null;
		$this->mEmailTokenExpires = null;
		$this->setEmailAuthenticationTimestamp( null );
		wfRunHooks( 'InvalidateEmailComplete', array( $this ) );
		return true;
	}

	/**
	 * Set the e-mail authentication timestamp.
	 * @param $timestamp String TS_MW timestamp
	 */
	function setEmailAuthenticationTimestamp( $timestamp ) {
		$this->load();
		$this->mEmailAuthenticated = $timestamp;
		wfRunHooks( 'wiki_userSetEmailAuthenticationTimestamp', array( $this, &$this->mEmailAuthenticated ) );
	}

	/**
	 * Is this wiki_user allowed to send e-mails within limits of current
	 * site configuration?
	 * @return Bool
	 */
	public function canSendEmail() {
		global $wgEnableEmail, $wgEnablewiki_userEmail;
		if( !$wgEnableEmail || !$wgEnablewiki_userEmail || !$this->isAllowed( 'sendemail' ) ) {
			return false;
		}
		$canSend = $this->isEmailConfirmed();
		wfRunHooks( 'wiki_userCanSendEmail', array( &$this, &$canSend ) );
		return $canSend;
	}

	/**
	 * Is this wiki_user allowed to receive e-mails within limits of current
	 * site configuration?
	 * @return Bool
	 */
	public function canReceiveEmail() {
		return $this->isEmailConfirmed() && !$this->getOption( 'disablemail' );
	}

	/**
	 * Is this wiki_user's e-mail address valid-looking and confirmed within
	 * limits of the current site configuration?
	 *
	 * @note If $wgEmailAuthentication is on, this may require the wiki_user to have
	 * confirmed their address by returning a code or using a password
	 * sent to the address from the wiki.
	 *
	 * @return Bool
	 */
	public function isEmailConfirmed() {
		global $wgEmailAuthentication;
		$this->load();
		$confirmed = true;
		if( wfRunHooks( 'EmailConfirmed', array( &$this, &$confirmed ) ) ) {
			if( $this->isAnon() ) {
				return false;
			}
			if( !Sanitizer::validateEmail( $this->mEmail ) ) {
				return false;
			}
			if( $wgEmailAuthentication && !$this->getEmailAuthenticationTimestamp() ) {
				return false;
			}
			return true;
		} else {
			return $confirmed;
		}
	}

	/**
	 * Check whether there is an outstanding request for e-mail confirmation.
	 * @return Bool
	 */
	public function isEmailConfirmationPending() {
		global $wgEmailAuthentication;
		return $wgEmailAuthentication &&
			!$this->isEmailConfirmed() &&
			$this->mEmailToken &&
			$this->mEmailTokenExpires > wfTimestamp();
	}

	/**
	 * Get the timestamp of account creation.
	 *
	 * @return String|Bool Timestamp of account creation, or false for
	 *     non-existent/anonymous wiki_user accounts.
	 */
	public function getRegistration() {
		if ( $this->isAnon() ) {
			return false;
		}
		$this->load();
		return $this->mRegistration;
	}

	/**
	 * Get the timestamp of the first edit
	 *
	 * @return String|Bool Timestamp of first edit, or false for
	 *     non-existent/anonymous wiki_user accounts.
	 */
	public function getFirstEditTimestamp() {
		if( $this->getId() == 0 ) {
			return false; // anons
		}
		r = wfGetDB( DB_SLAVE );
		$time = r->selectField( 'revision', 'rev_timestamp',
			array( 'rev_wiki_user' => $this->getId() ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp ASC' )
		);
		if( !$time ) {
			return false; // no edits
		}
		return wfTimestamp( TS_MW, $time );
	}

	/**
	 * Get the permissions associated with a given list of groups
	 *
	 * @param $groups Array of Strings List of internal group names
	 * @return Array of Strings List of permission key names for given groups combined
	 */
	public static function getGroupPermissions( $groups ) {
		global $wgGroupPermissions, $wgRevokePermissions;
		$rights = array();
		// grant every granted permission first
		foreach( $groups as $group ) {
			if( isset( $wgGroupPermissions[$group] ) ) {
				$rights = array_merge( $rights,
					// array_filter removes empty items
					array_keys( array_filter( $wgGroupPermissions[$group] ) ) );
			}
		}
		// now revoke the revoked permissions
		foreach( $groups as $group ) {
			if( isset( $wgRevokePermissions[$group] ) ) {
				$rights = array_diff( $rights,
					array_keys( array_filter( $wgRevokePermissions[$group] ) ) );
			}
		}
		return array_unique( $rights );
	}

	/**
	 * Get all the groups who have a given permission
	 *
	 * @param $role String Role to check
	 * @return Array of Strings List of internal group names with the given permission
	 */
	public static function getGroupsWithPermission( $role ) {
		global $wgGroupPermissions;
		$allowedGroups = array();
		foreach ( $wgGroupPermissions as $group => $rights ) {
			if ( isset( $rights[$role] ) && $rights[$role] ) {
				$allowedGroups[] = $group;
			}
		}
		return $allowedGroups;
	}

	/**
	 * Get the localized descriptive name for a group, if it exists
	 *
	 * @param $group String Internal group name
	 * @return String Localized descriptive group name
	 */
	public static function getGroupName( $group ) {
		$msg = wfMessage( "group-$group" );
		return $msg->isBlank() ? $group : $msg->text();
	}

	/**
	 * Get the localized descriptive name for a member of a group, if it exists
	 *
	 * @param $group String Internal group name
	 * @param $wiki_username String wiki_username for gender (since 1.19)
	 * @return String Localized name for group member
	 */
	public static function getGroupMember( $group, $wiki_username = '#' ) {
		$msg = wfMessage( "group-$group-member", $wiki_username );
		return $msg->isBlank() ? $group : $msg->text();
	}

	/**
	 * Return the set of defined explicit groups.
	 * The implicit groups (by default *, 'wiki_user' and 'autoconfirmed')
	 * are not included, as they are defined automatically, not in the database.
	 * @return Array of internal group names
	 */
	public static function getAllGroups() {
		global $wgGroupPermissions, $wgRevokePermissions;
		return array_diff(
			array_merge( array_keys( $wgGroupPermissions ), array_keys( $wgRevokePermissions ) ),
			self::getImplicitGroups()
		);
	}

	/**
	 * Get a list of all available permissions.
	 * @return Array of permission names
	 */
	public static function getAllRights() {
		if ( self::$mAllRights === false ) {
			global $wgAvailableRights;
			if ( count( $wgAvailableRights ) ) {
				self::$mAllRights = array_unique( array_merge( self::$mCoreRights, $wgAvailableRights ) );
			} else {
				self::$mAllRights = self::$mCoreRights;
			}
			wfRunHooks( 'wiki_userGetAllRights', array( &self::$mAllRights ) );
		}
		return self::$mAllRights;
	}

	/**
	 * Get a list of implicit groups
	 * @return Array of Strings Array of internal group names
	 */
	public static function getImplicitGroups() {
		global $wgImplicitGroups;
		$groups = $wgImplicitGroups;
		wfRunHooks( 'wiki_userGetImplicitGroups', array( &$groups ) );	#deprecated, use $wgImplictGroups instead
		return $groups;
	}

	/**
	 * Get the title of a page describing a particular group
	 *
	 * @param $group String Internal group name
	 * @return Title|Bool Title of the page if it exists, false otherwise
	 */
	public static function getGroupPage( $group ) {
		$msg = wfMessage( 'grouppage-' . $group )->inContentLanguage();
		if( $msg->exists() ) {
			$title = Title::newFromText( $msg->text() );
			if( is_object( $title ) )
				return $title;
		}
		return false;
	}

	/**
	 * Create a link to the group in HTML, if available;
	 * else return the group name.
	 *
	 * @param $group String Internal name of the group
	 * @param $text String The text of the link
	 * @return String HTML link to the group
	 */
	public static function makeGroupLinkHTML( $group, $text = '' ) {
		if( $text == '' ) {
			$text = self::getGroupName( $group );
		}
		$title = self::getGroupPage( $group );
		if( $title ) {
			return Linker::link( $title, htmlspecialchars( $text ) );
		} else {
			return $text;
		}
	}

	/**
	 * Create a link to the group in Wikitext, if available;
	 * else return the group name.
	 *
	 * @param $group String Internal name of the group
	 * @param $text String The text of the link
	 * @return String Wikilink to the group
	 */
	public static function makeGroupLinkWiki( $group, $text = '' ) {
		if( $text == '' ) {
			$text = self::getGroupName( $group );
		}
		$title = self::getGroupPage( $group );
		if( $title ) {
			$page = $title->getPrefixedText();
			return "[[$page|$text]]";
		} else {
			return $text;
		}
	}

	/**
	 * Returns an array of the groups that a particular group can add/remove.
	 *
	 * @param $group String: the group to check for whether it can add/remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *     'remove' => array( removablegroups ),
	 *     'add-self' => array( addablegroups to self),
	 *     'remove-self' => array( removable groups from self) )
	 */
	public static function changeableByGroup( $group ) {
		global $wgAddGroups, $wgRemoveGroups, $wgGroupsAddToSelf, $wgGroupsRemoveFromSelf;

		$groups = array( 'add' => array(), 'remove' => array(), 'add-self' => array(), 'remove-self' => array() );
		if( empty( $wgAddGroups[$group] ) ) {
			// Don't add anything to $groups
		} elseif( $wgAddGroups[$group] === true ) {
			// You get everything
			$groups['add'] = self::getAllGroups();
		} elseif( is_array( $wgAddGroups[$group] ) ) {
			$groups['add'] = $wgAddGroups[$group];
		}

		// Same thing for remove
		if( empty( $wgRemoveGroups[$group] ) ) {
		} elseif( $wgRemoveGroups[$group] === true ) {
			$groups['remove'] = self::getAllGroups();
		} elseif( is_array( $wgRemoveGroups[$group] ) ) {
			$groups['remove'] = $wgRemoveGroups[$group];
		}

		// Re-map numeric keys of AddToSelf/RemoveFromSelf to the 'wiki_user' key for backwards compatibility
		if( empty( $wgGroupsAddToSelf['wiki_user']) || $wgGroupsAddToSelf['wiki_user'] !== true ) {
			foreach( $wgGroupsAddToSelf as $key => $value ) {
				if( is_int( $key ) ) {
					$wgGroupsAddToSelf['wiki_user'][] = $value;
				}
			}
		}

		if( empty( $wgGroupsRemoveFromSelf['wiki_user']) || $wgGroupsRemoveFromSelf['wiki_user'] !== true ) {
			foreach( $wgGroupsRemoveFromSelf as $key => $value ) {
				if( is_int( $key ) ) {
					$wgGroupsRemoveFromSelf['wiki_user'][] = $value;
				}
			}
		}

		// Now figure out what groups the wiki_user can add to him/herself
		if( empty( $wgGroupsAddToSelf[$group] ) ) {
		} elseif( $wgGroupsAddToSelf[$group] === true ) {
			// No idea WHY this would be used, but it's there
			$groups['add-self'] = wiki_user::getAllGroups();
		} elseif( is_array( $wgGroupsAddToSelf[$group] ) ) {
			$groups['add-self'] = $wgGroupsAddToSelf[$group];
		}

		if( empty( $wgGroupsRemoveFromSelf[$group] ) ) {
		} elseif( $wgGroupsRemoveFromSelf[$group] === true ) {
			$groups['remove-self'] = wiki_user::getAllGroups();
		} elseif( is_array( $wgGroupsRemoveFromSelf[$group] ) ) {
			$groups['remove-self'] = $wgGroupsRemoveFromSelf[$group];
		}

		return $groups;
	}

	/**
	 * Returns an array of groups that this wiki_user can add and remove
	 * @return Array array( 'add' => array( addablegroups ),
	 *  'remove' => array( removablegroups ),
	 *  'add-self' => array( addablegroups to self),
	 *  'remove-self' => array( removable groups from self) )
	 */
	public function changeableGroups() {
		if( $this->isAllowed( 'wiki_userrights' ) ) {
			// This group gives the right to modify everything (reverse-
			// compatibility with old "wiki_userrights lets you change
			// everything")
			// Using array_merge to make the groups reindexed
			$all = array_merge( wiki_user::getAllGroups() );
			return array(
				'add' => $all,
				'remove' => $all,
				'add-self' => array(),
				'remove-self' => array()
			);
		}

		// Okay, it's not so simple, we will have to go through the arrays
		$groups = array(
			'add' => array(),
			'remove' => array(),
			'add-self' => array(),
			'remove-self' => array()
		);
		$addergroups = $this->getEffectiveGroups();

		foreach( $addergroups as $addergroup ) {
			$groups = array_merge_recursive(
				$groups, $this->changeableByGroup( $addergroup )
			);
			$groups['add']    = array_unique( $groups['add'] );
			$groups['remove'] = array_unique( $groups['remove'] );
			$groups['add-self'] = array_unique( $groups['add-self'] );
			$groups['remove-self'] = array_unique( $groups['remove-self'] );
		}
		return $groups;
	}

	/**
	 * Increment the wiki_user's edit-count field.
	 * Will have no effect for anonymous wiki_users.
	 */
	public function incEditCount() {
		if( !$this->isAnon() ) {
			w = wfGetDB( DB_MASTER );
			w->update( 'wiki_user',
				array( 'wiki_user_editcount=wiki_user_editcount+1' ),
				array( 'wiki_user_id' => $this->getId() ),
				__METHOD__ );

			// Lazy initialization check...
			if( w->affectedRows() == 0 ) {
				// Pull from a slave to be less cruel to servers
				// Accuracy isn't the point anyway here
				r = wfGetDB( DB_SLAVE );
				$count = r->selectField( 'revision',
					'COUNT(rev_wiki_user)',
					array( 'rev_wiki_user' => $this->getId() ),
					__METHOD__ );

				// Now here's a goddamn hack...
				if( r !== w ) {
					// If we actually have a slave server, the count is
					// at least one behind because the current transaction
					// has not been committed and replicated.
					$count++;
				} else {
					// But if DB_SLAVE is selecting the master, then the
					// count we just read includes the revision that was
					// just added in the working transaction.
				}

				w->update( 'wiki_user',
					array( 'wiki_user_editcount' => $count ),
					array( 'wiki_user_id' => $this->getId() ),
					__METHOD__ );
			}
		}
		// edit count in wiki_user cache too
		$this->invalidateCache();
	}

	/**
	 * Get the description of a given right
	 *
	 * @param $right String Right to query
	 * @return String Localized description of the right
	 */
	public static function getRightDescription( $right ) {
		$key = "right-$right";
		$msg = wfMessage( $key );
		return $msg->isBlank() ? $right : $msg->text();
	}

	/**
	 * Make an old-style password hash
	 *
	 * @param $password String Plain-text password
	 * @param $wiki_userId String wiki_user ID
	 * @return String Password hash
	 */
	public static function oldCrypt( $password, $wiki_userId ) {
		global $wgPasswordSalt;
		if ( $wgPasswordSalt ) {
			return md5( $wiki_userId . '-' . md5( $password ) );
		} else {
			return md5( $password );
		}
	}

	/**
	 * Make a new-style password hash
	 *
	 * @param $password String Plain-text password
	 * @param bool|string $salt Optional salt, may be random or the wiki_user ID.

	 *                     If unspecified or false, will generate one automatically
	 * @return String Password hash
	 */
	public static function crypt( $password, $salt = false ) {
		global $wgPasswordSalt;

		$hash = '';
		if( !wfRunHooks( 'wiki_userCryptPassword', array( &$password, &$salt, &$wgPasswordSalt, &$hash ) ) ) {
			return $hash;
		}

		if( $wgPasswordSalt ) {
			if ( $salt === false ) {
				$salt = MWCryptRand::generateHex( 8 );
			}
			return ':B:' . $salt . ':' . md5( $salt . '-' . md5( $password ) );
		} else {
			return ':A:' . md5( $password );
		}
	}

	/**
	 * Compare a password hash with a plain-text password. Requires the wiki_user
	 * ID if there's a chance that the hash is an old-style hash.
	 *
	 * @param $hash String Password hash
	 * @param $password String Plain-text password to compare
	 * @param $wiki_userId String|bool wiki_user ID for old-style password salt
	 *
	 * @return Boolean
	 */
	public static function comparePasswords( $hash, $password, $wiki_userId = false ) {
		$type = substr( $hash, 0, 3 );

		$result = false;
		if( !wfRunHooks( 'wiki_userComparePasswords', array( &$hash, &$password, &$wiki_userId, &$result ) ) ) {
			return $result;
		}

		if ( $type == ':A:' ) {
			# Unsalted
			return md5( $password ) === substr( $hash, 3 );
		} elseif ( $type == ':B:' ) {
			# Salted
			list( $salt, $realHash ) = explode( ':', substr( $hash, 3 ), 2 );
			return md5( $salt.'-'.md5( $password ) ) === $realHash;
		} else {
			# Old-style
			return self::oldCrypt( $password, $wiki_userId ) === $hash;
		}
	}

	/**
	 * Add a newwiki_user log entry for this wiki_user. Before 1.19 the return value was always true.
	 *
	 * @param $byEmail Boolean: account made by email?
	 * @param $reason String: wiki_user supplied reason
	 *
	 * @return int|bool True if not $wgNewwiki_userLog; otherwise ID of log item or 0 on failure
	 */
	public function addNewwiki_userLogEntry( $byEmail = false, $reason = '' ) {
		global $wgwiki_user, $wgContLang, $wgNewwiki_userLog;
		if( empty( $wgNewwiki_userLog ) ) {
			return true; // disabled
		}

		if( $this->getName() == $wgwiki_user->getName() ) {
			$action = 'create';
		} else {
			$action = 'create2';
			if ( $byEmail ) {
				if ( $reason === '' ) {
					$reason = wfMessage( 'newwiki_userlog-byemail' )->inContentLanguage()->text();
				} else {
					$reason = $wgContLang->commaList( array(
						$reason, wfMessage( 'newwiki_userlog-byemail' )->inContentLanguage()->text() ) );
				}
			}
		}
		$log = new LogPage( 'newwiki_users' );
		return (int)$log->addEntry(
			$action,
			$this->getwiki_userPage(),
			$reason,
			array( $this->getId() )
		);
	}

	/**
	 * Add an autocreate newwiki_user log entry for this wiki_user
	 * Used by things like CentralAuth and perhaps other authplugins.
	 *
	 * @return bool
	 */
	public function addNewwiki_userLogEntryAutoCreate() {
		global $wgNewwiki_userLog;
		if( !$wgNewwiki_userLog ) {
			return true; // disabled
		}
		$log = new LogPage( 'newwiki_users', false );
		$log->addEntry( 'autocreate', $this->getwiki_userPage(), '', array( $this->getId() ), $this );
		return true;
	}

	/**
	 * @todo document
	 */
	protected function loadOptions() {
		$this->load();
		if ( $this->mOptionsLoaded || !$this->getId() )
			return;

		$this->mOptions = self::getDefaultOptions();

		// Maybe load from the object
		if ( !is_null( $this->mOptionOverrides ) ) {
			wfDebug( "wiki_user: loading options for wiki_user " . $this->getId() . " from override cache.\n" );
			foreach( $this->mOptionOverrides as $key => $value ) {
				$this->mOptions[$key] = $value;
			}
		} else {
			wfDebug( "wiki_user: loading options for wiki_user " . $this->getId() . " from database.\n" );
			// Load from database
			r = wfGetDB( DB_SLAVE );

			$res = r->select(
				'wiki_user_properties',
				array( 'up_property', 'up_value' ),
				array( 'up_wiki_user' => $this->getId() ),
				__METHOD__
			);

			$this->mOptionOverrides = array();
			foreach ( $res as $row ) {
				$this->mOptionOverrides[$row->up_property] = $row->up_value;
				$this->mOptions[$row->up_property] = $row->up_value;
			}
		}

		$this->mOptionsLoaded = true;

		wfRunHooks( 'wiki_userLoadOptions', array( $this, &$this->mOptions ) );
	}

	/**
	 * @todo document
	 */
	protected function saveOptions() {
		global $wgAllowPrefChange;

		$this->loadOptions();

		// Not using getOptions(), to keep hidden preferences in database
		$saveOptions = $this->mOptions;

		// Allow hooks to abort, for instance to save to a global profile.
		// Reset options to default state before saving.
		if( !wfRunHooks( 'wiki_userSaveOptions', array( $this, &$saveOptions ) ) ) {
			return;
		}

		$extwiki_user = Externalwiki_user::newFromwiki_user( $this );
		$wiki_userId = $this->getId();
		$insert_rows = array();
		foreach( $saveOptions as $key => $value ) {
			# Don't bother storing default values
			$defaultOption = self::getDefaultOption( $key );
			if ( ( is_null( $defaultOption ) &&
					!( $value === false || is_null( $value ) ) ) ||
					$value != $defaultOption ) {
				$insert_rows[] = array(
						'up_wiki_user' => $wiki_userId,
						'up_property' => $key,
						'up_value' => $value,
					);
			}
			if ( $extwiki_user && isset( $wgAllowPrefChange[$key] ) ) {
				switch ( $wgAllowPrefChange[$key] ) {
					case 'local':
					case 'message':
						break;
					case 'semiglobal':
					case 'global':
						$extwiki_user->setPref( $key, $value );
				}
			}
		}

		w = wfGetDB( DB_MASTER );
		w->delete( 'wiki_user_properties', array( 'up_wiki_user' => $wiki_userId ), __METHOD__ );
		w->insert( 'wiki_user_properties', $insert_rows, __METHOD__ );
	}

	/**
	 * Provide an array of HTML5 attributes to put on an input element
	 * intended for the wiki_user to enter a new password.  This may include
	 * required, title, and/or pattern, depending on $wgMinimalPasswordLength.
	 *
	 * Do *not* use this when asking the wiki_user to enter his current password!
	 * Regardless of configuration, wiki_users may have invalid passwords for whatever
	 * reason (e.g., they were set before requirements were tightened up).
	 * Only use it when asking for a new password, like on account creation or
	 * ResetPass.
	 *
	 * Obviously, you still need to do server-side checking.
	 *
	 * NOTE: A combination of bugs in various browsers means that this function
	 * actually just returns array() unconditionally at the moment.  May as
	 * well keep it around for when the browser bugs get fixed, though.
	 *
	 * @todo FIXME: This does not belong here; put it in Html or Linker or somewhere
	 *
	 * @return array Array of HTML attributes suitable for feeding to
	 *   Html::element(), directly or indirectly.  (Don't feed to Xml::*()!
	 *   That will potentially output invalid XHTML 1.0 Transitional, and will
	 *   get confused by the boolean attribute syntax used.)
	 */
	public static function passwordChangeInputAttribs() {
		global $wgMinimalPasswordLength;

		if ( $wgMinimalPasswordLength == 0 ) {
			return array();
		}

		# Note that the pattern requirement will always be satisfied if the
		# input is empty, so we need required in all cases.
		#
		# @todo FIXME: Bug 23769: This needs to not claim the password is required
		# if e-mail confirmation is being used.  Since HTML5 input validation
		# is b0rked anyway in some browsers, just return nothing.  When it's
		# re-enabled, fix this code to not output required for e-mail
		# registration.
		#$ret = array( 'required' );
		$ret = array();

		# We can't actually do this right now, because Opera 9.6 will print out
		# the entered password visibly in its error message!  When other
		# browsers add support for this attribute, or Opera fixes its support,
		# we can add support with a version check to avoid doing this on Opera
		# versions where it will be a problem.  Reported to Opera as
		# DSK-262266, but they don't have a public bug tracker for us to follow.
		/*
		if ( $wgMinimalPasswordLength > 1 ) {
			$ret['pattern'] = '.{' . intval( $wgMinimalPasswordLength ) . ',}';
			$ret['title'] = wfMessage( 'passwordtooshort' )
				->numParams( $wgMinimalPasswordLength )->text();
		}
		*/

		return $ret;
	}

	/**
	 * Return the list of wiki_user fields that should be selected to create
	 * a new wiki_user object.
	 * @return array
	 */
	public static function selectFields() {
		return array(
			'wiki_user_id',
			'wiki_user_name',
			'wiki_user_real_name',
			'wiki_user_password',
			'wiki_user_newpassword',
			'wiki_user_newpass_time',
			'wiki_user_email',
			'wiki_user_touched',
			'wiki_user_token',
			'wiki_user_email_authenticated',
			'wiki_user_email_token',
			'wiki_user_email_token_expires',
			'wiki_user_registration',
			'wiki_user_editcount',
		);
	}
}
