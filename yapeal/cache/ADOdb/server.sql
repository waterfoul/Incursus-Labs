CREATE TABLE serverServerStatus (
`onlinePlayers`          BIGINT(20) UNSIGNED NOT NULL,
`serverName`             VARCHAR(32) NOT NULL,
`serverOpen`             VARCHAR(32) NOT NULL,
                 PRIMARY KEY (`serverName`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
INSERT INTO `utilSections` (`activeAPIMask`,`isActive`,`sectionID`,`section`)
      VALUES(1,1,6,'server')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`sectionID`=VALUES(`sectionID`),`section`=VALUES(`section`);
