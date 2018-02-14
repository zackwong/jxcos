/*
Navicat MySQL Data Transfer

Source Server         : 本地mysql
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : 8wine

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2015-07-09 14:59:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(32) NOT NULL COMMENT '流水单号',
  `type` tinyint(4) DEFAULT NULL COMMENT '单据类型',
  `total_price` decimal(10,2) NOT NULL COMMENT '订单总价',
  `biller` int(11) NOT NULL COMMENT '开单人',
  `datetime` datetime NOT NULL COMMENT '开单日期',
  `remarks` text,
  `is_paid` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) unsigned NOT NULL COMMENT '订单id',
  `pid` int(11) NOT NULL COMMENT '产品id',
  `pname` varchar(64) NOT NULL COMMENT '产品名称',
  `price` decimal(10,2) NOT NULL COMMENT '开单时价格',
  `qty` int(11) NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`),
  KEY `order_items_ibfk_1` (`oid`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`oid`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for stock_log
-- ----------------------------
DROP TABLE IF EXISTS `stock_log`;
CREATE TABLE `stock_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '产品id',
  `operator` int(11) NOT NULL COMMENT '操作员序号',
  `datetime` datetime NOT NULL COMMENT '操作时间',
  `remarks` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
