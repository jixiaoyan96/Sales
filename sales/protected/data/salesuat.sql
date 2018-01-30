/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : salesuat

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-30 12:54:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `customer_info`
-- ----------------------------
DROP TABLE IF EXISTS `customer_info`;
CREATE TABLE `customer_info` (
  `customer_id` int(100) NOT NULL AUTO_INCREMENT,
  `customer_name` char(30) DEFAULT NULL COMMENT '店名',
  `customer_second_name` varchar(30) DEFAULT NULL COMMENT '分店名',
  `customer_help_count_date` varchar(30) DEFAULT NULL COMMENT '辅助统计日期',
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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_info
-- ----------------------------
INSERT INTO `customer_info` VALUES ('1', '湘语修改测试json', 'jsonjson', 'jsoncustomer_help_count_date', '杨小姐json', '13682203195json', '回访 之前报过价。暂时不考虑年后有需要会联系我们。jsonjsonjson', '天河jso', '龙口东路json', '2018-01-03 00:00:00', '1', '4', '5', 'HK');
INSERT INTO `customer_info` VALUES ('2', '设置测试数据', '', '', '朱小姐', '137608451246', '有合作单位 留卡片。', '天河', '龙口东路', '2018-01-19 00:00:00', '1', '12', '18', 'HK');
INSERT INTO `customer_info` VALUES ('3', '蓉鱼', '', '', '司徒小姐', '18820004588', '介绍服务,有合作的单位,留卡片', '天河', '龙口东路', '2018-01-24 00:00:00', '1', '12', '18', 'HK');
INSERT INTO `customer_info` VALUES ('4', '11', null, null, '111', '1111', null, '', '', null, null, null, null, 'HK');
INSERT INTO `customer_info` VALUES ('5', '海底捞', null, null, '张经理', '13859568584', null, '青羊区', '北大街', '2018-01-18 00:00:00', null, null, null, 'HK');
INSERT INTO `customer_info` VALUES ('6', '海底捞', null, null, '张经理', '13859568584', '夜场  介绍灭虫洗手间服务 洗手间暂不用', '青羊区', '北大街', '2018-01-18 00:00:00', null, null, null, 'HK');
INSERT INTO `customer_info` VALUES ('7', '海底捞', null, null, '小明', '阿斯达', '总备注', '', '', null, null, '9', '11', 'HK');
INSERT INTO `customer_info` VALUES ('8', '海底捞', null, null, '小李', '13568596234', '总备注', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '6', 'HK');
INSERT INTO `customer_info` VALUES ('9', '海底捞', '海底捞3分店', '', '阿斯达', '1111', '总备注', '青羊区', '北大街', '2018-01-18 00:00:00', '1', '10', '7', 'HK');
INSERT INTO `customer_info` VALUES ('10', '海底捞', '', '', '小明', '13859568485', '啊啊啊', '', '', '2018-01-17 00:00:00', '1', '0', '0', 'HK');
INSERT INTO `customer_info` VALUES ('11', '客户名称', '海底捞3分店', '1703', '阿斯达', '13859568485', '总不住', '青羊区', '北大街', '2018-01-23 00:00:00', '1', '2', '8', 'HK');
INSERT INTO `customer_info` VALUES ('12', '海底捞', '海底捞3分店', '1703', '小明', '13859568485', '总备注', '青羊区', '旺泉街', '2018-01-03 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('13', '海底捞', '海底捞3分店', '1703', '小明', '13859568485', '总备注', '青羊区', '旺泉街', '2018-01-03 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('14', '海底捞修改页面新增测', '海底捞3分店', '1703', '小明', '13859568485', '总备注', '青羊区', '旺泉街', '2018-01-03 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('16', '海底捞', '海底捞3分店', '1703', '小明', '13859568485', '总备注', '青羊区', '旺泉街', '2018-01-03 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('17', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('18', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('19', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('20', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('22', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '7', '8', 'HK');
INSERT INTO `customer_info` VALUES ('23', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('24', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('25', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('26', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('27', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('28', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('29', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('30', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('31', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '总备注', '金牛区', '旺泉街', '2018-01-16 00:00:00', '1', '4', '2', 'HK');
INSERT INTO `customer_info` VALUES ('32', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('33', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('34', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('35', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('36', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('37', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('38', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('39', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('40', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('41', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('42', '鲜花店', '鲜花店3分店', '1703', '小明', '13859568485', '总备注销售拜访', '金牛区', '八宝街', '2018-01-10 00:00:00', '1', '6', '11', 'HK');
INSERT INTO `customer_info` VALUES ('43', '客户名称', '客户分店', '1705', '小明', '13859568485', '总备注 关于本次的拜访', '金牛区', '凤凰街', '2018-01-09 00:00:00', '1', '4', '8', 'HK');
INSERT INTO `customer_info` VALUES ('44', '客户名称', '客户分店', '1705', '小明', '13859568485', '总备注 关于本次的拜访', '金牛区', '凤凰街', '2018-01-09 00:00:00', '1', '4', '8', 'HK');
INSERT INTO `customer_info` VALUES ('45', '客户名称', '客户分店', '1705', '小明', '13859568485', '总备注 关于本次的拜访', '金牛区', '凤凰街', '2018-01-09 00:00:00', '1', '4', '8', 'HK');
INSERT INTO `customer_info` VALUES ('46', '客户名称', '客户分店', '1705', '小明', '13859568485', '总备注 关于本次的拜访', '金牛区', '凤凰街', '2018-01-09 00:00:00', '1', '4', '8', 'HK');
INSERT INTO `customer_info` VALUES ('47', '客户名称', '客户分店', '1705', '小明', '13859568485', '总备注 关于本次的拜访', '金牛区', '凤凰街', '2018-01-09 00:00:00', '1', '4', '8', 'HK');
INSERT INTO `customer_info` VALUES ('48', '客户名称', '客户分店', '1705', '小明', '13859568485', '总备注 关于本次的拜访', '金牛区', '凤凰街', '2018-01-09 00:00:00', '1', '4', '8', 'HK');
INSERT INTO `customer_info` VALUES ('49', '海底捞233', '海底捞1分店233', '1703', '阿斯达', '13586954235', '总备注', '青羊区', '旺泉街', '2018-01-02 00:00:00', '1', '5', '10', 'HK');
INSERT INTO `customer_info` VALUES ('50', '海底捞233', '海底捞1分店233', '1703', '阿斯达', '13586954235', '总备注', '青羊区', '旺泉街', '2018-01-02 00:00:00', '1', '5', '10', 'HK');
INSERT INTO `customer_info` VALUES ('51', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('52', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('53', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('54', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('55', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('56', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('57', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('58', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('59', '客户名称', '海底捞1分店', '1705', '阿斯达', '13586954235', '总备注', '青羊区', '北大街', '2018-01-09 00:00:00', '1', '5', '4', 'HK');
INSERT INTO `customer_info` VALUES ('60', '客户名称', '海底捞1分店', '1703', '阿斯达', '1111', '总备注', '青羊区', '旺泉街', '2018-01-10 00:00:00', '1', '3', '6', 'HK');
INSERT INTO `customer_info` VALUES ('61', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '49846+8465416', '金牛区', '', null, '1', '3', '3', 'HK');
INSERT INTO `customer_info` VALUES ('62', '客户名称', '海底捞3分店', '1703', '阿斯达', '13586954235', '49846+8465416', '金牛区', '', null, '1', '3', '3', 'HK');
INSERT INTO `customer_info` VALUES ('63', '客户名称', '海底捞3分店', '1705', '阿斯达', '1111', '备注', '金牛区', '北大街', null, '1', '4', '4', 'HK');
INSERT INTO `customer_info` VALUES ('64', '11', '海底捞1分店', '1703', '阿斯达', '13586954235', '客户尽快还款', '金牛区', '旺泉街', '2018-01-02 00:00:00', '1', '0', '2', 'HK');
INSERT INTO `customer_info` VALUES ('65', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('66', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('67', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('68', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('69', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('70', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('71', '海底捞', '海底捞1分店', '1703', '小明', '1111', '大叔大婶大', '金牛区', '旺泉街', '2018-01-17 00:00:00', '1', '6', '4', 'HK');
INSERT INTO `customer_info` VALUES ('72', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('73', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('74', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('75', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('76', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('77', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('78', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('79', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('80', '客户名称', '海底捞3分店', '1705', '小明', '13859568485', '总备注', '金牛区', '旺泉街', '2018-01-10 00:00:00', '1', '4', '6', 'HK');
INSERT INTO `customer_info` VALUES ('81', '海底捞', '海底捞1分店', '1703', '小明', '13586954235', '总备注', '金牛区', '北大街', '2018-01-10 00:00:00', '1', '6', '5', 'HK');
INSERT INTO `customer_info` VALUES ('82', '湘语233', '海底捞3分店', '1706', '杨小姐', '13682203195', '回访 之前报过价。暂时不考虑年后有需要会联系我们。', '天河', '龙口东路', '2018-01-03 00:00:00', '1', '1', '1', 'HK');
INSERT INTO `customer_info` VALUES ('83', '客户新增数据测试', '客户新增数据测试分店1', '1706', '联系人新增测试人', '13856595658', '客户新增数据测试总备注', '青羊区', '旺泉街', '2018-01-18 00:00:00', '1', '6', '5', 'HK');

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
-- Table structure for `order_customer_info`
-- ----------------------------
DROP TABLE IF EXISTS `order_customer_info`;
CREATE TABLE `order_customer_info` (
  `order_customer_info_id` int(20) NOT NULL AUTO_INCREMENT COMMENT '订单客户信息主键',
  `order_customer_name` varchar(50) DEFAULT NULL COMMENT '订单客户姓名',
  `order_customer_phone` varchar(20) DEFAULT NULL COMMENT '订单客户电话',
  `order_customer_rural` varchar(50) DEFAULT NULL COMMENT '订单客户区域',
  `order_customer_street` varchar(20) DEFAULT NULL COMMENT '订单客户街道',
  `order_customer_seller_id` int(20) DEFAULT NULL COMMENT '订单销售外键',
  `order_customer_total_money` varchar(100) DEFAULT NULL COMMENT '订单客户订单总额',
  PRIMARY KEY (`order_customer_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_customer_info
-- ----------------------------

-- ----------------------------
-- Table structure for `order_info`
-- ----------------------------
DROP TABLE IF EXISTS `order_info`;
CREATE TABLE `order_info` (
  `order_info_id` int(100) NOT NULL DEFAULT '0' COMMENT '销售订单主键',
  `seller_id` int(20) DEFAULT NULL COMMENT '销售外键',
  `order_info_seller_name` varchar(50) DEFAULT NULL COMMENT '销售姓名',
  `order_info_customer_pid` int(20) DEFAULT NULL COMMENT '客户外键',
  `order_customer_name` varchar(50) DEFAULT NULL COMMENT '客户姓名',
  `order_info_rural` varchar(50) DEFAULT NULL COMMENT '订单区域',
  `order_info_rural_location` varchar(50) DEFAULT NULL COMMENT '订单街道地址',
  `order_info_code_number` varchar(150) DEFAULT NULL COMMENT '订单编号',
  `order_info_money_total` varchar(30) DEFAULT NULL COMMENT '销售姓名',
  `order_info_date` varchar(30) DEFAULT NULL COMMENT '订单生成日期',
  PRIMARY KEY (`order_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_info
-- ----------------------------

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
-- Table structure for `service_history`
-- ----------------------------
DROP TABLE IF EXISTS `service_history`;
CREATE TABLE `service_history` (
  `service_history_id` int(100) NOT NULL AUTO_INCREMENT COMMENT '跟进服务主键',
  `service_history_name` varchar(20) DEFAULT NULL COMMENT '拜访服务名',
  `service_history_count` varchar(10) DEFAULT NULL COMMENT '服务',
  `service_history_money` varchar(20) DEFAULT NULL COMMENT '服务金额',
  `service_visit_pid` char(5) DEFAULT NULL COMMENT '跟进外键',
  PRIMARY KEY (`service_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service_history
-- ----------------------------
INSERT INTO `service_history` VALUES ('1', '清洁(清新机)', '4654$', '1111', '6');
INSERT INTO `service_history` VALUES ('2', '清洁(清新机)', '4654$', '1111', '7');
INSERT INTO `service_history` VALUES ('3', '清洁(清新机)', '4654$', '1111', '8');
INSERT INTO `service_history` VALUES ('4', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '9');
INSERT INTO `service_history` VALUES ('5', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '10');
INSERT INTO `service_history` VALUES ('6', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '11');
INSERT INTO `service_history` VALUES ('7', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '12');
INSERT INTO `service_history` VALUES ('8', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '13');
INSERT INTO `service_history` VALUES ('9', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '14');
INSERT INTO `service_history` VALUES ('10', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '15');
INSERT INTO `service_history` VALUES ('11', '灭虫(老鼠蟑螂)', '第一次跟进的第而次服', '第一次跟进的第二次服务价格', '15');
INSERT INTO `service_history` VALUES ('12', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '16');
INSERT INTO `service_history` VALUES ('13', '灭虫(老鼠蟑螂)', '第一次跟进的第而次服', '第一次跟进的第二次服务价格', '16');
INSERT INTO `service_history` VALUES ('14', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '17');
INSERT INTO `service_history` VALUES ('15', '灭虫(老鼠蟑螂)', '第一次跟进的第而次服', '第一次跟进的第二次服务价格', '17');
INSERT INTO `service_history` VALUES ('16', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '18');
INSERT INTO `service_history` VALUES ('17', '灭虫(老鼠蟑螂)', '第一次跟进的第而次服', '第一次跟进的第二次服务价格', '18');
INSERT INTO `service_history` VALUES ('18', '清洁(租赁机器)', '第一次跟进的第一次服', '第一次跟进的第一次服务数量', '20');
INSERT INTO `service_history` VALUES ('19', '灭虫(老鼠蟑螂)', '第一次跟进的第而次服', '第一次跟进的第二次服务价格', '20');
INSERT INTO `service_history` VALUES ('20', '清洁(皂液机)', '第一个价格', '0333333333', '33');
INSERT INTO `service_history` VALUES ('21', '清洁(皂液机)', '第一个价格', '0333333333', '34');
INSERT INTO `service_history` VALUES ('22', '清洁(租赁机器)', '第一个价格', '0333333333', '35');
INSERT INTO `service_history` VALUES ('23', '清洁(租赁机器)', '第一个价格', '0333333333', '36');
INSERT INTO `service_history` VALUES ('24', '清洁(租赁机器)', '第一个价格', '0333333333', '37');
INSERT INTO `service_history` VALUES ('25', '清洁(租赁机器)', '第一个价格', '0333333333', '38');
INSERT INTO `service_history` VALUES ('26', '清洁(租赁机器)', '第一个价格', '0333333333', '39');
INSERT INTO `service_history` VALUES ('27', '清洁(租赁机器)', '第一个价格', '0333333333', '40');
INSERT INTO `service_history` VALUES ('28', '清洁(租赁机器)', '第一个价格', '0333333333', '41');
INSERT INTO `service_history` VALUES ('29', '清洁(租赁机器)', '第一个价格', '0333333333', '42');
INSERT INTO `service_history` VALUES ('30', '清洁(租赁机器)', '第一个价格', '0333333333', '43');
INSERT INTO `service_history` VALUES ('31', '清洁(皂液机)', '232323', '232323', '44');
INSERT INTO `service_history` VALUES ('32', '清洁(租赁机器)', '第一个价格', '0333333333', '45');
INSERT INTO `service_history` VALUES ('33', '清洁(水盆)', '跟进二服务22', '第一次跟进的第二次服务价格', '45');
INSERT INTO `service_history` VALUES ('34', '清洁(租赁机器)', '第一个价格', '0333333333', '47');
INSERT INTO `service_history` VALUES ('35', '清洁(水盆)', '跟进二服务22', '第一次跟进的第二次服务价格', '47');
INSERT INTO `service_history` VALUES ('36', '清洁(皂液机)', '9', '130', '48');
INSERT INTO `service_history` VALUES ('37', '清洁(清新机)', '9', '130', '48');
INSERT INTO `service_history` VALUES ('38', '清洁(皂液机)', '14141', '4141', '48');
INSERT INTO `service_history` VALUES ('39', '灭虫(老鼠)', '14141', '170', '49');
INSERT INTO `service_history` VALUES ('40', '清洁(皂液机)', '232323', '0333333333', '50');
INSERT INTO `service_history` VALUES ('41', '清洁(尿斗)', '跟进二服务22', '跟进二服务222', '50');
INSERT INTO `service_history` VALUES ('42', '清洁(水盆)', '跟进三服务22', '跟进二服务222', '50');
INSERT INTO `service_history` VALUES ('43', '清洁(皂液机)', '撒大大', '130', '51');
INSERT INTO `service_history` VALUES ('44', '清洁(清新机)', '撒搭', '130', '51');
INSERT INTO `service_history` VALUES ('45', '清洁(租赁机器)', '14141', '170', '51');
INSERT INTO `service_history` VALUES ('46', '清洁(租赁机器)', '14141', '4141', '52');
INSERT INTO `service_history` VALUES ('47', '清洁(租赁机器)', '第一个价格', '0333333333', '53');
INSERT INTO `service_history` VALUES ('48', '清洁(清新机)', '第一个价格', '232323', '54');
INSERT INTO `service_history` VALUES ('49', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '54');
INSERT INTO `service_history` VALUES ('50', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '54');
INSERT INTO `service_history` VALUES ('51', '清洁(清新机)', '第一个价格', '232323', '55');
INSERT INTO `service_history` VALUES ('52', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '55');
INSERT INTO `service_history` VALUES ('53', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '55');
INSERT INTO `service_history` VALUES ('54', '清洁(清新机)', '第一个价格', '232323', '56');
INSERT INTO `service_history` VALUES ('55', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '56');
INSERT INTO `service_history` VALUES ('56', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '56');
INSERT INTO `service_history` VALUES ('57', '清洁(清新机)', '第一个价格', '232323', '58');
INSERT INTO `service_history` VALUES ('58', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '58');
INSERT INTO `service_history` VALUES ('59', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '58');
INSERT INTO `service_history` VALUES ('60', '清洁(清新机)', '第一个价格', '232323', '59');
INSERT INTO `service_history` VALUES ('61', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '59');
INSERT INTO `service_history` VALUES ('62', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '59');
INSERT INTO `service_history` VALUES ('63', '清洁(清新机)', '第一个价格', '232323', '61');
INSERT INTO `service_history` VALUES ('64', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '61');
INSERT INTO `service_history` VALUES ('65', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '61');
INSERT INTO `service_history` VALUES ('66', '清洁(清新机)', '第一个价格', '232323', '62');
INSERT INTO `service_history` VALUES ('67', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '62');
INSERT INTO `service_history` VALUES ('68', '清洁(皂液机)', '跟进三服务22', '跟进三服务222', '62');
INSERT INTO `service_history` VALUES ('69', '清洁(皂液机)', '9', '130', '63');
INSERT INTO `service_history` VALUES ('70', '清洁(水盆)', '9', '130', '63');
INSERT INTO `service_history` VALUES ('71', '清洁(清新机)', '8', '4141', '63');
INSERT INTO `service_history` VALUES ('72', '灭虫(租灭蝇灯)', '第二次跟进第一个服务', '4141', '64');
INSERT INTO `service_history` VALUES ('73', '清洁(清新机)', '232323', '0333333333', '65');
INSERT INTO `service_history` VALUES ('74', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '65');
INSERT INTO `service_history` VALUES ('75', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '65');
INSERT INTO `service_history` VALUES ('76', '清洁(皂液机)', '9安全区群', '130啊啊', '66');
INSERT INTO `service_history` VALUES ('77', '灭虫(老鼠)', '9阿斯达', '130sadad', '66');
INSERT INTO `service_history` VALUES ('78', '清洁(租赁机器)', '14141', '第二次跟进第一个服务价格', '66');
INSERT INTO `service_history` VALUES ('79', '清洁(尿斗)', '14141', '4141', '67');
INSERT INTO `service_history` VALUES ('80', '清洁(清新机)', '232323', '0333333333', '68');
INSERT INTO `service_history` VALUES ('81', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '68');
INSERT INTO `service_history` VALUES ('82', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '68');
INSERT INTO `service_history` VALUES ('83', '清洁(清新机)', '232323', '0333333333', '69');
INSERT INTO `service_history` VALUES ('84', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '69');
INSERT INTO `service_history` VALUES ('85', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '69');
INSERT INTO `service_history` VALUES ('86', '清洁(清新机)', '232323', '0333333333', '70');
INSERT INTO `service_history` VALUES ('87', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '70');
INSERT INTO `service_history` VALUES ('88', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '70');
INSERT INTO `service_history` VALUES ('89', '清洁(清新机)', '232323', '0333333333', '71');
INSERT INTO `service_history` VALUES ('90', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '71');
INSERT INTO `service_history` VALUES ('91', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '71');
INSERT INTO `service_history` VALUES ('92', '清洁(清新机)', '232323', '0333333333', '73');
INSERT INTO `service_history` VALUES ('93', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '73');
INSERT INTO `service_history` VALUES ('94', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '73');
INSERT INTO `service_history` VALUES ('95', '清洁(清新机)', '232323', '0333333333', '75');
INSERT INTO `service_history` VALUES ('96', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '75');
INSERT INTO `service_history` VALUES ('97', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '75');
INSERT INTO `service_history` VALUES ('98', '清洁(清新机)', '232323', '0333333333', '77');
INSERT INTO `service_history` VALUES ('99', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '77');
INSERT INTO `service_history` VALUES ('100', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '77');
INSERT INTO `service_history` VALUES ('101', '灭虫(老鼠蟑螂)', '4141', '第二次跟进第二个服务价格', '78');
INSERT INTO `service_history` VALUES ('102', '清洁(水盆)', '85', '第二次跟进第三个服务价格', '78');
INSERT INTO `service_history` VALUES ('103', '清洁(租赁机器)', '14141', '第二次跟进第一个服务价格', '78');
INSERT INTO `service_history` VALUES ('104', '清洁(皂液机)', '9安全区群', '130啊啊', '79');
INSERT INTO `service_history` VALUES ('105', '灭虫(老鼠)', '9阿斯达', '130sadad', '79');
INSERT INTO `service_history` VALUES ('106', '清洁(尿斗)', '14141', '4141', '79');
INSERT INTO `service_history` VALUES ('107', '清洁(清新机)', '232323', '0333333333', '80');
INSERT INTO `service_history` VALUES ('108', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '80');
INSERT INTO `service_history` VALUES ('109', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '80');
INSERT INTO `service_history` VALUES ('110', '灭虫(老鼠蟑螂)', '4141', '第二次跟进第二个服务价格', '81');
INSERT INTO `service_history` VALUES ('111', '清洁(水盆)', '85', '第二次跟进第三个服务价格', '81');
INSERT INTO `service_history` VALUES ('112', '清洁(租赁机器)', '14141', '第二次跟进第一个服务价格', '81');
INSERT INTO `service_history` VALUES ('113', '清洁(皂液机)', '9安全区群', '130啊啊', '82');
INSERT INTO `service_history` VALUES ('114', '灭虫(老鼠)', '9阿斯达', '130sadad', '82');
INSERT INTO `service_history` VALUES ('115', '清洁(尿斗)', '14141', '4141', '82');
INSERT INTO `service_history` VALUES ('116', '清洁(清新机)', '第一个价格', '0333333333', '83');
INSERT INTO `service_history` VALUES ('117', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '83');
INSERT INTO `service_history` VALUES ('118', '清洁(租赁机器)', '跟进二服务22', '第一次跟进的第二次服务价格', '83');
INSERT INTO `service_history` VALUES ('119', '清洁(皂液机)', '第二次跟进第二个服务', '第二次跟进第二个服务价格', '84');
INSERT INTO `service_history` VALUES ('120', '灭虫(老鼠)', '第二次跟进第二个服务', '第二次跟进第二个服务价格', '84');
INSERT INTO `service_history` VALUES ('121', '清洁(水盆)', '第二次跟进第一个服务', '第二次跟进第一个服务价格', '84');
INSERT INTO `service_history` VALUES ('122', '灭虫(蟑螂)', '撒大大', '撒大大', '85');
INSERT INTO `service_history` VALUES ('123', '清洁(马桶)', '阿斯达多所', '撒大大撒多', '85');
INSERT INTO `service_history` VALUES ('124', '清洁(租赁机器)', '第二次跟进第一个服务', '撒大大', '85');
INSERT INTO `service_history` VALUES ('125', '清洁(清新机)', '232323', '0333333333', '86');
INSERT INTO `service_history` VALUES ('126', '清洁(皂液机)', '跟进二服务22', '第一次跟进的第二次服务价格', '86');
INSERT INTO `service_history` VALUES ('127', '灭虫(果蝇)', '跟进三服务22', '跟进三服务222', '86');
INSERT INTO `service_history` VALUES ('128', '清洁(水盆)', '4141', '第二次跟进第二个服务价格', '87');
INSERT INTO `service_history` VALUES ('129', '清洁(皂液机)', '第二次跟进第二个服务', '414141', '87');
INSERT INTO `service_history` VALUES ('130', '清洁(皂液机)', '第二次跟进第一个服务', '第二次跟进第一个服务价格', '87');
INSERT INTO `service_history` VALUES ('131', '清洁(水盆)', '第一个价格', '0333333333', '88');
INSERT INTO `service_history` VALUES ('132', '清洁(皂液机)', '跟进三服务22', '第一次跟进的第二次服务价格', '88');
INSERT INTO `service_history` VALUES ('133', '清洁(租赁机器)', '第一次跟进的第而次服', '跟进二服务222', '88');
INSERT INTO `service_history` VALUES ('136', '灭虫(蟑螂)', '修改测试', '灭虫(租灭蝇灯)', '90');
INSERT INTO `service_history` VALUES ('137', '清洁(水盆)', '修改测试', '修改数据测试', '90');
INSERT INTO `service_history` VALUES ('138', '清洁(水盆)', '撒大受打击爱哦集合', '灭虫(租灭蝇灯)', '90');
INSERT INTO `service_history` VALUES ('139', '清洁(水盆)', '232323', '灭虫(租灭蝇灯)', '92');

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
  `visit_customer_fid` char(5) DEFAULT NULL COMMENT '客户外键',
  `visit_seller_fid` char(5) DEFAULT NULL COMMENT '销售外键',
  `visit_notes` varchar(100) DEFAULT NULL COMMENT '单次跟进备注',
  `visit_service_money` varchar(50) DEFAULT NULL COMMENT '单次跟进备注',
  `visit_date` varchar(50) DEFAULT NULL COMMENT '单次跟进日期',
  `visit_definition` varchar(20) DEFAULT NULL COMMENT '拜访目的',
  PRIMARY KEY (`visit_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visit_info
-- ----------------------------
INSERT INTO `visit_info` VALUES ('1', '24', '', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('2', '25', '', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('3', '26', '1', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('4', '27', '1', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('5', '28', '1', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('6', '29', '1', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('7', '30', '1', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('8', '31', '1', '', '', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('9', '32', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('10', '33', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('11', '34', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('12', '35', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('13', '36', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('14', '37', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('15', '38', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('16', '39', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('17', '40', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('18', '41', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('19', '41', '1', '第二次备注', '第二次总金额', '2018-02-22', '11');
INSERT INTO `visit_info` VALUES ('20', '42', '1', '第一次备注', '第一次总金额', '2018-01-17', '客诉');
INSERT INTO `visit_info` VALUES ('21', '42', '1', '第二次备注', '第二次总金额', '2018-02-22', '11');
INSERT INTO `visit_info` VALUES ('22', '43', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-13', '客诉');
INSERT INTO `visit_info` VALUES ('23', '43', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-25', '7');
INSERT INTO `visit_info` VALUES ('24', '44', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-13', '客诉');
INSERT INTO `visit_info` VALUES ('25', '44', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-25', '7');
INSERT INTO `visit_info` VALUES ('26', '45', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-13', '客诉');
INSERT INTO `visit_info` VALUES ('27', '45', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-25', '7');
INSERT INTO `visit_info` VALUES ('28', '46', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-13', '客诉');
INSERT INTO `visit_info` VALUES ('29', '46', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-25', '7');
INSERT INTO `visit_info` VALUES ('30', '47', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-13', '客诉');
INSERT INTO `visit_info` VALUES ('31', '47', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-25', '7');
INSERT INTO `visit_info` VALUES ('32', '48', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-13', '客诉');
INSERT INTO `visit_info` VALUES ('33', '49', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('34', '50', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('35', '51', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('36', '52', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('37', '53', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('38', '54', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('39', '55', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('40', '56', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('41', '57', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('42', '58', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('43', '59', '1', '', '', '2018-01-11', '客诉');
INSERT INTO `visit_info` VALUES ('44', '60', '1', '111111111', '11111', '2018-01-10', '追款');
INSERT INTO `visit_info` VALUES ('45', '61', '1', '', '', '2018-01-25', '报价');
INSERT INTO `visit_info` VALUES ('46', '61', '1', '', '', '2018-01-17', '客户资源');
INSERT INTO `visit_info` VALUES ('47', '62', '1', '', '', '2018-01-25', '报价');
INSERT INTO `visit_info` VALUES ('48', '62', '1', '', '', '2018-01-17', '客户资源');
INSERT INTO `visit_info` VALUES ('49', '62', '1', '', '', '2018-01-23', '客户资源');
INSERT INTO `visit_info` VALUES ('50', '63', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-10', '收款');
INSERT INTO `visit_info` VALUES ('51', '63', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-25', '陌拜');
INSERT INTO `visit_info` VALUES ('52', '63', '1', '第SAN次跟进备注', '第SAN次跟进总金额', '2018-01-05', '其他');
INSERT INTO `visit_info` VALUES ('53', '64', '1', '', '', '2018-01-10', '客诉');
INSERT INTO `visit_info` VALUES ('54', '65', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('55', '66', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('56', '67', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('57', '67', '1', '第二次跟进', '第二次总金额', '2018-01-24', '其他');
INSERT INTO `visit_info` VALUES ('58', '68', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('59', '69', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('60', '69', '1', '第二次跟进', '第二次总金额', '2018-01-24', '其他');
INSERT INTO `visit_info` VALUES ('61', '70', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('62', '71', '1', '第一次跟进', '第一次总金额', '2018-01-09', '追款');
INSERT INTO `visit_info` VALUES ('63', '71', '1', '第二次跟进', '第二次总金额', '2018-01-24', '其他');
INSERT INTO `visit_info` VALUES ('64', '71', '1', '第三次跟进', '第三次总金额', '2018-01-11', '其他');
INSERT INTO `visit_info` VALUES ('65', '72', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('66', '72', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-23', '更改项目');
INSERT INTO `visit_info` VALUES ('67', '72', '1', '第三次跟进备注', '第三次跟进总金额', '2018-01-10', '拜访目的');
INSERT INTO `visit_info` VALUES ('68', '73', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('69', '74', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('70', '75', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('71', '76', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('72', '76', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-23', '更改项目');
INSERT INTO `visit_info` VALUES ('73', '77', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('74', '77', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-23', '更改项目');
INSERT INTO `visit_info` VALUES ('75', '78', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('76', '78', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-23', '更改项目');
INSERT INTO `visit_info` VALUES ('77', '79', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('78', '79', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-23', '更改项目');
INSERT INTO `visit_info` VALUES ('79', '79', '1', '第三次跟进备注', '第三次跟进总金额', '2018-01-10', '拜访目的');
INSERT INTO `visit_info` VALUES ('80', '80', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('81', '80', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-23', '更改项目');
INSERT INTO `visit_info` VALUES ('82', '80', '1', '第三次跟进备注', '第三次跟进总金额', '2018-01-10', '拜访目的');
INSERT INTO `visit_info` VALUES ('83', '81', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('84', '81', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-17', '陌拜');
INSERT INTO `visit_info` VALUES ('85', '81', '1', '第三次跟进备注', '第三次跟进总金额', '2018-01-16', '陌拜');
INSERT INTO `visit_info` VALUES ('86', '83', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-24', '追款');
INSERT INTO `visit_info` VALUES ('87', '83', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-24', '日常跟进');
INSERT INTO `visit_info` VALUES ('88', '14', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '签单');
INSERT INTO `visit_info` VALUES ('90', '1', '1', '第二次跟进备注', '第二次跟进总金额', '2018-01-10', '首次');
INSERT INTO `visit_info` VALUES ('91', '3', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-24', '续约');
INSERT INTO `visit_info` VALUES ('92', '1', '1', '第一次跟进备注', '第一次跟进总金额', '2018-01-17', '客诉');
