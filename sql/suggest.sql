CREATE TABLE `app_feedback` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `uid` int unsigned NOT NULL COMMENT '用户uid',
   `createtime` int unsigned NOT NULL COMMENT '创建时间',
   `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已读 0未读 1已读',
   `important` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否标记为重点 0否 1是',
   `title` varchar(100) NOT NULL COMMENT '标题',
   `content` text NOT NULL DEFAULT '' COMMENT '留言内容',
   PRIMARY KEY (`id`),
   KEY `is_read` (`is_read`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户建议或bug反馈表';