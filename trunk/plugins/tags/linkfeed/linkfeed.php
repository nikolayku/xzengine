<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// плагин дл€ работы с системой купли продажи ссылок
// подробнее о системе купли продажи ссылок можно прочитать тут http://www.linkfeed.ru/reg/2010
// »спользует тег {linkfeed_plugin} дл€ вставки ссылок 

class plugin_linkfeed
{	
	private static $configFile = 'plugin_config.php'; 
	private static $oneTag = '{linkfeed_plugin}'; 
	private static $linkfeedClient = null; 
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории с текущим плагином
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

	// возвращ€ет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		if(self::$linkfeedClient === null)
			return false;

		return true;
	}
	
	// делает нужные преобразовани€
	public function ModifyTemplate(&$template)
	{	
		$template = str_replace(self::$oneTag, self::$linkfeedClient->return_links(), $template);
	}
	
	// позвращ€ет описание плагина - нужно дл€ админпанели 
	public function GetShortDescription()
	{
		return "ѕлагин дл€ системы linkfeed";
	}
	
	// функци€ настройки плагина из админпанели
	public function Admin()
	{
		return "плагин не поддерживает настройки";
	}
}

?>