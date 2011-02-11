<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// предварительная проверка способности сервера установить xzengine

Error_Reporting(E_ALL & ~E_NOTICE);

require_once './config.php';
require_once './php/common.php';
require_once './lang/'.INSTALL_LANG.'/lang.php';

$render_str = file_get_contents("./skin/".INSTALL_SKIN."/templates/index.tpl");


// нам не доступны функции от 5-го PHP (так как мы ещё не знаем какой PHP у нас установлен)
$phpVersion = GetPHPVersionAsInt();
$phpMinVersion = str_replace(".", "", MINPHPVERSION);

// проверяем совместима версия PHP установленная на сервере  с эталонной, если да то переходим к процессу установки
if($phpVersion >= $phpMinVersion)
{	
	// проблем нету PHP совместимы
	header("Location: ./install.php");
	exit(0);
}

// иначе  - версии PHP не совместимы
// загружаем шаблон вывода 

$page = file_get_contents("./skin/".INSTALL_SKIN."/templates/uncompatable.tpl");
// заменяем теги

// {php_min_version}
$page = str_replace("{php_min_version}", MINPHPVERSION, $page);

// {php_version_current}
$page = str_replace("{php_version_current}", phpversion(), $page);

////////////////////////////////////// заменяем теги в главном шаблоне
// {sitecontent}
$render_str = str_replace("{sitecontent}", $page, $render_str);

// {title}
$render_str = str_replace("{title}", different_versons, $render_str);


// {skin}
$render_str = str_replace("{skin}", "./skin/".INSTALL_SKIN, $render_str);

// {javascript}
$render_str = str_replace("{javascript}", "", $render_str);
echo $render_str;


?>