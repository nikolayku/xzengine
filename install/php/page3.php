<?php
///////////////////////////////////////////////////////////////////
// ���������� - ���� �������� ����� ����������� 3-� ��������� 
// ���������� ������ ������ ���������� ������������ �� �������������� ���������� (��� ��������������, ������ ���� � ������ � �����)
//////////////////////////////////////////////////////////////////

class page3
{
	// ���������� ���� ������� ������� �������� ��������	
	// $mainpage - ������ ������� ��������
	function doPage3(&$main_page_template)
	{	
		// �� ������� ������� �������� �������� ��� {title}
		$main_page_template = str_replace("{title}", page3_title, $main_page_template);
		
		// ��������� ������ 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page3.tpl"); 
		// {bodytext}
		$ret = str_replace("{bodytext}", page0_body_text, $ret);
		
		// 
		if(isset($_GET['submit']))
		{
			// ����� ��������� 
			$adminName = $_POST['admin_name'];
			$adminPass = $_POST['admin_pass'];
			
			// ��������� ���� �� ������� ��� �������������� 
			if(strlen($adminName) == 0)
			{
				$this->SetDefaultTags($ret, page3_adminname_error);
			}
			elseif(strlen($adminPass) == 0)
			{	
				// ��������� ���� �� ������ ������ ��������������
				$this->SetDefaultTags($ret, page3_adminpass_error);
			}
			else
			{
				// ������ ��������� ��������� ��
				$this->UpdateConfigFile($_POST['site_path'],$_POST['forum_path']); 
				
				// ��������� ras ����
				$ras = file_get_contents(db_serialised_filename_path);
				$db = new dataBaseConfig();
				$db = unserialize($ras);
				
				if($db->databaseType)
					$this->UpateMysqlDatabase($_POST['admin_name'], $_POST['admin_pass']);
				else
					$this->UpateTextDatabase($_POST['admin_name'], $_POST['admin_pass']);	
				// �������� ���������������� ����
				copy("./temp/config.php", "../config.php");	
			
				// ��������� ������ 
				$r = file_get_contents("./skin/".INSTALL_SKIN."/templates/page3_finish.tpl");
				return $r;
			}	
					
		}
		else
			$this->SetDefaultTags($ret, "");
		

		return $ret;
	}

	/////////////////////////////////////////////////////////////
	// ���������� �������� �������� ����
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
			// �������� ������ ���� � ������������ �����
			$path =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
			// ������� ������ ������ ���� /install/install.php
			$path = str_replace("/install/install.php", "", $path);	
			// �� ��� ���������� ������� ���� ��� ����������� ����� CMS 
			$template = str_replace("{site_path}", $path, $template);
		}


		// {forum_path}
		if(isset($_POST['forum_path']))
			$template = str_replace("{forum_path}", $_POST['forum_path'], $template);
		else
			$template = str_replace("{forum_path}", "#", $template);
	} 
	
	////////////////////////////////////////////////////////
	// ������� ��������� ��������� � ���������������� �����
	// ���������������� ���� ��������� � ���������� temp � ��� ���������� ���� �� ���������� ����
	function UpdateConfigFile($sitePath, $forumPath)
	{	
		$configFilename = "./temp/config.php";
		// ��������� ������
		$r = file_get_contents($configFilename);
		
		// �������� ����
		
		//{sitepath}
		$r = str_replace("{sitepath}", $sitePath, $r);
		//{forumpath}
		$r = str_replace("{forumpath}", $forumPath, $r);

		// ��������� ����
		file_put_contents($configFilename, $r);
	}
	
	///////////////////////////////////////////////////////////
	// ������� ��������� ��� ������������ � ������ � ���� ������
	// ��������� �� ������� �� db.ras ����� ��������������� �� ����� 2
	function UpateMysqlDatabase($adminName, $adminPass)
	{
		// ��������� ras ����
		$ras = file_get_contents(db_serialised_filename_path);
		$db = new dataBaseConfig();
		$db = unserialize($ras);
		
		// ������������ � ��
		$l = page2::CheckDataBaseConnection($db->host, $db->user, $db->pass, $db->databseName, $error);
		if($l == false)
			return ;
		
		// 
		$q = "INSERT INTO ".$db->tablePerfix."users (users_login, users_password) VALUES ('".$adminName."', '".$adminPass."')";
		mysql_query($q, $l);
	}		
	
		///////////////////////////////////////////////////////////
	// ������� ��������� ��� ������������ � ������ � ���� ������
	// ��������� �� ������� �� db.ras ����� ��������������� �� ����� 2
	function UpateTextDatabase($adminName, $adminPass)
	{	
		// ��������� ras ����
		$ras = file_get_contents(db_serialised_filename_path);
		$db = new dataBaseConfig();
		$db = unserialize($ras);
	
		
		$database = new Database($db->databseName);
		$q = "INSERT INTO ".$db->tablePerfix."users (users_login, users_password) VALUES ('".$adminName."', '".$adminPass."')";
		$database->executeQuery($q);
	}		
	
}
?>