DROP TABLE IF EXISTS sal_fivestep;
CREATE TABLE sal_fivestep (
  id int unsigned NOT NULL auto_increment primary key,
  username varchar(30) NOT NULL,
  step varchar(10) NOT NULL,
  filename varchar(255) NOT NULL,
  status char(1) NOT NULL DEFAULT 'P',
  city char(5) NOT NULL,
  lcu varchar(30),
  luu varchar(30),
  lcd timestamp default CURRENT_TIMESTAMP,
  lud timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS sal_fivestep_info;
CREATE TABLE sal_fivestep_info (
  five_id int unsigned NOT NULL,
  field_id varchar(30) not null,
  field_value varchar(2000),
  lcu varchar(30),
  luu varchar(30),
  lcd timestamp default CURRENT_TIMESTAMP,
  lud timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  UNIQUE KEY trans (five_id, field_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_info
-- ----------------------------
INSERT INTO `customer_info` VALUES ('214', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '2018-02-14 00:00:00', '1', '9', '11', 'HK');
INSERT INTO `customer_info` VALUES ('215', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '2018-02-14 00:00:00', '1', '4', '4', 'HK');
INSERT INTO `customer_info` VALUES ('216', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '客户名称', '2018-01-30 00:00:00', '1', '6', '5', 'HK');
INSERT INTO `customer_info` VALUES ('217', '总备注', '总备注', '总备注', '总备注', '总备注', '总备注总备注', '总备注', '总备注', '2018-02-13 00:00:00', '1', '4', '3', 'HK');

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
-- Table structure for `new_service_info`
-- ----------------------------
DROP TABLE IF EXISTS `new_service_info`;
CREATE TABLE `new_service_info` (
  `new_service_info_id` int(200) NOT NULL AUTO_INCREMENT COMMENT '服务主键',
  `new_visit_info_pid` int(100) DEFAULT NULL COMMENT '拜访外键',
  `new_service_money` varchar(50) DEFAULT NULL COMMENT '服务总金额',
  `new_services_kinds` varchar(200) DEFAULT NULL COMMENT '服务存入数量与类别',
  `new_services_kind` varchar(20) DEFAULT NULL COMMENT '类别',
  PRIMARY KEY (`new_service_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of new_service_info
-- ----------------------------
INSERT INTO `new_service_info` VALUES ('173', '265', '2500', 'fengshanji*18-', '1');
INSERT INTO `new_service_info` VALUES ('174', '265', '35200', 'fengshanji*35200-', '1');
INSERT INTO `new_service_info` VALUES ('175', '266', '2500', 'laoshu*22-zhanglang*33-', '2');
INSERT INTO `new_service_info` VALUES ('176', '266', '3300', 'matong*15-', '0');
INSERT INTO `new_service_info` VALUES ('177', '267', '2500', 'laoshu*22-zhanglang*33-', '2');
INSERT INTO `new_service_info` VALUES ('178', '267', '3300', 'matong*15-', '0');
INSERT INTO `new_service_info` VALUES ('179', '268', '2500', 'laoshu*22-zhanglang*33-', '2');
INSERT INTO `new_service_info` VALUES ('180', '268', '3300', 'matong*15-', '0');
INSERT INTO `new_service_info` VALUES ('181', '269', '1500', 'fengshanji*48-', '1');
INSERT INTO `new_service_info` VALUES ('182', '269', '3900', 'minixiaoji*36-', '3');
INSERT INTO `new_service_info` VALUES ('183', '270', '44964', 'fengshanji*565-', '1');
INSERT INTO `new_service_info` VALUES ('184', '270', '74984', 'chujiaquan*8789-', '4');
INSERT INTO `new_service_info` VALUES ('187', '272', '897484', 'fengshanji*745-', '1');
INSERT INTO `new_service_info` VALUES ('188', '272', '48489', 'laoshu*84-zhanglang*-laoshuguoying*48-', '2');
INSERT INTO `new_service_info` VALUES ('189', '273', '123123', 'minixiaoji*21312-xiaoji*213-', '3');
INSERT INTO `new_service_info` VALUES ('190', '273', '1231231', 'laoshu*123-laoshuguoying*123-zhanglangguoying*12312-', '2');
INSERT INTO `new_service_info` VALUES ('191', '274', '12312', 'laoshu*12312-zhanglang*1231-', '2');
INSERT INTO `new_service_info` VALUES ('192', '274', '76875857', 'laoshu*123-zhanglang*-guoying*123-laoshuzhanglangjiazudeng*123123-', '2');
INSERT INTO `new_service_info` VALUES ('193', '275', '215000', 'matong*851-niaodou*362-', '0');
INSERT INTO `new_service_info` VALUES ('194', '275', '6566416514', 'laoshu*956-zhanglang*-', '2');
INSERT INTO `new_service_info` VALUES ('195', '276', '542345', 'fengshanji*465-', '1');
INSERT INTO `new_service_info` VALUES ('196', '276', '546546', '', '0');
INSERT INTO `new_service_info` VALUES ('197', '276', '456456', '', '2');
INSERT INTO `new_service_info` VALUES ('198', '276', '456456', 'minixiaoji*85-', '3');
INSERT INTO `new_service_info` VALUES ('199', '277', '1200', 'fengshanji*14-', '1');
INSERT INTO `new_service_info` VALUES ('200', '277', '1200', 'laoshu*13-', '2');
INSERT INTO `new_service_info` VALUES ('201', '278', '15014', 'fengshanji*135-', '1');
INSERT INTO `new_service_info` VALUES ('202', '278', '15800', 'matong*185-niaodou*151-', '0');
INSERT INTO `new_service_info` VALUES ('203', '279', '13200', 'fengshanji*135-', '1');
INSERT INTO `new_service_info` VALUES ('204', '279', '15800', 'matong*185-niaodou*151-', '0');
INSERT INTO `new_service_info` VALUES ('205', '280', '1500', 'fengshanji*159-', '1');
INSERT INTO `new_service_info` VALUES ('206', '280', '3200', 'laoshu*220-laoshuguoying*226-', '2');
INSERT INTO `new_service_info` VALUES ('207', '281', '15000', 'matong*147-', '0');
INSERT INTO `new_service_info` VALUES ('208', '281', '16465', '', '1');
INSERT INTO `new_service_info` VALUES ('209', '281', '32620', '', '2');
INSERT INTO `new_service_info` VALUES ('210', '281', '1265561', 'minixiaoji*1561-', '3');
INSERT INTO `new_service_info` VALUES ('211', '282', '119', 'matong*15-', '0');
INSERT INTO `new_service_info` VALUES ('212', '282', '120', 'fengshanji*132-', '1');
INSERT INTO `new_service_info` VALUES ('213', '282', '10', 'laoshu*147-', '2');
INSERT INTO `new_service_info` VALUES ('214', '283', '2500', 'matong*1856-', '0');
INSERT INTO `new_service_info` VALUES ('215', '283', '3900', 'fengshanji*485-', '1');
INSERT INTO `new_service_info` VALUES ('216', '284', '5200', 'fengshanji*86-', '1');
INSERT INTO `new_service_info` VALUES ('217', '284', '4200', 'matong*47-', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_customer_info
-- ----------------------------
INSERT INTO `order_customer_info` VALUES ('1', '海底捞', '138856589568', '青羊区', '北大街', '1', '1200');

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
  `order_goods_code_number` varchar(50) DEFAULT NULL COMMENT '订货编号',
  `order_per_price` varchar(20) DEFAULT NULL,
  `order_free` varchar(20) DEFAULT NULL,
  `order_count` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`order_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_info
-- ----------------------------
INSERT INTO `order_info` VALUES ('1', '156', '销售员No.1', '12', '海底捞', '青羊区', '地区位置', '订单编码', '1200', '2017/12/8', '货物编码', null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

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
INSERT INTO `service_history` VALUES ('136', '灭虫(蟑螂)', '修改测试adasd', '啊实打实大', '90');
INSERT INTO `service_history` VALUES ('137', '灭虫(老鼠蟑螂果蝇)', '修改测试', '修改数据测试', '90');
INSERT INTO `service_history` VALUES ('138', '飘盈香(迷你机)', '撒大受打击爱哦集合', '啊实打实大', '90');
INSERT INTO `service_history` VALUES ('139', '清洁(水盆)', '232323', '撒打算大', '92');
INSERT INTO `service_history` VALUES ('140', '清洁(皂液机)', '232323', '0333333333', '93');
INSERT INTO `service_history` VALUES ('141', '灭虫(老鼠)', '跟进三服务22', '第一次跟进的第二次服务价格', '93');

-- ----------------------------
-- Table structure for `video_info`
-- ----------------------------
DROP TABLE IF EXISTS `video_info`;
CREATE TABLE `video_info` (
  `video_info_id` int(150) NOT NULL AUTO_INCREMENT COMMENT '文件主键',
  `video_info_url` varchar(280) DEFAULT NULL COMMENT '文件路径',
  `seller_pid` int(100) DEFAULT NULL COMMENT '销售员外键',
  `seller_notes` varchar(100) DEFAULT NULL COMMENT '备注信息',
  `city_privileges` char(5) DEFAULT NULL COMMENT '城市外键',
  `video_info_date` varchar(50) DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`video_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of video_info
-- ----------------------------
INSERT INTO `video_info` VALUES ('6', 'D:phpstudyPHPTutorialWWWSalesSalessalesprotected/upload/admin/151859799647680.mov', '1', '备注信息', 'HK', '2018-02-14 16:46:35');
INSERT INTO `video_info` VALUES ('7', 'D:phpstudyPHPTutorialWWWSalesSalessalesprotected/upload/admin/151859834262772.mov', '1', '备注信息', 'HK', '2018-02-14 16:52:21');
INSERT INTO `video_info` VALUES ('8', '/Sales/Sales/sales/upload/admin/151859912992034.mov', '1', '备注信息', 'HK', '2018-02-14 17:05:28');
INSERT INTO `video_info` VALUES ('9', '/Sales/Sales/sales/upload/admin/151900509748899.mov', '1', '备注信息', 'HK', '2018-02-19 09:51:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visit_info
-- ----------------------------
INSERT INTO `visit_info` VALUES ('278', '214', '1', '客户名称', '30814', '2018/02/14', '签单');
INSERT INTO `visit_info` VALUES ('279', '215', '1', '客户名称', '29000', '2018/02/14', '签单');
INSERT INTO `visit_info` VALUES ('280', '215', '1', '第一次跟进备注', '4700', '2018/02/15', '追款');
INSERT INTO `visit_info` VALUES ('281', '215', '1', '第一次跟进备注', '1329646', '2018/02/22', '追款');
INSERT INTO `visit_info` VALUES ('282', '215', '1', '第一次跟进备注', '349', '2018/02/21', '收款');
INSERT INTO `visit_info` VALUES ('283', '216', '1', '客户名称', '6400', '2018/02/14', '签单');
INSERT INTO `visit_info` VALUES ('284', '217', '1', '总备注', '9400', '2018/02/14', '回访');
