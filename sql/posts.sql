CREATE TABLE `app_posts` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `title` varchar(40) NOT NULL COMMENT '文章标题',
   `cate` int NOT NULL COMMENT '分类id',
   `uid` int unsigned NOT NULL COMMENT '用户uid',
   `createtime` int NOT NULL COMMENT '文章创建时间',
   `mtime` int NOT NULL COMMENT '文章最后修改时间',
   `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0:草稿，1:发表，2:禁用(管理员操作)',
   `summary` varchar(200) NOT NULL COMMENT '文章概要',
   `content` text NOT NULL COMMENT '文章内容',
   -- `tags` 
   `post_hits` int(11) DEFAULT '0' COMMENT 'post点击数，查看数',
   `post_like` int(11) DEFAULT '0' COMMENT 'post赞数',
   `comment_sum` int DEFAULT 0 COMMENT '文章评论总数',
   `istop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
   `recommended` tinyint(1) NOT NULL DEFAULT '0' COMMENT '推荐 1加精 0不加精',
   PRIMARY KEY (`id`),
   KEY (`uid`),
   KEY (`createtime`),
   KEY (`status`),
   KEY (`istop`),
   KEY (`cate`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章帖子';

ALTER TABLE `app_posts` ADD `cate` int NOT NULL COMMENT '分类id';
ALTER TABLE `app_posts` ADD INDEX (`cate`);
