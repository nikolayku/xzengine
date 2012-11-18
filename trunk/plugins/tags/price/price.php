<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// добавление прайса листа на сайт, с возможностью просмотра через google document view
// прайслист должен находится в папке UPLOADFILE_DIRECTORY.'/price/
// имя прайслиста - любое
// прайслистов в папке может быть несколько, плагин сам найдёт последний по дате создания
// динамическое определение типа файла - и показ соответствующей иконки

//FIXME: англ. версию

class plugin_price
{	
	private static $pluginName = 'price';							// имя самого плагина
	private static $pluginUrl = './index.php?plugins=price';
	private static $allowFiletypes = array('pdf', 'doc', 'docx', 'xls', 'xlsx');	// допустимые архивы файлов
	private static $archiveFiletypes = array('zip', 'rar');							// файлы архивов
	private $priceUploadDir;										// 
	private $pathToPlugin;											// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->priceUploadDir = '../'.UPLOADFILE_DIRECTORY.'/price/';	// путь для админпанели
	
	}

	// возвращяет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		return true;
	}
	
	// делает нужные преобразования
	public function ModifyTemplate(&$template)
	{	
		//загружаем файл локализации
		$langPath = './lang/'.SITE_LOC_FILE.'/plugins/price.php';
		if(is_file($langPath))
			require_once($langPath);
		
		$tpl = $this->prepareTemplate();
		
		// модифицируем главную страницу 
		$template = str_replace('{price_list}', $tpl, $template);
		
		// загружаем стили ({style} в конце нужен для того чтобы остальные плагины смогли подгружать свои стили)
		$template = str_replace('{style}', '<link href="{skin}/plugins/price/style.css" rel="stylesheet" type="text/css" media="screen" />{style}', $template);
		
		// загружаем javascript ({javasript} в конце нужен для того чтобы остальные плагины смогли подгружать свой javascript)
		$template = str_replace('{javascript}', '<script src="{skin}/plugins/price/code.js" type="text/javascript" language="javascript"></script>{javascript}', $template);
	}
	
	// возвращяет описание плагина - нужно для админпанели 
	public function GetShortDescription()
	{
		return "Управление прайслистом";
	}
	
	// функция настройки плагина из админпанели
	public function Admin()
	{	
		$message = $this->prepareDirectory();
		
		// загрузка файла
		if(isset($_GET['upload']))
			$message .= $this->ParseUplodedFile();
		
		return $this->prepareAdminTemplate($message);
	}
	
	// обработка страницы на сайте
	public function Render($mainpageTemplate)
	{	
		// если плагин не поддерживает рендеринг страницы то он должен вернуть 404 ошибку, это правильней с точки зрения безопасности
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	
	//========================================================================
	// вспомогательные функции плагина
	
	// создаёт директорию для хранения прайслистов
	private function prepareDirectory()
	{
		// создаём директорую куда будем загружать прайслист и где его будем брать
		if(is_dir($this->priceUploadDir) === false)
		{
			if(mkdir($this->priceUploadDir) === true)
				return 'Директория для сохранения прайс-листа создана';
			
			return $message = 'Невозможно создать директорию для хранения прайс-листа';
		}
		
		return "";
	}
		
	// возвращяет ссылку на иконку файла или false если файл архив или расширение неизвестно
	// возвращяет ссылку на иконку, соответствующюю расширению файла - если false, файл имеет расширение не подерживаемое плагином
	// $isView - true, если файл может быть просмотрен через google documen view
	
	static function ifDownloadAndView($path, &$isView)
	{
		// файл архив
		if(self::isArchive($path) === true)
		{	
			$isView = false;
			return false;
		}
		
		// файл неизвестного типа
		if(self::getPriceFileType($path, $filetype) === false)
		{
			$isView = false;
			return false;
		}
		
		$isView = true;
		return '{skin}/plugins/price/img/filetype/'.$filetype.'.png';
	}
	
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
	
	//получает тип файла по его расширению
	// возвращяет true, если документ $path можно просмотреть в онлайне и false если нельзя (zip, rar)
	// $filetype содержит расширение файла
	static private function getPriceFileType($path, &$filetype)
	{	
		$part = self::getExtension($path);
		
		if(array_search($part, self::$allowFiletypes) !== false)
		{	
			$filetype = $part;
			return true;
		}
		
		return false;
	}
	
	// возвращяет true если файл является архивом
	static private function isArchive($path)
	{
		$ext = self::getExtension($path);
		
		if(array_search($ext, self::$archiveFiletypes) === false)
			return false;
			
		return true;
	}
	
	// возвращяет true, если тип файла поддерживается плагином
	static private function isValidExtension($path)
	{
		if(self::isArchive($path) === true)
			return true;
		
		if(self::getPriceFileType($path, $temp) === true)
			return true;
			
		return false;
	}
	
	private function prepareTemplate()
	{
		// загружаем шаблон
		$tpl = file_get_contents('./skin/'.SKIN.'/plugins/price/price.tpl');
		
		//{title_download}
		$tpl = str_replace('{title_download}', plugin_price_title_download, $tpl);
		
		//{alt_download}
		$tpl = str_replace('{alt_download}', plugin_price_alt_download, $tpl);
		
		//{title_close}
		$tpl = str_replace('{title_close}', plugin_price_title_close, $tpl);
		
		//{alt_close}
		$tpl = str_replace('{alt_close}', plugin_price_alt_close, $tpl);
		
		//{title_watch}
		$tpl = str_replace('{title_watch}', plugin_price_title_watch, $tpl);
		
		//{alt_watch}
		$tpl = str_replace('{alt_watch}', plugin_price_alt_watch, $tpl);
		
		//{title}
		$tpl = str_replace('{title}', plugin_price_title, $tpl);
		
		
		// путь к файлу для закачки
		$pricePath = '{sitepath}/'.UPLOADFILE_DIRECTORY.'/price/'.$this->scanPriceDirectory(); // получаем последний прайслист
		
		$iconFile = self::ifDownloadAndView($pricePath, $canViewOnline);
		
		if($canViewOnline === true)
		{
			//{icon}
			$tpl = str_replace('{icon}', $iconFile, $tpl);
			
			//{canview} .. {/canview}
			$tpl = str_replace('{canview}', '', $tpl);
			
			//{/canview}
			$tpl = str_replace('{/canview}', '', $tpl);
		}
		else
		{
			// заменяем {canview} .. {/canview}
			$tpl = preg_replace('/(\{canview\}[\s\S]+\{\/canview\})/', '', $tpl);
		}
		
		//{price_url}
		$tpl = str_replace('{price_url}', $pricePath, $tpl);
		
		return $tpl;
	}
	
	// сканирует директорию с прайслистами, возвращяет имя самого последнего по времени создания файла
	// $isAdmin - true если функция вызывается из админпанели, иначе false
	private function scanPriceDirectory($isAdmin = false)
	{
		$dirToScan = './'.UPLOADFILE_DIRECTORY.'/price/';
		if($isAdmin === true)
			$dirToScan = $this->priceUploadDir;
			
		$bestPrice = "";	// самый последний залитый прайс
		$lastTime = 0;		// временная метка, по ней будет искатся лучший файл
		
		$handle = opendir($dirToScan);
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..' || $file == '.svn')
				continue;
			
			$fullPath = $dirToScan.$file;
			
			// если расширение файла не поддерживается
			if(self::isValidExtension($fullPath) === false)
				continue;
			
			// получаем время создания файла
			$fileInfo = stat($fullPath);
			if($fileInfo === false)
				continue;
			
			if($fileInfo['mtime'] > $lastTime)
			{
				$bestPrice = $file;
				$lastTime = $fileInfo['mtime'];
			}
		}
		closedir($handle);
		
		return $bestPrice;
	}
	
	// загружвет шаблон для админпанели
	private function prepareAdminTemplate($message)
	{
		// загружаем шаблон
		$settingsTpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// {message}
		$settingsTpl = str_replace('{message}', $message, $settingsTpl);
		
		// {maxfilesize_str}	
		$settingsTpl = str_replace("{maxfilesize_str}", ConvertBytes(UPLOADFILE_SIZE), $settingsTpl);
		
		// {maxfilesize}	
		$settingsTpl = str_replace("{maxfilesize}", UPLOADFILE_SIZE, $settingsTpl);
		
		// {new}
		$settingsTpl = str_replace("{new}", self::$pluginUrl.'&upload', $settingsTpl);
		
		// {price_time}
		$bestPrice = $this->priceUploadDir . $this->scanPriceDirectory(true);
		if(is_file($bestPrice) === false)
		{
			$settingsTpl = str_replace("{price_time}", "<b>Время не известно</b>", $settingsTpl);
		}
		else
		{
			$fileInfo = @stat($bestPrice);
			$settingsTpl = str_replace("{price_time}", date("d-m-Y", $fileInfo['mtime']), $settingsTpl);
		}
		
		// {help}
		$settingsTpl = str_replace("{help}", file_get_contents($this->pathToPlugin.'/readme.txt'), $settingsTpl);
		
		return $settingsTpl;
	}
	
	// обрабатывает загруженный файл
	private function ParseUplodedFile()
	{	
		$filename = $_FILES['uploadfilename']['name'];
		
		// проверки на поддерживаемый тип
		if(self::isValidExtension($filename) === false)
			return 'Данный тип файла не поддерживается';	
		
		if(!is_uploaded_file($_FILES['uploadfilename']['tmp_name']))
			return 'Файл не загружен. Возможно файл имеет слишком большой размер или произошёл разрыв соединения';	

		// удаляем предыдущие прайсы
		$this->clearPriceDir();
		
		if(!move_uploaded_file($_FILES['uploadfilename']['tmp_name'], $this->priceUploadDir.$filename))
			return 'Невозможно перенести файл';
				
		return 'Файл прайслиста загружен.';
	}	
	
	// очищяет директорию от загруженных прайслистов
	private function clearPriceDir()
	{
		$handle = opendir($this->priceUploadDir);
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..' || $file == '.svn')
				continue;
			
			$fullPath = $this->priceUploadDir.$file;
			
			// если расширение файла не поддерживается
			if(self::isValidExtension($fullPath) === false)
				continue;
			
			// удаляем файл
			@unlink($fullPath);
		}
		closedir($handle);
	}
}

?>
