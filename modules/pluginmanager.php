<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// �������� ��������

if(!defined("PLUGINS_DIR"))	define("PLUGINS_DIR" ,'./plugins/');

class PluginManager
{
	private static $instance;       //����������� ��������� - ��������� �������
	private static $tagPluginsList = array();	// ������ ������� ��������	

	/////////////////////////////
	// �����������
	// � ������ �������� ���������� ��������	
	/////////////////////////////	
	private function __construct()
	{	
		// ��������� ���������� � ���������
		self::ScanTagsPluginsDirectory();
	}
	private function __clone() {}
   
	/////////////////////////////	
	// ��������� ������� ������ 
	/////////////////////////////
	public static function Instance()
	{
		if (self::$instance === null)
				self::$instance = new PluginManager();
		
		return self::$instance;
	}
	
	/////////////////////////////	
	// ��������� ������� ������ 
	/////////////////////////////
	private function ScanTagsPluginsDirectory()
	{
		$tagPluginsDir = PLUGINS_DIR.'tags/';
		$handle = opendir($tagPluginsDir); 
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..')
				continue;
			
			// ������� svn
			if($file == '.svn')
				continue;
			
			$includePath = $tagPluginsDir.$file.'/'.$file.'.php';			
			require_once($includePath);
			
			// ��������� ����������� ����� ��������� ����������, �� �������� PHP,
			// ��������� ��������� ����� ����� �� ������� ������.
			$className = 'plugin_'.$file;
			self::$tagPluginsList[] = new $className($tagPluginsDir.$file);			

		}
		closedir($handle);
	}
	
	/////////////////////////////	
	// �������� �� ���� ������������������ �������� � �������� �� ����� ModifyTemplate
	/////////////////////////////
	public function ApplyTagPlugins(&$template)
	{	
		foreach(self::$tagPluginsList as $val)
		{
			if($val->isTagPresent($template))
				$val->ModifyTemplate($template);	
		}
	}

	
}


?>