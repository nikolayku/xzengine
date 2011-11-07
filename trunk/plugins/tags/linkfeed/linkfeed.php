<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ������ ��� ������ � �������� ����� ������� ������
// ��������� � ������� ����� ������� ������ ����� ��������� ��� http://www.linkfeed.ru/reg/2010
// ���������� ��� {linkfeed_plugin} ��� ������� ������ 

class plugin_linkfeed
{	
	private static $configFile = 'plugin_config.php'; 
	private static $oneTag = '{linkfeed_plugin}'; 
	private static $linkfeedClient = null; 
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� � ������� ��������
	public function __construct($path)
	{	
		require_once($path.'/'.self::$configFile);
		define('LINKFEED_USER', LINKFEED_PLUGIN_USER_ID);
		$path = './'.LINKFEED_USER.'/linkfeed.php';
		
		if(is_file($path))
		{
			require_once($path); 
			self::$linkfeedClient = new LinkfeedClient();	
		}
			
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		if(self::$linkfeedClient === null)
			return false;

		return true;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		$template = str_replace(self::$oneTag, self::$linkfeedClient->return_links(), $template);
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "������ ��� ������� linkfeed";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{
		return "������ �� ������������ ���������";
	}
}

?>