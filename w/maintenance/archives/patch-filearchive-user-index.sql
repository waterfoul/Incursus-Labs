-- Adding index to sort by uploader
ALTER TABLE /*$wgDBprefix*/filearchive 
  ADD INDEX fa_wiki_user_timestamp (fa_wiki_user_text,fa_timestamp),
  -- Remove useless, incomplete index
  DROP INDEX fa_deleted_wiki_user;
