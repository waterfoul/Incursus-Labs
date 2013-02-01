CREATE TABLE utilAccessMask (
`section`                VARCHAR(8) NOT NULL,
`api`                    VARCHAR(32) NOT NULL,
`description`            TEXT,
`mask`                   BIGINT(20) UNSIGNED NOT NULL,
`status`                 TINYINT UNSIGNED NOT NULL,
                 PRIMARY KEY (`section`, `api`)
) ENGINE = InnoDB COLLATE = ascii_general_ci;
CREATE TABLE utilCachedInterval (
`section`                VARCHAR(8) NOT NULL,
`api`                    VARCHAR(32) NOT NULL,
`interval`               INTEGER UNSIGNED NOT NULL,
                 PRIMARY KEY (`section`, `api`)
) ENGINE = InnoDB COLLATE = ascii_general_ci;
CREATE TABLE utilCachedUntil (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`api`                    VARCHAR(32) NOT NULL,
`cachedUntil`            DATETIME NOT NULL,
`section`                VARCHAR(8) NOT NULL,
                 PRIMARY KEY (`ownerID`, `api`)
) ENGINE = InnoDB COLLATE = ascii_general_ci;
CREATE TABLE utilGraphic (
`graphic`                LONGBLOB,
`graphicType`            VARCHAR(4),
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`ownerType`              VARCHAR(4),
                 PRIMARY KEY (`ownerID`)
) ENGINE = InnoDB COLLATE = ascii_general_ci;
ALTER TABLE utilGraphic ADD  INDEX `utilGraphic1`  (`OwnerType`);
CREATE TABLE utilRegisteredCharacter (
`activeAPIMask`          BIGINT(20) UNSIGNED,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(100),
`isActive`               TINYINT(1),
`proxy`                  VARCHAR(255),
                 PRIMARY KEY (`characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE utilRegisteredCorporation (
`activeAPIMask`          BIGINT(20) UNSIGNED,
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(150),
`isActive`               TINYINT(1),
`proxy`                  VARCHAR(255),
                 PRIMARY KEY (`corporationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE utilRegisteredKey (
`activeAPIMask`          BIGINT(20) UNSIGNED,
`isActive`               TINYINT(1),
`keyID`                  BIGINT(20) UNSIGNED NOT NULL,
`proxy`                  VARCHAR(255),
`vCode`                  VARCHAR(64) NOT NULL,
                 PRIMARY KEY (`keyID`)
) ENGINE = InnoDB COLLATE = ascii_general_ci;
CREATE TABLE utilRegisteredUploader (
`isActive`               TINYINT(1),
`key`                    VARCHAR(255),
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`uploadDestinationID`    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `uploadDestinationID`)
);
CREATE TABLE utilSections (
`activeAPIMask`          BIGINT(20) UNSIGNED NOT NULL,
`isActive`               TINYINT(1) NOT NULL,
`proxy`                  VARCHAR(255),
`sectionID`              BIGINT(20) UNSIGNED NOT NULL,
`section`                VARCHAR(8),
                 PRIMARY KEY (`sectionID`)
) ENGINE = InnoDB COLLATE = ascii_general_ci;
ALTER TABLE utilSections ADD  INDEX `utilSection1`  (`section`);
CREATE TABLE utilUploadDestination (
`isActive`               TINYINT(1),
`name`                   VARCHAR(25),
`uploadDestinationID`    BIGINT(20) UNSIGNED NOT NULL,
`url`                    VARCHAR(255),
                 PRIMARY KEY (`uploadDestinationID`)
);
CREATE TABLE utilXmlCache (
`hash`                   VARCHAR(40) NOT NULL,
`api`                    VARCHAR(32) NOT NULL,
`modified`               DATETIME,
`section`                VARCHAR(8) NOT NULL,
`xml`                    LONGTEXT,
                 PRIMARY KEY (`hash`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE utilXmlCache ADD  INDEX `utilXmlCache1`  (`section`);
ALTER TABLE utilXmlCache ADD  INDEX `utilXmlCache2`  (`api`);
ALTER TABLE `utilGraphic` MODIFY `graphic` MEDIUMBLOB DEFAULT NULL;
ALTER TABLE `utilXmlCache` MODIFY `api` CHAR(32) COLLATE ascii_general_ci NOT NULL;
ALTER TABLE `utilXmlCache` MODIFY `modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
ALTER TABLE `utilXmlCache` MODIFY `hash` CHAR(40) COLLATE ascii_general_ci NOT NULL;
ALTER TABLE `utilXmlCache` MODIFY `xml` LONGTEXT;
TRUNCATE `utilAccessMask`;
INSERT INTO `utilAccessMask` (`mask`, `section`, `api`, `description`, `status`)
      VALUES
      (1, 'account', 'APIKeyInfo', 'Used to get information about a keyID', 16),
      (33554432, 'account', 'AccountStatus', 'EVE player account status.', 16);
INSERT INTO `utilAccessMask` (`mask`, `section`, `api`, `description`, `status`)
      VALUES
      (1, 'char', 'AccountBalance', 'Current balance of characters wallet.', 16),
      (2, 'char', 'AssetList', 'Entire asset list of character.', 16),
      (4, 'char', 'CalendarEventAttendees', 'Event attendee responses. Requires UpcomingCalendarEvents to function.', 2),
      (8, 'char', 'CharacterSheet', 'Character Sheet information. Contains basic "Show Info" information along with clones, account balance, implants, attributes, skills, certificates and corporation roles.', 16),
      (16, 'char', 'ContactList', 'List of character contacts and relationship levels.', 16),
      (32, 'char', 'ContactNotifications', 'Most recent contact notifications for the character.', 16),
      (64, 'char', 'FacWarStats', 'Characters Factional Warfare Statistics.', 8),
      (128, 'char', 'IndustryJobs', 'Character jobs, completed and active.', 16),
      (256, 'char', 'KillLog', 'Characters kill log.', 16),
      (512, 'char', 'MailBodies', 'EVE Mail bodies. Requires MailMessages as well to function.', 16),
      (1024, 'char', 'MailingLists', 'List of all Mailing Lists the character subscribes to.', 16),
      (2048, 'char', 'MailMessages', 'List of all messages in the characters EVE Mail Inbox.', 16),
      (4096, 'char', 'MarketOrders', 'List of all Market Orders the character has made.', 16),
      (8192, 'char', 'Medals', 'Medals awarded to the character.', 2),
      (16384, 'char', 'Notifications', 'List of recent notifications sent to the character.', 16),
      (32768, 'char', 'NotificationTexts', 'Actual body of notifications sent to the character. Requires Notification access to function.', 16),
      (65536, 'char', 'Research', 'List of all Research agents working for the character and the progress of the research.', 16),
      (131072, 'char', 'SkillInTraining', 'Skill currently in training on the character. Subset of entire Skill Queue.', 16),
      (262144, 'char', 'SkillQueue', 'Entire skill queue of character.', 16),
      (524288, 'char', 'Standings', 'NPC Standings towards the character.', 16),
      (1048576, 'char', 'UpcomingCalendarEvents', 'Upcoming events on characters calendar.', 2),
      (2097152, 'char', 'WalletJournal', 'Wallet journal of character.', 16),
      (4194304, 'char', 'WalletTransactions', 'Market transaction journal of character.', 16),
      (67108864, 'char', 'Contracts', 'List of all Contracts the character is involved in.', 16),
      (134217728, 'char', 'Locations', 'Allows the fetching of coordinate and name data for items owned by the character.', 1);
INSERT INTO `utilAccessMask` (`mask`, `section`, `api`, `description`, `status`)
      VALUES
      (1, 'corp', 'AccountBalance', 'Current balance of all corporation accounts.', 16),
      (2, 'corp', 'AssetList', 'List of all corporation assets.', 16),
      (4, 'corp', 'MemberMedals', 'List of medals awarded to corporation members.', 16),
      (8, 'corp', 'CorporationSheet', 'Exposes basic "Show Info" information as well as Member Limit and basic division and wallet info.', 16),
      (16, 'corp', 'ContactList', 'Corporate contact list and relationships.', 16),
      (32, 'corp', 'ContainerLog', 'Corporate secure container access log.', 16),
      (64, 'corp', 'FacWarStats', 'Corporations Factional Warfare Statistics.', 8),
      (128, 'corp', 'IndustryJobs', 'Corporation jobs, completed and active.', 16),
      (256, 'corp', 'KillLog', 'Corporation kill log.', 16),
      (512, 'corp', 'MemberSecurity', 'Member roles and titles.', 2),
      (1024, 'corp', 'MemberSecurityLog', 'Member role and title change log.', 2),
      (2048, 'corp', 'MemberTrackingLimited', 'Limited Member information.', 16),
      (4096, 'corp', 'MarketOrders', 'List of all corporate market orders.', 16),
      (8192, 'corp', 'Medals', 'List of all medals created by the corporation.', 16),
      (16384, 'corp', 'OutpostList', 'List of all outposts controlled by the corporation.', 16),
      (32768, 'corp', 'OutpostServiceDetail', 'List of all service settings of corporate outposts.', 16),
      (65536, 'corp', 'Shareholders', 'Shareholders of the corporation.', 2),
      (131072, 'corp', 'StarbaseDetail', 'List of all settings of corporate starbases.', 16),
      (262144, 'corp', 'Standings', 'NPC Standings towards corporation.', 16),
      (524288, 'corp', 'StarbaseList', 'List of all corporate starbases.', 16),
      (1048576, 'corp', 'WalletJournal', 'Wallet journal for all corporate accounts.', 16),
      (2097152, 'corp', 'WalletTransactions', 'Market transactions of all corporate accounts.', 16),
      (4194304, 'corp', 'Titles', 'Titles of corporation and the roles they grant.', 2),
      (8388608, 'corp', 'Contracts', 'List of recent Contracts the corporation is involved in.', 16),
      (16777216, 'corp', 'Locations', 'Allows the fetching of coordinate and name data for items owned by the corporation.', 1),
      (33554432, 'corp', 'MemberTracking', 'Extensive Member information. Time of last logoff, last known location and ship.', 16);
INSERT INTO `utilAccessMask` (`mask`, `section`, `api`, `description`, `status`)
      VALUES
      (1, 'eve', 'AllianceList', 'Returns a list of alliances in eve.', 16),
      (2, 'eve', 'CertificateTree', 'Returns a list of certificates in eve.', 1),
      (4, 'eve', 'CharacterID', 'Returns the ownerID for a given character, faction, alliance or corporation name, or the typeID for other objects such as stations, solar systems, planets, etc.', 1),
      (8, 'eve', 'CharacterName', 'Returns the name associated with an ownerID or a typeID.', 1),
      (16, 'eve', 'ConquerableStationList', 'Conquerable Station List including Outpost.', 16),
      (32, 'eve', 'ErrorList', 'Returns a list of error codes that can be returned by the EVE API servers.', 16),
      (64, 'eve', 'FacWarStats', 'Returns global stats on the factions in factional warfare including the number of pilots in each faction, the number of systems they control, and how many kills and victory points each and all factions obtained yesterday, in the last week, and total.', 16),
      (128, 'eve', 'FacWarTopStats', 'Returns Factional Warfare Top 100 Stats.', 16),
      (256, 'eve', 'RefTypes', 'Returns a list of transaction types used in the Journal Entries.', 16),
      (512, 'eve', 'SkillTree', 'XML of currently in-game skills (including unpublished skills).', 1),
      (0, 'eve', 'CharacterInfo', 'Character information, exposes skill points and current ship information on top of "Show Info" information.', 1),
      (8388608, 'eve', 'CharacterInfoPublic', 'Character information, exposes skill points and current ship information on top of "Show Info" information.', 1),
      (16777216, 'eve', 'CharacterInfoPrivate', 'Sensitive Character Information, exposes account balance and last known location on top of the other Character Information call.', 1);
INSERT INTO `utilAccessMask` (`mask`, `section`, `api`, `description`, `status`)
      VALUES
      (1, 'map', 'FacWarSystems', 'Returns a list of contestable solarsystems  and the NPC faction currently occupying them. It should be noted that this file only returns a non-zero ID if the occupying faction is not the sovereign faction.', 16),
      (2, 'map', 'Jumps', 'Returns a list of systems where any jumps have happened.', 16),
      (4, 'map', 'Kills', 'Returns the number of kills in solarsystems within the last hour. Only solar system where kills have been made are listed, so assume zero in case the system is not listed.', 16),
      (8, 'map', 'Sovereignty', 'Returns a list of solarsystems and what faction or alliance controls them. ', 16),
      (16, 'map', 'SovereigntyStatus', 'Returns a list of all sovereignty structures in EVE. This API has been disabled and is not expected to return but was included for completeness.', 1);
INSERT INTO `utilAccessMask` (`mask`, `section`, `api`, `description`, `status`)
      VALUES
      (1, 'server', 'ServerStatus', 'Returns current Eve server status and number of players online.', 16);
TRUNCATE `utilCachedInterval`;
INSERT INTO `utilCachedInterval` (`section`,`api`,`interval`)
      VALUES
      ('account', 'AccountStatus', 3600),
      ('account', 'APIKeyInfo', 300);
INSERT INTO `utilCachedInterval` (`section`,`api`,`interval`)
      VALUES
      ('char', 'AccountBalance', 900),
      ('char', 'AssetList', 21600),
      ('char', 'CalendarEventAttendees', 3600),
      ('char', 'CharacterSheet', 3600),
      ('char', 'ContactList', 900),
      ('char', 'ContactNotifications', 21600),
      ('char', 'Contracts', 900),
      ('char', 'FacWarStats', 3600),
      ('char', 'IndustryJobs', 900),
      ('char', 'KillLog', 3600),
      ('char', 'Locations', 3600),
      ('char', 'MailBodies', 1800),
      ('char', 'MailingLists', 21600),
      ('char', 'MailMessages', 1800),
      ('char', 'MarketOrders', 3600),
      ('char', 'Medals', 3600),
      ('char', 'Notifications', 1800),
      ('char', 'NotificationTexts', 1800),
      ('char', 'Research', 900),
      ('char', 'SkillInTraining', 300),
      ('char', 'SkillQueue', 900),
      ('char', 'Standings', 3600),
      ('char', 'UpcomingCalendarEvents', 900),
      ('char', 'WalletJournal', 1620),
      ('char', 'WalletTransactions', 3600);
INSERT INTO `utilCachedInterval` (`section`,`api`,`interval`)
      VALUES
      ('corp', 'AccountBalance', 900),
      ('corp', 'AssetList', 21600),
      ('corp', 'ContactList', 900),
      ('corp', 'ContainerLog', 3600),
      ('corp', 'Contracts', 900),
      ('corp', 'CorporationSheet', 21600),
      ('corp', 'FacWarStats', 3600),
      ('corp', 'IndustryJobs', 900),
      ('corp', 'KillLog', 3600),
      ('corp', 'Locations', 3600),
      ('corp', 'MarketOrders', 3600),
      ('corp', 'Medals', 3600),
      ('corp', 'MemberMedals', 3600),
      ('corp', 'MemberSecurity', 3600),
      ('corp', 'MemberSecurityLog', 3600),
      ('corp', 'MemberTracking', 21600),
      ('corp', 'OutpostList', 3600),
      ('corp', 'OutpostServiceDetail', 3600),
      ('corp', 'Shareholders', 3600),
      ('corp', 'Standings', 3600),
      ('corp', 'StarbaseDetail', 3600),
      ('corp', 'StarbaseList', 3600),
      ('corp', 'Titles', 3600),
      ('corp', 'WalletJournal', 1620),
      ('corp', 'WalletTransactions', 3600);
INSERT INTO `utilCachedInterval` (`section`,`api`,`interval`)
      VALUES
      ('eve', 'AllianceList', 3600),
      ('eve', 'CertificateTree', 86400),
      ('eve', 'CharacterInfo', 3600),
      ('eve', 'ConquerableStationList', 3600),
      ('eve', 'ErrorList', 86400),
      ('eve', 'FacWarStats', 3600),
      ('eve', 'FacWarTopStats', 3600),
      ('eve', 'RefTypes', 86400),
      ('eve', 'SkillTree', 86400);
INSERT INTO `utilCachedInterval` (`section`,`api`,`interval`)
      VALUES
      ('map', 'FacWarSystems', 3600),
      ('map', 'Jumps', 3600),
      ('map', 'Kills', 3600),
      ('map', 'Sovereignty', 3600);
INSERT INTO `utilCachedInterval` (`section`,`api`,`interval`)
      VALUES
      ('server', 'ServerStatus', 180);
INSERT INTO `utilRegisteredKey` (`activeAPIMask`,`isActive`,`keyID`,`vCode`)
      VALUES(8388608,1,1156,'abc123')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`isActive`=VALUES(`isActive`),`keyID`=VALUES(`keyID`),`vCode`=VALUES(`vCode`);
