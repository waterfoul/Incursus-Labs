CREATE TABLE corpAccountBalance (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountID`              BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`balance`                NUMERIC(17,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `accountKey`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpAllianceContactList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`contactID`              BIGINT(20) UNSIGNED NOT NULL,
`contactName`            VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `contactID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpAssetList (
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
ALTER TABLE corpAssetList ADD  INDEX `corpAssetList1`  (`lft`);
ALTER TABLE corpAssetList ADD  INDEX `corpAssetList2`  (`locationID`);
CREATE TABLE corpAttackers (
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`allianceName`           VARCHAR(255),
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255),
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255),
`damageDone`             BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
`factionID`              BIGINT(20) UNSIGNED NOT NULL,
`factionName`            VARCHAR(255) NOT NULL,
`finalBlow`              TINYINT(1) UNSIGNED NOT NULL,
`securityStatus`         DOUBLE NOT NULL,
`shipTypeID`             BIGINT(20) UNSIGNED NOT NULL,
`weaponTypeID`           BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpCalendarEventAttendees (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255) NOT NULL,
`response`               VARCHAR(32) NOT NULL,
                 PRIMARY KEY (`ownerID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpCombatSettings (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`posID`                  BIGINT(20) UNSIGNED NOT NULL,
`onAggressionEnabled`    TINYINT(1) UNSIGNED NOT NULL,
`onCorporationWarEnabled` TINYINT(1) UNSIGNED NOT NULL,
`onStandingDropStanding` NUMERIC(5,2) UNSIGNED NOT NULL,
`onStatusDropEnabled`    TINYINT(1) UNSIGNED NOT NULL,
`onStatusDropStanding`   NUMERIC(5,2) UNSIGNED NOT NULL,
`useStandingsFromOwnerID` BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `posID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpContainerLog (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`action`                 VARCHAR(255) NOT NULL,
`actorID`                BIGINT(20) UNSIGNED NOT NULL,
`actorName`              VARCHAR(255) NOT NULL,
`flag`                   SMALLINT(5) UNSIGNED NOT NULL,
`itemID`                 BIGINT(20) UNSIGNED NOT NULL,
`itemTypeID`             BIGINT(20) UNSIGNED NOT NULL,
`locationID`             BIGINT(20) UNSIGNED NOT NULL,
`logTime`                DATETIME NOT NULL,
`newConfiguration`       SMALLINT(4) UNSIGNED NOT NULL,
`oldConfiguration`       SMALLINT(4) UNSIGNED NOT NULL,
`passwordType`           VARCHAR(255) NOT NULL,
`quantity`               BIGINT(20) UNSIGNED NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `itemID`, `logTime`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpContracts (
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
CREATE TABLE corpCorporateContactList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`contactID`              BIGINT(20) UNSIGNED NOT NULL,
`contactName`            VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `contactID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpCorporationSheet (
`allianceID`             BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
`allianceName`           VARCHAR(255),
`ceoID`                  BIGINT(20) UNSIGNED NOT NULL,
`ceoName`                VARCHAR(255) NOT NULL,
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255) NOT NULL,
`description`            TEXT,
`memberCount`            SMALLINT(5) UNSIGNED NOT NULL,
`memberLimit`            SMALLINT(5) NOT NULL DEFAULT 0,
`shares`                 BIGINT(20) UNSIGNED NOT NULL,
`stationID`              BIGINT(20) UNSIGNED NOT NULL,
`stationName`            VARCHAR(255) NOT NULL,
`taxRate`                NUMERIC(5,2) UNSIGNED NOT NULL,
`ticker`                 VARCHAR(255) NOT NULL,
`url`                    VARCHAR(255),
                 PRIMARY KEY (`corporationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpDivisions (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`description`            VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `accountKey`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpFacWarStats (
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
ALTER TABLE corpFacWarStats ADD  INDEX `corpFacWarStats1`  (`factionID`);
CREATE TABLE corpFuel (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`posID`                  BIGINT(20) UNSIGNED NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
`quantity`               BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `posID`, `typeID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpGeneralSettings (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`posID`                  BIGINT(20) UNSIGNED NOT NULL,
`allowAllianceMembers`   TINYINT(1) UNSIGNED NOT NULL,
`allowCorporationMembers` TINYINT(1) UNSIGNED NOT NULL,
`deployFlags`            SMALLINT(5) UNSIGNED NOT NULL,
`usageFlags`             SMALLINT(5) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `posID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpIndustryJobs (
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
CREATE TABLE corpItems (
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
CREATE TABLE corpKillLog (
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`killTime`               DATETIME NOT NULL,
`moonID`                 BIGINT(20) UNSIGNED NOT NULL,
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `killTime`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpLogo (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`color1`                 SMALLINT(5) UNSIGNED NOT NULL,
`color2`                 SMALLINT(5) UNSIGNED NOT NULL,
`color3`                 SMALLINT(5) UNSIGNED NOT NULL,
`graphicID`              BIGINT(20) UNSIGNED NOT NULL,
`shape1`                 SMALLINT(5) UNSIGNED NOT NULL,
`shape2`                 SMALLINT(5) UNSIGNED NOT NULL,
`shape3`                 SMALLINT(5) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `graphicID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpMarketOrders (
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
CREATE TABLE corpMedals (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`created`                DATETIME NOT NULL,
`creatorID`              BIGINT(20) UNSIGNED NOT NULL,
`description`            TEXT,
`medalID`                BIGINT(20) UNSIGNED NOT NULL,
`title`                  VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `medalID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpMemberMedals (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`medalID`                BIGINT(20) UNSIGNED NOT NULL,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`issued`                 DATETIME NOT NULL,
`issuerID`               BIGINT(20) UNSIGNED NOT NULL,
`reason`                 TEXT,
`status`                 VARCHAR(32) NOT NULL,
                 PRIMARY KEY (`ownerID`, `medalID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpMemberTracking (
`base`                   VARCHAR(255),
`baseID`                 BIGINT(20) UNSIGNED,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`grantableRoles`         VARCHAR(64),
`location`               VARCHAR(255),
`locationID`             BIGINT(20) UNSIGNED,
`logoffDateTime`         DATETIME,
`logonDateTime`          DATETIME,
`name`                   VARCHAR(255) NOT NULL,
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`roles`                  VARCHAR(64),
`shipType`               VARCHAR(255),
`shipTypeID`             BIGINT(20),
`startDateTime`          DATETIME NOT NULL,
`title`                  TEXT,
                 PRIMARY KEY (`characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE corpMemberTracking ADD  INDEX `corpMemberTrackingindex1`  (`ownerID`);
CREATE TABLE corpOutpostList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`dockingCostPerShipVolume` NUMERIC(17,2) NOT NULL,
`officeRentalCost`       NUMERIC(17,2) NOT NULL,
`reprocessingEfficiency` NUMERIC(5,4) NOT NULL,
`reprocessingStationTake` NUMERIC(5,4) NOT NULL,
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
`standingOwnerID`        BIGINT(20) UNSIGNED NOT NULL,
`stationID`              BIGINT(20) UNSIGNED NOT NULL,
`stationName`            VARCHAR(255) NOT NULL,
`stationTypeID`          BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `stationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpOutpostServiceDetail (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`stationID`              BIGINT(20) UNSIGNED NOT NULL,
`discountPerGoodStanding` NUMERIC(5,2) NOT NULL,
`minStanding`            NUMERIC(5,2) UNSIGNED NOT NULL,
`serviceName`            VARCHAR(255) NOT NULL,
`surchargePerBadStanding` NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `stationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpStandingsFromAgents (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`fromID`                 BIGINT(20) UNSIGNED NOT NULL,
`fromName`               VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `fromID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpStandingsFromFactions (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`fromID`                 BIGINT(20) UNSIGNED NOT NULL,
`fromName`               VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `fromID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpStandingsFromNPCCorporations (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`fromID`                 BIGINT(20) UNSIGNED NOT NULL,
`fromName`               VARCHAR(255) NOT NULL,
`standing`               NUMERIC(5,2) NOT NULL,
                 PRIMARY KEY (`ownerID`, `fromID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpStarbaseDetail (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`posID`                  BIGINT(20) UNSIGNED NOT NULL,
`onlineTimestamp`        DATETIME NOT NULL,
`state`                  TINYINT(2) UNSIGNED NOT NULL,
`stateTimestamp`         DATETIME NOT NULL,
                 PRIMARY KEY (`ownerID`, `posID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpStarbaseList (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`itemID`                 BIGINT(20) UNSIGNED NOT NULL,
`locationID`             BIGINT(20) UNSIGNED NOT NULL,
`moonID`                 BIGINT(20) UNSIGNED NOT NULL,
`onlineTimestamp`        DATETIME NOT NULL,
`standingOwnerID`        BIGINT(20) UNSIGNED NOT NULL,
`state`                  TINYINT(2) UNSIGNED NOT NULL,
`stateTimestamp`         DATETIME NOT NULL,
`typeID`                 BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `itemID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpVictim (
`killID`                 BIGINT(20) UNSIGNED NOT NULL,
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`allianceName`           VARCHAR(255),
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255),
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255),
`damageTaken`            BIGINT(20) UNSIGNED NOT NULL,
`factionID`              BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
`factionName`            VARCHAR(255) NOT NULL,
`shipTypeID`             BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`killID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpWalletDivisions (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`description`            VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`ownerID`, `accountKey`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpWalletJournal (
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
`refTypeID`              SMALLINT(5) UNSIGNED NOT NULL,
                 PRIMARY KEY (`ownerID`, `accountKey`, `refID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE corpWalletTransactions (
`ownerID`                BIGINT(20) UNSIGNED NOT NULL,
`accountKey`             SMALLINT(4) UNSIGNED NOT NULL,
`characterID`            BIGINT(20) UNSIGNED,
`characterName`          VARCHAR(255),
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
                 PRIMARY KEY (`ownerID`, `accountKey`, `transactionID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE `corpAssetList` MODIFY `singleton` BOOLEAN NOT NULL;
ALTER TABLE `corpAttackers` MODIFY `finalBlow` BOOLEAN NOT NULL;
ALTER TABLE `corpCombatSettings` MODIFY `onAggressionEnabled` BOOLEAN NOT NULL;
ALTER TABLE `corpCombatSettings` MODIFY `onCorporationWarEnabled` BOOLEAN NOT NULL;
ALTER TABLE `corpCombatSettings` MODIFY `onStatusDropEnabled` BOOLEAN NOT NULL;
ALTER TABLE `corpContracts` MODIFY `forCorp` BOOLEAN NOT NULL;
ALTER TABLE `corpGeneralSettings` MODIFY `allowAllianceMembers` BOOLEAN NOT NULL;
ALTER TABLE `corpGeneralSettings` MODIFY `allowCorporationMembers` BOOLEAN NOT NULL;
ALTER TABLE `corpIndustryJobs` MODIFY `completed` BOOLEAN NOT NULL;
ALTER TABLE `corpMarketOrders` MODIFY `bid` BOOLEAN NOT NULL;
INSERT INTO `utilSections` (`activeAPIMask`,`isActive`,`sectionID`,`section`)
      VALUES(46068159,1,3,'corp')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`sectionID`=VALUES(`sectionID`),`section`=VALUES(`section`);
