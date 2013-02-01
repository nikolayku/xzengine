<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ����� favicon ��������������� �� �����������

class plugin_favicon
{	
	private static $pluginName = 'favicon';									// ��� ������ �������
	private static $pluginUrl = 'index.php?plugins=favicon';				// �������� �������� ������� � �����������
	private static $defaultFileName = 'favicon.ico';						// favicon �� ���������
	private static $configDir = '../temp/plugins/favicon';					// ���������� � �����������(������������ admin )
	private static $configDirMain = './temp/plugins/favicon';				// ���������� � �����������(������������ ������� �������� )
	private $pathToPlugin;													// ���� � ���������� �������
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� �� �������
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		// ������� ����� ������ �� �������������
		return false;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		// ������� �������� � �������� �������� �� ����������
		return false;
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "��������� favicon.ico";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		$message = "";
				
		// �������� ������� ���������� ��� �������� �������
		if(is_dir(self::$configDir) == false)
		{
			if(mkdir(self::$configDir, 0777, true) === false)
				$message .= '���������� ������� ���������� ��� ���������� ����������������� favicon.ico';
			else 
				$message .= '���������� ��� ���������� ����������������� favicon.ico �������';
		}
		
		// �������� �����
		if(isset($_GET['upload']))
			$message .= $this->ParseUplodedFile();
		else if(isset($_GET['delete']))
		{
			if(@unlink(self::$configDir.'/'.self::$defaultFileName))
				$message .= "���� �����";
			else
				$message .= "���������� ������� ����";
		}
		
		
		return $this->LoadTemplate($message);		
	}
	
	// ��������� �������� ���� (index.php?plugin=favicon) �� �����
	// $mainpageTemplate - ������� ��������
	public function Render($mainpageTemplate)
	{	
		self::OutputImage($this->GetPath());
			
		exit();
	}
	
	//========================================================================
	
	// ������� favicon.ico 
	static private function OutputImage($filename)
	{
		header('Content-type: image/x-icon');
		header('Content-Length: ' . filesize($filename));
		ob_clean();
		flush();
		readfile($filename);
	}
	
	// ���������� ���� �� favicon �������� 
	private function GetPath()
	{	
		// �������� �� ���������
		$filePath = $this->pathToPlugin.'/'.self::$defaultFileName;
		
		$temp = self::$configDirMain.'/'.self::$defaultFileName;
		if(is_file($temp))
			$filePath = $temp;
			
		return $filePath;
	}
	
	private function LoadTemplate($message)
	{
		$tpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// �������� ����
		// {message}
		$tpl = str_replace('{message}', $message, $tpl);
		
		//{favicon_path}
		$link = SITE_PATH.self::$pluginUrl;
		if(SIMPLY_URL == 1)
			$link = SITE_PATH."/".self::$defaultFileName;
		$tpl = str_replace("{favicon_path}", $link, $tpl);
		
		// {maxfilesize_str}	
		$tpl = str_replace("{maxfilesize_str}", ConvertBytes(UPLOADFILE_SIZE), $tpl);
		
		// {maxfilesize}	
		$settingsTpl = str_replace("{maxfilesize}", UPLOADFILE_SIZE, $settingsTpl);
		
		// {new}
		$tpl = str_replace("{new}", self::$pluginUrl.'&upload', $tpl);
		// {delete}
		$tpl = str_replace("{delete}", self::$pluginUrl.'&delete', $tpl);
		
		return $tpl;
	}
	// ==================== helper functions ====================
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
	
	// ������������ ����������� ����
	private function ParseUplodedFile()
	{	
		$filename = $_FILES['uploadfilename']['name'];
		
		// �������� �� �������������� ���
		if(self::getExtension($filename) !== "ico")
			return '������ .ico �������� ��� favicon �����';	
		
		if(!is_uploaded_file($_FILES['uploadfilename']['tmp_name']))
			return '���� �� ��������. �������� ���� ����� ������� ������� ������ ��� ��������� ������ ����������';	
		
		if(!move_uploaded_file($_FILES['uploadfilename']['tmp_name'], self::$configDir.'/'.self::$defaultFileName))
			return '���������� ��������� ����';
				
		return '���� favicon.ico ��������.';
	}
	
}

?>
