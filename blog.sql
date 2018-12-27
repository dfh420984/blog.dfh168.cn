/*
Navicat MySQL Data Transfer

Source Server         : docker_mysql
Source Server Version : 50642
Source Host           : 127.0.0.1:3309
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50642
File Encoding         : 65001

Date: 2018-12-27 17:29:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '后台管理员表主键',
  `email` varchar(35) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `mobile` char(13) NOT NULL DEFAULT '' COMMENT '管理员手机号',
  `head_image` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `ip` int(10) NOT NULL DEFAULT '0' COMMENT '管理员登录ip',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态,0：禁用 ,1.启用，2.删除',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '管理员登录时间',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '管理员添加时间',
  `time_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '管理员更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_email` (`email`),
  UNIQUE KEY `ix_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', '352928736@qq.com', '13331139424', '', '2130706433', '1', '2018-12-26 03:24:14', '2018-12-26 03:24:14', '2018-12-26 03:24:14');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类主键',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类上级id,category.id',
  `slug` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `content` varchar(25) NOT NULL DEFAULT '' COMMENT '分类内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态,0:禁用,1.启用,2.删除',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `time_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '0', '', 'php', '1', '2018-12-26 03:21:04', '2018-12-26 03:21:04');
INSERT INTO `category` VALUES ('2', '0', '', 'java', '1', '2018-12-26 03:21:04', '2018-12-26 03:21:04');
INSERT INTO `category` VALUES ('3', '0', '', 'python', '1', '2018-12-26 03:21:04', '2018-12-26 03:21:04');
INSERT INTO `category` VALUES ('4', '0', '', 'go', '1', '2018-12-26 03:21:04', '2018-12-26 03:21:04');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论主键',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论用户id,关联user.id',
  `posts_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '帖子id,关联posts.id',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论上级id,comments.id',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评论内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态,0:待审核,1.上线,2.删除',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `time_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `posts_id` (`posts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='帖子评论表';

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', '1', '1', '0', '顶一个', '1', '2018-12-26 03:14:22', '2018-12-26 03:14:22');
INSERT INTO `comments` VALUES ('2', '2', '1', '1', '顶楼上', '1', '2018-12-26 03:14:22', '2018-12-26 03:14:22');
INSERT INTO `comments` VALUES ('3', '3', '1', '0', '非常好', '0', '2018-12-26 03:14:22', '2018-12-26 03:14:22');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '帖子主键',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发帖用户id,关联user.id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '帖子分类id,关联category.id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '帖子标题',
  `slug` varchar(255) NOT NULL DEFAULT '' COMMENT '别名',
  `content` text NOT NULL COMMENT '帖子内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,0:待审核,1.上线,2.删除',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `time_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='帖子表';

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('1', '1', '1', 'easyswoole强大', '', 'easyswoole太强大了，非常好用', '1', '2018-12-26 03:11:56', '2018-12-26 03:11:56');
INSERT INTO `posts` VALUES ('2', '1', '1', 'swoole太牛逼了', '', 'swoole太牛逼了，杠杆滴', '1', '2018-12-26 03:11:56', '2018-12-26 03:11:56');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '前台用户主键',
  `email` varchar(35) NOT NULL DEFAULT '' COMMENT '前台用户邮箱',
  `mobile` char(13) NOT NULL DEFAULT '' COMMENT '前台用户手机号',
  `nickname` varchar(25) NOT NULL DEFAULT '' COMMENT '昵称',
  `slug` varchar(255) NOT NULL DEFAULT '' COMMENT 'slug别名',
  `head_image` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `ip` int(10) NOT NULL DEFAULT '0' COMMENT '前台用户登录ip',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态,0：禁用 ,1.启用，2.删除',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '前台用户登录时间',
  `time_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '管理员添加时间',
  `time_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '管理员更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ix_email` (`email`),
  UNIQUE KEY `ix_mobile` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='前台用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '352928736@qq.com', '13331139424', '', '', '', '2130706433', '1', '2018-12-26 03:19:03', '2018-12-26 03:19:03', '2018-12-26 03:19:03');
INSERT INTO `user` VALUES ('2', 'duanfuhao@smzdm.com', '15172471345', '', '', '', '2130706433', '1', '2018-12-26 03:19:03', '2018-12-26 03:19:03', '2018-12-26 03:19:03');
INSERT INTO `user` VALUES ('3', 'duanfuhao@163.com', '13693240212', '', '', '', '2130706433', '1', '2018-12-26 03:19:03', '2018-12-26 03:19:03', '2018-12-26 03:19:03');
