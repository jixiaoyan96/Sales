/*
Navicat MySQL Data Transfer

Source Server         : ldb
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : salesdev

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-01-25 10:56:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sal_rank`
-- ----------------------------
DROP TABLE IF EXISTS `sal_rank`;
CREATE TABLE `sal_rank` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `season` varchar(20) DEFAULT NULL COMMENT '赛季',
  `month` datetime DEFAULT NULL COMMENT '月份',
  `username` varchar(20) DEFAULT NULL,
  `city` varchar(11) DEFAULT NULL,
  `rank` int(20) DEFAULT NULL COMMENT '初始分数',
  `new_rank` int(20) DEFAULT NULL COMMENT '本赛季分数',
  `lcd` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lud` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sal_rank
-- ----------------------------
INSERT INTO `sal_rank` VALUES ('1', '1', '2019-07-02 10:42:46', 'test', 'SH', '0', '0', '2021-01-11 10:43:20', '2021-01-11 10:43:20');
INSERT INTO `sal_rank` VALUES ('2', '1', '2019-08-02 10:43:23', 'test', 'SH', '2147483647', '0', '2021-01-11 10:44:04', '2021-01-11 10:44:04');
INSERT INTO `sal_rank` VALUES ('3', '2', '2019-09-01 10:43:35', 'test', 'SH', '2147483647', null, '2021-01-11 10:43:50', '2021-01-11 10:43:50');
