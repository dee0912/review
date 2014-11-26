/*
Navicat MySQL Data Transfer

Source Server         : 172.16.10.237
Source Server Version : 50173
Source Host           : 172.16.10.237:3306
Source Database       : ReviewDB

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2014-11-26 10:07:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_time` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=200100101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('200100100', '2014-11-25 11:58:39');

-- ----------------------------
-- Table structure for order_show
-- ----------------------------
DROP TABLE IF EXISTS `order_show`;
CREATE TABLE `order_show` (
  `show_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '晒单id',
  `order_id` bigint(20) NOT NULL COMMENT '订单id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id',
  `product_id` bigint(11) NOT NULL COMMENT '晒单的商品id',
  `sale_prop` varchar(512) DEFAULT '' COMMENT '晒单的商品',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 0-禁用 1-启用',
  `creation_time` datetime NOT NULL COMMENT '晒单时间',
  `modification_time` datetime NOT NULL COMMENT '晒单修改时间',
  PRIMARY KEY (`show_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_show
-- ----------------------------
INSERT INTO `order_show` VALUES ('1', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:06:01', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('2', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:06:22', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('3', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:08:44', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('4', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:17:03', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('5', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:17:15', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('6', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:18:49', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('7', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:21:58', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('8', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:23:06', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('9', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:23:22', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('10', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:24:46', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('11', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:26:47', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('12', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:27:09', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('13', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:28:03', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('14', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:28:35', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('15', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:29:35', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('16', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:30:31', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('17', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:30:48', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('18', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:46:50', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('19', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:47:29', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('20', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:48:32', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('21', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:49:32', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('22', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:49:56', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('23', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:50:49', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('24', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:51:15', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('25', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:52:32', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('26', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:53:09', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('27', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:53:24', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('28', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:53:48', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('29', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:55:25', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('30', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:55:42', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('31', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:55:58', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('32', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:56:14', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('33', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:58:21', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('34', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 15:58:59', '0000-00-00 00:00:00');
INSERT INTO `order_show` VALUES ('35', '200100100', '100100', '3001001001', 'testtttt', '1', '2014-11-25 16:00:20', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for order_show_pic
-- ----------------------------
DROP TABLE IF EXISTS `order_show_pic`;
CREATE TABLE `order_show_pic` (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '晒单单张图片id',
  `show_id` int(11) NOT NULL COMMENT '晒单id',
  `url` varchar(256) NOT NULL COMMENT '晒单单张图片url',
  `priority` int(11) NOT NULL DEFAULT '1' COMMENT '晒单单张图片顺序',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '单张图片是否显示 0-不显示 1-显示',
  `creation_time` datetime NOT NULL COMMENT '单张图片添加时间',
  `modification_time` datetime NOT NULL COMMENT '单张图片修改时间',
  PRIMARY KEY (`pic_id`),
  KEY `show_id` (`show_id`) USING BTREE,
  CONSTRAINT `order_show_pic_ibfk_1` FOREIGN KEY (`show_id`) REFERENCES `order_show` (`show_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_show_pic
-- ----------------------------
INSERT INTO `order_show_pic` VALUES ('1', '15', './Uploads/2014-11-25/54742fdfd10d5.jpg', '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('2', '17', './Uploads/2014-11-25/54743028844f4.jpg', '1', '1', '2014-11-25 15:30:48', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('3', '17', './Uploads/2014-11-25/5474302885db0.jpg', '1', '1', '2014-11-25 15:30:48', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('4', '17', './Uploads/2014-11-25/5474302887109.jpg', '1', '1', '2014-11-25 15:30:48', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('5', '18', './Uploads/2014-11-25/547433ea29a38.jpg', '1', '1', '2014-11-25 15:46:50', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('6', '18', './Uploads/2014-11-25/547433ea2b4e4.jpg', '1', '1', '2014-11-25 15:46:50', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('7', '18', './Uploads/2014-11-25/547433ea2c61b.jpg', '1', '1', '2014-11-25 15:46:50', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('8', '20', './Uploads/2014-11-25/54743450c089e.jpg', '0', '1', '2014-11-25 15:48:32', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('32', '29', './Uploads/2014-11-25/547435ed495ac.jpg', '1', '1', '2014-11-25 15:55:25', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('33', '29', './Uploads/2014-11-25/547435ed4aad5.jpg', '1', '1', '2014-11-25 15:55:25', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('34', '29', './Uploads/2014-11-25/547435ed4c253.jpg', '1', '1', '2014-11-25 15:55:25', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('35', '30', './Uploads/2014-11-25/547435fe2c312.jpg', '1', '1', '2014-11-25 15:55:42', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('36', '30', './Uploads/2014-11-25/547435fe2d5d5.jpg', '1', '1', '2014-11-25 15:55:42', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('37', '30', './Uploads/2014-11-25/547435fe2edde.jpg', '1', '1', '2014-11-25 15:55:42', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('38', '31', './Uploads/2014-11-25/5474360e57aea.jpg', '1', '1', '2014-11-25 15:55:58', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('39', '31', './Uploads/2014-11-25/5474360e5a1c6.jpg', '68', '1', '2014-11-25 15:55:58', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('40', '31', './Uploads/2014-11-25/5474360e5c7a9.jpg', '44', '1', '2014-11-25 15:55:58', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('41', '32', './Uploads/2014-11-25/5474361ea8b80.jpg', '0', '1', '2014-11-25 15:56:14', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('42', '32', './Uploads/2014-11-25/5474361eaa864.jpg', '0', '1', '2014-11-25 15:56:14', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('43', '32', './Uploads/2014-11-25/5474361eabe30.jpg', '0', '1', '2014-11-25 15:56:14', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('44', '34', './Uploads/2014-11-25/547436c3511c1.jpg', '0', '1', '2014-11-25 15:58:59', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('45', '34', './Uploads/2014-11-25/547436c35289a.jpg', '0', '1', '2014-11-25 15:58:59', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('46', '34', './Uploads/2014-11-25/547436c353da9.jpg', '0', '1', '2014-11-25 15:58:59', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('47', '35', './Uploads/2014-11-25/54743714c1b0b.jpg', '1', '1', '2014-11-25 16:00:20', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('48', '35', './Uploads/2014-11-25/54743714c33db.jpg', '1', '1', '2014-11-25 16:00:20', '0000-00-00 00:00:00');
INSERT INTO `order_show_pic` VALUES ('49', '35', './Uploads/2014-11-25/54743714c4bb2.jpg', '1', '1', '2014-11-25 16:00:20', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_name_sub` varchar(255) DEFAULT NULL,
  `product_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `standard_price` decimal(10,2) NOT NULL,
  `chunbo_price` decimal(10,0) DEFAULT NULL,
  `product_area` varchar(100) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `create_by` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `update_by` int(11) NOT NULL,
  `up_down_time` datetime DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `sku_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', '四川徐香猕猴桃(中果)27粒/3kg', '口感超甜，香气独特，像是融合了甜瓜、草莓等混合风味 ', '0', '1', '50.00', '50', null, '2014-11-04 20:17:34', '0', '2014-11-04 20:18:00', '0', '2014-11-04 20:18:18', '1', '0102022400C ');
INSERT INTO `product` VALUES ('2', '商品2', '商品2描述', '0', '1', '100.00', '100', null, '2014-11-05 17:57:33', '0', '2014-11-05 17:57:39', '0', '2014-11-05 17:57:45', '1', '0102022400V');

-- ----------------------------
-- Table structure for review
-- ----------------------------
DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id',
  `comment` varchar(1024) NOT NULL DEFAULT '' COMMENT '评论内容',
  `reply` varchar(1024) NOT NULL DEFAULT '' COMMENT '管理员回复内容',
  `score` int(11) NOT NULL DEFAULT '5' COMMENT '用户评分',
  `order_id` bigint(20) NOT NULL COMMENT '订单编号',
  `order_time` datetime NOT NULL COMMENT '订单下单时间',
  `product_id` bigint(11) NOT NULL COMMENT '评价的商品id',
  `sale_prop` varchar(512) NOT NULL DEFAULT '' COMMENT '评价的商品',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 0-禁用 1-启用',
  `creation_time` datetime NOT NULL COMMENT '评论时间',
  `modification_time` datetime NOT NULL COMMENT '管理员回复时间',
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of review
-- ----------------------------
INSERT INTO `review` VALUES ('1', '100100', '', '', '1', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 10:46:15', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('2', '100100', '222', '', '1', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 10:53:01', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('3', '100100', '11', '', '5', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 10:53:19', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('4', '100100', '111', '', '1', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:26:53', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('5', '100100', '11', '', '1', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:35:55', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('6', '100100', '11', '', '1', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:36:49', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('7', '100100', '11111', '', '1', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:44:23', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('8', '100100', 'hahaha', '', '2', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:45:55', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('9', '100100', '1111', '', '2', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:46:32', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('10', '100100', 'gggggg', '', '3', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:47:04', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('11', '100100', '呜呜呜呜', '', '3', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 11:59:41', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('12', '100100', '嘎嘎嘎嘎嘎嘎嘎', '', '2', '200100100', '0000-00-00 00:00:00', '3001001001', 'testtttt', '1', '2014-11-25 12:00:55', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('13', '100100', '分', '', '2', '200100100', '2014-11-25 11:58:39', '3001001001', 'testtttt', '1', '2014-11-25 12:02:36', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('14', '100100', 'QQ群', '', '2', '200100100', '2014-11-25 11:58:39', '3001001001', 'testtttt', '1', '2014-11-25 12:02:56', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('15', '100100', 'lskk\"\";asda\\\\\';l\'a;s', '', '5', '200100100', '2014-11-25 11:58:39', '3001001001', 'testtttt', '1', '2014-11-25 13:43:54', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('16', '100100', '1111', '', '3', '200100100', '2014-11-25 11:58:39', '3001001001', 'testtttt', '1', '2014-11-25 13:50:42', '0000-00-00 00:00:00');
INSERT INTO `review` VALUES ('17', '100100', 'asd\\sad\'ddsdf', '的顶顶顶顶顶', '4', '200100100', '2014-11-25 11:58:39', '3001001001', 'testtttt', '0', '2014-11-25 13:51:06', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for tag
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标签id',
  `review_id` int(11) NOT NULL COMMENT '评论id',
  `tag_name` varchar(32) NOT NULL DEFAULT '' COMMENT '标签名称',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 0-禁用 1-启用',
  `creation_time` datetime NOT NULL COMMENT '标签创建时间',
  `modification_time` datetime NOT NULL COMMENT '标签修改时间',
  PRIMARY KEY (`tag_id`),
  KEY `review_id` (`review_id`) USING BTREE,
  CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag
-- ----------------------------
INSERT INTO `tag` VALUES ('1', '7', 'null', '1', '2014-11-25 11:44:23', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('2', '10', '[\"\\u9001\\u8d27\\u5feb\",\"\\u65b0\\u9', '1', '2014-11-25 11:47:04', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('3', '11', '[\"\\u65b0\\u9c9c\",\"\\u53e3\\u611f\\u5', '1', '2014-11-25 11:59:41', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('4', '12', '[\"\\u9001\\u8d27\\u5feb\",\"\\u65b0\\u9', '1', '2014-11-25 12:00:55', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('5', '13', '[\"\\u9001\\u8d27\\u5feb\"]', '1', '2014-11-25 12:02:36', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('6', '14', '[\"\\u9001\\u8d27\\u5feb\",\"\\u65b0\\u9', '1', '2014-11-25 12:02:56', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('7', '15', '[\"\\u9001\\u8d27\\u5feb\",\"\\u65b0\\u9', '1', '2014-11-25 13:43:54', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('8', '16', '[\"\\u9001\\u8d27\\u5feb\"]', '1', '2014-11-25 13:50:42', '0000-00-00 00:00:00');
INSERT INTO `tag` VALUES ('9', '17', '[\"\\u65b0\\u9c9c\"]', '1', '2014-11-25 13:51:06', '0000-00-00 00:00:00');
