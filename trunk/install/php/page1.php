<?php
///////////////////////////////////////////////////////////////////
// назначение - файл содержит класс управл€ющий второй страницей 
// назначение выдать информацию о том на какие папки надо дать права на запись
//////////////////////////////////////////////////////////////////

class page1
{
	// назначение этой функции сделать основные действи€	
	// $mainpage - шаблон главной страницы
	function doPage1(&$main_page_template)
	{	

		$main_page_template = str_replace("{title}", page1_title, $main_page_template);		
	
		$page_tpl = file_get_contents("./skin/".INSTALL_SKIN."/templates/page1.tpl");
		$page_777y = file_get_contents("./skin/".INSTALL_SKIN."/templates/page1_777y.tpl");
		$page_777n = file_get_contents("./skin/".INSTALL_SKIN."/templates/page1_777n.tpl");
		
		// результат записываетс€ сюда 
		$out = "";	 		
		
		// список директорий которые надо проверить
		$dirlist= array("upload","admin/backup", "install/temp", "skin");
		$filesdir = array("config.php");		

		$status = true;
		
		// проходим по всем директори€м 
		foreach($dirlist as $val)
		{	
			$if777 = ($this->GetDirAttr("../".$val) == "777");
						
			///////////////////////////////////////////////
			// если права на папку сто€т 777 то показываем один шаблон
			if($if777 == true)
			{
				$temp = str_replace("{dirname}", $val, $page_777y);
				$out .= $temp;
			}						
			// если нет то другой
			else	
			{
				$temp = str_replace("{dirname}", $val, $page_777n);
				$out .= $temp;
			}
			///////////////////////////////////////////////
			
			$status = $status && $if777;

		}// end foreach($dirlist as $val)
		// проходим по файлам
		foreach($filesdir as $val)
		{	
			$if777 = ($this->GetFileAttr("../".$val) >= 666);
			
			//echo $v."<br>";			

			///////////////////////////////////////////////
			// если права на файл сто€т 666 то показываем один шаблон
			if($if777 == true)
			{
				$temp = str_replace("{dirname}", $val, $page_777y);
				$out .= $temp;
			}						
			// если нет то другой
			else	
			{
				$temp = str_replace("{dirname}", $val, $page_777n);
				$out .= $temp;
			}
			///////////////////////////////////////////////
			
			$status = $status && $if777;

		}// end foreach($dirlist as $val)

		// {bodytext} основной тег шаблона			
		$page_tpl = str_replace("{bodytext}", $out, $page_tpl);
			
		// {next_or_refresh} - или обновить - если не на все папки даны разрешени€, или ссылка на след. страницу			
		if($status == true)
			$page_tpl = str_replace("{next_or_refresh}", '<a href="./install.php?step=dbtype">'.page1_next.'</a>', $page_tpl);
		else
			$page_tpl = str_replace("{next_or_refresh}", '<a href="javascript:location.reload();">'.page1_refresh.'</a>', $page_tpl);
		
		return $page_tpl;
	}
	
	// вспомогательн€ функци€ - возвращ€ет атрибуты директории 
	function GetDirAttr($dir)
	{
		return (substr(sprintf('%o', @fileperms($dir)), -3));
	}
	
	// вспомогательн€ функци€ - возвращ€ет атрибуты директории 
	function GetFileAttr($dir)
	{
		return (int)(substr(sprintf('%o', @fileperms($dir)), -3));
	}	
		
}
?>