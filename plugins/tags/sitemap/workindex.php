<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// plugin ��� xzengine
// ������ 1.0 beta
// ����� Nikolay(xzengine team)
// �������������� 
// ������ ���������� ����� ����� ��� google (sitemap.xml)
// ����� ����� ���� ��� � ����� (���� ���� .htaccess ��������)
// ��� � ���������� � ���� (��� ���� ���������� ���� ���������� ���� ������ ����� �������� 777)
// ��������� .htaccess
// ���� ���� ������ �� ������ � ���� .htaccess(��������� �������� ��� �� ��������� �������)
// �� ������� ������� ���� ��������� ������ ���� 
// RewriteRule ^sitemap.xml$ ./plugins/sitemap/index.php
// ���� �������� ������ GZIP_ENABLED � ����� config.php ����������� � 1 
// �� ������� ������ 
// RewriteRule ^sitemap.xml.gz$ ./plugins/sitemap/index.php
// ���� ��� ���� �� ������������ ������ � ���� .htaccess
// �� ����� ������������ ����� ����� � ��������� � � root ����������
// ��� ����� ���� ���������� $use_htacess ���� ��������� �������� false
// � �� ���������� ��� ����� ���������� ���� (������������� ���������� $saveToPath) ���� ����� 777
// ������������ sitemap.xml ����� ��������� on-line ����������� http://www.validome.org/google/validate
// ����� �������� � sitemap ����� �������� http://ru.wikipedia.org/wiki/Sitemaps
////////////////////////////////////////////////////////////////////////////////////////////////////////////


$use_htacess = true;
$saveToPath = '../../../sitemap.xml';			// ���� ��������� ���� ������ � ����� .htasess ������ 
$compressionlevel = 0;						// ������� ���������� 0-10, 0 ��� ���������� , ����������� ������ ��������� ��� ���������� (���� � ������� )
// ��� ��� �� ������ ��������� ������� �� ��� ��������� ������ ������������ ������ (gziped) sitemap �����

define("API_HOME_DIR" ,"../../../modules/textdb/");
define("DB_DIR" ,"../../../admin/backup/");


require_once('../../../config.php');
require_once('../../../modules/database.php');
require_once('../../../modules/gzip.php');
require_once ('../../../modules/textdb/txt-db-api.php');

// ���� $use_htacess - true �� ������� $text � �����
// ����� ������� $text � �������� ����� ������������� $fileHeader
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
	// ������������� header
	header('Content-Type: text/xml');
	
	// �������������� ���������
	ob_start();
	ob_implicit_flush(0);	
}
else
{
	$outputFile = fopen("sitemap.xml","wt");
}
// ���������� ���������

SaveOrWrite($outputFile, '<?xml version="1.0" encoding="UTF-8"?>'."\n", $use_htacess);
SaveOrWrite($outputFile, '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd" xmlns="http://www.google.com/schemas/sitemap/0.84">'."\n", $use_htacess);



         

// ����
SaveOrWrite($outputFile, "\t".'<url>'."\n", $use_htacess);
SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/</loc>'."\n", $use_htacess);
SaveOrWrite($outputFile, "\t\t".'<priority>0.9</priority>'."\n", $use_htacess);	
SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess); 


// ����� ��������� ���������
SaveOrWrite($outputFile, "\t".'<url>'."\n");
SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?feedback</loc>'."\n", $use_htacess);
SaveOrWrite($outputFile, "\t\t".'<priority>0.5</priority>'."\n");	
SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess);

// ���� ��������� ���������� ��������
if(USERS_CAN_ADD_NEWS == 1)
{
	SaveOrWrite($outputFile, "\t".'<url>'."\n", $use_htacess);
	SaveOrWrite($outputFile, "\t\t".'<loc>'.SITE_PATH.'/index.php?addnews</loc>'."\n", $use_htacess);
	SaveOrWrite($outputFile, "\t\t".'<priority>0.5</priority>'."\n", $use_htacess);	
	SaveOrWrite($outputFile, "\t".'</url>'."\n", $use_htacess);		
}

// ���������� �������
$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news';
$res = AbstractDataBase::Instance()->query($q);

// ���������� �������� � �� 
$totalNews = AbstractDataBase::Instance()->num_rows($res);

while($line = AbstractDataBase::Instance()->get_row($res))
{	
	// �������
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
	
	// ������ �� ������ ���������
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

// ��������� ��������
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