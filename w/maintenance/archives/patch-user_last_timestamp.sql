-- For getting diff since last view
ALTER TABLE /*$wgDBprefix*/wiki_user_newtalk
  ADD wiki_user_last_timestamp varbinary(14) NULL default NULL;
