<?php
///////////////////////////////////////////////////////////////////
// ���������� - ���� �������� ����� ����������� ������ ��������� 
// ���������� ������ ������ ���������� ������������ �� ��������������� ������  
//////////////////////////////////////////////////////////////////

class page0
{
	// ���������� ���� ������� ������� �������� ��������	
	// $mainpage - ������ ������� ��������
	function doPage0(&$main_page_template)
	{	
		// �� ������� ������� �������� �������� ��� {title}
		$main_page_template = str_replace("{title}", page0_title, $main_page_template);
		
		// ��������� ������ 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page0.tpl"); 
		// {bodytext}
		$ret = str_replace("{bodytext}", page0_body_text, $ret);			
		return $ret;
	}	
}
?>