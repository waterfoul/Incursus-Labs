define mw_prefix='{$wgDBprefix}';

CREATE INDEX &mw_prefix.mwwiki_user_i02 ON &mw_prefix.mwwiki_user (wiki_user_email);

