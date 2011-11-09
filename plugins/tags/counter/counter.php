<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
// 
//////////////////////////////////////////////////////////////////////////////////////////////
// встраивание на страницу счётчиков от ли.ру, рамблера и тд

class plugin_counter
{	
	private static $pluginsDir = 'counters'; 	// директория где расположены счётчики
	private static $pluginName = 'counter';		// имя самого плагина
	private static $pluginUrl = './index.php?plugins=counter';
	private $tagsArray = array();
	private $pathToPlugin;		// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->scanDirectoryWithCounters();
	}

	// возвращяет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		if(count($this->tagsArray) > 0)	
			return true;
		
		return false;
	}
	
	// делает нужные преобразования
	public function ModifyTemplate(&$template)
	{	
		foreach($this->tagsArray as $val)
		{
			$template = str_replace($val['tag'], $val['value'], $template);		
		}	
	}
	
	// позвращяет описание плагина - нужно для админпанели 
	public function GetShortDescription()
	{
		return "различные счётчики";
	}
	
	// функция настройки плагина из админпанели
	public function Admin()
	{	
		$message = "";
		if($this->GetDirAttr('./'.$this->pathToPlugin.'/'.self::$pluginsDir) != '777')
			$message = 'Невозможно сохранить настройки счётчиков. На папку '.self::$pluginsDir.' не установлены права записи';

		if(isset($_GET['del']))
			$message = $this->deleteCounter($_GET['del']).$message;
		
				
		$out = $this->formAddNew($message).$this->getList();
		
		return $out;
	}
	
	// сканирует директория с счётчиками
	private function scanDirectoryWithCounters()
	{	
		$this->tagsArray = array();
		
		$dirToScan = $this->pathToPlugin.'/'.self::$pluginsDir.'/';
		$handle = opendir($dirToScan);
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..' || $file == '.svn')
				continue;
			
			$name = strtok($file, '.');
			// формируем массив
			$this->tagsArray[] = array('tag'=>'{'.$name.'}', 'value'=>file_get_contents($dirToScan.'/'.$file), 'name'=>$name);
		}
		closedir($handle);
	}
	
	// возвращяет списком количество счётчиков с тегами
	private function getList()
	{	
		$listTemplate = file_get_contents($this->pathToPlugin.'/counterslist.tpl');
		
		$out = "";
		for($i = 0; $i < count($this->tagsArray); ++$i)
		{
			$temp = $listTemplate;
			$temp = str_replace('{tag}', $this->tagsArray[$i]['tag'], $temp);
			
			$deleteUrl = self::$pluginUrl.'&del='.$this->tagsArray[$i]['name'];
			$temp = str_replace('{delete}', $deleteUrl, $temp);
			
			$out .= $temp;
		}
		
		return $out;
	}
	
	// удаляем счётчик по имени
	private function deleteCounter($name)
	{
		$name = trim($name);
		
		for($i = 0; $i < count($this->tagsArray); ++$i)
		{
			if($this->tagsArray[$i]['name'] == $name)
			{
				$pathToDelete = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$name.'.txt';
				echo $pathToDelete;
				if(unlink($pathToDelete) == false)
					return "Невозможно удалить счётчик '".$name."'";
				else
				{
					$this->scanDirectoryWithCounters();
					return "Счётчик удалён";
				}
			}
		}
	}
	
	// добавление нового счётчика
	private function formAddNew($message)
	{
		$newTemplate = file_get_contents($this->pathToPlugin.'/new.tpl');
		
		//{message}
		$newTemplate = str_replace('{message}', $message, $newTemplate);
		
		return $newTemplate;
	}
	
	// получает атрибуты директории
	private function GetDirAttr($dir)
	{
		return (substr(sprintf('%o', @fileperms($dir)), -3));
	}
}

?>