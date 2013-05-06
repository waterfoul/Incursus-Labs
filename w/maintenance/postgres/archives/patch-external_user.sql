CREATE TABLE external_wiki_user (
  eu_local_id     INTEGER  NOT NULL  PRIMARY KEY,
  eu_external_id TEXT
);

CREATE UNIQUE INDEX eu_external_id ON external_wiki_user (eu_external_id);
