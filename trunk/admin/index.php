<?php
//////////////////////////////////////////////////////////////////////
// админ панель
//////////////////////////////////////////////////////////////////////

// указываем путь 
define("API_HOME_DIR" ,"../modules/textdb/");
define("DB_DIR" ,"./backup/");

////////////////////////////////////////////////////////
// включаем перехват errors
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
require_once './classes/commonfunctions.php';
require_once './classes/dbtools.php';
require_once '../classes/feedback.php';
require_once './classes/category.php';
require_once './classes/edittemplates.php';
require_once '../modules/textdb/txt-db-api.php';

$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/index.tpl");		// шаблон

// FIXME: перенести в локализацию
$message = 'Не найдена сессия администратора - пожалуйста авторизируйтесь <a href="../index.php">Назад на сайт</a>';


// если определено $_GET['login'] то пользователь входит в систему
if(isset($_GET['login']))
{
	// вход в систему
	$login = "";
	if(isset($_POST['login']))
		$login = $_POST['login'];
	
	$password = "";
	if(isset($_POST['password']))
		$password = $_POST['password'];
	
	// проверяем пароль и имя пользователя
	if(userPriviliges::IsUserExist($login, $password, $message))
	{
		// сохраняем cookies
		if($_POST['SaveOnThis']=='1')	// если надо сохранять кукисы
			userPriviliges::SetAdminCookies($login, $password, true);
		else
			userPriviliges::SetAdminCookies($login, $password, false);		
		
	}	
}

// если определён $_GET['logout'] то выходим
if(isset($_GET['logout']))
	userPriviliges::RemoveCookies();	 


// если пользователь администратор
if(userPriviliges::IsAdministrator())
{	
	if(isset($_GET['edittemplates']))
	{	
		// редактирование шаблонов 
		
		$ed = new EditTemplates();
		$render_str = str_replace("{sitecontent_admin}",$ed->LoadTemplate($render_str), $render_str);	

	}	
	else if(isset($_GET['category']))
	{	
		// работа с категориями
		
		$message = '';
		$nc = new Category();
		
		if($_GET['category'] == 'add')		// добавляем категорию
			$nc->AddCategory($render_str);	
		else if($_GET['category']== 'delete') // удаляем категорию
		{	
			$ID = 0;
			if(isset($_GET['ID']))
				$ID = $_GET['ID'];

			$nc->DeleteCategory($ID);
		}
				
		$render_str = str_replace("{sitecontent_admin}",$nc->GetCategoryList($render_str), $render_str);	
	}				
	else if(isset($_GET['feedbacklist']))
	{	
		// выводим список feedback новостей	
		
		$message = '';
		$fb = new FeedBack();	
			
		if(isset($_GET['delete']))
			$fb->FeedbackDelete($_GET['delete']);
		
		$render_str = str_replace("{sitecontent_admin}",$fb->FeedbackMessageList($render_str), $render_str);
	}				
	else if(isset($_GET['dbtools']))
	{	
		// страница для работы с базой данных
		
		$message = '';
		$databasetools = new dbtools();
		
		if($_GET['dbtools'] =='optimize')
			$message = $databasetools->optimize();
		
		if($_GET['dbtools'] =='repair')
			$message = $databasetools->repair();
		
		$render_str = str_replace("{sitecontent_admin}", $databasetools->LoadTemplate($render_str ,$message), $render_str);
	}			
	
	else if(isset($_GET['uploadfilelist']))
	{	
		// загружаем форму загрузки файлов
		
		$message = '';
		$upfileorm = new UploadFile();		
		// загрузка файлов
		if($_GET['uploadfile'] == 'upload')
		{
			$message = $upfileorm->ParseUplodedFile();
		}
							
		// удаление загруженного файла		
		if(isset($_GET['deleteuploadfile']))
			$upfileorm->DeleteUploadFile($_GET['deleteuploadfile']);		

		$render_str = str_replace("{sitecontent_admin}", $upfileorm->LoadTemplate($message).$upfileorm->GetUploadDirectoryList($render_str), $render_str);
	}		
	else if(isset($_GET['staticpagedelete']))
	{	
		// удаление статической страницы
		
		$spage = new Pages();
		
		// удаляем
		$spage->DeleteStaticPage($_GET['staticpagedelete']);
		
		// показываем список страниц
		$render_str = str_replace("{sitecontent_admin}", $spage->GetStaticPageList($render_str), $render_str);
	}		
	else if(isset($_GET['staticpagelist']))
	{	
		// показывание списка статических страниц	
		
		$spage = new Pages();	
		$render_str = str_replace("{sitecontent_admin}", $spage->GetStaticPageList($render_str), $render_str);

	}			
	else if(isset($_GET['staticpageadd']))
	{	
		// добавление статической страницы 
		
		$spage = new Pages();
		$render_str = str_replace("{sitecontent_admin}", $spage->AddOrUpdate(), $render_str);
	}		
	else if(isset($_GET['staticpageedit']))
	{	
		// добавление- редактирование статической страницы диалоговое окно
		
		$spage = new Pages();
		$render_str = str_replace("{sitecontent_admin}", $spage->LoadEditPage($_GET['staticpageedit']), $render_str);
	}
	else if(isset($_GET['listnews']))
	{	
		// просмотр добавленных новостей	
		
		if(isset($_GET['deleteid']))	// удаляем новость
		{
			$ad = new addnews();
			$ad->deleteNews($_GET['deleteid']);
		}
		
		$page = 0;
		if(is_int($_GET['listnews']))
			$page = $_GET['listnews'];
		
		$nl = new listNews(); 
		
		$render_str = str_replace("{sitecontent_admin}", $nl->getnews($render_str,ADMINPANEL_NEWSPERPAGE, $page), $render_str);

	}
	else if(isset($_GET['config']))
	{	
		//страница настроек
	
		$message = '';
		if($_GET['config'] =='save')
		{
			$message = EngineSettings::SaveConfig('config.php');
			echo '<meta http-equiv="Refresh" content="0;URL=index.php?config" />';		

		}
		
		$render_str = str_replace("{sitecontent_admin}", EngineSettings::LoadSettingsFileAsTemplate($render_str, $message), $render_str);
	}
	else if(isset($_GET['id']))
	{
		// редактирование новостей
		
		$ad = new addnews();
		$ad->editNews($_GET['id']);
	}
	else
	{
		$ad = new addnews();	
		// удаляем если есть сиссионные переменные 
		$ad->FlushSession();
	}
	


	// заменяем меню
	// {menu_admin}
	$menu = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/menu.tpl");
	$render_str = str_replace("{menu_admin}", $menu, $render_str);
	
	//если ничего не вывели значит выводим статистику
	$i = new systemInfo(); 
	
	$render_str = str_replace("{sitecontent_admin}", $i->render(), $render_str);
	
}
else
{
	// пользователь не администратор
	// скрываем меню
	$render_str = str_replace("{menu_admin}", '', $render_str);
	
	// заменяем шаблон {sitecontent_admin}
	$render_str = str_replace("{sitecontent_admin}", userPriviliges::render($message), $render_str);
}

// {javascript_admin}
$render_str = str_replace("{javascript_admin}", "", $render_str);

// {skin_admin}
$render_str = str_replace("{skin_admin}", SITE_PATH.'/admin/skin/'.ADMINPANEL_SKIN, $render_str);

// {sitepath_admin}
$render_str = str_replace("{sitepath_admin}", SITE_PATH, $render_str);

//{forum_path_admin}	
$render_str = str_replace("{forum_path_admin}", FORUM_PATH, $render_str);

// {debug_log_admin} - тег вывода сообщений об ошибках 
if(DEBUG_MODE)
	$render_str = str_replace("{debug_log_admin}", BugReport::Instance()->Flush(), $render_str);
else
	$render_str = str_replace("{debug_log_admin}", "", $render_str);


// выводим 
$z = new GZip();

ob_start();
ob_implicit_flush(0); 

echo $render_str;

// zip output 
if((GZIP_ENABLED == 1))
	$z->UseGZip(GZIP_COMPRESSION);


?>