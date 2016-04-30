CREATE TABLE IF NOT EXISTS `app_admin_group_action` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL COMMENT '管理组id',
  `auth_access_id` int NOT NULL COMMENT '访问规则id',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `auth_access_id` (`auth_access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '管理组用户的权限';