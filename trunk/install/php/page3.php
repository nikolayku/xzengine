<?php
///////////////////////////////////////////////////////////////////
// назначение - файл содержит класс управляющий 3-й страницей 
// назначение класса выдать информацию пользователю об дополнительных настройках (имя администратора, пароль путь к форуму и сайту)
//////////////////////////////////////////////////////////////////

class page3
{
	// назначение этой функции сделать основные действия	
	// $mainpage - шаблон главной страницы
	function doPage3(&$main_page_template)
	{	
		// на шаблоне главной страницы заменяем тег {title}
		$main_page_template = str_replace("{title}", page3_title, $main_page_template);
		
		// загружаем шаблон 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page3.tpl"); 
		// {bodytext}
		$ret = str_replace("{bodytext}", page0_body_text, $ret);
		
		// 
		if(isset($_GET['submit']))
		{
			// форма заполнена 
			$adminName = $_POST['admin_name'];
			$adminPass = $_POST['admin_pass'];
			
			// проверяем если не введено имя администратора 
			if(strlen($adminName) == 0)
			{
				$this->SetDefaultTags($ret, page3_adminname_error);
			}
			elseif(strlen($adminPass) == 0)
			{	
				// проверяем если не введен пароль администратора
				$this->SetDefaultTags($ret, page3_adminpass_error);
			}
			else
			{
				// данные заполнены сохраняем их
				$this->UpdateConfigFile($_POST['site_path'],$_POST['forum_path']); 
				
				// загружаем ras файл
				$ras = file_get_contents(db_serialised_filename_path);
				$db = new dataBaseConfig();
				$db = unserialize($ras);
				
				if($db->databaseType)
					$this->UpateMysqlDatabase($_POST['admin_name'], $_POST['admin_pass']);
				else
					$this->UpateTextDatabase($_POST['admin_name'], $_POST['admin_pass']);	
				// копируем конфигурационный файл
				copy("./temp/config.php", "../config.php");	
			
				// загружаем шаблон 
				$r = file_get_contents("./skin/".INSTALL_SKIN."/templates/page3_finish.tpl");
				return $r;
			}	
					
		}
		else
			$this->SetDefaultTags($ret, "");
		

		return $ret;
	}

	/////////////////////////////////////////////////////////////
	// назначение заменяет основные теги
	function SetDefaultTags(&$template, $message)
	{	
		// {message}
		$template = str_replace("{message}", $message, $template);	

		// {admin_name}
		if(isset($_POST['admin_name']))
			$template = str_replace("{admin_name}", $_POST['admin_name'], $template);
		else
			$template = str_replace("{admin_name}", "", $template);
		
		// {admin_pass}
		if(isset($_POST['admin_pass']))
			$template = str_replace("{admin_pass}", $_POST['admin_pass'], $template);
		else
			$template = str_replace("{admin_pass}", "", $template);
		
		// {site_path}
		if(isset($_POST['site_path']))
			$template = str_replace("{site_path}", $_POST['site_path'], $template);
		else
		{	
			// получаем полный путь к исполняемому файлу
			$path =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
			// удаляем оттуда строку вида /install/install.php
			$path = str_replace("/install/install.php", "", $path);	
			// то что получилось считаем путём где расположены файлы CMS 
			$template = str_replace("{site_path}", $path, $template);
		}


		// {forum_path}
		if(isset($_POST['forum_path']))
			$template = str_replace("{forum_path}", $_POST['forum_path'], $template);
		else
			$template = str_replace("{forum_path}", "#", $template);
	} 
	
	////////////////////////////////////////////////////////
	// функция сохраняет настройки в конфигурационном файле
	// конфигурационный файл находится в директории temp и был скопирован туда на предыдущем шаге
	function UpdateConfigFile($sitePath, $forumPath)
	{	
		$configFilename = "./temp/config.php";
		// загружаем шаблон
		$r = file_get_contents($configFilename);
		
		// заменяем теги
		
		//{sitepath}
		$r = str_replace("{sitepath}", $sitePath, $r);
		//{forumpath}
		$r = str_replace("{forumpath}", $forumPath, $r);

		// сохраняем файл
		file_put_contents($configFilename, $r);
	}
	
	///////////////////////////////////////////////////////////
	// функция сохраняет имя пользователя и пароль в базе данных
	// настройки БД берутся из db.ras файла сформированного на этапе 2
	function UpateMysqlDatabase($adminName, $adminPass)
	{
		// загружаем ras файл
		$ras = file_get_contents(db_serialised_filename_path);
		$db = new dataBaseConfig();
		$db = unserialize($ras);
		
		// подключаемся к бд
		$l = page2::CheckDataBaseConnection($db->host, $db->user, $db->pass, $db->databseName, $error);
		if($l == false)
			return ;
		
		// 
		$q = "INSERT INTO ".$db->tablePerfix."users (users_login, users_password) VALUES ('".$adminName."', '".$adminPass."')";
		mysql_query($q, $l);
	}		
	
		///////////////////////////////////////////////////////////
	// функция сохраняет имя пользователя и пароль в базе данных
	// настройки БД берутся из db.ras файла сформированного на этапе 2
	function UpateTextDatabase($adminName, $adminPass)
	{	
		// загружаем ras файл
		$ras = file_get_contents(db_serialised_filename_path);
		$db = new dataBaseConfig();
		$db = unserialize($ras);
	
		
		$database = new Database($db->databseName);
		$q = "INSERT INTO ".$db->tablePerfix."users (users_login, users_password) VALUES ('".$adminName."', '".$adminPass."')";
		$database->executeQuery($q);
	}		
	
}
?>