-- Timestamp of the last time when a new password was
-- sent, for throttling purposes
ALTER TABLE /*$wgDBprefix*/wiki_user ADD wiki_user_newpass_time binary(14);

