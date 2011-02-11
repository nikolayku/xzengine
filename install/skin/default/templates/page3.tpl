<table width="100%" border="0" cellspacing="2" cellpadding="2" class="SiteContent">
  <tr>
    <td>Дополнительные настройки </td>
  </tr>
  <tr>
    <td>
		<div align="center">
			<form id="othersettings" name="othersettings" method="post" action="./install.php?step=params&submit">
			<br>
			{message}
			<br><br>  
			Имя администратора<br>
			  <input name="admin_name" type="text" id="admin_name" value="{admin_name}" size="30" />
			  <br><br>
			  Пароль администратора<br>
				<input type="text" name="admin_pass" id="admin_pass" value="{admin_pass}" size="30"/>
			  <br><br>
			Путь к сайту<br>
				<input type="text" name="site_path" id="site_path" value="{site_path}" size="30"/>
			  <br><br>
			Путь к форуму(или # если форума ещё нет)<br>
				<input type="text" name="forum_path" id="forum_path" value="{forum_path}" size="30"/>
			  <br><br>
			  <input name="next" type="submit" id="next" value="Далее..." />
			
			</form>
		</div> 
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>