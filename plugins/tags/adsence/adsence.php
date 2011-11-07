<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ����������� �� �������� ���� adsence �� google

class plugin_adsence
{	
	private static $pluginsDir = 'banners'; 	
	private $tagsArray = array();

	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� � ������� ��������
	public function __construct($path)
	{
		$dirToScan = $path.'/'.self::$pluginsDir.'/';
		$handle = opendir($dirToScan);
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..')
				continue;
			$name = strtok($file, '.');
			// ��������� ������
			$this->tagsArray[] = array('tag'=>'{'.$name.'}', 'value'=>file_get_contents($dirToScan.'/'.$file));
		}
		closedir($handle);
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
		return "��������� adsence";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{
		return "������ �� ������������ ���������";
	}
}

?>