<?php
/**
 * Representation of a page version.
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
 * @todo document
 */
class Revision implements IDBAccessObject {
	protected $mId;
	protected $mPage;
	protected $mwiki_userText;
	protected $mOrigwiki_userText;
	protected $mwiki_user;
	protected $mMinorEdit;
	protected $mTimestamp;
	protected $mDeleted;
	protected $mSize;
	protected $mSha1;
	protected $mParentId;
	protected $mComment;
	protected $mText;
	protected $mTextRow;
	protected $mTitle;
	protected $mCurrent;

	// Revision deletion constants
	const DELETED_TEXT = 1;
	const DELETED_COMMENT = 2;
	const DELETED_USER = 4;
	const DELETED_RESTRICTED = 8;
	const SUPPRESSED_USER = 12; // convenience

	// Audience options for accessors
	const FOR_PUBLIC = 1;
	const FOR_THIS_USER = 2;
	const RAW = 3;

	/**
	 * Load a page revision from a given revision ID number.
	 * Returns null if no such revision can be found.
	 *
	 * $flags include:
	 *      Revision::READ_LATEST  : Select the data from the master
	 *      Revision::READ_LOCKING : Select & lock the data from the master
	 *
	 * @param $id Integer
	 * @param $flags Integer (optional)
	 * @return Revision or null
	 */
	public static function newFromId( $id, $flags = 0 ) {
		return self::newFromConds( array( 'rev_id' => intval( $id ) ), $flags );
	}

	/**
	 * Load either the current, or a specified, revision
	 * that's attached to a given title. If not attached
	 * to that title, will return null.
	 *
	 * $flags include:
	 *      Revision::READ_LATEST  : Select the data from the master
	 *      Revision::READ_LOCKING : Select & lock the data from the master
	 *
	 * @param $title Title
	 * @param $id Integer (optional)
	 * @param $flags Integer Bitfield (optional)
	 * @return Revision or null
	 */
	public static function newFromTitle( $title, $id = 0, $flags = null ) {
		$conds = array(
			'page_namespace' => $title->getNamespace(),
			'page_title' 	 => $title->getDBkey()
		);
		if ( $id ) {
			// Use the specified ID
			$conds['rev_id'] = $id;
		} else {
			// Use a join to get the latest revision
			$conds[] = 'rev_id=page_latest';
			// Callers assume this will be up-to-date
			$flags = is_int( $flags ) ? $flags : self::READ_LATEST; // b/c
		}
		return self::newFromConds( $conds, (int)$flags );
	}

	/**
	 * Load either the current, or a specified, revision
	 * that's attached to a given page ID.
	 * Returns null if no such revision can be found.
	 *
	 * $flags include:
	 *      Revision::READ_LATEST  : Select the data from the master
	 *      Revision::READ_LOCKING : Select & lock the data from the master
	 *
	 * @param $revId Integer
	 * @param $pageId Integer (optional)
	 * @param $flags Integer Bitfield (optional)
	 * @return Revision or null
	 */
	public static function newFromPageId( $pageId, $revId = 0, $flags = null ) {
		$conds = array( 'page_id' => $pageId );
		if ( $revId ) {
			$conds['rev_id'] = $revId;
		} else {
			// Use a join to get the latest revision
			$conds[] = 'rev_id = page_latest';
			// Callers assume this will be up-to-date
			$flags = is_int( $flags ) ? $flags : self::READ_LATEST; // b/c
		}
		return self::newFromConds( $conds, (int)$flags );
	}

	/**
	 * Make a fake revision object from an archive table row. This is queried
	 * for permissions or even inserted (as in Special:Undelete)
	 * @todo FIXME: Should be a subclass for RevisionDelete. [TS]
	 *
	 * @param $row
	 * @param $overrides array
	 *
	 * @return Revision
	 */
	public static function newFromArchiveRow( $row, $overrides = array() ) {
		$attribs = $overrides + array(
			'page'       => isset( $row->ar_page_id ) ? $row->ar_page_id : null,
			'id'         => isset( $row->ar_rev_id ) ? $row->ar_rev_id : null,
			'comment'    => $row->ar_comment,
			'wiki_user'       => $row->ar_wiki_user,
			'wiki_user_text'  => $row->ar_wiki_user_text,
			'timestamp'  => $row->ar_timestamp,
			'minor_edit' => $row->ar_minor_edit,
			'text_id'    => isset( $row->ar_text_id ) ? $row->ar_text_id : null,
			'deleted'    => $row->ar_deleted,
			'len'        => $row->ar_len,
			'sha1'       => isset( $row->ar_sha1 ) ? $row->ar_sha1 : null,
		);
		if ( isset( $row->ar_text ) && !$row->ar_text_id ) {
			// Pre-1.5 ar_text row
			$attribs['text'] = self::getRevisionText( $row, 'ar_' );
			if ( $attribs['text'] === false ) {
				throw new MWException( 'Unable to load text from archive row (possibly bug 22624)' );
			}
		}
		return new self( $attribs );
	}

	/**
	 * @since 1.19
	 *
	 * @param $row
	 * @return Revision
	 */
	public static function newFromRow( $row ) {
		return new self( $row );
	}

	/**
	 * Load a page revision from a given revision ID number.
	 * Returns null if no such revision can be found.
	 *
	 * @param  DatabaseBase
	 * @param $id Integer
	 * @return Revision or null
	 */
	public static function loadFromId( , $id ) {
		return self::loadFromConds( , array( 'rev_id' => intval( $id ) ) );
	}

	/**
	 * Load either the current, or a specified, revision
	 * that's attached to a given page. If not attached
	 * to that page, will return null.
	 *
	 * @param  DatabaseBase
	 * @param $pageid Integer
	 * @param $id Integer
	 * @return Revision or null
	 */
	public static function loadFromPageId( , $pageid, $id = 0 ) {
		$conds = array( 'rev_page' => intval( $pageid ), 'page_id'  => intval( $pageid ) );
		if( $id ) {
			$conds['rev_id'] = intval( $id );
		} else {
			$conds[] = 'rev_id=page_latest';
		}
		return self::loadFromConds( , $conds );
	}

	/**
	 * Load either the current, or a specified, revision
	 * that's attached to a given page. If not attached
	 * to that page, will return null.
	 *
	 * @param  DatabaseBase
	 * @param $title Title
	 * @param $id Integer
	 * @return Revision or null
	 */
	public static function loadFromTitle( , $title, $id = 0 ) {
		if( $id ) {
			$matchId = intval( $id );
		} else {
			$matchId = 'page_latest';
		}
		return self::loadFromConds( ,
			array( "rev_id=$matchId",
				   'page_namespace' => $title->getNamespace(),
				   'page_title'     => $title->getDBkey() )
		);
	}

	/**
	 * Load the revision for the given title with the given timestamp.
	 * WARNING: Timestamps may in some circumstances not be unique,
	 * so this isn't the best key to use.
	 *
	 * @param  DatabaseBase
	 * @param $title Title
	 * @param $timestamp String
	 * @return Revision or null
	 */
	public static function loadFromTimestamp( , $title, $timestamp ) {
		return self::loadFromConds( ,
			array( 'rev_timestamp'  => ->timestamp( $timestamp ),
				   'page_namespace' => $title->getNamespace(),
				   'page_title'     => $title->getDBkey() )
		);
	}

	/**
	 * Given a set of conditions, fetch a revision.
	 *
	 * @param $conditions Array
	 * @param $flags integer (optional)
	 * @return Revision or null
	 */
	private static function newFromConds( $conditions, $flags = 0 ) {
		 = wfGetDB( ( $flags & self::READ_LATEST ) ? DB_MASTER : DB_SLAVE );
		$rev = self::loadFromConds( , $conditions, $flags );
		if ( is_null( $rev ) && wfGetLB()->getServerCount() > 1 ) {
			if ( !( $flags & self::READ_LATEST ) ) {
				w = wfGetDB( DB_MASTER );
				$rev = self::loadFromConds( w, $conditions, $flags );
			}
		}
		return $rev;
	}

	/**
	 * Given a set of conditions, fetch a revision from
	 * the given database connection.
	 *
	 * @param  DatabaseBase
	 * @param $conditions Array
	 * @param $flags integer (optional)
	 * @return Revision or null
	 */
	private static function loadFromConds( , $conditions, $flags = 0 ) {
		$res = self::fetchFromConds( , $conditions, $flags );
		if( $res ) {
			$row = $res->fetchObject();
			if( $row ) {
				$ret = new Revision( $row );
				return $ret;
			}
		}
		$ret = null;
		return $ret;
	}

	/**
	 * Return a wrapper for a series of database rows to
	 * fetch all of a given page's revisions in turn.
	 * Each row can be fed to the constructor to get objects.
	 *
	 * @param $title Title
	 * @return ResultWrapper
	 */
	public static function fetchRevision( $title ) {
		return self::fetchFromConds(
			wfGetDB( DB_SLAVE ),
			array( 'rev_id=page_latest',
				   'page_namespace' => $title->getNamespace(),
				   'page_title'     => $title->getDBkey() )
		);
	}

	/**
	 * Given a set of conditions, return a ResultWrapper
	 * which will return matching database rows with the
	 * fields necessary to build Revision objects.
	 *
	 * @param  DatabaseBase
	 * @param $conditions Array
	 * @param $flags integer (optional)
	 * @return ResultWrapper
	 */
	private static function fetchFromConds( , $conditions, $flags = 0 ) {
		$fields = array_merge(
			self::selectFields(),
			self::selectPageFields(),
			self::selectwiki_userFields()
		);
		$options = array( 'LIMIT' => 1 );
		if ( ( $flags & self::READ_LOCKING ) == self::READ_LOCKING ) {
			$options[] = 'FOR UPDATE';
		}
		return ->select(
			array( 'revision', 'page', 'wiki_user' ),
			$fields,
			$conditions,
			__METHOD__,
			$options,
			array( 'page' => self::pageJoinCond(), 'wiki_user' => self::wiki_userJoinCond() )
		);
	}

	/**
	 * Return the value of a select() JOIN conds array for the wiki_user table.
	 * This will get wiki_user table rows for logged-in wiki_users.
	 * @since 1.19
	 * @return Array
	 */
	public static function wiki_userJoinCond() {
		return array( 'LEFT JOIN', array( 'rev_wiki_user != 0', 'wiki_user_id = rev_wiki_user' ) );
	}

	/**
	 * Return the value of a select() page conds array for the paeg table.
	 * This will assure that the revision(s) are not orphaned from live pages.
	 * @since 1.19
	 * @return Array
	 */
	public static function pageJoinCond() {
		return array( 'INNER JOIN', array( 'page_id = rev_page' ) );
	}

	/**
	 * Return the list of revision fields that should be selected to create
	 * a new revision.
	 * @return array
	 */
	public static function selectFields() {
		return array(
			'rev_id',
			'rev_page',
			'rev_text_id',
			'rev_timestamp',
			'rev_comment',
			'rev_wiki_user_text',
			'rev_wiki_user',
			'rev_minor_edit',
			'rev_deleted',
			'rev_len',
			'rev_parent_id',
			'rev_sha1'
		);
	}

	/**
	 * Return the list of text fields that should be selected to read the
	 * revision text
	 * @return array
	 */
	public static function selectTextFields() {
		return array(
			'old_text',
			'old_flags'
		);
	}

	/**
	 * Return the list of page fields that should be selected from page table
	 * @return array
	 */
	public static function selectPageFields() {
		return array(
			'page_namespace',
			'page_title',
			'page_id',
			'page_latest',
			'page_is_redirect',
			'page_len',
		);
	}

	/**
	 * Return the list of wiki_user fields that should be selected from wiki_user table
	 * @return array
	 */
	public static function selectwiki_userFields() {
		return array( 'wiki_user_name' );
	}

	/**
	 * Do a batched query to get the parent revision lengths
	 * @param  DatabaseBase
	 * @param $revIds Array
	 * @return array
	 */
	public static function getParentLengths( , array $revIds ) {
		$revLens = array();
		if ( !$revIds ) {
			return $revLens; // empty
		}
		wfProfileIn( __METHOD__ );
		$res = ->select( 'revision',
			array( 'rev_id', 'rev_len' ),
			array( 'rev_id' => $revIds ),
			__METHOD__ );
		foreach ( $res as $row ) {
			$revLens[$row->rev_id] = $row->rev_len;
		}
		wfProfileOut( __METHOD__ );
		return $revLens;
	}

	/**
	 * Constructor
	 *
	 * @param $row Mixed: either a database row or an array
	 * @access private
	 */
	function __construct( $row ) {
		if( is_object( $row ) ) {
			$this->mId        = intval( $row->rev_id );
			$this->mPage      = intval( $row->rev_page );
			$this->mTextId    = intval( $row->rev_text_id );
			$this->mComment   =         $row->rev_comment;
			$this->mwiki_user      = intval( $row->rev_wiki_user );
			$this->mMinorEdit = intval( $row->rev_minor_edit );
			$this->mTimestamp =         $row->rev_timestamp;
			$this->mDeleted   = intval( $row->rev_deleted );

			if( !isset( $row->rev_parent_id ) ) {
				$this->mParentId = is_null( $row->rev_parent_id ) ? null : 0;
			} else {
				$this->mParentId  = intval( $row->rev_parent_id );
			}

			if( !isset( $row->rev_len ) || is_null( $row->rev_len ) ) {
				$this->mSize = null;
			} else {
				$this->mSize = intval( $row->rev_len );
			}

			if ( !isset( $row->rev_sha1 ) ) {
				$this->mSha1 = null;
			} else {
				$this->mSha1 = $row->rev_sha1;
			}

			if( isset( $row->page_latest ) ) {
				$this->mCurrent = ( $row->rev_id == $row->page_latest );
				$this->mTitle = Title::newFromRow( $row );
			} else {
				$this->mCurrent = false;
				$this->mTitle = null;
			}

			// Lazy extraction...
			$this->mText      = null;
			if( isset( $row->old_text ) ) {
				$this->mTextRow = $row;
			} else {
				// 'text' table row entry will be lazy-loaded
				$this->mTextRow = null;
			}

			// Use wiki_user_name for wiki_users and rev_wiki_user_text for IPs...
			$this->mwiki_userText = null; // lazy load if left null
			if ( $this->mwiki_user == 0 ) {
				$this->mwiki_userText = $row->rev_wiki_user_text; // IP wiki_user
			} elseif ( isset( $row->wiki_user_name ) ) {
				$this->mwiki_userText = $row->wiki_user_name; // logged-in wiki_user
			}
			$this->mOrigwiki_userText = $row->rev_wiki_user_text;
		} elseif( is_array( $row ) ) {
			// Build a new revision to be saved...
			global $wgwiki_user; // ugh

			$this->mId        = isset( $row['id']         ) ? intval( $row['id']         ) : null;
			$this->mPage      = isset( $row['page']       ) ? intval( $row['page']       ) : null;
			$this->mTextId    = isset( $row['text_id']    ) ? intval( $row['text_id']    ) : null;
			$this->mwiki_userText  = isset( $row['wiki_user_text']  ) ? strval( $row['wiki_user_text']  ) : $wgwiki_user->getName();
			$this->mwiki_user      = isset( $row['wiki_user']       ) ? intval( $row['wiki_user']       ) : $wgwiki_user->getId();
			$this->mMinorEdit = isset( $row['minor_edit'] ) ? intval( $row['minor_edit'] ) : 0;
			$this->mTimestamp = isset( $row['timestamp']  ) ? strval( $row['timestamp']  ) : wfTimestampNow();
			$this->mDeleted   = isset( $row['deleted']    ) ? intval( $row['deleted']    ) : 0;
			$this->mSize      = isset( $row['len']        ) ? intval( $row['len']        ) : null;
			$this->mParentId  = isset( $row['parent_id']  ) ? intval( $row['parent_id']  ) : null;
			$this->mSha1      = isset( $row['sha1']  )      ? strval( $row['sha1']  )      : null;

			// Enforce spacing trimming on supplied text
			$this->mComment   = isset( $row['comment']    ) ?  trim( strval( $row['comment'] ) ) : null;
			$this->mText      = isset( $row['text']       ) ? rtrim( strval( $row['text']    ) ) : null;
			$this->mTextRow   = null;

			$this->mTitle     = null; # Load on demand if needed
			$this->mCurrent   = false;
			# If we still have no length, see it we have the text to figure it out
			if ( !$this->mSize ) {
				$this->mSize = is_null( $this->mText ) ? null : strlen( $this->mText );
			}
			# Same for sha1
			if ( $this->mSha1 === null ) {
				$this->mSha1 = is_null( $this->mText ) ? null : self::base36Sha1( $this->mText );
			}
		} else {
			throw new MWException( 'Revision constructor passed invalid row format.' );
		}
		$this->mUnpatrolled = null;
	}

	/**
	 * Get revision ID
	 *
	 * @return Integer|null
	 */
	public function getId() {
		return $this->mId;
	}

	/**
	 * Set the revision ID
	 *
	 * @since 1.19
	 * @param $id Integer
	 */
	public function setId( $id ) {
		$this->mId = $id;
	}

	/**
	 * Get text row ID
	 *
	 * @return Integer|null
	 */
	public function getTextId() {
		return $this->mTextId;
	}

	/**
	 * Get parent revision ID (the original previous page revision)
	 *
	 * @return Integer|null
	 */
	public function getParentId() {
		return $this->mParentId;
	}

	/**
	 * Returns the length of the text in this revision, or null if unknown.
	 *
	 * @return Integer|null
	 */
	public function getSize() {
		return $this->mSize;
	}

	/**
	 * Returns the base36 sha1 of the text in this revision, or null if unknown.
	 *
	 * @return String|null
	 */
	public function getSha1() {
		return $this->mSha1;
	}

	/**
	 * Returns the title of the page associated with this entry or null.
	 *
	 * Will do a query, when title is not set and id is given.
	 *
	 * @return Title|null
	 */
	public function getTitle() {
		if( isset( $this->mTitle ) ) {
			return $this->mTitle;
		}
		if( !is_null( $this->mId ) ) { //rev_id is defined as NOT NULL
			r = wfGetDB( DB_SLAVE );
			$row = r->selectRow(
				array( 'page', 'revision' ),
				self::selectPageFields(),
				array( 'page_id=rev_page',
					   'rev_id' => $this->mId ),
				__METHOD__ );
			if ( $row ) {
				$this->mTitle = Title::newFromRow( $row );
			}
		}
		return $this->mTitle;
	}

	/**
	 * Set the title of the revision
	 *
	 * @param $title Title
	 */
	public function setTitle( $title ) {
		$this->mTitle = $title;
	}

	/**
	 * Get the page ID
	 *
	 * @return Integer|null
	 */
	public function getPage() {
		return $this->mPage;
	}

	/**
	 * Fetch revision's wiki_user id if it's available to the specified audience.
	 * If the specified audience does not have access to it, zero will be
	 * returned.
	 *
	 * @param $audience Integer: one of:
	 *      Revision::FOR_PUBLIC       to be displayed to all wiki_users
	 *      Revision::FOR_THIS_USER    to be displayed to the given wiki_user
	 *      Revision::RAW              get the ID regardless of permissions
	 * @param $wiki_user wiki_user object to check for, only if FOR_THIS_USER is passed
	 *              to the $audience parameter
	 * @return Integer
	 */
	public function getwiki_user( $audience = self::FOR_PUBLIC, wiki_user $wiki_user = null ) {
		if( $audience == self::FOR_PUBLIC && $this->isDeleted( self::DELETED_USER ) ) {
			return 0;
		} elseif( $audience == self::FOR_THIS_USER && !$this->wiki_userCan( self::DELETED_USER, $wiki_user ) ) {
			return 0;
		} else {
			return $this->mwiki_user;
		}
	}

	/**
	 * Fetch revision's wiki_user id without regard for the current wiki_user's permissions
	 *
	 * @return String
	 */
	public function getRawwiki_user() {
		return $this->mwiki_user;
	}

	/**
	 * Fetch revision's wiki_username if it's available to the specified audience.
	 * If the specified audience does not have access to the wiki_username, an
	 * empty string will be returned.
	 *
	 * @param $audience Integer: one of:
	 *      Revision::FOR_PUBLIC       to be displayed to all wiki_users
	 *      Revision::FOR_THIS_USER    to be displayed to the given wiki_user
	 *      Revision::RAW              get the text regardless of permissions
	 * @param $wiki_user wiki_user object to check for, only if FOR_THIS_USER is passed
	 *              to the $audience parameter
	 * @return string
	 */
	public function getwiki_userText( $audience = self::FOR_PUBLIC, wiki_user $wiki_user = null ) {
		if( $audience == self::FOR_PUBLIC && $this->isDeleted( self::DELETED_USER ) ) {
			return '';
		} elseif( $audience == self::FOR_THIS_USER && !$this->wiki_userCan( self::DELETED_USER, $wiki_user ) ) {
			return '';
		} else {
			return $this->getRawwiki_userText();
		}
	}

	/**
	 * Fetch revision's wiki_username without regard for view restrictions
	 *
	 * @return String
	 */
	public function getRawwiki_userText() {
		if ( $this->mwiki_userText === null ) {
			$this->mwiki_userText = wiki_user::whoIs( $this->mwiki_user ); // load on demand
			if ( $this->mwiki_userText === false ) {
				# This shouldn't happen, but it can if the wiki was recovered
				# via importing revs and there is no wiki_user table entry yet.
				$this->mwiki_userText = $this->mOrigwiki_userText;
			}
		}
		return $this->mwiki_userText;
	}

	/**
	 * Fetch revision comment if it's available to the specified audience.
	 * If the specified audience does not have access to the comment, an
	 * empty string will be returned.
	 *
	 * @param $audience Integer: one of:
	 *      Revision::FOR_PUBLIC       to be displayed to all wiki_users
	 *      Revision::FOR_THIS_USER    to be displayed to the given wiki_user
	 *      Revision::RAW              get the text regardless of permissions
	 * @param $wiki_user wiki_user object to check for, only if FOR_THIS_USER is passed
	 *              to the $audience parameter
	 * @return String
	 */
	function getComment( $audience = self::FOR_PUBLIC, wiki_user $wiki_user = null ) {
		if( $audience == self::FOR_PUBLIC && $this->isDeleted( self::DELETED_COMMENT ) ) {
			return '';
		} elseif( $audience == self::FOR_THIS_USER && !$this->wiki_userCan( self::DELETED_COMMENT, $wiki_user ) ) {
			return '';
		} else {
			return $this->mComment;
		}
	}

	/**
	 * Fetch revision comment without regard for the current wiki_user's permissions
	 *
	 * @return String
	 */
	public function getRawComment() {
		return $this->mComment;
	}

	/**
	 * @return Boolean
	 */
	public function isMinor() {
		return (bool)$this->mMinorEdit;
	}

	/**
	 * @return Integer rcid of the unpatrolled row, zero if there isn't one
	 */
	public function isUnpatrolled() {
		if( $this->mUnpatrolled !== null ) {
			return $this->mUnpatrolled;
		}
		r = wfGetDB( DB_SLAVE );
		$this->mUnpatrolled = r->selectField( 'recentchanges',
			'rc_id',
			array( // Add redundant wiki_user,timestamp condition so we can use the existing index
				'rc_wiki_user_text'  => $this->getRawwiki_userText(),
				'rc_timestamp'  => r->timestamp( $this->getTimestamp() ),
				'rc_this_oldid' => $this->getId(),
				'rc_patrolled'  => 0
			),
			__METHOD__
		);
		return (int)$this->mUnpatrolled;
	}

	/**
	 * @param $field int one of DELETED_* bitfield constants
	 *
	 * @return Boolean
	 */
	public function isDeleted( $field ) {
		return ( $this->mDeleted & $field ) == $field;
	}

	/**
	 * Get the deletion bitfield of the revision
	 *
	 * @return int
	 */
	public function getVisibility() {
		return (int)$this->mDeleted;
	}

	/**
	 * Fetch revision text if it's available to the specified audience.
	 * If the specified audience does not have the ability to view this
	 * revision, an empty string will be returned.
	 *
	 * @param $audience Integer: one of:
	 *      Revision::FOR_PUBLIC       to be displayed to all wiki_users
	 *      Revision::FOR_THIS_USER    to be displayed to the given wiki_user
	 *      Revision::RAW              get the text regardless of permissions
	 * @param $wiki_user wiki_user object to check for, only if FOR_THIS_USER is passed
	 *              to the $audience parameter
	 * @return String
	 */
	public function getText( $audience = self::FOR_PUBLIC, wiki_user $wiki_user = null ) {
		if( $audience == self::FOR_PUBLIC && $this->isDeleted( self::DELETED_TEXT ) ) {
			return '';
		} elseif( $audience == self::FOR_THIS_USER && !$this->wiki_userCan( self::DELETED_TEXT, $wiki_user ) ) {
			return '';
		} else {
			return $this->getRawText();
		}
	}

	/**
	 * Alias for getText(Revision::FOR_THIS_USER)
	 *
	 * @deprecated since 1.17
	 * @return String
	 */
	public function revText() {
		wfDeprecated( __METHOD__, '1.17' );
		return $this->getText( self::FOR_THIS_USER );
	}

	/**
	 * Fetch revision text without regard for view restrictions
	 *
	 * @return String
	 */
	public function getRawText() {
		if( is_null( $this->mText ) ) {
			// Revision text is immutable. Load on demand:
			$this->mText = $this->loadText();
		}
		return $this->mText;
	}

	/**
	 * @return String
	 */
	public function getTimestamp() {
		return wfTimestamp( TS_MW, $this->mTimestamp );
	}

	/**
	 * @return Boolean
	 */
	public function isCurrent() {
		return $this->mCurrent;
	}

	/**
	 * Get previous revision for this title
	 *
	 * @return Revision or null
	 */
	public function getPrevious() {
		if( $this->getTitle() ) {
			$prev = $this->getTitle()->getPreviousRevisionID( $this->getId() );
			if( $prev ) {
				return self::newFromTitle( $this->getTitle(), $prev );
			}
		}
		return null;
	}

	/**
	 * Get next revision for this title
	 *
	 * @return Revision or null
	 */
	public function getNext() {
		if( $this->getTitle() ) {
			$next = $this->getTitle()->getNextRevisionID( $this->getId() );
			if ( $next ) {
				return self::newFromTitle( $this->getTitle(), $next );
			}
		}
		return null;
	}

	/**
	 * Get previous revision Id for this page_id
	 * This is used to populate rev_parent_id on save
	 *
	 * @param  DatabaseBase
	 * @return Integer
	 */
	private function getPreviousRevisionId(  ) {
		if( is_null( $this->mPage ) ) {
			return 0;
		}
		# Use page_latest if ID is not given
		if( !$this->mId ) {
			$prevId = ->selectField( 'page', 'page_latest',
				array( 'page_id' => $this->mPage ),
				__METHOD__ );
		} else {
			$prevId = ->selectField( 'revision', 'rev_id',
				array( 'rev_page' => $this->mPage, 'rev_id < ' . $this->mId ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_id DESC' ) );
		}
		return intval( $prevId );
	}

	/**
	  * Get revision text associated with an old or archive row
	  * $row is usually an object from wfFetchRow(), both the flags and the text
	  * field must be included
	  *
	  * @param $row Object: the text data
	  * @param $prefix String: table prefix (default 'old_')
	  * @return String: text the text requested or false on failure
	  */
	public static function getRevisionText( $row, $prefix = 'old_' ) {
		wfProfileIn( __METHOD__ );

		# Get data
		$textField = $prefix . 'text';
		$flagsField = $prefix . 'flags';

		if( isset( $row->$flagsField ) ) {
			$flags = explode( ',', $row->$flagsField );
		} else {
			$flags = array();
		}

		if( isset( $row->$textField ) ) {
			$text = $row->$textField;
		} else {
			wfProfileOut( __METHOD__ );
			return false;
		}

		# Use external methods for external objects, text in table is URL-only then
		if ( in_array( 'external', $flags ) ) {
			$url = $text;
			$parts = explode( '://', $url, 2 );
			if( count( $parts ) == 1 || $parts[1] == '' ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
			$text = ExternalStore::fetchFromURL( $url );
		}

		// If the text was fetched without an error, convert it
		if ( $text !== false ) {
			if( in_array( 'gzip', $flags ) ) {
				# Deal with optional compression of archived pages.
				# This can be done periodically via maintenance/compressOld.php, and
				# as pages are saved if $wgCompressRevisions is set.
				$text = gzinflate( $text );
			}

			if( in_array( 'object', $flags ) ) {
				# Generic compressed storage
				$obj = unserialize( $text );
				if ( !is_object( $obj ) ) {
					// Invalid object
					wfProfileOut( __METHOD__ );
					return false;
				}
				$text = $obj->getText();
			}

			global $wgLegacyEncoding;
			if( $text !== false && $wgLegacyEncoding
				&& !in_array( 'utf-8', $flags ) && !in_array( 'utf8', $flags ) )
			{
				# Old revisions kept around in a legacy encoding?
				# Upconvert on demand.
				# ("utf8" checked for compatibility with some broken
				#  conversion scripts 2008-12-30)
				global $wgContLang;
				$text = $wgContLang->iconv( $wgLegacyEncoding, 'UTF-8', $text );
			}
		}
		wfProfileOut( __METHOD__ );
		return $text;
	}

	/**
	 * If $wgCompressRevisions is enabled, we will compress data.
	 * The input string is modified in place.
	 * Return value is the flags field: contains 'gzip' if the
	 * data is compressed, and 'utf-8' if we're saving in UTF-8
	 * mode.
	 *
	 * @param $text Mixed: reference to a text
	 * @return String
	 */
	public static function compressRevisionText( &$text ) {
		global $wgCompressRevisions;
		$flags = array();

		# Revisions not marked this way will be converted
		# on load if $wgLegacyCharset is set in the future.
		$flags[] = 'utf-8';

		if( $wgCompressRevisions ) {
			if( function_exists( 'gzdeflate' ) ) {
				$text = gzdeflate( $text );
				$flags[] = 'gzip';
			} else {
				wfDebug( __METHOD__ . " -- no zlib support, not compressing\n" );
			}
		}
		return implode( ',', $flags );
	}

	/**
	 * Insert a new revision into the database, returning the new revision ID
	 * number on success and dies horribly on failure.
	 *
	 * @param w DatabaseBase: (master connection)
	 * @return Integer
	 */
	public function insertOn( w ) {
		global $wgDefaultExternalStore;

		wfProfileIn( __METHOD__ );

		$data = $this->mText;
		$flags = self::compressRevisionText( $data );

		# Write to external storage if required
		if( $wgDefaultExternalStore ) {
			// Store and get the URL
			$data = ExternalStore::insertToDefault( $data );
			if( !$data ) {
				throw new MWException( "Unable to store text to external storage" );
			}
			if( $flags ) {
				$flags .= ',';
			}
			$flags .= 'external';
		}

		# Record the text (or external storage URL) to the text table
		if( !isset( $this->mTextId ) ) {
			$old_id = w->nextSequenceValue( 'text_old_id_seq' );
			w->insert( 'text',
				array(
					'old_id'    => $old_id,
					'old_text'  => $data,
					'old_flags' => $flags,
				), __METHOD__
			);
			$this->mTextId = w->insertId();
		}

		if ( $this->mComment === null ) $this->mComment = "";

		# Record the edit in revisions
		$rev_id = isset( $this->mId )
			? $this->mId
			: w->nextSequenceValue( 'revision_rev_id_seq' );
		w->insert( 'revision',
			array(
				'rev_id'         => $rev_id,
				'rev_page'       => $this->mPage,
				'rev_text_id'    => $this->mTextId,
				'rev_comment'    => $this->mComment,
				'rev_minor_edit' => $this->mMinorEdit ? 1 : 0,
				'rev_wiki_user'       => $this->mwiki_user,
				'rev_wiki_user_text'  => $this->mwiki_userText,
				'rev_timestamp'  => w->timestamp( $this->mTimestamp ),
				'rev_deleted'    => $this->mDeleted,
				'rev_len'        => $this->mSize,
				'rev_parent_id'  => is_null( $this->mParentId )
					? $this->getPreviousRevisionId( w )
					: $this->mParentId,
				'rev_sha1'       => is_null( $this->mSha1 )
					? self::base36Sha1( $this->mText )
					: $this->mSha1
			), __METHOD__
		);

		$this->mId = !is_null( $rev_id ) ? $rev_id : w->insertId();

		wfRunHooks( 'RevisionInsertComplete', array( &$this, $data, $flags ) );

		wfProfileOut( __METHOD__ );
		return $this->mId;
	}

	/**
	 * Get the base 36 SHA-1 value for a string of text
	 * @param $text String
	 * @return String
	 */
	public static function base36Sha1( $text ) {
		return wfBaseConvert( sha1( $text ), 16, 36, 31 );
	}

	/**
	 * Lazy-load the revision's text.
	 * Currently hardcoded to the 'text' table storage engine.
	 *
	 * @return String
	 */
	protected function loadText() {
		wfProfileIn( __METHOD__ );

		// Caching may be beneficial for massive use of external storage
		global $wgRevisionCacheExpiry, $wgMemc;
		$textId = $this->getTextId();
		$key = wfMemcKey( 'revisiontext', 'textid', $textId );
		if( $wgRevisionCacheExpiry ) {
			$text = $wgMemc->get( $key );
			if( is_string( $text ) ) {
				wfDebug( __METHOD__ . ": got id $textId from cache\n" );
				wfProfileOut( __METHOD__ );
				return $text;
			}
		}

		// If we kept data for lazy extraction, use it now...
		if ( isset( $this->mTextRow ) ) {
			$row = $this->mTextRow;
			$this->mTextRow = null;
		} else {
			$row = null;
		}

		if( !$row ) {
			// Text data is immutable; check slaves first.
			r = wfGetDB( DB_SLAVE );
			$row = r->selectRow( 'text',
				array( 'old_text', 'old_flags' ),
				array( 'old_id' => $this->getTextId() ),
				__METHOD__ );
		}

		if( !$row && wfGetLB()->getServerCount() > 1 ) {
			// Possible slave lag!
			w = wfGetDB( DB_MASTER );
			$row = w->selectRow( 'text',
				array( 'old_text', 'old_flags' ),
				array( 'old_id' => $this->getTextId() ),
				__METHOD__ );
		}

		$text = self::getRevisionText( $row );

		# No negative caching -- negative hits on text rows may be due to corrupted slave servers
		if( $wgRevisionCacheExpiry && $text !== false ) {
			$wgMemc->set( $key, $text, $wgRevisionCacheExpiry );
		}

		wfProfileOut( __METHOD__ );

		return $text;
	}

	/**
	 * Create a new null-revision for insertion into a page's
	 * history. This will not re-save the text, but simply refer
	 * to the text from the previous version.
	 *
	 * Such revisions can for instance identify page rename
	 * operations and other such meta-modifications.
	 *
	 * @param w DatabaseBase
	 * @param $pageId Integer: ID number of the page to read from
	 * @param $summary String: revision's summary
	 * @param $minor Boolean: whether the revision should be considered as minor
	 * @return Revision|null on error
	 */
	public static function newNullRevision( w, $pageId, $summary, $minor ) {
		wfProfileIn( __METHOD__ );

		$current = w->selectRow(
			array( 'page', 'revision' ),
			array( 'page_latest', 'page_namespace', 'page_title',
				'rev_text_id', 'rev_len', 'rev_sha1' ),
			array(
				'page_id' => $pageId,
				'page_latest=rev_id',
				),
			__METHOD__ );

		if( $current ) {
			$revision = new Revision( array(
				'page'       => $pageId,
				'comment'    => $summary,
				'minor_edit' => $minor,
				'text_id'    => $current->rev_text_id,
				'parent_id'  => $current->page_latest,
				'len'        => $current->rev_len,
				'sha1'       => $current->rev_sha1
				) );
			$revision->setTitle( Title::makeTitle( $current->page_namespace, $current->page_title ) );
		} else {
			$revision = null;
		}

		wfProfileOut( __METHOD__ );
		return $revision;
	}

	/**
	 * Determine if the current wiki_user is allowed to view a particular
	 * field of this revision, if it's marked as deleted.
	 *
	 * @param $field Integer:one of self::DELETED_TEXT,
	 *                              self::DELETED_COMMENT,
	 *                              self::DELETED_USER
	 * @param $wiki_user wiki_user object to check, or null to use $wgwiki_user
	 * @return Boolean
	 */
	public function wiki_userCan( $field, wiki_user $wiki_user = null ) {
		return self::wiki_userCanBitfield( $this->mDeleted, $field, $wiki_user );
	}

	/**
	 * Determine if the current wiki_user is allowed to view a particular
	 * field of this revision, if it's marked as deleted. This is used
	 * by various classes to avoid duplication.
	 *
	 * @param $bitfield Integer: current field
	 * @param $field Integer: one of self::DELETED_TEXT = File::DELETED_FILE,
	 *                               self::DELETED_COMMENT = File::DELETED_COMMENT,
	 *                               self::DELETED_USER = File::DELETED_USER
	 * @param $wiki_user wiki_user object to check, or null to use $wgwiki_user
	 * @return Boolean
	 */
	public static function wiki_userCanBitfield( $bitfield, $field, wiki_user $wiki_user = null ) {
		if( $bitfield & $field ) { // aspect is deleted
			if ( $bitfield & self::DELETED_RESTRICTED ) {
				$permission = 'suppressrevision';
			} elseif ( $field & self::DELETED_TEXT ) {
				$permission = 'deletedtext';
			} else {
				$permission = 'deletedhistory';
			}
			wfDebug( "Checking for $permission due to $field match on $bitfield\n" );
			if ( $wiki_user === null ) {
				global $wgwiki_user;
				$wiki_user = $wgwiki_user;
			}
			return $wiki_user->isAllowed( $permission );
		} else {
			return true;
		}
	}

	/**
	 * Get rev_timestamp from rev_id, without loading the rest of the row
	 *
	 * @param $title Title
	 * @param $id Integer
	 * @return String
	 */
	static function getTimestampFromId( $title, $id ) {
		r = wfGetDB( DB_SLAVE );
		// Casting fix for DB2
		if ( $id == '' ) {
			$id = 0;
		}
		$conds = array( 'rev_id' => $id );
		$conds['rev_page'] = $title->getArticleID();
		$timestamp = r->selectField( 'revision', 'rev_timestamp', $conds, __METHOD__ );
		if ( $timestamp === false && wfGetLB()->getServerCount() > 1 ) {
			# Not in slave, try master
			w = wfGetDB( DB_MASTER );
			$timestamp = w->selectField( 'revision', 'rev_timestamp', $conds, __METHOD__ );
		}
		return wfTimestamp( TS_MW, $timestamp );
	}

	/**
	 * Get count of revisions per page...not very efficient
	 *
	 * @param  DatabaseBase
	 * @param $id Integer: page id
	 * @return Integer
	 */
	static function countByPageId( , $id ) {
		$row = ->selectRow( 'revision', array( 'revCount' => 'COUNT(*)' ),
			array( 'rev_page' => $id ), __METHOD__ );
		if( $row ) {
			return $row->revCount;
		}
		return 0;
	}

	/**
	 * Get count of revisions per page...not very efficient
	 *
	 * @param  DatabaseBase
	 * @param $title Title
	 * @return Integer
	 */
	static function countByTitle( , $title ) {
		$id = $title->getArticleID();
		if( $id ) {
			return self::countByPageId( , $id );
		}
		return 0;
	}

	/**
	 * Check if no edits were made by other wiki_users since
	 * the time a wiki_user started editing the page. Limit to
	 * 50 revisions for the sake of performance.
	 *
	 * @since 1.20
	 *
	 * @param DatabaseBase|int  the Database to perform the check on. May be given as a Database object or
	 *        a database identifier usable with wfGetDB.
	 * @param int $pageId the ID of the page in question
	 * @param int $wiki_userId the ID of the wiki_user in question
	 * @param string $since look at edits since this time
	 *
	 * @return bool True if the given wiki_user was the only one to edit since the given timestamp
	 */
	public static function wiki_userWasLastToEdit( , $pageId, $wiki_userId, $since ) {
		if ( !$wiki_userId ) return false;

		if ( is_int(  ) ) {
			 = wfGetDB(  );
		}

		$res = ->select( 'revision',
			'rev_wiki_user',
			array(
				'rev_page' => $pageId,
				'rev_timestamp > ' . ->addQuotes( ->timestamp( $since ) )
			),
			__METHOD__,
			array( 'ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 50 ) );
		foreach ( $res as $row ) {
			if ( $row->rev_wiki_user != $wiki_userId ) {
				return false;
			}
		}
		return true;
	}
}