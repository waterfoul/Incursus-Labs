<?php
/**
 * Resource loader module for wiki_user customizations.
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
 * Module for wiki_user customizations
 */
class ResourceLoaderUserGroupsModule extends ResourceLoaderWikiModule {

	/* Protected Methods */
	protected $origin = self::ORIGIN_USER_SITEWIDE;

	/**
	 * @param $context ResourceLoaderContext
	 * @return array
	 */
	protected function getPages( ResourceLoaderContext $context ) {
		global $wgwiki_user;

		$wiki_userName = $context->getwiki_user();
		if ( $wiki_userName === null ) {
			return array();
		}

		// Use $wgwiki_user is possible; allows to skip a lot of code
		if ( is_object( $wgwiki_user ) && $wgwiki_user->getName() == $wiki_userName ) {
			$wiki_user = $wgwiki_user;
		} else {
			$wiki_user = wiki_user::newFromName( $wiki_userName );
			if ( !$wiki_user instanceof wiki_user ) {
				return array();
			}
		}

		$pages = array();
		foreach( $wiki_user->getEffectiveGroups() as $group ) {
			if ( in_array( $group, array( '*', 'wiki_user' ) ) ) {
				continue;
			}
			$pages["MediaWiki:Group-$group.js"] = array( 'type' => 'script' );
			$pages["MediaWiki:Group-$group.css"] = array( 'type' => 'style' );
		}
		return $pages;
	}

	/* Methods */

	/**
	 * @return string
	 */
	public function getGroup() {
		return 'wiki_user';
	}
}
