DROP TABLE IF EXISTS `app_posts_class`;
CREATE TABLE `app_posts_class` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `class_name` varchar(20) NOT NULL COMMENT '分类名',
   `uid` int NOT NULL COMMENT '创建者uid',
   `ctime` int NOT NULL COMMENT '创建时间',
   `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示 0不显示 1显示',
   PRIMARY KEY (`id`),
   KEY (`status`)
   -- KEY (`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章帖子分类';

