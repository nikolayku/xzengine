<?php
//---------------------------------------------
// config file created atSunday 22nd 2012f April 2012 11:42:55 PM
//---------------------------------------------

// ��������� ����� 

define("OFF_SITE","0"); 					// ��������� ����
define("OFF_SITE_MESSAGE","���� �������� ��������. ������� ���������������� ������."); 					// ��������� �������������

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

define("GZIP_ENABLED","1"); 					// ��������� gzip
define("GZIP_COMPRESSION","3"); 					// ������� ����������

// ��������� �����

define("SITE_PATH","http://localhost/xzengine/trunk"); 					// ���� � �����
define("NEWSPERPAGE","2"); 					// ���������� �������� �� ��������
define("SITE_TITLE","xzengine - ��������� ������ �������"); 					// ��������� �����
define("SITE_KEYWORDS","CMS, ������ �����, ������� ������ �����"); 					// �������� �����
define("SKIN","buxdozor_ru"); 					// ���� ��� �����
define("DATEFORMAT","F jS, Y"); 					// ������ ����
define("SIMPLY_URL","0"); 					// �������� ������ � ������� ���� ��� ��� ������� ����������� ������ � ���� .htaccess
define("USERS_CAN_ADD_NEWS","1"); 					// ����� �� ������� ������������ ��������� �������

// �����������

define("ADMINPANEL_SKIN","default"); 					// ���� �� ��������� ��� �����������
define("ADMINPANEL_NEWSPERPAGE","50"); 					// ���������� �������� �� �������� ��������������

// �������� ������

define("UPLOADFILE_SIZE","2097152"); 					// ������������ ������ ����� ������������ �� ������
define("UPLOADFILE_DIRECTORY","upload"); 					// ���������� ���� ��������� ����������� �����

// ���� � ������

define("FORUM_PATH","#"); 					// ���� � ������ , ���� ���� ����������� � �� , �� ���� ����� ���������� �� ��� {forum_path}

// ��������� ��������������

define("ADMIN_LOGIN","admin"); 					// ����� ��������������
define("ADMIN_PASS","1"); 					// ������ ��������������
?>