CREATE TABLE accountAccountStatus (
`keyID`                  BIGINT(20) UNSIGNED NOT NULL,
`createDate`             DATETIME NOT NULL,
`logonCount`             BIGINT(20) UNSIGNED NOT NULL,
`logonMinutes`           BIGINT(20) UNSIGNED NOT NULL,
`paidUntil`              DATETIME NOT NULL,
                 PRIMARY KEY (`keyID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
CREATE TABLE accountAPIKeyInfo (
`keyID`                  BIGINT(20) UNSIGNED NOT NULL,
`accessMask`             BIGINT(20) UNSIGNED NOT NULL,
`expires`                DATETIME NOT NULL DEFAULT '2038-01-19 03:14:07',
`type`                   VARCHAR(11) NOT NULL,
                 PRIMARY KEY (`keyID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE accountAPIKeyInfo ADD  INDEX `accountAPIKeyInfo1`  (`type`);
CREATE TABLE accountCharacters (
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
`characterName`          VARCHAR(255) NOT NULL,
`corporationID`          BIGINT(20) UNSIGNED NOT NULL,
`corporationName`        VARCHAR(255) NOT NULL,
                 PRIMARY KEY (`characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE accountCharacters ADD  INDEX `accountCharacters1`  (`corporationID`);
CREATE TABLE accountKeyBridge (
`keyID`                  BIGINT(20) UNSIGNED NOT NULL,
`characterID`            BIGINT(20) UNSIGNED NOT NULL,
                 PRIMARY KEY (`keyID`, `characterID`)
) ENGINE = InnoDB COLLATE = utf8_unicode_ci;
ALTER TABLE accountKeyBridge ADD  UNIQUE INDEX `accountKeyBridge1`  (`characterID`, `keyID`);
ALTER TABLE `accountAPIKeyInfo` MODIFY `type` ENUM('Account','Character','Corporation') COLLATE ascii_general_ci NOT NULL;
INSERT INTO `utilSections` (`activeAPIMask`,`isActive`,`sectionID`,`section`)
      VALUES(33554433,1,1,'account')
      ON DUPLICATE KEY UPDATE `activeAPIMask`=VALUES(`activeAPIMask`),`sectionID`=VALUES(`sectionID`),`section`=VALUES(`section`);
