<?php
///////////////////////////////////////////////////////////////////
// ���������� - ���� �������� ����� ����������� ������ ��������� 
// ���������� ������ ���������� � ��� �� ����� ����� ���� ���� ����� �� ������
//////////////////////////////////////////////////////////////////

class page1
{
	// ���������� ���� ������� ������� �������� ��������	
	// $mainpage - ������ ������� ��������
	function doPage1(&$main_page_template)
	{	

		$main_page_template = str_replace("{title}", page1_title, $main_page_template);		
	
		$page_tpl = file_get_contents("./skin/".INSTALL_SKIN."/templates/page1.tpl");
		$page_777y = file_get_contents("./skin/".INSTALL_SKIN."/templates/page1_777y.tpl");
		$page_777n = file_get_contents("./skin/".INSTALL_SKIN."/templates/page1_777n.tpl");
		
		// ��������� ������������ ���� 
		$out = "";	 		
		
		// ������ ���������� ������� ���� ���������
		$dirlist= array("upload","admin/backup", "install/temp", "skin");
		$filesdir = array("config.php");		

		$status = true;
		
		// �������� �� ���� ����������� 
		foreach($dirlist as $val)
		{	
			$if777 = ($this->GetDirAttr("../".$val) == "777");
						
			///////////////////////////////////////////////
			// ���� ����� �� ����� ����� 777 �� ���������� ���� ������
			if($if777 == true)
			{
				$temp = str_replace("{dirname}", $val, $page_777y);
				$out .= $temp;
			}						
			// ���� ��� �� ������
			else	
			{
				$temp = str_replace("{dirname}", $val, $page_777n);
				$out .= $temp;
			}
			///////////////////////////////////////////////
			
			$status = $status && $if777;

		}// end foreach($dirlist as $val)
		// �������� �� ������
		foreach($filesdir as $val)
		{	
			$if777 = ($this->GetFileAttr("../".$val) >= 666);
			
			//echo $v."<br>";			

			///////////////////////////////////////////////
			// ���� ����� �� ���� ����� 666 �� ���������� ���� ������
			if($if777 == true)
			{
				$temp = str_replace("{dirname}", $val, $page_777y);
				$out .= $temp;
			}						
			// ���� ��� �� ������
			else	
			{
				$temp = str_replace("{dirname}", $val, $page_777n);
				$out .= $temp;
			}
			///////////////////////////////////////////////
			
			$status = $status && $if777;

		}// end foreach($dirlist as $val)

		// {bodytext} �������� ��� �������			
		$page_tpl = str_replace("{bodytext}", $out, $page_tpl);
			
		// {next_or_refresh} - ��� �������� - ���� �� �� ��� ����� ���� ����������, ��� ������ �� ����. ��������			
		if($status == true)
			$page_tpl = str_replace("{next_or_refresh}", '<a href="./install.php?step=dbtype">'.page1_next.'</a>', $page_tpl);
		else
			$page_tpl = str_replace("{next_or_refresh}", '<a href="javascript:location.reload();">'.page1_refresh.'</a>', $page_tpl);
		
		return $page_tpl;
	}
	
	// �������������� ������� - ���������� �������� ���������� 
	function GetDirAttr($dir)
	{
		return (substr(sprintf('%o', @fileperms($dir)), -3));
	}
	
	// �������������� ������� - ���������� �������� ���������� 
	function GetFileAttr($dir)
	{
		return (int)(substr(sprintf('%o', @fileperms($dir)), -3));
	}	
		
}
?>