<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////



class showfullnews
{	
	//////////////////////////////////////
	// конструктор
	//////////////////////////////////////
	function __construct()
	{	
	}		

	//////////////////////////////////////
	// показывает шаблон с постоянной ссылкой
	// $template - шаблон главной страницы для замена тегов заголовка и тд
	/////////////////////////////////////
	function ShowFullNews($id, &$template = '')
	{	
		
		$error = '';	
		
		if(is_numeric($id) && $id > 0)
		{
			$t = file_get_contents("./skin/".SKIN."/templates/newsshowfull.tpl");
			
				
			
			$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_id='.$id.' LIMIT 1';	
			$result = AbstractDataBase::Instance()->query($q );	
			
			if(!$result)
				return $error;
			
			$newsfound = AbstractDataBase::Instance()->get_row($result);	
			
			if(!$newsfound)
				return $error;
				
			$this->replaceTags($t, $newsfound);	
			
			// заменяет тег {keywords} главной страницы	 	
			// {keywords} 
			$template = str_replace("{keywords}", $newsfound['news_keyword'], $template);			

			// заменяем тег {title} главной страницы	
			// {title} 
			$template = str_replace("{title}", $newsfound['news_name'], $template);
			
			return $t;
		}
		
		return $error;
	}


	/////////////////////
	// заменяет все теги возвращяет шаблон с заменеными тегами
	////////////////////

	function replaceTags(&$template, $row)
	{
		// {newsname} 
		$template = str_replace("{newsname}", $row['news_name'], $template);
		
		// {newsshowfull}  
		$template = str_replace("{newsshowfull}", $row['news_showfull'], $template);
		
		// {keywords} 
		$template = str_replace("{keywords}", $row['news_keyword'], $template);	
	
		// {newsdate}  
		$timest = $row['news_date'];
		$template = str_replace("{newsdate}", date(DATEFORMAT, $timest), $template);
		
		// {newsautor}   
		$template = str_replace("{newsautor}", $row['news_autor'], $template);
	
		// {descrlink}
		if(SIMPLY_URL)   
			$template = str_replace("{descrlink}", '{sitepath}/news/'.$row['news_id'].'.htm', $template);
		else
			$template = str_replace("{descrlink}", '{sitepath}/index.php?news='.$row['news_id'], $template);

		
	}
	
	///////////////////////
	// заменяет шаблоны {lastpage} {nextpage} 
	///////////////////////
	function getPagesGrild($template, $isdraw = true, $newsperpage = 5, $page=0, $category = 0)
	{
		if(!$isdraw)
		{
			$template = str_replace("{lastpage}", "", $template);
			$template = str_replace("{nextpage}", "", $template);
			return $template;
		}
		
		
		$result = '';
		
		// подсчитываем количество всех страниц	
		if($category == 0)
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_view = 1 ' );
		else
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_view = 1 AND news_category='.$category );
			
				

		if(!$result)
			return "";
		
		$news = AbstractDataBase::Instance()->num_rows($result);
		
		if(($news < $newsperpage))
			$pages = 0;
		else
			$pages = ceil($news/$newsperpage);

		if($page >= $pages)
			$page = $pages;
		
		// левая и правая сыылки
		$left = file_get_contents("./skin/".SKIN."/templates/lastpage.tpl");
		$right = file_get_contents("./skin/".SKIN."/templates/nextpage.tpl");;

		//{link} and {pagenum}  для левой ссылки
		if(($page - 1) >=0)
		{	
			$left = '';
			if($category ==0)
				$left = str_replace("{link}", SITE_PATH."/index.php?page=".($page - 1), $left);
			else
				$left = str_replace("{link}", SITE_PATH."/index.php?page=".($page - 1)."&category=".$category, $left);
			
			$left = str_replace("{pagenum}", ($page - 1), $left);
			
		}
		else
			$left = "";	
		
		//{link} and {pagenum}  для правой ссылки
		if(($page + 1) < $pages)
		{	
			$right = '';
			
			if($category ==0)
				$right = str_replace("{link}", SITE_PATH."/index.php?page=".($page + 1), $right);
			else
				$right = str_replace("{link}", SITE_PATH."/index.php?page=".($page + 1)."&category=".$category, $right);
				
			$right = str_replace("{pagenum}", ($page + 1), $right);
			
		}
		else
			$right = "";	
				

		// заменяем страницы
		$template = str_replace("{lastpage}", $left, $template);
		$template = str_replace("{nextpage}", $right, $template);				
				
		
		return $template;
	
	}
	
}


?>