<?php
//////////////////////////////////////////////////////////
// ����� ��� ������ �� ������������ ���������
//////////////////////////////////////////////////////////

class Pages
{	
	////////////////////////////////////////////////////////////////////
	//  ������� ��������
	////////////////////////////////////////////////////////////////////
	function DeleteStaticPage($id)
	{		
		if((is_numeric($id)) && ($id >= 1))
			$q = AbstractDataBase::Instance()->query('DELETE FROM '.DATABASE_TBLPERFIX.'static WHERE static_id="'.$id.'"');
	}
		
	////////////////////////////////////////////////////////////////////
	//  �������� ���� ��� �������� ������ �������
	////////////////////////////////////////////////////////////////////
	function replaceTags(&$temp, $line)
	{
		//{id}
		$temp = str_replace("{id}", $line['static_id'], $temp);	
		
		//{static_pagename}
		$temp = str_replace("{static_pagename}", addslashes($line['static_pagename']), $temp);
		
		//{static_page_link}		
		if(SIMPLY_URL)	// ���� �������� ��������� �������� ������
			$temp = str_replace("{static_page_link}", '/spage/'.$line['static_id'].'.htm', $temp);
		else // ���� ���������	
			$temp = str_replace("{static_page_link}", '/index.php?spage='.$line['static_id'], $temp);
		
		return $temp;		
	}		
		
	////////////////////////////////////////////////////////////////////
	// ��������� ������ ���� ���������� ������� 
	// $main_page_template - ������ ������� ��������
	////////////////////////////////////////////////////////////////////
	function GetStaticPageList(&$main_page_template)
	{
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/staticpagelist.tpl");	
			
		$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'static');
		
		if(AbstractDataBase::Instance()->num_rows($q) == 0)
		{
			$error = '���� ������ �� �������� �� ����� ���������� ��������. <a href="./index.php?staticpageedit">�������</a>';
			return $error;
		}
		
		// ��������� ������ ��� ����������� ������
		$JavaScript = '<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>';	
		
		// �������� ��� javascript �� ������� ��������
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);		
		
		$outputstr = '';
		while($line = AbstractDataBase::Instance()->get_row($q))
		{	
			$temp = $template;
			$this->replaceTags($temp, $line);
			
			$outputstr = $outputstr.$temp;
		}
		
		//FIXME - ��������� �������, ���������� ������ �� ���������� ����������� �������
		$outputstr = '<a href="./index.php?staticpageedit">�������� ��� ����</a><br><br>'.$outputstr;
		
		return $outputstr;	
	}	
	
	////////////////////////////////////////////////////////////////////
	// ���������� � ���� ������
	////////////////////////////////////////////////////////////////////
	function AddOrUpdate()
	{	
		$static_pagename = $_POST['static_pagename'];
		$static_text = $_POST['static_text'];
		$static_keywords = $_POST['static_keywords'];
		
		// �������� ���� � ����� �� ������
		$static_text = str_replace(SITE_PATH, '{sitepath}', $static_text);
		
		// �������� ���� � ������ �� ������
		$static_text = str_replace(FORUM_PATH, '{forum_path}', $static_text);
		
		// �������� ���� � ����� �� ������
		$static_pagename = str_replace(SITE_PATH, '{sitepath}', $static_pagename);
		
		// �������� ���� � ������ �� ������
		$static_pagename = str_replace(FORUM_PATH, '{forum_path}', $static_pagename);
		
		
		// � $_SESSION['editstaticpageid'] ����������� ������������� ����������� �������
		// ���� ����������� �� ��������� ����� ���������
		session_start();
		$q = '';
		$message = '';		
		if(isset($_SESSION['editstaticpageid']))
		{	
			$q = "UPDATE ".DATABASE_TBLPERFIX."static SET static_pagename='".$static_pagename."', static_text='".$static_text."', static_keywords='".$static_keywords."' WHERE static_id='".$_SESSION['editstaticpageid']."'";
			$message = '������� ���������';
			unset($_SESSION['editstaticpageid']);	
		}
		else
		{
			$q = "INSERT INTO ".DATABASE_TBLPERFIX."static (static_pagename, static_text, static_keywords) VALUES ('".$static_pagename."', '".$static_text."', '".$static_keywords."')";
			$message = '����������� �������� ������������';
		}

		// ��������� ����������	
		AbstractDataBase::Instance()->query($q);
		
		$message = $message.'&nbsp;&nbsp;<a href="./index.php?staticpagelist">�����</a>';
		// ��������� ��������
		return $this->LoadEditPage(0,$message);	

	}
	
	// ��������� ������
	function LoadEditPage($id = 0, $message = "")
	{		
		$static_pagename = "";
		$static_text = "";		
		$static_keywords = "";
		
		// ��������� ��������� �� ������� ������
		if((is_numeric($id)) && ($id >= 1))
		{
			$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'static WHERE static_id = '.$id.' LIMIT 1');
			if($q)
			{	
				$line = AbstractDataBase::Instance()->get_row($q);
			
				if($line)
				{
					$static_pagename = $line['static_pagename'];	// ��������� ��������
					$static_text = $line['static_text'];			// ���������� ��������
					$static_keywords = $line['static_keywords'];	// �������� �����
					
					// �������� ���� � ����� �� ������
					$static_text = str_replace('{sitepath}', SITE_PATH, $static_text);
					// �������� ���� � ������ �� ������
					$static_text = str_replace('{forum_path}', FORUM_PATH, $static_text);
					// �������� ���� � ������ �� ������
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
		
		// �������� �������
		
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

	// �������� � ������� �������� ����  {title} � 
	// $template - ������ ������� ��������
	// $id - id ����������� ��������
	function RenderPage($template, $id)
	{	
		// ����� ��� �������� �� ����������� ����� 
		if((!is_numeric($id)) || ($id < 1))
		{	
			// ����������
			header("HTTP/1.0 404 Not Found");
			return '';
		}

		$q = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'static WHERE static_id = '.$id.' LIMIT 1');
		
		if(!$q)
		{	
			// ������ �� �������
			header("HTTP/1.0 404 Not Found");
			return '';
		}
		
		$line = AbstractDataBase::Instance()->get_row($q);
		
		if(!$line)
		{
			// ������ �� �������
			header("HTTP/1.0 404 Not Found");
			return '';
		}
				
		// ��������� ������
		$staticpage = file_get_contents("./skin/".SKIN."/templates/staticpage.tpl");			
		
		// {pagecontent}
		$staticpage = str_replace("{pagecontent}", $line['static_text'], $staticpage);
		
		//{sitecontent}
		$template = str_replace("{sitecontent}", $staticpage, $template);
		
		//{keywords} - �������� ���� ������ ���� �������� �����, ����� �� ��������� � index.php
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