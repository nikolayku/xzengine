<?php
/////////////////////////////////////////////////////
// получение информации о системе
////////////////////////////////////////////////////

class systemInfo
{	
	////////////////////////////////////
	// конструктор
	////////////////////////////////////
	function __construct()
	{
	}		
	
	////////////////////////////////////
	// Получает информацию об общих feedback сообщениях
	// заменяет тег {feedbackmessages}
	////////////////////////////////////
	function GetFeedBackMessages(&$template)
	{	
		$fb = new FeedBack();
		
		// заменяем
		$template = str_replace("{feedbackmessages}", $fb->GetFeedbackMessageCount(), $template);
			
	}	
		

	////////////////////////////////////
	// Получает размер базы данных
	// заменяет тег {databasesize}
	////////////////////////////////////
	function GetDataBaseSize(&$template)
	{	
		// вычисляем размер БД	
		$total = 0;
		if(DATABASE_USEMYSQL)
		{
			$r = AbstractDataBase::Instance()->query('SHOW TABLE STATUS FROM '.DATABASE_NAME);
			while($array = AbstractDataBase::Instance()->get_row($r))
				$total += $array[Data_length]+$array[Index_length];
		}
		// заменяем
		$template = str_replace("{databasesize}", ConvertBytes($total), $template);
			
	}	

	////////////////////////////////////
	// Получает состояние сайта
	// заменяет тег {sitestate}
	////////////////////////////////////
	function GetSiteState(&$template)
	{	
		$st = '';	
		if(OFF_SITE)
			$st = '<b>Сайт выключен</b>';
		else
			$st = 'Сайт включен';

		$template = str_replace("{sitestate}", $st, $template);
	}
		
	
	////////////////////////////////////
	// получает версию PHP
	// заменяет тег {phpversion}
	////////////////////////////////////
	function GetPhpVersion(&$template)
	{
		$template = str_replace("{phpversions}", phpversion(), $template);
	}

	///////////////////////////////////
	// Получает версию Mysql
	// заменяет тег {mysqlversion}
	///////////////////////////////////
	function GetMysqlVersion(&$template)
	{
		
		$template = str_replace("{mysqlversion}", @mysql_get_server_info(), $template);
		
	}

	///////////////////////////////////
	// получает свободный объём в байтах
	// заменяет тег {diskfreespace}
	//////////////////////////////////
	function GetDiskFreeSpace(&$template, $dir = '../')
	{
		$df = disk_free_space("/");
		$template = str_replace("{diskfreespace}", ConvertBytes($df), $template);		
	}
	
	///////////////////////////////////
	// получает размер папки с загруженными на сервер файлами
	// заменяет тег {uplodeddirsize}
	//////////////////////////////////
	function GetUplodedDirSize(&$template)
	{
		$df = GetDirectorySize('../'.UPLOADFILE_DIRECTORY);
		$template = str_replace("{uplodeddirsize}", ConvertBytes($df), $template);		
	}	
		
	///////////////////////////////////
	// получает общий объём в байтах
	// заменяет тег {disktotalspace}
	//////////////////////////////////
	function GetDiskTotalSpace(&$template, $dir = '../')
	{
		$df = disk_total_space("/");	
		$template = str_replace("{disktotalspace}", ConvertBytes($df), $template);
		
	}

	//////////////////////////////////
	// получает общее количество новостей ожидающих проверки
	// заменяет тег {notapprovednews}
	//////////////////////////////////
	function GetNotApprovedNews(&$template)
	{	
		$res = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_approve = 0');	
		$template = str_replace("{notapprovednews}", AbstractDataBase::Instance()->num_rows($res), $template);
	}

	/////////////////////////////////
	// получает общее количество новостей хранящихся в БД
	// заменяет тег {totalnews}
	////////////////////////////////
	function GetTotalNews(&$template)
	{	
		$res = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news');	
		$template = str_replace("{totalnews}", AbstractDataBase::Instance()->num_rows($res), $template);
	}
		
	///////////////////////////////
	// загружает шаблон заменяет все теги
	//////////////////////////////
	
	function render()
	{
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/info.tpl");
		
		$this->GetPhpVersion($template);
		$this->GetMysqlVersion($template);
		$this->GetDiskFreeSpace($template);
		$this->GetDiskTotalSpace($template);
		$this->GetNotApprovedNews($template);
		$this->GetTotalNews($template);
		$this->GetUplodedDirSize($template);	
		$this->GetSiteState($template);		
		$this->GetDataBaseSize($template);
		$this->GetFeedBackMessages($template);		

		return $template;
	}
	
}

?>