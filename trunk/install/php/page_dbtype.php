<?php
///////////////////////////////////////////////////////////////////
// ���������� ������ ���������� � ��� ����� ��� �� ������������ - mysql ��� ���������
//////////////////////////////////////////////////////////////////

class Page_dbtype
{
	// ���������� ���� ������� ������� �������� ��������	
	// $mainpage - ������ ������� ��������
	function doPage_dbtype(&$main_page_template)
	{	
		$main_page_template = str_replace("{title}", page_dbtype_title, $main_page_template);		
		// ��������� ������ 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page_dbtype.tpl"); 
		return $ret;		
	}	
}


?>