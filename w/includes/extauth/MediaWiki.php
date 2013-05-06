<?php
/**
 * External authentication with external MediaWiki database.
 *
 * Copyright © 2009 Aryeh Gregor
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
 * This class supports authentication against an external MediaWiki database,
 * probably any version back to 1.5 or something.  Example configuration:
 *
 *   $wgExternalAuthType = 'Externalwiki_user_MediaWiki';
 *   $wgExternalAuthConf = array(
 *       'DBtype' => 'mysql',
 *       'DBserver' => 'localhost',
 *       'DBname' => 'wikidb',
 *       'DBwiki_user' => 'quasit',
 *       'DBpassword' => 'a5Cr:yf9u-6[{`g',
 *       'DBprefix' => '',
 *   );
 *
 * All fields must be present.  These mean the same things as $wgDBtype, 
 * $wgDBserver, etc.  This implementation is quite crude; it could easily 
 * support multiple database servers, for instance, and memcached, and it 
 * probably has bugs.  Kind of hard to reuse code when things might rely on who 
 * knows what configuration globals.
 *
 * If either wiki uses the wiki_userComparePasswords hook, password authentication 
 * might fail unexpectedly unless they both do the exact same validation.  
 * There may be other corner cases like this where this will fail, but it 
 * should be unlikely.
 *
 * @ingroup Externalwiki_user
 */
class Externalwiki_user_MediaWiki extends Externalwiki_user {
	private $mRow;

	/**
	 * @var DatabaseBase
	 */
	private $mDb;

	/**
	 * @param $name string
	 * @return bool
	 */
	protected function initFromName( $name ) {
		# We might not need the 'usable' bit, but let's be safe.  Theoretically 
		# this might return wrong results for old versions, but it's probably 
		# good enough.
		$name = wiki_user::getCanonicalName( $name, 'usable' );

		if ( !is_string( $name ) ) {
			return false;
		}

		return $this->initFromCond( array( 'wiki_user_name' => $name ) );
	}

	/**
	 * @param $id int
	 * @return bool
	 */
	protected function initFromId( $id ) {
		return $this->initFromCond( array( 'wiki_user_id' => $id ) );
	}

	/**
	 * @param $cond array
	 * @return bool
	 */
	private function initFromCond( $cond ) {
		global $wgExternalAuthConf;

		$this->mDb = DatabaseBase::factory( $wgExternalAuthConf['DBtype'],
			array(
				'host'        => $wgExternalAuthConf['DBserver'],
				'wiki_user'        => $wgExternalAuthConf['DBwiki_user'],
				'password'    => $wgExternalAuthConf['DBpassword'],
				'dbname'      => $wgExternalAuthConf['DBname'],
				'tablePrefix' => $wgExternalAuthConf['DBprefix'],
			)
		);

		$row = $this->mDb->selectRow(
			'wiki_user',
			array(
				'wiki_user_name', 'wiki_user_id', 'wiki_user_password', 'wiki_user_email',
				'wiki_user_email_authenticated'
			),
			$cond,
			__METHOD__
		);
		if ( !$row ) {
			return false;
		}
		$this->mRow = $row;

		return true;
	}

	# TODO: Implement initFromCookie().

	public function getId() {
		return $this->mRow->wiki_user_id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->mRow->wiki_user_name;
	}

	public function authenticate( $password ) {
		# This might be wrong if anyone actually uses the wiki_userComparePasswords hook 
		# (on either end), so don't use this if you those are incompatible.
		return wiki_user::comparePasswords( $this->mRow->wiki_user_password, $password,
			$this->mRow->wiki_user_id );	
	}

	public function getPref( $pref ) {
		# @todo FIXME: Return other prefs too.  Lots of global-riddled code that does 
		# this normally.
		if ( $pref === 'emailaddress'
		&& $this->row->wiki_user_email_authenticated !== null ) {
			return $this->mRow->wiki_user_email;
		}
		return null;
	}

	/**
	 * @return array
	 */
	public function getGroups() {
		# @todo FIXME: Untested.
		$groups = array();
		$res = $this->mDb->select(
			'wiki_user_groups',
			'ug_group',
			array( 'ug_wiki_user' => $this->mRow->wiki_user_id ),
			__METHOD__
		);
		foreach ( $res as $row ) {
			$groups[] = $row->ug_group;
		}
		return $groups;
	}

	# TODO: Implement setPref().
}
