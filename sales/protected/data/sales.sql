/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sales

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-22 18:19:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `customer_info`
-- ----------------------------
DROP TABLE IF EXISTS `customer_info`;
CREATE TABLE `customer_info` (
  `customer_id` int(100) NOT NULL AUTO_INCREMENT,
  `customer_name` char(20) DEFAULT NULL COMMENT '店名',
  `customer_contact` char(20) DEFAULT NULL COMMENT '联系人称呼',
  `customer_contact_phone` char(20) DEFAULT NULL,
  `customer_notes` varchar(200) DEFAULT NULL COMMENT '总备注',
  `customer_district` char(5) DEFAULT NULL COMMENT '地区外键',
  `customer_street` varchar(50) DEFAULT NULL COMMENT '区域街道',
  `customer_create_date` timestamp NULL DEFAULT NULL COMMENT '创建拜访的日期',
  `customer_create_sellers_id` int(100) DEFAULT NULL,
  `visit_kinds` int(5) DEFAULT NULL COMMENT '类型',
  `customer_kinds` int(5) DEFAULT NULL COMMENT '客户种类',
  `city` char(5) DEFAULT NULL COMMENT '城市',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_info
-- ----------------------------
INSERT INTO `customer_info` VALUES ('1', '湘语', '杨小姐', '13682203195', '回访 之前报过价。暂时不考虑年后有需要会联系我们。', '天河', '龙口东路', '2018-01-03 10:37:51', '1', '12', '18', 'HK');
INSERT INTO `customer_info` VALUES ('2', '洞庭湖鱼头王', '朱小姐', '137608451246', '有合作单位 留卡片。', '天河', '龙口东路', '2018-01-19 10:39:11', '1', '12', '18', 'HK');
INSERT INTO `customer_info` VALUES ('3', '蓉鱼', '司徒小姐', '18820004588', '介绍服务,有合作的单位,留卡片', '天河', '龙口东路', '2018-01-24 10:40:08', '1', '12', '18', 'HK');

-- ----------------------------
-- Table structure for `customer_kinds`
-- ----------------------------
DROP TABLE IF EXISTS `customer_kinds`;
CREATE TABLE `customer_kinds` (
  `customer_kinds_id` int(5) NOT NULL AUTO_INCREMENT COMMENT '客户种类',
  `customer_kinds_name` varchar(30) DEFAULT NULL COMMENT '客户种类',
  PRIMARY KEY (`customer_kinds_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_kinds
-- ----------------------------
INSERT INTO `customer_kinds` VALUES ('1', '粤菜');
INSERT INTO `customer_kinds` VALUES ('2', '烧烤');
INSERT INTO `customer_kinds` VALUES ('3', '西餐');
INSERT INTO `customer_kinds` VALUES ('4', '火锅');
INSERT INTO `customer_kinds` VALUES ('5', '网吧');
INSERT INTO `customer_kinds` VALUES ('6', '影院');
INSERT INTO `customer_kinds` VALUES ('7', '酒吧');
INSERT INTO `customer_kinds` VALUES ('8', '其它');
INSERT INTO `customer_kinds` VALUES ('9', 'ktv');
INSERT INTO `customer_kinds` VALUES ('10', '茶餐厅');
INSERT INTO `customer_kinds` VALUES ('11', '江浙菜');
INSERT INTO `customer_kinds` VALUES ('12', '美容院');
INSERT INTO `customer_kinds` VALUES ('13', '饮品店');
INSERT INTO `customer_kinds` VALUES ('14', '咖啡厅');
INSERT INTO `customer_kinds` VALUES ('15', '清真菜');
INSERT INTO `customer_kinds` VALUES ('16', '俱乐部');
INSERT INTO `customer_kinds` VALUES ('17', '快/简餐');
INSERT INTO `customer_kinds` VALUES ('18', '川/辣菜');
INSERT INTO `customer_kinds` VALUES ('19', '日本料理');
INSERT INTO `customer_kinds` VALUES ('20', '水疗会所');
INSERT INTO `customer_kinds` VALUES ('21', '韩国料理');
INSERT INTO `customer_kinds` VALUES ('22', '面包甜点');
INSERT INTO `customer_kinds` VALUES ('23', '星马越泰菜');
INSERT INTO `customer_kinds` VALUES ('24', '东/西北菜');

-- ----------------------------
-- Table structure for `sales_kinds`
-- ----------------------------
DROP TABLE IF EXISTS `sales_kinds`;
CREATE TABLE `sales_kinds` (
  `kinds_id` int(20) NOT NULL AUTO_INCREMENT,
  `kinds_name` char(20) DEFAULT NULL,
  `kinds_pid` int(20) DEFAULT NULL,
  PRIMARY KEY (`kinds_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sales_kinds
-- ----------------------------
INSERT INTO `sales_kinds` VALUES ('1', '拜访类型', '0');
INSERT INTO `sales_kinds` VALUES ('2', '拜访目的', '0');
INSERT INTO `sales_kinds` VALUES ('3', '客户种类', '0');
INSERT INTO `sales_kinds` VALUES ('4', '清洁', '0');
INSERT INTO `sales_kinds` VALUES ('5', '灭虫', '0');
INSERT INTO `sales_kinds` VALUES ('6', '飘盈香', '0');
INSERT INTO `sales_kinds` VALUES ('7', '甲醛', '0');
INSERT INTO `sales_kinds` VALUES ('8', '服务类别  合计金额', '0');
INSERT INTO `sales_kinds` VALUES ('9', '纸品', '0');
INSERT INTO `sales_kinds` VALUES ('10', '一次性售卖', '0');
INSERT INTO `sales_kinds` VALUES ('11', '陌拜', '1');
INSERT INTO `sales_kinds` VALUES ('12', '日常跟进', '1');
INSERT INTO `sales_kinds` VALUES ('13', '客户资源', '1');
INSERT INTO `sales_kinds` VALUES ('14', '电话上门', '1');
INSERT INTO `sales_kinds` VALUES ('15', '首次', '2');
INSERT INTO `sales_kinds` VALUES ('16', '报价', '2');
INSERT INTO `sales_kinds` VALUES ('17', '客诉', '2');
INSERT INTO `sales_kinds` VALUES ('18', '收款', '2');
INSERT INTO `sales_kinds` VALUES ('19', '追款', '2');
INSERT INTO `sales_kinds` VALUES ('20', '签单', '2');
INSERT INTO `sales_kinds` VALUES ('21', '续约', '2');
INSERT INTO `sales_kinds` VALUES ('22', '回访', '2');
INSERT INTO `sales_kinds` VALUES ('23', '其他', '2');
INSERT INTO `sales_kinds` VALUES ('24', '更改项目', '2');
INSERT INTO `sales_kinds` VALUES ('25', '粤菜', '3');
INSERT INTO `sales_kinds` VALUES ('26', '烧烤', '3');
INSERT INTO `sales_kinds` VALUES ('27', '西餐', '3');
INSERT INTO `sales_kinds` VALUES ('28', '火锅', '3');
INSERT INTO `sales_kinds` VALUES ('29', '网吧', '3');
INSERT INTO `sales_kinds` VALUES ('30', '影院', '3');
INSERT INTO `sales_kinds` VALUES ('31', '酒吧', '3');
INSERT INTO `sales_kinds` VALUES ('32', '其它', '3');
INSERT INTO `sales_kinds` VALUES ('33', 'ktv', '3');
INSERT INTO `sales_kinds` VALUES ('34', '茶餐厅', '3');
INSERT INTO `sales_kinds` VALUES ('35', '江浙菜', '3');
INSERT INTO `sales_kinds` VALUES ('36', '美容院', '3');
INSERT INTO `sales_kinds` VALUES ('37', '饮品店', '3');
INSERT INTO `sales_kinds` VALUES ('38', '咖啡厅', '3');
INSERT INTO `sales_kinds` VALUES ('39', '清真菜', '3');
INSERT INTO `sales_kinds` VALUES ('40', '俱乐部', '3');
INSERT INTO `sales_kinds` VALUES ('41', '快/简餐', '3');
INSERT INTO `sales_kinds` VALUES ('42', '川/辣菜', '3');
INSERT INTO `sales_kinds` VALUES ('43', '日本料理', '3');
INSERT INTO `sales_kinds` VALUES ('44', '水疗会所', '3');
INSERT INTO `sales_kinds` VALUES ('45', '韩国料理', '3');
INSERT INTO `sales_kinds` VALUES ('46', '面包甜点', '3');
INSERT INTO `sales_kinds` VALUES ('47', '星马越泰菜', '3');
INSERT INTO `sales_kinds` VALUES ('48', '东/西北菜', '3');
INSERT INTO `sales_kinds` VALUES ('49', '马桶', '4');
INSERT INTO `sales_kinds` VALUES ('50', '尿斗', '4');
INSERT INTO `sales_kinds` VALUES ('51', '水盆', '4');
INSERT INTO `sales_kinds` VALUES ('52', '清新机', '4');
INSERT INTO `sales_kinds` VALUES ('53', '皂液机', '4');
INSERT INTO `sales_kinds` VALUES ('54', '租赁机器', '4');
INSERT INTO `sales_kinds` VALUES ('55', '年金额', '4');
INSERT INTO `sales_kinds` VALUES ('56', '老鼠', '5');
INSERT INTO `sales_kinds` VALUES ('57', '蟑螂', '5');
INSERT INTO `sales_kinds` VALUES ('58', '果蝇', '5');
INSERT INTO `sales_kinds` VALUES ('59', '租灭蝇灯', '5');
INSERT INTO `sales_kinds` VALUES ('60', '老鼠蟑螂', '5');
INSERT INTO `sales_kinds` VALUES ('61', '老鼠果蝇', '5');
INSERT INTO `sales_kinds` VALUES ('62', '老鼠蟑螂果蝇', '5');
INSERT INTO `sales_kinds` VALUES ('63', '老鼠蟑螂+租灯', '5');
INSERT INTO `sales_kinds` VALUES ('64', '老鼠果蝇+租灯', '5');
INSERT INTO `sales_kinds` VALUES ('65', '老鼠蟑螂果蝇+租灯', '5');
INSERT INTO `sales_kinds` VALUES ('66', '小机', '6');
INSERT INTO `sales_kinds` VALUES ('67', '中机', '6');
INSERT INTO `sales_kinds` VALUES ('68', '大机', '6');
INSERT INTO `sales_kinds` VALUES ('69', '迷你小机', '6');
INSERT INTO `sales_kinds` VALUES ('70', '除甲醛', '7');
INSERT INTO `sales_kinds` VALUES ('71', 'AC30', '7');
INSERT INTO `sales_kinds` VALUES ('72', '迷你清洁炮', '7');

-- ----------------------------
-- Table structure for `sellers_info`
-- ----------------------------
DROP TABLE IF EXISTS `sellers_info`;
CREATE TABLE `sellers_info` (
  `sellers_id` int(12) NOT NULL AUTO_INCREMENT COMMENT '销售员主键',
  `sellers_name` varchar(20) DEFAULT NULL COMMENT '销售员名',
  `city` char(5) DEFAULT NULL COMMENT '城市权限',
  PRIMARY KEY (`sellers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sellers_info
-- ----------------------------
INSERT INTO `sellers_info` VALUES ('1', '小明', 'HK');
INSERT INTO `sellers_info` VALUES ('2', '小王', 'HK');
INSERT INTO `sellers_info` VALUES ('3', '小李', 'HK');

-- ----------------------------
-- Table structure for `sellers_user_bind_v`
-- ----------------------------
DROP TABLE IF EXISTS `sellers_user_bind_v`;
CREATE TABLE `sellers_user_bind_v` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `sellers_id` int(20) DEFAULT NULL COMMENT '销售员外键',
  `sellers_name` varchar(15) DEFAULT NULL COMMENT '销售员姓名',
  `user_id` varchar(20) DEFAULT NULL COMMENT '登录的销售员账号主键',
  `user_name` varchar(30) DEFAULT NULL COMMENT '登录的销售员disp_name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sellers_user_bind_v
-- ----------------------------
INSERT INTO `sellers_user_bind_v` VALUES ('1', '1', '小明', 'admin', 'administrator');

-- ----------------------------
-- Table structure for `visit_definition`
-- ----------------------------
DROP TABLE IF EXISTS `visit_definition`;
CREATE TABLE `visit_definition` (
  `visit_definition_id` int(5) NOT NULL AUTO_INCREMENT,
  `visit_definition_name` varchar(25) DEFAULT NULL COMMENT '拜访目的',
  PRIMARY KEY (`visit_definition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visit_definition
-- ----------------------------
INSERT INTO `visit_definition` VALUES ('1', '首次');
INSERT INTO `visit_definition` VALUES ('2', '报价');
INSERT INTO `visit_definition` VALUES ('3', '客诉');
INSERT INTO `visit_definition` VALUES ('4', '收款');
INSERT INTO `visit_definition` VALUES ('5', '追款');
INSERT INTO `visit_definition` VALUES ('6', '签单');
INSERT INTO `visit_definition` VALUES ('7', '续约');
INSERT INTO `visit_definition` VALUES ('8', '回访');
INSERT INTO `visit_definition` VALUES ('9', '其他');
INSERT INTO `visit_definition` VALUES ('10', '更改项目');
INSERT INTO `visit_definition` VALUES ('11', '拜访目的');
INSERT INTO `visit_definition` VALUES ('12', '陌拜');
INSERT INTO `visit_definition` VALUES ('13', '日常跟进');
INSERT INTO `visit_definition` VALUES ('14', '客户资源');
INSERT INTO `visit_definition` VALUES ('15', '电话上门');

-- ----------------------------
-- Table structure for `visit_info`
-- ----------------------------
DROP TABLE IF EXISTS `visit_info`;
CREATE TABLE `visit_info` (
  `visit_info_id` int(100) NOT NULL AUTO_INCREMENT,
  `visit_customer_fid` int(100) DEFAULT NULL COMMENT '客户外键',
  `visit_seller_fid` int(100) DEFAULT NULL COMMENT '销售外键',
  `visit_service_fid` int(100) DEFAULT NULL COMMENT '服务外键',
  `visit_service_count` varchar(50) DEFAULT NULL COMMENT '单次跟进备注',
  `visit_date` varchar(50) DEFAULT NULL COMMENT '单次跟进日期',
  `visit_definition` int(5) DEFAULT NULL COMMENT '拜访目的',
  PRIMARY KEY (`visit_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visit_info
-- ----------------------------
