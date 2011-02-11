<?php
///////////////////////////////////////////////////////////////////
// назначение - файл содержит класс управляющий первой страницей 
// назначение класса выдать информацию пользователю об устанавливаемой версии  
//////////////////////////////////////////////////////////////////

class page0
{
	// назначение этой функции сделать основные действия	
	// $mainpage - шаблон главной страницы
	function doPage0(&$main_page_template)
	{	
		// на шаблоне главной страницы заменяем тег {title}
		$main_page_template = str_replace("{title}", page0_title, $main_page_template);
		
		// загружаем шаблон 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page0.tpl"); 
		// {bodytext}
		$ret = str_replace("{bodytext}", page0_body_text, $ret);			
		return $ret;
	}	
}
?>