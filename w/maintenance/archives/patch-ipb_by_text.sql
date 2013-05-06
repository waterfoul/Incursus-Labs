-- Adding colomn with wiki_username of blocker and sets it.
-- Required for crosswiki blocks.

ALTER TABLE /*$wgDBprefix*/ipblocks
	ADD ipb_by_text varchar(255) binary NOT NULL default '';

UPDATE /*$wgDBprefix*/ipblocks 
	JOIN /*$wgDBprefix*/wiki_user ON ipb_by = wiki_user_id
	SET ipb_by_text = wiki_user_name
	WHERE ipb_by != 0;