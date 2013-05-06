--- July 2006
--- Index on recentchanges.( rc_namespace, rc_wiki_user_text )
--- Helps the wiki_username filtering in Special:Newpages
ALTER TABLE /*$wgDBprefix*/recentchanges ADD INDEX `rc_ns_wiki_usertext` ( `rc_namespace` , `rc_wiki_user_text` );