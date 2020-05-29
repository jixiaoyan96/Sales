/*
Navicat MySQL Data Transfer

Source Server         : ldb
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : salesdev

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-05-29 16:34:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sal_integral`
-- ----------------------------
DROP TABLE IF EXISTS `sal_integral`;
CREATE TABLE `sal_integral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `point` decimal(5,3) DEFAULT '0.000',
  `username` varchar(20) DEFAULT NULL,
  `city` char(11) DEFAULT NULL,
  `lcd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sal_integral
-- ----------------------------
INSERT INTO `sal_integral` VALUES ('1', '2020', '5', null, 'test', 'SH', '2020-05-28 15:18:50', '2020-05-28 15:18:50');
