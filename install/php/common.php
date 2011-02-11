<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// содержит р€д дополнительных функций 

// путь к файлу где расположена информаци€
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

// возвращ€ет версию PHP числом
function GetPHPVersionAsInt()
{
	$version = phpversion();
	$version = str_replace(".","", $version);
	return $version;
}

	////////////////////////////////////////////////////////////
	// функци€ служит дл€ того чтобы обновить файл настроек
	function UpdateConfigFile($server, $username, $password, $databseName, $tablePerfix, $databaseType=1)	
	{	
		$configFilename = "./temp/config.php";
		// копируем шаблон настроек из папки data в папку temp 
		copy("./data/config.php", $configFilename);
		// загружаем шаблон
		$r = file_get_contents($configFilename);
		
		// замен€ем теги
		
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
		
		// сохран€ем файл
		file_put_contents($configFilename, $r);
		
		// эти настройки будут сохран€тьс€ в файл
		$db = new dataBaseConfig();
		$db->host = $server;
		$db->user = $username;
		$db->pass = $password;
		$db->databseName = $databseName;	
		$db->tablePerfix = $tablePerfix;
		$db->databaseType = $databaseType;

		// получаем переменную дл€ хранени€
		$store = serialize($db);
		
		// сохран€ем 
		file_put_contents(db_serialised_filename_path, $store);
			 
	}	


?>