<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

//FIXME: � ������� ���� ��� ����� ����� � ������ �� �������� ���������� ��������� �� �������

// ���� �� �������� �������� � ������������� ������������ ����� ������ ��� callback ������� ������ �� ������� , ������� ���������� 
// ������� �������. �� �� �������� �������-���� ��������� ��������� ���������
function ErrorCatchCallback($errno, $errstr, $errfile, $errline)
{
	BugReport::Instance()->ErrorOccured($errno, $errstr, $errfile, $errline);
}

// ����� ��� ��� ����������
// ���������� ��� �������� (http://ru.wikipedia.org/wiki/%d0%a1%d0%b8%d0%bd%d0%b3%d0%bb%d1%82%d0%be%d0%bd)
 class BugReport
{	
	private static $instance; //����������� ���������� - ��������� �������
	private $m_log;			  // ��������� ����
	private $m_oldErrorHandler;		// ������ ������� ������
	
	/////////////////////////////
	// �����������
	// � ������ �������� ���������� ��������
	/////////////////////////////	
	private function __construct() {}
	
	private function __clone() {}

	/////////////////////////////	
	// ��������� ������� ������ 
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
	// ���������� ������
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
	// ��������� ����� ������ � �������������� ����� �� ���� 
	/////////////////////////////	
	private function SetError($error)	
	{	
		$this->m_log .= $error;
	}
	
	/////////////////////////////	
	// ��������� ����� ������ � �������������� ����� �� ���� 
	/////////////////////////////	
	public function EnableErrorsLog()	
	{	
		// ������������� ������� ��� ���������� error ���������
		$m_oldErrorHandler = set_error_handler("ErrorCatchCallback", E_ALL);
		$m_log = "";
	}

	/////////////////////////////	
	// ���������� ��������� ����
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
