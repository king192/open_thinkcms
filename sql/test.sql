
CREATE TABLE IF NOT EXISTS `app_test_3` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '留言测试表';
CREATE TABLE IF NOT EXISTS `app_test_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '留言测试表';

CREATE TABLE IF NOT EXISTS `app_test_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '留言测试表';

CREATE TABLE IF NOT EXISTS `app_test_0` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `msgid` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT '留言测试表';




INSERT INTO `app_test_0` (`msgid`) VALUES 
('1'),
('2'),
('3'),
('4');
INSERT INTO `app_test_1` (`msgid`) VALUES 
('5'),
('6'),
('7'),
('8');
INSERT INTO `app_test_2` (`msgid`) VALUES 
('9'),
('10'),
('11'),
('12');
INSERT INTO `app_test_3` (`msgid`) VALUES 
('13'),
('14'),
('15'),
('16');