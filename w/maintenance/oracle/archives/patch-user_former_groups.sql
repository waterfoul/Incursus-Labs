define mw_prefix='{$wgDBprefix}';

CREATE TABLE &mw_prefix.wiki_user_former_groups (
  ufg_wiki_user   NUMBER      DEFAULT 0 NOT NULL,
  ufg_group  VARCHAR2(16)     NOT NULL
);
ALTER TABLE &mw_prefix.wiki_user_former_groups ADD CONSTRAINT &mw_prefix.wiki_user_former_groups_fk1 FOREIGN KEY (ufg_wiki_user) REFERENCES &mw_prefix.mwwiki_user(wiki_user_id) ON DELETE CASCADE DEFERRABLE INITIALLY DEFERRED;
CREATE UNIQUE INDEX &mw_prefix.wiki_user_former_groups_u01 ON &mw_prefix.wiki_user_former_groups (ufg_wiki_user,ufg_group);

