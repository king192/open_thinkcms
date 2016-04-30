DROP TABLE IF EXISTS `app_sign`;
CREATE TABLE `app_sign` (
   `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
   `uid` int unsigned NOT NULL COMMENT '用户uid',
   `sign_tm` int unsigned NOT NULL COMMENT '签到时间',
   `sign_num` smallint(6) NOT NULL COMMENT '连续签到天数',
   PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户签到表';