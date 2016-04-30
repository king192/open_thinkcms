CREATE TABLE `app_admin_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `module` char(20) NOT NULL COMMENT '模块',
  `controler` char(20) NOT NULL COMMENT '控制器',
  `action` char(20) NOT NULL COMMENT '操作名称',
  `data` char(50) NOT NULL COMMENT '额外参数',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`),
  KEY `controler` (`controler`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `app_admin_menu` VALUES ('1', '0', 'Admin', 'User', 'user', '', '0', '1', '用户管理', 'th', '', '30');
INSERT INTO `app_admin_menu` VALUES ('2', '1', 'Admin', 'User', 'comments', '', '1', '1', '用户组', '', '', '0');
INSERT INTO `app_admin_menu` VALUES ('3', '2', 'Admin', 'User', 'comments', '', '1', '1', '用户列表', '', '', '0');
INSERT INTO `app_admin_menu` VALUES ('4', '1', 'Admin', 'User', 'list', '', '1', '0', '管理组', '', '', '0');

INSERT INTO `app_admin_menu` VALUES ('1', '0', 'Admin', 'User', 'user', '', '0', '1', '用户管理', 'th', '', '30');
INSERT INTO `app_admin_menu` VALUES ('2', '1', 'Admin', 'User', 'comments', '', '1', '1', '用户留言', '', '', '0');
INSERT INTO `app_admin_menu` VALUES ('3', '1', 'Admin', 'User', 'list', '', '1', '0', '用户列表', '', '', '0');
