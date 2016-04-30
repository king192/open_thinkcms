CREATE TABLE `app_cate` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `parentid` int NOT NULL DEFAULT 0 COMMENT '父级菜单id，0为顶级菜单',
   `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 显示，0 不显示',
   `name` varchar(50) NOT NULL COMMENT '分类名称',
   `uid` int NOT NULL COMMENT '创建者uid',
   `icon` varchar(50) DEFAULT NULL COMMENT '分类图标',
   `remark` varchar(255) DEFAULT NULL COMMENT '备注',
   `sort` smallint unsigned NOT NULL DEFAULT 0 COMMENT '排序id', 
   PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='前台帖子分类' AUTO_INCREMENT=100;

-- insert into `app_cate` (name) values ('hello');