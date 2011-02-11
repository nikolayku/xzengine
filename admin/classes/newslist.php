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
		$news_view = 0;
		
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
			
			
			if($_POST['news_view'] == 1)
				$news_view = 1;	
			else
				$news_view = 0;		

		}		
		
		// добавляем форму фильтра 
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
      <input name="news_view" type="checkbox" id="news_view" value="1" '.(($news_view == 1)?'checked="checked"':'').' />
      Показанные новости</label></td>
    <td width="12%"><input type="submit" name="Submit" value="Применить" /></td>
  </tr>
</table>

</form>';

		$outputstr = $filter_form_code.$outputstr;

		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/news.tpl");
		
		
		// получаем новости
		$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news ORDER BY news_id DESC LIMIT '.$newsperpage * $page.','.$newsperpage;
		
		// если определён фильтр
		if(isset($_GET['applyfilter']))
		{	
			//$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_fixed = '.$news_fixed.' AND news_approve = '.$news_approve.' AND news_view = '.$news_view.' ORDER BY news_id DESC LIMIT '.$newsperpage.' OFFSET '.($newsperpage * $page);
			$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'news ';
			
			$q_1 = (($news_fixed == 1)?'news_fixed = 1 ':'');			
			$q_2 = (($news_approve == 1)?'news_approve = 1 ':'');			
			$q_3 = (($news_view == 1)?'news_view = 1 ':'');			
			
			// расматриваем различные комбинации флагов
			$flags = "";
			
			if($news_fixed && !$news_approve && !$news_view)			// выбран только флаг 	$news_fixed
				$flags = 'WHERE '.$q_1;
			
			if($news_fixed && $news_approve && !$news_view)			// выбран  флаг 	$news_fixed и $news_approve
				$flags = 'WHERE '.$q_1.'AND '.$q_2;
			
			if($news_fixed && !$news_approve && $news_view)			// выбран  флаг 	$news_fixed и $news_view
				$flags = 'WHERE '.$q_1.'AND '.$q_3;
			
			if(!$news_fixed && $news_approve && $news_view)			// выбран  флаг 	$news_approve и $news_view
				$flags = 'WHERE '.$q_2.'AND '.$q_3;
			
			if($news_fixed && $news_approve && $news_view)			// выбраны все флаги
				$flags = '';		
			
			if(!$news_fixed && !$news_approve && !$news_view)		// ничего не выбрано
				$flags = 'WHERE news_fixed = 0 AND news_approve = 0 AND news_view = 0 ';	
			
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
		$template = str_replace("{newslink}", $row['news_full_link'], $template);
		
		// {newsid} 
		$template = str_replace("{newsid}", $row['news_id'], $template);


	}
	
}


?>