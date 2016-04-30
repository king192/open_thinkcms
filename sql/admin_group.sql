CREATE TABLE IF NOT EXISTS `app_admin_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(30) NOT NULL,
  `remark` varchar(100) DEFAULT NULL,
  `uid` int NOt NUll COMMENT '创建者uid',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '管理组';