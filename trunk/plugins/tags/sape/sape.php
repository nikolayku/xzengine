<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ������ ��� ������ � �������� ����� ������� ������
// ��������� � ������� ����� ������� ������ ����� ��������� ��� http://www.sape.ru/r.0bf14ccf4b.php
// ���������� ��� {sape_plugin} ��� ������� ������ 

class plugin_sape
{	
	private static $configFile = 'plugin_config.php'; 
	private static $oneTag = '{sape_plugin}'; 
	private static $sapeClient = null; 
	private static $sapeContent = null; 
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� � ������� ��������
	public function __construct($path)
	{	
		require_once($path.'/'.self::$configFile);
		if (!defined('_SAPE_USER'))
			define('_SAPE_USER', SAPE_PLUGIN_USER_ID);
		
		$pathToSape_php = './'._SAPE_USER.'/sape.php';
		
		if(is_file($pathToSape_php))
		{
			require_once($pathToSape_php); 
			self::$sapeClient = new SAPE_client();
			self::$sapeContent = new SAPE_context();	
		}
			
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		if(self::$sapeClient === null)
			return false;

		return true;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		$template = str_replace(self::$oneTag, self::$sapeClient->return_links(), $template);
		$template = self::$sapeContent->replace_in_text_segment($template);
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "��������� ���� ������� ����� ������� ������ sape.ru";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{
		return "������ �� ������������ ���������";
	}
	
	// ��������� �������� �� �����
	// $mainpageTemplate - ������� ��������
	public function Render($mainpageTemplate)
	{
		// ���� ������ �� ������������ ��������� �������� �� �� ������ ������� 404 ������, ��� ���������� � ����� ������ ������������
		header("HTTP/1.0 404 Not Found");
		exit();
	}
}

?>