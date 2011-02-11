<?php
///////////////////////////////////////////////////////////////////
// назначение выдать информацию о том какой тип бд использовать - mysql или текстовую
//////////////////////////////////////////////////////////////////

class Page_dbtype
{
	// назначение этой функции сделать основные действия	
	// $mainpage - шаблон главной страницы
	function doPage_dbtype(&$main_page_template)
	{	
		$main_page_template = str_replace("{title}", page_dbtype_title, $main_page_template);		
		// загружаем шаблон 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page_dbtype.tpl"); 
		return $ret;		
	}	
}


?>