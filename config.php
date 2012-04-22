<?php
//---------------------------------------------
// config file created atSunday 22nd 2012f April 2012 11:42:55 PM
//---------------------------------------------

// Состояние сайта 

define("OFF_SITE","0"); 					// Отключить сайт
define("OFF_SITE_MESSAGE","Сайт временно отключён. Ведутся профилактические работы."); 					// Сообщение пользователям

// работа с БД

define("DATABASE_HOST",""); 					// имя хоста с БД
define("DATABASE_USER",""); 					// пользователь
define("DATABASE_PASSWORD",""); 					// пароль
define("DATABASE_NAME","test"); 					// имя базы данных
define("DATABASE_TBLPERFIX","xz_"); 					// перфикс таблиц при создании
define("DATABASE_USEMYSQL","0"); 					// использование mysql или текстовой бд. устанавливается только при установке, дальнейшее изменение возможно только "руками"

// настройки языковой поддержки

define("SITE_LOC_FILE","ru"); 					// путь к файлу локализаций для сайта
define("ADMINPANEL_LOC_FILE","eng"); 					// путь к файлу локализаций для админпанели

// поддержка GZip

define("GZIP_ENABLED","1"); 					// поддержка gzip
define("GZIP_COMPRESSION","3"); 					// уровень компрессии

// Настройки сайта

define("SITE_PATH","http://localhost/xzengine/trunk"); 					// путь к сайту
define("NEWSPERPAGE","2"); 					// количество новостей на странице
define("SITE_TITLE","xzengine - установка прошла успешно"); 					// заголовок сайта
define("SITE_KEYWORDS","CMS, Движок сайта, Скачать движок сайта"); 					// ключевые слова
define("SKIN","buxdozor_ru"); 					// скин для сайта
define("DATEFORMAT","F jS, Y"); 					// формат даты
define("SIMPLY_URL","0"); 					// выдавать ссылку в удобном виде или нет требует возможность записи в файл .htaccess
define("USERS_CAN_ADD_NEWS","1"); 					// Могут ли обычные пользователи добавлять новости

// админпанель

define("ADMINPANEL_SKIN","default"); 					// скин по умолчанию для админпанели
define("ADMINPANEL_NEWSPERPAGE","50"); 					// количество новостей на странице редактирования

// загрузка файлов

define("UPLOADFILE_SIZE","2097152"); 					// максимальный размер файла загружаемого на сервер
define("UPLOADFILE_DIRECTORY","upload"); 					// директория куда сохранять загруженные файлы

// путь к форуму

define("FORUM_PATH","#"); 					// Путь к форуму , если пост сохраняется в бд , то этот текст заменяется на тег {forum_path}

// настройки администратора

define("ADMIN_LOGIN","admin"); 					// логин администратора
define("ADMIN_PASS","1"); 					// пароль администратора
?>