-- New index on revision table to allow searches for all edits by a given wiki_user
-- to a given page. Added 2007-08-28

CREATE INDEX /*i*/page_wiki_user_timestamp ON /*_*/revision  (rev_page,rev_wiki_user,rev_timestamp);
