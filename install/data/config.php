<?php

//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

//---------------------------------------------
// ���� ���� �������� �������� ��� �������� ���������������� �����
//---------------------------------------------

// ��������� ����� 

define("OFF_SITE","0"); 					// ��������� ����
define("OFF_SITE_MESSAGE","���� �������� ��������. ������� ���������������� ������."); 					// ��������� �������������
define("DEBUG_MODE","0"); 					// ��������� debug ������

// ������ � ��

define("DATABASE_HOST","{database_host}"); 					// ��� ����� � ��
define("DATABASE_USER","{database_user}"); 					// ������������
define("DATABASE_PASSWORD","{database_pass}"); 					// ������
define("DATABASE_NAME","{database_name}"); 					// ��� ���� ������
define("DATABASE_TBLPERFIX","{database_tableperfix}"); 					// ������� ������ ��� ��������
define("DATABASE_USEMYSQL","{database_usemysql}"); 					// ������������� mysql ��� ��������� ��. ��������������� ������ ��� ���������, ���������� ��������� �������� ������ "������"


// ��������� �������� ���������

define("SITE_LOC_FILE","ru"); 					// ���� � ����� ����������� ��� �����
define("ADMINPANEL_LOC_FILE","eng"); 					// ���� � ����� ����������� ��� �����������

// ��������� GZip

define("GZIP_ENABLED","0"); 					// ��������� gzip
define("GZIP_COMPRESSION","3"); 					// ������� ����������

// ��������� �����

define("SITE_PATH","{sitepath}"); 					// ���� � �����
define("NEWSPERPAGE","15"); 					// ���������� �������� �� ��������
define("SITE_TITLE","xzengine - ��������� ������ �������"); 					// ��������� �����
define("SITE_KEYWORDS","CMS, ������ �����, ������� ������ �����"); 					// �������� �����
define("SKIN","xzengine_ru"); 					// ���� ��� �����
define("DATEFORMAT","F jS, Y"); 					// ������ ����
define("SIMPLY_URL","0"); 					// �������� ������ � ������� ���� ��� ��� ������� ����������� ������ � ���� .htaccess
define("USERS_CAN_ADD_NEWS","1"); 					// ����� �� ������� ������������ ��������� �������

// �����������

define("ADMINPANEL_SKIN","default"); 					// ���� �� ��������� ��� �����������
define("ADMINPANEL_NEWSPERPAGE","50"); 					// ���������� �������� �� �������� ��������������

// Rss ���������

define("RSS_NEWS","30"); 					// ������� ����� ���������� ��������
define("RSS_DESCRIPTION","rss ����� "); 					// �������� �������
define("RSS_LIVETIME","60"); 					// ����� ����� ������� ������� ��������� ���������� Rss ������

// �������� ������

define("UPLOADFILE_SIZE","2097152"); 					// ������������ ������ ����� ������������ �� ������
define("UPLOADFILE_DIRECTORY","upload"); 					// ���������� ���� ��������� ����������� �����

// ���� � ������

define("FORUM_PATH","{forumpath}"); 					// ���� � ������ , ���� ���� ����������� � �� , �� ���� ����� ���������� �� ��� {forum_path}
?>