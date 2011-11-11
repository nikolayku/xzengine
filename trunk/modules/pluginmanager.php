<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
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
	private function __construct($isAdminPanel)
	{	
		// ��������� ���������� � ���������
		self::ScanTagsPluginsDirectory($isAdminPanel);
	}
	private function __clone() {}
   
	/////////////////////////////	
	// ��������� ������� ������ 
	/////////////////////////////
	public static function Instance($isAdminPanel = false)
	{
		if (self::$instance === null)
				self::$instance = new PluginManager($isAdminPanel);
		
		return self::$instance;
	}
	
	/////////////////////////////	
	// ��������� ������� ������ 
	// $isAdminPanel - true ���� ������������� ��� ����� �����������
	/////////////////////////////
	private function ScanTagsPluginsDirectory($isAdminPanel)
	{	
		$tagPluginsDir = './plugins/tags/';
		if($isAdminPanel == true)
			$tagPluginsDir = '../plugins/tags/';
		
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
			
			// �������� �������
			$pluginInfo = array();
			$pluginInfo['class'] = new $className($tagPluginsDir.$file);				// ������ �������
			$pluginInfo['short'] = trim($pluginInfo['class']->GetShortDescription());	// �������� �������
			$pluginInfo['name'] = $file;												// �������� �������
			$pluginInfo['icon'] = '{skin_admin}/images/plugin.png';						// ������
			
			// ��������� ���� �� � ������� ���� ������
			$iconFile = $tagPluginsDir.$file.'/icon.png'; 
			if(is_file($iconFile))
				$pluginInfo['icon'] = '{sitepath}/plugins/tags/'.$file.'/icon.png';
			
			// ���������� ��������
			self::$tagPluginsList[] = $pluginInfo;			

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
			if($val['class']->isTagPresent($template))
				$val['class']->ModifyTemplate($template);	
		}
	}
	
	/////////////////////////////	
	// ���������� ���������� � ��������
	/////////////////////////////
	public function ViewPluginsList()
	{	
		// ��������� ������
		$listTemplate = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/pluginslist.tpl");
		$out = '';
		
		// ���� �� ���� ������������������ ��������
		foreach(self::$tagPluginsList as $val)
		{
			$temp = $listTemplate;
			$temp = str_replace("{plugin_icon}", $val['icon'], $temp);
			$temp = str_replace("{plugin_name}", $val['name'], $temp);
			$temp = str_replace("{plugin_short_descr}", $val['short'], $temp);
			
			$out .= $temp;
		}
		
		return $out;
	}
	
	/////////////////////////////	
	// ���������� true, ���� ������ � ����� ������ �����������, false � ��������� ������
	// $template - ������ ������� ��������
	/////////////////////////////
	public function isPluginRegister($pluginName)
	{	
		if($pluginName == "")
			return false;
		
		// ������ �� ���� ������������������ ��������
		foreach(self::$tagPluginsList as $val)
		{
			if($val['name'] == $pluginName)
				return true;
		}
		
		return false;
	}
	
	/////////////////////////////	
	// ��������� �������
	// $pluginName - ��� �������
	// $renderTemplate - ������ ������� �������� �����������
	/////////////////////////////
	public function runConfigurePlugin($pluginName, $renderTemplate)
	{	
		$out = "������ '".$pluginName."' �� ������";
		if($pluginName == "")
			return $out;
		
		// ������ �� ���� ������������������ ��������
		for($i = 0; i < count(self::$tagPluginsList); ++$i)
		{
			if(self::$tagPluginsList[$i]['name'] == $pluginName)
			{
				// ��������� ��������� �������
				return self::$tagPluginsList[$i]['class']->Admin($renderTemplate);
			}
		}
		
		return $out;
	}
}

?>
