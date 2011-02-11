<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// ��� ������ � ����� ������ (MySQL)

require_once 'errorpage.php';


class MySQLDataBase
{
	private $link = false;    // 
	static private $db_queries;
	/////////////////////////////
	// ��������� ���������� �������� � ��
	//////////////////////////////
	function zero_number_of_queries()
	{
		self::$db_queries = 0;
	}	

	////////////////////////////
	// ��������� ���������� �������� � ��
	////////////////////////////
	function get_number_of_queries()
	{
		return self::$db_queries;
	}		
	
	/////////////////////////////
	// connect to databese
	////////////////////////////
	function connect($server, $username, $password, $databseName, $showerror=true)			
	{	
		
		if(!($this->link = @mysql_connect($server, $username, $password)))
		{	
			if($showerror)
			{
				$this->showerror(mysql_error(), mysql_errno());
				die();
			}
			
		}
		
		if(!@mysql_select_db($databseName, $this->link))
		{
			if($showerror)
			{
				$this->showerror(mysql_error(), mysql_errno());
				die();
			}
			return false;
		}
		
		// �������� ���������
		mysql_query("SET CHARACTER SET cp1251_koi8",$this->link);
		mysql_query("set character_set_client='cp1251'",$this->link);
		mysql_query("set character_set_results='cp1251'",$this->link);
 		mysql_query("set collation_connection='cp1251_general_ci'",$this->link);
		
		self::$db_queries +=4;
				
	}	
	
	//////////////////////////
	// ���������� ������������� ������
	/////////////////////////
	function get_row($query_result)
	{	
		//self::$db_queries +=1;
		return @mysql_fetch_assoc($query_result);
	}
	
	//////////////////////////
	// �������� ���������� �����
	/////////////////////////
	function num_rows($query_result)
	{	
		//self::$db_queries +=1; 
		return @mysql_num_rows($query_result);
	}
	
	////////////////////////
	// ��������� ���������� � ��
	///////////////////////
	function close()
	{
		@mysql_close($this->link);
	}
	
		
	//////////////////////////
	// �������� ������ � ��
	/////////////////////////
	function query($query, $show_error=true)
	{	
		//$query = str_replace(";", "--", $query);		// ������������� �� SQL �������
		
		if($this->link === false) 
			$this->connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
				
		if(!($result = @mysql_query($query, $this->link)))
		{
			if($show_error)
			{
				$this->showerror(mysql_error(), mysql_errno(), $query);
				die();
			}
		}
		
		self::$db_queries +=1;

		return $result;
	}

	
	//////////////////////////
	// show error
	/////////////////////////
	function showerror($error, $errorNo, $query = "")
	{
		$page = new errorpage();
		$page->errorwindow($errorNo, $error);	
		
	}
		
}

?>