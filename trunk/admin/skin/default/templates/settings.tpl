<form id="settings" name="settings" method="post" action="index.php?config=save">
     	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="3%">&nbsp;</td>
              <td width="63%">{message}</td>
              <td width="34%">&nbsp;</td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td class="NewDateStamp">Состояние сайта </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Выключить сайт для обычных пользователей</td>
              <td>
                <select name="OFF_SITE" id="OFF_SITE">
                 {OFF_SITE}
                </select>              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Текст отображаемый обычным пользователям</td>
              <td>
                <input name="OFF_SITE_MESSAGE" type="text" id="OFF_SITE_MESSAGE" value="{OFF_SITE_MESSAGE}" />              </td>
            </tr>
		</tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Локализация</td>
              <td>&nbsp;</td>
            </tr>
		<tr>
              <td>&nbsp;</td>
              <td>Язык для сайта</td>
              <td>
                <select name="SITE_LOC_FILE" id="SITE_LOC_FILE">
                 {SITE_LOC_FILE}
                </select>              </td>
            </tr>
		<tr>
              <td>&nbsp;</td>
              <td>Язык для админпанели</td>
              <td>
                <select name="ADMINPANEL_LOC_FILE" id="ADMINPANEL_LOC_FILE">
                 {ADMINPANEL_LOC_FILE}
                </select>              </td>
            </tr>	
            <tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Настройки базы данных </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Host где расположена база данных </td>
              <td>
                <input name="DATABASE_HOST" type="text" id="DATABASE_HOST" value="{DATABASE_HOST}" />              </td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>Login пользователя БД </td>
              <td>
                <input name="DATABASE_USER" type="text" id="DATABASE_USER" value="{DATABASE_USER}" />              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Пароль для доступа к БД </td>
              <td><label>
                <input name="DATABASE_PASSWORD" type="text" id="DATABASE_PASSWORD" value="{DATABASE_PASSWORD}" />
              </label></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>Имя базы данных </td>
              <td>
                <input name="DATABASE_NAME" type="text" id="DATABASE_NAME" value="{DATABASE_NAME}" />              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Перфикс таблиц </td>
              <td>
                <input name="DATABASE_TBLPERFIX" type="text" id="DATABASE_TBLPERFIX" value="{DATABASE_TBLPERFIX}" />              </td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td class="NewDateStamp">Настройки GZip </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Включение GZip компрессии </td>
              <td>
                <select name="GZIP_ENABLED" id="GZIP_ENABLED">
                 {GZIP_ENABLED}
                </select>              </td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>Степень компресии (рекомендуемый уровень 3) </td>
              <td>
                <input name="GZIP_COMPRESSION" type="text" id="GZIP_COMPRESSION" value="{GZIP_COMPRESSION}" size="2" maxlength="2" />              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Настройки сайта </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Путь к сайту </td>
              <td>
                <input name="SITE_PATH" type="text" id="SITE_PATH" value="{SITE_PATH}" />              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Количество новостей на странице </td>
              <td>
                <input name="NEWSPERPAGE" type="text" id="NEWSPERPAGE" value="{NEWSPERPAGE}" />              </td>
            </tr>
            <tr>
              <td height="26">&nbsp;</td>
              <td>Заголовок сайта </td>
              <td>
                <input name="SITE_TITLE" type="text" id="SITE_TITLE" value="{SITE_TITLE}" />              </td>
            </tr>
            <tr>
              <td height="26">&nbsp;</td>
              <td>Ключевые слова</td>
              <td>
                <input name="SITE_KEYWORDS" type="text" id="SITE_KEYWORDS" value="{SITE_KEYWORDS}" />              </td>
            </tr>
            <tr>
              <td height="31">&nbsp;</td>
              <td>Текущий скин для сайта </td>
              <td>
                <select name="SKIN">
                	{SKIN}
				</select>              </td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>Формат вывода даты </td>
              <td>
                <input name="DATEFORMAT" type="text" id="DATEFORMAT" value="{DATEFORMAT}" />              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Использование &quot;понятной ссылки&quot; требует запись в файл .htaccess</td>
              <td>
                <select name="SIMPLY_URL" id="SIMPLY_URL">
                 {SIMPLY_URL}
                </select>              </td>
            </tr>
           <tr>
              <td>&nbsp;</td>
              <td>Могут ли обычные пользователи добавлять новости</td>
              <td>
                <select name="USERS_CAN_ADD_NEWS" id="USERS_CAN_ADD_NEWS">
                 {USERS_CAN_ADD_NEWS}
                </select>              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Настройки админпанели </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Скин админпанели </td>
              <td>
                <select name="ADMINPANEL_SKIN">
				{ADMINPANEL_SKIN}
                </select>              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Количество новостей на странице </td>
              <td>
                <input name="ADMINPANEL_NEWSPERPAGE" type="text" id="ADMINPANEL_NEWSPERPAGE" value="{ADMINPANEL_NEWSPERPAGE}" />              </td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Загрузка файлов</td>
              <td>&nbsp;</td>
            </tr>
			<tr>
              <td height="28">&nbsp;</td>
              <td>Директория для загружаемых файлов</td>
              <td>
                <input name="UPLOADFILE_DIRECTORY" type="text" id="UPLOADFILE_DIRECTORY" value="{UPLOADFILE_DIRECTORY}" />              </td>
            </tr>
			<tr>
              <td height="28">&nbsp;</td>
              <td>Размер(в байтах)загружаемого файла (<a href="#" onclick="SetMaxUplodedFileSize('{maxuplodedfilesizeinbytes}');return false;" title="установить максимальное">макс.</a> {maxuplodedfilesizeinbytes} = {maxiplodedfilesize})</td>
              <td>
                <input name="UPLOADFILE_SIZE" type="text" id="UPLOADFILE_SIZE" value="{UPLOADFILE_SIZE}" />              </td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Настройки форума</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Путь к форуму</td>
              <td>
                <input name="FORUM_PATH" type="text" id="FORUM_PATH" value="{FORUM_PATH}" />              </td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">Учётная запись администратора</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Логин администратора</td>
              <td>
                <input name="ADMIN_LOGIN" type="text" id="ADMIN_LOGIN" value="{ADMIN_LOGIN}" />              </td>
            </tr>
			<tr>
              <td height="28">&nbsp;</td>
              <td>Пароль администратора</td>
              <td>
                <input name="ADMIN_PASS" type="text" id="ADMIN_PASS" value="{ADMIN_PASS}" />              </td>
            </tr>	
            <tr>
              <td>&nbsp;</td>
              <td colspan="2" align="center" valign="middle">
              <input type="submit" name="submit" value="Применить" /></td>
            </tr>
        
				
          </table>
	</form>