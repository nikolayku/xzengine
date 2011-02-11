<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ����������� ��������� �� 

require_once 'mysqldb.php';
require_once 'textdb.php';

class AbstractDataBase
{
	private static $link = null;    // ���� � ���� - ������� �����, ��� ��� ��� ��������� ����� ����������
	private static $instance;        //����������� ��������� - ��������� �������
	
  /////////////////////////////
	// �����������
	// � ������ �������� ���������� ��������� � �� 		
	/////////////////////////////	
	private function __construct() {}
	private function __clone() {}
  
  /////////////////////////////	
	// ��������� ������� ������ 
	/////////////////////////////
	private static function CreateInstance()
	{
		if(self::$link === null)
		{	
			if(DATABASE_USEMYSQL)
				self::$link = new MySQLDataBase();
			else
				self::$link = new TextDataBase();
			      
		}
    }
  
  /////////////////////////////	
	// ��������� ������� ������ 
	/////////////////////////////
	public static function Instance()
	{
		if (self::$instance === null)
				self::$instance = new AbstractDataBase();
		
		self::CreateInstance();	
		return self::$instance;
	}
	
	/////////////////////////////
	// ��������� ���������� �������� � ��
	//////////////////////////////
	function zero_number_of_queries()
	{  
    	self::$link->zero_number_of_queries();
	}	

	////////////////////////////
	// ��������� ���������� �������� � ��
	////////////////////////////
	function get_number_of_queries()
	{
		return self::$link->get_number_of_queries();
	}		
	
	/////////////////////////////
	// connect to databese
	////////////////////////////
	function connect($server, $username, $password, $databseName, $showerror=true)			
	{	
		self::$link->connect($server, $username, $password, $databseName, $showerror);		
	}	
	
	//////////////////////////
	// ���������� ������������� ������
	/////////////////////////
	function get_row($query_result)
	{
		return self::$link->get_row($query_result);
	}
	
	//////////////////////////
	// �������� ���������� �����
	/////////////////////////
	function num_rows($query_result)
	{ 
		return self::$link->num_rows($query_result);
	}
	
	////////////////////////
	// ��������� ���������� � ��
	///////////////////////
	function close()
	{  
		self::$link->close();
	}
	
		
	//////////////////////////
	// �������� ������ � ��
	/////////////////////////
	function query($query, $show_error=true)
	{	
		return self::$link->query($query, $show_error);
	}

	
	//////////////////////////
	// show error
	/////////////////////////
	function showerror($error, $errorNo, $query = "")
	{  
		self::$link->showerror($error, $errorNo, $query);
	}		
}

?>