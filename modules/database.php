<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// Абстрактный интерфейс бд 

require_once 'mysqldb.php';
require_once 'textdb.php';

class AbstractDataBase
{
	private static $link = null;    // линк к базе - неважно какой, так как они испоьзуют общие интерфейсы
	private static $instance;        //статическая переменна - экземпляр объекта
	
  /////////////////////////////
	// конструктор
	// в случае создания нескольких коннектов к бд 		
	/////////////////////////////	
	private function __construct() {}
	private function __clone() {}
  
  /////////////////////////////	
	// получение инстанс класса 
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
	// получение инстанс класса 
	/////////////////////////////
	public static function Instance()
	{
		if (self::$instance === null)
				self::$instance = new AbstractDataBase();
		
		self::CreateInstance();	
		return self::$instance;
	}
	
	/////////////////////////////
	// обнуление количества запросов к бд
	//////////////////////////////
	function zero_number_of_queries()
	{  
    	self::$link->zero_number_of_queries();
	}	

	////////////////////////////
	// получение количества запросов к бд
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
	// возвращяем ассоциативный массив
	/////////////////////////
	function get_row($query_result)
	{
		return self::$link->get_row($query_result);
	}
	
	//////////////////////////
	// получает количество рядов
	/////////////////////////
	function num_rows($query_result)
	{ 
		return self::$link->num_rows($query_result);
	}
	
	////////////////////////
	// закрывает соединение с БД
	///////////////////////
	function close()
	{  
		self::$link->close();
	}
	
		
	//////////////////////////
	// посылает запрос к БД
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