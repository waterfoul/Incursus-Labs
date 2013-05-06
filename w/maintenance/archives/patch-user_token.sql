-- wiki_user_token patch
-- 2004-09-23

ALTER TABLE /*$wgDBprefix*/wiki_user ADD wiki_user_token  binary(32) NOT NULL default '';

UPDATE /*$wgDBprefix*/wiki_user SET wiki_user_token = concat(
	substring(rand(),3,4),
	substring(rand(),3,4),
	substring(rand(),3,4),
	substring(rand(),3,4),
	substring(rand(),3,4),
	substring(rand(),3,4),
	substring(rand(),3,4),
	substring(rand(),3,4)
);
