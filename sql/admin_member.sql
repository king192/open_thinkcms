CREATE TABLE IF NOT EXISTS `app_admin_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int NOt NUll COMMENT '用户uid',
  `is_allowed` tinyint(1) NOT NUll DEFAULT 0 COMMENT '是否禁用 0否 1是',
  `ctime` int(11) NOT NULL COMMENT '创建时间',
  `lastlgtm` int NOT NULL DEFAULT 0 COMMENT '最后登录后台时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '管理员';

-- alter table `app_admin_member` add `is_allowed` tinyint(1) NOT NUll DEFAULT 0 COMMENT '是否禁用 0否 1是';
-- alter table `app_admin_member` add index (`uid`);