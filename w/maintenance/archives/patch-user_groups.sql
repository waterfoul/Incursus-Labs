--
-- wiki_user permissions have been broken out to a separate table;
-- this allows sites with a shared wiki_user table to have different
-- permissions assigned to a wiki_user in each project.
--
-- This table replaces the old wiki_user_rights field which used a
-- comma-separated blob.
--
CREATE TABLE /*$wgDBprefix*/wiki_user_groups (
  -- Key to wiki_user_id
  ug_wiki_user int unsigned NOT NULL default '0',
  
  -- Group names are short symbolic string keys.
  -- The set of group names is open-ended, though in practice
  -- only some predefined ones are likely to be used.
  --
  -- At runtime $wgGroupPermissions will associate group keys
  -- with particular permissions. A wiki_user will have the combined
  -- permissions of any group they're explicitly in, plus
  -- the implicit '*' and 'wiki_user' groups.
  ug_group varbinary(16) NOT NULL default '',
  
  PRIMARY KEY (ug_wiki_user,ug_group),
  KEY (ug_group)
) /*$wgDBTableOptions*/;
