<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// ��� ������ � ��������� ��

require_once 'errorpage.php';

class TextDataBase
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
		$this->link = new Database(DATABASE_NAME);			
	}	
	
	//////////////////////////
	// ���������� ������������� ������
	/////////////////////////
	function get_row($query_result)
	{
		$res = $query_result->next();
		if(!$res)
			return false;
		
		$retrunArray = array();
		$columNames = $query_result->getColumnNames();
		
		foreach($columNames as $val)
			$retrunArray[$val] = $query_result->getCurrentValueByName($val);
		
		
		return 	$retrunArray;
	}
	
	//////////////////////////
	// �������� ���������� �����
	/////////////////////////
	function num_rows($query_result)
	{	
		return $query_result->getRowCount();
	}
	
	////////////////////////
	// ��������� ���������� � ��
	///////////////////////
	function close()
	{
		return null;
	}
		
	//////////////////////////
	// �������� ������ � ��
	/////////////////////////
	function query($query, $show_error=true)
	{	
		//$query = str_replace(";", "--", $query);		// ������������� �� SQL �������
		
		if($this->link === false) 
			$this->connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
				
		$result = $this->link->executeQuery($query);
		if(txtdbapi_error_occurred())
		{
			if($show_error)
			{
				$this->showerror($this->link->txtdbapi_get_last_error(), 0, $query);
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