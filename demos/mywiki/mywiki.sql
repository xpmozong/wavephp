-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 10 月 30 日 18:02
-- 服务器版本: 5.5.25a
-- PHP 版本: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `mywiki`
--

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '激活 0-否 1-是',
  `add_date` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `email`, `is_active`, `add_date`, `last_login_date`) VALUES
(3, 'xpmozong', 'e10adc3949ba59abbe56e057f20f883e', '361131953@qq.com', 1, '2015-07-17 17:08:19', '2015-10-08 10:14:08');

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
