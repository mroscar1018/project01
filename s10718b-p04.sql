-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2019-04-18 12:24:25
-- 伺服器版本: 5.7.17-log
-- PHP 版本： 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `s10718b-p04`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cart`
--

CREATE TABLE `cart` (
  `cartid` int(11) NOT NULL,
  `sid` int(10) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `ordtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 資料表結構 `class`
--

CREATE TABLE `class` (
  `cid` tinyint(4) NOT NULL,
  `cname` varchar(20) NOT NULL,
  `sort` varchar(1) DEFAULT NULL,
  `img` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `class`
--

INSERT INTO `class` (`cid`, `cname`, `sort`, `img`) VALUES
(0, '粥', '1', 'c0'),
(1, '麵', '2', 'c1'),
(2, '小菜', '3', 'c2'),
(3, '湯', '4', 'c3');

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `shopid` int(10) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pw1` varchar(30) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `addr` varchar(200) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `order`
--

CREATE TABLE `order` (
  `id` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `shopid` int(10) NOT NULL,
  `qty` smallint(6) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `sid` int(11) NOT NULL,
  `cid` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` varchar(11) NOT NULL,
  `descript` varchar(100) NOT NULL COMMENT '商品簡介',
  `img` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `product`
--

INSERT INTO `product` (`sid`, `cid`, `name`, `price`, `descript`, `img`) VALUES
(1, 0, '皮蛋瘦肉粥', '80', '皮蛋加瘦肉', 'a01'),
(2, 0, '鹹蛋瘦肉粥', '80', '', 'a02'),
(3, 0, '翡翠銀魚粥', '80', '', 'a03'),
(4, 0, '黃金南瓜粥', '85', '', 'a04'),
(5, 0, '滑蛋牛肉粥', '85', '', 'a05'),
(6, 0, '海鮮粥', '90', '', 'a06'),
(7, 1, '椒麻拌麵', '55', '', 'b02'),
(8, 1, '蔥油蒜香拌麵', '55', '', 'b01'),
(9, 1, '海鮮烏龍麵', '110', '', 'b03'),
(10, 1, '番茄海鮮烏龍麵', '130', '', 'b04'),
(11, 3, '蛋花湯', '35', '', 'd01'),
(12, 3, '蛤蠣湯', '45', '', 'd02'),
(13, 3, '貢丸湯', '40', '', 'd03'),
(14, 3, '海鮮湯', '70', '', 'd04'),
(15, 3, '番茄海鮮湯', '90', '', 'd05'),
(16, 2, '燙青菜', '40', '', 'c01'),
(17, 2, '綜合滷味黑白切', '依量計算', '', 'c02');

-- --------------------------------------------------------

--
-- 資料表結構 `signup`
--

CREATE TABLE `signup` (
  `id` int(4) NOT NULL COMMENT '流水編號',
  `jt` varchar(2) NOT NULL COMMENT '性別',
  `username` varchar(20) NOT NULL COMMENT '使用者名稱',
  `mobile` varchar(10) NOT NULL COMMENT '使用者電話',
  `special` varchar(200) DEFAULT NULL COMMENT '需求',
  `ordertime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartid`);

--
-- 資料表索引 `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`cid`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`shopid`);

--
-- 資料表索引 `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `cartid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;
--
-- 使用資料表 AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `shopid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- 使用資料表 AUTO_INCREMENT `order`
--
ALTER TABLE `order`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- 使用資料表 AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用資料表 AUTO_INCREMENT `signup`
--
ALTER TABLE `signup`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT COMMENT '流水編號', AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
