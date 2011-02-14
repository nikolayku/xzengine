# структура таблиц этот шаблон используется для создание структуры таблиц при установки 
# СМС xzengine изменение этого файла разрешено только в том случае если вы отдаёте себе 
# отчёт в тех действиях которые вы будите производить с этим файлом
# 
# Структура таблицы `{tableperfix}category`
# 

-- 
-- Структура таблицы `{tableperfix}category`
-- 

DROP TABLE IF EXISTS `{tableperfix}category`;
CREATE TABLE `{tableperfix}category` (
  `category_name` text collate cp1251_bin NOT NULL,
  `category_descr` text collate cp1251_bin NOT NULL,
  `category_id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;

-- 
-- Дамп данных таблицы `{tableperfix}category`
-- 

INSERT INTO `{tableperfix}category` VALUES ('Новости', '', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `{tableperfix}feedback`
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
-- Дамп данных таблицы `{tableperfix}feedback`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `{tableperfix}news`
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
-- Дамп данных таблицы `{tableperfix}news`
-- 

INSERT INTO `{tableperfix}news` VALUES ('xzengine 1.7 beta 6', '<p>&nbsp;</p><div style="text-align: center"><img src="{sitepath}/upload/boxsmall.jpg" alt="xzengine 1.7 beta 6" title="xzengine 1.7 beta 6" /></div> <p>&nbsp;</p><p align="left">Двиг xzengine обновился до версии v.1.5 beta 6<br />Функции<br />1) поддержка GZip<br />2) поддержка Rss<br />3) Поддержка статических страниц (для сосдания дорвеев и переадресации)<br />4) Загрузка файлов а сервер<br />5) поддержка скинов админпанели и самого сайта<br />6) поддержка статических страниц и ЧПУ<br />7) редактирование шаблонов из админпанели<br />8) управление списком ключевых слов для каждой новости</p><p align="left">То что добавлено в новой версии читаем в подробнее </p>', 'xzengine team', '', 1216701386, 0, 1, 1, 1, '<div style="text-align: center"><img src="{sitepath}/upload/boxsmall.jpg" alt="xzengine 1.7 beta 6" title="xzengine 1.7 beta 6" /></div> <p align="left">Двиг xzengine обновился до версии v.1.5 beta 6<br /> Функции<br /> 1) поддержка GZip<br /> 2) поддержка Rss<br /> 3) Поддержка статических страниц (для сосдания дорвеев и переадресации)<br /> 4) Загрузка файлов а сервер<br /> 5) поддержка скинов админпанели и самого сайта<br /> 6) поддержка статических страниц и ЧПУ<br /> </p><p align="left">То что добавлено в новой версии читаем в подробнее </p><p align="left">В новой версии добавлено<br />1) для администратора - возможность выделять текст <font size="2"><strong>размером</strong> <font size="0">и <font size="1" color="{forum_path}ff6600">цветом</font></font></font></p><p align="left">2) Добавлена возможность редактирования шаблонов через админпанель с удобной подсветкой синтаксиса<br />3) Добавлено добавление ключевых слов для каждой новости и для главной страницы сайта. Появился новый тег <strong>{keyword} </strong></p>', 1, 1, 'xzengine 1.7 beta 6 скачать, скачать xzengine, система управления сайтом');

-- --------------------------------------------------------

-- 
-- Структура таблицы `{tableperfix}static`
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
-- Структура таблицы `{tableperfix}users`
-- 

DROP TABLE IF EXISTS `{tableperfix}users`;
CREATE TABLE `{tableperfix}users` (
  `users_login` text collate cp1251_bin NOT NULL,
  `users_password` text collate cp1251_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COLLATE=cp1251_bin;

