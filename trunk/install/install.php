<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
// мастер установки xzingine
// 
// $_GET['step'] - то какой сейчас следует делать шаг
//////////////////////////////////////////////////////////////////////////////////////////////

require_once './config.php';
require_once './lang/'.INSTALL_LANG.'/lang.php';
require_once './php/common.php';

// указываем путь 
define("API_HOME_DIR" ,"../modules/textdb/");
define("DB_DIR" ,"../admin/backup/");

require_once '../modules/textdb/txt-db-api.php';

// страницы 
require_once './php/page0.php';
require_once './php/page1.php';
require_once './php/page2.php';
require_once './php/page3.php';
require_once './php/page_dbtype.php';
require_once './php/config_textdb.php';



$step = "hello";
$getStep = $_GET['step'];
if(isset($getStep))
	$step = $getStep;
	
$render_str = file_get_contents("./skin/".INSTALL_SKIN."/templates/index.tpl");


//////////////////////////////////////////////////////////////////////////////////////
// страница приветстви€
if($step == "hello")
{
	$page0 = new page0();
	// {body}
	$render_str = str_replace("{sitecontent}", $page0->doPage0($render_str), $render_str);
}

// права на запись к папкам
if($step == "permissions")
{
	$page1 = new page1();
	// {body}
	$render_str = str_replace("{sitecontent}", $page1->doPage1($render_str), $render_str);
}

// выбор типа базы mysql или текстова€
if($step == "dbtype")
{
	$page = new Page_dbtype();
	// {body}
	$render_str = str_replace("{sitecontent}", $page->doPage_dbtype($render_str), $render_str);
}

// настройка Ѕƒ mysql
if($step == "mysqlconfig")
{
	$page2 = new page2();
	// {body}
	$render_str = str_replace("{sitecontent}", $page2->doPage2($render_str), $render_str);
	
}

// настройка текстовой бд
if($step == "textbdconfig")
{
	$page2 = new Page_textbdconfig();
	// {body}
	$render_str = str_replace("{sitecontent}", $page2->doPage_textbdconfig($render_str), $render_str);
	
}

// дополнительные парамеры
if($step == "params")
{
	$page3 = new page3();
	// {body}
	$render_str = str_replace("{sitecontent}", $page3->doPage3($render_str), $render_str);
}

//////////////////////////////////////////////////////////////////////////////////////

// теги доступные на всех страницах
// {skin}
$render_str = str_replace("{skin}", "./skin/".INSTALL_SKIN, $render_str);

// {javascript}
$render_str = str_replace("{javascript}", "", $render_str);


echo $render_str;

?>