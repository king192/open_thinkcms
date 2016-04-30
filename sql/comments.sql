CREATE TABLE `app_comments` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `uid` int unsigned NOT NULL COMMENT '用户uid',
   `to_uid` int unsigned NOT NULL DEFAULT 0 COMMENT 'reply to uid',
   `post_id` int NOT NULL COMMENT '被评论文章id',
   `createtime` int NOT NULL COMMENT '评论时间',
   `content` text NOT NULL COMMENT '评论内容',
   `post_like` int(11) DEFAULT '0' COMMENT 'post赞数',
   `parentid` int NOT NULL COMMENT '评论父id',
   `ischild` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否有子评论 0木有 1有',
   `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
   `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0未读 1已读',
   PRIMARY KEY (`id`),
   KEY (`post_id`),
   KEY (`uid`),
   KEY (`to_uid`),
   KEY (`is_read`)
   -- KEY (`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章帖子评论';