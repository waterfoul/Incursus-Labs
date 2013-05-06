
-- Relation table between wiki_user and groups
CREATE TABLE /*$wgDBprefix*/wiki_user_groups (
	ug_wiki_user int unsigned NOT NULL default '0',
	ug_group varbinary(16) NOT NULL default '0',
	PRIMARY KEY  (ug_wiki_user,ug_group)
  KEY (ug_group)
) /*$wgDBTableOptions*/;
