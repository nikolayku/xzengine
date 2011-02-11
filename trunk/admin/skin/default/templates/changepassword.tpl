<!-- форма изменения пароля-->
		<form id="change_password_form" name="change_password_form" method="post" action="./index.php?chusernameandpass=change">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div align="center">
				{message}<br /><br />
                Изменение пароля администратора
                <br /> <br />
				Имя администратора <br />
				<input name="users_login" type="text" id="users_login" value="{users_login}" size="30" />
				<br /><br />
				Пароль администратора<br />
				<input name="users_password" type="text" id="users_password" value="{users_password}" size="30" />
				<br /><br />
				<input name="submit" type="submit" id="submit" value="Изменить" />

				</div></td>
            </tr>
          </table>
                        </form>
		<!-- конец формы изменения пароля-->