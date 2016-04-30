CREATE TABLE IF NOT EXISTS `app_admin_belong_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int NOt NUll COMMENT '用户uid',
  `group_id` int NOT NUll COMMENT '管理组id',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '用户所在管理组';

-- alter table `app_admin_belong_group` add index (`uid`);