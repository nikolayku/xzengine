<?php
////////////////////////////////////////////////////////
// xzengine
///////////////////////////////////////////////////////
// ���� �������� $_GET['addnews'] �� ��������� �������
// ���� �������� $_GET['page'] �� ���������� �������� � ��������

// ���� ���� config.php ����� , ������ ������� ��� �� �����������
if(filesize("./config.php") == 0)
{	
	// ��������� �� �������� ���������
	header("Location: ./install/index.php");
	exit();
}

////////////////////////////////////////////////////////
// �������� �������� errors
require_once './modules/bugreport.php';
require_once './config.php';
if(DEBUG_MODE)
	BugReport::Instance()->EnableErrorsLog();
else
	error_reporting(0);
////////////////////////////////////////////////////////


// ���������� �����
$time_start = microtime(1);

// ���������� � ������

$VERSION_MAJOR	= '2';		// ������� ������
$VERSION_MINOR	= '0';		// ������� ������
$VERSION_INFO	= 'beta 1';	// �������������� ����������

// ���������� � ��������� ����� ���������� ��������� ��������
// FIXME: � ���� ? ���������� ����� ����� �������� �� ����������
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

require_once './modules/database.php';
require_once './modules/errorpage.php';
require_once './classes/viewnews.php';
require_once './classes/addnews.php';
require_once './classes/admin.php';
require_once './classes/viewfullnews.php';
require_once './modules/gzip.php';
require_once './classes/rss.php';
require_once './classes/feedback.php';
require_once './admin/classes/staticpages.php';
require_once './modules/textdb/txt-db-api.php';
require_once './modules/pluginmanager.php';

// �������� ���������
require_once './lang/'.SITE_LOC_FILE.'/lang.php';

// ������ ��
AbstractDataBase::Instance()->zero_number_of_queries(); // �������� ���������� ��������

// �������������� plugin ��������
PluginManager::Instance();

// ��������� �������� �� ����
if(OFF_SITE)
{	
	// ���� ������������� �� ��������� ������� ������ 	
	if(userPriviliges::IsAdministrator())
		$render_str = file_get_contents("./skin/".SKIN."/templates/index.tpl");		// ������
	else
	{
		$render_str = file_get_contents("./skin/".SKIN."/templates/offsite.tpl");	// ���� ��������
		// �������� ��������� ������������
		$render_str = str_replace("{message}", OFF_SITE_MESSAGE, $render_str);
	}
}
else
{
	$render_str = file_get_contents("./skin/".SKIN."/templates/index.tpl");		// ������
}


$page_news =  new viewnews();
$readmore = new showfullnews();

$page = 0;
$category = 0;				// ��������� (0 ���� �������)

// ����� �������� ��������
if(isset($_GET['page']))
	$page = $_GET['page'];


// ����� ��������� ��������
if(isset($_GET['category']) && is_numeric($_GET['category']))
	$category = $_GET['category'];

// ������� Rss ���� �������
if(isset($_GET['rss']))
{
	$rss = new RssGen();
	$rss->GenRss();
	// �������	
	exit();
}	


// ����� �������� �����
if(isset($_GET['feedback']))
{
	$fb = new FeedBack();
	
	$message = '';
	
	if($_GET['feedback'] == 'send')
		$message = $fb->SendFeedBack();	
	
	$render_str = str_replace("{sitecontent}", $fb->RenderFeedBackTemplate($render_str, $message), $render_str);	
}


// ���� ���������� ������ �� ������ �������� �������
if(isset($_GET['readmore']))
{
	$render_str = str_replace("{sitecontent}", $readmore->ShowFullNews($_GET['readmore'], $render_str), $render_str);
	
	//������ ������� 
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page, $category);
	
	//{pages}
	$render_str = str_replace("{pages}", "", $render_str);


}


// ���� ���������� ������ �� ����������� �������
if(isset($_GET['news']))
{
	$render_str = str_replace("{sitecontent}", $page_news->ShowConstLinkTemplate($_GET['news'], $render_str), $render_str);
	
	//������ ������� 
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page , $category);
	
	//{pages}
	$render_str = str_replace("{pages}", "", $render_str);


}

// ���� ���������� ����������� ��������
if(isset($_GET['spage']))
{
	$spage = new Pages();
	
	// �������� ���������� ����������� ��������	
	$render_str = $spage->RenderPage($render_str, $_GET['spage']);

	//������ ������� 
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page , $category);
	
	//{pages}
	$render_str = str_replace("{pages}", "", $render_str);
		
}


// ������������ �������� ����

// {sitecontent}
$addn = new addnews();
if(isset($_GET['addnews']))  //��������� �������
{	
	if(userPriviliges::IsAdministrator() )
	{	
		// ���������� �������
		$message = "";	

		if($_GET['addnews'] == 'post')
		{
			$addn->Check($message);
		}
		
		// ���������� ��������
		$templ = $addn->render($render_str, $message);
		$render_str = str_replace("{sitecontent}", $templ, $render_str);
			
	}
	else	
	{	
		if(USERS_CAN_ADD_NEWS)
		{	
			$message = "";	

			if($_GET['addnews'] == 'post')
			{
				$addn->Check($message);
			}
			

			// ���������� ��������
			$templ = $addn->render($render_str, $message);
			$render_str = str_replace("{sitecontent}", $templ, $render_str);
		}
		else
		{
			// ��������� ������ 
			$addnewsfailure = file_get_contents("./skin/".SKIN."/templates/addnewsfailure.tpl");
			// �������� ������� �����
			$render_str = str_replace("{sitecontent}", $addnewsfailure, $render_str);	
		}
	}
	// �� ���������� �������
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page , $category);
		
	//{pages}
	$render_str = str_replace("{pages}", '', $render_str);
}
else
{
	// ������� ���������� ���������� 	
	$addn->FlushSession();
	
	// ���������� ������ ��������
	$render_str = str_replace("{sitecontent}", $page_news->getnews(NEWSPERPAGE, $page, $category), $render_str);
	
	// ��������
	$render_str = $page_news->getPagesGrild($render_str, true, NEWSPERPAGE, $page , $category);
	
	//{pages}
	$render_str = str_replace("{pages}", $page_news->GetPagesList($category), $render_str);

}

// {title} - ��������� ��������
$render_str = str_replace("{title}", SITE_TITLE, $render_str);

// {keywords} - ��������� ��������
$keywords = SITE_KEYWORDS;
if($category != 0)
{	
	// ���������� �������� ����� ��� ���������
	$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'category WHERE category_id='.$category.' LIMIT 1';	
	$result = AbstractDataBase::Instance()->query($q );	
	
	if($result)
	{
		$newsfound = AbstractDataBase::Instance()->get_row($result);	
		print_r($newsfound);
		if($newsfound && (trim($newsfound['category_descr']) != ""))
			$keywords = $newsfound['category_descr'];
	}
}
$render_str = str_replace("{keywords}", $keywords, $render_str);

// {skin}
// FIXME: ��������
$render_str = str_replace("{skin}", '{sitepath}/skin/'.SKIN, $render_str);

//{versionnumber} - ������� ������
$render_str = str_replace("{versionnumber}", $VERSION_MAJOR.'.'.$VERSION_MINOR.' '.$VERSION_INFO, $render_str);

//{adminpanellink} - ������ �� ����� ������, ������������ ������ ���� ������������ ����� ��� �������������
if(userPriviliges::IsAdministrator())
	$render_str = str_replace("{adminpanellink}", '<a href="'.SITE_PATH.'/admin/index.php">'.lang_goto_adminpanel.'</a>', $render_str);
else
	$render_str = str_replace("{adminpanellink}", '', $render_str);	
	
//{forum_path} - ���� � ������	
$render_str = str_replace("{forum_path}", FORUM_PATH, $render_str);

//{number_sql_queries}	
$render_str = str_replace("{number_sql_queries}", AbstractDataBase::Instance()->get_number_of_queries(), $render_str);

// {javascript} - javascript ��� �� ��������
$JavaScript = 
'<script src="{sitepath}/javascript/common.js" type="text/javascript" language="javascript"></script>';
$render_str = str_replace("{javascript}", $JavaScript, $render_str);

// {sitepath} - ���� � �����
$render_str = str_replace("{sitepath}", SITE_PATH, $render_str);

// {pageurl} - ���������� ������ ���� � ������� ��������
$render_str = str_replace("{pageurl}", 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $render_str);

// �������� ����� ��������� ��������
$page_gen_time = microtime(1) - $time_start;

//{page_gen_time} - ����� ��������� ��������	
$render_str = str_replace("{page_gen_time}", substr($page_gen_time,0, 5), $render_str);

// {debug_log} - ��� ������ ��������� �� ������� 
if(DEBUG_MODE)
	$render_str = str_replace("{debug_log}", BugReport::Instance()->Flush(), $render_str);
else
	$render_str = str_replace("{debug_log}", "", $render_str);

PluginManager::Instance()->ApplyTagPlugins($render_str);


$z = new GZip();

ob_start();
ob_implicit_flush(0); 


echo $render_str;

// zip output 
if((GZIP_ENABLED == 1))
	$z->UseGZip(GZIP_COMPRESSION);


?>
