<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////
// файл локализации. 


// feedback form
define("lang_feedback_done", 'Feedback message send . <a href="index.php">Return to site</a>');
define("lang_feedback_nameverylong", '\'Name\' field must be less than 300 characters');
define("lang_feedback_messageverylong", '\'Message\' field must be less than 300 characters');
define("lang_feedback_invalidpiccode", 'Wrong number from image, please try again');
define("lang_feedback_form", 'Feedback form');

// adminpanel 
define("lang_goto_adminpanel", 'Go to adminpanel');

// add news
define("lang_addnews_newsnameverylong", 'News name must be less than 250 characters');
define("lang_addnews_newsautorverylong", 'Autor name must be less than 60 characters');
define("lang_addnews_edit", 'News is edit <a href="{sitepath}/admin/index.php?listnews"> Back to site </a>');
define("lang_addnews_add", 'News is added <a href="{sitepath}/index.php"> Back to site </a>');
define("lang_addnews_invalidpiccode", 'Wrong number from image, please try again');

// show news
define("show_news_not_found", 'Sorry required news is not found in our database or removed <a href="{sitepath}"> Back to site </a>');

// for edit news
define("news_edit", '<a href="{sitepath}/admin/index.php?id={newsid}">Edit</a>');

// plugin load fail
define("plugin_load_fail", 'Plugin load fail');




?>
