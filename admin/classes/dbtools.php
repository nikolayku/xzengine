<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// класс для работы с базой данных

class dbtools
{	
	function __construct()
	{
	}		
	
	//////////////////////////////////////////
	// ремонт БД
	// возвращяет сообщение об результате работы
	//////////////////////////////////////////
	function repair()
	{	
		if(!DATABASE_USEMYSQL)
			return 'Текущяя БД не поддерживает эту операцию';
		// получаем список таблиц бд
		$tables = ''; 
		$result = AbstractDataBase::Instance()->query("SHOW TABLES");
		while($row = AbstractDataBase::Instance()->get_row($result))
		{
			$tables  = $tables.' '.$row[0].',';
		}
		// удаляем последнюю запятую
		$tables  = substr($tables, 0, strlen($tables) - 1); 	
		
		AbstractDataBase::Instance()->query('REPAIR TABLE '.$tables);
		return 'Ремонт всех таблиц базы данных произведён';
	}
		
	

	//////////////////////////////////////////
	// оптимизация БД
	// возвращяет сообщение об результате работы
	//////////////////////////////////////////
	function optimize()
	{	
		if(!DATABASE_USEMYSQL)
			return 'Текущяя БД не поддерживает эту операцию';

		// получаем список таблиц бд
		$tables = ''; 
		$result = AbstractDataBase::Instance()->query("SHOW TABLES");
		while($row = AbstractDataBase::Instance()->get_row($result))
		{
			$tables  = $tables.' '.$row[0].',';
		}
		// удаляем последнюю запятую
		$tables  = substr($tables, 0, strlen($tables) - 1); 	

		AbstractDataBase::Instance()->query('OPTIMIZE TABLE '.$tables);
		
		return 'Оптимизация всех таблиц базы данных проведена';
	}
	
	
	//////////////////////////////////////////
	// функция загружает шаблон dbtools.tpl, заменяет теги
	////////////////////////////////////////// 	

	function LoadTemplate(&$main_page_template, $message)
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/dbtools.tpl");
		
		// заменяем тег {javascript_admin} в меню главного шаблона
		$JavaScript = 
'<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>';
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);
		
		// {message}	
		$render_str = str_replace("{message}", $message, $render_str);
		
		// получаем список файлов 
		$filelist = '';
		$dh = opendir('backup');
		while (($file = readdir($dh)) !== false) 
		{
			if ($file != "." && $file != ".." && $file != 'index.php') 
			{
				 $filelist = $filelist.'<option value="'.$file.'">'.$file.'</option>';
			}	
		}		
		// {restorefiles}	
		$render_str = str_replace("{restorefiles}", $filelist, $render_str);
		
		return 	$render_str;
		
	}		
};

?>