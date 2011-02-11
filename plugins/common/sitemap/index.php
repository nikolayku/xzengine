<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// plugin для xzengine
// версия 1.0 beta
// автор Nikolay(xzengine team)
// Предназначение 
// плагин генерирует карту сайта для google (sitemap.xml)
// Вывод может быть как в поток (если файл .htaccess настроен)
// так и сохранение в файл (при этом директория куда сораняется файл должна иметь атрибуты 777)
// настройка .htaccess
// если есть доступ на запись в файл .htaccess(некоторые хостинги это не позволяют сделать)
// то следует добавть туда следующюю строку вида 
// RewriteRule ^sitemap.xml$ ./plugins/sitemap/index.php
// если включено сжатие GZIP_ENABLED в файле config.php установлена в 1 
// то следует писать 
// RewriteRule ^sitemap.xml.gz$ ./plugins/sitemap/index.php
// Если Ваш хост не поддерживает запись в файл .htaccess
// то можно генерировать карту сайта и сохранять её в root директории
// для этого ниже переменной $use_htacess надо присвоить значение false
// и на директорию где будет расположен файл (определяеммый переменной $saveToPath) дать права 777
// генерируемый sitemap.xml можно проверить on-line валидатором http://www.validome.org/google/validate
// Более подробно о sitemap можно почитать http://ru.wikipedia.org/wiki/Sitemaps
////////////////////////////////////////////////////////////////////////////////////////////////////////////


$use_htacess = true;
$saveToPath = '../../../sitemap.xml';			// куда сохранять если доступ к файлу .htasess закрыт 
$compressionlevel = 0;						// уровень компрессии 0-10, 0 нет компрессии , установлена разные настройки для компрессии (сайт и плагина )
// так как на момент написания плигина не все поисковые машины поддерживали сжатые (gziped) sitemap файлы

define("API_HOME_DIR" ,"../../../modules/textdb/");
define("DB_DIR" ,"../../../admin/backup/");


require_once('../../../config.php');
require_once('../../../modules/database.php');
require_once('../../../modules/gzip.php');
require_once ('../../../modules/textdb/txt-db-api.php');

// если $use_htacess - true то выводит $text в поток
// иначе выводит $text в файловый поток установленный $fileHeader
function SaveOrWrite($fileHeader, $text, $use_htacess = true)
{
	if($use_htacess == true)
		printf($text);
	else
		fwrite($fileHeader, $text);
}



$outputFile = '';

if($use_htacess)
{
	// устанавливаем header
	header('Content-Type: text/xml');
	
	// дополнительные настройки
	ob_start();
	ob_implicit_flush(0);	
}
else
{
	$outputFile = fopen("sitemap.xml","wt");
}
// записываем заголовок

SaveOrWrite($outputFile, '<?xml version="1.0" encoding="UTF-8"?>'."\n", $use_htacess);
SaveOrWrite($outputFile, '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd" xmlns="http://www.google.com/schemas/sitemap/0.84">'."\n", $use_htacess);



         

// сайт
SaveOrWrite($outputFile, "\t".'<url>'."\n", $use_htacess);
SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/</loc>'."\n", $use_htacess);
SaveOrWrite($outputFile, "\t\t".'<priority>0.9</priority>'."\n", $use_htacess);	
SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess); 


// форма обратного сообщения
SaveOrWrite($outputFile, "\t".'<url>'."\n");
SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?feedback</loc>'."\n", $use_htacess);
SaveOrWrite($outputFile, "\t\t".'<priority>0.5</priority>'."\n");	
SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess);

// если разрешено добавление новостей
if(USERS_CAN_ADD_NEWS == 1)
{
	SaveOrWrite($outputFile, "\t".'<url>'."\n", $use_htacess);
	SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?addnews</loc>'."\n", $use_htacess);
	SaveOrWrite($outputFile, "\t\t".'<priority>0.5</priority>'."\n", $use_htacess);	
	SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess);		
}

// записываем новости
$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news';
$res = AbstractDataBase::Instance()->query($q);

// количество новостей в бд 
$totalNews = AbstractDataBase::Instance()->num_rows($res);

while($line = AbstractDataBase::Instance()->get_row($res))
{	
	// новости
	SaveOrWrite($outputFile, "\t".'<url>'."\n");
	if(SIMPLY_URL == 1)
	{
		SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/news/'.$line['news_id'].'.htm</loc>'."\n", $use_htacess);
		SaveOrWrite($outputFile, "\t\t".'<priority>0.8</priority>'."\n", $use_htacess);	
	}
	else
	{
		SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?news='.$line['news_id'].'</loc>'."\n", $use_htacess);
		SaveOrWrite($outputFile, "\t\t".'<priority>0.8</priority>'."\n", $use_htacess);
	}
	SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess);
	
	// ссылка на читать подробнее
	if($line['news_full_or_link'] == 1)
	{
		SaveOrWrite($outputFile, "\t".'<url>'."\n", $use_htacess);
		if(SIMPLY_URL == 1)
		{
			SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/readmore/'.$line['news_id'].'.htm</loc>'."\n", $use_htacess);
			SaveOrWrite($outputFile, "\t\t".'<priority>0.8</priority>'."\n", $use_htacess);	
		}
		else
		{
			SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?readmore='.$line['news_id'].'</loc>'."\n", $use_htacess);
			SaveOrWrite($outputFile, "\t\t".'<priority>0.8</priority>'."\n", $use_htacess);
		}

		SaveOrWrite($outputFile, "\t".'</url>'."\n");
	}	

}

// добавляем страницы
if($totalNews)
{
	$pagesNum = ceil($totalNews/NEWSPERPAGE);
	
	for($p = 0; $p < $pagesNum; $p++)
	{
		SaveOrWrite($outputFile, "\t".'<url>'."\n", $use_htacess);
		SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?page='.$p.'</loc>'."\n", $use_htacess);
		SaveOrWrite($outputFile, "\t\t".'<priority>0.9</priority>'."\n", $use_htacess);
		SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess);
	}	
}



SaveOrWrite($outputFile, '</urlset>'."\n", $use_htacess);

if($use_htacess)
{	
	if( $compressionlevel != 0)
	{
		$z = new GZip();
		$z->UseGZip($compressionlevel);
	}
}
else
{
	fclose($outputFile);
}

?>