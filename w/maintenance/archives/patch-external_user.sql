CREATE TABLE /*_*/external_wiki_user (
  -- Foreign key to wiki_user_id
  eu_local_id int unsigned NOT NULL PRIMARY KEY,

  -- Some opaque identifier provided by the external database
  eu_external_id varchar(255) binary NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/eu_external_id ON /*_*/external_wiki_user (eu_external_id);
