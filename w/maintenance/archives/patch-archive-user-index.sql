-- Adds a wiki_user,timestamp index to the archive table
-- Used for browsing deleted contributions and renames
ALTER TABLE /*$wgDBprefix*/archive 
	ADD INDEX wiki_usertext_timestamp ( ar_wiki_user_text , ar_timestamp );
