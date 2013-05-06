-- Stores the groups the wiki_user has once belonged to. 
-- The wiki_user may still belong these groups. Check wiki_user_groups.
CREATE TABLE /*_*/wiki_user_former_groups (
  -- Key to wiki_user_id
  ufg_wiki_user int unsigned NOT NULL default 0,
  ufg_group varbinary(32) NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ufg_wiki_user_group ON /*_*/wiki_user_former_groups (ufg_wiki_user,ufg_group);
