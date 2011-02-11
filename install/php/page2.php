<?php
///////////////////////////////////////////////////////////////////
// ���������� - ���� �������� ����� ����������� ������ ��������� 
// ���������� ������ ������ ���������� ������������ �� ��������������� ������  
//////////////////////////////////////////////////////////////////

class page2
{
	// ���������� ���� ������� ������� �������� ��������	
	// $mainpage - ������ ������� ��������
	function doPage2(&$main_page_template)
	{	
		// �� ������� ������� �������� �������� ��� {title}
		$main_page_template = str_replace("{title}", page2_title, $main_page_template);
		

		// ��������� ������ 
		$ret = file_get_contents("./skin/".INSTALL_SKIN."/templates/page2.tpl"); 
		
		if(isset($_GET['submit']))
		{
			// ������ �������� �����������, ���� ��� ���������� ��������� �������
			$l = $this->CheckDataBaseConnection($_POST['database_host'], $_POST['database_user'], $_POST['database_pass'], $_POST['database_name'], $message);
			
			if($l == false)	// ��������� ������ ����������� � ��
			{
				// �������� ����
				$this->FillDefault($ret, $message);
			}
			else
			{
				// ���� ������ ������ ��� �������
				$importQuery = $this->LoadImportDataBase($_POST['database_tableperfix']);
				
				$error = true; 
				$pieces  = $this->split_sql($importQuery);
				
				// ��������� ������ 	
				for ($i=0; $i<count($pieces); $i++)
				{
					$pieces[$i] = trim($pieces[$i]);
					if(!empty($pieces[$i]) && $pieces[$i] != "#")
					{
						if(mysql_query($pieces[$i]) == false)
							$error = false;	
						
					}
				}	// end for	
			
				// ��������� ��������� �� ��������� ���������������� �����
				UpdateConfigFile($_POST['database_host'], $_POST['database_user'], $_POST['database_pass'], $_POST['database_name'], $_POST['database_tableperfix']);				

				// ���� ���� ���������� ������ ������� 
				if($error == false)
				{
					$r = file_get_contents("./skin/".INSTALL_SKIN."/templates/page2_error.tpl");
					$r = str_replace("{export}", $importQuery, $r);
					return $r;
				}	
				else	
				{
					// ���� �� ������ �������� �� ������� ������ �������� �� ����. ����
					$r = file_get_contents("./skin/".INSTALL_SKIN."/templates/page2_done.tpl"); 
					return $r;
				}
			
				
			}	// end else
		}
		else
		{
			// ������ ������� ����������� �� ��������� ����
			$this->FillDefault($ret, "");
		}		

		return $ret;
	}	


	////////////////////////////////
	// ��������������� �������, ������ ��� ���������� ������������ ���������� �������
	function FillDefault(&$template, $message)
	{	
		// {message}
		$template = str_replace("{message}", $message, $template);
		
		// {database_host}
		if(isset($_POST['database_host']))
			$template = str_replace("{database_host}", $_POST['database_host'], $template);
		else
			$template = str_replace("{database_host}", "localhost:3306", $template);
		
		
		// {database_user}
		if(isset($_POST['database_user']))
			$template = str_replace("{database_user}", $_POST['database_user'], $template);
		else
			$template = str_replace("{database_user}", "", $template);
		

		// {database_pass}
		if(isset($_POST['database_pass']))
			$template = str_replace("{database_pass}", $_POST['database_pass'], $template);
		else
			$template = str_replace("{database_pass}", "", $template);	

		
		// {database_name}
		if(isset($_POST['database_name']))
			$template = str_replace("{database_name}", $_POST['database_name'], $template);
		else
			$template = str_replace("{database_name}", "", $template);			
		
		
		// {database_tableperfix}
		if(isset($_POST['database_tableperfix']))
			$template = str_replace("{database_tableperfix}", $_POST['database_tableperfix'], $template);
		else
			$template = str_replace("{database_tableperfix}", "xz_", $template);	
		
	}

	//////////////////////////////////////
	// ������� ������������� ����������� � ���� ������ 	
	// ���������� link ���������� ���� �������� ����������� ������ ������� ����� false
	// ���������� $error_result ������ ������
	public static function CheckDataBaseConnection($server, $username, $password, $databseName, &$error_result)
	{
		$link = @mysql_connect($server, $username, $password);
		
		if(!$link)
		{
			$error_result = page2_mysql_connect_error;
			return false;
		}
		
		// �������� ���� ������ 
		if(!@mysql_select_db($databseName, $link))
		{
			$error_result = page2_select_databese_error;
			return false;
		}
		
		// ������������� ��������� ���������
		@mysql_query("SET CHARACTER SET cp1251_koi8",$link);
		@mysql_query("set character_set_client='cp1251'",$link);
		@mysql_query("set character_set_results='cp1251'",$link);
 		@mysql_query("set collation_connection='cp1251_general_ci'",$link);
		
		return $link;

	}
	
	///////////////////////////////////////////////////////
	// ��������� ������������� �� � �������� �������
	function LoadImportDataBase($perfix)
	{
		$ret = file_get_contents("./data/sql.tpl");
		$ret = str_replace("{tableperfix}", $perfix, $ret);		

		return $ret;
	}
		
	///////////////////////////////////////////////////////
	// ������ ���� �������� �� ������� mysql ���������� ������ ���� ������
	function split_sql($sql)
	{
		$sql = trim($sql);
		$sql = ereg_replace("\n#[^\n]*\n", "\n", $sql);

		$buffer = array();
		$ret = array();
		$in_string = false;

		for($i=0; $i<strlen($sql)-1; $i++)
		{
			if($sql[$i] == ";" && !$in_string)
			{
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i + 1);
				$i = 0;
			}

			if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\")
			{
				$in_string = false;
			}
			elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\"))
			{
				$in_string = $sql[$i];
			}
			if(isset($buffer[1]))
			{
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		if(!empty($sql))
		{
			$ret[] = $sql;
		}
		return($ret);
	}	

}
?>