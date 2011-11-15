<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// плагин дл€ работы с системой купли продажи ссылок
// подробнее о системе купли продажи ссылок можно прочитать тут http://www.sape.ru/r.0bf14ccf4b.php
// »спользует тег {sape_plugin} дл€ вставки ссылок 

class plugin_sape
{	
	private static $configFile = 'plugin_config.php'; 
	private static $oneTag = '{sape_plugin}'; 
	private static $sapeClient = null; 
	private static $sapeContent = null; 
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории с текущим плагином
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

	// возвращ€ет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		if(self::$sapeClient === null)
			return false;

		return true;
	}
	
	// делает нужные преобразовани€
	public function ModifyTemplate(&$template)
	{	
		$template = str_replace(self::$oneTag, self::$sapeClient->return_links(), $template);
		$template = self::$sapeContent->replace_in_text_segment($template);
	}
	
	// позвращ€ет описание плагина - нужно дл€ админпанели 
	public function GetShortDescription()
	{
		return "установка кода системы купли продажи ссылок sape.ru";
	}
	
	// функци€ настройки плагина из админпанели
	public function Admin()
	{
		return "плагин не поддерживает настройки";
	}
	
	// обработка страницы на сайте
	// $mainpageTemplate - главна€ страницы
	public function Render($mainpageTemplate)
	{
		// если плагин не поддерживает рендеринг страницы то он должен вернуть 404 ошибку, это правильней с точки зрени€ безопасности
		header("HTTP/1.0 404 Not Found");
		exit();
	}
}

?>