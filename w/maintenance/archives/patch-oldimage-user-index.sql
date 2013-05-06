-- 
-- oldimage-wiki_user-index.sql
-- 
-- Add wiki_user/timestamp index to old image versions
-- 

ALTER TABLE /*$wgDBprefix*/oldimage
   ADD INDEX oi_wiki_usertext_timestamp (oi_wiki_user_text,oi_timestamp);
