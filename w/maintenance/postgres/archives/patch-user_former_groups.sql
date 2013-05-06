CREATE TABLE wiki_user_former_groups (
  ufg_wiki_user   INTEGER      NULL  REFERENCES mwwiki_user(wiki_user_id) ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED,
  ufg_group  TEXT     NOT NULL
);
CREATE UNIQUE INDEX ufg_wiki_user_group ON wiki_user_former_groups (ufg_wiki_user, ufg_group);
