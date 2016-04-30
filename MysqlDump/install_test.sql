-- MySQL dump 10.13  Distrib 5.5.40, for Win32 (x86)
--
-- Host: localhost    Database: app_thinkfortest
-- ------------------------------------------------------
-- Server version	5.5.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_admin_belong_group`
--

DROP TABLE IF EXISTS `app_admin_belong_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_admin_belong_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `group_id` int(11) NOT NULL COMMENT '管理组id',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='用户所在管理组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_admin_belong_group`
--

LOCK TABLES `app_admin_belong_group` WRITE;
/*!40000 ALTER TABLE `app_admin_belong_group` DISABLE KEYS */;
INSERT INTO `app_admin_belong_group` VALUES (9,20,13),(14,19,13),(17,22,13),(18,1,13),(19,1,15);
/*!40000 ALTER TABLE `app_admin_belong_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_admin_group`
--

DROP TABLE IF EXISTS `app_admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_admin_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) NOT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `uid` int(11) NOT NULL COMMENT '创建者uid',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='管理组';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_admin_group`
--

LOCK TABLES `app_admin_group` WRITE;
/*!40000 ALTER TABLE `app_admin_group` DISABLE KEYS */;
INSERT INTO `app_admin_group` VALUES (13,'开发者','程序猿',1,1461208680),(15,'测试2','',1,1461326104);
/*!40000 ALTER TABLE `app_admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_admin_group_action`
--

DROP TABLE IF EXISTS `app_admin_group_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_admin_group_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT '管理组id',
  `auth_access_id` int(11) NOT NULL COMMENT '访问规则id',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `auth_access_id` (`auth_access_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COMMENT='管理组用户的权限';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_admin_group_action`
--

LOCK TABLES `app_admin_group_action` WRITE;
/*!40000 ALTER TABLE `app_admin_group_action` DISABLE KEYS */;
INSERT INTO `app_admin_group_action` VALUES (65,13,1),(66,13,3),(77,15,1),(78,15,4),(79,15,1),(80,15,5);
/*!40000 ALTER TABLE `app_admin_group_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_admin_member`
--

DROP TABLE IF EXISTS `app_admin_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_admin_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `is_allowed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0否 1是',
  `lastlgtm` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录后台时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='管理员';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_admin_member`
--

LOCK TABLES `app_admin_member` WRITE;
/*!40000 ALTER TABLE `app_admin_member` DISABLE KEYS */;
INSERT INTO `app_admin_member` VALUES (8,13,0,0,0),(9,14,1461250684,0,0),(14,19,1461251640,0,0),(15,20,1461251729,0,0),(16,21,1461291990,0,0),(20,22,1461319776,0,0),(21,1,0,0,0);
/*!40000 ALTER TABLE `app_admin_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_auth`
--

DROP TABLE IF EXISTS `app_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_auth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id，0为顶级',
  `module` varchar(30) NOT NULL COMMENT '模块',
  `controller` varchar(30) NOT NULL COMMENT '控制器',
  `action` varchar(30) NOT NULL COMMENT '操作名称',
  `param` varchar(80) DEFAULT NULL COMMENT '额外参数',
  `name` varchar(50) NOT NULL COMMENT '规则名称',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `auth` (`module`,`controller`,`action`,`param`),
  KEY `sort` (`sort`),
  KEY `module` (`module`,`controller`,`action`),
  KEY `module_2` (`module`),
  KEY `controller` (`controller`),
  KEY `action` (`action`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='权限规则列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_auth`
--

LOCK TABLES `app_auth` WRITE;
/*!40000 ALTER TABLE `app_auth` DISABLE KEYS */;
INSERT INTO `app_auth` VALUES (1,0,'Adminn','UserController','get_list','','用户管理',0),(3,1,'Adminn','Test','hello','','hello',0),(4,1,'Adminn','Test','hi','','hi',0),(5,1,'Adminn','Test','how','','how',0),(6,0,'f','f','f1','','用户管理',0),(7,6,'f','f','f2','','后台管理组',0),(8,7,'Adminn','AdminUser','admin_post','','后台添加用户组',0),(9,7,'Adminn','AdminGroup','group_post','','后台管理组',0),(10,0,'Adminn','Secret','index','','私密档案',0);
/*!40000 ALTER TABLE `app_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_cate`
--

DROP TABLE IF EXISTS `app_cate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父级菜单id，0为顶级菜单',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 显示，0 不显示',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `uid` int(11) NOT NULL COMMENT '创建者uid',
  `icon` varchar(50) DEFAULT NULL COMMENT '分类图标',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序id',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='前台帖子分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_cate`
--

LOCK TABLES `app_cate` WRITE;
/*!40000 ALTER TABLE `app_cate` DISABLE KEYS */;
INSERT INTO `app_cate` VALUES (100,0,1,'php',0,NULL,NULL,0);
/*!40000 ALTER TABLE `app_cate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_comments`
--

DROP TABLE IF EXISTS `app_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(10) unsigned NOT NULL COMMENT '用户uid',
  `post_id` int(11) NOT NULL COMMENT '被评论文章id',
  `createtime` int(11) NOT NULL COMMENT '评论时间',
  `content` text NOT NULL COMMENT '评论内容',
  `post_like` int(11) DEFAULT '0' COMMENT 'post赞数',
  `parentid` int(11) NOT NULL COMMENT '评论父id',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
  `ischild` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有子评论 0木有 1有',
  `to_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'reply to uid',
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `uid` (`uid`),
  KEY `to_uid` (`to_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='文章帖子评论';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_comments`
--

LOCK TABLES `app_comments` WRITE;
/*!40000 ALTER TABLE `app_comments` DISABLE KEYS */;
INSERT INTO `app_comments` VALUES (1,1,0,1461496503,'jhgjhblbbkblkjlk',0,0,0,0,0),(2,1,7,1461497183,'hello world！！！！！！！！！！！',0,0,0,0,0),(3,1,7,1461497372,'么么大，哈哈哈',0,0,0,0,0),(4,1,7,1461507681,'you are so great!',0,0,0,0,0),(5,1,7,1461507717,'love you !!!!!',0,0,0,0,0),(6,1,7,1461510556,'you are so cool!!!!!!!!!!!!!!!!!!!!!!!!',0,0,0,0,0),(7,1,7,1461510966,'how do you do !',0,0,0,0,0),(8,1,7,1461511165,'how do you do !!',0,0,0,1,0),(9,1,7,1461513236,'I am fine! think you',0,7,0,0,0),(10,1,7,1461514069,'welllllllllllllll',0,8,0,1,0),(11,1,7,1461515849,'listen to me , you are so good!',0,8,0,0,0),(12,1,7,1461517161,'okkkkkkkkkkk',0,10,0,0,0),(13,1,6,1461523874,'不错，markdown',0,0,0,0,0),(14,1,10,1461556086,'窗前明月光，疑是地上霜',0,0,0,0,0),(15,1,10,1461556104,'窗前明月光，疑是地上霜!',0,0,0,0,0),(16,1,10,1461556696,'举头望明也，低头思故乡',0,0,0,0,0),(17,1,10,1461556880,'锄禾日当午，汗滴禾下土',0,0,0,0,0),(18,1,10,1461557236,'千山鸟飞绝，万径人踪灭',0,0,0,0,0),(19,1,10,1461557477,'孤舟蓑笠翁，独钓寒江雪',0,0,0,0,0),(20,1,10,1461557602,'一去二三里，延村四五家',0,0,0,0,0),(21,1,10,1461557791,'停车坐爱枫林晚，霜叶红于二月花',0,0,0,0,0),(22,1,10,1461557996,'停车坐爱枫林晚，霜叶红于二月花',0,0,0,1,0),(23,1,10,1461558083,'好诗好诗，不错',0,22,0,0,0),(24,1,10,1461558488,';lsdjf\'a;sfjldfjsldjfalsfj;alsjfawejfiwf',0,0,0,0,0),(25,1,10,1461558698,'野火烧不尽，春风吹又生',0,0,0,1,0),(26,1,10,1461558734,'一枝红杏出墙来',0,25,0,0,0),(27,1,10,1461559246,'一岁一枯荣,',0,0,0,0,0),(28,1,10,1461559447,'春风得意看风景双龙夺凤',0,0,0,1,0),(29,1,10,1461559552,'风萧萧兮，雨潺潺兮',0,0,0,0,0),(30,1,10,1461559618,'中国文化，博大精深',0,28,0,0,0),(31,1,10,1461559669,'丽丽原上草，，',0,0,0,1,0),(32,1,10,1461559711,'一岁一枯荣，，，，',0,31,0,0,0),(33,1,10,1461559909,'野火烧不尽fff',0,31,0,1,0),(34,1,10,1461560285,'红尘滚滚，灰飞烟灭',0,31,0,0,0),(35,1,10,1461560591,'good good study day day up!',0,31,0,1,0),(36,1,10,1461560625,'好好学习，天天向上',0,35,0,0,0),(37,1,10,1461560667,'艾玛，副教授打飞机阿联的发',0,0,0,1,0),(38,1,10,1461561926,'号人一生平安',0,35,0,0,0),(39,1,10,1461567056,'野火烧不尽，快递费加拉斯地方了',0,31,0,0,0),(40,4,10,1461591573,'大家好~~~~~~~',0,0,0,1,0),(41,4,10,1461591606,'how are you!',0,37,0,0,0),(42,4,10,1461594520,'春风吹又生！',0,33,0,0,0),(43,4,10,1461599248,'你是管理员！！！',0,40,0,0,4),(44,4,10,1461599571,'呢吗呢吗好，',0,31,0,0,1);
/*!40000 ALTER TABLE `app_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_credit`
--

DROP TABLE IF EXISTS `app_credit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_credit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(10) unsigned NOT NULL COMMENT '用户uid',
  `type` tinyint(1) NOT NULL COMMENT '积分类型 1签到 2发表帖子',
  `createtime` int(11) NOT NULL COMMENT '积分时间',
  `credit` int(11) NOT NULL COMMENT '积分',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='积分表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_credit`
--

LOCK TABLES `app_credit` WRITE;
/*!40000 ALTER TABLE `app_credit` DISABLE KEYS */;
INSERT INTO `app_credit` VALUES (1,5,1,20160418,11),(2,5,1,20160418,11),(3,5,1,20160423,3),(4,1,1,20160423,2),(5,1,2,20160424,10),(6,1,2,20160425,6),(7,1,1,20160425,2),(8,4,2,20160425,8),(9,4,1,20160425,2);
/*!40000 ALTER TABLE `app_credit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_menu`
--

DROP TABLE IF EXISTS `app_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `parentid` int(11) NOT NULL DEFAULT '0' COMMENT '父级菜单id，0为顶级菜单',
  `module` varchar(30) NOT NULL COMMENT '模块',
  `controller` varchar(30) NOT NULL COMMENT '控制器',
  `action` varchar(30) NOT NULL COMMENT '操作名称',
  `param` varchar(80) DEFAULT NULL COMMENT '额外参数',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 显示，0 不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `uid` int(11) NOT NULL COMMENT '创建者uid',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序id',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COMMENT='后台菜单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_menu`
--

LOCK TABLES `app_menu` WRITE;
/*!40000 ALTER TABLE `app_menu` DISABLE KEYS */;
INSERT INTO `app_menu` VALUES (100,0,'Adminn','UserController','index','',1,'用户管理',0,'','test',0),(107,100,'Adminn','1','1','1',1,'后台用户',1,'','',0),(108,107,'Adminn','AdminUser','get_user_list','',1,'管理员',1,'','',0),(109,107,'Adminn','AdminGroup','get_group_list','',1,'管理组',1,'','',0),(111,100,'f','f','f2','',1,'前台用户',1,'','',0),(112,111,'Adminn','UserList','get_user_list','',1,'用户列表',1,'','',0),(113,0,'Adminn','Statistics','index','',1,'统计管理',1,'','',0),(114,0,'t','t','t11','',0,'隐藏测试',1,'','',0),(115,0,'Adminn','Secret','index','',1,'私密档案',1,'','',0),(116,107,'Adminn','AdminUser','myself','',1,'我的资料',1,'','',0);
/*!40000 ALTER TABLE `app_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_nav_item`
--

DROP TABLE IF EXISTS `app_nav_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_nav_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(100) NOT NULL,
  `pid` int(11) NOT NULL,
  `word` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  `beiZhu` varchar(10) DEFAULT NULL,
  `trash` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_nav_item`
--

LOCK TABLES `app_nav_item` WRITE;
/*!40000 ALTER TABLE `app_nav_item` DISABLE KEYS */;
INSERT INTO `app_nav_item` VALUES (1,0,1,'淘宝','http://www.taobao.com',1,NULL,NULL),(3,0,1,'发现','http://shop57995814.taobao.com/?spm=a230r.7195193.1997079397.1.j5YrnB',2,'',NULL),(4,0,2,'罗辑思维','http://www.youku.com/show_page/id_z5bdbf57c947311e3b8b7.html',1,NULL,NULL),(5,0,2,'暴走大事件','http://www.youku.com/show_page/id_z358fb9aafb7d11e3a705.html',2,NULL,NULL),(6,0,2,'音乐','http://music.youku.com/',3,NULL,NULL),(7,0,1,'尽情的拖拽我','http://weibo.com/u/1896238917/home?wvr=5&lf=reg',3,'我的微博，欢迎关注',NULL),(8,0,3,'未登录只能部分功能演示,想保存数据等请登陆后操作','http://www.baidu.com',1,'好奇就注册一下吧',NULL);
/*!40000 ALTER TABLE `app_nav_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_nav_parent`
--

DROP TABLE IF EXISTS `app_nav_parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_nav_parent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ppid` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `sort` int(11) NOT NULL,
  `attrState` tinyint(1) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_nav_parent`
--

LOCK TABLES `app_nav_parent` WRITE;
/*!40000 ALTER TABLE `app_nav_parent` DISABLE KEYS */;
INSERT INTO `app_nav_parent` VALUES (1,1,'购物',1,0,0),(2,2,'视频',1,0,0),(3,2,'操作说明',2,0,0);
/*!40000 ALTER TABLE `app_nav_parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_nav_row`
--

DROP TABLE IF EXISTS `app_nav_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_nav_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_nav_row`
--

LOCK TABLES `app_nav_row` WRITE;
/*!40000 ALTER TABLE `app_nav_row` DISABLE KEYS */;
INSERT INTO `app_nav_row` VALUES (1,1),(2,2),(3,3);
/*!40000 ALTER TABLE `app_nav_row` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_nav_user`
--

DROP TABLE IF EXISTS `app_nav_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_nav_user` (
  `uid` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `markcategory` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_nav_user`
--

LOCK TABLES `app_nav_user` WRITE;
/*!40000 ALTER TABLE `app_nav_user` DISABLE KEYS */;
INSERT INTO `app_nav_user` VALUES (0,'admin','购物');
/*!40000 ALTER TABLE `app_nav_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_posts`
--

DROP TABLE IF EXISTS `app_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(10) unsigned NOT NULL COMMENT '用户uid',
  `createtime` int(11) NOT NULL COMMENT '文章创建时间',
  `mtime` int(11) NOT NULL COMMENT '文章最后修改时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:草稿，1:发表，2:禁用(管理员操作)',
  `summary` varchar(50) NOT NULL COMMENT '文章概要',
  `content` text NOT NULL COMMENT '文章内容',
  `post_hits` int(11) DEFAULT '0' COMMENT 'post点击数，查看数',
  `post_like` int(11) DEFAULT '0' COMMENT 'post赞数',
  `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
  `recommended` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐 1加精 0不加精',
  `class_id` int(11) NOT NULL COMMENT '分类id',
  `cate` int(11) NOT NULL COMMENT '分类id',
  `comment_sum` int(11) DEFAULT '0' COMMENT '文章评论总数',
  `title` varchar(40) NOT NULL COMMENT '文章标题',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `createtime` (`createtime`),
  KEY `status` (`status`),
  KEY `class_id` (`class_id`),
  KEY `cate` (`cate`),
  KEY `istop` (`istop`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='文章帖子';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_posts`
--

LOCK TABLES `app_posts` WRITE;
/*!40000 ALTER TABLE `app_posts` DISABLE KEYS */;
INSERT INTO `app_posts` VALUES (1,1,1461438779,1461438779,1,'hello，is me！ how are you , I am fine! think you !I','hello，is me！ how are you , I am fine! think you !I am doing well! very great!\r\nso good!',0,0,0,0,0,100,0,'未定义'),(2,1,1461439126,1461439126,1,'实例\r\n创建带有 4 个选项的选择列表：\r\n&lt;select&gt;\r\n  &lt;option','实例\r\n创建带有 4 个选项的选择列表：\r\n&lt;select&gt;\r\n  &lt;option value=&quot;volvo&quot;&gt;Volvo&lt;/option&gt;\r\n  &lt;option value=&quot;saab&quot;&gt;Saab&lt;/option&gt;\r\n  &lt;option value=&quot;opel&quot;&gt;Opel&lt;/option&gt;\r\n  &lt;option value=&quot;audi&quot;&gt;Audi&lt;/option&gt;\r\n&lt;/select&gt;\r\n\r\n尝试一下 »\r\n浏览器支持\r\nInternet Explorer Firefox Opera Google Chrome Safari\r\n大多数主流浏览器支持 &lt;option&gt; 标签。\r\n标签定义及使用说明\r\nThe &lt;option&gt; 标签定义下拉列表中的一个选项（一个条目）。\r\n&lt;option&gt; 标签中的内容作为 &lt;select&gt; 或者&lt;datalist&gt; 一个元素使用。\r\n提示和注释\r\n注释：&lt;option&gt; 标签可以在不带有任何属性的情况下使用，但是您通常需要使用 value 属性，此属性会指示出被送往服务器的内容。\r\n注释：请与 select 元素配合使用此标签，否则这个标签是没有意义的。\r\n提示：如果列表选项很多，可以使用 &lt;optgroup&gt; 标签对相关选项进行组合。\r\n属性\r\n属性	值	描述\r\ndisabled	disabled	规定此选项应在首次加载时被禁用。\r\nlabel	text	定义当使用 &lt;optgroup&gt; 时所使用的标注。\r\nselected	selected	规定选项（在首次显示在列表中时）表现为选中状态。\r\nvalue	text	定义送往服务器的选项值。\r\n\r\n全局属性\r\n&lt;option&gt; 标签支持全局属性，查看完整属性表 HTML全局属性。\r\n事件属性',0,0,0,0,0,100,0,'未定义'),(3,1,1461439294,1461439294,1,'JavaScript 教程\r\nJavaScript 是 Web 的编程语言。\r\n所有现代的 HTML','JavaScript 教程\r\nJavaScript 是 Web 的编程语言。\r\n所有现代的 HTML 页面都使用 JavaScript。\r\nJavaScript 非常容易学。\r\n本教程将教你学习从初级到高级JavaScript知识。\r\nJavaScript 在线实例\r\n本教程包含了大量的 JavaScript 实例， 您可以点击 &quot;尝试一下&quot; 来在线查看实例。\r\n实例\r\n我的第一个 JavaScript 程序\r\n这是一个段落\r\n显示日期 \r\n\r\n\r\n尝试一下 »\r\n在每个页面您可以点击 &quot;尝试一下&quot; 在线查看实例！！！\r\n尝试每个实例，并且在线修改代码，查看不同的运行效果！！！\r\nNote	如果能根据本站的实例一步一个脚印学习，你将会在很短的时间内学会 JavaScript。\r\n\r\n为什么学习 JavaScript?\r\nJavaScript web 开发人员必须学习的 3 门语言中的一门：\r\nHTML 定义了网页的内容\r\nCSS 描述了网页的布局\r\nJavaScript 网页的行为\r\n本教程是关于 JavaScript 及介绍 JavaScript 如何与 HTML 和 CSS 一起工作。\r\n\r\n谁适合阅读本教程?\r\n1. 如果您想学习 JavaScript，您可以学习本教程：\r\n了解 JavaScript 是如何与 HTML 和 CSS 一起工作的。\r\n2. 如果在此之前您已经使用过 JavaScript，您也可以阅读本教程：\r\nJavaScript 一直在升级，所以我们需要时刻了解 JavaScript 的新技术。\r\n\r\n阅读本教程前，您需要了解的知识：\r\n阅读本教程，您需要有以下基础：\r\nHTML 和 CSS 基础\r\n如果您想学习这些基础知识，您可以在我们的首页找到相应的教程菜鸟教程。\r\n\r\nJavaScript 实例\r\n学习 100 多个 JavaScript 实例！\r\n在实例页面中，您可以点击 &quot;尝试一下&quot; 来查看 JavaScript 在线实例。\r\nJavaScript 实例\r\nJavaScript 对象实例\r\nJavaScript 浏览器支持实例\r\nJavaScript HTML DOM 实例\r\n\r\nJavaScript 测验\r\n在 W3CSchool 中测试您的 JavaScript 技能！\r\n\r\nJavaScript 参考手册\r\n在 W3CSchool 中，我们为您提供完整的 JavaScript 对象、浏览器对象、HTML DOM 对象参考手册。\r\n以下手册包含了每个对象、属性、方法的实例。\r\nJavaScript 内置对象\r\nBrowser 对象\r\nHTML DOM 对象',0,0,0,0,0,100,0,'未定义'),(4,1,1461439359,1461439359,1,'kdk','JavaScript 教程\r\nJavaScript 是 Web 的编程语言。\r\n所有现代的 HTML 页面都使用 JavaScript。\r\nJavaScript 非常容易学。\r\n本教程将教你学习从初级到高级JavaScript知识。\r\nJavaScript 在线实例\r\n本教程包含了大量的 JavaScript 实例， 您可以点击 &quot;尝试一下&quot; 来在线查看实例。\r\n实例\r\n我的第一个 JavaScript 程序\r\n这是一个段落\r\n显示日期 \r\n\r\n\r\n尝试一下 »\r\n在每个页面您可以点击 &quot;尝试一下&quot; 在线查看实例！！！\r\n尝试每个实例，并且在线修改代码，查看不同的运行效果！！！\r\nNote	如果能根据本站的实例一步一个脚印学习，你将会在很短的时间内学会 JavaScript。\r\n\r\n为什么学习 JavaScript?\r\nJavaScript web 开发人员必须学习的 3 门语言中的一门：\r\nHTML 定义了网页的内容\r\nCSS 描述了网页的布局\r\nJavaScript 网页的行为\r\n本教程是关于 JavaScript 及介绍 JavaScript 如何与 HTML 和 CSS 一起工作。\r\n\r\n谁适合阅读本教程?\r\n1. 如果您想学习 JavaScript，您可以学习本教程：\r\n了解 JavaScript 是如何与 HTML 和 CSS 一起工作的。\r\n2. 如果在此之前您已经使用过 JavaScript，您也可以阅读本教程：\r\nJavaScript 一直在升级，所以我们需要时刻了解 JavaScript 的新技术。\r\n\r\n阅读本教程前，您需要了解的知识：\r\n阅读本教程，您需要有以下基础：\r\nHTML 和 CSS 基础\r\n如果您想学习这些基础知识，您可以在我们的首页找到相应的教程菜鸟教程。\r\n\r\nJavaScript 实例\r\n学习 100 多个 JavaScript 实例！\r\n在实例页面中，您可以点击 &quot;尝试一下&quot; 来查看 JavaScript 在线实例。\r\nJavaScript 实例\r\nJavaScript 对象实例\r\nJavaScript 浏览器支持实例\r\nJavaScript HTML DOM 实例\r\n\r\nJavaScript 测验\r\n在 W3CSchool 中测试您的 JavaScript 技能！\r\n\r\nJavaScript 参考手册\r\n在 W3CSchool 中，我们为您提供完整的 JavaScript 对象、浏览器对象、HTML DOM 对象参考手册。\r\n以下手册包含了每个对象、属性、方法的实例。\r\nJavaScript 内置对象\r\nBrowser 对象\r\nHTML DOM 对象',0,0,0,0,0,100,0,'未定义'),(5,1,1461439547,1461439547,1,'JavaScript 教程\r\nJavaScript 是 Web 的编程语言。\r\n所有现代的 HTML','JavaScript 教程\r\nJavaScript 是 Web 的编程语言。\r\n所有现代的 HTML 页面都使用 JavaScript。\r\nJavaScript 非常容易学。\r\n本教程将教你学习从初级到高级JavaScript知识。\r\nJavaScript 在线实例\r\n本教程包含了大量的 JavaScript 实例， 您可以点击 &quot;尝试一下&quot; 来在线查看实例。\r\n实例\r\n我的第一个 JavaScript 程序\r\n这是一个段落\r\n显示日期 \r\n\r\n\r\n尝试一下 »\r\n在每个页面您可以点击 &quot;尝试一下&quot; 在线查看实例！！！\r\n尝试每个实例，并且在线修改代码，查看不同的运行效果！！！\r\nNote	如果能根据本站的实例一步一个脚印学习，你将会在很短的时间内学会 JavaScript。\r\n\r\n为什么学习 JavaScript?\r\nJavaScript web 开发人员必须学习的 3 门语言中的一门：\r\nHTML 定义了网页的内容\r\nCSS 描述了网页的布局\r\nJavaScript 网页的行为\r\n本教程是关于 JavaScript 及介绍 JavaScript 如何与 HTML 和 CSS 一起工作。\r\n\r\n谁适合阅读本教程?\r\n1. 如果您想学习 JavaScript，您可以学习本教程：\r\n了解 JavaScript 是如何与 HTML 和 CSS 一起工作的。\r\n2. 如果在此之前您已经使用过 JavaScript，您也可以阅读本教程：\r\nJavaScript 一直在升级，所以我们需要时刻了解 JavaScript 的新技术。\r\n\r\n阅读本教程前，您需要了解的知识：\r\n阅读本教程，您需要有以下基础：\r\nHTML 和 CSS 基础\r\n如果您想学习这些基础知识，您可以在我们的首页找到相应的教程菜鸟教程。\r\n\r\nJavaScript 实例\r\n学习 100 多个 JavaScript 实例！\r\n在实例页面中，您可以点击 &quot;尝试一下&quot; 来查看 JavaScript 在线实例。\r\nJavaScript 实例\r\nJavaScript 对象实例\r\nJavaScript 浏览器支持实例\r\nJavaScript HTML DOM 实例\r\n\r\nJavaScript 测验\r\n在 W3CSchool 中测试您的 JavaScript 技能！\r\n\r\nJavaScript 参考手册\r\n在 W3CSchool 中，我们为您提供完整的 JavaScript 对象、浏览器对象、HTML DOM 对象参考手册。\r\n以下手册包含了每个对象、属性、方法的实例。\r\nJavaScript 内置对象\r\nBrowser 对象\r\nHTML DOM 对象',0,0,0,0,0,100,0,'未定义'),(6,1,1461439773,1461439773,1,'JavaScript 函数定义\r\nJavaScript 使用关键字 function 定义函数。\r\n','JavaScript 函数定义\r\nJavaScript 使用关键字 function 定义函数。\r\n函数可以通过声明定义，也可以是一个表达式。\r\n函数声明\r\n在之前的教程中，你已经了解了函数声明的语法 :\r\nfunction functionName(parameters) {\r\n  执行的代码\r\n}\r\n函数声明后不会立即执行，会在我们需要的时候调用到。\r\n实例\r\nfunction myFunction(a, b) {\r\n    return a * b;\r\n}\r\n\r\n尝试一下 »\r\n\r\nNote	分号是用来分隔可执行JavaScript语句。 \r\n由于函数声明不是一个可执行语句，所以不以分号结束。\r\n\r\n函数表达式\r\nJavaScript 函数可以通过一个表达式定义。\r\n函数表达式可以存储在变量中：\r\n实例\r\nvar x = function (a, b) {return a * b};\r\n\r\n尝试一下 »\r\n在函数表达式存储在变量后，变量也可作为一个函数使用：\r\n实例\r\nvar x = function (a, b) {return a * b};\r\nvar z = x(4, 3);\r\n\r\n尝试一下 »\r\n以上函数实际上是一个 匿名函数 (函数没有名称)。\r\n函数存储在变量中，不需要函数名称，通常通过变量名来调用。\r\nNote	上述函数以分号结尾，因为它是一个执行语句。\r\n\r\nFunction() 构造函数\r\n在以上实例中，我们了解到函数通过关键字 function 定义。\r\n函数同样可以通过内置的 JavaScript 函数构造器（Function()）定义。\r\n实例\r\nvar myFunction = new Function(&quot;a&quot;, &quot;b&quot;, &quot;return a * b&quot;);\r\n\r\nvar x = myFunction(4, 3);\r\n\r\n尝试一下 »\r\n实际上，你不必使用构造函数。上面实例可以写成：\r\n实例\r\nvar myFunction = function (a, b) {return a * b}\r\n\r\nvar x = myFunction(4, 3);\r\n\r\n尝试一下 »\r\n\r\nNote	在 JavaScript 中，很多时候，你需要避免使用 new 关键字。\r\n\r\n函数提升（Hoisting）\r\n在之前的教程中我们已经了解了 &quot;hoisting(提升)&quot;。\r\n提升（Hoisting）是 JavaScript 默认将当前作用域提升到前面去的的行为。\r\n提升（Hoisting）应用在变量的声明与函数的声明。\r\n因此，函数可以在声明之前调用：\r\nmyFunction(5);\r\n\r\nfunction myFunction(y) {\r\n    return y * y;\r\n}\r\n使用表达式定义函数时无法提升。\r\n自调用函数\r\n函数表达式可以 &quot;自调用&quot;。\r\n自调用表达式会自动调用。\r\n如果表达式后面紧跟 () ，则会自动调用。\r\n不能自调用声明的函数。\r\n通过添加括号，来说明它是一个函数表达式：\r\n实例\r\n(function () {\r\n    var x = &quot;Hello!!&quot;;      // 我将调用自己\r\n})();\r\n\r\n尝试一下 »\r\n以上函数实际上是一个 匿名自我调用的函数 (没有函数名)。\r\n函数可作为一个值使用\r\nJavaScript 函数作为一个值使用：\r\n实例\r\nfunction myFunction(a, b) {\r\n    return a * b;\r\n}\r\n\r\nvar x = myFunction(4, 3);\r\n\r\n尝试一下 »\r\nJavaScript 函数可作为表达式使用：\r\n实例\r\nfunction myFunction(a, b) {\r\n    return a * b;\r\n}\r\n\r\nvar x = myFunction(4, 3) * 2;\r\n\r\n尝试一下 »\r\n\r\n函数是对象\r\n在 JavaScript 中使用 typeof 操作符判断函数类型将返回 &quot;function&quot; 。\r\n但是JavaScript 函数描述为一个对象更加准确。\r\nJavaScript 函数有 属性 和 方法。\r\narguments.length 属性返回函数调用过程接收到的参数个数：\r\n实例\r\nfunction myFunction(a, b) {\r\n    return arguments.length;',2,0,0,0,0,100,1,'未定义'),(7,1,1461439872,1461439872,1,'JavaScript 函数定义\r\nJavaScript 使用关键字 function 定义函数。\r\n','JavaScript 函数定义\r\nJavaScript 使用关键字 function 定义函数。\r\n函数可以通过声明定义，也可以是一个表达式。\r\n函数声明\r\n在之前的教程中，你已经了解了函数声明的语法 :\r\nfunction functionName(parameters) {\r\n  执行的代码\r\n}\r\n函数声明后不会立即执行，会在我们需要的时候调用到。\r\n实例\r\nfunction myFunction(a, b) {\r\n    return a * b;\r\n}\r\n\r\n尝试一下 »\r\n\r\nNote	分号是用来分隔可执行JavaScript语句。 \r\n由于函数声明不是一个可执行语句，所以不以分号结束。\r\n\r\n函数表达式\r\nJavaScript 函数可以通过一个表达式定义。\r\n函数表达式可以存储在变量中：\r\n实例\r\nvar x = function (a, b) {return a * b};\r\n\r\n尝试一下 »\r\n在函数表达式存储在变量后，变量也可作为一个函数使用：\r\n实例\r\nvar x = function (a, b) {return a * b};\r\nvar z = x(4, 3);\r\n\r\n尝试一下 »\r\n以上函数实际上是一个 匿名函数 (函数没有名称)。\r\n函数存储在变量中，不需要函数名称，通常通过变量名来调用。\r\nNote	上述函数以分号结尾，因为它是一个执行语句。\r\n\r\nFunction() 构造函数\r\n在以上实例中，我们了解到函数通过关键字 function 定义。\r\n函数同样可以通过内置的 JavaScript 函数构造器（Function()）定义。\r\n实例\r\nvar myFunction = new Function(&quot;a&quot;, &quot;b&quot;, &quot;return a * b&quot;);\r\n\r\nvar x = myFunction(4, 3);\r\n\r\n尝试一下 »\r\n实际上，你不必使用构造函数。上面实例可以写成：\r\n实例\r\nvar myFunction = function (a, b) {return a * b}\r\n\r\nvar x = myFunction(4, 3);\r\n\r\n尝试一下 »\r\n\r\nNote	在 JavaScript 中，很多时候，你需要避免使用 new 关键字。\r\n\r\n函数提升（Hoisting）\r\n在之前的教程中我们已经了解了 &quot;hoisting(提升)&quot;。\r\n提升（Hoisting）是 JavaScript 默认将当前作用域提升到前面去的的行为。\r\n提升（Hoisting）应用在变量的声明与函数的声明。\r\n因此，函数可以在声明之前调用：\r\nmyFunction(5);\r\n\r\nfunction myFunction(y) {\r\n    return y * y;\r\n}\r\n使用表达式定义函数时无法提升。\r\n自调用函数\r\n函数表达式可以 &quot;自调用&quot;。\r\n自调用表达式会自动调用。\r\n如果表达式后面紧跟 () ，则会自动调用。\r\n不能自调用声明的函数。\r\n通过添加括号，来说明它是一个函数表达式：\r\n实例\r\n(function () {\r\n    var x = &quot;Hello!!&quot;;      // 我将调用自己\r\n})();\r\n\r\n尝试一下 »\r\n以上函数实际上是一个 匿名自我调用的函数 (没有函数名)。\r\n函数可作为一个值使用\r\nJavaScript 函数作为一个值使用：\r\n实例\r\nfunction myFunction(a, b) {\r\n    return a * b;\r\n}\r\n\r\nvar x = myFunction(4, 3);\r\n\r\n尝试一下 »\r\nJavaScript 函数可作为表达式使用：\r\n实例\r\nfunction myFunction(a, b) {\r\n    return a * b;\r\n}\r\n\r\nvar x = myFunction(4, 3) * 2;\r\n\r\n尝试一下 »\r\n\r\n函数是对象\r\n在 JavaScript 中使用 typeof 操作符判断函数类型将返回 &quot;function&quot; 。\r\n但是JavaScript 函数描述为一个对象更加准确。\r\nJavaScript 函数有 属性 和 方法。\r\narguments.length 属性返回函数调用过程接收到的参数个数：\r\n实例\r\nfunction myFunction(a, b) {\r\n    return arguments.length;',97,0,0,0,0,100,11,'未定义'),(8,1,1461524191,1461524191,1,'&lt;div style=&quot;color:red;&quot;&gt;hello&lt;/','&lt;div style=&quot;color:red;&quot;&gt;hello&lt;/div&gt;\r\n&lt;script&gt;alert(true);&lt;/script&gt;',2,0,0,0,0,100,0,'xss测试,come'),(9,1,1461524269,1461524269,1,'&lt;div style=&quot;color:red;&quot;&gt;hello&lt;/','&lt;div style=&quot;color:red;&quot;&gt;hello&lt;/div&gt;\r\n&lt;script&gt;alert(true);&lt;/script&gt;',1,0,0,0,0,100,0,'xss测试,come1'),(10,1,1461524353,1461524353,1,'&lt;div style=&quot;color:red;&quot;&gt;hello&lt;/','&lt;div style=&quot;color:red;&quot;&gt;hello&lt;/div&gt;\r\n&lt;script&gt;alert(true);&lt;/script&gt;```\r\n&lt;script&gt;alert(true);&lt;/script&gt;\r\n```',64,0,0,0,0,100,31,'xss测试,come1'),(11,4,1461591525,1461591525,1,'您可以使用 HTML 来建立自己的 WEB 站点。\r\n在本教程中，您将学习如何使用 HT','您可以使用 HTML 来建立自己的 WEB 站点。\r\n在本教程中，您将学习如何使用 HTML 来创建站点。\r\nHTML 很容易学习！相信您能很快学会它！\r\nHTML 实例\r\n本教程包含了数百个 HTML 实例。\r\n使用本站的编辑器，您可以轻松实现在线修改 HTML，并查看实例运行结果。\r\n注意：对于中文网页需要使用 &lt;meta charset=&quot;utf-8&quot;&gt; 声明编码，否则会出现乱码。\r\n实例\r\n&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n&lt;head&gt;\r\n&lt;meta charset=&quot;utf-8&quot;&gt;\r\n&lt;title&gt;菜鸟教程(runoob.com)&lt;/title&gt;\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n\r\n&lt;h1&gt;我的第一个标题&lt;/h1&gt;\r\n\r\n&lt;p&gt;我的第一个段落。&lt;/p&gt;\r\n\r\n&lt;/body&gt;\r\n&lt;/html&gt;\r\n\r\n尝试一下 »\r\n点击 &quot;尝试一下&quot; 按钮查看在线实例\r\n开始学习HTML!\r\nHTML 实例\r\n在 HTML 手册中包含了数百个在线实例，您可以在线编辑并查看运行结果。\r\n查看 HTML 实例！\r\nHTML 参考手册\r\n在菜鸟教程中，我们提供了完整的 HTML 参考手册，其中包括标签、属性、颜色、实体等等。\r\nHTML 标签参考手册\r\n',1,0,0,0,0,100,0,'HTML 教程- (HTML5 标准)'),(12,4,1461592237,1461592237,1,'语义= 意义.\r\n语义元素 = 元素的意义.\r\n什么是语义元素?\r\n一个语义元素能够','语义= 意义.\r\n语义元素 = 元素的意义.\r\n什么是语义元素?\r\n一个语义元素能够清楚的描述其意义给浏览器和开发者。\r\n无语义 元素实例: &lt;div&gt; 和 &lt;span&gt; - 无需考虑内容.\r\n语义元素实例: &lt;form&gt;, &lt;table&gt;, and &lt;img&gt; - 清楚的定义了它的内容.\r\n浏览器支持\r\nInternet ExplorerFirefoxOperaGoogle ChromeSafari\r\nInternet Explorer 9+, Firefox, Chrome, Safari 和 Opera 支持语义元素。\r\n注意: Internet Explorer 8及更早版本不支持该元素. 但是文章底部提供了兼容的解决方法.\r\nHTML5中新的语义元素\r\n许多现有网站都包含以下HTML代码： &lt;div id=&quot;nav&quot;&gt;, &lt;div class=&quot;header&quot;&gt;, 或者 &lt;div id=&quot;footer&quot;&gt;, 来指明导航链接, 头部, 以及尾部.\r\nHTML5提供了新的语义元素来明确一个Web页面的不同部分:\r\n&lt;header&gt;\r\n&lt;nav&gt;\r\n&lt;section&gt;\r\n&lt;article&gt;\r\n&lt;aside&gt;\r\n&lt;figcaption&gt;\r\n&lt;figure&gt;\r\n&lt;footer&gt;\r\nHTML5 语义元素\r\nHTML5 &lt;section&gt; 元素\r\n&lt;section&gt; 标签定义文档中的节（section、区段）。比如章节、页眉、页脚或文档中的其他部分。\r\n根据W3C HTML5文档: section 包含了一组内容及其标题。\r\n实例\r\n&lt;section&gt;\r\n  &lt;h1&gt;WWF&lt;/h1&gt;\r\n  &lt;p&gt;The World Wide Fund for Nature (WWF) is....&lt;/p&gt;\r\n&lt;/section&gt;\r\n\r\n尝试一下 »\r\n\r\nHTML5 &lt;article&gt; 元素\r\n&lt;article&gt; 标签定义独立的内容。.\r\n&lt;article&gt; 元素使用实例:\r\nForum post\r\nBlog post\r\nNews story\r\nComment\r\n实例\r\n&lt;article&gt;\r\n  &lt;h1&gt;Internet Explorer 9&lt;/h1&gt;\r\n  &lt;p&gt;Windows Internet Explorer 9 (abbreviated as IE9) was released to\r\n  the  public on March 14, 2011 at 21:00 PDT.....&lt;/p&gt;\r\n&lt;/article&gt;\r\n\r\n尝试一下 »\r\n\r\nHTML5 &lt;nav&gt; 元素\r\n&lt;nav&gt; 标签定义导航链接的部分。\r\n&lt;nav&gt; 元素用于定义页面的导航链接部分区域，但是，不是所有的链接都需要包含在 &lt;nav&gt; 元素中!\r\n实例\r\n&lt;nav&gt;\r\n&lt;a href=&quot;/html/&quot;&gt;HTML&lt;/a&gt; |\r\n&lt;a href=&quot;/css/&quot;&gt;CSS&lt;/a&gt; |\r\n&lt;a href=&quot;/js/&quot;&gt;JavaScript&lt;/a&gt; |\r\n&lt;a href=&quot;/jquery/&quot;&gt;jQuery&lt;/a&gt;\r\n&lt;/nav&gt;\r\n\r\n尝试一下 »\r\n\r\nHTML5 &lt;aside&gt; 元素\r\n&lt;aside&gt; 标签定义页面主区域内容之外的内容（比如侧边栏）。\r\naside 标签的内容应与主区域的内容相关.\r\n实例\r\n&lt;p&gt;My family and I visited The Epcot center this summer.&lt;/p&gt;\r\n\r\n&lt;aside&gt;\r\n  &lt;h4&gt;Epcot Center&lt;/h4&gt;\r\n  &lt;p&gt;The Epcot Center is a theme park in Disney World, Florida.&lt;/p&gt;\r\n&lt;/aside&gt;\r\n\r\n尝试一下 »\r\n\r\nHTML5 &lt;header&gt; 元素\r\n&lt;header&gt;元素描述了文档的头部区域\r\n&lt;header&gt;元素注意用于定义内容的介绍展示区域.\r\n在页面中你可以使用多个&lt;header&gt; 元素.\r\n以下实例定义了文章的头部:\r\n实例\r\n&lt;article&gt;\r\n  &lt;header&gt;\r\n    &lt;h1&gt;Internet Explorer 9&lt;/h1&gt;\r\n    &lt;p&gt;&lt;time pubdate datetime=&quot;2011-03-15&quot;&gt;&lt;/time&gt;&lt;/p&gt;\r\n  &lt;/header&gt;\r\n  &lt;p&gt;Windows Internet Explorer 9 (abbreviated as IE9) was released to\r\n  the  public on March 14, 2011 at 21:00 PDT.....&lt;/p&gt;\r\n&lt;/article&gt;\r\n\r\n尝试一下 »\r\n\r\nHTML5 &lt;footer&gt; 元素\r\n&lt;footer&gt; 元素描述了文档的底部区域.\r\n&lt;footer&gt; 元素应该包含它的包含元素\r\n一个页脚通常包含文档的作者，著作权信息，链接的使用条款，联系信息等\r\n文档中你可以使用多个 &lt;footer&gt;元素.\r\n实例\r\n&lt;footer&gt;\r\n  &lt;p&gt;Posted by: Hege Refsnes&lt;/p&gt;\r\n  &lt;p&gt;&lt;time pubdate datetime=&quot;2012-03-01&quot;&gt;&lt;/time&gt;&lt;/p&gt;\r\n&lt;/footer&gt;\r\n\r\n尝试一下 »\r\n\r\nHTML5 &lt;figure&gt; 和 &lt;figcaption&gt; 元素',0,0,0,0,0,100,0,'HTML5 语义元素'),(13,4,1461592416,1461592416,1,'HTML5 新元素\r\n自1999年以后HTML 4.01 已经改变了很多,今天，在HTML 4.01','HTML5 新元素\r\n自1999年以后HTML 4.01 已经改变了很多,今天，在HTML 4.01中的几个已经被废弃，这些元素在HTML5中已经被删除或重新定义。\r\n为了更好地处理今天的互联网应用，HTML5添加了很多新元素及功能，比如: 图形的绘制，多媒体内容，更好的页面结构，更好的形式 处理，和几个api拖放元素，定位，包括网页 应用程序缓存，存储，网络工作者，等。\r\n&lt;canvas&gt; 新元素\r\n标签	描述\r\n&lt;canvas&gt;	标签定义图形，比如图表和其他图像。该标签基于 JavaScript 的绘图 API\r\n\r\n新多媒体元素\r\n标签	描述\r\n&lt;audio&gt;	定义音频内容\r\n&lt;video&gt;	定义视频（video 或者 movie）\r\n&lt;source&gt;	定义多媒体资源 &lt;video&gt; 和 &lt;audio&gt;\r\n&lt;embed&gt;	定义嵌入的内容，比如插件。\r\n&lt;track&gt;	为诸如 &lt;video&gt; 和 &lt;audio&gt; 元素之类的媒介规定外部文本轨道。\r\n\r\n新表单元素\r\n标签	描述\r\n&lt;datalist&gt;	定义选项列表。请与 input 元素配合使用该元素，来定义 input 可能的值。\r\n&lt;keygen&gt;	规定用于表单的密钥对生成器字段。\r\n&lt;output&gt;	定义不同类型的输出，比如脚本的输出。\r\n\r\n新的语义和结构元素\r\nHTML5提供了新的元素来创建更好的页面结构：\r\n标签	描述\r\n&lt;article&gt;	定义页面独立的内容区域。\r\n&lt;aside&gt;	定义页面的侧边栏内容。\r\n&lt;bdi&gt;	允许您设置一段文本，使其脱离其父元素的文本方向设置。\r\n&lt;command&gt;	定义命令按钮，比如单选按钮、复选框或按钮\r\n&lt;details&gt;	用于描述文档或文档某个部分的细节\r\n&lt;dialog&gt;	定义对话框，比如提示框\r\n&lt;summary&gt;	标签包含 details 元素的标题\r\n&lt;figure&gt;	规定独立的流内容（图像、图表、照片、代码等等）。\r\n&lt;figcaption&gt;	定义 &lt;figure&gt; 元素的标题\r\n&lt;footer&gt;	定义 section 或 document 的页脚。\r\n&lt;header&gt;	定义了文档的头部区域\r\n&lt;mark&gt;	定义带有记号的文本。\r\n&lt;meter&gt;	定义度量衡。仅用于已知最大和最小值的度量。\r\n&lt;nav&gt;	定义导航链接的部分。\r\n&lt;progress&gt;	定义任何类型的任务的进度。\r\n&lt;ruby&gt;	定义 ruby 注释（中文注音或字符）。\r\n&lt;rt&gt;	定义字符（中文注音或字符）的解释或发音。\r\n&lt;rp&gt;	在 ruby 注释中使用，定义不支持 ruby 元素的浏览器所显示的内容。\r\n&lt;section&gt;	定义文档中的节（section、区段）。\r\n&lt;time&gt;	定义日期或时间。\r\n&lt;wbr&gt;	规定在文本中的何处适合添加换行符。\r\n\r\n已移除的元素\r\n以下的 HTML 4.01 元素在HTML5中已经被删除:\r\n&lt;acronym&gt;\r\n&lt;applet&gt;\r\n&lt;basefont&gt;\r\n&lt;big&gt;\r\n&lt;center&gt;\r\n&lt;dir&gt;\r\n&lt;font&gt;\r\n&lt;frame&gt;\r\n&lt;frameset&gt;\r\n&lt;noframes&gt;',0,0,0,0,0,100,0,'HTML5 新元素'),(14,4,1461592515,1461592515,1,'Windows 和 Mac 的键盘快捷键\r\n在现代操作系统中和计算机软件程序中，键盘快','Windows 和 Mac 的键盘快捷键\r\n在现代操作系统中和计算机软件程序中，键盘快捷键经常被使用。\r\n使用键盘快捷键能帮您节省很多时间。\r\n基本的快捷键\r\n\r\n描述	Windows	Mac OS\r\n编辑菜单	Alt + E	Ctrl + F2 + F\r\n文件菜单	Alt + F	Ctrl + F2 + E\r\n视图菜单	Alt + V	Ctrl + F2 + V\r\n全选文本	Ctrl + A	Cmd + A\r\n复制文本	Ctrl + C	Cmd + C\r\n查找文本	Ctrl + F	Cmd + F\r\n查找替换文本	Ctrl + H	Cmd + F\r\n新建文档	Ctrl + N	Cmd + N\r\n打开文件	Ctrl + O	Cmd + O\r\n打印选项	Ctrl + P	Cmd + P\r\n保存文件	Ctrl + S	Cmd + S\r\n粘贴文本	Ctrl + V	Cmd + V\r\n剪切文本	Ctrl + X	Cmd + X\r\n重做文本	Ctrl + Y	Shift + Cmd + Z\r\n撤销文本	Ctrl + Z	Cmd + Z\r\n\r\n\r\n文本编辑\r\n\r\n描述	Windows	Mac OS\r\n光标移动		\r\n将文本插入光标向右移动或者移动到下一行行首	Right Arrow	Right Arrow\r\n将文本插入光标向左移动或者移动到上一行行尾	Left Arrow	Left Arrow\r\n将文本插入光标向上移动一行	Up Arrow	Up Arrow\r\n将文本插入光标向下移动一行	Down Arrow	Down Arrow\r\n将文本插入光标移动到当前行的行首	Home	Cmd + Left Arrow\r\n将文本插入光标移动到当前行的行尾	End	Cmd + Right Arrow\r\n将文本插入光标移动到文档的开头	Ctrl + Home	Cmd + Up Arrow\r\n将文本插入光标移动到文档的结尾	Ctrl + End	Cmd + Down Arrow\r\n将文本插入光标移动到上一个文本框	Page Up	Fn + Up Arrow\r\n将文本插入光标移动到下一个文本框	Page Down	Fn + Down Arrow\r\n将文本插入光标向左移动到前一个词的开头	Ctrl + Left Arrow	Option + Left Arrow\r\n将文本插入光标向右移动到后一个词的开头	Ctrl + Right Arrow	Option + Right Arrow\r\n将文本插入光标移动到行首	Ctrl + Up Arrow	Cmd + Left Arrow\r\n将文本插入光标移动到行尾	Ctrl + Down Arrow	Cmd + Right Arrow\r\n 	 	 \r\n文本选择		\r\n选择文本插入光标左边的字符	Shift + Left Arrow	Shift + Left Arrow\r\n选择文本插入光标右边的字符	Shift + Right Arrow	Shift + Right Arrow\r\n向上选择一行文本	Shift + Up Arrow	Shift + Up Arrow\r\n向下选择一行文本	Shift + Down Arrow	Shift + Down Arrow\r\n选择文本插入光标左边的字	Shift + Ctrl + Left	Shift + Opt + Left\r\n选择文本插入光标右边的字	Shift + Ctrl + Right	Shift + Opt + Right\r\n向左选择一段文本	Shift + Ctrl + Up	Shift + Opt + Up\r\n向右选择一段文本	Shift + Ctrl + Down	Shift + Opt + Down\r\n选择文本插入光标与当前行行首之间的文本	Shift + Home	Cmd + Shift + Left Arrow\r\n选择文本插入光标与当前行行尾之间的文本	Shift + End	Cmd + Shift + Right Arrow\r\n选择文本插入光标与文档开头之间的文本	Shift + Ctrl + Home	Cmd + Shift + Up Arrow or Cmd + Shift + Fn + Left Arrow\r\n选择文本插入光标与文档结尾之间的文本	Shift + Ctrl + End	Cmd + Shift + Down Arrow or Cmd + Shift + Fn + Right Arrow\r\n向上选择一个文本框	Shift + Page Up	Shift + Fn + Up Arrow\r\n向下选择一个文本框	Shift + Page Down	Shift + Fn + Down Arrow\r\n全选文本	Ctrl + A	Cmd + A\r\n查找文本	Ctrl + F	Cmd + F\r\n 	 	 \r\n文本排版		\r\n将所选文本设置为粗体	Ctrl + B	Cmd + B\r\n将所选文本设置为斜体	Ctrl + I	Cmd + I\r\n将所选文本加下划线	Ctrl + U	Cmd + U\r\n将所选文本设置为上标	Ctrl + Shift + =	Cmd + Shift + =\r\n将所选文本设置为下标	Ctrl + =	Cmd + =\r\n 	 	 \r\n文本编辑		\r\n删除文本插入光标左边的字符	Backspace	Backspace\r\n删除文本插入光标右边的字符	Delete	Fn + Backspace\r\n删除文本插入光标右边的字	Ctrl + Del	Cmd + Backspace\r\n删除文本插入光标左边的字	Ctrl + Backspace	Cmd + Fn + Backspace\r\n增加缩进量	Tab	Tab\r\n减少缩进量	Shift + Tab	Shift + Tab\r\n复制文本	Ctrl + C	Cmd + C\r\n查找替换文本	Ctrl + H	Cmd + F\r\n粘贴文本	Ctrl + V	Cmd + V\r\n剪切文本	Ctrl + X	Cmd + X\r\n重做文本	Ctrl + Y	Shift + Cmd + Z\r\n撤销文本	Ctrl + Z	Cmd + Z\r\n',0,0,0,0,0,100,0,'键盘快捷键!!!');
/*!40000 ALTER TABLE `app_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_posts_class`
--

DROP TABLE IF EXISTS `app_posts_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_posts_class` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `class_name` varchar(20) NOT NULL COMMENT '分类名',
  `uid` int(11) NOT NULL COMMENT '创建者uid',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 0不显示 1显示',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章帖子分类';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_posts_class`
--

LOCK TABLES `app_posts_class` WRITE;
/*!40000 ALTER TABLE `app_posts_class` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_posts_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_sign`
--

DROP TABLE IF EXISTS `app_sign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_sign` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(10) unsigned NOT NULL COMMENT '用户uid',
  `sign_tm` int(10) unsigned NOT NULL COMMENT '签到时间',
  `sign_num` smallint(6) NOT NULL COMMENT '连续签到天数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='用户签到表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_sign`
--

LOCK TABLES `app_sign` WRITE;
/*!40000 ALTER TABLE `app_sign` DISABLE KEYS */;
INSERT INTO `app_sign` VALUES (1,1,1461572330,2),(2,2,1450888360,1),(3,3,1460194676,2),(4,4,1461591695,1),(15,5,1460991124,1);
/*!40000 ALTER TABLE `app_sign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user`
--

DROP TABLE IF EXISTS `app_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `regtm` int(11) NOT NULL COMMENT '注册时间',
  `lastlgtm` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `lastrettm` int(11) DEFAULT NULL COMMENT '最后获取重置密码token时间',
  `chg_pwd_tm` int(11) NOT NULL,
  `isdisabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为不禁用，1为禁用',
  `email` varchar(30) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `platform` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1手动注册，2qq，3微博，4微信，5其他',
  `token` varchar(50) DEFAULT NULL COMMENT '激活码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否激活,验证邮箱激活',
  `regip` varchar(15) NOT NULL COMMENT '注册ip',
  `lastip` varchar(15) NOT NULL COMMENT '最后登录ip',
  `avatar` varchar(100) DEFAULT NULL,
  `credit` int(11) NOT NULL DEFAULT '0' COMMENT '用户总积分',
  `login_times` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user`
--

LOCK TABLES `app_user` WRITE;
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;
INSERT INTO `app_user` VALUES (1,'admin123','87d9bb400c0634691f0e3baaf1e2fd0d',1450523317,1461338724,1460182213,0,0,'1434970057@qq.com',0,1,NULL,0,'','127.0.0.1',NULL,20,1),(2,'admin1','87d9bb400c0634691f0e3baaf1e2fd0d',1450586825,1451110812,1460143108,0,0,'1293812979@qq.com',0,1,NULL,0,'','127.0.0.1','http://saetp.qq/Uploads/avatar/2015/12/26/20151226164023966.jpeg',0,0),(3,'hello1','87d9bb400c0634691f0e3baaf1e2fd0d',1460089561,1460194661,NULL,0,0,'348959@qq.com',2147483647,1,NULL,0,'','127.0.0.1','http://saetp.qq/Uploads/avatar/2016/04/08/20160408151927895.jpeg',0,0),(4,'user123','87d9bb400c0634691f0e3baaf1e2fd0d',1460906343,1461590096,NULL,0,0,'khgi@qq.com',2147483647,1,NULL,0,'','127.0.0.1',NULL,10,1),(5,'test11','87d9bb400c0634691f0e3baaf1e2fd0d',1460972656,1460974968,NULL,0,0,'dfkj@qq.com',2147483647,1,NULL,0,'','127.0.0.1',NULL,11,0),(12,'jfkdien','87d9bb400c0634691f0e3baaf1e2fd0d',0,NULL,NULL,0,0,'143497005@qq.com',NULL,1,NULL,0,'','',NULL,0,0),(13,'jfkdiene','87d9bb400c0634691f0e3baaf1e2fd0d',0,NULL,NULL,0,0,'14349700@qq.com',NULL,1,NULL,0,'','',NULL,0,0),(14,'jfkdie','87d9bb400c0634691f0e3baaf1e2fd0d',0,NULL,NULL,0,0,'1434970@qq.com',NULL,1,NULL,0,'','',NULL,0,0),(19,'谢谢12345','87d9bb400c0634691f0e3baaf1e2fd0d',0,NULL,NULL,0,0,'1234567890@qq.com',NULL,1,NULL,0,'','',NULL,0,0),(20,'testttttttt1','87d9bb400c0634691f0e3baaf1e2fd0d',0,1461322687,NULL,0,0,'kfkld10o@qq.com',NULL,1,NULL,0,'','127.0.0.1',NULL,0,0),(21,'ios1234','87d9bb400c0634691f0e3baaf1e2fd0d',0,1461323002,NULL,0,0,'dfjk@qq.com',NULL,1,NULL,0,'','127.0.0.1',NULL,0,0),(22,'helloworld','87d9bb400c0634691f0e3baaf1e2fd0d',0,1461384214,NULL,0,0,'12345@qq.com',NULL,1,NULL,0,'','127.0.0.1',NULL,0,0),(23,'',NULL,0,NULL,NULL,0,0,'',12345678,1,NULL,0,'','',NULL,0,0);
/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-26  1:17:57
