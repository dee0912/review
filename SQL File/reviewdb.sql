/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : reviewdb

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2014-11-24 20:09:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for order_show
-- ----------------------------
DROP TABLE IF EXISTS `order_show`;
CREATE TABLE `order_show` (
  `show_id` int(11) NOT NULL COMMENT '晒单id',
  `order_id` bigint(20) NOT NULL COMMENT '订单id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id',
  `product_id` int(11) NOT NULL COMMENT '晒单的商品id',
  `sale_prop` varchar(512) DEFAULT '' COMMENT '晒单的商品',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 0-禁用 1-启用',
  `creation_time` datetime NOT NULL COMMENT '晒单时间',
  `modification_time` datetime NOT NULL COMMENT '晒单修改时间',
  PRIMARY KEY (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_show
-- ----------------------------

-- ----------------------------
-- Table structure for order_show_pic
-- ----------------------------
DROP TABLE IF EXISTS `order_show_pic`;
CREATE TABLE `order_show_pic` (
  `pic_id` int(11) NOT NULL COMMENT '晒单单张图片id',
  `show_id` int(11) NOT NULL COMMENT '晒单id',
  `url` varchar(256) NOT NULL COMMENT '晒单单张图片url',
  `priority` int(11) NOT NULL COMMENT '晒单单张图片顺序',
  `is_enabled` int(11) NOT NULL COMMENT '单张图片是否显示 0-不显示 1-显示',
  `creation_time` datetime NOT NULL COMMENT '单张图片添加时间',
  `modification_time` datetime NOT NULL COMMENT '单张图片修改时间',
  PRIMARY KEY (`pic_id`),
  KEY `show_id` (`show_id`) USING BTREE,
  CONSTRAINT `show_id` FOREIGN KEY (`show_id`) REFERENCES `order_show` (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_show_pic
-- ----------------------------

-- ----------------------------
-- Table structure for review
-- ----------------------------
DROP TABLE IF EXISTS `review`;
CREATE TABLE `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `member_id` bigint(20) NOT NULL COMMENT '用户id',
  `comment` varchar(1024) NOT NULL DEFAULT '' COMMENT '评论内容',
  `reply` varchar(1024) NOT NULL DEFAULT '' COMMENT '管理员回复内容',
  `score` int(11) NOT NULL COMMENT '用户评分',
  `order_id` bigint(20) NOT NULL COMMENT '订单编号',
  `order_time` datetime NOT NULL COMMENT '订单下单时间',
  `product_id` int(11) NOT NULL COMMENT '评价的商品id',
  `sale_prop` varchar(512) NOT NULL DEFAULT '' COMMENT '评价的商品',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 0-禁用 1-启用',
  `creation_time` datetime NOT NULL COMMENT '评论时间',
  `modification_time` datetime NOT NULL COMMENT '管理员回复时间',
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of review
-- ----------------------------

-- ----------------------------
-- Table structure for tag
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  `review_id` int(11) NOT NULL COMMENT '评论id',
  `tag_name` varchar(32) NOT NULL DEFAULT '' COMMENT '标签名称',
  `is_enabled` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用 0-禁用 1-启用',
  `creation_time` datetime NOT NULL COMMENT '标签创建时间',
  `modification_time` datetime NOT NULL COMMENT '标签修改时间',
  PRIMARY KEY (`tag_id`),
  KEY `review_id` (`review_id`),
  CONSTRAINT `review_id` FOREIGN KEY (`review_id`) REFERENCES `review` (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tag
-- ----------------------------
