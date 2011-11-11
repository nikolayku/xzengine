<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
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
	private function __construct($isAdminPanel)
	{	
		// сканируем директорию с плагинами
		self::ScanTagsPluginsDirectory($isAdminPanel);
	}
	private function __clone() {}
   
	/////////////////////////////	
	// получение инстанс класса 
	/////////////////////////////
	public static function Instance($isAdminPanel = false)
	{
		if (self::$instance === null)
				self::$instance = new PluginManager($isAdminPanel);
		
		return self::$instance;
	}
	
	/////////////////////////////	
	// получение инстанс класса 
	// $isAdminPanel - true если инициализаци€ идт через админпанель
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
			
			// скипаем svn
			if($file == '.svn')
				continue;
			
			$includePath = $tagPluginsDir.$file.'/'.$file.'.php';			
			require_once($includePath);
			
			// следующ€€ конструкци€ может оказатьс€ непон€тной, но средства PHP,
			// позвол€ют создавать новый класс из обычной строки.
			$className = 'plugin_'.$file;
			
			// описание плагина
			$pluginInfo = array();
			$pluginInfo['class'] = new $className($tagPluginsDir.$file);				// объект плагина
			$pluginInfo['short'] = trim($pluginInfo['class']->GetShortDescription());	// описание плагина
			$pluginInfo['name'] = $file;												// название плагина
			$pluginInfo['icon'] = '{skin_admin}/images/plugin.png';						// иконка
			
			// провер€ем есть ли у плагина сво€ иконка
			$iconFile = $tagPluginsDir.$file.'/icon.png'; 
			if(is_file($iconFile))
				$pluginInfo['icon'] = '{sitepath}/plugins/tags/'.$file.'/icon.png';
			
			// добавление описани€
			self::$tagPluginsList[] = $pluginInfo;			

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
			if($val['class']->isTagPresent($template))
				$val['class']->ModifyTemplate($template);	
		}
	}
	
	/////////////////////////////	
	// возвращ€ет информацию о плагинах
	/////////////////////////////
	public function ViewPluginsList()
	{	
		// загружаем шаблон
		$listTemplate = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/pluginslist.tpl");
		$out = '';
		
		// цикл по всем зарегистрированным плагинам
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
	// возвращ€ет true, если плагин с таким именем присуствует, false в противном случае
	// $template - шаблон главной страницы
	/////////////////////////////
	public function isPluginRegister($pluginName)
	{	
		if($pluginName == "")
			return false;
		
		// проход по всем зарегистрированным плагинам
		foreach(self::$tagPluginsList as $val)
		{
			if($val['name'] == $pluginName)
				return true;
		}
		
		return false;
	}
	
	/////////////////////////////	
	// настройки плагина
	// $pluginName - им€ плагина
	// $renderTemplate - шаблон главной страницы админпанели
	/////////////////////////////
	public function runConfigurePlugin($pluginName, $renderTemplate)
	{	
		$out = "ѕлагин '".$pluginName."' не найден";
		if($pluginName == "")
			return $out;
		
		// проход по всем зарегистрированным плагинам
		for($i = 0; i < count(self::$tagPluginsList); ++$i)
		{
			if(self::$tagPluginsList[$i]['name'] == $pluginName)
			{
				// запускаем настройки плагина
				return self::$tagPluginsList[$i]['class']->Admin($renderTemplate);
			}
		}
		
		return $out;
	}
}

?>
