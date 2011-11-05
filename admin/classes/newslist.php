<?php
// показывает новости

class listNews
{
	/////////////////////////////////////
	// возвращяет шаблон news.tpl где теги заменены
	// показывает списком все новости
	// $page - страница какую надо выводить
	// $main_page_template - шаблон главной страницы
	/////////////////////////////////////
	function getNews(&$main_page_template, $newsperpage = 30,$page=0)
	{
		$outputstr = ""; // сюда сохранятся значния выхоной строки	
		
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
		
		// добавляем форму фильтра 
		//FIXME: убрать фильтр, добавить поиск по новости с ajax
		$filter_form_code = 
		'<form id="formfilter" name="formfilter" method="post" action="index.php?listnews&applyfilter">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="17%" align="center">Фильтр по: </td>
			<td width="26%"><label>
			  <input name="news_fixed" type="checkbox" id="news_fixed" value="1" '.(($news_fixed == 1)?'checked="checked"':'').' />
			  Зафиксированые новости</label></td>
			<td width="23%"><label>
			  <input name="news_approve" type="checkbox" id="news_approve" value="1" '.(($news_approve == 1)?'checked="checked"':'').' />
			  Провереные новости </label></td>
			<td width="22%" valign="middle"><label>
			  <input name="news_show_in_category" type="checkbox" id="news_show_in_category" value="1" '.(($news_show_in_category == 1)?'checked="checked"':'').' />
			  В категории</label></td>
			<td width="12%"><input type="submit" name="Submit" value="Применить" /></td>
		  </tr>
		</table>

		</form>';

		$outputstr = $filter_form_code.$outputstr;
		
		// загружаем шаблон
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/news.tpl");
		
		// получаем новости
		$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news ORDER BY news_id DESC LIMIT '.$newsperpage * $page.','.$newsperpage;
		
		// если определён фильтр
		// FIXME: убрать эти фильтры !!!!!, заменить поиском по имени новости
		if(isset($_GET['applyfilter']))
		{	
			$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news ';
			
			$q_1 = (($news_fixed == 1)?'news_fixed = 1 ':'');			
			$q_2 = (($news_approve == 1)?'news_approve = 1 ':'');			
			$q_3 = (($news_show_in_category == 1)?'news_show_in_category = 1 ':'');			
			
			// расматриваем различные комбинации флагов
			$flags = "";
			
			if($news_fixed && !$news_approve && !$news_show_in_category)			// выбран только флаг 	$news_fixed
				$flags = 'WHERE '.$q_1;
			
			if(!$news_fixed && $news_approve && !$news_show_in_category)			// выбран только флаг 	$news_approve
				$flags = 'WHERE '.$q_2;
			
			if(!$news_fixed && !$news_approve && $news_show_in_category)			// выбран только флаг 	$news_show_in_category
				$flags = 'WHERE '.$q_3;
			
			if($news_fixed && $news_approve && !$news_show_in_category)			// выбран  флаг 	$news_fixed и $news_approve
				$flags = 'WHERE '.$q_1.'AND '.$q_2;
			
			if($news_fixed && !$news_approve && $news_show_in_category)			// выбран  флаг 	$news_fixed и $news_show_in_category
				$flags = 'WHERE '.$q_1.'AND '.$q_3;
			
			if(!$news_fixed && $news_approve && $news_show_in_category)			// выбран  флаг 	$news_approve и $news_show_in_category
				$flags = 'WHERE '.$q_2.'AND '.$q_3;
			
			if($news_fixed && $news_approve && $news_show_in_category)			// выбраны все флаги
				$flags = 'WHERE '.$q_1.'AND'.$q_2.'AND'.$q_3;		
			
			if(!$news_fixed && !$news_approve && !$news_show_in_category)		// ничего не выбрано
				$flags = 'WHERE news_fixed = 0 AND news_approve = 0 AND news_show_in_category = 0 ';	
			
			//print_r($_POST);
			//echo "FLAGS".$flags;
			
			// соединяем с запросом
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
		
		// заменяем javascript тег
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", '<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>', $main_page_template);		

		return $outputstr;
	}

	////////////////////////////////
	// repalcetags
	// заменяет все теги на нужные
	////////////////////////////////
	function replaceTags(&$template, $row)
	{
		// {newsname} 
		$template = str_replace("{newsname}", $row['news_name'], $template);

		// {newslink} 
		if(SIMPLY_URL)	// если включена поддержка понятной ссылки
			$template = str_replace("{newslink}", '{sitepath}/news/'.$row['news_id'].'.htm', $template);
		else // если отключена	
			$template = str_replace("{newslink}", '{sitepath}/index.php?news='.$row['news_id'], $template);
		
		// {newsid} 
		$template = str_replace("{newsid}", $row['news_id'], $template);
	}
}

?>