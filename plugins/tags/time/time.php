<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2013 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ��������� ��� � ������������ ������� �� �������
// %Y% - ����������� ������� ���
// %M% - ����������� ������� �����
// %D% - ����������� ������� ����
// %h% - ����������� ������� ���
// %m% - ����������� ������� ������
// %s% - ����������� ������� ������� 

class plugin_time
{	
	private static $pluginName = 'time';							// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=time';
	private $pathToPlugin;											// ���� � ���������� �������
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� �� �������
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;	
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		// FIXME: add regular expression pattern
		return true;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		//��������� ���� �����������
		// ������������ ������� �������� 
		$template = str_replace('{time}', "curret time is here", $template);
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{	
		return "��������������� ����� �������";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		$readMeFile = $this->pathToPlugin.'/readme.txt';
		if(isset($readMeFile))
			$out .= file_get_contents($readMeFile);
		else
			$out = "�� ������ ���� 'readme.txt'";
			
		return $out; 
	}
	
	// ��������� �������� �� �����
	public function Render($mainpageTemplate)
	{	
		// ���� ������ �� ������������ ��������� �������� �� �� ������ ������� 404 ������, ��� ���������� � ����� ������ ������������
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	
	//========================================================================
	// ��������������� ������� �������
		
}

?>
