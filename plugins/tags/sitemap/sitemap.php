<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2012 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// ��������� sitemap.xml ��� xzengine

class plugin_sitemap
{	
	private static $pluginName = 'sitemap';								// ��� ������ �������
	private static $pluginUrl = './index.php?plugins=sitemap';			// �������� �������� ������� � �����������
	private $pathToPlugin;												// ���� � ���������� �������
	
	// ����������� - �������� �������������� ���������������� 
	// $path - ���� � ���������� �� �������
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
	}

	// ���������� true ���� ��� ��� ����� ����� ����������� �� ��������
	public function isTagPresent($template)
	{	
		return true;
	}
	
	// ������ ������ ��������������
	public function ModifyTemplate(&$template)
	{	
		return false;
	}
	
	// ���������� �������� ������� - ����� ��� ����������� 
	public function GetShortDescription()
	{
		return "��������� sitemap.xml";
	}
	
	// ������� ��������� ������� �� �����������
	public function Admin()
	{	
		$tpl = file_get_contents($this->pathToPlugin.'/settings.tpl');
		
		// {sitepath_link}
		$link = SITE_PATH."/index.php?plugin=sitemap";
		if(SIMPLY_URL == 1)
			$link = SITE_PATH."/sitemap.xml";
		$tpl = str_replace("{sitepath_link}", $link, $tpl);
		
		$url = urlencode($link);
		$tpl = str_replace("{google_sitemap}", "http://google.com/webmasters/sitemaps/ping?sitemap=".$link, $tpl);
		$tpl = str_replace("{yandex_sitemap}", "http://webmaster.yandex.ru/wmconsole/sitemap_list.xml?host=".$link, $tpl);
		$tpl = str_replace("{yahoo_sitemap}", "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=SitemapWriter&url= ".$link, $tpl);
		$tpl = str_replace("{askcom_sitemap}", "http://submissions.ask.com/ping?sitemap=".$link, $tpl);
		$tpl = str_replace("{bing_sitemap}", "http://www.bing.com/webmaster/ping.aspx?siteMap=".$link, $tpl);
		
		return $tpl;
		
	}
	
	// ��������� �������� ���� (index.php?plugin=rss) �� �����
	// $mainpageTemplate - ������� ��������
	public function Render($mainpageTemplate)
	{	
		self::GenerateSitemapXml();
		exit();
	}

	//==================== ��������������� �������
	private static function GenerateSitemapXml()
	{
		// ������������� header
		header('Content-Type: text/xml');

		// �������������� ���������
		ob_start();
		ob_implicit_flush(0);	

		// ���������� ���������
		printf('<?xml version="1.0" encoding="UTF-8"?>'."\n");
		printf('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd" xmlns="http://www.google.com/schemas/sitemap/0.84">'."\n");

		// ����
		printf("\t".'<url>'."\n");
		printf("\t\t".'<loc>'.SITE_PATH.'/</loc>'."\n");
		printf("\t\t".'<priority>0.9</priority>'."\n");	
		printf("\t".'</url>'."\n"); 

		// ����� ��������� ���������
		printf("\t".'<url>'."\n");
		printf("\t\t".'<loc>'.SITE_PATH.'/index.php?feedback</loc>'."\n");
		printf("\t\t".'<priority>0.5</priority>'."\n");	
		printf("\t".'</url>'."\n");

		// ���� ��������� ���������� ��������
		if(USERS_CAN_ADD_NEWS == 1)
		{
			printf("\t".'<url>'."\n");
			printf("\t\t".'<loc>'.SITE_PATH.'/index.php?addnews</loc>'."\n");
			printf("\t\t".'<priority>0.5</priority>'."\n");	
			printf("\t".'</url>'."\n");		
		}

		// ���������� �������
		$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news';
		$res = AbstractDataBase::Instance()->query($q);

		// ���������� �������� � �� 
		$totalNews = AbstractDataBase::Instance()->num_rows($res);

		while($line = AbstractDataBase::Instance()->get_row($res))
		{	
			// �������
			printf("\t".'<url>'."\n");
			if(SIMPLY_URL == 1)
			{
				printf("\t\t".'<loc>'.SITE_PATH.'/news/'.$line['news_id'].'.htm</loc>'."\n");
				printf("\t\t".'<priority>0.8</priority>'."\n");	
			}
			else
			{
				printf("\t\t".'<loc>'.SITE_PATH.'/index.php?news='.$line['news_id'].'</loc>'."\n");
				printf("\t\t".'<priority>0.8</priority>'."\n");
			}
			printf("\t".'</url>'."\n");
			
			// ������ �� ������ ���������
			if($line['news_full_or_link'] == 1)
			{
				printf("\t".'<url>'."\n");
				if(SIMPLY_URL == 1)
				{
					printf("\t\t".'<loc>'.SITE_PATH.'/readmore/'.$line['news_id'].'.htm</loc>'."\n");
					printf("\t\t".'<priority>0.8</priority>'."\n");	
				}
				else
				{
					printf("\t\t".'<loc>'.SITE_PATH.'/index.php?readmore='.$line['news_id'].'</loc>'."\n");
					printf("\t\t".'<priority>0.8</priority>'."\n");
				}

				printf("\t".'</url>'."\n");
			}	

		}
		
		// ��������� ��������
		if($totalNews)
		{
			$pagesNum = ceil($totalNews/NEWSPERPAGE);
			
			for($p = 0; $p < $pagesNum; $p++)
			{
				printf("\t".'<url>'."\n");
				printf("\t\t".'<loc>'.SITE_PATH.'/index.php?page='.$p.'</loc>'."\n");
				printf("\t\t".'<priority>0.9</priority>'."\n");
				printf("\t".'</url>'."\n");
			}	
		}
		printf('</urlset>'."\n");
		
	}
	
}

?>
