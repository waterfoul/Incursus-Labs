-- Add a 'real name' field where wiki_users can specify the name they want
-- used for author attribution or other places that real names matter.

ALTER TABLE wiki_user 
        ADD (wiki_user_real_name varchar(255) binary NOT NULL default '');
