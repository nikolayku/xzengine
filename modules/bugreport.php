<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

//FIXME: в будущем этот код будет удалЄн и заменЄн на включене выключение сообщени€ об ошибках

// пока не решенные проблемы с установлением статического члена класса как callback функции отчЄта об ошибках , поэтому используем 
// внешнюю функцию. из неЄ вызываем функцию-член синглтона обработки сообщений
function ErrorCatchCallback($errno, $errstr, $errfile, $errline)
{
	BugReport::Instance()->ErrorOccured($errno, $errstr, $errfile, $errline);
}

// класс дл€ баг репортинга
// реализован как синглтон (http://ru.wikipedia.org/wiki/%d0%a1%d0%b8%d0%bd%d0%b3%d0%bb%d1%82%d0%be%d0%bd)
 class BugReport
{	
	private static $instance; //статическа€ переменна€ - экземпл€р объекта
	private $m_log;			  // состо€ние лога
	private $m_oldErrorHandler;		// старый хэндлер ошибок
	
	/////////////////////////////
	// конструктор
	// в случае создани€ нескольких объектов
	/////////////////////////////	
	private function __construct() {}
	
	private function __clone() {}

	/////////////////////////////	
	// получение инстанс класса 
	/////////////////////////////
	public static function Instance()
	{
		if (self::$instance === null)
		{	
			self::$instance = new BugReport();
		}
		return self::$instance;
	}
	
	/////////////////////////////
	// обработчик ошибок
	/////////////////////////////
	public static function ErrorOccured($errno, $errstr, $errfile, $errline)	
	{	
		$errorType = "";	
		switch ( $errno )
		{	
			case E_USER_NOTICE:
				$errorType = 'E_USER_NOTICE';
				break;
			case E_WARNING:
				$errorType = 'E_WARNING';
				break;
			case E_USER_WARNING:
				$errorType = 'E_USER_WARNING';
				break;
			case E_NOTICE:
				$errorType = 'E_NOTICE';
				break;
			case E_USER_ERROR:
				$errorType = 'E_USER_ERROR';
				break;
			default:
				return;
		}		
		
		$errolLine = $errorType.'--'.$errno.': "'.$errstr.'" in "'.$errfile.'" at line:'.$errline."\n";
		BugReport::Instance()->SetError($errolLine);
		
	}
	
	/////////////////////////////	
	// отключает вывод ошибок и переобозначает вывод на себ€ 
	/////////////////////////////	
	private function SetError($error)	
	{	
		$this->m_log .= $error;
	}
	
	/////////////////////////////	
	// отключает вывод ошибок и переобозначает вывод на себ€ 
	/////////////////////////////	
	public function EnableErrorsLog()	
	{	
		// устанавливаем функцию как обработчик error сообщений
		$m_oldErrorHandler = set_error_handler("ErrorCatchCallback", E_ALL);
		$m_log = "";
	}

	/////////////////////////////	
	// возвращ€ет состо€ние лога
	/////////////////////////////	
	public function Flush()
	{	
		$returnLog = $m_log;
		$m_log = '';
		restore_error_handler();
		return $returnLog;
	}
};	// end class BugReport




?>
