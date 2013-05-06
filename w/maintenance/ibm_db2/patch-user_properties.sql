CREATE TABLE wiki_user_properties (
  -- Foreign key to wiki_user.wiki_user_id
  up_wiki_user BIGINT NOT NULL,
  
  -- Name of the option being saved. This is indexed for bulk lookup.
  up_property VARCHAR(32) FOR BIT DATA NOT NULL,
  
  -- Property value as a string.
  up_value CLOB(64K) INLINE LENGTH 4096
);
