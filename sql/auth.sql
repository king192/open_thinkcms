CREATE TABLE `app_auth` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `parentid` int NOT NULL DEFAULT 0 COMMENT '父级id，0为顶级',
   `module` varchar(30) NOT NULL COMMENT '模块',
   `controller` varchar(30) NOT NULL COMMENT '控制器',
   `action` varchar(30) NOT NULL COMMENT '操作名称',
   `param` varchar(80) DEFAULT NULL COMMENT '额外参数',
   `sort` smallint NOT NULL DEFAULT 0 COMMENT '排序',
   `name` varchar(50) NOT NULL COMMENT '规则名称',
   PRIMARY KEY (`id`),
   KEY `auth` (`module`,`controller`,`action`,`param`),
   KEY `auth1` (`module`,`controller`,`action`),
   KEY `module` (`module`),
   KEY `controller` (`controller`),
   KEY `action` (`action`),
   KEY `sort` (`sort`)
   -- KEY (`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限规则列表';

-- alter table `app_auth` add `sort` smallint NOT NULL DEFAULT 0 COMMENT '排序';
-- alter table `app_auth` add index (`sort`);
-- alter table `app_auth` add index (`module`,`controller`,`action`);
-- alter table `app_auth` add index (`module`);
-- alter table `app_auth` add index (`controller`);
-- alter table `app_auth` add index (`action`);
