-- Add the logging table and adjust recentchanges to accomodate special pages
-- 2004-08-24

CREATE TABLE /*$wgDBprefix*/logging (
  -- Symbolic keys for the general log type and the action type
  -- within the log. The output format will be controlled by the
  -- action field, but only the type controls categorization.
  log_type varbinary(10) NOT NULL default '',
  log_action varbinary(10) NOT NULL default '',
  
  -- Timestamp. Duh.
  log_timestamp binary(14) NOT NULL default '19700101000000',
  
  -- The wiki_user who performed this action; key to wiki_user_id
  log_wiki_user int unsigned NOT NULL default 0,
  
  -- Key to the page affected. Where a wiki_user is the target,
  -- this will point to the wiki_user page.
  log_namespace int NOT NULL default 0,
  log_title varchar(255) binary NOT NULL default '',
  
  -- Freeform text. Interpreted as edit history comments.
  log_comment varchar(255) NOT NULL default '',
  
  -- LF separated list of miscellaneous parameters
  log_params blob NOT NULL,

  KEY type_time (log_type, log_timestamp),
  KEY wiki_user_time (log_wiki_user, log_timestamp),
  KEY page_time (log_namespace, log_title, log_timestamp)

) /*$wgDBTableOptions*/;


-- Change from unsigned to signed so we can store special pages
ALTER TABLE recentchanges
  MODIFY rc_namespace tinyint(3) NOT NULL default '0';
