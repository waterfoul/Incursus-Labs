<?php

/**
 * Copyright (c) 2010.,
 *   Vitaliy Filippov <vitalif[d.o.g]mail.ru>
 *   Stas Fomin <stas.fomin[d.o.g]yandex.ru>
 *
 * This file is part of IntraACL MediaWiki extension
 * http://wiki.4intra.net/IntraACL
 *
 * Loosely based on HaloACL (c) 2009, ontoprise GmbH
 *
 * The IntraACL-Extension is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The IntraACL-Extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class IntraACL_SQL_Groups
{
    private function getDBConn(&$bb, &$wiki, &$tables)
    {
        global $wgAuth;
	$bb = $wgAuth->connect($wiki);
	$tables["group"]=$wgAuth->_GroupsTB;
	$tables["wiki_users"]=$wgAuth->_wiki_userTB;
	$tables["wiki_usergroups"]=$wgAuth->_wiki_user_GroupTB;
    }
    /**
     * Returns the name of the group with the ID $groupID.
     *
     * @param int $groupID
     *         ID of the group whose name is requested
     *
     * @return string
     *         Name of the group with the given ID or <NULL> if there is no such
     *         group defined in the database.
     */
    public function groupNameForID($groupID)
    {
	$this->getDBConn($bb, $wiki, $tables);
	$qry = mysql_query("SELECT group_name FROM " . $tables["group"] . " WHERE group_id = '" . mysql_real_escape_string($groupID) . "'");
	$groupName = mysql_fetch_object($qry)->group_name;
        return $groupName;
    }

    /**
     * Saves the given group in the database.
     * @param HACLGroup $group
     *        This object defines the group that wil be saved.
     */
    public function saveGroup(HACLGroup $group)
    {
    }

    /**
     * Retrieves all groups from the database.
     * [name contains $text]
     * [name does not contain $nottext]
     * [maximum $limit]
     *
     * @return Array
     *         Array of Group Objects
     */
    public function getGroups($text = NULL, $nottext = NULL, $limit = NULL, $as_object = false)
    {
	$this->getDBConn($bb, $wiki, $tables);

        $options = array('ORDER BY' => 'group_name');
        if ($limit !== NULL)
            $options['LIMIT'] = $limit;
        $where = array();
        if (strlen($text))
            $where[] = 'group_name LIKE "%' . mysql_real_escape_string($text) . '%"';
        if (strlen($nottext))
            $where[] = 'group_name NOT LIKE "%' . mysql_real_escape_string($nottext) . '%"';
	$qry = "SELECT group_name, group_id FROM " . $tables["group"];
	if(count($where) != 0)
		$qry .= " WHERE " . implode(" AND ", $where);
	foreach($options as $i => $v)
		$qry .= " " . $i . " " . $v;
        $qry = mysql_query($qry, $bb);
        $groups = array();
        if ($as_object)
        {
            while ($row = mysql_fetch_object($qry))
            {
                $groupID = $row->group_id;
                $groupName = $row->group_name;
                $mgGroups = array(5);
                $mgwiki_users = array();
                $groups[] = new HACLGroup($groupID, $groupName, $mgGroups, $mgwiki_users);
            }
        }
        else
        {
            while ($row = mysql_fetch_array($qry))
	    {
		$rowArray = array();
		$rowArray[0] = $row["group_id"];
		$rowArray["group_id"] = $rowArray[0];
		$rowArray[1] = $row["group_name"];
                $rowArray["group_name"] = $rowArray[1];
		$rowArray[2] = "5";
                $rowArray["mg_groups"] = $rowArray[2];
		$rowArray[3] = "";
                $rowArray["mg_wiki_users"] = $rowArray[3];
                $groups[] = $rowArray;
	    }
        }
        return $groups;
    }

    /**
     * Retrieves the description of the group with the name $groupName from
     * the database.
     *
     * @param string $groupName
     *         Name of the requested group.
     *
     * @return HACLGroup
     *         A new group object or <NULL> if there is no such group in the
     *         database.
     *
     */
    public function getGroupByName($groupName) {
	if($groupName == "/")
	    return -1;
	$groupName = explode("/", $groupName);
	if(count($groupName)>1)
		$groupName = $groupName[1];
	else
		$groupName = $groupName[0];
	IntraACL_SQL_Groups::getDBConn($bb, $wiki, $tables);
        $qry = mysql_query("SELECT group_name, group_id FROM " . $tables["group"] . " WHERE group_name = '" . mysql_real_escape_string($groupName) . "'");
        $group = NULL;

        if ($row = mysql_fetch_object($qry)){
            $groupID = $row->group_id;
            $mgGroups = array(5);
            $mgwiki_users  = array();

            $group = new HACLGroup($groupID, $groupName, $mgGroups, $mgwiki_users);
        }

        return $group;
    }

    /**
     * Retrieves the description of the group with the ID $groupID from
     * the database.
     *
     * @param int $groupID
     *         ID of the requested group.
     *
     * @return HACLGroup
     *         A new group object or <NULL> if there is no such group in the
     *         database.
     *
     */
    public function getGroupByID($groupID) {
	IntraACL_SQL_Groups::getDBConn($bb, $wiki, $tables);
        $qry = mysql_query("SELECT group_name, group_id FROM " . $tables["group"] . " WHERE group_id = '" . mysql_real_escape_string($groupID) . "'");
        $group = NULL;

        if ($row = mysql_fetch_object($qry)){
            $groupID = $row->group_id;
	    $groupName = $row->group_name;
            $mgGroups = array(5);
            $mgwiki_users  = array();

            $group = new HACLGroup($groupID, $groupName, $mgGroups, $mgwiki_users);
        }

        return $group;
    }

    /**
     * Adds the wiki_user with the ID $wiki_userID to the group with the ID $groupID.
     *
     * @param int $groupID
     *         The ID of the group to which the wiki_user is added.
     * @param int $wiki_userID
     *         The ID of the wiki_user who is added to the group.
     *
     */
    public function addwiki_userToGroup($groupID, $wiki_userID) {
    }

    /**
     * Adds the group with the ID $childGroupID to the group with the ID
     * $parentGroupID.
     *
     * @param $parentGroupID
     *         The group with this ID gets the new child with the ID $childGroupID.
     * @param $childGroupID
     *         The group with this ID is added as child to the group with the ID
     *      $parentGroup.
     *
     */
    public function addGroupToGroup($parentGroupID, $childGroupID) {
    }

    /**
     * Removes the wiki_user with the ID $wiki_userID from the group with the ID $groupID.
     *
     * @param $groupID
     *         The ID of the group from which the wiki_user is removed.
     * @param int $wiki_userID
     *         The ID of the wiki_user who is removed from the group.
     *
     */
    public function removewiki_userFromGroup($groupID, $wiki_userID) {
    }

    /**
     * Removes all members from the group with the ID $groupID.
     *
     * @param $groupID
     *         The ID of the group from which the wiki_user is removed.
     *
     */
    public function removeAllMembersFromGroup($groupID) {
    }

    /**
     * Removes the group with the ID $childGroupID from the group with the ID
     * $parentGroupID.
     *
     * @param $parentGroupID
     *         This group loses its child $childGroupID.
     * @param $childGroupID
     *         This group is removed from $parentGroupID.
     *
     */
    public function removeGroupFromGroup($parentGroupID, $childGroupID) {
    }

    /**
     * Returns the IDs of all wiki_users or groups that are a member of the group
     * with the ID $groupID.
     *
     * @param string $memberType
     *         'wiki_user' => ask for all wiki_user IDs
     *         'group' => ask for all group IDs
     * @return array(int)
     *         List of IDs of all direct wiki_users or groups in this group.
     *
     */
    public function getMembersOfGroup($groupID, $memberType)
    {
	if($memberType == 'group')
	    return array();
	
	$this->getDBConn($bb, $wiki, $tables);
        $qry = mysql_query("SELECT b.login_name_clean FROM " . $tables["wiki_usergroups"] . " as a JOIN " . $tables["wiki_users"] . " AS b ON a.wiki_user_id = b.wiki_user_id WHERE a.group_id = '" . mysql_real_escape_string($groupID) . "'", $bb);

        $members = array();
        while ($row = mysql_fetch_object($qry))
	{
	    $qry2 = mysql_query("SELECT wiki_user_id FROM wiki_user WHERE wiki_user_name = '" . $row->login_name_clean . "'");
	    if($row2 = $mysql_fetch_object($qry2))
            	$members[] = (int) $row2->wiki_user_id;
	}

        r->freeResult($res);

        return $members;
    }

    /**
     * Massively retrieve members of groups with IDs $ids
     */
    public function getMembersOfGroups($ids)
    {
        if (!$ids)
            return array();
	$members = array();
	foreach($ids as $id)
		$members[$id]["wiki_user"] = getMembersOfGroup($id,"wiki_user");
        return $members;
    }

    /**
     * Returns all groups the wiki_user is member of
     *
     * @param  string $memberType: 'wiki_user' or 'group'
     * @param  int $memberID: ID of asked wiki_user or group
     * @param  boolean $recurse: recursive or no
     * @return array(int): parent group IDs
     */
    public function getGroupsOfMember($memberType, $memberID, $recurse = true)
    {
	if($memberType = 'group')
	    return array();
	
	$this->getDBConn($bb, $wiki, $tables);
        $qry = mysql_query("SELECT group_id FROM " . $tables["wiki_usergroups"] . " WHERE wiki_user_id = '" . mysql_real_escape_string($memberID) . "'", $bb);

        $members = array();
        while ($row = mysql_fetch_object($qry))
        {
	    $members[] = $row->group_id;
        }

        return $members;
    }

    /**
     * Checks if the given wiki_user or group with the ID $childID belongs to the
     * group with the ID $parentID.
     *
     * @param int $parentID
     *         ID of the group that is checked for a member.
     *
     * @param int $childID
     *         ID of the group or wiki_user that is checked for membership.
     *
     * @param string $memberType
     *         HACLGroup::USER  : Checks for membership of a wiki_user
     *         HACLGroup::GROUP : Checks for membership of a group
     *
     * @param bool recursive
     *         <true>, checks recursively among all children of this $parentID if
     *                 $childID is a member
     *         <false>, checks only if $childID is an immediate member of $parentID
     *
     * @return bool
     *         <true>, if $childID is a member of $parentID
     *         <false>, if not
     *
     */
    public function hasGroupMember($parentID, $childID, $memberType, $recursive)
    {
	if($memberType == HACLGroup::GROUP)
	    return array();
	$this->getDBConn($bb, $wiki, $tables);
        $qry = mysql_query("SELECT group_id FROM " . $tables["wiki_usergroups"] . " WHERE group_id = '" . mysql_real_escape_string($parentID) . "' AND user_id = '" . mysql_real_escape_string($childID) . "'");
        $group = NULL;
print(mysql_error());
        if ($row = mysql_fetch_object($qry)){
            $groupID = $row->group_id;
            $mgGroups = array(5);
            $mgwiki_users  = array();

            $group = new HACLGroup($groupID, $groupName, $mgGroups, $mgwiki_users);
        }

        return $group;
    }

    public function getGroupMembersRecursive($groupID, $children = array())
    {
	return getMembersOfGroup($groupID,"wiki_user");
    }

    /**
     * Massively retrieves IntraACL groups with $group_ids from the DB
     * If $group_ids is NULL, retrieves ALL groups
     * @return array(group_id => row)
     */
    public function getGroupsByIds($group_ids)
    {
        if (!$group_ids)
            return array();
	$groups = array();
	foreach($group_ids as $id)
	    $groups[$id] = getGroupByID($id);
	return $groups;
    }

    /**
     * Deletes the group with the ID $groupID from the database. All references
     * to the group in the hierarchy of groups are deleted as well.
     *
     * However, the group is not removed from any rights, security descriptors etc.
     * as this would mean that articles will have to be changed.
     *
     *
     * @param int $groupID
     *         ID of the group that is removed from the database.
     *
     */
    public function deleteGroup($groupID) {
    }

    /**
     * Checks if the group with the ID $groupID exists in the database.
     *
     * @param int $groupID
     *         ID of the group
     *
     * @return bool
     *         <true> if the group exists
     *         <false> otherwise
     */
    public function groupExists($groupID)
    {
	$this->getDBConn($bb, $wiki, $tables);
        $qry = mysql_query("SELECT group_name, group_id FROM " . $tables["group"] . " WHERE group_id = '" . mysql_real_escape_string($groupID) . "'");
        $group = NULL;

        if ($row = mysql_fetch_object($qry)){
	    return true;
        }
	
	return false;

    }
}
