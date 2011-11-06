<?php
//////////////////////////////////////////////////////////
// класс дл€ работы со статическими странцами
//////////////////////////////////////////////////////////

class Pages
{	
	////////////////////////////////////////////////////////////////////
	//  ”дал€ет страницу
	////////////////////////////////////////////////////////////////////
	function DeleteStaticPage($id)
	{		
		if((is_numeric($id)) && ($id >= 1))
			$q = AbstractDataBase::Instance()->query('DELETE FROM '.DATABASE_TBLPERFIX.'static WHERE static_id="'.$id.'"');
	}
		
	////////////////////////////////////////////////////////////////////
	//  «амен€ет теги при сосзании списка страниц
	////////////////////////////////////////////////////////////////////
	function replaceTags(&$temp, $line)
	{
		//{id}
		$temp = str_replace("{id}", $line['static_id'], $temp);	
		
		//{static_pagename}
		$temp = str_replace("{static_pagename}", addslashes($line['static_pagename']), $temp);
		
		//{static_page_link}		
		if(SIMPLY_URL)	// если включена поддержка пон€тной ссылки
			$temp = str_replace("{static_page_link}", '/spage/'.$line['static_id'].'.htm', $temp);
		else // если отключена	
			$temp = str_replace("{static_page_link}", '/index.php?spage='.$line['static_id'], $temp);
		
		return $temp;		
	}		
		
	////////////////////////////////////////////////////////////////////
	// ѕолучение списка всех статичеких страниц 
	// $main_page_template - шаблон главной страницы
	////////////////////////////////////////////////////////////////////
	function GetStaticPageList(&$main_page_template)
	{
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/staticpagelist.tpl");	
			
		$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'static');
		
		if(AbstractDataBase::Instance()->num_rows($q) == 0)
		{
			$error = 'Ѕаза данных не содержит не одной статичекой страницы. <a href="./index.php?staticpageedit">—оздать</a>';
			return $error;
		}
		
		// добавл€ем скрипт дл€ копировани€ ссылки
		$JavaScript = '<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>';	
		
		// замен€ем тег javascript на главной странице
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);		
		
		$outputstr = '';
		while($line = AbstractDataBase::Instance()->get_row($q))
		{	
			$temp = $template;
			$this->replaceTags($temp, $line);
			
			$outputstr = $outputstr.$temp;
		}
		
		//FIXME - временное решение, показывать ссылку на добавление статических страниц
		$outputstr = '<a href="./index.php?staticpageedit">ƒобавить ещЄ одну</a><br><br>'.$outputstr;
		
		return $outputstr;	
	}	
	
	////////////////////////////////////////////////////////////////////
	// ƒобавление в базу данных
	////////////////////////////////////////////////////////////////////
	function AddOrUpdate()
	{	
		$static_pagename = $_POST['static_pagename'];
		$static_text = $_POST['static_text'];
		$static_keywords = $_POST['static_keywords'];
		
		// замен€ем путь к сайту на шаблон
		$static_text = str_replace(SITE_PATH, '{sitepath}', $static_text);
		
		// замен€ем путь к форуму на шаблон
		$static_text = str_replace(FORUM_PATH, '{forum_path}', $static_text);
		
		// замен€ем путь к сайту на шаблон
		$static_pagename = str_replace(SITE_PATH, '{sitepath}', $static_pagename);
		
		// замен€ем путь к форуму на шаблон
		$static_pagename = str_replace(FORUM_PATH, '{forum_path}', $static_pagename);
		
		
		// в $_SESSION['editstaticpageid'] содердитьс€ идентификатор измен€емого объекта
		// если содержитьс€ то обновл€ем иначе добавл€ем
		session_start();
		$q = '';
		$message = '';		
		if(isset($_SESSION['editstaticpageid']))
		{	
			$q = "UPDATE ".DATABASE_TBLPERFIX."static SET static_pagename='".$static_pagename."', static_text='".$static_text."', static_keywords='".$static_keywords."' WHERE static_id='".$_SESSION['editstaticpageid']."'";
			$message = 'Ќовость обновлена';
			unset($_SESSION['editstaticpageid']);	
		}
		else
		{
			$q = "INSERT INTO ".DATABASE_TBLPERFIX."static (static_pagename, static_text, static_keywords) VALUES ('".$static_pagename."', '".$static_text."', '".$static_keywords."')";
			$message = '—татическа€ страница сформирована';
		}

		// обновл€ем содержимое	
		AbstractDataBase::Instance()->query($q);
		
		$message = $message.'&nbsp;&nbsp;<a href="./index.php?staticpagelist">Ќазад</a>';
		// загружаем страницу
		return $this->LoadEditPage(0,$message);	

	}
	
	// загружает шаблон
	function LoadEditPage($id = 0, $message = "")
	{		
		$static_pagename = "";
		$static_text = "";		
		$static_keywords = "";
		
		// провер€ем правильно ли введены данные
		if((is_numeric($id)) && ($id >= 1))
		{
			$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'static WHERE static_id = '.$id.' LIMIT 1');
			if($q)
			{	
				$line = AbstractDataBase::Instance()->get_row($q);
			
				if($line)
				{
					$static_pagename = $line['static_pagename'];	// заголовок страницы
					$static_text = $line['static_text'];			// содержимое страницы
					$static_keywords = $line['static_keywords'];	// ключевые слова
					
					// замен€ем путь к сайту на шаблон
					$static_text = str_replace('{sitepath}', SITE_PATH, $static_text);
					// замен€ем путь к форуму на шаблон
					$static_text = str_replace('{forum_path}', FORUM_PATH, $static_text);
					// замен€ем путь к форуму на шаблон
					$static_text = str_replace('{forum_path}', FORUM_PATH, $static_text);
					
					session_start();
					$_SESSION['editstaticpageid'] = $id;
					
				}
			}	
		}	
				

		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/staticpage.tpl");	
		
		$tinyJS = 
				'<script language="javascript" type="text/javascript" src="../editor/tiny_mce.js"></script> 
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
					  file : "../modules/mfm_012/mfm.php?field=" + field_name + "&url=" + url + "",
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
		
		// замен€ем шаблоны
		
		// {javascript_admin}
		$render_str = str_replace("{javascript_admin}", $tinyJS, $render_str);	
	
		session_start();
		
		//{static_pagename}
		$render_str = str_replace("{static_pagename}", $static_pagename, $render_str);
	
		//{static_text}
		$render_str = str_replace("{static_text}", $static_text, $render_str);
		
		//{static_keywords}
		$render_str = str_replace("{static_keywords}", $static_keywords, $render_str);
		
		
		//{message}
		$render_str = str_replace("{message}", $message, $render_str);		

		return $render_str;
	}

	// замен€ет в шаблоне страницы теги  {title} и 
	// $template - шаблон главной страницы
	// $id - id статической страницы
	function RenderPage($template, $id)
	{	
		// здесь идЄт проверка на правльность ввода 
		if((!is_numeric($id)) || ($id < 1))
		{	
			// выкидываем
			header("HTTP/1.0 404 Not Found");
			return '';
		}

		$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'static WHERE static_id = '.$id.' LIMIT 1');
		
		if(!$q)
		{	
			// ничего не найдено
			header("HTTP/1.0 404 Not Found");
			return '';
		}
		
		$line = AbstractDataBase::Instance()->get_row($q);
		
		if(!$line)
		{
			// ничего не найдено
			header("HTTP/1.0 404 Not Found");
			return '';
		}
				
		// загружаем шаблон
		$staticpage = file_get_contents("./skin/".SKIN."/templates/staticpage.tpl");			
		
		// {pagecontent}
		$staticpage = str_replace("{pagecontent}", $line['static_text'], $staticpage);
		
		//{sitecontent}
		$template = str_replace("{sitecontent}", $staticpage, $template);
		
		//{keywords} - замен€ем если только есть ключевые слова, иначе их установ€т в index.php
		if(trim($line['static_keywords']) != "")
			$template = str_replace("{keywords}", $line['static_keywords'], $template);
		
		// {title}
		$template = str_replace("{title}", $line['static_pagename'], $template);

		// {lastpage}
		$template = str_replace("{lastpage}", '', $template);
		
		// {nextpage}
		$template = str_replace("{nextpage}", '', $template);		

		return $template;
	}		
	
};


?>