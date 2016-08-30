
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- api_config
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `api_config`;

CREATE TABLE `api_config`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `api_token` VARCHAR(255),
    `api_key` VARCHAR(255),
    `api_url` VARCHAR(255),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- insert default values
INSERT INTO `store_config` (`api_token`, `api_key`, `api_url`) VALUES
('100FBFED0B742F288013F1ED1','64285C2A60E9F941A7B8EB868A918032C07CDD0C1DD184FB','http://thelia-marketplace.openstudio-lab.com');

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
