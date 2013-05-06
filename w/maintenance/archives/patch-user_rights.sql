-- Split wiki_user table into two parts:
--   wiki_user
--   wiki_user_rights
-- The later contains only the permissions of the wiki_user. This way,
-- you can store the accounts for several wikis in one central
-- database but keep wiki_user rights local to the wiki.

CREATE TABLE /*$wgDBprefix*/wiki_user_rights (
  -- Key to wiki_user_id
  ur_wiki_user int unsigned NOT NULL,
  
  -- Comma-separated list of permission keys
  ur_rights tinyblob NOT NULL,
  
  UNIQUE KEY ur_wiki_user (ur_wiki_user)

) /*$wgDBTableOptions*/;

INSERT INTO /*$wgDBprefix*/wiki_user_rights SELECT wiki_user_id,wiki_user_rights FROM /*$wgDBprefix*/wiki_user;

ALTER TABLE /*$wgDBprefix*/wiki_user DROP COLUMN wiki_user_rights;
