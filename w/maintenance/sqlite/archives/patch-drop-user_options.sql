-- Remove wiki_user_options field from wiki_user table

CREATE TABLE /*_*/wiki_user_tmp (
  wiki_user_id int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  wiki_user_name varchar(255) binary NOT NULL default '',
  wiki_user_real_name varchar(255) binary NOT NULL default '',
  wiki_user_password tinyblob NOT NULL,
  wiki_user_newpassword tinyblob NOT NULL,
  wiki_user_newpass_time binary(14),
  wiki_user_email tinytext NOT NULL,
  wiki_user_touched binary(14) NOT NULL default '',
  wiki_user_token binary(32) NOT NULL default '',
  wiki_user_email_authenticated binary(14),
  wiki_user_email_token binary(32),
  wiki_user_email_token_expires binary(14),
  wiki_user_registration binary(14),
  wiki_user_editcount int
) /*$wgDBTableOptions*/;

INSERT INTO /*_*/wiki_user_tmp
	SELECT wiki_user_id, wiki_user_name, wiki_user_real_name, wiki_user_password, wiki_user_newpassword, wiki_user_newpass_time, wiki_user_email, wiki_user_touched,
		wiki_user_token, wiki_user_email_authenticated, wiki_user_email_token, wiki_user_email_token_expires, wiki_user_registration, wiki_user_editcount
		FROM /*_*/wiki_user;

DROP TABLE /*_*/wiki_user;

ALTER TABLE /*_*/wiki_user_tmp RENAME TO /*_*/wiki_user;

CREATE UNIQUE INDEX /*i*/wiki_user_name ON /*_*/wiki_user (wiki_user_name);
CREATE INDEX /*i*/wiki_user_email_token ON /*_*/wiki_user (wiki_user_email_token);
CREATE INDEX /*i*/wiki_user_email ON /*_*/wiki_user (wiki_user_email(50));
