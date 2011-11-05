<?php
// ���������� �������

class listNews
{
	/////////////////////////////////////
	// ���������� ������ news.tpl ��� ���� ��������
	// ���������� ������� ��� �������
	// $page - �������� ����� ���� ��������
	// $main_page_template - ������ ������� ��������
	/////////////////////////////////////
	function getNews(&$main_page_template, $newsperpage = 30,$page=0)
	{
		$outputstr = ""; // ���� ���������� ������� ������� ������	
		
		if($page < 0)
			$page = 0;
			
		$news_fixed = 1;
		$news_approve = 0;
		$news_show_in_category = 0;
		
		if(isset($_GET['applyfilter']))
		{
			if($_POST['news_fixed'] == 1)
				$news_fixed = 1;
			else
				$news_fixed = 0;			

			if($_POST['news_approve'] == 1)
				$news_approve = 1;
			else	
				$news_approve = 0;	
			
			
			if($_POST['news_show_in_category'] == 1)
				$news_show_in_category = 1;	
			else
				$news_show_in_category = 0;		

		}		
		
		// ��������� ����� ������� 
		//FIXME: ������ ������, �������� ����� �� ������� � ajax
		$filter_form_code = 
		'<form id="formfilter" name="formfilter" method="post" action="index.php?listnews&applyfilter">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="17%" align="center">������ ��: </td>
			<td width="26%"><label>
			  <input name="news_fixed" type="checkbox" id="news_fixed" value="1" '.(($news_fixed == 1)?'checked="checked"':'').' />
			  �������������� �������</label></td>
			<td width="23%"><label>
			  <input name="news_approve" type="checkbox" id="news_approve" value="1" '.(($news_approve == 1)?'checked="checked"':'').' />
			  ���������� ������� </label></td>
			<td width="22%" valign="middle"><label>
			  <input name="news_show_in_category" type="checkbox" id="news_show_in_category" value="1" '.(($news_show_in_category == 1)?'checked="checked"':'').' />
			  � ���������</label></td>
			<td width="12%"><input type="submit" name="Submit" value="���������" /></td>
		  </tr>
		</table>

		</form>';

		$outputstr = $filter_form_code.$outputstr;
		
		// ��������� ������
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/news.tpl");
		
		// �������� �������
		$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news ORDER BY news_id DESC LIMIT '.$newsperpage * $page.','.$newsperpage;
		
		// ���� �������� ������
		// FIXME: ������ ��� ������� !!!!!, �������� ������� �� ����� �������
		if(isset($_GET['applyfilter']))
		{	
			$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news ';
			
			$q_1 = (($news_fixed == 1)?'news_fixed = 1 ':'');			
			$q_2 = (($news_approve == 1)?'news_approve = 1 ':'');			
			$q_3 = (($news_show_in_category == 1)?'news_show_in_category = 1 ':'');			
			
			// ������������ ��������� ���������� ������
			$flags = "";
			
			if($news_fixed && !$news_approve && !$news_show_in_category)			// ������ ������ ���� 	$news_fixed
				$flags = 'WHERE '.$q_1;
			
			if(!$news_fixed && $news_approve && !$news_show_in_category)			// ������ ������ ���� 	$news_approve
				$flags = 'WHERE '.$q_2;
			
			if(!$news_fixed && !$news_approve && $news_show_in_category)			// ������ ������ ���� 	$news_show_in_category
				$flags = 'WHERE '.$q_3;
			
			if($news_fixed && $news_approve && !$news_show_in_category)			// ������  ���� 	$news_fixed � $news_approve
				$flags = 'WHERE '.$q_1.'AND '.$q_2;
			
			if($news_fixed && !$news_approve && $news_show_in_category)			// ������  ���� 	$news_fixed � $news_show_in_category
				$flags = 'WHERE '.$q_1.'AND '.$q_3;
			
			if(!$news_fixed && $news_approve && $news_show_in_category)			// ������  ���� 	$news_approve � $news_show_in_category
				$flags = 'WHERE '.$q_2.'AND '.$q_3;
			
			if($news_fixed && $news_approve && $news_show_in_category)			// ������� ��� �����
				$flags = 'WHERE '.$q_1.'AND'.$q_2.'AND'.$q_3;		
			
			if(!$news_fixed && !$news_approve && !$news_show_in_category)		// ������ �� �������
				$flags = 'WHERE news_fixed = 0 AND news_approve = 0 AND news_show_in_category = 0 ';	
			
			//print_r($_POST);
			//echo "FLAGS".$flags;
			
			// ��������� � ��������
			$q = $q.$flags.'ORDER BY news_id DESC LIMIT '.$newsperpage * $page.','.$newsperpage;	
		}
				
		$result = AbstractDataBase::Instance()->query($q);
		if(!$result)
			return "";

		while($line = AbstractDataBase::Instance()->get_row($result))
		{	
			$temp = $template;
			$this->replaceTags($temp, $line);
			
			$outputstr = $outputstr.$temp;
		}
		
		// �������� javascript ���
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", '<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>', $main_page_template);		

		return $outputstr;
	}

	////////////////////////////////
	// repalcetags
	// �������� ��� ���� �� ������
	////////////////////////////////
	function replaceTags(&$template, $row)
	{
		// {newsname} 
		$template = str_replace("{newsname}", $row['news_name'], $template);

		// {newslink} 
		if(SIMPLY_URL)	// ���� �������� ��������� �������� ������
			$template = str_replace("{newslink}", '{sitepath}/news/'.$row['news_id'].'.htm', $template);
		else // ���� ���������	
			$template = str_replace("{newslink}", '{sitepath}/index.php?news='.$row['news_id'], $template);
		
		// {newsid} 
		$template = str_replace("{newsid}", $row['news_id'], $template);
	}
}

?>