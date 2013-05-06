ALTER TABLE revision DROP CONSTRAINT revision_rev_wiki_user_fkey;
ALTER TABLE revision ADD CONSTRAINT revision_rev_wiki_user_fkey
  FOREIGN KEY (rev_wiki_user) REFERENCES mwwiki_user(wiki_user_id) ON DELETE RESTRICT;

