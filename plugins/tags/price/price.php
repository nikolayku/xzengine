<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ���������� ������ ����� �� ����, � ������������ ��������� ����� google document view
// ��������� ������ ��������� � ����� UPLOADFILE_DIRECTORY.'/price/
// ��� ���������� - �����
// ����������� � ����� ����� ���� ���������, ������ ��� ����� ��������� �� ���� ��������
// ������������ ����������� ���� ����� - � ����� ��������������� ������

//FIXME: ����. ������
//FIXME: javascript ��������� � ����

class plugin_price
{	
	private static $pluginName = 'price';							// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=price';
	private static $allowFiletypes = array('pdf', 'doc', 'docx', 'xls', 'xlsx');	// ���������� ������ ������
	private static $archiveFiletypes = array('zip', 'rar');							// ����� �������
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
		//��������� ���� �����������
		$langPath = './lang/'.SITE_LOC_FILE.'/plugins/price.php';
		if(is_file($langPath))
			require_once($langPath);
		
		$tpl = self::prepareTemplate();
		
		// ������������ ������� �������� 
		$template = str_replace('{price_list}', $tpl, $template);
		
		// ��������� ����� ({style} � ����� ����� ��� ���� ����� ��������� ������� ������ ���������� ���� �����)
		$template = str_replace('{style}', '<link href="{skin}/plugins/price/style.css" rel="stylesheet" type="text/css" media="screen" />{style}', $template);
		
		// ��������� javascript ({javasript} � ����� ����� ��� ���� ����� ��������� ������� ������ ���������� ���� javascript)
		$template = str_replace('{javascript}', '<script src="{skin}/plugins/price/code.js" type="text/javascript" language="javascript"></script>{javascript}', $template);
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
	public function Render($mainpageTemplate)
	{	
		// ���� ������ �� ������������ ��������� �������� �� �� ������ ������� 404 ������, ��� ���������� � ����� ������ ������������
		header("HTTP/1.0 404 Not Found");
		exit();
	}
	
	//========================================================================
	// ��������������� ������� �������
	
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
	
	// ���������� ������ �� ������ ����� ��� false ���� ���� ����� ��� ���������� ����������
	// ���������� ������ �� ������, ��������������� ���������� ����� - ���� false, ���� ����� ���������� �� ������������� ��������
	// $isView - true, ���� ���� ����� ���� ���������� ����� google documen view
	
	static function ifDownloadAndView($path, &$isView)
	{
		// ���� �����
		if(self::isArchive($path) === true)
		{	
			$isView = false;
			return false;
		}
		
		// ���� ������������ ����
		if(self::getPriceFileType($path, $filetype) === false)
		{
			$isView = false;
			return false;
		}
		
		$isView = true;
		return '{skin}/plugins/price/img/filetype/'.$filetype.'.png';
	}
	
	// ���������� ���������� �����
	static private function getExtension($path)
	{
		$path = trim($path);
		
		$part = explode('.', $path);
		if(count($part) > 0)
			$part = $part[count($part) - 1];
		
		if($part == $path)
			return false;
		
		$part = strtolower(trim($part));
		return $part;
	}
	
	//�������� ��� ����� �� ��� ����������
	// ���������� true, ���� �������� $path ����� ����������� � ������� � false ���� ������ (zip, rar)
	// $filetype �������� ���������� �����
	static private function getPriceFileType($path, &$filetype)
	{	
		$part = self::getExtension($path);
		
		if(array_search($part, self::$allowFiletypes) !== false)
		{	
			$filetype = $part;
			return true;
		}
		
		return false;
	}
	
	// ���������� true ���� ���� �������� �������
	static private function isArchive($path)
	{
		$ext = self::getExtension($path);
		
		if(array_search($ext, self::$archiveFiletypes) === false)
			return false;
			
		return true;
	}
	
	// ���������� true, ���� ��� ����� �������������� ��������
	static private function isValidExtension($path)
	{
		if(self::isArchive($path) === true)
			return true;
		
		if(self::getPriceFileType($path, $temp) === true)
			return true;
			
		return false;
	}
	
	static private function prepareTemplate()
	{
		// ��������� ������
		$tpl = file_get_contents('./skin/'.SKIN.'/plugins/price/price.tpl');
		
		//{title_download}
		$tpl = str_replace('{title_download}', plugin_price_title_download, $tpl);
		
		//{alt_download}
		$tpl = str_replace('{alt_download}', plugin_price_alt_download, $tpl);
		
		//{title_close}
		$tpl = str_replace('{title_close}', plugin_price_title_close, $tpl);
		
		//{alt_close}
		$tpl = str_replace('{alt_close}', plugin_price_alt_close, $tpl);
		
		//{title_watch}
		$tpl = str_replace('{title_watch}', plugin_price_title_watch, $tpl);
		
		//{alt_watch}
		$tpl = str_replace('{alt_watch}', plugin_price_alt_watch, $tpl);
		
		//{title}
		$tpl = str_replace('{title}', plugin_price_title, $tpl);
		
		
		// ���� � ����� ��� �������
		//FIXME: ���� ������� �������� �� ����� 
		$pricePath = self::scanPriceDirectory(); // �������� ��������� ���������
		
		$iconFile = self::ifDownloadAndView($pricePath, $canViewOnline);
		
		if($canViewOnline === true)
		{
			//{icon}
			$tpl = str_replace('{icon}', $iconFile, $tpl);
			
			//{canview} .. {/canview}
			$tpl = str_replace('{canview}', '', $tpl);
			
			//{/canview}
			$tpl = str_replace('{/canview}', '', $tpl);
		}
		else
		{
			// �������� {canview} .. {/canview}
			$tpl = preg_replace('/(\{canview\}[\s\S]+\{\/canview\})/', '', $tpl);
		}
		
		//{price_url}
		$tpl = str_replace('{price_url}', $pricePath, $tpl);
		
		return $tpl;
	}
	
	// ��������� ���������� � ������������, ���������� ��� ������ ���������� �� ������� �������� �����
	static private function scanPriceDirectory()
	{
		$dirToScan = './'.UPLOADFILE_DIRECTORY.'/price/';
		$bestPrice = "";	// ����� ��������� ������� �����
		$lastTime = 0;		// ��������� �����, �� ��� ����� ������� ������ ����
		
		$handle = opendir($dirToScan);
		while (false !== ($file = readdir($handle)))
		{
			if($file == '.' || $file == '..' || $file == '.svn')
				continue;
			
			$fullPath = $dirToScan.$file;
			
			// ���� ���������� ����� �� ��������������
			if(self::isValidExtension($fullPath) === false)
				continue;
			
			// �������� ����� �������� �����
			$fileInfo = stat($fullPath);
			if($fileInfo === false)
				continue;
			
			if($fileInfo['mtime'] > $lastTime)
			{
				$bestPrice = $file;
				$lastTime = $fileInfo['mtime'];
			}
			
		}
		closedir($handle);
		
		return '{sitepath}/'.UPLOADFILE_DIRECTORY.'/price/'.$bestPrice;
	}
	
}

?>
