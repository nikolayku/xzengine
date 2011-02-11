<table width="100%" border="0" cellspacing="2" cellpadding="2" class="SiteContent">
  <tr>
    <td>Настройка базы данных </td>
  </tr>
  <tr>
    <td>
		<div align="center">
			<form id="databasesettings" name="databasesettings" method="post" action="./install.php?step=mysqlconfig&submit">
				{message}
			<br><br>  
			Хост(может быть указан порт к примеру localhost:3306)<br>
			  <input name="database_host" type="text" id="database_host" value="{database_host}" size="30" />
			  <br><br>
			  Имя пользователя для этой базы данных<br>
				<input type="text" name="database_user" id="database_user" value="{database_user}" size="30"/>
			  <br><br>
			Пароль для пользователя базы данных<br>
				<input type="text" name="database_pass" id="database_pass" value="{database_pass}" size="30"/>
			  <br><br>
			Имя базы данных<br>
				<input type="text" name="database_name" id="database_name" value="{database_name}" size="30"/>
			  <br><br>
			Перфикс таблиц(если не знаете что это, оставьте как есть)<br>
				<input name="database_tableperfix" type="text" id="database_tableperfix" value="{database_tableperfix}" size="30"/>
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