<?php

// добавление новостей



// добавление новостей
class addnews
{
	// конструктор
	function __construct()
	{	
		session_start();
	}
		
	// удаляет новость из бд
	function deleteNews($id)
	{
		// проверка....
		AbstractDataBase::Instance()->query('DELETE FROM '.DATABASE_TBLPERFIX.'news WHERE news_id="'.$id.'"');		
	}
		

	// $message - сообщение которое будит выводится
	// $main_page_template - шаблон главной страницы
	function render(&$main_page_template, $message = "")
	{	
					
		$newsname = "";
		if(isset($_POST['news_name']))
			$newsname = $_POST['news_name'];
			
		$newsdescription = "";
		if(isset($_POST['news_sh_description']))
			$newsdescription = $_POST['news_sh_description'];
		
		$newsfulllink = "";
		if(isset($_POST['news_full_link']))
			$newsfulllink = $_POST['news_full_link'];

		$news_keyword = "";
		if(isset($_POST['news_keyword']))
			$news_keyword = $_POST['news_keyword'];
				
		$autor = "";
		if(isset($_POST['news_autor']))
			$autor = $_POST['news_autor'];
		
		$newsshowfull = "";
		if(isset($_POST['news_showfull']))
			$newsshowfull = $_POST['news_showfull'];
		
		$newscategory = '';
		// получаем категорию
		// составляем список всех категорий
		$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'category');	

		while($line = AbstractDataBase::Instance()->get_row($q))
		{	
			if(isset($_POST['news_category']))
			{
				$cat_ID = $_POST['news_category'];
				if($line['category_id'] == $cat_ID)
					$newscategory = '<option value="'.$line['category_id'].'">'.$line['category_name'].'</option>'.$newscategory;
				
				else
					$newscategory = $newscategory.'<option value="'.$line['category_id'].'">'.$line['category_name'].'</option>';
			}
			else	
			{
				$newscategory = $newscategory.'<option value="'.$line['category_id'].'">'.$line['category_name'].'</option>';
			
			}
			
		}	
		
	
		if(isset($_SESSION['edit_id']))
		{
			if(isset($_SESSION['news_name']))
			$newsname = $_SESSION['news_name'];
		
			if(isset($_SESSION['news_sh_description']))
				$newsdescription = $_SESSION['news_sh_description'];
			
			if(isset($_SESSION['news_full_link']))
				$newsfulllink = $_SESSION['news_full_link'];

			if(isset($_SESSION['news_autor']))
				$autor = $_SESSION['news_autor'];
			
			if(isset($_SESSION['news_keyword']))
				$news_keyword = $_SESSION['news_keyword'];
			
			if(isset($_SESSION['news_showfull']))
				$newsshowfull = $_SESSION['news_showfull'];
			
			if(isset($_SESSION['news_category']))
			{
				$t = $_SESSION['news_category'];
				// составляем список всех категорий
				$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'category');	
				$catlist = '';
		
				while($line = AbstractDataBase::Instance()->get_row($q))
				{	
					$cat_ID = $line['category_id']; 
					//echo $cat_ID."-dsfmgsdg-"; 	
					if($cat_ID == $t)
						$catlist = '<option value="'.$line['category_id'].'">'.$line['category_name'].'</option>'.$catlist;
					
					else
						$catlist = $catlist.'<option value="'.$line['category_id'].'">'.$line['category_name'].'</option>';
					
				}	
			
				$newscategory = $catlist;
			}
		}
		
	
		$template = file_get_contents("./skin/".SKIN."/templates/addnews.tpl");
		
		// заменяем теги
		// {newsname}
		$template = str_replace("{newsname}", $newsname, $template);

		// {newsdescription}
		$template = str_replace("{newsdescription}", stripslashes($newsdescription), $template);
		
		// {newsshowfull}
		$template = str_replace("{newsshowfull}", stripslashes($newsshowfull), $template);
		
		// {newsfulllink}
		$template = str_replace("{newsfulllink}", $newsfulllink, $template);	
		
		// {newskeyword}
		$template = str_replace("{newskeyword}", $news_keyword, $template);			
		
		// {autor}
		$template = str_replace("{autor}", $autor, $template);
		
		// {categorylist}		
		$template = str_replace("{categorylist}", $newscategory, $template);
		
		// показываем расширенный набор кнопок (для администратора)
		if(userPriviliges::IsAdministrator())
		{
			$tinyJS = 
				'<script language="javascript" type="text/javascript" src="{sitepath}/editor/tiny_mce.js"></script> 
				<script language="javascript" type="text/javascript">

				tinyMCE.init({
				mode : "textareas",
				theme: "advanced",
				language : "en",
				plugins : "advimage,advlink,emotions,inlinepopups",
				theme_advanced_buttons1 : "justifyleft,justifycenter,justifyfull,justifyright,fontsizeselect,forecolor,separator,bold,italic,underline,strikethrough,separator,link,image,separator,emotions,separator,code",
				theme_advanced_buttons2 : "",
				theme_advanced_buttons3 : "",
				theme_advanced_buttons4 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,


				relative_urls : false,
				convert_urls : false,
				file_browser_callback : MadFileBrowser
				});
				
				function MadFileBrowser(field_name, url, type, win)
				{
				  tinyMCE.activeEditor.windowManager.open({
					  file : "./modules/mfm_012/mfm.php?field=" + field_name + "&url=" + url + "",
					  title : "File Manager",
					  width : 900,
					  height : 450,
					  resizable : "no",
					  inline : "yes",
					  close_previous : "no"
				  }, {
					  window : win,
					  input : field_name
				  });
				  return false;
				}
				
				</script>
				
				<script type="text/javascript">
				function BrowseFiles(popurl)
				{
					var winpops=window.open(popurl,"","status = 1, height = 450, width = 900, left = 200, top = 180, resizable = 0")
				}	
				</script>';	
		}
		else
		{	
			// показываем обычный набор кнопок
			$tinyJS = 
				'<script language="javascript" type="text/javascript" src="{sitepath}/editor/tiny_mce.js"></script> 
				<script language="javascript" type="text/javascript">

				tinyMCE.init({
				mode : "textareas",
				theme_advanced_toolbar_location : "top",
				plugins : "emotions",
				theme_advanced_buttons1 : "separator,justifyleft,justifycenter,justifyfull,justifyright,separator,bold,italic,underline,strikethrough,separator,link,image,separator,emotions,separator",
				theme_advanced_buttons2 : "",
				theme_advanced_buttons3 : "",
				relative_urls : false,
				convert_urls : false
				});

				</script>';	
		}
			
	
	// {javascript}
	$main_page_template = str_replace("{javascript}", $tinyJS, $main_page_template);	
	
	// {message}
	$template = str_replace("{message}", $message, $template);
	
	// {private}
	$t = "";
	

	if(userPriviliges::IsAdministrator())
	{
		//
		$t = file_get_contents("./skin/".SKIN."/templates/options.tpl");
		
		// заменяем теги
		
		if(isset($_SESSION['edit_id']))
		{
			// news_fixed
			if(isset($_SESSION['news_fixed']))
			{	
				if($_SESSION['news_fixed'] == 1)
					$t = str_replace("{news_fixed_ch}", 'checked="checked"', $t);
				else	
					$t = str_replace("{news_fixed_ch}", '', $t);
			}
			
			// news_view
			if(isset($_SESSION['news_view']))
			{	
				if($_SESSION['news_view'] == 1)
					$t = str_replace("{news_view_ch}", 'checked="checked"', $t);
				else	
					$t = str_replace("{news_view_ch}", '', $t);
			}
			
			// news_approve
			if(isset($_SESSION['news_approve']))
			{	
				if($_SESSION['news_approve'] == 1)
					$t = str_replace("{news_approve_ch}", 'checked="checked"', $t);
				else	
					$t = str_replace("{news_approve_ch}", '', $t);
			}
		}
		else
		{
			$t = str_replace("{news_fixed_ch}", '', $t);
			$t = str_replace("{news_view_ch}", 'checked="checked"', $t);
			$t = str_replace("{news_approve_ch}", 'checked="checked"', $t);
			
		}
		
		
	}// end if(userPriviliges::IsAdministrator())
	else
	{
		$t = file_get_contents("./skin/".SKIN."/templates/antispampicture.tpl");
	}
	
	$template = str_replace("{private}", $t, $template);
	

	return $template;
		
	}

	
	/////////////////////////////////////
	// проверяет правльность ввода данных
	// возвращяет true или false в зависимости от того как прошла проверка
	/////////////////////////////////////
	function Check(&$message)
	{	
		// проверяем является ли пользователь администратором
		$isadmin = 	userPriviliges::IsAdministrator();
		
		// флаги добавления новости
		$news_fixed = 0;		// зафиксирована
		$news_approve = 0;		// разрешить новость
		$news_view = 0;			// показывать новость на сайте		

		if(!$isadmin)
		{
			// если не администратор то должно быть определено число с картинки
			$imagefrompic = "";
			if(isset($_POST['imagefrompic']))
				$imagefrompic = $_POST['imagefrompic'];
			else	
				return false;

			
			
			if($_SESSION['image_from_pic'] != $imagefrompic)
			{
				$message = lang_addnews_invalidpiccode;
				return false;
			}	
		}
		else
		{
			if(isset($_POST['news_fixed']))
				$news_fixed = $_POST['news_fixed'];

			if(isset($_POST['news_approve']))
				$news_approve = $_POST['news_approve'];
			
			
			if(isset($_POST['news_view']))
				$news_view = $_POST['news_view'];
			
		}	

			
		$news_name = "";
		if(isset($_POST['news_name']))
			$news_name = $_POST['news_name'];
		else	
			return false;
		
		$news_sh_description = "";
		if(isset($_POST['news_sh_description']))
			$news_sh_description = $_POST['news_sh_description'];
		else	
			return false;
		
		$news_showfull = "";
		if(isset($_POST['news_showfull']))
			$news_showfull = $_POST['news_showfull'];
		else	
			return false;	

		$news_full_link = "";
		if(isset($_POST['news_full_link']))
			$news_full_link = $_POST['news_full_link'];
		else	
			return false;
		
		$news_keyword = "";
		if(isset($_POST['news_keyword']))
			$news_keyword = $_POST['news_keyword'];
		else	
			return false;
		
		$news_autor = "";
		if(isset($_POST['news_autor']))
			$news_autor = $_POST['news_autor'];
		else	
			return false;
		
		$news_category = 0;
		if(isset($_POST['news_category']))
			$news_category = $_POST['news_category'];
		else	
			return false;
		
		
		
		if(strlen($news_name) > 250)
		{
			$message = lang_addnews_newsnameverylong;
			return false;	
		}	
		
		if(strlen($news_autor) > 60)
		{
			$message = lang_addnews_newsautorverylong;
			return false;	
		}	
		$t = time();
		
		
		// заменяем путь к сайту на шаблон
		$news_sh_description = str_replace(SITE_PATH, '{sitepath}', $news_sh_description);
		$news_showfull = str_replace(SITE_PATH, '{sitepath}', $news_showfull);
		
		
		// заменяем путь к форуму на шаблон
		$news_sh_description = str_replace(FORUM_PATH, '{forum_path}', $news_sh_description);
		$news_full_link = str_replace(FORUM_PATH, '{forum_path}', $news_full_link);		
		$news_showfull = str_replace(FORUM_PATH, '{forum_path}', $news_showfull);		

		
		$news_full_or_link = 1;
		// определяем какую ссылку использовать - на полную новость или на другой сайт
		if((strlen($news_showfull) > 0) and (strlen($news_full_link) == 0))
			$news_full_or_link = 1;
		else
			$news_full_or_link = 0;	

		// запрос
		
		if(isset($_SESSION['edit_id']))
		{
			$q = "UPDATE ".DATABASE_TBLPERFIX."news SET news_name='".$news_name."', news_sh_description='".$news_sh_description."',news_autor='".$news_autor."', news_full_link='".$news_full_link."', news_date='".$t."', news_fixed = '".$news_fixed."', news_view='".$news_view."', news_approve='".$news_approve."',news_showfull='".$news_showfull."', news_full_or_link='".$news_full_or_link."', news_category='".$news_category."', news_keyword='".$news_keyword."' WHERE news_id='".$_SESSION['edit_id']."'";
		}
		else
		{
			$q = "INSERT INTO ".DATABASE_TBLPERFIX."news (news_name, news_sh_description, news_autor, news_full_link, news_date, news_fixed, news_view, news_approve , news_showfull, news_full_or_link, news_category, news_keyword) VALUES ('".$news_name."', '".$news_sh_description."', '".$news_autor."', '".$news_full_link."', '".$t."', '".$news_fixed."', '".$news_view."', '".$news_approve."', '".$news_showfull."', '".$news_full_or_link."', '".$news_category."','".$news_keyword."')";		
		}
		
		
		AbstractDataBase::Instance()->query($q);	
		
		// если это редактирование новости то перегохим на страницу просмотра и редактирования новостей
		if(isset($_SESSION['edit_id']))
			$message = lang_addnews_edit;

		else	
			$message = lang_addnews_add;
		
			
		// сбрасываем значения если всё прошло удачно
		$this->FlushSession();		
		
		unset($_SESSION['edit_id']);
		unset($_POST['news_name']);
		unset($_POST['news_sh_description']);		
		unset($_POST['news_full_link']);	
		unset($_POST['news_autor']);		
		unset($_POST['news_showfull']);		
		unset($_POST['news_category']);
		unset($_POST['news_keyword']);
		

		return true;
		
		
	}
	
	/////////////////////////////////////////////////////////
	// вспомогательная функция - сбрасывает состояние сессионных переменных
	////////////////////////////////////////////////////////
	
	function FlushSession()
	{	
		unset($_SESSION['edit_id']);
		unset($_SESSION['news_name']);
		unset($_SESSION['news_sh_description']);		
		unset($_SESSION['news_full_link']);	
		unset($_SESSION['news_autor']);
		unset($_SESSION['news_showfull']);
		unset($_SESSION['news_category']);	
		unset($_SESSION['news_keyword']);			

		unset($_SESSION['news_fixed']);
		unset($_SESSION['news_view']);
		unset($_SESSION['news_approve']);
		
	}
	
	/////////////////////////////////////////////////////////
	// вспомогательная функция - сохранение сиссионных переменных для последующего редактирования 
	////////////////////////////////////////////////////////
	
	function editNews($id = 0)
	{
		// получаем новости
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_id='.$id.' LIMIT 1 ');
		
		// если ничего не найдено то перескакиваем на главную страницу
		if(!$result)
			echo '<meta http-equiv="Refresh" content="0;URL=index.php" />';
		
		$line = AbstractDataBase::Instance()->get_row($result);
		
		// устанавливаем переменные
		
		$_SESSION['edit_id'] = $id;
		
		$_SESSION['news_name'] = $line['news_name'];
		$_SESSION['news_sh_description'] = $line['news_sh_description'];
		$_SESSION['news_full_link'] = $line['news_full_link'];
		$_SESSION['news_autor'] = $line['news_autor'];
		$_SESSION['news_showfull'] = $line['news_showfull'];		
		$_SESSION['news_category'] = $line['news_category'];		
		$_SESSION['news_keyword'] = $line['news_keyword'];		

		// флаги
		$_SESSION['news_fixed'] = $line['news_fixed'];	
		$_SESSION['news_view'] = $line['news_view'];			
		$_SESSION['news_approve'] = $line['news_approve'];		
		
		// редирект на страницу редактирования новости (она общяя как для админпанели , так и для обычного пользователя)	
		echo '<meta http-equiv="Refresh" content="0;URL=../index.php?addnews" />';
		
	}
					 	
}

?>