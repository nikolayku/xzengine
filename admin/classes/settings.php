<?php
/////////////////////////////////////////////////////////////////
// ��������� �������
/////////////////////////////////////////////////////////////////

class EngineSettings
{	
	///////////////////////////////
	// ��������� � ������� ��������
	///////////////////////////////		
	function SaveParam($handle, $name, $value, $comment)
	{
		fprintf($handle, "define(\"%s\",\"%s\"); \t\t\t\t\t%s\n",$name, $value, $comment);
	}
	
	/////////////////////////////////
	// ��������� ���������������� ����
	/////////////////////////////////	
	function SaveConfig($filename = 'test.php')
	{
		$handle = @fopen('../'.$filename, "w");
		
		if(!$handle)
			return '���������� ������� ���������������� ����';
		
		// ��������� � ����
		fprintf($handle, '<?php'."\n");
		fprintf($handle, '//---------------------------------------------'."\n");
		fprintf($handle, '// ���� �������� ������ '.date("l dS of F Y h:i:s A")."\n");
		fprintf($handle, '//---------------------------------------------'."\n");
		
		fprintf($handle, "\n".'// ��������� ����� '."\n\n");
		$this->SaveParam($handle, 'OFF_SITE', $_POST['OFF_SITE'], '// ��������� ����');
		$this->SaveParam($handle, 'OFF_SITE_MESSAGE', $_POST['OFF_SITE_MESSAGE'], '// ��������� �������������');
		$this->SaveParam($handle, 'DEBUG_MODE', $_POST['DEBUG_MODE'], '// ��������� debug ������');
		
		fprintf($handle, "\n".'// ������ � ��'."\n\n");
		
		$this->SaveParam($handle, 'DATABASE_HOST', $_POST['DATABASE_HOST'], '// ��� ����� � ��');
		$this->SaveParam($handle, 'DATABASE_USER', $_POST['DATABASE_USER'], '// ������������');
		$this->SaveParam($handle, 'DATABASE_PASSWORD', $_POST['DATABASE_PASSWORD'], '// ������');		
		$this->SaveParam($handle, 'DATABASE_NAME', $_POST['DATABASE_NAME'], '// ��� ���� ������');		
		$this->SaveParam($handle, 'DATABASE_TBLPERFIX', $_POST['DATABASE_TBLPERFIX'], '// ������� ������ ��� ��������');		
		$this->SaveParam($handle, 'DATABASE_USEMYSQL',DATABASE_USEMYSQL, '// ������������� mysql ��� ��������� ��. ��������������� ������ ��� ���������, ���������� ��������� �������� ������ "������"');
				
	
		fprintf($handle, "\n".'// ��������� �������� ���������'."\n\n");		
		$this->SaveParam($handle, 'SITE_LOC_FILE', $_POST['SITE_LOC_FILE'], '// ���� � ����� ����������� ��� �����');
		$this->SaveParam($handle, 'ADMINPANEL_LOC_FILE', $_POST['ADMINPANEL_LOC_FILE'], '// ���� � ����� ����������� ��� �����������');

		fprintf($handle, "\n".'// ��������� GZip'."\n\n");		
			
		$this->SaveParam($handle, 'GZIP_ENABLED', $_POST['GZIP_ENABLED'], '// ��������� gzip');		
		$this->SaveParam($handle, 'GZIP_COMPRESSION', $_POST['GZIP_COMPRESSION'], '// ������� ����������');
		
		fprintf($handle, "\n".'// ��������� �����'."\n\n");		
		
		$this->SaveParam($handle, 'SITE_PATH', $_POST['SITE_PATH'], '// ���� � �����');
		$this->SaveParam($handle, 'NEWSPERPAGE', $_POST['NEWSPERPAGE'], '// ���������� �������� �� ��������');
		$this->SaveParam($handle, 'SITE_TITLE', $_POST['SITE_TITLE'], '// ��������� �����');
		$this->SaveParam($handle, 'SITE_KEYWORDS', $_POST['SITE_KEYWORDS'], '// �������� �����');
		$this->SaveParam($handle, 'SKIN', $_POST['SKIN'], '// ���� ��� �����');
		$this->SaveParam($handle, 'DATEFORMAT', $_POST['DATEFORMAT'], '// ������ ����');		
		$this->SaveParam($handle, 'SIMPLY_URL', $_POST['SIMPLY_URL'], '// �������� ������ � ������� ���� ��� ��� ������� ����������� ������ � ���� .htaccess');		
		$this->SaveParam($handle, 'USERS_CAN_ADD_NEWS', $_POST['USERS_CAN_ADD_NEWS'], '// ����� �� ������� ������������ ��������� �������');		
					

		fprintf($handle, "\n".'// �����������'."\n\n");

		$this->SaveParam($handle, 'ADMINPANEL_SKIN', $_POST['ADMINPANEL_SKIN'], '// ���� �� ��������� ��� �����������');		
		$this->SaveParam($handle, 'ADMINPANEL_NEWSPERPAGE', $_POST['ADMINPANEL_NEWSPERPAGE'], '// ���������� �������� �� �������� ��������������');		
		
		fprintf($handle, "\n".'// Rss ���������'."\n\n");
		
		$this->SaveParam($handle, 'RSS_NEWS', $_POST['RSS_NEWS'], '// ������� ����� ���������� ��������');		
		$this->SaveParam($handle, 'RSS_DESCRIPTION', $_POST['RSS_DESCRIPTION'], '// �������� �������');		
		$this->SaveParam($handle, 'RSS_LIVETIME', $_POST['RSS_LIVETIME'], '// ����� ����� ������� ������� ��������� ���������� Rss ������');		
		
		fprintf($handle, "\n".'// �������� ������'."\n\n");
		$this->SaveParam($handle, 'UPLOADFILE_SIZE', $_POST['UPLOADFILE_SIZE'], '// ������������ ������ ����� ������������ �� ������');		
		$this->SaveParam($handle, 'UPLOADFILE_DIRECTORY', $_POST['UPLOADFILE_DIRECTORY'], '// ���������� ���� ��������� ����������� �����');		
		
		fprintf($handle, "\n".'// ���� � ������'."\n\n");
		$this->SaveParam($handle, 'FORUM_PATH', $_POST['FORUM_PATH'], '// ���� � ������ , ���� ���� ����������� � �� , �� ���� ����� ���������� �� ��� {forum_path}');		
		
		
		
		fprintf($handle, '?>');	
		
		fflush($handle);
		@fclose($handle);
		
		
		
		return '������ ���������';		

	}
	
	//////////////////////////////
	// ��������� ���������������� ����
	//////////////////////////////
	function LoadSettingsFileAsTemplate(&$main_page_template, $message)
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/settings.tpl");		// ������
		
		$JavaScript = 
'<script type="text/javascript" language="javascript">
// ������������� �������������������� ������ ������������ �����
function SetMaxUplodedFileSize(maxuploadfilesize)
{
	document.getElementById("UPLOADFILE_SIZE").value = maxuploadfilesize;
}
</script>';	
		
		// �������� ��� javascript �� ������� ��������
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);	
			
		//{OFF_SITE_MESSAGE} 
		$render_str = str_replace('{OFF_SITE_MESSAGE}', OFF_SITE_MESSAGE, $render_str);
		
		//{OFF_SITE}
		$str = "";	
		if(OFF_SITE)
			$str = '<option value="1">Yes</option><option value="0">No</option>';
		else	
			$str = '<option value="0">No</option><option value="1">Yes</option>'; 
		$render_str = str_replace('{OFF_SITE}', $str, $render_str);	
		
		//{DEBUG_MODE}
		$str = "";	
		if(DEBUG_MODE)
			$str = '<option value="1">Yes</option><option value="0">No</option>';
		else	
			$str = '<option value="0">No</option><option value="1">Yes</option>'; 
		$render_str = str_replace('{DEBUG_MODE}', $str, $render_str);		
	
		//{DATABASE_HOST} 
		$render_str = str_replace('{DATABASE_HOST}', DATABASE_HOST, $render_str);
			
		//{DATABASE_HOST} 
		$render_str = str_replace('{DATABASE_USER}', DATABASE_USER, $render_str);
		
		//{DATABASE_PASSWORD} 
		$render_str = str_replace('{DATABASE_PASSWORD}', DATABASE_PASSWORD, $render_str);	
	
		//{DATABASE_NAME} 
		$render_str = str_replace('{DATABASE_NAME}', DATABASE_NAME, $render_str);	
		
		//{DATABASE_TBLPERFIX} 
		$render_str = str_replace('{DATABASE_TBLPERFIX}', DATABASE_TBLPERFIX, $render_str);
		
		//{GZIP_ENABLED}
		$str = "";	
		if(GZIP_ENABLED)
			$str = '<option value="1">On</option><option value="0">Off</option>';
		else	
			$str = '<option value="0">Off</option><option value="1">On</option>'; 
		$render_str = str_replace('{GZIP_ENABLED}', $str, $render_str);
		
		// {ADMINPANEL_LOC_FILE}		
		$render_str = str_replace('{ADMINPANEL_LOC_FILE}', $this->SkinList('./lang/', ADMINPANEL_LOC_FILE), $render_str);
	
		// {SITE_LOC_FILE}		
		$render_str = str_replace('{SITE_LOC_FILE}', $this->SkinList('../lang/', SITE_LOC_FILE), $render_str);
				
		//{GZIP_COMPRESSION}
		$render_str = str_replace('{GZIP_COMPRESSION}', GZIP_COMPRESSION, $render_str);

		//{SITE_PATH}
		$render_str = str_replace('{SITE_PATH}', SITE_PATH, $render_str);
		
		//{NEWSPERPAGE}
		$render_str = str_replace('{NEWSPERPAGE}', NEWSPERPAGE, $render_str);
		
		//{SITE_TITLE}
		$render_str = str_replace('{SITE_TITLE}', SITE_TITLE, $render_str);
		
		//{SITE_KEYWORDS}
		$render_str = str_replace('{SITE_KEYWORDS}', SITE_KEYWORDS, $render_str);
		
		//{SKIN}
		$render_str = str_replace('{SKIN}', $this->SkinList('../skin/',SKIN ), $render_str);
		
		//{DATEFORMAT}
		$render_str = str_replace('{DATEFORMAT}', DATEFORMAT, $render_str);
		
		//{SIMPLY_URL}
		$str = "";	
		if(SIMPLY_URL)
			$str = '<option value="1">On</option><option value="0">Off</option>';
		else	
			$str = '<option value="0">Off</option><option value="1">On</option>'; 
		
		$render_str = str_replace('{SIMPLY_URL}', $str, $render_str);		
		
		//{USERS_CAN_ADD_NEWS}
		$str = "";	
		if(USERS_CAN_ADD_NEWS)
			$str = '<option value="1">Yes</option><option value="0">No</option>';
		else	
			$str = '<option value="0">No</option><option value="1">Yes</option>'; 
		
		$render_str = str_replace('{USERS_CAN_ADD_NEWS}', $str, $render_str);		
				

		//{ADMINPANEL_SKIN}
		$render_str = str_replace('{ADMINPANEL_SKIN}', $this->SkinList('./skin/', ADMINPANEL_SKIN), $render_str);
		
		//{ADMINPANEL_NEWSPERPAGE}
		$render_str = str_replace('{ADMINPANEL_NEWSPERPAGE}', ADMINPANEL_NEWSPERPAGE, $render_str);
		
		//{RSS_NEWS}
		$render_str = str_replace('{RSS_NEWS}', RSS_NEWS, $render_str);
		
		//{RSS_DESCRIPTION}
		$render_str = str_replace('{RSS_DESCRIPTION}', RSS_DESCRIPTION, $render_str);
		
		//{RSS_LIVETIME}
		$render_str = str_replace('{RSS_LIVETIME}', RSS_LIVETIME, $render_str);
		
		//{UPLOADFILE_SIZE}
		$render_str = str_replace('{UPLOADFILE_SIZE}', UPLOADFILE_SIZE, $render_str);
		
		// �������� ������������ ������ ������������ ����� � ������
		$maxuplodedfilesizeinbytes = GetMaxUplodedFileSize();
		//{maxuplodedfilesizeinbytes}
		$render_str = str_replace('{maxuplodedfilesizeinbytes}', $maxuplodedfilesizeinbytes, $render_str);
		//{maxiplodedfilesize}
		$render_str = str_replace('{maxiplodedfilesize}', ConvertBytes($maxuplodedfilesizeinbytes), $render_str);
				

		//{UPLOADFILE_DIRECTORY}
		$render_str = str_replace('{UPLOADFILE_DIRECTORY}', UPLOADFILE_DIRECTORY, $render_str);
		
		//{FORUM_PATH}
		$render_str = str_replace('{FORUM_PATH}', FORUM_PATH, $render_str);
		
	
		//{message}
		$render_str = str_replace('{message}', $message, $render_str);
		

		
		return $render_str;
	}

	/////////////////////////////////////
	// ������� ������ ���� ������ � �����
	// $dir - ���������� ��� �������� �����
	// $current - ��� ����(����������) �������(�) ������(�) ���� � ������ ������
	// $isFile - ���� true �� ������� ������ ������ ������ , false ����������
	////////////////////////////////////
	static function SkinList($dir='./skins/', $current = '', $isFile = false)
	{	
		$out = '';
		if (is_dir($dir)) 
		{
			if ($dh = opendir($dir)) 
			{	
				
				while (($file = readdir($dh)) !== false) 
				{	
					$value = ($isFile) ? is_file($dir.$file) : is_dir($dir.$file);
						
					if ($file != "." && $file != ".." && $value) 
					{ 	
						if($file == $current)	// ������� ����������
							$out = '<option value="'.$file.'">'.$file.'</option>'.$out;	
						else					
							$out .= '<option value="'.$file.'">'.$file.'</option>';
					}	
				}
				closedir($dh);
			}
		}
		return $out;
	}		
			
}	


?>