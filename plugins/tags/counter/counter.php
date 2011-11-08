<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
// 
//////////////////////////////////////////////////////////////////////////////////////////////
// ����������� �� �������� ��������� �� ��.��, �������� � ��

class plugin_counter
{	
	private static $pluginsDir = 'counters'; 	// ���������� ��� ����������� ��������
	private static $pluginName = 'counter';		// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=counter';
	private $tagsArray = array();
	private $pathToPlugin;		// ���� � ���������� �������
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� �� �������
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->scanDirectoryWithCounters();
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		if(count($this->tagsArray) > 0)	
			return true;
		
		return false;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		foreach($this->tagsArray as $val)
		{
			$template = str_replace($val['tag'], $val['value'], $template);		
		}	
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "��������� ��������";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		if(isset($_GET['del']))
			$this->deleteCounter($_GET['del']);
		
		$out = $this->formAddNew().$this->getList();
		
		return $out;
	}
	
	// ��������� ���������� � ����������
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
			// ��������� ������
			$this->tagsArray[] = array('tag'=>'{'.$name.'}', 'value'=>file_get_contents($dirToScan.'/'.$file), 'name'=>$name);
		}
		closedir($handle);
	}
	
	// ���������� ������� ���������� ��������� � ������
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
	
	// ������� ������� �� �����
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
					return "���������� ������� ������� '".$name."'";
				else
				{
					$this->scanDirectoryWithCounters();
					return "������� �����";
				}
			}
		}
	}
	
	// ���������� ������ ��������
	private function formAddNew($message)
	{
		$newTemplate = file_get_contents($this->pathToPlugin.'/new.tpl');
		
		return $newTemplate;
	}
}

?>