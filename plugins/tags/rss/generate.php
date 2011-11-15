<?php
////////////////////////////////////////////////////////////
// ��������� Rss ��������
///////////////////////////////////////////////////////////

class RssGen
{	
	// ����� ������ � � ����� ������� ��������
	static function WhatLink($row)
	{	
		$row['news_full_link'] = str_replace("{forum_path}", FORUM_PATH, $row['news_full_link']);
		$row['news_full_link'] = str_replace("{sitepath}", SITE_PATH, $row['news_full_link']);

		if($row['news_full_or_link'] == 1)
		{
			// � ����� ������� �������� 
			if(SIMPLY_URL == 1)
				return  '<![CDATA['.SITE_PATH.'/readmore/'.$row['news_id'].'.htm]]>'."\n";
			else	
				return  '<![CDATA['.SITE_PATH.'/index.php?spage=/'.$row['news_id'].']]>'."\n";
		}	
		
		return '<![CDATA['.$row['news_full_link'].']]>'."\n";
	}	

	// ��������� � ������� Rss �������	
	// $rssNewsCount - ���������� rss �������� ���������� �� ���
	// $rssNewsLivetime - ����� ����� �������� � �������
	// $rssDescrtiption - �������� ������
	static function GenRss($rssNewsCount, $rssNewsLivetime, $rssDescrtiption)
	{	
		// ���������� � ���������  
		header('Content-Type: text/xml; charset=windows-1251');

		// ���������� ���������
		echo '<?xml version="1.0" encoding="windows-1251"?>'."\n";
		echo '<rss version="2.0">'."\n";
		echo '<channel>'."\n";
		echo '<title><![CDATA['.htmlspecialchars(SITE_TITLE, ENT_QUOTES).']]></title>'."\n";	
		echo '<link><![CDATA['.htmlspecialchars(SITE_PATH, ENT_QUOTES).']]></link>'."\n";		
		echo '<description><![CDATA['.htmlspecialchars($rssDescrtiption, ENT_QUOTES).']]></description>'."\n";	
		echo '<ttl>'.$rssNewsLivetime.'</ttl>'."\n";	
		echo '<generator>xzengine</generator>'."\n";
		
		// ���������� ���� RSS
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_show_in_category = 0 ORDER BY news_id DESC  LIMIT '.$rssNewsCount );			
		
		while($line = AbstractDataBase::Instance()->get_row($result))
			self::RssBody($line);
		
		echo "".'</channel>'."\n";
		echo '</rss>';

	}
		
	////////////////////////////////////////
	// ������� Rss
	////////////////////////////////////////
	static function RssBody($row)
	{
		echo '<item>'."\n";
		echo '<title>'.htmlspecialchars($row['news_name'], ENT_QUOTES).'</title>'."\n";
		
		// �������� ���� ���� � ������ � �����

		echo '<link>'.self::WhatLink($row).'</link>'."\n";
		
		// �������� ���� ���� � ������ � �����
		$row['news_sh_description'] = str_replace("{forum_path}", FORUM_PATH, $row['news_sh_description']);
		$row['news_sh_description'] = str_replace("{sitepath}", SITE_PATH, $row['news_sh_description']);
		echo '<description><![CDATA['.$row['news_sh_description'].']]></description>'."\n";
		
		echo '<guid>'.self::WhatLink($row).'</guid>'."\n";
		
		echo '<pubDate>'.date("r", $row['news_date']).'</pubDate>'."\n";
		echo '</item>'."\n";
	}	
}

?>