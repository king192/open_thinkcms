CREATE TABLE `app_credit` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `uid` int unsigned NOT NULL COMMENT '用户uid',
   `type` tinyint(1) NOT NULL COMMENT '积分类型 1签到 2发表帖子',
   `credit` int NOT NULL COMMENT '积分',
   `createtime` int(8) NOT NULL COMMENT '积分时间',
   PRIMARY KEY (`id`),
   KEY (`uid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分表';

ALTER TABLE  `app_credit` ADD `credit` int NOT NULL COMMENT '积分';

-- 统计上周用户积分
-- select * from app_credit where month(createtime) = month(curdate()) and week(createtime) = week(curdate())-1
-- where date(时间字段)=date(now())

-- select id,uid,sum(credit) from app_credit where month(createtime) = month(curdate()) and week(createtime) = week(curdate())-1 group by uid order by sum(credit) desc;