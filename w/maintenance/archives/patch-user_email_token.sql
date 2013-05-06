--
-- E-mail confirmation token and expiration timestamp,
-- for verification of e-mail addresses.
--
-- 2005-04-25
--

ALTER TABLE /*$wgDBprefix*/wiki_user
  ADD COLUMN wiki_user_email_authenticated binary(14),
  ADD COLUMN wiki_user_email_token binary(32),
  ADD COLUMN wiki_user_email_token_expires binary(14),
  ADD INDEX (wiki_user_email_token);
