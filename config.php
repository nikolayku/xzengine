<?php
//---------------------------------------------
// config file created atFriday 02nd 2011f September 2011 11:25:39 PM
//---------------------------------------------

// ��������� ����� 

define("OFF_SITE","0"); 					// ��������� ����
define("OFF_SITE_MESSAGE","���� �������� ��������. ������� ���������������� ������."); 					// ��������� �������������
define("DEBUG_MODE","0"); 					// ��������� debug ������

// ������ � ��

define("DATABASE_HOST",""); 					// ��� ����� � ��
define("DATABASE_USER",""); 					// ������������
define("DATABASE_PASSWORD",""); 					// ������
define("DATABASE_NAME","test"); 					// ��� ���� ������
define("DATABASE_TBLPERFIX","xz_"); 					// ������� ������ ��� ��������
define("DATABASE_USEMYSQL","0"); 					// ������������� mysql ��� ��������� ��. ��������������� ������ ��� ���������, ���������� ��������� �������� ������ "������"

// ��������� �������� ���������

define("SITE_LOC_FILE","ru"); 					// ���� � ����� ����������� ��� �����
define("ADMINPANEL_LOC_FILE","eng"); 					// ���� � ����� ����������� ��� �����������

// ��������� GZip

define("GZIP_ENABLED","0"); 					// ��������� gzip
define("GZIP_COMPRESSION","3"); 					// ������� ����������

// ��������� �����

define("SITE_PATH","http://localhost/xzengine/trunk"); 					// ���� � �����
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

define("FORUM_PATH","#"); 					// ���� � ������ , ���� ���� ����������� � �� , �� ���� ����� ���������� �� ��� {forum_path}

// ��������� ��������������

define("ADMIN_LOGIN","admin"); 					// ����� ��������������
define("ADMIN_PASS","1"); 					// ������ ��������������
?>