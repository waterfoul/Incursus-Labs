CREATE TABLE charAccountBalance (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountID`              BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`balance`                NUMERIC(17,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `accountKey`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charAllianceContactList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`contactID`              BIGINT(20) UNSIGNED NOT NULL,
`contactName`            VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `contactID`)
)ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charAssetList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`flag`                   SMALLINT(5) UNSIGNED NOT NULL,
`itemID`                 BIGINT(20) UNSIGNED NOT NULL,
`lft`                    BIGINT(20) UNSIGNED NOT NULL,
`locationID`             BIGINT(20) UNSIGNED NOT NULL,
`lvl`                    TINYINT(2) UNSIGNED NOT NULL,
`quantity`               BIGINT(20) UNSIGNED NOT NULL,
`rawQuantity`            BIGINT(20),
`rgt`                    BIGINT(20) UNSIGNED NOT NULL,
`singleton`              TINYINT(1) UNSIGNED NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `itemID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE charAssetList ADD  INDEX `charAssetList1`  (`lft`);
ALTER TABLE charAssetList ADD  INDEX `charAssetList2`  (`locationID`);
CREATE TABLE charAttackers (
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`allianceName`           VARCHAR(255),
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255),
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255),
`damageDone`             BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
`factionID`              BIGINT(20) UNSIGNED NOT NULL,
`factionName`            VARCHAR(255),
`finalBlow`              TINYINT(1) UNSIGNED NOT NULL,
`securityStatus`         DOUBLE NOT NULL,
`shipTypeID`             BIGINT(20) UNSIGNED NOT NULL,
`weaponTypeID`           BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charAttributeEnhancers (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`augmentatorName`        VARCHAR(100) NOT NULL,
`augmentatorValue`       TINYINT(2) UNSIGNED NOT NULL,
`bonusName`              VARCHAR(100) NOT NULL,
                 PRIMARY KEY (`ownerID`, `bonusName`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charAttributes (
`charisma`               TINYINT(2) UNSIGNED NOT NULL,
`intelligence`           TINYINT(2) UNSIGNED NOT NULL,
`memory`                 TINYINT(2) UNSIGNED NOT NULL,
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`perception`             TINYINT(2) UNSIGNED NOT NULL,
`willpower`              TINYINT(2) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCalendarEventAttendees (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255) NOT NULL,
`response`               VARCHAR(32) NOT NULL,
                 PRIMARY KEY (`ownerID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCertificates (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`certificateID`          BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `certificateID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCharacterSheet (
`allianceID`             BIGINT(20) UNSIGNED DEFAULT 0,
`allianceName`           VARCHAR(255) DEFAULT '',
`ancestry`               VARCHAR(255) NOT NULL,
`balance`                NUMERIC(17,2) NOT NULL,
`bloodLine`              VARCHAR(255) NOT NULL,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`cloneName`              VARCHAR(255) NOT NULL,
`cloneSkillPoints`       BIGINT(20) UNSIGNED NOT NULL,
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255) NOT NULL,
`DoB`                    DATETIME NOT NULL,
`gender`                 VARCHAR(255) NOT NULL,
`name`                   VARCHAR(255) NOT NULL,
`race`                   VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charContactList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`contactID`              BIGINT(20) UNSIGNED NOT NULL,
`contactName`            VARCHAR(255) NOT NULL,
`inWatchlist`            TINYINT(1) UNSIGNED NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `contactID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charContactNotifications (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`notificationID`         BIGINT(20) UNSIGNED NOT NULL,
`senderID`               BIGINT(20) UNSIGNED NOT NULL,
`senderName`             VARCHAR(255) NOT NULL,
`sentDate`               DATETIME NOT NULL,
`messageData`            TEXT,
                 PRIMARY KEY (`ownerID`, `notificationID`, `senderID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCorporateContactList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`contactID`              BIGINT(20) UNSIGNED NOT NULL,
`contactName`            VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `contactID`)
)ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charContracts (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`contractID`             BIGINT(20) UNSIGNED NOT NULL,
`issuerID`               BIGINT(20) UNSIGNED NOT NULL,
`issuerCorpID`           BIGINT(20) UNSIGNED NOT NULL,
`assigneeID`             BIGINT(20) UNSIGNED NOT NULL,
`acceptorID`             BIGINT(20) UNSIGNED NOT NULL,
`startStationID`         BIGINT(20) UNSIGNED NOT NULL,
`endStationID`           BIGINT(20) UNSIGNED NOT NULL,
`type`                   VARCHAR(255) NOT NULL,
`status`                 VARCHAR(255) NOT NULL,
`title`                  VARCHAR(255),
`forCorp`                TINYINT(1) UNSIGNED NOT NULL,
`availability`           VARCHAR(255) NOT NULL,
`dateIssued`             DATETIME NOT NULL,
`dateExpired`            DATETIME NOT NULL,
`dateAccepted`           DATETIME,
`numDays`                SMALLINT(3) UNSIGNED NOT NULL,
`dateCompleted`          DATETIME,
`price`                  NUMERIC(17,2) NOT NULL,
`reward`                 NUMERIC(17,2) NOT NULL,
`collateral`             NUMERIC(17,2) NOT NULL,
`buyout`                 NUMERIC(17,2) NOT NULL,
`volume`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `contractID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCorporationRoles (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`roleID`                 BIGINT(20) UNSIGNED NOT NULL,
`roleName`               VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `roleID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCorporationRolesAtBase (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`roleID`                 BIGINT(20) UNSIGNED NOT NULL,
`roleName`               VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `roleID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCorporationRolesAtHQ (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`roleID`                 BIGINT(20) UNSIGNED NOT NULL,
`roleName`               VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `roleID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCorporationRolesAtOther (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`roleID`                 BIGINT(20) UNSIGNED NOT NULL,
`roleName`               VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `roleID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charCorporationTitles (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`titleID`                BIGINT(20) UNSIGNED NOT NULL,
`titleName`              VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `titleID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charFacWarStats (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`factionID`              BIGINT(20) UNSIGNED NOT NULL,
`factionName`            VARCHAR(32) NOT NULL,
`enlisted`               DATETIME NOT NULL,
`currentRank`            BIGINT(20) UNSIGNED NOT NULL,
`highestRank`            BIGINT(20) UNSIGNED NOT NULL,
`killsYesterday`         BIGINT(20) UNSIGNED NOT NULL,
`killsLastWeek`          BIGINT(20) UNSIGNED NOT NULL,
`killsTotal`             BIGINT(20) UNSIGNED NOT NULL,
`victoryPointsYesterday` BIGINT(20) UNSIGNED NOT NULL,
`victoryPointsLastWeek`  BIGINT(20) UNSIGNED NOT NULL,
`victoryPointsTotal`     BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE charFacWarStats ADD  INDEX `charFacWarStats1`  (`factionID`);
CREATE TABLE charIndustryJobs (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`activityID`             TINYINT(2) UNSIGNED NOT NULL,
`assemblyLineID`         BIGINT(20) UNSIGNED NOT NULL,
`beginProductionTime`    DATETIME NOT NULL,
`charMaterialMultiplier` NUMERIC(4,2) NOT NULL,
`charTimeMultiplier`     NUMERIC(4,2) NOT NULL,
`completed`              TINYINT(1) UNSIGNED NOT NULL,
`completedStatus`        TINYINT(2) UNSIGNED NOT NULL,
`completedSuccessfully`  TINYINT(2) UNSIGNED NOT NULL,
`containerID`            BIGINT(20) UNSIGNED NOT NULL,
`containerLocationID`    BIGINT(20) UNSIGNED NOT NULL,
`containerTypeID`        BIGINT(20) UNSIGNED NOT NULL,
`endProductionTime`      DATETIME NOT NULL,
`installedInSolarSystemID` BIGINT(20) UNSIGNED NOT NULL,
`installedItemCopy`      BIGINT(20) UNSIGNED NOT NULL,
`installedItemFlag`      SMALLINT(5) UNSIGNED NOT NULL,
`installedItemID`        BIGINT(20) UNSIGNED NOT NULL,
`installedItemLicensedProductionRunsRemaining` BIGINT(20) NOT NULL,
`installedItemLocationID` BIGINT(20) UNSIGNED NOT NULL,
`installedItemMaterialLevel` BIGINT(20) NOT NULL,
`installedItemProductivityLevel` BIGINT(20) NOT NULL,
`installedItemQuantity`  BIGINT(20) UNSIGNED NOT NULL,
`installedItemTypeID`    BIGINT(20) UNSIGNED NOT NULL,
`installerID`            BIGINT(20) UNSIGNED NOT NULL,
`installTime`            DATETIME NOT NULL,
`jobID`                  BIGINT(20) UNSIGNED NOT NULL,
`licensedProductionRuns` BIGINT(20) NOT NULL,
`materialMultiplier`     NUMERIC(4,2) NOT NULL,
`outputFlag`             SMALLINT(5) UNSIGNED NOT NULL,
`outputLocationID`       BIGINT(20) UNSIGNED NOT NULL,
`outputTypeID`           BIGINT(20) UNSIGNED NOT NULL,
`pauseProductionTime`    DATETIME NOT NULL,
`runs`                   BIGINT(20) UNSIGNED NOT NULL,
`timeMultiplier`         NUMERIC(4,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `jobID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charItems (
`flag`                   SMALLINT(5) UNSIGNED NOT NULL,
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`lft`                    BIGINT(20) UNSIGNED NOT NULL,
`lvl`                    TINYINT(2) UNSIGNED NOT NULL,
`rgt`                    BIGINT(20) UNSIGNED NOT NULL,
`qtyDropped`             BIGINT(20) UNSIGNED NOT NULL,
`qtyDestroyed`           BIGINT(20) UNSIGNED NOT NULL,
`singleton`              SMALLINT(5) UNSIGNED NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `lft`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charKillLog (
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`killTime`               DATETIME NOT NULL,
`moonID`                 BIGINT(20) UNSIGNED NOT NULL,
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `killTime`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charMailBodies (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`body`                   TEXT,
`messageID`              BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `messageID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charMailingLists (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`displayName`            VARCHAR(255) NOT NULL,
`listID`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `listID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charMailMessages (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`messageID`              BIGINT(20) UNSIGNED NOT NULL,
`senderID`               BIGINT(20) UNSIGNED NOT NULL,
`sentDate`               DATETIME NOT NULL,
`title`                  VARCHAR(255),
`toCharacterIDs`         TEXT,
`toCorpOrAllianceID`     BIGINT(20) UNSIGNED DEFAULT 0,
`toListID`               TEXT,
                 PRIMARY KEY (`ownerID`, `messageID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charMarketOrders (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`bid`                    TINYINT(1) UNSIGNED NOT NULL,
`charID`                 BIGINT(20) UNSIGNED NOT NULL,
`duration`               SMALLINT(3) UNSIGNED NOT NULL,
`escrow`                 NUMERIC(17,2) NOT NULL,
`issued`                 DATETIME NOT NULL,
`minVolume`              BIGINT(20) UNSIGNED NOT NULL,
`orderID`                BIGINT(20) UNSIGNED NOT NULL,
`orderState`             TINYINT(2) UNSIGNED NOT NULL,
`price`                  NUMERIC(17,2) NOT NULL,
`range`                  SMALLINT NOT NULL,
`stationID`              BIGINT(20) UNSIGNED,
`typeID`                 BIGINT(20) UNSIGNED,
`volEntered`             BIGINT(20) UNSIGNED NOT NULL,
`volRemaining`           BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `orderID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charNotifications (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`notificationID`         BIGINT(20) UNSIGNED NOT NULL,
`read`                   TINYINT(1) UNSIGNED NOT NULL,
`senderID`               BIGINT(20) UNSIGNED NOT NULL,
`sentDate`               DATETIME NOT NULL,
`typeID`                 SMALLINT(5) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `notificationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charNotificationTexts (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`notificationID`         BIGINT(20) UNSIGNED NOT NULL,
`text`                   TEXT,
                 PRIMARY KEY (`ownerID`, `notificationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charResearch (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`agentID`                BIGINT(20) UNSIGNED NOT NULL,
`pointsPerDay`           NUMERIC(5,2) NOT NULL,
`skillTypeID`            BIGINT(20) UNSIGNED,
`remainderPoints`        DOUBLE NOT NULL,
`researchStartDate`      DATETIME NOT NULL,
                 PRIMARY KEY (`ownerID`, `agentID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charSkillInTraining (
`currentTQTime`          DATETIME,
`offset`                 TINYINT(2) NOT NULL,
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`skillInTraining`        TINYINT(1) UNSIGNED NOT NULL,
`trainingDestinationSP`  BIGINT(20) UNSIGNED NOT NULL,
`trainingEndTime`        DATETIME,
`trainingStartSP`        BIGINT(20) UNSIGNED NOT NULL,
`trainingStartTime`      DATETIME,
`trainingToLevel`        TINYINT(1) UNSIGNED NOT NULL,
`trainingTypeID`         BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charSkillQueue (
`endSP`                  BIGINT(20) UNSIGNED NOT NULL,
`endTime`                DATETIME NOT NULL,
`level`                  TINYINT(1) UNSIGNED NOT NULL,
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`queuePosition`          TINYINT(2) UNSIGNED NOT NULL,
`startSP`                BIGINT(20) UNSIGNED NOT NULL,
`startTime`              DATETIME NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `queuePosition`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charSkills (
`level`                  TINYINT(1) UNSIGNED NOT NULL,
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`skillpoints`            BIGINT(20) UNSIGNED NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
`published`              TINYINT(1) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `typeID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charStandingsFromAgents (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`fromID`                 BIGINT(20) UNSIGNED NOT NULL,
`fromName`               VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `fromID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charStandingsFromFactions (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`fromID`                 BIGINT(20) UNSIGNED NOT NULL,
`fromName`               VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `fromID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charStandingsFromNPCCorporations (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`fromID`                 BIGINT(20) UNSIGNED NOT NULL,
`fromName`               VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `fromID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charVictim (
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`allianceName`           VARCHAR(255),
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255),
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255),
`damageTaken`            BIGINT(20) UNSIGNED NOT NULL,
`factionID`              BIGINT(20) UNSIGNED NOT NULL,
`factionName`            VARCHAR(255),
`shipTypeID`             BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charWalletJournal (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`amount`                 NUMERIC(17,2) NOT NULL,
`argID1`                 BIGINT(20) UNSIGNED,
`argName1`               VARCHAR(255),
`balance`                NUMERIC(17,2) NOT NULL,
`date`                   DATETIME NOT NULL,
`ownerID1`               BIGINT(20) UNSIGNED,
`ownerID2`               BIGINT(20) UNSIGNED,
`ownerName1`             VARCHAR(255),
`ownerName2`             VARCHAR(255),
`reason`                 TEXT,
`refID`                  BIGINT(20) UNSIGNED NOT NULL,
`refTypeID`              INTEGER(3) UNSIGNED NOT NULL,
`taxAmount`              NUMERIC(17,2) NOT NULL,
`taxReceiverID`          BIGINT(20) UNSIGNED DEFAULT 0,
                 PRIMARY KEY (`ownerID`, `refID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE charWalletTransactions (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`clientID`               BIGINT(20) UNSIGNED,
`clientName`             VARCHAR(255),
`journalTransactionID`   BIGINT(20) UNSIGNED NOT NULL,
`price`                  NUMERIC(17,2) NOT NULL,
`quantity`               BIGINT(20) UNSIGNED NOT NULL,
`stationID`              BIGINT(20) UNSIGNED,
`stationName`            VARCHAR(255),
`transactionDateTime`    DATETIME NOT NULL,
`transactionFor`         VARCHAR(255) NOT NULL DEFAULT 'corporation',
`transactionID`          BIGINT(20) UNSIGNED NOT NULL,
`transactionType`        VARCHAR(255) NOT NULL DEFAULT 'sell',
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
`typeName`               VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `transactionID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE `charAssetList` MODIFY `singleton` BOOLEAN NOT NULL;
ALTER TABLE `charAttackers` MODIFY `finalBlow` BOOLEAN NOT NULL;
ALTER TABLE `charContactList` MODIFY `inWatchlist` BOOLEAN NOT NULL;
ALTER TABLE `charContracts` MODIFY `forCorp` BOOLEAN NOT NULL;
ALTER TABLE `charIndustryJobs` MODIFY `completed` BOOLEAN NOT NULL;
ALTER TABLE `charMarketOrders` MODIFY `bid` BOOLEAN NOT NULL;
ALTER TABLE `charNotifications` MODIFY `read` BOOLEAN NOT NULL;
ALTER TABLE `charSkills` MODIFY `published` BOOLEAN NOT NULL;
INSERT INTO `utilSections` (`activeAPIMask`,`isActive`,`sectionID`,`section`)
      VALUES(74440635,1,2,'char')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`sectionID`=VALUES(`sectionID`),`section`=VALUES(`section`);
