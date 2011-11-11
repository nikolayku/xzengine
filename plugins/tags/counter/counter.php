<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
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
		// FIXME: ����� ���������� ��������
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
		return "�������� ������������ �����(Liveinternet, Rambler...)";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		$message = "";
		if($this->GetDirAttr('./'.$this->pathToPlugin.'/'.self::$pluginsDir) != '777')
			$message = '���������� ��������� ��������� ���������. �� ����� '.self::$pluginsDir.' �� ����������� ����� ������';

		if(isset($_GET['del']))
			$message = $this->deleteCounter($_GET['del']).$message;
		
		if(isset($_GET['new']))
			$message = $this->newCounter().$message;
		
				
		$out = $this->formAddNew($message).$this->getList();
		
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
			
			// ������ ��� �������� ��������
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
		
		//{message}
		$newTemplate = str_replace('{message}', $message, $newTemplate);
		
		// {new} ������ ��� �������� ������ ��������
		$newUrl = self::$pluginUrl.'&new';
		$newTemplate = str_replace('{new}', $newUrl, $newTemplate);
		
		return $newTemplate;
	}
	
	// �������� �������� ����������
	private function GetDirAttr($dir)
	{
		return (substr(sprintf('%o', @fileperms($dir)), -3));
	}
	
	// ������ �������
	private function newCounter()
	{	
		// ������� ��� ������ �������
		$name = $this->checkInputName($_POST['counter_name']);
		if($name == '')
			return '��� �������� ������ �� ���������';
		
		$counterCode = trim($_POST['counter_code']);
		
		// ���������
		$fileName = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$name.'.txt';
		if(file_put_contents($fileName, $counterCode) == false)
			return '������� �� ��������';
		
		// ����������� ������ ���������
		$this->scanDirectoryWithCounters();
			
		return '������� ��������';
	}
	
	// ��������� ������������ ����� ����� ��������, 
	// ������� ��� ������ ������� ����� �������� � ��������� ���� ����������� ��������, � ����� ������� '_'
	private function checkInputName($name)
	{
		$name = preg_replace('/([^a-zA-Z_]+)/', '', $name);
		$name = trim($name);
		return $name;
	}
}

?>
