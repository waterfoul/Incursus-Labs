ALTER TABLE /*_*/external_wiki_user
CHANGE COLUMN eu_wiki_id
eu_local_id int unsigned NOT NULL;
