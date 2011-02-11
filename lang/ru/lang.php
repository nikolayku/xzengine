<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////
// файл локализации. 


// feedback form
define("lang_feedback_done", 'Сообщение администратору отправлено . <a href="index.php">Назад на сайт</a>');
define("lang_feedback_nameverylong", 'Поле \'Имя\' должно быть меньше 60 символов');
define("lang_feedback_messageverylong", 'Поле \'Сообщение\' должно быть меньше 300 символов');
define("lang_feedback_invalidpiccode", 'Неправильно введено число с картинки');
define("lang_feedback_form", 'Форма обратного сообщения');

// adminpanel 
define("lang_goto_adminpanel", 'Админпанель');

// add news
define("lang_addnews_newsnameverylong", 'Имя новости не может быть больше 250 символов');
define("lang_addnews_newsautorverylong", 'Имя автора должно быть меньше 60 символов');
define("lang_addnews_edit", 'Новость отредактирована <a href="{sitepath}/admin/index.php?listnews"> Назад на сайт </a>');
define("lang_addnews_add", 'Новость добвлена <a href="{sitepath}/index.php"> назад на сайт </a>');
define("lang_addnews_invalidpiccode", 'Неправильно введено число с картинки');

// show news
define("show_news_not_found", 'Запрашиваемоя вами новость не найдена в нашей базе данных. Возможно она была удалена или перемещена <a href="{sitepath}"> Назад на сайт</a>');







?>