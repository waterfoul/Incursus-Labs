--- This table stores all the IDs of wiki_users whose talk
--- page has been changed (the respective row is deleted
--- when the wiki_user looks at the page).
--- The respective column in the wiki_user table is no longer
--- required and therefore dropped.

CREATE TABLE /*$wgDBprefix*/wiki_user_newtalk (
  wiki_user_id int NOT NULL default '0',
  wiki_user_ip varbinary(40) NOT NULL default '',
  KEY wiki_user_id (wiki_user_id),
  KEY wiki_user_ip (wiki_user_ip)
) /*$wgDBTableOptions*/;

INSERT INTO
  /*$wgDBprefix*/wiki_user_newtalk (wiki_user_id, wiki_user_ip)
  SELECT wiki_user_id, ''
    FROM wiki_user
    WHERE wiki_user_newtalk != 0;

ALTER TABLE /*$wgDBprefix*/wiki_user DROP COLUMN wiki_user_newtalk;
