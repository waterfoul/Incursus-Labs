-- Adds the ipb_expiry field to ipblocks

ALTER TABLE /*$wgDBprefix*/ipblocks ADD ipb_expiry varbinary(14) NOT NULL default '';

-- All IP blocks have one day expiry
UPDATE /*$wgDBprefix*/ipblocks SET ipb_expiry = date_format(date_add(ipb_timestamp,INTERVAL 1 DAY),"%Y%m%d%H%i%s") WHERE ipb_wiki_user = 0;

-- Null string is fine for wiki_user blocks, since this indicates infinity
