<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{title}</title>
	<!-- мета теги-->
	<meta name="keywords" content="{keywords}" />
	<meta name="description" content="{title}" />
	<meta name="generator" content="XZengine v.{versionnumber}" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<!-- стили -->
	<link href="{skin}/style.css" rel="stylesheet" type="text/css" media="screen" />
	<style type=text/css media=screen>
		body {
		margin: 0;
		padding: 0;
		background: #333333 url({skin}/images/img01.gif) repeat-x;
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		font-size: 13px;
		color: #666666;
		}
		
		ul {
		list-style-image: url({skin}/images/img07.gif);
		}
		
		#menu {
		width: 778px;
		height: 45px;
		margin: 0 auto;
		background: #F6F6F6 url({skin}/images/img02.gif) no-repeat;
		}
		
		#menu .current_page_item a {
		background: url({skin}/images/img06.gif) repeat-x;
		}

		#page {
		width: 778px;
		margin: 0 auto;
		background: #FFFFFF url({skin}/images/img05.gif) repeat-y;
		}

		#page-bg {
		padding: 11px 24px;
		background: url({skin}/images/img03.jpg) no-repeat;
		}
		
		#footer {
		width: 750px;
		margin: 0 auto;
		padding: 20px 0;
		background: url({skin}/images/img08.gif) no-repeat;
		}
		
	</style>
	<!-- java script -->
	{javascript}
	<!-- css styles -->
	{style}
</head>
<LINK rel="alternate" type="application/rss+xml" title="RSS" href="{rss}">
<body>
<!-- Заголовок -->
<div id="logo">
	<h1><a href="{sitepath}" title="{title}">XZengine</a></h1>
	<p>{title}</p>
</div>
<div id="menu">
	<ul>
		<li><a href="{sitepath}" title="На главную">Главная</a></li>
		<li><a href="{rss}" alt="Rss подписка" title="Подписка на RSS новости"><img src="{skin}/images/rss.png" width="16" height="16"> RSS</a></li>
	
	</ul>
</div>
<!-- end Заголовок -->
<!-- start page -->
<div id="page">
	<div id="page-bg">
<!-- список новостей -->
<div id="content">
{sitecontent}
<br><br>
<!-- Список страниц-->
	<div class="post">
		<div class="entry">
			{lastpage} {pages} {nextpage}
		</div>
	</div>
<!-- end Список страниц-->
</div>
<!-- end список новостей -->
		<!-- start Меню -->
		<div id="sidebar">
			<ul>
				<li>
					<h2>Разделы:</h2>
					<ul>
						<li><a href="http://xzengine.ru">Официальный сайт</a></li>
						{adminpanellink}&nbsp;
					</ul>
					<h2>Если понравился сайт</h2>
					<ul>
						<li><a title="Добавить в избранное" href="" onclick="bookmark('{title}', '{sitepath}')">Добавить в избранное</a></li>
						<li><a title="Сделать стартовой" href="" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('{sitepath}');return false;">Сделать стартовой</a></li>
						<li><a title="Обратная связь" href="{sitepath}/index.php?feedback" >Форма обратной связи</a></li>
						<li><a title="Rss 2.0" href="{sitepath}/index.php?rss" >RSS 2.0</a></li>

					</ul>
					<h2>Прайс лист</h2>
					<ul>
						<li>{price_list}</li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- start Меню -->
		<div style="clear: both;">&nbsp;</div>
  </div>
</div>
<!-- end page -->
<div id="footer">
	<p>2005-2007 Powered by xzengine v.{versionnumber} <!-- <noindex><nofollow><iframe src="http://www.sape.ru/r.0bf14ccf4b.php" width="1" height="1" frameborder="0" scrolling="no"></iframe></nofollow></noindex> --></p>
</div>
</body>
</html>
<!-- 
Страница сгенерирована за {page_gen_time} секунд 
использовано {number_sql_queries} запросов к БД

Ошибки выполнения скрипта:
{debug_log} 
-->