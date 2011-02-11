<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
//////////////////////////////////////////////////////////////////////////////////////////////

// ��������������� �������� ����������� ������� ���������� xzengine

Error_Reporting(E_ALL & ~E_NOTICE);

require_once './config.php';
require_once './php/common.php';
require_once './lang/'.INSTALL_LANG.'/lang.php';

$render_str = file_get_contents("./skin/".INSTALL_SKIN."/templates/index.tpl");


// ��� �� �������� ������� �� 5-�� PHP (��� ��� �� ��� �� ����� ����� PHP � ��� ����������)
$phpVersion = GetPHPVersionAsInt();
$phpMinVersion = str_replace(".", "", MINPHPVERSION);

// ��������� ���������� ������ PHP ������������� �� �������  � ���������, ���� �� �� ��������� � �������� ���������
if($phpVersion >= $phpMinVersion)
{	
	// ������� ���� PHP ����������
	header("Location: ./install.php");
	exit(0);
}

// �����  - ������ PHP �� ����������
// ��������� ������ ������ 

$page = file_get_contents("./skin/".INSTALL_SKIN."/templates/uncompatable.tpl");
// �������� ����

// {php_min_version}
$page = str_replace("{php_min_version}", MINPHPVERSION, $page);

// {php_version_current}
$page = str_replace("{php_version_current}", phpversion(), $page);

////////////////////////////////////// �������� ���� � ������� �������
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