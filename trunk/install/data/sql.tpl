# ��������� ������ ���� ������ ������������ ��� �������� ��������� ������ ��� ��������� 
# ��� xzengine ��������� ����� ����� ��������� ������ � ��� ������ ���� �� ������ ���� 
# ����� � ��� ��������� ������� �� ������ ����������� � ���� ������
# 
# ��������� ������� `{tableperfix}category`
# 

-- 
-- ��������� ������� `{tableperfix}category`
-- 

DROP TABLE IF EXISTS `{tableperfix}category`;
CREATE TABLE `{tableperfix}category` (
  `category_name` text collate cp1251_bin NOT NULL,
  `category_descr` text collate cp1251_bin NOT NULL,
  `category_id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;

-- 
-- ���� ������ ������� `{tableperfix}category`
-- 

INSERT INTO `{tableperfix}category` VALUES ('�������', '', 1);

-- --------------------------------------------------------

-- 
-- ��������� ������� `{tableperfix}feedback`
-- 

DROP TABLE IF EXISTS `{tableperfix}feedback`;
CREATE TABLE `{tableperfix}feedback` (
  `feedback_from` text collate cp1251_bin NOT NULL,
  `feedback_message` text collate cp1251_bin NOT NULL,
  `feedback_id` int(11) NOT NULL auto_increment,
  `feedback_read` tinyint(1) NOT NULL,
  PRIMARY KEY  (`feedback_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;

-- 
-- ���� ������ ������� `{tableperfix}feedback`
-- 


-- --------------------------------------------------------

-- 
-- ��������� ������� `{tableperfix}news`
-- 

DROP TABLE IF EXISTS `{tableperfix}news`;
CREATE TABLE `{tableperfix}news` (
  `news_name` varchar(256) collate cp1251_bin NOT NULL,
  `news_sh_description` text collate cp1251_bin NOT NULL,
  `news_autor` varchar(64) collate cp1251_bin NOT NULL,
  `news_full_link` text collate cp1251_bin NOT NULL,
  `news_date` double NOT NULL,
  `news_fixed` tinyint(1) NOT NULL,
  `news_view` tinyint(1) NOT NULL,
  `news_approve` tinyint(1) NOT NULL,
  `news_id` int(11) NOT NULL auto_increment,
  `news_showfull` text collate cp1251_bin NOT NULL,
  `news_full_or_link` tinyint(1) NOT NULL default '0',
  `news_category` int(11) NOT NULL,
  `news_keyword` text collate cp1251_bin NOT NULL,
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;

-- 
-- ���� ������ ������� `{tableperfix}news`
-- 

INSERT INTO `{tableperfix}news` VALUES ('xzengine 1.7 beta 6', '<p>&nbsp;</p><div style="text-align: center"><img src="{sitepath}/upload/boxsmall.jpg" alt="xzengine 1.7 beta 6" title="xzengine 1.7 beta 6" /></div> <p>&nbsp;</p><p align="left">���� xzengine ��������� �� ������ v.1.5 beta 6<br />�������<br />1) ��������� GZip<br />2) ��������� Rss<br />3) ��������� ����������� ������� (��� �������� ������� � �������������)<br />4) �������� ������ � ������<br />5) ��������� ������ ����������� � ������ �����<br />6) ��������� ����������� ������� � ���<br />7) �������������� �������� �� �����������<br />8) ���������� ������� �������� ���� ��� ������ �������</p><p align="left">�� ��� ��������� � ����� ������ ������ � ��������� </p>', 'xzengine team', '', 1216701386, 0, 1, 1, 1, '<div style="text-align: center"><img src="{sitepath}/upload/boxsmall.jpg" alt="xzengine 1.7 beta 6" title="xzengine 1.7 beta 6" /></div> <p align="left">���� xzengine ��������� �� ������ v.1.5 beta 6<br /> �������<br /> 1) ��������� GZip<br /> 2) ��������� Rss<br /> 3) ��������� ����������� ������� (��� �������� ������� � �������������)<br /> 4) �������� ������ � ������<br /> 5) ��������� ������ ����������� � ������ �����<br /> 6) ��������� ����������� ������� � ���<br /> </p><p align="left">�� ��� ��������� � ����� ������ ������ � ��������� </p><p align="left">� ����� ������ ���������<br />1) ��� �������������� - ����������� �������� ����� <font size="2"><strong>��������</strong> <font size="0">� <font size="1" color="{forum_path}ff6600">������</font></font></font></p><p align="left">2) ��������� ����������� �������������� �������� ����� ����������� � ������� ���������� ����������<br />3) ��������� ���������� �������� ���� ��� ������ ������� � ��� ������� �������� �����. �������� ����� ��� <strong>{keyword} </strong></p>', 1, 1, 'xzengine 1.7 beta 6 �������, ������� xzengine, ������� ���������� ������');

-- --------------------------------------------------------

-- 
-- ��������� ������� `{tableperfix}static`
-- 

DROP TABLE IF EXISTS `{tableperfix}static`;
CREATE TABLE `{tableperfix}static` (
  `static_id` int(11) NOT NULL auto_increment,
  `static_pagename` text collate cp1251_bin NOT NULL,
  `static_text` text collate cp1251_bin NOT NULL,
  PRIMARY KEY  (`static_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;


-- --------------------------------------------------------

-- 
-- ��������� ������� `{tableperfix}users`
-- 

DROP TABLE IF EXISTS `{tableperfix}users`;
CREATE TABLE `{tableperfix}users` (
  `users_login` text collate cp1251_bin NOT NULL,
  `users_password` text collate cp1251_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;

