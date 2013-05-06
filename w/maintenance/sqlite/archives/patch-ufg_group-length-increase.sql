CREATE TABLE /*_*/wiki_user_former_groups_tmp (
  ug_wiki_user int unsigned NOT NULL default 0,
  ug_group varbinary(32) NOT NULL default ''
) /*$wgDBTableOptions*/;

INSERT INTO /*_*/wiki_user_former_groups_tmp
	SELECT ug_wiki_user, ug_group
		FROM /*_*/wiki_user_groups;

DROP TABLE /*_*/wiki_user_former_groups;

ALTER TABLE /*_*/wiki_user_former_groups_tmp RENAME TO /*_*/wiki_user_former_groups;

CREATE UNIQUE INDEX /*i*/ufg_wiki_user_group ON /*_*/wiki_user_former_groups (ufg_wiki_user,ufg_group);

