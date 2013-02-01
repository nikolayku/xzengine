<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2012 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////
// генераци€ sitemap.xml дл€ xzengine

class plugin_sitemap
{	
	private static $pluginName = 'sitemap';								// им€ самого плагина
	private static $pluginUrl = './index.php?plugins=sitemap';			// страница настроек плагина в админпанеле
	private $pathToPlugin;												// путь к директории плагина
	
	// конструктор - основное предназначение инициализировать 
	// $path - путь к директории со скинами
	public function __construct($path)
	{	
		$this->pathToPlugin = $path;
	}

	// возвращ€ет true если тэг или група тегов присуствует на странице
	public function isTagPresent($template)
	{	
		return true;
	}
	
	// делает нужные преобразовани€
	public function ModifyTemplate(&$template)
	{	
		return false;
	}
	
	// возвращ€ет описание плагина - нужно дл€ админпанели 
	public function GetShortDescription()
	{
		return "√енераци€ sitemap.xml";
	}
	
	// функци€ настройки плагина из админпанели
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
	
	// обработка страницы вида (index.php?plugin=rss) на сайте
	// $mainpageTemplate - главна€ страницы
	public function Render($mainpageTemplate)
	{	
		self::GenerateSitemapXml();
		exit();
	}

	//==================== вспомогательные функции
	private static function GenerateSitemapXml()
	{
		// устанавливаем header
		header('Content-Type: text/xml');

		// дополнительные настройки
		ob_start();
		ob_implicit_flush(0);	

		// записываем заголовок
		printf('<?xml version="1.0" encoding="UTF-8"?>'."\n");
		printf('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd" xmlns="http://www.google.com/schemas/sitemap/0.84">'."\n");

		// сайт
		printf("\t".'<url>'."\n");
		printf("\t\t".'<loc>'.SITE_PATH.'/</loc>'."\n");
		printf("\t\t".'<priority>0.9</priority>'."\n");	
		printf("\t".'</url>'."\n"); 

		// форма обратного сообщени€
		printf("\t".'<url>'."\n");
		printf("\t\t".'<loc>'.SITE_PATH.'/index.php?feedback</loc>'."\n");
		printf("\t\t".'<priority>0.5</priority>'."\n");	
		printf("\t".'</url>'."\n");

		// если разрешено добавление новостей
		if(USERS_CAN_ADD_NEWS == 1)
		{
			printf("\t".'<url>'."\n");
			printf("\t\t".'<loc>'.SITE_PATH.'/index.php?addnews</loc>'."\n");
			printf("\t\t".'<priority>0.5</priority>'."\n");	
			printf("\t".'</url>'."\n");		
		}

		// записываем новости
		$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news';
		$res = AbstractDataBase::Instance()->query($q);

		// количество новостей в бд 
		$totalNews = AbstractDataBase::Instance()->num_rows($res);

		while($line = AbstractDataBase::Instance()->get_row($res))
		{	
			// новости
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
			
			// ссылка на читать подробнее
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
		
		// добавл€ем страницы
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
