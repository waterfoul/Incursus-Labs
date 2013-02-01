CREATE TABLE eveAllianceList (
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`executorCorpID`         BIGINT(20) UNSIGNED,
`memberCount`            BIGINT(20) UNSIGNED,
`name`                   VARCHAR(255),
`shortName`              VARCHAR(255),
`startDate`              DATETIME,
                 PRIMARY KEY (`allianceID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCharactersKillsLastWeek (
characterID              BIGINT(20) UNSIGNED NOT NULL,
characterName            VARCHAR(32),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (characterID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCharactersKillsTotal (
characterID              BIGINT(20) UNSIGNED NOT NULL,
characterName            VARCHAR(32),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (characterID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCharactersKillsYesterday (
characterID              BIGINT(20) UNSIGNED NOT NULL,
characterName            VARCHAR(32),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (characterID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCharactersVictoryPointsLastWeek (
characterID              BIGINT(20) UNSIGNED NOT NULL,
characterName            VARCHAR(32),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (characterID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCharactersVictoryPointsTotal (
characterID              BIGINT(20) UNSIGNED NOT NULL,
characterName            VARCHAR(32),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (characterID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCharactersVictoryPointsYesterday (
characterID              BIGINT(20) UNSIGNED NOT NULL,
characterName            VARCHAR(32),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (characterID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveConquerableStationList (
`corporationID`          BIGINT(20) UNSIGNED,
`corporationName`        VARCHAR(255),
`solarSystemID`          BIGINT(20) UNSIGNED,
`stationID`              BIGINT(20) UNSIGNED NOT NULL,
`stationName`            VARCHAR(255),
`stationTypeID`          BIGINT(20) UNSIGNED,
                 PRIMARY KEY (`stationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCorporationsKillsLastWeek (
corporationID            BIGINT(20) UNSIGNED NOT NULL,
corporationName          VARCHAR(255),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (corporationID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCorporationsKillsTotal (
corporationID            BIGINT(20) UNSIGNED NOT NULL,
corporationName          VARCHAR(255),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (corporationID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCorporationsKillsYesterday (
corporationID            BIGINT(20) UNSIGNED NOT NULL,
corporationName          VARCHAR(255),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (corporationID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCorporationsVictoryPointsLastWeek (
corporationID            BIGINT(20) UNSIGNED NOT NULL,
corporationName          VARCHAR(255),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (corporationID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCorporationsVictoryPointsTotal (
corporationID            BIGINT(20) UNSIGNED NOT NULL,
corporationName          VARCHAR(255),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (corporationID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveCorporationsVictoryPointsYesterday (
corporationID            BIGINT(20) UNSIGNED NOT NULL,
corporationName          VARCHAR(255),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (corporationID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveErrorList (
`errorCode`              SMALLINT(3) UNSIGNED NOT NULL,
`errorText`              TEXT,
                 PRIMARY KEY (`errorCode`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactions (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
killsYesterday           BIGINT(20) UNSIGNED NOT NULL,
killsLastWeek            BIGINT(20) UNSIGNED NOT NULL,
killsTotal               BIGINT(20) UNSIGNED NOT NULL,
pilots                   BIGINT(20) UNSIGNED NOT NULL,
systemsControlled        BIGINT(20) UNSIGNED NOT NULL,
victoryPointsYesterday   BIGINT(20) UNSIGNED NOT NULL,
victoryPointsLastWeek    BIGINT(20) UNSIGNED NOT NULL,
victoryPointsTotal       BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionsKillsLastWeek (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionsKillsTotal (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionsKillsYesterday (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
kills                    BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionsVictoryPointsLastWeek (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionsVictoryPointsTotal (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionsVictoryPointsYesterday (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
victoryPoints            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (factionID)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFactionWars (
factionID                BIGINT(20) UNSIGNED NOT NULL,
factionName              VARCHAR(32),
againstID                BIGINT(20) UNSIGNED NOT NULL,
againstName              VARCHAR(32)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveFacWarStats (
killsYesterday           BIGINT(20) UNSIGNED NOT NULL,
killsLastWeek            BIGINT(20) UNSIGNED NOT NULL,
killsTotal               BIGINT(20) UNSIGNED NOT NULL,
victoryPointsYesterday   BIGINT(20) UNSIGNED NOT NULL,
victoryPointsLastWeek    BIGINT(20) UNSIGNED NOT NULL,
victoryPointsTotal       BIGINT(20) UNSIGNED NOT NULL
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveMemberCorporations (
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`startDate`              DATETIME,
                 PRIMARY KEY (`corporationID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE eveRefTypes (
`refTypeID`              SMALLINT(5) UNSIGNED NOT NULL,
`refTypeName`            VARCHAR(255),
                 PRIMARY KEY (`refTypeID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
INSERT INTO `utilSections` (`activeAPIMask`,`isActive`,`sectionID`,`section`)
      VALUES(497,1,4,'eve')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`sectionID`=VALUES(`sectionID`),`section`=VALUES(`section`);
