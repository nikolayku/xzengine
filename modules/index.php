<?php
if(isset($_GET['pictype']))
{	
	// bg.png
	if($_GET['pictype'] == "bg")
	{	
		@header("Content-Type: image/png");
		echo base64_decode("iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAIAAAAmkwkpAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAdSURBVHjaYvgPA+fOnWOAs4AkA5wF4sBZQAAQYACf2C2FgNhT8AAAAABJRU5ErkJggg==");
		exit;
	}
	//cover_l_t.jpg
	if($_GET['pictype'] == "cover_l_t")
	{	
		@header("Content-Type: image/jpg");
		echo base64_decode('/9j/4AAQSkZJRgABAgAAZABkAAD/7AARRHVja3kAAQAEAAAAUAAA/+4ADkFkb2JlAGTAAAAAAf/bAIQAAgICAgICAgICAgMCAgIDBAMCAgMEBQQEBAQEBQYFBQUFBQUGBgcHCAcHBgkJCgoJCQwMDAwMDAwMDAwMDAwMDAEDAwMFBAUJBgYJDQsJCw0PDg4ODg8PDAwMDAwPDwwMDAwMDA8MDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgADAAMAwERAAIRAQMRAf/EAGIAAAMBAAAAAAAAAAAAAAAAAAEFBgkBAQAAAAAAAAAAAAAAAAAAAAAQAAECBAIKAwAAAAAAAAAAAAIBAwAREgQTBiExYXGBMnJTBRUUFjYRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/ANv/AB9i7mNbu8u7sy8O+4bNLSoC34tEoKZEKkosItSNtiWkVUjUiNYB59Tyzr9BYV9747eJvrlVPjAHKf5fL0+b11ti9eENc9tU5wFBAf/Z');
		exit;
	}
	// hspacer.png
	if($_GET['pictype'] == "hspacer")
	{	
		@header("Content-Type: image/png");
		echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAAMCAYAAACji9dXAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAVSURBVHjaYvr//z8DEwMQkE4ABBgAsJoDFmRcvcgAAAAASUVORK5CYII=');
		exit;
	}
	// cover_r_t.jpg
	if($_GET['pictype'] == "cover_r_t")
	{	
		@header("Content-Type: image/jpg");
		echo base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAMAAwDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3VrCAcxKIXHRovlx+HQ/jUEdwYVMb3EMLIcFHH6jkce3bpWjXM+IJGj1BApxmME/maAP/2Q==');
		exit;
	}
	
	// logo.jpg
	if($_GET['pictype'] == "logo")
	{	
		@header("Content-Type: image/jpg");
		echo base64_decode('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');
		exit;
	}
	// cover_l_b.jpg
	if($_GET['pictype'] == "cover_l_b")
	{	
		@header("Content-Type: image/jpg");
		echo base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAMAAwDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3WxbFuITgPD8jDPTA4/TFWqzriPyTNJEzI0UQZcenzfKfbj8O1ZL+IbtHK+XCcdyp/wAaAP/Z');
		exit;
	}
	if($_GET['pictype'] == "cover_r_b")
	{	
		@header("Content-Type: image/jpg");
		echo base64_decode('/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAMAAwDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+sO+sH1S6aWLbsT92CSRnHXHHqSPwosb2bU5PLmO1CpJEeVzyB16960re3hktoneJGLIDyoIHHQegoA//9k=');
		exit;
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Ошибка</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial;
}
body {
	background-image: url("index.php?pictype=bg");
	margin-top: 20px;
}
a:link {
	color: #0060ff;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #0060ff;
}
a:hover {
	text-decoration: none;
	color: #0060ff;
}
a:active {
	text-decoration: none;
	color: #0060ff;
}

.BorderLeft {
	background-color: #FFFFFF;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: solid;
	border-top-color: #FFFFFF;
	border-right-color: #FFFFFF;
	border-bottom-color: #FFFFFF;
	border-left-color: #bfbfbf;
}
.BorderRight {
	background-color: #FFFFFF;
	border-top-width: 0px;
	border-right-width: 1px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: solid;
	border-bottom-style: none;
	border-left-style: none;
	border-top-color: #FFFFFF;
	border-right-color: #bfbfbf;
	border-bottom-color: #FFFFFF;
	border-left-color: #FFFFFF;
}
.BorderTop {



	background-color: #FFFFFF;
	border-top-width: 1px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: solid;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	border-top-color: #bfbfbf;
	border-right-color: #FFFFFF;
	border-bottom-color: #FFFFFF;
	border-left-color: #FFFFFF;
}
.BorderBlank {
	background-color: #FFFFFF;
	border: 0px none #FFFFFF;
}
.BorderBottom {
	background-color: #FFFFFF;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #FFFFFF;
	border-right-color: #FFFFFF;
	border-bottom-color: #bfbfbf;
	border-left-color: #FFFFFF;
}
.SiteContent {
	font-family: Arial;
	font-size: 12px;
	color: #494949;
	font-weight: normal;
}

-->
</style>
</head>
<body>
<div align="center">
  <table width="208" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="12" align="left" valign="top"><img src="index.php?pictype=cover_l_t" width="12" height="12" /></td>
      <td width="184" class="BorderTop"><img src="index.php?pictype=hspacer" width="1" height="12"  /></td>
      <td width="12" align="right" valign="top"><img src="index.php?pictype=cover_r_t" width="12" height="12" /></td>
    </tr>
    <tr>
      <td class="BorderLeft">&nbsp;</td>
      <td><img src="index.php?pictype=logo" width="684" height="50" /></td>
      <td class="BorderRight">&nbsp;</td>
    </tr>
    <tr>
      <td class="BorderLeft">&nbsp;</td>
      <td class="BorderBlank">&nbsp;</td>
      <td class="BorderRight">&nbsp;</td>
    </tr>
    <tr>
      <td height="97" class="BorderLeft">&nbsp;</td>
     	<td align="left" valign="top" bgcolor="#FFFFFF" class="SiteContent"><div align="center"><strong>Вы попали на несуществующую страницу!</strong><br />
   	    Пожалуйста нажмите на кнопочку   «<strong><a href="#" onclick="history.back();return false;">Назад</a></strong>» в вашем браузере для возвращения на предыдущую страницу.</div></td>
     	<td class="BorderRight">&nbsp;</td>
    </tr>
    <tr>
      <td><img src="index.php?pictype=cover_l_b" width="12" height="12" /></td>
      <td class="BorderBottom"><img src="index.php?pictype=hspacer" width="1" height="12" /></td>
      <td><img src="index.php?pictype=cover_r_b" width="12" height="12" /></td>
    </tr>
  </table>
</div>
</body>
</html>
