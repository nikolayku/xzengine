<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{title}</title>
{javascript}
<style type="text/css">
<!--
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

body,td,th {
	font-family: Arial;
}
body {
	background-image: url({skin}/images/bg.png);
	margin-top: 7px;
}
-->
</style>
<link href="{skin}/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center">
  <table width="208" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="12" align="left" valign="top"><img src="{skin}/images/cover_l_t.jpg" width="12" height="12" /></td>
      <td width="184" class="BorderTop"><img src="{skin}/images/hspacer.png" width="1" height="12"  /></td>
      <td width="12" align="right" valign="top"><img src="{skin}/images/cover_r_t.jpg" width="12" height="12" /></td>
    </tr>
    <tr>
      <td class="BorderLeft">&nbsp;</td>
      <td class="BorderBlank"><div align="center"><a href="./index.php"><img src="{skin}/images/logo.png" width="684" height="135" border="0"/></a></div></td>
      <td class="BorderRight">&nbsp;</td>
    </tr>
    <tr>
      <td class="BorderLeft">&nbsp;</td>
      <td class="BorderBlank">&nbsp;</td>
      <td class="BorderRight">&nbsp;</td>
    </tr>
    <tr>
      <td height="97" class="BorderLeft">&nbsp;</td>
     	<td align="left" valign="top" bgcolor="#FFFFFF" class="SiteContent">
		<!-- содержимое -->
		{sitecontent}
		<!-- конец содержимого страницы-->
		</td>
      <td class="BorderRight">&nbsp;</td>
    </tr>
    <tr>
      <td><img src="{skin}/images/cover_l_b.jpg" width="12" height="12" /></td>
      <td class="BorderBottom"><img src="{skin}/images/hspacer.png" width="1" height="12" /></td>
      <td><img src="{skin}/images/cover_r_b.jpg" width="12" height="12" /></td>
    </tr>
  </table>
</div>
</body>
</html>
