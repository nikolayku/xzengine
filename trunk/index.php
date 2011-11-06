<?php
////////////////////////////////////////////////////////
// xzengine
///////////////////////////////////////////////////////
// если передано $_GET['addnews'] то добавляем новость
// если передано $_GET['page'] то показываем страницу с новостью

// если нету config.php файла , значит система ещё не установлена
if(filesize("./config.php") == 0)
{	
	// редректим на страницу установки
	header("Location: ./install/index.php");
	exit();
}

////////////////////////////////////////////////////////
// включаем перехват errors
require_once './modules/bugreport.php';
require_once './config.php';
if(DEBUG_MODE)
	BugReport::Instance()->EnableErrorsLog();
else
	error_reporting(0);
////////////////////////////////////////////////////////


// запоминаем время
$time_start = microtime(1);

// информация о версии

$VERSION_MAJOR	= '2';		// старшая версия
$VERSION_MINOR	= '0';		// младшая версия
$VERSION_INFO	= 'beta 1';	// дополнительная информация

// записываем в заголовок время последнего изменения страницы
// FIXME: а надо ? поисковики любят когда страница не изменяется
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

// языковые настройки
require_once './lang/'.SITE_LOC_FILE.'/lang.php';

// создаём БД
AbstractDataBase::Instance()->zero_number_of_queries(); // обнуляем количество запросов

// инициализируем plugin менеджер
PluginManager::Instance();

// проверяем отключён ли сайт
if(OFF_SITE)
{	
	// если администратор то загружаем обычный шаблон 	
	if(userPriviliges::IsAdministrator())
		$render_str = file_get_contents("./skin/".SKIN."/templates/index.tpl");		// шаблон
	else
	{
		$render_str = file_get_contents("./skin/".SKIN."/templates/offsite.tpl");	// сайт выключен
		// заменяем сообщение пользователю
		$render_str = str_replace("{message}", OFF_SITE_MESSAGE, $render_str);
	}
}
else
{
	$render_str = file_get_contents("./skin/".SKIN."/templates/index.tpl");		// шаблон
}


$page_news =  new viewnews();
$readmore = new showfullnews();

$page = 0;
$category = 0;				// категория (0 если главная)

// какую страницу выводить
if(isset($_GET['page']))
	$page = $_GET['page'];


// какую категорию выводить
if(isset($_GET['category']) && is_numeric($_GET['category']))
	$category = $_GET['category'];

// выводим Rss если требуют
if(isset($_GET['rss']))
{
	$rss = new RssGen();
	$rss->GenRss();
	// выходим	
	exit();
}	


// форма обратной связи
if(isset($_GET['feedback']))
{
	$fb = new FeedBack();
	
	$message = '';
	
	if($_GET['feedback'] == 'send')
		$message = $fb->SendFeedBack();	
	
	$render_str = str_replace("{sitecontent}", $fb->RenderFeedBackTemplate($render_str, $message), $render_str);	
}


// если определена ссылка на полное описание новости
if(isset($_GET['readmore']))
{
	$render_str = str_replace("{sitecontent}", $readmore->ShowFullNews($_GET['readmore'], $render_str), $render_str);
	
	//прячем стрелки 
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page, $category);
	
	//{pages}
	$render_str = str_replace("{pages}", "", $render_str);


}


// если определена ссылка на статическую новость
if(isset($_GET['news']))
{
	$render_str = str_replace("{sitecontent}", $page_news->ShowConstLinkTemplate($_GET['news'], $render_str), $render_str);
	
	//прячем стрелки 
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page , $category);
	
	//{pages}
	$render_str = str_replace("{pages}", "", $render_str);


}

// если определена статическая страница
if(isset($_GET['spage']))
{
	$spage = new Pages();
	
	// получаем содержимое статической страницы	
	$render_str = $spage->RenderPage($render_str, $_GET['spage']);

	//прячем стрелки 
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page , $category);
	
	//{pages}
	$render_str = str_replace("{pages}", "", $render_str);
		
}


// обрабатываем основные теги

// {sitecontent}
$addn = new addnews();
if(isset($_GET['addnews']))  //добавляем новость
{	
	if(userPriviliges::IsAdministrator() )
	{	
		// добавление новости
		$message = "";	

		if($_GET['addnews'] == 'post')
		{
			$addn->Check($message);
		}
		
		// показываем страницу
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
			

			// показываем страницу
			$templ = $addn->render($render_str, $message);
			$render_str = str_replace("{sitecontent}", $templ, $render_str);
		}
		else
		{
			// загружаем шаблон 
			$addnewsfailure = file_get_contents("./skin/".SKIN."/templates/addnewsfailure.tpl");
			// заменяем контент сайта
			$render_str = str_replace("{sitecontent}", $addnewsfailure, $render_str);	
		}
	}
	// не показываем стрелки
	$render_str = $page_news->getPagesGrild($render_str, false, NEWSPERPAGE, $page , $category);
		
	//{pages}
	$render_str = str_replace("{pages}", '', $render_str);
}
else
{
	// удаляем сессионную информацию 	
	$addn->FlushSession();
	
	// показываем список новостей
	$render_str = str_replace("{sitecontent}", $page_news->getnews(NEWSPERPAGE, $page, $category), $render_str);
	
	// страницы
	$render_str = $page_news->getPagesGrild($render_str, true, NEWSPERPAGE, $page , $category);
	
	//{pages}
	$render_str = str_replace("{pages}", $page_news->GetPagesList($category), $render_str);

}

// {title} - заголовок страницы
$render_str = str_replace("{title}", SITE_TITLE, $render_str);

// {keywords} - заголовок страницы
$keywords = SITE_KEYWORDS;
if($category != 0)
{	
	// показываем ключевые слова для категории
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
// FIXME: подумать
$render_str = str_replace("{skin}", '{sitepath}/skin/'.SKIN, $render_str);

//{versionnumber} - текущяя версия
$render_str = str_replace("{versionnumber}", $VERSION_MAJOR.'.'.$VERSION_MINOR.' '.$VERSION_INFO, $render_str);

//{adminpanellink} - ссылка на админ панель, показывается только если пользователь зашёл как администратор
if(userPriviliges::IsAdministrator())
	$render_str = str_replace("{adminpanellink}", '<a href="'.SITE_PATH.'/admin/index.php">'.lang_goto_adminpanel.'</a>', $render_str);
else
	$render_str = str_replace("{adminpanellink}", '', $render_str);	
	
//{forum_path} - путь к форуму	
$render_str = str_replace("{forum_path}", FORUM_PATH, $render_str);

//{number_sql_queries}	
$render_str = str_replace("{number_sql_queries}", AbstractDataBase::Instance()->get_number_of_queries(), $render_str);

// {javascript} - javascript код на странице
$JavaScript = 
'<script src="{sitepath}/javascript/common.js" type="text/javascript" language="javascript"></script>';
$render_str = str_replace("{javascript}", $JavaScript, $render_str);

// {sitepath} - путь к сайту
$render_str = str_replace("{sitepath}", SITE_PATH, $render_str);

// {pageurl} - показывает полный путь к текущей странице
$render_str = str_replace("{pageurl}", 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $render_str);

// получаем время генерации страницы
$page_gen_time = microtime(1) - $time_start;

//{page_gen_time} - время генерации страницы	
$render_str = str_replace("{page_gen_time}", substr($page_gen_time,0, 5), $render_str);

// {debug_log} - тег вывода сообщений об ошибках 
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
