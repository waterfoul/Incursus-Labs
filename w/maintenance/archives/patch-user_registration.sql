--
-- New wiki_user field for tracking registration time
-- 2005-12-21
--

ALTER TABLE /*$wgDBprefix*/wiki_user
  -- Timestamp of account registration.
  -- Accounts predating this schema addition may contain NULL.
  ADD wiki_user_registration binary(14);
