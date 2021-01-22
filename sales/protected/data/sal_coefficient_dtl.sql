/*
Navicat MySQL Data Transfer

Source Server         : ldb
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : salesdev

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-01-22 10:06:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sal_coefficient_dtl`
-- ----------------------------
DROP TABLE IF EXISTS `sal_coefficient_dtl`;
CREATE TABLE `sal_coefficient_dtl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hdr_id` int(10) unsigned NOT NULL,
  `name` varchar(11) NOT NULL,
  `operator` char(2) NOT NULL,
  `criterion` decimal(11,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(11,2) NOT NULL DEFAULT '0.00',
  `coefficient` decimal(5,3) NOT NULL DEFAULT '0.000',
  `lcu` varchar(30) DEFAULT NULL,
  `luu` varchar(30) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_service_rate_dtl_01` (`hdr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sal_coefficient_dtl
-- ----------------------------
INSERT INTO `sal_coefficient_dtl` VALUES ('29', '24', '0', 'LE', '4.00', '0.00', '0.800', 'test', 'test', '2021-01-22 09:54:25', '2021-01-22 09:54:25');
INSERT INTO `sal_coefficient_dtl` VALUES ('30', '24', '0', 'LE', '9.00', '500.00', '0.900', 'test', 'test', '2021-01-22 09:54:25', '2021-01-22 09:54:25');
INSERT INTO `sal_coefficient_dtl` VALUES ('31', '24', '0', 'LE', '14.00', '1000.00', '1.000', 'test', 'test', '2021-01-22 09:54:25', '2021-01-22 10:02:22');
INSERT INTO `sal_coefficient_dtl` VALUES ('32', '24', '0', 'GT', '16.00', '2000.00', '1.200', 'test', 'test', '2021-01-22 09:54:25', '2021-01-22 10:02:22');
INSERT INTO `sal_coefficient_dtl` VALUES ('33', '24', '1', 'LE', '30000.00', '0.00', '0.025', 'test', 'test', '2021-01-22 09:56:56', '2021-01-22 09:56:56');
INSERT INTO `sal_coefficient_dtl` VALUES ('34', '24', '1', 'LE', '60000.00', '0.00', '0.050', 'test', 'test', '2021-01-22 09:56:57', '2021-01-22 09:56:57');
INSERT INTO `sal_coefficient_dtl` VALUES ('35', '24', '1', 'LE', '120000.00', '0.00', '0.100', 'test', 'test', '2021-01-22 09:56:57', '2021-01-22 09:56:57');
INSERT INTO `sal_coefficient_dtl` VALUES ('36', '24', '1', 'GT', '120000.00', '0.00', '0.120', 'test', 'test', '2021-01-22 09:56:57', '2021-01-22 09:56:57');
INSERT INTO `sal_coefficient_dtl` VALUES ('37', '24', '2', 'GT', '0.00', '0.00', '0.300', 'test', 'test', '2021-01-22 10:00:30', '2021-01-22 10:00:30');
INSERT INTO `sal_coefficient_dtl` VALUES ('38', '24', '3', 'GT', '0.00', '0.00', '0.800', 'test', 'test', '2021-01-22 10:00:55', '2021-01-22 10:00:55');
INSERT INTO `sal_coefficient_dtl` VALUES ('39', '24', '4', 'GT', '0.00', '0.00', '1.500', 'test', 'test', '2021-01-22 10:01:23', '2021-01-22 10:01:23');
INSERT INTO `sal_coefficient_dtl` VALUES ('40', '24', '5', 'LE', '0.25', '0.00', '0.400', 'test', 'test', '2021-01-22 10:04:01', '2021-01-22 10:04:01');
INSERT INTO `sal_coefficient_dtl` VALUES ('41', '24', '5', 'LE', '0.50', '0.00', '0.700', 'test', 'test', '2021-01-22 10:04:01', '2021-01-22 10:04:01');
INSERT INTO `sal_coefficient_dtl` VALUES ('42', '24', '5', 'LE', '0.75', '0.00', '1.000', 'test', 'test', '2021-01-22 10:04:01', '2021-01-22 10:04:01');
INSERT INTO `sal_coefficient_dtl` VALUES ('43', '24', '5', 'LE', '1.00', '0.00', '1.100', 'test', 'test', '2021-01-22 10:04:01', '2021-01-22 10:04:01');
