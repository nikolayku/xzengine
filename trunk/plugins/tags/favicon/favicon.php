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
	private static $pluginUrl = 'index.php?plugins=favicon';				// страница настроек плагина в админпанеле
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
		
		// загрузка файла
		if(isset($_GET['upload']))
			$message .= $this->ParseUplodedFile();
		else if(isset($_GET['delete']))
		{
			if(@unlink(self::$configDir.'/'.self::$defaultFileName))
				$message .= "Файл удалён";
			else
				$message .= "Невозможно удалить файл";
		}
		
		
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
	
	// Выводит favicon.ico 
	static private function OutputImage($filename)
	{
		header('Content-type: image/x-icon');
		header('Content-Length: ' . filesize($filename));
		ob_clean();
		flush();
		readfile($filename);
	}
	
	// Возвращяет путь на favicon картинку 
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
		
		//{favicon_path}
		$link = SITE_PATH.self::$pluginUrl;
		if(SIMPLY_URL == 1)
			$link = SITE_PATH."/".self::$defaultFileName;
		$tpl = str_replace("{favicon_path}", $link, $tpl);
		
		// {maxfilesize_str}	
		$tpl = str_replace("{maxfilesize_str}", ConvertBytes(UPLOADFILE_SIZE), $tpl);
		
		// {maxfilesize}	
		$settingsTpl = str_replace("{maxfilesize}", UPLOADFILE_SIZE, $settingsTpl);
		
		// {new}
		$tpl = str_replace("{new}", self::$pluginUrl.'&upload', $tpl);
		// {delete}
		$tpl = str_replace("{delete}", self::$pluginUrl.'&delete', $tpl);
		
		return $tpl;
	}
	// ==================== helper functions ====================
	// возвращяет расширение файла
	static private function getExtension($path)
	{
		$path = trim($path);
		
		$part = explode('.', $path);
		if(count($part) > 0)
			$part = $part[count($part) - 1];
		
		if($part == $path)
			return false;
		
		$part = strtolower(trim($part));
		return $part;
	}
	
	// обрабатывает загруженный файл
	private function ParseUplodedFile()
	{	
		$filename = $_FILES['uploadfilename']['name'];
		
		// проверки на поддерживаемый тип
		if(self::getExtension($filename) !== "ico")
			return 'Только .ico подходит под favicon сайта';	
		
		if(!is_uploaded_file($_FILES['uploadfilename']['tmp_name']))
			return 'Файл не загружен. Возможно файл имеет слишком большой размер или произошёл разрыв соединения';	
		
		if(!move_uploaded_file($_FILES['uploadfilename']['tmp_name'], self::$configDir.'/'.self::$defaultFileName))
			return 'Невозможно перенести файл';
				
		return 'Файл favicon.ico загружен.';
	}
	
}

?>
