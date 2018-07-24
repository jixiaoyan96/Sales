CREATE DATABASE notifyuat CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE ON notifyuat.* TO 'swuser'@'localhost' IDENTIFIED BY 'Swisher@168';

use notifyuat;

DROP TABLE IF EXISTS ntf_message;
CREATE TABLE ntf_message(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system_id` varchar(15) NOT NULL,
  `msg_type` varchar(10) DEFAULT NULL,
  `title_en` varchar(1000) DEFAULT NULL,
  `title_cn` varchar(1000) DEFAULT NULL,
  `title_tw` varchar(1000) DEFAULT NULL,
  `message_en` text,
  `message_cn` text,
  `message_tw` text,
  `status` char(1) NOT NULL DEFAULT 'P',
  `response` text,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS sal_push_message;
CREATE TABLE sal_push_message(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msg_type` varchar(10) DEFAULT NULL,
  `title_en` varchar(1000) DEFAULT NULL,
  `title_cn` varchar(1000) DEFAULT NULL,
  `title_tw` varchar(1000) DEFAULT NULL,
  `message_en` text,
  `message_cn` text,
  `message_tw` text,
  `status` char(1) NOT NULL DEFAULT 'P',
  `response` text,
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

