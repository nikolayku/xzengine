<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
// 
//////////////////////////////////////////////////////////////////////////////////////////////
// встраивание на страницу счЄтчиков от ли.ру, рамблера и тд

class plugin_counter
{	
	private static $pluginsDir = 'counters'; 	// директори€ где расположены счЄтчики
	private static $pluginName = 'counter';		// им€ самого плагина
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
		return "различные счЄтчики";
	}
	
	// функци€ настройки плагина из админпанели
	public function Admin()
	{	
		if(isset($_GET['del']))
			$this->deleteCounter($_GET['del']);
		
		$out = $this->formAddNew().$this->getList();
		
		return $out;
	}
	
	// сканирует директори€ с счЄтчиками
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
	
	// возвращ€ет списком количество счЄтчиков с тегами
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
	
	// удал€ем счЄтчик по имени
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
					return "Ќевозможно удалить счЄтчик '".$name."'";
				else
				{
					$this->scanDirectoryWithCounters();
					return "—чЄтчик удалЄн";
				}
			}
		}
	}
	
	// добавление нового счЄтчика
	private function formAddNew($message)
	{
		$newTemplate = file_get_contents($this->pathToPlugin.'/new.tpl');
		
		return $newTemplate;
	}
}

?>