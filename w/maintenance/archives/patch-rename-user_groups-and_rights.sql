
ALTER TABLE /*$wgDBprefix*/wiki_user_groups
	CHANGE wiki_user_id ug_wiki_user INT UNSIGNED NOT NULL DEFAULT '0',
	CHANGE group_id ug_group INT UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE /*$wgDBprefix*/wiki_user_rights
	CHANGE wiki_user_id ur_wiki_user INT UNSIGNED NOT NULL,
	CHANGE wiki_user_rights ur_rights TINYBLOB NOT NULL;

