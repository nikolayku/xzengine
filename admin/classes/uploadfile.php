<?php

///////////////////////////////////////////////////////////////////
// загружаемые файлы
///////////////////////////////////////////////////////////////////

class UploadFile
{	
	function DeleteUploadFile($filename)
	{	
		$filename = '../'.UPLOADFILE_DIRECTORY.'/'.urldecode($filename);
		
		if(file_exists($filename))
			unlink($filename);
				
		
	}	
	
	///////////////////////////////////////////
	// получает содержимое директории с загруженными файлами
	///////////////////////////////////////////
	function GetUploadDirectoryList(&$main_page_template)
	{	
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/uploadfilelist.tpl");
		$handle = opendir('../'.UPLOADFILE_DIRECTORY); 
		$find = false;	// если найден хотябы один файл
		
		$JavaScript = 
'<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
// link to page
function link_to_post(filename)
{
	temp = prompt( "Ссылка для копирования", "{sitepath_admin}/'.UPLOADFILE_DIRECTORY.'/" + filename );
	return false;
}
</script>';	
		
			
		// заменяем тег javascript на главной странице
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);	
		
		$ret = '';
		while (false !== ($file = readdir($handle)))
		{	
			if ($file != "." && $file != ".." &&!is_dir($file) && $file != "index.php")
			{	
				$find = true; 
				$temp = $template;
				
				// заменяем теги
				// {filename}
				$temp = str_replace("{filename}", $file, $temp);
			
				// {filelink}
				$temp = str_replace("{filelink}", SITE_PATH.'/'.UPLOADFILE_DIRECTORY.'/'.$file, $temp);
				
				//{deleteurl}	
				$temp = str_replace("{deleteurl}", urlencode($file), $temp);
									

				$ret = $ret.$temp;
			} 
		}
		closedir($handle);
		if($find)
			return  $ret;

		return 'Директория '.UPLOADFILE_DIRECTORY.' не содержит файлов ';
	} 
	
	
	///////////////////////////////////////////
	// загружает шаблон
	///////////////////////////////////////////
	function LoadTemplate($message)
	{
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/uploadfileform.tpl");
		
		// {maxfilesize}	
		$template = str_replace("{maxfilesize}", UPLOADFILE_SIZE, $template);
		
		// {maxfilesize}	
		$template = str_replace("{maxfilesize_str}", ConvertBytes(UPLOADFILE_SIZE), $template);		

		// {message}	
		$template = str_replace("{message}", $message, $template);
		
		return $template;
		
	}

	///////////////////////////////////////////
	// обрабатывает загруженный файл
	// возвращяет строку с сообщением о результатах загрузки
	///////////////////////////////////////////
	function ParseUplodedFile()
	{	
		$filename = $_FILES['uploadfilename']['name'];
		
		if(!is_uploaded_file($_FILES['uploadfilename']['tmp_name']))
			return 'Файл не загружен. Возможно файл имеет слишком большой размер или произошёл разрыв соединения';	
		
		// создаём уникальное имя файла
		if($_POST['uniquefilename'] == 1)	
			$filename = time().rand(0, 100).$_FILES['uploadfilename']['name'];
		
		
		if(!move_uploaded_file($_FILES['uploadfilename']['tmp_name'], '../'.UPLOADFILE_DIRECTORY.'/'.$filename))
			return 'Невозможно перенести файл';
				

		return 'Файл <a href="../'.UPLOADFILE_DIRECTORY.'/'.$filename.'">'.$_FILES['uploadfilename']['name'].'</a> загружен.';
		
	}	
}

?>