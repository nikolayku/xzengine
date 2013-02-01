<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2013 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ƒобавл€ет тег с подстановкой времени по формату
// %Y% - подставл€ет текущий год
// %M% - подставл€ет текущий мес€ц
// %D% - подставл€ет текущий день
// %h% - подставл€ет текущий час
// %m% - подставл€ет текущюю минуту
// %s% - подставл€ет текущюю секунду 

// используетс€ как callback функци€ 
function plugin_time_callback($matches)
{	
	// подстановка дл€ функции date
	$chars = array("%Y%"=>"Y", "%M%"=>"m", "%D%"=>"d", "%h%"=>"H", "%m%"=>"i", "%s%"=>"s");
	$date = $matches[1];
	
	// форматируем дл€ функции date
	foreach($chars as $key=>$val)
		$date = str_replace($key, $val, $date);
	
	return date($date);
}

class plugin_time
{	
	private static $pluginName = 'time';						// им€ самого плагина
	private static $pluginUrl = './index.php?plugins=time';
	private static $regExpr = "/{time:([^}]+)}/";				// регул€рное выражение дл€ поиска
	private $pathToPlugin;										// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;	
	}

	// возвращ€ет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		// FIXME: add regular expression pattern
		return true;
	}
	
	// делает нужные преобразовани€
	public function ModifyTemplate(&$template)
	{	
		// модифицируем главную страницу 
		$template = preg_replace_callback(self::$regExpr, "plugin_time_callback", $template);		
	}
	
	// возвращ€ет описание плагина - нужно дл€ админпанели 
	public function GetShortDescription()
	{	
		return "‘орматированный вывод времени";
	}
	
	// функци€ настройки плагина из админпанели
	public function Admin()
	{	
		$readMeFile = $this->pathToPlugin.'/readme.txt';
		if(isset($readMeFile))
			$out .= file_get_contents($readMeFile);
		else
			$out = "Ќе найден файл 'readme.txt'";
			
		return $out; 
	}
	
	// обработка страницы на сайте
	public function Render($mainpageTemplate)
	{	
		// если плагин не поддерживает рендеринг страницы то он должен вернуть 404 ошибку, это правильней с точки зрени€ безопасности
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	
	//========================================================================
	// вспомогательные функции плагина
		
}

?>
