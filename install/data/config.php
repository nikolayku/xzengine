<?php

//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

//---------------------------------------------
// этот файл является шаблоном для создания конфигурационнго файла
//---------------------------------------------

// Состояние сайта 

define("OFF_SITE","0"); 					// Отключить сайт
define("OFF_SITE_MESSAGE","Сайт временно отключён. Ведутся профилактические работы."); 					// Сообщение пользователям
define("DEBUG_MODE","0"); 					// состояние debug режима

// работа с БД

define("DATABASE_HOST","{database_host}"); 					// имя хоста с БД
define("DATABASE_USER","{database_user}"); 					// пользователь
define("DATABASE_PASSWORD","{database_pass}"); 					// пароль
define("DATABASE_NAME","{database_name}"); 					// имя базы данных
define("DATABASE_TBLPERFIX","{database_tableperfix}"); 					// перфикс таблиц при создании
define("DATABASE_USEMYSQL","{database_usemysql}"); 					// использование mysql или текстовой бд. устанавливается только при установке, дальнейшее изменение возможно только "руками"


// настройки языковой поддержки

define("SITE_LOC_FILE","ru"); 					// путь к файлу локализаций для сайта
define("ADMINPANEL_LOC_FILE","eng"); 					// путь к файлу локализаций для админпанели

// поддержка GZip

define("GZIP_ENABLED","0"); 					// поддержка gzip
define("GZIP_COMPRESSION","3"); 					// уровень компрессии

// Настройки сайта

define("SITE_PATH","{sitepath}"); 					// путь к сайту
define("NEWSPERPAGE","15"); 					// количество новостей на странице
define("SITE_TITLE","xzengine - установка прошла успешно"); 					// заголовок сайта
define("SITE_KEYWORDS","CMS, Движок сайта, Скачать движок сайта"); 					// ключевые слова
define("SKIN","xzengine_ru"); 					// скин для сайта
define("DATEFORMAT","F jS, Y"); 					// формат даты
define("SIMPLY_URL","0"); 					// выдавать ссылку в удобном виде или нет требует возможность записи в файл .htaccess
define("USERS_CAN_ADD_NEWS","1"); 					// Могут ли обычные пользователи добавлять новости

// админпанель

define("ADMINPANEL_SKIN","default"); 					// скин по умолчанию для админпанели
define("ADMINPANEL_NEWSPERPAGE","50"); 					// количество новостей на странице редактирования

// Rss Настройки

define("RSS_NEWS","30"); 					// сколько будет выдаваться новостей
define("RSS_DESCRIPTION","rss лента "); 					// описание ресурса
define("RSS_LIVETIME","60"); 					// время через которое следует обновлять содержимое Rss канала

// загрузка файлов

define("UPLOADFILE_SIZE","2097152"); 					// максимальный размер файла загружаемого на сервер
define("UPLOADFILE_DIRECTORY","upload"); 					// директория куда сохранять загруженные файлы

// путь к форуму

define("FORUM_PATH","{forumpath}"); 					// Путь к форуму , если пост сохраняется в бд , то этот текст заменяется на тег {forum_path}
?>