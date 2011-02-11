<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<!-- мета теги-->
	<title>{title}</title>
	<meta name="keywords" content="{keywords}" />
	<meta name="description" content="{title}" />
	<meta name="generator" content="XZengine v.{versionnumber}" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<!-- java script -->
	{javascript}
	<link rel="stylesheet" type="text/css" href="{skin}/greeze/style.css" media="screen" />
</head>

<body>
<div id="wrapper">
	<ul id="top-menu">
	<!-- Header menu #Begin -->
		<li><a href="{sitepath}">Главная</a></li>
		<li><a href="index.php?feedback">Форма обратной связи</a></li>
		<li><a href="index.php?rss">RSS 2.0</a></li>
	<!-- Header menu #End -->
	</ul>
	<div id="header">
	<!-- Header #Begin -->
		<a href="{sitepath}" class="logo"><b>Xzengine</b></a>
		<div>Баннер</div>
	<!-- Header #End -->
	</div>
	<div id="main">
		<div id="content">
		<!-- Left column #Begin -->
			{sitecontent}
			<div class="pages">
				<div class="list">[ {lastpage} {pages} {nextpage} ]</div>
			</div>
		<!-- Left column #End -->
		</div>
	</div>
	<div id="sidebar">
	<!-- Right Column #Begin -->
		
		<div class="block yellow">
			<h5>Знакомство с сайтом</h5>
			<a href="#"><b>Xzengine.ru</b></a>	
			<span>{title}</span>
			<p>Ключевые слова: {keywords}</p>
		</div>

		<ul class="rss">
			<li><a href="#">Читать через Google</a></li>
			<li><a href="#">Читать через Яндекс</a></li>
			<li><a href="#">Получать RSS на e-mail</a></li>
		</ul>
		
		<div class="block">
			<h5><img src="{skin}/greeze/iurl.gif" alt="" />Реклама</h5>
			баннер
		</div>

		<div class="block">
			<h5><img src="{skin}/greeze/iview.gif" alt="" />Заголовок</h5>
			текст
		</div>
	<!-- Right Column #End -->
	</div>
	<div id="footer">
	<!-- Footer #Begin -->
		&copy; 2005-2007 Powered by xzengine v.{versionnumber} 
		<ul>
		<!-- Footer menu #Begin -->
			<li><a href="{sitepath}">Главная</a></li>
			<li><a href="index.php?feedback">Форма обратной связи</a></li>
			<li><a href="index.php?rss">RSS 2.0</a></li>
		<!-- Footer menu #End -->
		</ul>
		<div>
		<!-- Replace "width="88" height="31"" with "class="count"" (Counters #Begin) -->
			<img src="http://www.w3.org/Icons/valid-xhtml10" class="count" alt="valid html" />
			<img src="http://jigsaw.w3.org/css-validator/images/vcss" class="count" alt="valid css" />
		<!-- Counters #End -->
		</div>
	<!-- Footer #End -->
	</div>
</div>
</body>
</html><!--
2005-2007 Powered by xzengine v.{versionnumber} 
Страница сгенерирована за {page_gen_time} секунд 
использовано {number_sql_queries} запросов к БД
Ошибки выполнения скрипта:
{debug_log} 
-->