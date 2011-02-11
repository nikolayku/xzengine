<?php
///////////////////////////////////////////////////////////////////
// настройки текстовой бд
//////////////////////////////////////////////////////////////////

class Page_textbdconfig
{
	// назначение этой функции сделать основные действия	
	// $mainpage - шаблон главной страницы
	function doPage_textbdconfig(&$main_page_template)
	{	
		$main_page_template = str_replace("{title}", page_textbd_title, $main_page_template);		
				
		if(isset($_GET['submit']))
		{
			$tablePerfix = $_POST['database_tableperfix'];
			if($tablePerfix == "")
				return  $this->FillDefault(page_textbd_tableperfix);
			
			$databaseName = $_POST['database_name'];
			if($databaseName == "")
				return $this->FillDefault(page_textbd_database_name);
			
			if(($r = $this->CreateDataBase($databaseName, $tablePerfix)) != "")
				return $this->FillDefault($r);		
			else	
				return $this->ConfigDone();
				
		}

		return $this->FillDefault();
	}

	// Загружает параметры
	function FillDefault($message="")
	{
		// загружаем шаблон 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/configtextdtabase.tpl"); 
		
		// заполняем основные теги
		// {database_name}
		if(isset($_POST['database_name']))
			$ret = str_replace("{database_name}", $_POST['database_name'], $ret);
		else
			$ret = str_replace("{database_name}", "", $ret);
		
		// {database_name}
		if(isset($_POST['database_tableperfix']))
			$ret = str_replace("{database_tableperfix}", $_POST['database_tableperfix'], $ret);
		else
			$ret = str_replace("{database_tableperfix}", "xz_", $ret);	

		// {message}
		$ret = str_replace("{message}", $message, $ret);

		return $ret;
	}
	
	// загружает шаблон если всё прошло нормально
	function ConfigDone()
	{
		// загружаем шаблон 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/configtextdtabase_done.tpl"); 
		return $ret;
	}
	
	// копирует загототовку текстовой бд
	function CreateDataBase($databaseName, $tablePerfix)
	{
		$dirpath = '../admin/backup/'.$databaseName;
		$dirFrom = './data/database/';
		
		if(!@is_dir($dirpath))
		{
			// создаём папку
			if(!@mkdir($dirpath, 0777))
				return page_textbd_create_dir_fail;
		}
	
		// копируем файлы
		if ($dh = opendir($dirFrom)) 
		{	
			while (($file = readdir($dh)) !== false) 
			{	
				if(!is_file($dirFrom.$file))
					continue;
				
				if(!@copy($dirFrom.$file, $dirpath.'/'.$tablePerfix.$file))
					return page_textbd_copy_files_fail;
				
				if(!@chmod($dirpath.'/'.$tablePerfix.$file, 0777))	
					return page_textbd_set_permissions_fail;

			}
			closedir($dh);
		}
		
		UpdateConfigFile("", "", "", $databaseName, $tablePerfix, 0);
		return "";
	}		
}


?>