<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
// autor Kulchicky Nikolay
// 
//////////////////////////////////////////////////////////////////////////////////////////////
// ��������� ��������� ����

class plugin_customtag
{	
	private static $pluginsDir = 'tags'; 	// ���������� ��� ����������� ���������
	private static $pluginName = 'customtag';		// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=customtag';
	private $tagsArray = array();
	private $pathToPlugin;		// ���� � ���������� �������
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� �� �������
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->scanDirectoryWithTags();
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
			$template = str_replace($val['tag'], $val['value'], $template);		
			
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "�������� �������������� �����";
	}
	
	// ������� ��������� ������� �� �����������
	// $adminPage - �������� �����������
	public function Admin($adminPage)
	{	
		$message = "";
		if($this->GetDirAttr($this->pathToPlugin.'/'.self::$pluginsDir) != '777')
			$message = '���������� ��������� ��������� �����. �� ����� "'.self::$pluginsDir.'" �� ����������� ����� ������';

		if(isset($_GET['del']))
			$message = $this->deleteTeg($_GET['del']).$message;
		
		if(isset($_GET['new']))
			$message = $this->newTag().$message;
		
		$editName = false;
		if(isset($_GET['edit']))
			$editName = trim($_GET['edit']);
				
		$out = $this->formAddNew($message, $editName).$this->getList();
		
		// ��������� ������� ����� readme.txt
		$readMeFile = $this->pathToPlugin.'/readme.txt';
		if(isset($readMeFile))
			$out .= file_get_contents($readMeFile);
		
		return $out;
	}
	
	// ��������� �������� �� �����
	// $mainpageTemplate - ������� ��������
	public function Render($mainpageTemplate)
	{	
		// ���� ������ �� ������������ ��������� �������� �� �� ������ ������� 404 ������, ��� ���������� � ����� ������ ������������
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	
	// ==================== ������ ���� ������� ������������� ��� ������� =======================
	
	// ��������� ���������� � ������
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
			// ��������� ������
			$this->tagsArray[] = array('tag'=>'{'.$name.'}', 'value'=>file_get_contents($dirToScan.'/'.$file), 'name'=>$name);
		}
		closedir($handle);
	}
	
	// ���������� ������� ���������� ��������� � ������
	private function getList()
	{	
		$listTemplate = file_get_contents($this->pathToPlugin.'/tagslist.tpl');
		
		$out = "";
		for($i = 0; $i < count($this->tagsArray); ++$i)
		{
			$temp = $listTemplate;
			$temp = str_replace('{tag}', $this->tagsArray[$i]['tag'], $temp);
			
			// ������ ��� �������� ��������
			$deleteUrl = self::$pluginUrl.'&del='.$this->tagsArray[$i]['name'];
			$temp = str_replace('{delete}', $deleteUrl, $temp);
			
			$editUrl = self::$pluginUrl.'&edit='.$this->tagsArray[$i]['name'];
			$temp = str_replace('{edit}', $editUrl, $temp);
			
			$out .= $temp;
		}
		
		return $out;
	}
	
	// ������� ��� �� �����
	private function deleteTeg($name)
	{
		$name = trim($name);
		
		for($i = 0; $i < count($this->tagsArray); ++$i)
		{
			if($this->tagsArray[$i]['name'] == $name)
			{
				$pathToDelete = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$name.'.txt';
				if(unlink($pathToDelete) == false)
					return "���������� ������� ��� '".$name."'";
				else
				{
					$this->scanDirectoryWithTags();
					return "��� �����";
				}
			}
		}
	}
	
	// ���������� ������ ��������
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
		
		// {new} ������ ��� �������� ������ ��������
		$newUrl = self::$pluginUrl.'&new';
		$newTemplate = str_replace('{new}', $newUrl, $newTemplate);
		
		// {tag_name}
		$newTemplate = str_replace('{tag_name}', $tagName, $newTemplate);
		
		// {tag_code}
		$newTemplate = str_replace('{tag_code}', $tagCode, $newTemplate);
		
		return $newTemplate;
	}
	
	// �������� �������� ����������
	private function GetDirAttr($dir)
	{
		return (substr(sprintf('%o', @fileperms($dir)), -3));
	}
	
	// ������ ����� ���
	private function newTag()
	{	
		// ������� ��� ������ �������
		$name = $this->checkInputName($_POST['counter_name']);
		if($name == '')
			return '��� ���� ������ �� ���������';
		
		$counterCode = trim($_POST['counter_code']);
		$counterCode = stripslashes(htmlspecialchars_decode($counterCode));
		
		// ���������
		$fileName = $this->pathToPlugin.'/'.self::$pluginsDir.'/'.$name.'.txt';
		if(file_put_contents($fileName, $counterCode) == false)
			return '��� �� �������';
		
		// ����������� ������ ���������
		$this->scanDirectoryWithTags();
			
		return '��� �������';
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
