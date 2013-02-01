CREATE TABLE mapFacWarSystems (
`contested`              TINYINT(1) UNSIGNED NOT NULL,
`occupyingFactionID`     BIGINT(20) UNSIGNED,
`occupyingFactionName`   VARCHAR(255),
`owningFactionID`        BIGINT(20) UNSIGNED,
`owningFactionName`      VARCHAR(255),
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
`solarSystemName`        VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`solarSystemID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE mapJumps (
`shipJumps`              BIGINT(20) UNSIGNED NOT NULL,
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`solarSystemID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE mapKills (
`factionKills`           BIGINT(20) UNSIGNED NOT NULL,
`podKills`               BIGINT(20) UNSIGNED NOT NULL,
`shipKills`              BIGINT(20) UNSIGNED NOT NULL,
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`solarSystemID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE mapSovereignty (
`allianceID`             BIGINT(20) UNSIGNED NOT NULL,
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`factionID`              BIGINT(20) UNSIGNED NOT NULL,
`solarSystemID`          BIGINT(20) UNSIGNED NOT NULL,
`solarSystemName`        VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`solarSystemID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE `mapFacWarSystems` MODIFY `contested` BOOLEAN NOT NULL;
INSERT INTO `utilSections` (`activeAPIMask`,`isActive`,`sectionID`,`section`)
      VALUES(15,1,5,'map')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`sectionID`=VALUES(`sectionID`),`section`=VALUES(`section`);
