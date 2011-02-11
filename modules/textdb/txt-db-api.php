<?php
//////////////////////////////////////////////////////////////////////////////////////////////
// part of xzengine 
// copyright 2007-2008 xzengine
// autor Kulchicky Nikolay
// Php Textfile DB API
// Copyright 2005 by c-worker.ch
// http://www.c-worker.ch
//////////////////////////////////////////////////////////////////////////////////////////////


// Directory where the API is located (Server Path, no URL)
$API_HOME_DIR="./modules/textdb/";	

$DB_DIR="./admin/backup/";			

// ----------- IGNORE FROM HERE (Users) --------------
if(!defined("API_HOME_DIR")) 			define("API_HOME_DIR" ,$API_HOME_DIR);
if(!defined("DB_DIR")) 					define("DB_DIR" ,$DB_DIR);

include_once(API_HOME_DIR . "resultset.php");
include_once(API_HOME_DIR . "database.php");


?>