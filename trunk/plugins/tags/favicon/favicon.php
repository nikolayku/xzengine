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
	private static $pluginUrl = './index.php?plugins=favicon';				// �������� �������� ������� � �����������
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
		
		/*
		if(isset($_GET['save']))
		{
			if(self::SaveConfig() === false)
				$message .= '������ ���������� ����������������� �����';
			else
				$message .= '��������� ���������';
		}
		
		// ��������� ������ ����
		$msg = '';
		$values = self::LoadConfig($msg, true);
		$message .= $msg;
		
		*/
		
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
	
	// ������ ���� 
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
		
		return $tpl;
	}
	
	// ��������� ������
	// $msg - ���������� ������ 
	// $ifAdminPage - ���� true, �� ������ ������ ������ � �����������, false ������ �������� �������� �����
	/*static private function LoadConfig(&$msg, $ifAdminPage)
	{	
		// �������� �� ���������
		$default = array();
		$default['rss_newscount'] = 30;						// ���������� �������� �� ��������
		$default['rss_descr'] = 'xzengne - rss plugin ';	// �������� ������
		$default['rss_update'] = 120;						// ����� ���������� ������ � �������
		
		$configFile = self::$configDir . self::$configFile;
		if($ifAdminPage === false)
			$configFile = self::$configDirMain . self::$configFile;
		
		if(is_file($configFile) === false)
		{	
			$msg = '���������������� ���� �� ������, ������������ ��������� �� ���������';
			return $default;
		}	
		
		// ��������� ������
		$buf = file_get_contents($configFile);
		$ret = @unserialize($buf);
		if($ret === false)
		{
			$msg = '������ �������� ����������������� �����';
			return $default;
		}
		
		//FIXME: �������� �������� ��������
		
		return $ret;
	}
		*/
	
	/*
	private static function SaveConfig()
	{
		$data = array();
		$data['rss_newscount'] = $_POST['rss_newscount'];
		$data['rss_descr'] = $_POST['rss_descr'];
		$data['rss_update'] = $_POST['rss_update'];
		
		//FIXME: �������� ��������� ������
		
		// ����������
		$buf = serialize($data);
		
		$fileToSave = self::$configDir . self::$configFile;
		return @file_put_contents($fileToSave, $buf);
	}
	*/
	
}

?>
