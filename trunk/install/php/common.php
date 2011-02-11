<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// �������� ��� �������������� ������� 

// ���� � ����� ��� ����������� ����������
define("db_serialised_filename_path", './temp/db.ras');


class dataBaseConfig
{
	var $host;
	var $user;
	var $pass;
	var $databseName;
	var $tablePerfix;
	var $databaseType;		// mysql 1, textdb 0
}

// ���������� ������ PHP ������
function GetPHPVersionAsInt()
{
	$version = phpversion();
	$version = str_replace(".","", $version);
	return $version;
}

	////////////////////////////////////////////////////////////
	// ������� ������ ��� ���� ����� �������� ���� ��������
	function UpdateConfigFile($server, $username, $password, $databseName, $tablePerfix, $databaseType=1)	
	{	
		$configFilename = "./temp/config.php";
		// �������� ������ �������� �� ����� data � ����� temp 
		copy("./data/config.php", $configFilename);
		// ��������� ������
		$r = file_get_contents($configFilename);
		
		// �������� ����
		
		//{database_host}
		$r = str_replace("{database_host}", $server, $r);		
		
		//{database_user}
		$r = str_replace("{database_user}", $username, $r);		
		
		//{database_pass}
		$r = str_replace("{database_pass}", $password, $r);				
		
		//{database_name}
		$r = str_replace("{database_name}", $databseName, $r);
		
		//{database_tableperfix}
		$r = str_replace("{database_tableperfix}", $tablePerfix, $r);
		
		//{database_usemysql}
		$r = str_replace("{database_usemysql}", $databaseType, $r);
		
		// ��������� ����
		file_put_contents($configFilename, $r);
		
		// ��� ��������� ����� ����������� � ����
		$db = new dataBaseConfig();
		$db->host = $server;
		$db->user = $username;
		$db->pass = $password;
		$db->databseName = $databseName;	
		$db->tablePerfix = $tablePerfix;
		$db->databaseType = $databaseType;

		// �������� ���������� ��� ��������
		$store = serialize($db);
		
		// ��������� 
		file_put_contents(db_serialised_filename_path, $store);
			 
	}	


?>