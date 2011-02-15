<?php

// ���������� ��������



// ���������� ��������
class addnews
{
	// �����������
	function __construct()
	{	
		session_start();
	}
		
	// ������� ������� �� ��
	function deleteNews($id)
	{
		// ��������....
		AbstractDataBase::Instance()->query('DELETE FROM '.DATABASE_TBLPERFIX.'news WHERE news_id="'.$id.'"');		
	}
		

	// $message - ��������� ������� ����� ���������
	// $main_page_template - ������ ������� ��������
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
		// �������� ���������
		// ���������� ������ ���� ���������
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
				// ���������� ������ ���� ���������
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
		
		// �������� ����
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
		
		// ���������� ����������� ����� ������ (��� ��������������)
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
			// ���������� ������� ����� ������
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
		
		// �������� ����
		
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
	// ��������� ����������� ����� ������
	// ���������� true ��� false � ����������� �� ���� ��� ������ ��������
	/////////////////////////////////////
	function Check(&$message)
	{	
		// ��������� �������� �� ������������ ���������������
		$isadmin = 	userPriviliges::IsAdministrator();
		
		// ����� ���������� �������
		$news_fixed = 0;		// �������������
		$news_approve = 0;		// ��������� �������
		$news_view = 0;			// ���������� ������� �� �����		

		if(!$isadmin)
		{
			// ���� �� ������������� �� ������ ���� ���������� ����� � ��������
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
		
		
		// �������� ���� � ����� �� ������
		$news_sh_description = str_replace(SITE_PATH, '{sitepath}', $news_sh_description);
		$news_showfull = str_replace(SITE_PATH, '{sitepath}', $news_showfull);
		
		
		// �������� ���� � ������ �� ������
		$news_sh_description = str_replace(FORUM_PATH, '{forum_path}', $news_sh_description);
		$news_full_link = str_replace(FORUM_PATH, '{forum_path}', $news_full_link);		
		$news_showfull = str_replace(FORUM_PATH, '{forum_path}', $news_showfull);		

		
		$news_full_or_link = 1;
		// ���������� ����� ������ ������������ - �� ������ ������� ��� �� ������ ����
		if((strlen($news_showfull) > 0) and (strlen($news_full_link) == 0))
			$news_full_or_link = 1;
		else
			$news_full_or_link = 0;	

		// ������
		
		if(isset($_SESSION['edit_id']))
		{
			$q = "UPDATE ".DATABASE_TBLPERFIX."news SET news_name='".$news_name."', news_sh_description='".$news_sh_description."',news_autor='".$news_autor."', news_full_link='".$news_full_link."', news_date='".$t."', news_fixed = '".$news_fixed."', news_view='".$news_view."', news_approve='".$news_approve."',news_showfull='".$news_showfull."', news_full_or_link='".$news_full_or_link."', news_category='".$news_category."', news_keyword='".$news_keyword."' WHERE news_id='".$_SESSION['edit_id']."'";
		}
		else
		{
			$q = "INSERT INTO ".DATABASE_TBLPERFIX."news (news_name, news_sh_description, news_autor, news_full_link, news_date, news_fixed, news_view, news_approve , news_showfull, news_full_or_link, news_category, news_keyword) VALUES ('".$news_name."', '".$news_sh_description."', '".$news_autor."', '".$news_full_link."', '".$t."', '".$news_fixed."', '".$news_view."', '".$news_approve."', '".$news_showfull."', '".$news_full_or_link."', '".$news_category."','".$news_keyword."')";		
		}
		
		
		AbstractDataBase::Instance()->query($q);	
		
		// ���� ��� �������������� ������� �� ��������� �� �������� ��������� � �������������� ��������
		if(isset($_SESSION['edit_id']))
			$message = lang_addnews_edit;

		else	
			$message = lang_addnews_add;
		
			
		// ���������� �������� ���� �� ������ ������
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
	// ��������������� ������� - ���������� ��������� ���������� ����������
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
	// ��������������� ������� - ���������� ���������� ���������� ��� ������������ �������������� 
	////////////////////////////////////////////////////////
	
	function editNews($id = 0)
	{
		// �������� �������
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'news WHERE news_id='.$id.' LIMIT 1 ');
		
		// ���� ������ �� ������� �� ������������� �� ������� ��������
		if(!$result)
			echo '<meta http-equiv="Refresh" content="0;URL=index.php" />';
		
		$line = AbstractDataBase::Instance()->get_row($result);
		
		// ������������� ����������
		
		$_SESSION['edit_id'] = $id;
		
		$_SESSION['news_name'] = $line['news_name'];
		$_SESSION['news_sh_description'] = $line['news_sh_description'];
		$_SESSION['news_full_link'] = $line['news_full_link'];
		$_SESSION['news_autor'] = $line['news_autor'];
		$_SESSION['news_showfull'] = $line['news_showfull'];		
		$_SESSION['news_category'] = $line['news_category'];		
		$_SESSION['news_keyword'] = $line['news_keyword'];		

		// �����
		$_SESSION['news_fixed'] = $line['news_fixed'];	
		$_SESSION['news_view'] = $line['news_view'];			
		$_SESSION['news_approve'] = $line['news_approve'];		
		
		// �������� �� �������� �������������� ������� (��� ����� ��� ��� ����������� , ��� � ��� �������� ������������)	
		echo '<meta http-equiv="Refresh" content="0;URL=../index.php?addnews" />';
		
	}
					 	
}

?>