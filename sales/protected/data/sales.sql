/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sales

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-20 10:04:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sa_classify
-- ----------------------------
DROP TABLE IF EXISTS `sa_classify`;
CREATE TABLE `sa_classify` (
  `id` int(64) NOT NULL,
  `typeid` int(64) DEFAULT NULL,
  `money` int(64) NOT NULL,
  `pid` int(64) NOT NULL,
  `name` char(100) NOT NULL,
  `city` char(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_classify
-- ----------------------------

-- ----------------------------
-- Table structure for sa_good
-- ----------------------------
DROP TABLE IF EXISTS `sa_good`;
CREATE TABLE `sa_good` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `goodid` int(64) NOT NULL COMMENT '商品ID',
  `gname` varchar(64) NOT NULL COMMENT '商品名字',
  `gmoney` int(64) NOT NULL COMMENT '商品价格',
  `gtype` int(64) NOT NULL,
  `pid` int(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_good
-- ----------------------------
INSERT INTO `sa_good` VALUES ('1', '5', '清洁', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('2', '1', '灭虫', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('3', '2', '飘盈香', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('4', '3', '甲醛', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('5', '4', '纸品', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('6', '100', '马桶', '100', '2', '5');
INSERT INTO `sa_good` VALUES ('7', '101', '尿斗', '100', '2', '5');
INSERT INTO `sa_good` VALUES ('8', '102', '水盆', '100', '2', '5');
INSERT INTO `sa_good` VALUES ('9', '103', '清新机', '100', '2', '5');
INSERT INTO `sa_good` VALUES ('10', '104', '皂液机', '100', '2', '5');
INSERT INTO `sa_good` VALUES ('11', '105', '租赁机器', '100', '2', '5');
INSERT INTO `sa_good` VALUES ('12', '106', '老鼠', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('13', '107', '蟑螂', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('14', '108', '果蝇', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('15', '109', '租灭蝇灯', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('16', '110', '老鼠蟑螂', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('17', '111', '老鼠果蝇', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('18', '112', '蟑螂果蝇', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('19', '113', '老鼠蟑螂果蝇', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('20', '114', '老鼠蟑螂+租灯', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('21', '115', '蟑螂果蝇+租灯', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('22', '116', '老鼠蟑螂果蝇+租灯', '100', '2', '1');
INSERT INTO `sa_good` VALUES ('23', '117', '小机', '100', '2', '2');
INSERT INTO `sa_good` VALUES ('24', '118', '大机', '100', '2', '2');
INSERT INTO `sa_good` VALUES ('25', '119', '中机', '100', '2', '2');
INSERT INTO `sa_good` VALUES ('26', '120', '迷你小机', '100', '2', '2');
INSERT INTO `sa_good` VALUES ('27', '121', '除甲醛', '100', '2', '3');
INSERT INTO `sa_good` VALUES ('28', '122', 'AC30', '100', '2', '3');
INSERT INTO `sa_good` VALUES ('29', '123', 'PR10', '100', '2', '3');
INSERT INTO `sa_good` VALUES ('30', '124', '迷你清洁炮', '100', '2', '3');
INSERT INTO `sa_good` VALUES ('31', '125', '擦手纸', '100', '2', '4');
INSERT INTO `sa_good` VALUES ('32', '126', '大卷厕纸', '100', '2', '4');

-- ----------------------------
-- Table structure for sa_order
-- ----------------------------
DROP TABLE IF EXISTS `sa_order`;
CREATE TABLE `sa_order` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(24) NOT NULL COMMENT '订单编号(自动生成)',
  `name` varchar(64) NOT NULL COMMENT '客户名字',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '下单时间',
  `money` int(64) DEFAULT NULL COMMENT '总价',
  `lcu` char(14) NOT NULL COMMENT '销售姓名',
  `address` varchar(64) DEFAULT NULL COMMENT '客户地址',
  `city` char(5) DEFAULT NULL COMMENT '地区',
  `region` varchar(64) DEFAULT NULL COMMENT '客户区域',
  `status` varchar(30) DEFAULT NULL COMMENT '订单状态(0.完成,1,进行,2待确认)',
  `goodagio` varchar(32) DEFAULT NULL COMMENT '商品折扣',
  `goodid` int(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_order
-- ----------------------------
INSERT INTO `sa_order` VALUES ('1', '1513677298zSr0admin', '客户Name', '2017-12-20 00:00:00', null, 'admin', '西街大道25号', 'HK', '东郊', '0', '0', '105');
INSERT INTO `sa_order` VALUES ('2', '15137339939F89admin', '火锅食品', '2017-12-20 00:00:00', null, 'admin', '东郊XX路48号', 'HK', '东郊', '0', '0', '110');

-- ----------------------------
-- Table structure for sa_ordergoods
-- ----------------------------
DROP TABLE IF EXISTS `sa_ordergoods`;
CREATE TABLE `sa_ordergoods` (
  `id` int(64) NOT NULL,
  `oid` int(24) DEFAULT NULL,
  `type` int(64) DEFAULT NULL,
  `number` int(64) DEFAULT NULL,
  `city` char(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_ordergoods
-- ----------------------------

-- ----------------------------
-- Table structure for sa_order_good
-- ----------------------------
DROP TABLE IF EXISTS `sa_order_good`;
CREATE TABLE `sa_order_good` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `goodid` varchar(64) NOT NULL,
  `orderid` varchar(64) NOT NULL,
  `number` int(64) NOT NULL,
  `ismony` int(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_order_good
-- ----------------------------
INSERT INTO `sa_order_good` VALUES ('1', '109', '1513677298zSr0admin', '2', '100');
INSERT INTO `sa_order_good` VALUES ('2', '110', '15137339939F89admin', '1', '100');
INSERT INTO `sa_order_good` VALUES ('3', '115', '15137346459Dfqadmin', '1', '100');

-- ----------------------------
-- Table structure for sa_steps
-- ----------------------------
DROP TABLE IF EXISTS `sa_steps`;
CREATE TABLE `sa_steps` (
  `id` int(64) NOT NULL,
  `userid` int(64) NOT NULL,
  `level` int(6) NOT NULL,
  `src` char(255) NOT NULL,
  `city` char(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_steps
-- ----------------------------

-- ----------------------------
-- Table structure for sa_stopcr
-- ----------------------------
DROP TABLE IF EXISTS `sa_stopcr`;
CREATE TABLE `sa_stopcr` (
  `id` int(64) NOT NULL,
  `aim` int(64) NOT NULL,
  `stime` int(11) NOT NULL,
  `ltime` int(11) NOT NULL,
  `days` int(64) NOT NULL,
  `resule` int(64) NOT NULL,
  `crname` char(64) NOT NULL,
  `craddress` char(64) NOT NULL,
  `sonname` char(64) DEFAULT NULL,
  `charge` char(64) DEFAULT NULL,
  `phone` char(16) NOT NULL,
  `pacttime` int(11) NOT NULL,
  `beforeuser` int(64) DEFAULT NULL,
  `remarks` char(255) DEFAULT NULL,
  `city` char(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_stopcr
-- ----------------------------

-- ----------------------------
-- Table structure for sa_visit
-- ----------------------------
DROP TABLE IF EXISTS `sa_visit`;
CREATE TABLE `sa_visit` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `uname` int(64) NOT NULL COMMENT '销售员名字',
  `type` int(64) NOT NULL COMMENT '类型:0=陌拜,1=日常更进，2=客户资源,3=电话上门',
  `aim` int(64) NOT NULL COMMENT '目的:0=首次,1=报价，2=客诉，3=收款，4=追款，5=签单，6=续约，7=回访，8=其他，9=更改项目.',
  `datatime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '日期',
  `area` int(64) NOT NULL COMMENT '区域',
  `road` char(64) NOT NULL COMMENT '街道',
  `crtype` int(64) NOT NULL COMMENT '客户类型:0=粤菜,1=烧烤,2=西餐,3=火锅,4=网吧，5=影院，6=酒吧，7=其他，8=KTV，9=茶餐厅，10=江浙菜，11=美容院，12=饮品店，13=咖啡厅，14=清真菜，15=俱乐部，16=快/简餐,17=川 /辣菜,18=日本料理,19=水疗会所,20=韩国料理 ，21=面包甜点,22=星马月泰菜，23=东/西北菜',
  `crname` char(64) NOT NULL COMMENT '客户名字',
  `sonname` char(64) DEFAULT NULL COMMENT '分店名',
  `charge` char(64) DEFAULT NULL COMMENT '负责人',
  `phone` char(16) NOT NULL COMMENT '电话',
  `remarks` char(255) DEFAULT NULL COMMENT '备注',
  `city` char(5) NOT NULL COMMENT '地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_visit
-- ----------------------------
