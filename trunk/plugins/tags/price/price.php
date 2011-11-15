<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// добавление прайса листа на сайт, с возможностью просмотра

class plugin_price
{	
	private static $pluginName = 'price';							// им€ самого плагина
	private static $pluginUrl = './index.php?plugins=price';
	private $priceUploadDir;										// 
	private $pathToPlugin;											// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->priceUploadDir = '../'.UPLOADFILE_DIRECTORY.'/price/';
	}

	// возвращ€ет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		return true;
	}
	
	// делает нужные преобразовани€
	public function ModifyTemplate(&$template)
	{	
		//foreach($this->tagsArray as $val)
		//	$template = str_replace($val['tag'], $val['value'], $template);		
			
	}
	
	// возвращ€ет описание плагина - нужно дл€ админпанели 
	public function GetShortDescription()
	{
		return "”правление прайслистом";
	}
	
	// функци€ настройки плагина из админпанели
	public function Admin()
	{	
		$message = $this->prepareDirectory();
		
		// загружаем шаблон
		$settingsTpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// {message}
		$settingsTpl = str_replace('{message}', $message, $settingsTpl);
		
		return $settingsTpl;
	}
	
	// обработка страницы на сайте
	// $mainpageTemplate - главна€ страницы
	public function Render($mainpageTemplate)
	{	
		$template = file_get_contents("./skin/".SKIN."/templates/newsshowfull.tpl");
		
		// замен€ем теги
		// {newsname}
		$template = str_replace('{newsname}', "FIXME", $template);
		
		// {newsdate}
		$template = str_replace('{newsdate}', "FIXME", $template);
		
		// {newsautor}
		$template = str_replace('{newsautor}', "FIXME", $template);
		
		// {edit} - будет путь на настройки плагина если админ, иначе ничего
		$template = str_replace('{edit}', "FIXME", $template);
		
		// {keywords}
		$template = str_replace('{keywords}', "FIXME", $template);
		
		// {newsshowfull}
		$priceContent = '<iframe src="http://docs.google.com/viewer?url=http://labs.google.com/papers/bigtable-osdi06.pdf&embedded=true" width="100%" height="300" frameborder="0" scrolling="no"></iframe>';
		$template = str_replace('{newsshowfull}', $priceContent, $template);
		
		return $template;
	}
	
	private function prepareDirectory()
	{
		// создаЄм директорую куда будем загружать прайслист и где его будем брать
		if(is_dir($this->priceUploadDir) === false)
		{
			if(mkdir($this->priceUploadDir) === true)
				return 'ƒиректори€ дл€ сохранени€ прайс-листа создана';
			
			return $message = 'Ќевозможно создать директорию дл€ хранени€ прайс-листа';
		}
		
		return "";
	}
	
}

?>
