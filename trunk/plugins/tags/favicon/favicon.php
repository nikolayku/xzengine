<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// смена favicon непосредственно из админпанели

class plugin_favicon
{	
	private static $pluginName = 'favicon';									// имя самого плагина
	private static $pluginUrl = './index.php?plugins=favicon';				// страница настроек плагина в админпанеле
	private static $defaultFileName = 'favicon.ico';						// favicon по умолчанию
	private static $configDir = '../temp/plugins/favicon';					// директория с настройками(относительно admin )
	private static $configDirMain = './temp/plugins/favicon';				// директория с настройками(относительно главной страницы )
	private $pathToPlugin;													// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
	}

	// возвращяет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		// никаких тегов плагин не предоставляет
		return false;
	}
	
	// делает нужные преобразования
	public function ModifyTemplate(&$template)
	{	
		// никаких действий с шаблоном страницы не производит
		return false;
	}
	
	// возвращяет описание плагина - нужно для админпанели 
	public function GetShortDescription()
	{
		return "Изменение favicon.ico";
	}
	
	// функция настройки плагина из админпанели
	public function Admin()
	{	
		$message = "";
				
		// пытаемся создать директорию для хранения конфига
		if(is_dir(self::$configDir) == false)
		{
			if(mkdir(self::$configDir, 0777, true) === false)
				$message .= 'Невозможно создать директорию для сохранения пользовательского favicon.ico';
			else 
				$message .= 'Дтректория для сохранения пользовательского favicon.ico создана';
		}
		
		/*
		if(isset($_GET['save']))
		{
			if(self::SaveConfig() === false)
				$message .= 'Ошибка сохранения конфигурационного файла';
			else
				$message .= 'Настройки сохранены';
		}
		
		// загружаем конфиг файл
		$msg = '';
		$values = self::LoadConfig($msg, true);
		$message .= $msg;
		
		*/
		
		return $this->LoadTemplate($message);
		
	}
	
	// обработка страницы вида (index.php?plugin=favicon) на сайте
	// $mainpageTemplate - главная страницы
	public function Render($mainpageTemplate)
	{	
		self::OutputImage($this->GetPath());
			
		exit();
	}
	
	//========================================================================
	
	// читает файл 
	static private function OutputImage($filename)
	{
		header('Content-type: image/x-icon');
		header('Content-Length: ' . filesize($filename));
		ob_clean();
		flush();
		readfile($filename);
	}
	
	// возвращяет путь на favicon картинку 
	private function GetPath()
	{	
		// значение по умолчанию
		$filePath = $this->pathToPlugin.'/'.self::$defaultFileName;
		
		$temp = self::$configDirMain.'/'.self::$defaultFileName;
		if(is_file($temp))
			$filePath = $temp;
			
		return $filePath;
	}
	
	private function LoadTemplate($message)
	{
		$tpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// заменяем теги
		// {message}
		$tpl = str_replace('{message}', $message, $tpl);
		
		return $tpl;
	}
	
	// Загружает конфиг
	// $msg - возвращяет ошибку 
	// $ifAdminPage - если true, то сейчас работа вёдется с админпанели, false значит основная страница сайта
	/*static private function LoadConfig(&$msg, $ifAdminPage)
	{	
		// значения по умолчанию
		$default = array();
		$default['rss_newscount'] = 30;						// количество новостей на странице
		$default['rss_descr'] = 'xzengne - rss plugin ';	// описание канала
		$default['rss_update'] = 120;						// время обновления канала в минутах
		
		$configFile = self::$configDir . self::$configFile;
		if($ifAdminPage === false)
			$configFile = self::$configDirMain . self::$configFile;
		
		if(is_file($configFile) === false)
		{	
			$msg = 'Конфигурационный файл не найден, используются настройки по умолчанию';
			return $default;
		}	
		
		// загружаем конфиг
		$buf = file_get_contents($configFile);
		$ret = @unserialize($buf);
		if($ret === false)
		{
			$msg = 'Ошибка загрузки конфигурационного файла';
			return $default;
		}
		
		//FIXME: проверка введённых значений
		
		return $ret;
	}
		*/
	
	/*
	private static function SaveConfig()
	{
		$data = array();
		$data['rss_newscount'] = $_POST['rss_newscount'];
		$data['rss_descr'] = $_POST['rss_descr'];
		$data['rss_update'] = $_POST['rss_update'];
		
		//FIXME: проверка введенных данных
		
		// сохранение
		$buf = serialize($data);
		
		$fileToSave = self::$configDir . self::$configFile;
		return @file_put_contents($fileToSave, $buf);
	}
	*/
	
}

?>
