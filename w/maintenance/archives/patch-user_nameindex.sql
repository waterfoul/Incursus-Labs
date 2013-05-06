--
-- Change the index on wiki_user_name to a unique index to prevent
-- duplicate registrations from creeping in.
--
-- Run maintenance/wiki_userDupes.php or through the updater first
-- to clean up any prior duplicate accounts.
--
-- Added 2005-06-05
--

     ALTER TABLE /*$wgDBprefix*/wiki_user
      DROP INDEX wiki_user_name,
ADD UNIQUE INDEX wiki_user_name(wiki_user_name);
