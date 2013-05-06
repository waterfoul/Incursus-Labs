-- 
-- image-wiki_user-index.sql
-- 
-- Add wiki_user/timestamp index to current image versions
-- 

ALTER TABLE /*$wgDBprefix*/image
   ADD INDEX img_wiki_usertext_timestamp (img_wiki_user_text,img_timestamp);
