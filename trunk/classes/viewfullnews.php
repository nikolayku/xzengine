<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2011 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

class FullNews
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
			
			// �������� ��� {keywords} ������� ��������	 	
			// {keywords} 
			$template = str_replace("{keywords}", $newsfound['news_keyword'], $template);			

			// �������� ��� {title} ������� ��������	
			// {title} 
			$template = str_replace("{title}", $newsfound['news_name'], $template);
			
			return $t;
		}
		
		return $error;
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
	
}


?>
