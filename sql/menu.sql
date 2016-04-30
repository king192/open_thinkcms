CREATE TABLE `app_menu` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `parentid` int NOT NULL DEFAULT 0 COMMENT '父级菜单id，0为顶级菜单',
   `module` varchar(30) NOT NULL COMMENT '模块',
   `controller` varchar(30) NOT NULL COMMENT '控制器',
   `action` varchar(30) NOT NULL COMMENT '操作名称',
   `param` varchar(80) DEFAULT NULL COMMENT '额外参数',
   `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 显示，0 不显示',
   `name` varchar(50) NOT NULL COMMENT '菜单名称',
   `uid` int NOT NULL COMMENT '创建者uid',
   `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
   `remark` varchar(255) DEFAULT NULL COMMENT '备注',
   `sort` smallint unsigned NOT NULL DEFAULT 0 COMMENT '排序id', 
   PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台菜单' AUTO_INCREMENT=100;
