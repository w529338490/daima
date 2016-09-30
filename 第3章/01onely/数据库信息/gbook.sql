-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 09 月 07 日 06:24
-- 服务器版本: 5.1.42
-- PHP 版本: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `gbook`
--

-- --------------------------------------------------------

--
-- 表的结构 `ly_gbconfig`
--

CREATE TABLE IF NOT EXISTS `ly_gbconfig` (
  `id` int(10) unsigned NOT NULL DEFAULT '1',
  `admin_user` varchar(64) NOT NULL DEFAULT '',
  `admin_pass` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `ly_gbconfig`
--

INSERT INTO `ly_gbconfig` (`id`, `admin_user`, `admin_pass`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- 表的结构 `ly_guestbook`
--

CREATE TABLE IF NOT EXISTS `ly_guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `reply` text,
  `email` varchar(128) DEFAULT '',
  `userip` varchar(22) NOT NULL DEFAULT '',
  `settop` tinyint(1) NOT NULL DEFAULT '0',
  `ifshow` tinyint(1) NOT NULL DEFAULT '0',
  `ifqqh` tinyint(1) NOT NULL DEFAULT '0',
  `systime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `replytime` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `ly_guestbook`
--

INSERT INTO `ly_guestbook` (`id`, `username`, `content`, `reply`, `email`, `userip`, `settop`, `ifshow`, `ifqqh`, `systime`, `replytime`) VALUES
(2, '千山鸟飞绝', '    尊前作剧莫相笑，我死诸君思我狂……', '嘻嘻', '', '127.0.0.1', 0, 1, 0, '2010-10-08 19:08:31', '2010-09-06 10:08:57'),
(3, '春有恩', '你的照片好漂亮，羡慕死你们了~~', '谢谢~有空过来玩。', '', '127.0.0.1', 0, 1, 0, '2010-09-07 07:44:22', '2010-09-07 07:50:11'),
(5, '独领风骚', '贝斯，你们要注意安全哟，(*^__^*)&nbsp;嘻嘻……祝福你快乐。', NULL, '', '127.0.0.1', 0, 1, 1, '2010-09-07 07:59:13', '0000-00-00 00:00:00');
