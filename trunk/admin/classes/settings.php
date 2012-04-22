<?php

// настройки системы


class EngineSettings
{	
	// сохраняет в формате настроек	
	static private function SaveParam($handle, $name, $value, $comment)
	{
		fprintf($handle, "define(\"%s\",\"%s\"); \t\t\t\t\t%s\n",$name, $value, $comment);
	}
	
	// сохраняет конфигурационный файл
	static function SaveConfig($filename = 'test.php')
	{
		$handle = @fopen('../'.$filename, "w");
		
		if(!$handle)
			return 'Невозможно создать конфигурационный файл';
		
		// сохраняем в файл
		fprintf($handle, '<?php'."\n");
		fprintf($handle, '//---------------------------------------------'."\n");
		fprintf($handle, '// config file created at'.date("l dS of F Y h:i:s A")."\n");
		fprintf($handle, '//---------------------------------------------'."\n");
		
		fprintf($handle, "\n".'// Состояние сайта '."\n\n");
		self::SaveParam($handle, 'OFF_SITE', $_POST['OFF_SITE'], '// Отключить сайт');
		self::SaveParam($handle, 'OFF_SITE_MESSAGE', $_POST['OFF_SITE_MESSAGE'], '// Сообщение пользователям');
		
		fprintf($handle, "\n".'// работа с БД'."\n\n");
		
		self::SaveParam($handle, 'DATABASE_HOST', $_POST['DATABASE_HOST'], '// имя хоста с БД');
		self::SaveParam($handle, 'DATABASE_USER', $_POST['DATABASE_USER'], '// пользователь');
		self::SaveParam($handle, 'DATABASE_PASSWORD', $_POST['DATABASE_PASSWORD'], '// пароль');		
		self::SaveParam($handle, 'DATABASE_NAME', $_POST['DATABASE_NAME'], '// имя базы данных');		
		self::SaveParam($handle, 'DATABASE_TBLPERFIX', $_POST['DATABASE_TBLPERFIX'], '// перфикс таблиц при создании');		
		self::SaveParam($handle, 'DATABASE_USEMYSQL',DATABASE_USEMYSQL, '// использование mysql или текстовой бд. устанавливается только при установке, дальнейшее изменение возможно только "руками"');
				
	
		fprintf($handle, "\n".'// настройки языковой поддержки'."\n\n");		
		self::SaveParam($handle, 'SITE_LOC_FILE', $_POST['SITE_LOC_FILE'], '// путь к файлу локализаций для сайта');
		self::SaveParam($handle, 'ADMINPANEL_LOC_FILE', $_POST['ADMINPANEL_LOC_FILE'], '// путь к файлу локализаций для админпанели');

		fprintf($handle, "\n".'// поддержка GZip'."\n\n");		
			
		self::SaveParam($handle, 'GZIP_ENABLED', $_POST['GZIP_ENABLED'], '// поддержка gzip');		
		self::SaveParam($handle, 'GZIP_COMPRESSION', $_POST['GZIP_COMPRESSION'], '// уровень компрессии');
		
		fprintf($handle, "\n".'// Настройки сайта'."\n\n");		
		
		self::SaveParam($handle, 'SITE_PATH', $_POST['SITE_PATH'], '// путь к сайту');
		self::SaveParam($handle, 'NEWSPERPAGE', $_POST['NEWSPERPAGE'], '// количество новостей на странице');
		self::SaveParam($handle, 'SITE_TITLE', $_POST['SITE_TITLE'], '// заголовок сайта');
		self::SaveParam($handle, 'SITE_KEYWORDS', $_POST['SITE_KEYWORDS'], '// ключевые слова');
		self::SaveParam($handle, 'SKIN', $_POST['SKIN'], '// скин для сайта');
		self::SaveParam($handle, 'DATEFORMAT', $_POST['DATEFORMAT'], '// формат даты');		
		self::SaveParam($handle, 'SIMPLY_URL', $_POST['SIMPLY_URL'], '// выдавать ссылку в удобном виде или нет требует возможность записи в файл .htaccess');		
		self::SaveParam($handle, 'USERS_CAN_ADD_NEWS', $_POST['USERS_CAN_ADD_NEWS'], '// Могут ли обычные пользователи добавлять новости');		
					
		fprintf($handle, "\n".'// админпанель'."\n\n");

		self::SaveParam($handle, 'ADMINPANEL_SKIN', $_POST['ADMINPANEL_SKIN'], '// скин по умолчанию для админпанели');		
		self::SaveParam($handle, 'ADMINPANEL_NEWSPERPAGE', $_POST['ADMINPANEL_NEWSPERPAGE'], '// количество новостей на странице редактирования');		
			
		fprintf($handle, "\n".'// загрузка файлов'."\n\n");
		self::SaveParam($handle, 'UPLOADFILE_SIZE', $_POST['UPLOADFILE_SIZE'], '// максимальный размер файла загружаемого на сервер');		
		self::SaveParam($handle, 'UPLOADFILE_DIRECTORY', $_POST['UPLOADFILE_DIRECTORY'], '// директория куда сохранять загруженные файлы');		
		
		fprintf($handle, "\n".'// путь к форуму'."\n\n");
		self::SaveParam($handle, 'FORUM_PATH', $_POST['FORUM_PATH'], '// Путь к форуму , если пост сохраняется в бд , то этот текст заменяется на тег {forum_path}');		
		
		fprintf($handle, "\n".'// настройки администратора'."\n\n");
		self::SaveParam($handle, 'ADMIN_LOGIN', $_POST['ADMIN_LOGIN'], '// логин администратора');
		self::SaveParam($handle, 'ADMIN_PASS', $_POST['ADMIN_PASS'], '// пароль администратора');			
		
		
		fprintf($handle, '?>');	
		
		// обновляем 
		userPriviliges::SetAdminCookies($_POST['ADMIN_LOGIN'], $_POST['ADMIN_PASS'], true);
		
		fflush($handle);
		@fclose($handle);
		
		// FIXME: перенести в локализацию 
		return 'Данные сохранены';		

	}
	
	// загружает конфигурационный файл
	static function LoadSettingsFileAsTemplate(&$main_page_template, $message)
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/settings.tpl");		// шаблон
		
		$JavaScript = 
			'<script type="text/javascript" language="javascript">
			// устанавливает максимальновозможный размер загружаемого файла
			function SetMaxUplodedFileSize(maxuploadfilesize)
			{
				document.getElementById("UPLOADFILE_SIZE").value = maxuploadfilesize;
			}
			</script>';	
		
		// заменяем тег javascript на главной странице
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
		$render_str = str_replace('{ADMINPANEL_LOC_FILE}', self::SkinList('./lang/', ADMINPANEL_LOC_FILE), $render_str);
	
		// {SITE_LOC_FILE}		
		$render_str = str_replace('{SITE_LOC_FILE}', self::SkinList('../lang/', SITE_LOC_FILE), $render_str);
				
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
		$render_str = str_replace('{SKIN}', self::SkinList('../skin/',SKIN ), $render_str);
		
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
		$render_str = str_replace('{ADMINPANEL_SKIN}', self::SkinList('./skin/', ADMINPANEL_SKIN), $render_str);
		
		//{ADMINPANEL_NEWSPERPAGE}
		$render_str = str_replace('{ADMINPANEL_NEWSPERPAGE}', ADMINPANEL_NEWSPERPAGE, $render_str);
		
		//{UPLOADFILE_SIZE}
		$render_str = str_replace('{UPLOADFILE_SIZE}', UPLOADFILE_SIZE, $render_str);
		
		// получаем максимальный размер загружаемого файла в байтах
		$maxuplodedfilesizeinbytes = GetMaxUplodedFileSize();
		//{maxuplodedfilesizeinbytes}
		$render_str = str_replace('{maxuplodedfilesizeinbytes}', $maxuplodedfilesizeinbytes, $render_str);
		//{maxiplodedfilesize}
		$render_str = str_replace('{maxiplodedfilesize}', ConvertBytes($maxuplodedfilesizeinbytes), $render_str);
				

		//{UPLOADFILE_DIRECTORY}
		$render_str = str_replace('{UPLOADFILE_DIRECTORY}', UPLOADFILE_DIRECTORY, $render_str);
		
		//{FORUM_PATH}
		$render_str = str_replace('{FORUM_PATH}', FORUM_PATH, $render_str);
		
		//{ADMIN_LOGIN}
		$render_str = str_replace('{ADMIN_LOGIN}', ADMIN_LOGIN, $render_str);
		
		//{ADMIN_PASS}
		$render_str = str_replace('{ADMIN_PASS}', ADMIN_PASS, $render_str);
		
	
		//{message}
		$render_str = str_replace('{message}', $message, $render_str);
		
		return $render_str;
	}

	// получае список всех скинов в папке
	// $dir - директория где начинать поиск
	// $current - тот файл(директория) который(я) должен(а) быть в списке первым
	// $isFile - если true то вернётся список только файлов , false директорий
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
						
					if ($file != "." && $file != ".." && $file != '.svn' && $value) 
					{ 	
						if($file == $current)	// текущяя директория
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