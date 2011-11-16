<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ��������� rss ��� xzengine

class plugin_rss
{	
	private static $pluginName = 'rss';								// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=rss';			// �������� �������� ������� � �����������
	private static $configFile = 'config.txt';						// ���� � �����������
	private static $configDir = '../temp/plugins/rss/';				// ���������� � �����������(������������ admin )
	private static $configDirMain = './temp/plugins/rss/';				// ���������� � �����������(������������ ������� �������� )
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
		//FIXME: ����������� ��� {rss}
		return false;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		//FIXME: ����������� ��� {rss}
		return;
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "Rss �������";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		$message = "";
				
		// �������� ������� ���������� ��� �������� �������
		
		if(is_dir(self::$configDir) == false)
		{
			if(mkdir(self::$configDir, 0777, true) === false)
				$message .= '���������� ������� ���������� ��� ���������� ��������';
		}
		
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
		
		return $this->LoadTemplate($values, $message);
	}
	
	// ��������� �������� ���� (index.php?plugin=rss) �� �����
	// $mainpageTemplate - ������� ��������
	public function Render($mainpageTemplate)
	{	
		// ��������� ����������� .php �����
		require_once($this->pathToPlugin.'/generate.php');
		
		$settings = self::LoadConfig($msg, false);
		
		// ��������� rss
		RssGen::GenRss($settings['rss_newscount'], $settings['rss_update'], $settings['rss_descr']);
		
		// ��� �� ���� ���������� ��������� �������
		exit();
	}
	
	//========================================================================
	
	// ��������� ������
	// $msg - ���������� ������ 
	// $ifAdminPage - ���� true, �� ������ ������ ������ � �����������, false ������ �������� �������� �����
	static private function LoadConfig(&$msg, $ifAdminPage)
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
	
	private function LoadTemplate($values, $message)
	{
		$tpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// �������� ����
		// {message}
		$tpl = str_replace('{message}', $message, $tpl);
		
		// {rss_newscount}
		$tpl = str_replace('{rss_newscount}', $values['rss_newscount'], $tpl);
		
		// {rss_descr}
		$tpl = str_replace('{rss_descr}', $values['rss_descr'], $tpl);
		
		// {rss_update}
		$tpl = str_replace('{rss_update}', $values['rss_update'], $tpl);
		
		// {rss_edit} - ��� 
		$tpl = str_replace('{rss_edit}', self::$pluginUrl.'&save', $tpl);
		
		return $tpl;
	}
	
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
	
}

?>
