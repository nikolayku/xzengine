<table width="100%" border="0" cellspacing="2" cellpadding="2" class="SiteContent">
  <tr>
    <td>Настройка базы данных </td>
  </tr>
  <tr>
    <td>
		<div align="center">
			<form id="databasesettings" name="databasesettings" method="post" action="./install.php?step=textbdconfig&submit">
				{message}
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