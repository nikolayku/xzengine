<html>
<link rel="Shortcut Icon" href="{sitepath}/favicon.ico">
<head>
<title>{title}</title>
<meta name="keywords" content="{keywords}" />
<meta name="description" content="{title}" />
<meta name="generator" content="XZengine v.{versionnumber}" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="{skin}/style.css" rel="stylesheet" type="text/css" media="screen" />
<style type=text/css media=screen>
.menu {color: #442d27;background-image: url({skin}/images/mbg.gif);background-repeat: no-repeat;font-weight: bold;padding-right: 10px;padding-left: 41px;	white-space: nowrap;	font-size: 12px;padding-top: 7px;padding-bottom: 7px;font-family: Arial, Helvetica, sans-serif;}
.body_txt {color: #FFFFFF;text-align: justify;padding: 10px;vertical-align: top;font-size: 12px;background-image: url({skin}/images/cbg.jpg);background-repeat: no-repeat;background-position: left top;}
.login_form {background-image: url({skin}/images/login-form-bg.gif);background-repeat: repeat-x;height: 20px;width: 110px;border-width: 1px;border-style: solid;font-size: 11px;padding-top: 3px;padding-left: 1px;}
.mbotbg {background-image: url({skin}/images/mbotbg.gif);background-repeat: repeat-x;}
</style>
<!-- java script -->
{javascript}
</head>

<body>
<table width="744" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div style="position:absolute; margin-left:362px; top:18px"><img src="{skin}/images/logo.jpg" alt="" width="99" height="74"></div>
	<div id="company_name">Бокал вина</div>
    <img src="{skin}/images/p1.jpg" alt="" width="744" height="110"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="539"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div id="slogan">
              <p>{title}<br>
                  <img src="{skin}/images/spacer.gif" alt="" width="40" height="1"></p>
            </div>
              <img src="{skin}/images/p2.jpg" alt="" width="539" height="92"></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1" valign="top"><img src="{skin}/images/p3.jpg" alt="" width="193" height="287"></td>
                <td class="body_txt">
				<!-- содержимое сайта -->
				{sitecontent}
				<div style="border:#e6a354 solid 1px;padding:4px 6px 2px 6px">{lastpage} {pages} {nextpage}</div>
				<!-- конец содержимого сайта-->	
				</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td valign="top">
		<div><img src="{skin}/images/spacer.gif" alt="" width="1" height="3"></div>
		<div class="menu"><a href="{sitepath}">Главная</a></div>
		<div class="menu"><a href="{sitepath}/index.php?category=1">Новости</a></div>
		<div class="menu"><a href="{sitepath}/index.php?category=2">Статьи</a></div>
		<div class="menu"><a href="{sitepath}/index.php?category=3">Дегустация</a></div>		
	
        <div><img src="{skin}/images/spacer.gif" alt="" width="1" height="3"></div>
		<div class="menu"><a title="Добавить в избранное" href="" onclick="bookmark('{title}', '{sitepath}')">Добавить в избранное</a></div>
		<div class="menu"><a title="Сделать стартовой" href="" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('{sitepath}');return false;">Сделать стартовой</a></div>
		<div class="menu"><a title="Обратная связь" href="{sitepath}/index.php?feedback" >Форма обратной связи</a></div>
		<div class="menu"><a title="Rss 2.0" href="{sitepath}/index.php?rss" >RSS 2.0</a></div>
		<div class="bottom_menu">Реклама на сайте:<br>{sape_plugin}</div>
        <div><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="4"><img src="{skin}/images/spacer.gif" alt="" width="4" height="167"></td>
    <td class="mbotbg">&nbsp;</td>
  </tr>
</table>
</div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="{skin}/images/bot_line.gif" alt="" width="744" height="1"></td>
  </tr>
  <tr>
    <td class="bottom_menu"><a href="{sitepath}/index.php?spage=1">Соглашение</a>  
  </tr>
  <tr>
    <td class="bottom_addr">2005-2007 Powered by xzengine v.{versionnumber} <noindex><nofollow><iframe src="http://www.sape.ru/r.0bf14ccf4b.php" width="1" height="1" frameborder="0" scrolling="no"></iframe></nofollow></noindex>{liveinternet}</td>
  </tr>
</table>
</body>
</html>
