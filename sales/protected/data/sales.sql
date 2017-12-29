/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : sales

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-29 16:10:45
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_good
-- ----------------------------
INSERT INTO `sa_good` VALUES ('1', '5', '清洁', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('2', '1', '灭虫', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('3', '2', '飘盈香', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('4', '3', '甲醛', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('5', '4', '纸品', '0', '1', '0');
INSERT INTO `sa_good` VALUES ('6', '100', '马桶', '87', '2', '5');
INSERT INTO `sa_good` VALUES ('7', '101', '尿斗', '68', '2', '5');
INSERT INTO `sa_good` VALUES ('8', '102', '水盆', '78', '2', '5');
INSERT INTO `sa_good` VALUES ('9', '103', '清新机', '357', '2', '5');
INSERT INTO `sa_good` VALUES ('10', '104', '皂液机', '88', '2', '5');
INSERT INTO `sa_good` VALUES ('11', '105', '租赁机器', '265', '2', '5');
INSERT INTO `sa_good` VALUES ('12', '106', '老鼠', '80', '2', '1');
INSERT INTO `sa_good` VALUES ('13', '107', '蟑螂', '80', '2', '1');
INSERT INTO `sa_good` VALUES ('14', '108', '果蝇', '80', '2', '1');
INSERT INTO `sa_good` VALUES ('15', '109', '租灭蝇灯', '75', '2', '1');
INSERT INTO `sa_good` VALUES ('16', '110', '老鼠蟑螂', '125', '2', '1');
INSERT INTO `sa_good` VALUES ('17', '111', '老鼠果蝇', '369', '2', '1');
INSERT INTO `sa_good` VALUES ('18', '112', '蟑螂果蝇', '257', '2', '1');
INSERT INTO `sa_good` VALUES ('19', '113', '老鼠蟑螂果蝇', '157', '2', '1');
INSERT INTO `sa_good` VALUES ('20', '114', '老鼠蟑螂+租灯', '358', '2', '1');
INSERT INTO `sa_good` VALUES ('21', '115', '蟑螂果蝇+租灯', '178', '2', '1');
INSERT INTO `sa_good` VALUES ('22', '116', '老鼠蟑螂果蝇+租灯', '287', '2', '1');
INSERT INTO `sa_good` VALUES ('23', '117', '小机', '157', '2', '2');
INSERT INTO `sa_good` VALUES ('24', '118', '大机', '300', '2', '2');
INSERT INTO `sa_good` VALUES ('25', '119', '中机', '210', '2', '2');
INSERT INTO `sa_good` VALUES ('26', '120', '迷你小机', '99', '2', '2');
INSERT INTO `sa_good` VALUES ('27', '121', '除甲醛', '180', '2', '3');
INSERT INTO `sa_good` VALUES ('28', '122', 'AC30', '351', '2', '3');
INSERT INTO `sa_good` VALUES ('29', '123', 'PR10', '125', '2', '3');
INSERT INTO `sa_good` VALUES ('30', '124', '迷你清洁炮', '157', '2', '3');
INSERT INTO `sa_good` VALUES ('31', '125', '擦手纸', '120', '2', '4');
INSERT INTO `sa_good` VALUES ('32', '126', '大卷厕纸', '140', '2', '4');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_order
-- ----------------------------
INSERT INTO `sa_order` VALUES ('1', '1514449716P8v4admin', '测试客户1', '2017-12-28 16:28:36', '1430', 'admin', '西街XX路XX号', 'HK', '西街', null, null, null);
INSERT INTO `sa_order` VALUES ('3', '1514519142vo3ladmin', '多个商品测试', '2017-12-29 11:45:42', '150', 'admin', '西街XX路XX号', 'HK', '未知', null, null, null);

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
  `goodagio` int(64) DEFAULT '0' COMMENT '折扣',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_order_good
-- ----------------------------
INSERT INTO `sa_order_good` VALUES ('1', '119', '1514449716P8v4admin', '5', '1000', '0');
INSERT INTO `sa_order_good` VALUES ('2', '105', '1514449716P8v4admin', '1', '260', '0');
INSERT INTO `sa_order_good` VALUES ('3', '115', '1514449716P8v4admin', '1', '170', '0');
INSERT INTO `sa_order_good` VALUES ('4', '120', '151444989371Opadmin', '1', '99', '0');
INSERT INTO `sa_order_good` VALUES ('5', '126', '151444989371Opadmin', '2', '280', '0');
INSERT INTO `sa_order_good` VALUES ('6', '116', '151444989371Opadmin', '3', '861', '0');
INSERT INTO `sa_order_good` VALUES ('7', '104', '151444989371Opadmin', '4', '352', '0');
INSERT INTO `sa_order_good` VALUES ('8', '124', '151444989371Opadmin', '1', '157', '0');
INSERT INTO `sa_order_good` VALUES ('9', '124', '1514519142vo3ladmin', '1', '150', '0');
INSERT INTO `sa_order_good` VALUES ('10', '123', '15145341342KGjadmin', '5', '600', '0');

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
-- Table structure for sa_type
-- ----------------------------
DROP TABLE IF EXISTS `sa_type`;
CREATE TABLE `sa_type` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `typeid` int(64) NOT NULL,
  `pid` int(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_type
-- ----------------------------
INSERT INTO `sa_type` VALUES ('1', '类型', '1', '0');
INSERT INTO `sa_type` VALUES ('2', '目的', '1', '0');
INSERT INTO `sa_type` VALUES ('3', '客户种类', '1', '0');
INSERT INTO `sa_type` VALUES ('4', '陌拜', '2', '1');
INSERT INTO `sa_type` VALUES ('5', '日常跟进', '2', '1');
INSERT INTO `sa_type` VALUES ('6', '客户资源', '2', '1');
INSERT INTO `sa_type` VALUES ('7', '电话上门', '2', '1');
INSERT INTO `sa_type` VALUES ('8', '首次', '2', '2');
INSERT INTO `sa_type` VALUES ('9', '报价', '2', '2');
INSERT INTO `sa_type` VALUES ('10', '客诉', '2', '2');
INSERT INTO `sa_type` VALUES ('11', '收款', '2', '2');
INSERT INTO `sa_type` VALUES ('12', '追款', '2', '2');
INSERT INTO `sa_type` VALUES ('13', '签单', '2', '2');
INSERT INTO `sa_type` VALUES ('14', '续约', '2', '2');
INSERT INTO `sa_type` VALUES ('15', '回访', '2', '2');
INSERT INTO `sa_type` VALUES ('16', '其他', '2', '2');
INSERT INTO `sa_type` VALUES ('17', '更改项目', '2', '2');
INSERT INTO `sa_type` VALUES ('18', '粤菜', '2', '3');
INSERT INTO `sa_type` VALUES ('19', '烧烤', '2', '3');
INSERT INTO `sa_type` VALUES ('20', '西餐', '2', '3');
INSERT INTO `sa_type` VALUES ('21', '火锅', '2', '3');
INSERT INTO `sa_type` VALUES ('22', '网吧', '2', '3');
INSERT INTO `sa_type` VALUES ('23', '影院', '2', '3');
INSERT INTO `sa_type` VALUES ('24', '酒吧', '2', '3');
INSERT INTO `sa_type` VALUES ('25', '其他', '2', '3');
INSERT INTO `sa_type` VALUES ('26', 'KTV', '2', '3');
INSERT INTO `sa_type` VALUES ('27', '茶餐厅', '2', '3');
INSERT INTO `sa_type` VALUES ('28', '江浙菜', '2', '3');
INSERT INTO `sa_type` VALUES ('29', '美容院', '2', '3');
INSERT INTO `sa_type` VALUES ('30', '饮品店', '2', '3');
INSERT INTO `sa_type` VALUES ('31', '咖啡厅', '2', '3');
INSERT INTO `sa_type` VALUES ('32', '清真菜', '2', '3');
INSERT INTO `sa_type` VALUES ('33', '俱乐部', '2', '3');
INSERT INTO `sa_type` VALUES ('34', '快/简餐', '2', '3');
INSERT INTO `sa_type` VALUES ('35', '川/辣菜', '2', '3');
INSERT INTO `sa_type` VALUES ('36', '日本料理', '2', '3');
INSERT INTO `sa_type` VALUES ('37', '水疗会所', '2', '3');
INSERT INTO `sa_type` VALUES ('38', '韩国料理', '2', '3');
INSERT INTO `sa_type` VALUES ('39', '面包甜点', '2', '3');
INSERT INTO `sa_type` VALUES ('40', '星马越泰菜', '2', '3');
INSERT INTO `sa_type` VALUES ('41', '东/西北菜', '2', '3');

-- ----------------------------
-- Table structure for sa_visit
-- ----------------------------
DROP TABLE IF EXISTS `sa_visit`;
CREATE TABLE `sa_visit` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `uname` char(64) DEFAULT NULL COMMENT '销售员名字',
  `type` char(64) DEFAULT NULL COMMENT '类型:0=陌拜,1=日常更进，2=客户资源,3=电话上门',
  `aim` char(64) DEFAULT NULL COMMENT '目的:0=首次,1=报价，2=客诉，3=收款，4=追款，5=签单，6=续约，7=回访，8=其他，9=更改项目.',
  `datatime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '日期',
  `area` char(64) DEFAULT NULL COMMENT '区域',
  `road` char(64) DEFAULT NULL COMMENT '街道',
  `crtype` char(64) DEFAULT NULL COMMENT '客户类型:0=粤菜,1=烧烤,2=西餐,3=火锅,4=网吧，5=影院，6=酒吧，7=其他，8=KTV，9=茶餐厅，10=江浙菜，11=美容院，12=饮品店，13=咖啡厅，14=清真菜，15=俱乐部，16=快/简餐,17=川 /辣菜,18=日本料理,19=水疗会所,20=韩国料理 ，21=面包甜点,22=星马月泰菜，23=东/西北菜',
  `crname` char(64) DEFAULT NULL COMMENT '客户名字',
  `sonname` char(64) DEFAULT NULL COMMENT '分店名',
  `charge` char(64) DEFAULT NULL COMMENT '负责人',
  `phone` int(16) DEFAULT NULL COMMENT '电话',
  `remarks` char(255) DEFAULT NULL COMMENT '备注',
  `city` char(5) DEFAULT NULL COMMENT '地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_visit
-- ----------------------------
INSERT INTO `sa_visit` VALUES ('7', 'admin', '日常跟进', '收款', '2017-12-28 16:22:55', '青羊区', '地税局', '西餐', '娅米西餐厅', '无', '李四', '2147483647', '无', 'HK');
INSERT INTO `sa_visit` VALUES ('8', 'admin', '电话上门', '首次', '2017-12-29 09:46:13', '成华区', '府青路25号', '清真菜', '湖北清真菜馆', '无', '王五', '2147483647', '<script>\r\n	alert(\"安全测试\");\r\n</script>', 'HK');

-- ----------------------------
-- Table structure for sa_visit_offer
-- ----------------------------
DROP TABLE IF EXISTS `sa_visit_offer`;
CREATE TABLE `sa_visit_offer` (
  `id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `visitid` int(64) NOT NULL COMMENT '拜访记录的ID',
  `name` varchar(64) NOT NULL COMMENT '报价使用的物品名字',
  `number` int(11) NOT NULL COMMENT '数量',
  `money` int(64) NOT NULL COMMENT '年金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sa_visit_offer
-- ----------------------------
