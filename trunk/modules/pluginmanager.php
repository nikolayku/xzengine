<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// менеджер плагинов

if(!defined("PLUGINS_DIR"))	define("PLUGINS_DIR" ,'./plugins/');

class PluginManager
{
	private static $instance;       //статическа€ переменна - экземпл€р объекта
	private static $tagPluginsList = array();	// список тэговых плагинов	

	/////////////////////////////
	// конструктор
	// в случае создани€ нескольких объЄктов	
	/////////////////////////////	
	private function __construct()
	{	
		// сканируем директорию с плагинами
		self::ScanTagsPluginsDirectory();
	}
	private function __clone() {}
   
	/////////////////////////////	
	// получение инстанс класса 
	/////////////////////////////
	public static function Instance()
	{
		if (self::$instance === null)
				self::$instance = new PluginManager();
		
		return self::$instance;
	}
	
	/////////////////////////////	
	// получение инстанс класса 
	/////////////////////////////
	private function ScanTagsPluginsDirectory()
	{
		$tagPluginsDir = PLUGINS_DIR.'tags/';
		$handle = opendir($tagPluginsDir); 
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..')
				continue;
			
			// скипаем svn
			if($file == '.svn')
				continue;
			
			$includePath = $tagPluginsDir.$file.'/'.$file.'.php';			
			require_once($includePath);
			
			// следующ€€ конструкци€ может оказатьс€ непон€тной, но средства PHP,
			// позвол€ют создавать новый класс из обычной строки.
			$className = 'plugin_'.$file;
			self::$tagPluginsList[] = new $className($tagPluginsDir.$file);			

		}
		closedir($handle);
	}
	
	/////////////////////////////	
	// проходит по всем зарегистрированным плагинам и вызывает их метод ModifyTemplate
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