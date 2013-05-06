define mw_prefix='{$wgDBprefix}';

ALTER TABLE &mw_prefix.wiki_user_properties MODIFY up_property varchar2(255);
