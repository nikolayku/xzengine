<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ���������� ������ ����� �� ����, � ������������ ���������

class plugin_price
{	
	private static $pluginName = 'price';							// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=price';
	private $priceUploadDir;										// 
	private $pathToPlugin;											// ���� � ���������� �������
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� �� �������
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
		$this->priceUploadDir = '../'.UPLOADFILE_DIRECTORY.'/price/';
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		return true;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		//foreach($this->tagsArray as $val)
		//	$template = str_replace($val['tag'], $val['value'], $template);		
			
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "���������� �����������";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		$message = $this->prepareDirectory();
		
		// ��������� ������
		$settingsTpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// {message}
		$settingsTpl = str_replace('{message}', $message, $settingsTpl);
		
		return $settingsTpl;
	}
	
	// ��������� �������� �� �����
	// $mainpageTemplate - ������� ��������
	public function Render($mainpageTemplate)
	{	
		$template = file_get_contents("./skin/".SKIN."/templates/newsshowfull.tpl");
		
		// �������� ����
		// {newsname}
		$template = str_replace('{newsname}', "FIXME", $template);
		
		// {newsdate}
		$template = str_replace('{newsdate}', "FIXME", $template);
		
		// {newsautor}
		$template = str_replace('{newsautor}', "FIXME", $template);
		
		// {edit} - ����� ���� �� ��������� ������� ���� �����, ����� ������
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
		// ������ ���������� ���� ����� ��������� ��������� � ��� ��� ����� �����
		if(is_dir($this->priceUploadDir) === false)
		{
			if(mkdir($this->priceUploadDir) === true)
				return '���������� ��� ���������� �����-����� �������';
			
			return $message = '���������� ������� ���������� ��� �������� �����-�����';
		}
		
		return "";
	}
	
}

?>
