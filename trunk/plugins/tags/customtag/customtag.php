<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
// autor Kulchicky Nikolay
// 
//////////////////////////////////////////////////////////////////////////////////////////////
// позволяет создавать теги

class plugin_customtag
{	
	private static $pluginsDir = 'tags'; 	// директория где расположены настройки
	private static $pluginName = 'customtag';		// имя самого плагина
	private static $pluginUrl = './index.php?plugins=customtag';
	private $tagsArray = array();
	private $pathToPlugin;		// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->scanDirectoryWithTags();
	}

	// возвращяет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		// FIXME: более тчательная проверка
		if(count($this->tagsArray) > 0)	
			return true;
		
		return false;
	}
	
	// делает нужные преобразования
	public function ModifyTemplate(&$template)
	{	
		foreach($this->tagsArray as $val)
			$template = str_replace($val['tag'], $val['value'], $template);		
			
	}
	
	// возвращяет описание плагина - нужно для админпанели 
	public function GetShortDescription()
	{
		return "Создание дополнительных тегов";
	}
	
	// функция настройки плагина из админпанели
	// $adminPage - страница админпанели
	public function Admin($adminPage)
	{	
		$message = "";
		if($this->GetDirAttr($this->pathToPlugin.'/'.self::$pluginsDir) != '777')
			$message = 'Невозможно сохранить настройки тегов. На папку "'.self::$pluginsDir.'" не установлены права записи';

		if(isset($_GET['del']))
			$message = $this->deleteTeg($_GET['del']).$message;
		
		if(isset($_GET['new']))
			$message = $this->newTag().$message;
		
		$editName = false;
		if(isset($_GET['edit']))
			$editName = trim($_GET['edit']);
				
		$out = $this->formAddNew($message, $editName).$this->getList();
		
		// проверяем наличие файла readme.txt
		$readMeFile = $this->pathToPlugin.'/readme.txt';
		if(isset($readMeFile))
			$out .= file_get_contents($readMeFile);
		
		return $out;
	}
	
	// обработка страницы на сайте
	// $mainpageTemplate - главная страницы
	public function Render($mainpageTemplate)
	{	
		// если плагин не поддерживает рендеринг страницы то он должен вернуть 404 ошибку, это правильней с точки зрения безопасности
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	
	// ==================== дальше идут функции специфические для плагина =======================
	
	// сканирует директория с тегами
	private function scanDirectoryWithTags()
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
		$listTemplate = file_get_contents($this->pathToPlugin.'/tagslist.tpl');
		
		$out = "";
		for($i = 0; $i < count($this->tagsArray); ++$i)
		{
			$temp = $listTemplate;
			$temp = str_replace('{tag}', $this->tagsArray[$i]['tag'], $temp);
			
			// ссылка для удаления счётчика
			$deleteUrl = self::$pluginUrl.'&del='.$this->tagsArray[$i]['name'];
			$temp = str_replace('{delete}', $deleteUrl, $temp);
			
			$editUrl = self::$pluginUrl.'&edit='.$this->tagsArray[$i]['name'];
			$temp = str_replace('{edit}', $editUrl, $temp);
			
			$out .= $temp;
		}
		
		return $out;
	}
	
	// удаляем тег по имени
	private function deleteTeg($name)
	{
		$name = trim($name);
		
		for($i = 0; $i < count($this->tagsArray); ++$i)
		{
			if($this->tagsArray[$i]['name'] == $name)
			{
				$pathToDelete = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$name.'.txt';
				if(unlink($pathToDelete) == false)
					return "Невозможно удалить тег '".$name."'";
				else
				{
					$this->scanDirectoryWithTags();
					return "Тег удалён";
				}
			}
		}
	}
	
	// добавление нового счётчика
	private function formAddNew($message, $editName)
	{	
		$editName = trim($editName);
		$tagName = '';
		$tagCode = '';
		
		if($editName !== false)
		{
			$fileName = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$editName.'.txt';
			if(($code = file_get_contents($fileName)) !== false)
			{
				$tagName = $editName;
				$tagCode = htmlspecialchars($code);
			}
		}
		
		$newTemplate = file_get_contents($this->pathToPlugin.'/new.tpl');
		
		//{message}
		$newTemplate = str_replace('{message}', $message, $newTemplate);
		
		// {new} ссылка для создания нового счётчика
		$newUrl = self::$pluginUrl.'&new';
		$newTemplate = str_replace('{new}', $newUrl, $newTemplate);
		
		// {tag_name}
		$newTemplate = str_replace('{tag_name}', $tagName, $newTemplate);
		
		// {tag_code}
		$newTemplate = str_replace('{tag_code}', $tagCode, $newTemplate);
		
		return $newTemplate;
	}
	
	// получает атрибуты директории
	private function GetDirAttr($dir)
	{
		return (substr(sprintf('%o', @fileperms($dir)), -3));
	}
	
	// создаёт новый тег
	private function newTag()
	{	
		// удаляем все лишние символы
		$name = $this->checkInputName($_POST['counter_name']);
		if($name == '')
			return 'Имя тега задано не корректно';
		
		$counterCode = trim($_POST['counter_code']);
		$counterCode = stripslashes(htmlspecialchars_decode($counterCode));
		
		// сохраняем
		$fileName = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$name.'.txt';
		if(file_put_contents($fileName, $counterCode) == false)
			return 'Тег не сохранён';
		
		// индексируем список счётчиков
		$this->scanDirectoryWithTags();
			
		return 'Тег сохранён';
	}
	
	// проверяет правильность ввода имени счётчика, 
	// убирает все лишние символы кроме строчных и заглавных букв английского алфавита, а также символа '_'
	private function checkInputName($name)
	{
		$name = preg_replace('/([^a-zA-Z_]+)/', '', $name);
		$name = trim($name);
		return $name;
	}
}

?>
