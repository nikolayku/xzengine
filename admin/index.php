<?php
//////////////////////////////////////////////////////////////////////
// ����� ������
//////////////////////////////////////////////////////////////////////

// ��������� ���� 
define("API_HOME_DIR" ,"../modules/textdb/");
define("DB_DIR" ,"./backup/");

////////////////////////////////////////////////////////
// �������� �������� errors
require_once '../modules/bugreport.php';
require_once '../config.php';
if(DEBUG_MODE)
	BugReport::Instance()->EnableErrorsLog();
else
	error_reporting(0);
////////////////////////////////////////////////////////

require_once '../modules/database.php';
require_once '../modules/errorpage.php';
require_once '../classes/viewnews.php';
require_once '../classes/addnews.php';
require_once '../classes/admin.php';
require_once './classes/newslist.php';
require_once './classes/info.php';
require_once '../modules/gzip.php';
require_once './classes/settings.php';
require_once './classes/staticpages.php';
require_once './classes/uploadfile.php';
require_once './classes/commonfunctions.php';
require_once './classes/dbtools.php';
require_once '../classes/feedback.php';
require_once './classes/category.php';
require_once './classes/edittemplates.php';
require_once '../modules/textdb/txt-db-api.php';

$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/index.tpl");		// ������

$up = new userPriviliges();

$message = '�� ������� ������ �������������� - ���������� ��������������� <a href="../index.php">����� �� ����</a>';

// ���� ����������� cookies 

if(isset($_COOKIE['login']) && isset($_COOKIE['md5pass']))
{	
	if($up->IsUserExist($_COOKIE['login'], $_COOKIE['md5pass'], $message, true))
	{	
		$up->SetAdminCookies($_COOKIE['login'], $_COOKIE['md5pass'], false, true);
	}
}


// ���� ���������� $_GET['login'] �� ������������ ������ � �������
if(isset($_GET['login']))
{
	// ���� � �������
	$login = "";
	if(isset($_POST['login']))
		$login = $_POST['login'];
	
	$password = "";
	if(isset($_POST['password']))
		$password = $_POST['password'];
	
	// ��������� ������ � ��� ������������
	if($up->IsUserExist($login, $password, $message))
	{
		// ��������� cookies
		if($_POST['SaveOnThis']=='1')	// ���� ���� ��������� ������
			$up->SetAdminCookies($login, $password, true);
		else
			$up->SetAdminCookies($login, $password, false);		
		
	}
		
		
}

// ���� �������� $_GET['logout'] �� �������
if(isset($_GET['logout']))
{
	$up->RemoveCookies();	 
}



if($up->IsAdministrator())
{	
	
	$parseOne = true;	// �� ���� �������� �������� ����� ��������� ���� ��������	

	if(isset($_GET['edittemplates']) && $parseOne)
	{
		$ed = new EditTemplates();
		$render_str = str_replace("{sitecontent_admin}",$ed->LoadTemplate($render_str), $render_str);	

		$parseOne = false;
	}	

	// ������ � �����������
	if(isset($_GET['category']) && $parseOne)
	{	
		$message = '';
		$nc = new Category();
		
		if($_GET['category'] == 'add')		// ��������� ���������
		{
			$nc->AddCategory($render_str);	
		}
		else if($_GET['category']== 'delete') // ������� ���������
		{	
			$ID = 0;
			if(isset($_GET['ID']))
				$ID = $_GET['ID'];

			$nc->DeleteCategory($ID);
		}
				
		$render_str = str_replace("{sitecontent_admin}",$nc->GetCategoryList($render_str), $render_str);	

		$parseOne = false;
	}				

	// ������� ������ feedback ��������
	if(isset($_GET['feedbacklist']) && $parseOne)
	{	
			
		$message = '';
		$fb = new FeedBack();	
			
		if(isset($_GET['delete']))
		{
			$fb->FeedbackDelete($_GET['delete']);
		}	
	
		$render_str = str_replace("{sitecontent_admin}",$fb->FeedbackMessageList($render_str), $render_str);
		
		$parseOne = false;
	}				
	

	// �������� ��� ������ � ����� ������
	if(isset($_GET['dbtools']) && $parseOne)
	{		
		$message = '';
			
		$databasetools = new dbtools();
		
		if($_GET['dbtools'] =='optimize')
		{
			$message = $databasetools->optimize();
		}	
		
		if($_GET['dbtools'] =='repair')
		{
			$message = $databasetools->repair();
		}		

		$render_str = str_replace("{sitecontent_admin}", $databasetools->LoadTemplate($render_str ,$message), $render_str);
		$parseOne = false;
	}			
		
	
	// ����� ��������� ������ � ����� ������������
	if(isset($_GET['chusernameandpass']) && $parseOne)
	{		
		$message = '';
	
		if($_GET['chusernameandpass'] == 'change')
		{
			$up->ChangeUsernameAndPass();
			$message = '��� ������������ � ������ ��������.';
			
		}	
			
	
		$render_str = str_replace("{sitecontent_admin}", $up->LoadChangepasswordForm($message), $render_str);
		$parseOne = false;
	}			
	
	
	// ��������� ����� �������� ������
	if(isset($_GET['uploadfilelist']) && $parseOne)
	{		
		$message = '';
		$upfileorm = new UploadFile();		
		// �������� ������
		if($_GET['uploadfile'] == 'upload')
		{
			$message = $upfileorm->ParseUplodedFile();
		}
							
		// �������� ������������ �����		
		if(isset($_GET['deleteuploadfile']))
			$upfileorm->DeleteUploadFile($_GET['deleteuploadfile']);		

		$render_str = str_replace("{sitecontent_admin}", $upfileorm->LoadTemplate($message).$upfileorm->GetUploadDirectoryList($render_str), $render_str);
		$parseOne = false;
	}		
		
	
	// �������� ����������� ��������
	if(isset($_GET['staticpagedelete']) and $parseOne)
	{	
		
		$spage = new Pages();
		
		// �������
		$spage->DeleteStaticPage($_GET['staticpagedelete']);
		
		// ���������� ������ �������
		$render_str = str_replace("{sitecontent_admin}", $spage->GetStaticPageList($render_str), $render_str);
		$parseOne = false;
	}		
	
	// ����������� ������ ����������� �������
	if(isset($_GET['staticpagelist']) and $parseOne)
	{	
		
		$spage = new Pages();	
		$render_str = str_replace("{sitecontent_admin}", $spage->GetStaticPageList($render_str), $render_str);
		
		
		$parseOne = false;
	}			
	
	// ���������� ����������� �������� 
	if(isset($_GET['staticpageadd']) and $parseOne)
	{	
		
		$spage = new Pages();
		
		
		$render_str = str_replace("{sitecontent_admin}", $spage->AddOrUpdate(), $render_str);
		
		
		$parseOne = false;
	}		
	
	
	// ����������- �������������� ����������� �������� ���������� ����
	if(isset($_GET['staticpageedit']) and $parseOne)
	{	
		
		$spage = new Pages();
		
		$render_str = str_replace("{sitecontent_admin}", $spage->LoadEditPage($_GET['staticpageedit']), $render_str);
		
		$parseOne = false;
	}
		
	// �������� ����������� ��������	
	if(isset($_GET['listnews']) and $parseOne)
	{	
		if(isset($_GET['deleteid']))	// ������� �������
		{
			$ad = new addnews();
			$ad->deleteNews($_GET['deleteid']);
		}
		
		$page = 0;
		if(is_int($_GET['listnews']))
			$page = $_GET['listnews'];
		
		$nl = new listNews(); 
		
		$render_str = str_replace("{sitecontent_admin}", $nl->getnews($render_str,ADMINPANEL_NEWSPERPAGE, $page), $render_str);
		
		$parseOne = false;
	}
	
	//�������� ��������
	if(isset($_GET['config']) and $parseOne)
	{	
		$s = new EngineSettings();
		$message = '';
		if($_GET['config'] =='save')
		{
			$message = $s->SaveConfig('config.php');
			echo '<meta http-equiv="Refresh" content="0;URL=index.php?config" />';		

		}
		
		$render_str = str_replace("{sitecontent_admin}", $s->LoadSettingsFileAsTemplate($render_str, $message), $render_str);
		
		$parseOne = false;
	}
	
	// �������������� ��������	
	$ad = new addnews();	
	if(isset($_GET['id']) and $parseOne)
	{	
		$ad->editNews($_GET['id']);
		$parseOne = false;
	}
	else 
	{
		// ������� ���� ���� ���������� ���������� 
		$ad->FlushSession();
	}


	// �������� ����
	// {menu_admin}
	$menu = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/menu.tpl");
	$render_str = str_replace("{menu_admin}", $menu, $render_str);
	
	//���� ������ �� ������ ������ ������� ����������
	$i = new systemInfo(); 
	
	$render_str = str_replace("{sitecontent_admin}", $i->render(), $render_str);
	
}
else
{
	// ������������ �� �������������
	
	$render_str = str_replace("{menu_admin}", '', $render_str);
	
	// �������� ������ {sitecontent_admin}
	$render_str = str_replace("{sitecontent_admin}", $up->render($message), $render_str);

}

// {javascript_admin}
$render_str = str_replace("{javascript_admin}", "", $render_str);



// {skin_admin}
$render_str = str_replace("{skin_admin}", SITE_PATH.'/admin/skin/'.ADMINPANEL_SKIN, $render_str);

// {sitepath_admin}
$render_str = str_replace("{sitepath_admin}", SITE_PATH, $render_str);

//{forum_path_admin}	
$render_str = str_replace("{forum_path_admin}", FORUM_PATH, $render_str);

// {debug_log_admin} - ��� ������ ��������� �� ������� 
if(DEBUG_MODE)
	$render_str = str_replace("{debug_log_admin}", BugReport::Instance()->Flush(), $render_str);
else
	$render_str = str_replace("{debug_log_admin}", "", $render_str);


// ������� 
$z = new GZip();

ob_start();
ob_implicit_flush(0); 

echo $render_str;

// zip output 
if((GZIP_ENABLED == 1))
	$z->UseGZip(GZIP_COMPRESSION);


?>