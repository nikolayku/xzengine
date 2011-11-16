<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// генерация rss для xzengine

class plugin_rss
{	
	private static $pluginName = 'rss';								// имя самого плагина
	private static $pluginUrl = './index.php?plugins=rss';			// страница настроек плагина в админпанеле
	private static $configFile = 'config.txt';						// файл с настройками
	private static $configDir = '../temp/plugins/rss/';				// директория с настройками(относительно admin )
	private static $configDirMain = './temp/plugins/rss/';				// директория с настройками(относительно главной страницы )
	private $pathToPlugin;											// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
	}

	// возвращяет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		//FIXME: исползовать тег {rss}
		return false;
	}
	
	// делает нужные преобразования
	public function ModifyTemplate(&$template)
	{	
		//FIXME: исползовать тег {rss}
		return;
	}
	
	// возвращяет описание плагина - нужно для админпанели 
	public function GetShortDescription()
	{
		return "Rss новости";
	}
	
	// функция настройки плагина из админпанели
	public function Admin()
	{	
		$message = "";
				
		// пытаемся создать директорию для хранения конфига
		
		if(is_dir(self::$configDir) == false)
		{
			if(mkdir(self::$configDir, 0777, true) === false)
				$message .= 'Невозможно создать директорию для сохранения настроек';
		}
		
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
		
		return $this->LoadTemplate($values, $message);
	}
	
	// обработка страницы вида (index.php?plugin=rss) на сайте
	// $mainpageTemplate - главная страницы
	public function Render($mainpageTemplate)
	{	
		// загружаем необходимые .php файлы
		require_once($this->pathToPlugin.'/generate.php');
		
		$settings = self::LoadConfig($msg, false);
		
		// генерация rss
		RssGen::GenRss($settings['rss_newscount'], $settings['rss_update'], $settings['rss_descr']);
		
		// нам не надо дальнейшая обработка движком
		exit();
	}
	
	//========================================================================
	
	// Загружает конфиг
	// $msg - возвращяет ошибку 
	// $ifAdminPage - если true, то сейчас работа вёдется с админпанели, false значит основная страница сайта
	static private function LoadConfig(&$msg, $ifAdminPage)
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
	
	private function LoadTemplate($values, $message)
	{
		$tpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// заменяем теги
		// {message}
		$tpl = str_replace('{message}', $message, $tpl);
		
		// {rss_newscount}
		$tpl = str_replace('{rss_newscount}', $values['rss_newscount'], $tpl);
		
		// {rss_descr}
		$tpl = str_replace('{rss_descr}', $values['rss_descr'], $tpl);
		
		// {rss_update}
		$tpl = str_replace('{rss_update}', $values['rss_update'], $tpl);
		
		// {rss_edit} - урл 
		$tpl = str_replace('{rss_edit}', self::$pluginUrl.'&save', $tpl);
		
		return $tpl;
	}
	
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
	
}

?>
