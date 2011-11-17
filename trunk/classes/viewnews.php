<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// �������� ��������


class viewnews
{	
	//////////////////////////////////////
	// �����������
	//////////////////////////////////////
	function __construct()
	{	
	}		

	//////////////////////////////////////
	// ���������� ������ � ���������� �������
	// $template - ������ ������� �������� ��� ������ ����� ��������� � ��
	/////////////////////////////////////
	function ShowConstLinkTemplate($id, &$template = '')
	{		
		$error = '';	
		
		if(is_numeric($id) && $id > 0)
		{
			$t = file_get_contents("./skin/".SKIN."/templates/constlink.tpl");

			$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_id='.$id.' LIMIT 1';	
			$result = AbstractDataBase::Instance()->query($q );	
			
			if(!$result)
				return $error;
			
			$newsfound = AbstractDataBase::Instance()->get_row($result);	
			
			if(!$newsfound)
				return $error;
				
			$this->replaceTags($t, $newsfound);	
			
			// �������� ��� {title} ������� ��������
				
			// {title} 
			$template = str_replace("{title}", $newsfound['news_name'], $template);
			
			// {keywords} 
			$template = str_replace("{keywords}", $newsfound['news_keyword'], $template);
			
			return $t;
		}
		
		// some error 
				
		
		return $error;
	}



	/////////////////////
	// ���������� �������
	// newsperpage - ���������� �������� �� ��������
	// page - ��������
	// category - ��������� �������, ���� 0 �� ������� ��������
	/////////////////////
	function getnews($newsperpage = 30, $page=0, $category = 0)
	{	
		if($page < 0)
			$page = 0;
		
		if($category < 0)
			$category = 0;
		
		$outputstr = "";
		
		// ��������� ������
		$template = file_get_contents("./skin/".SKIN."/templates/news.tpl");
		
		// ������ �� ��������
		$showInSameCategory = 'news_show_in_category = 1';
		if($category == 0)
			$showInSameCategory = 'news_show_in_category = 0';
		
		// �������� ��������������� �������	
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 1 AND news_approve = 1 AND '.$showInSameCategory.' ORDER BY news_id DESC');
		
		if(!$result)
			return "";
		
		$fixedNewsFound = AbstractDataBase::Instance()->num_rows($result);
		
		while($line = AbstractDataBase::Instance()->get_row($result))
		{	
			$temp = $template;
			$this->replaceTags($temp, $line);
			
			$outputstr = $outputstr.$temp;
		}
		
		// �������� �� ��������������� �������
		$result = '';	
		if($category == 0)
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND '.$showInSameCategory.' ORDER BY news_id DESC  LIMIT '.$newsperpage * $page.','.$newsperpage);
		else
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_category = '.$category.' ORDER BY news_id DESC  LIMIT '.$newsperpage * $page.','.$newsperpage);
		
		if(!$result)
			return "";
		
		while($line = AbstractDataBase::Instance()->get_row($result))
		{	
			$temp = $template;
			$this->replaceTags($temp, $line);
			
			$outputstr = $outputstr.$temp;
		}
			
		return $outputstr;
	}


	/////////////////////
	// �������� ��� ���� ���������� ������ � ���������� ������
	////////////////////

	function replaceTags(&$template, $row)
	{	
		// ��������� ������ �� �������������� �������, ���� ������������ ������������� 
		if(userPriviliges::IsAdministrator())
		{
			$temp = str_replace("{newsid}", $row['news_id'], news_edit);
			$template = str_replace("{edit}", $temp, $template);
		}
		else
			$template = str_replace("{edit}", '', $template);
		
		// {newsname} 
		$template = str_replace("{newsname}", $row['news_name'], $template);
		
		// {keywords} 
		$template = str_replace("{keywords}", $row['news_keyword'], $template);
		
		// {newsdescr}  
		$template = str_replace("{newsdescr}", $row['news_sh_description'], $template);
		
		// {newsdate}  
		$timest = $row['news_date'];
		$template = str_replace("{newsdate}", date(DATEFORMAT, $timest), $template);
		
		// {newslink} 
		if($row['news_full_or_link'] == 1)	 
		{	
			if(SIMPLY_URL)	// ����� ������� ������   
				$template = str_replace("{newslink}", '{sitepath}/readmore/'.$row['news_id'].'.htm', $template);
			else
				$template = str_replace("{newslink}", '{sitepath}/index.php?readmore='.$row['news_id'], $template);
		}
		else
		{	
			// ���������� ������ 
	 		$template = str_replace("{newslink}", $row['news_full_link'], $template);
		}	
		// {newsautor}   
		$template = str_replace("{newsautor}", $row['news_autor'], $template);
	
		// {descrlink}
		if(SIMPLY_URL)   
			$template = str_replace("{descrlink}", '{sitepath}/news/'.$row['news_id'].'.htm', $template);
		else
			$template = str_replace("{descrlink}", '{sitepath}/index.php?news='.$row['news_id'], $template);
				
	}
	
	///////////////////////
	// �������� ������� {lastpage} {nextpage} 
	///////////////////////
	function getPagesGrild($template, $isdraw = true, $newsperpage = 5, $page=0, $category = 0)
	{
		if(!$isdraw)
		{
			$template = str_replace("{lastpage}", "", $template);
			$template = str_replace("{nextpage}", "", $template);
			return $template;
		}

		// ������������ ���������� ���� �������
		$result = '';
		if($category == 0)
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_show_in_category = 0 ' );
		else
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_show_in_category = 1 AND news_category = '.$category );
				

		if(!$result)
			return "";
		
		$news = AbstractDataBase::Instance()->num_rows($result);
		
		if(($news < $newsperpage))
			$pages = 0;
		else
			$pages = ceil($news/$newsperpage);

		if($page >= $pages)
			$page = $pages;
		
		// ����� � ������ ������
		$left = file_get_contents("./skin/".SKIN."/templates/lastpage.tpl");
		$right = file_get_contents("./skin/".SKIN."/templates/nextpage.tpl");;
		
		
		//{link} and {pagenum}  ��� ����� ������
		if(($page - 1) >=0)
		{	
			if($category == 0)
				$left = str_replace("{link}", SITE_PATH."/index.php?page=".($page - 1), $left);
			
			else
				$left = str_replace("{link}", SITE_PATH."/index.php?page=".($page - 1)."&category=".$category, $left);				
			
			$left = str_replace("{pagenum}", ($page - 1), $left);
			
		}
		else
			$left = "";	
		
		//{link} and {pagenum}  ��� ������ ������
		if(($page + 1) < $pages)
		{	
			if($category == 0)
				$right = str_replace("{link}", SITE_PATH."/index.php?page=".($page + 1), $right);
			else
				$right = str_replace("{link}", SITE_PATH."/index.php?page=".($page + 1)."&category=".$category, $right);
					
			$right = str_replace("{pagenum}", ($page + 1), $right);
		}
		else
			$right = "";	
				

		// �������� ��������
		$template = str_replace("{lastpage}", $left, $template);
		$template = str_replace("{nextpage}", $right, $template);				
				
		
		return $template;
	
	}
	
	///////////////////////
	// ���������� ���������� ������� � ���� ��������� 
	///////////////////////
	function GetPagesList($category = 0)
	{	
		// ������� ��������
		$cstart = 0;
		if(isset($_GET['page']))
			$cstart = intval($_GET['page']);
		
		// �������� ����� ���������� ��������
		if($category == 0)
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_show_in_category = 0 ' );
		else
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = 0 AND news_approve = 1 AND news_show_in_category = 1 AND news_category = '.$category );
			
	
		if(!$result)
			return "";
		
		$news_count = AbstractDataBase::Instance()->num_rows($result);	
		
		if(NEWSPERPAGE)
			$pages_count = @ceil($news_count/NEWSPERPAGE);
		else
			return "";
		
		$pages_start_from = 1;
		$pages = "";
		
		for($j=1;$j<=$pages_count-1;$j++)
		{	
			if($pages_start_from != $cstart)
			{	
				if($category == 0)
					$pages .= ' <a href="'.SITE_PATH.'/index.php?page='.$j.'">'.($j).'</a> ';
				else
					$pages .= ' <a href="'.SITE_PATH.'/index.php?page='.$j.'&category='.$category.'">'.($j).'</a> ';
					
			}
			else
			{
				$pages .= '['.($j).']';
			}
			$pages_start_from ++;
		}	
		
		return $pages;
	}
	
}


?>
