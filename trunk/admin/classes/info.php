<?php
/////////////////////////////////////////////////////
// ��������� ���������� � �������
////////////////////////////////////////////////////

class systemInfo
{	
	////////////////////////////////////
	// �����������
	////////////////////////////////////
	function __construct()
	{
	}		
	
	////////////////////////////////////
	// �������� ���������� �� ����� feedback ����������
	// �������� ��� {feedbackmessages}
	////////////////////////////////////
	function GetFeedBackMessages(&$template)
	{	
		$fb = new FeedBack();
		
		// ��������
		$template = str_replace("{feedbackmessages}", $fb->GetFeedbackMessageCount(), $template);
			
	}	
		

	////////////////////////////////////
	// �������� ������ ���� ������
	// �������� ��� {databasesize}
	////////////////////////////////////
	function GetDataBaseSize(&$template)
	{	
		// ��������� ������ ��	
		$total = 0;
		if(DATABASE_USEMYSQL)
		{
			$r = AbstractDataBase::Instance()->query('SHOW TABLE STATUS FROM '.DATABASE_NAME);
			while($array = AbstractDataBase::Instance()->get_row($r))
				$total += $array[Data_length]+$array[Index_length];
		}
		// ��������
		$template = str_replace("{databasesize}", ConvertBytes($total), $template);
			
	}	

	////////////////////////////////////
	// �������� ��������� �����
	// �������� ��� {sitestate}
	////////////////////////////////////
	function GetSiteState(&$template)
	{	
		$st = '';	
		if(OFF_SITE)
			$st = '<b>���� ��������</b>';
		else
			$st = '���� �������';

		$template = str_replace("{sitestate}", $st, $template);
	}
		
	
	////////////////////////////////////
	// �������� ������ PHP
	// �������� ��� {phpversion}
	////////////////////////////////////
	function GetPhpVersion(&$template)
	{
		$template = str_replace("{phpversions}", phpversion(), $template);
	}

	///////////////////////////////////
	// �������� ������ Mysql
	// �������� ��� {mysqlversion}
	///////////////////////////////////
	function GetMysqlVersion(&$template)
	{
		
		$template = str_replace("{mysqlversion}", @mysql_get_server_info(), $template);
		
	}

	///////////////////////////////////
	// �������� ��������� ����� � ������
	// �������� ��� {diskfreespace}
	//////////////////////////////////
	function GetDiskFreeSpace(&$template, $dir = '../')
	{
		$df = disk_free_space("/");
		$template = str_replace("{diskfreespace}", ConvertBytes($df), $template);		
	}
	
	///////////////////////////////////
	// �������� ������ ����� � ������������ �� ������ �������
	// �������� ��� {uplodeddirsize}
	//////////////////////////////////
	function GetUplodedDirSize(&$template)
	{
		$df = GetDirectorySize('../'.UPLOADFILE_DIRECTORY);
		$template = str_replace("{uplodeddirsize}", ConvertBytes($df), $template);		
	}	
		
	///////////////////////////////////
	// �������� ����� ����� � ������
	// �������� ��� {disktotalspace}
	//////////////////////////////////
	function GetDiskTotalSpace(&$template, $dir = '../')
	{
		$df = disk_total_space("/");	
		$template = str_replace("{disktotalspace}", ConvertBytes($df), $template);
		
	}

	//////////////////////////////////
	// �������� ����� ���������� �������� ��������� ��������
	// �������� ��� {notapprovednews}
	//////////////////////////////////
	function GetNotApprovedNews(&$template)
	{	
		$res = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_approve = 0');	
		$template = str_replace("{notapprovednews}", AbstractDataBase::Instance()->num_rows($res), $template);
	}

	/////////////////////////////////
	// �������� ����� ���������� �������� ���������� � ��
	// �������� ��� {totalnews}
	////////////////////////////////
	function GetTotalNews(&$template)
	{	
		$res = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news');	
		$template = str_replace("{totalnews}", AbstractDataBase::Instance()->num_rows($res), $template);
	}
		
	///////////////////////////////
	// ��������� ������ �������� ��� ����
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