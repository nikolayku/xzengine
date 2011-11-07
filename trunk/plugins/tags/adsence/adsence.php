<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ¬страивание на страницу кода adsence от google

class plugin_adsence
{	
	private static $pluginsDir = 'banners'; 	
	private $tagsArray = array();

	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории с текущим плагином
	public function __construct($path)
	{
		$dirToScan = $path.'/'.self::$pluginsDir.'/';
		$handle = opendir($dirToScan);
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..')
				continue;
			$name = strtok($file, '.');
			// формируем массив
			$this->tagsArray[] = array('tag'=>'{'.$name.'}', 'value'=>file_get_contents($dirToScan.'/'.$file));
		}
		closedir($handle);
	}

	// возвращ€ет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		if(count($this->tagsArray) > 0)	
			return true;
		
		return false;
	}
	
	// делает нужные преобразовани€
	public function ModifyTemplate(&$template)
	{	
		foreach($this->tagsArray as $val)
		{
			$template = str_replace($val['tag'], $val['value'], $template);		
		}	
	}
	
	// позвращ€ет описание плагина - нужно дл€ админпанели 
	public function GetShortDescription()
	{
		return "установка adsence";
	}
	
	// функци€ настройки плагина из админпанели
	public function Admin()
	{
		return "плагин не поддерживает настройки";
	}
}

?>