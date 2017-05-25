DROP TABLE IF EXISTS `lqsj_third_users`;
CREATE TABLE `lqsj_third_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `thirdCode` varchar(20) DEFAULT NULL,
  `thirdOpenId` varchar(100) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;