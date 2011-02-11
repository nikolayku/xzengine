<?php
//////////////////////////////////////////////
// общие функции 
/////////////////////////////////////////////


/////////////////////////////////////////////
// получает размер директории и всех поддиректорий
/////////////////////////////////////////////
function GetDirectorySize($dir)
{
	$space = 0;
	if (is_dir($dir))
	{	
		$dh = opendir($dir);
		while (($file = readdir($dh)) !== false)
		{		
			if ($file != "." and $file != "..")
			{	
				if(is_file($dir.'/'.$file))
				{		
					$space += filesize($dir.'/'.$file);	
				}
				if(is_dir($dir.'/'.$file))	
					$space += GetDirectorySize($dir.'/'.$file);
			}
		}	
		closedir($dh);
   }
   return $space;
} 


/////////////////////////////////////////////
// получает размер файла (в байтах ) который можно загрузить на сервер
/////////////////////////////////////////////


function GetMaxUplodedFileSize()
{
	$maxsize = ini_get('upload_max_filesize');

	if (!is_numeric($maxsize))
	{
		if (strpos($maxsize, 'M') !== false)
      		$maxsize = intval($maxsize)*1024*1024;
    
		elseif (strpos($maxsize, 'K') !== false)
       		$maxsize = intval($maxsize)*1024;
	
		elseif (strpos($maxsize, 'G') !== false)
       		$maxsize = intval($maxsize)*1024*1024*1024;
	}
	return $maxsize;
}

/////////////////////////////////////////////
// конвертирует байты в мегабайты , килобайты ....
// выводит сконверченное 
//////////////////////////////////////////////
function ConvertBytes($number)
{
	$len = strlen($number);
	
	if($len < 4)
	{
		return sprintf("%d b", $number);
	}
	
	if($len >= 4 && $len <=6)
	{
		return sprintf("%0.2f Kb", $number/1024);
	}
	
	if($len >= 7 && $len <=9)
	{
		return sprintf("%0.2f Mb", $number/1024/1024);
	}
	
	return sprintf("%0.2f Gb", $number/1024/1024/1024);
						
		
}
?>