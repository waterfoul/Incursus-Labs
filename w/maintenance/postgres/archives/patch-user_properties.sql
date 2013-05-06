CREATE TABLE wiki_user_properties(
  up_wiki_user   INTEGER      NULL  REFERENCES mwwiki_user(wiki_user_id) ON DELETE CASCADE,
  up_property TEXT NOT NULL,
  up_value TEXT
);

CREATE UNIQUE INDEX wiki_user_properties_wiki_user_property on wiki_user_properties (up_wiki_user,up_property);
CREATE INDEX wiki_user_properties_property on wiki_user_properties (up_property);
