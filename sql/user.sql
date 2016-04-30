-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- 主机: w.rdc.sae.sina.com.cn:3307
-- 生成日期: 2015 年 12 月 20 日 12:08
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `app_thinkfortest`
--

-- --------------------------------------------------------

--
-- 表的结构 `app_user`
--

CREATE TABLE IF NOT EXISTS `app_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0保密 1男 2女',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '个人网站',
  `birthday` date DEFAULT NULL COMMENT '生日',
  -- `birth_year` smallint(4) NOT NULL DEFAULT 0 COMMENT '出生年',
  -- `birth_mouth` tinyint(2) NOT NULL 
  `about` varchar(500) DEFAULT NULL COMMENT '个人简介',
  `regtm` int(11) NOT NULL COMMENT '注册时间',
  `lastlgtm` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `lastrettm` int(11) DEFAULT NULL COMMENT '最后获取重置密码token时间',
  `chg_pwd_tm` int(11) NOT NULL,
  `isdisabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为不禁用，1为禁用',
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(100) null,
  `platform` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1手动注册，2qq，3微博，4微信，5其他',
  `token` varchar(50) DEFAULT NULL COMMENT '激活码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否激活,验证邮箱激活',
  `regip` varchar(15) NOT NULL COMMENT '注册ip',
  `lastip` varchar(15) NOT NULL COMMENT '最后登录ip',
  `login_times` int unsigned NOT null DEFAULT 0 COMMENT '登陆次数',
  `credit` int NOT NULL DEFAULT 0 COMMENT '用户总积分',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `lastlgtm` (`lastlgtm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --添加普通索引
-- ALTER TABLE  `app_user` ADD INDEX (  `lastlgtm` );
-- ALTER TABLE  `app_user` ADD `credit` int NOT NULL DEFAULT 0 COMMENT '用户总积分';
-- ALTER TABLE `app_user` ENGINE=InnoDB;
-- alter table app_user modify column `phone` varchar(20) DEFAULT NULL;
-- --查找某字段在某张表中--
-- select * from INFORMATION_SCHEMA.columns where COLUMN_NAME Like '%placement%'; 