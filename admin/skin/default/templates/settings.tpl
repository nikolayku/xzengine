<form id="settings" name="settings" method="post" action="index.php?config=save">
     	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="3%">&nbsp;</td>
              <td width="63%">{message}</td>
              <td width="34%">&nbsp;</td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td class="NewDateStamp">��������� ����� </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>��������� ���� ��� ������� �������������</td>
              <td>
                <select name="OFF_SITE" id="OFF_SITE">
                 {OFF_SITE}
                </select>              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>����� ������������ ������� �������������</td>
              <td>
                <input name="OFF_SITE_MESSAGE" type="text" id="OFF_SITE_MESSAGE" value="{OFF_SITE_MESSAGE}" />              </td>
            </tr>
		</tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">�����������</td>
              <td>&nbsp;</td>
            </tr>
		<tr>
              <td>&nbsp;</td>
              <td>���� ��� �����</td>
              <td>
                <select name="SITE_LOC_FILE" id="SITE_LOC_FILE">
                 {SITE_LOC_FILE}
                </select>              </td>
            </tr>
		<tr>
              <td>&nbsp;</td>
              <td>���� ��� �����������</td>
              <td>
                <select name="ADMINPANEL_LOC_FILE" id="ADMINPANEL_LOC_FILE">
                 {ADMINPANEL_LOC_FILE}
                </select>              </td>
            </tr>	
            <tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">��������� ���� ������ </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>Host ��� ����������� ���� ������ </td>
              <td>
                <input name="DATABASE_HOST" type="text" id="DATABASE_HOST" value="{DATABASE_HOST}" />              </td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>Login ������������ �� </td>
              <td>
                <input name="DATABASE_USER" type="text" id="DATABASE_USER" value="{DATABASE_USER}" />              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>������ ��� ������� � �� </td>
              <td><label>
                <input name="DATABASE_PASSWORD" type="text" id="DATABASE_PASSWORD" value="{DATABASE_PASSWORD}" />
              </label></td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>��� ���� ������ </td>
              <td>
                <input name="DATABASE_NAME" type="text" id="DATABASE_NAME" value="{DATABASE_NAME}" />              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>������� ������ </td>
              <td>
                <input name="DATABASE_TBLPERFIX" type="text" id="DATABASE_TBLPERFIX" value="{DATABASE_TBLPERFIX}" />              </td>
            </tr>
            <tr>
              <td height="15">&nbsp;</td>
              <td class="NewDateStamp">��������� GZip </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>��������� GZip ���������� </td>
              <td>
                <select name="GZIP_ENABLED" id="GZIP_ENABLED">
                 {GZIP_ENABLED}
                </select>              </td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>������� ��������� (������������� ������� 3) </td>
              <td>
                <input name="GZIP_COMPRESSION" type="text" id="GZIP_COMPRESSION" value="{GZIP_COMPRESSION}" size="2" maxlength="2" />              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">��������� ����� </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>���� � ����� </td>
              <td>
                <input name="SITE_PATH" type="text" id="SITE_PATH" value="{SITE_PATH}" />              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>���������� �������� �� �������� </td>
              <td>
                <input name="NEWSPERPAGE" type="text" id="NEWSPERPAGE" value="{NEWSPERPAGE}" />              </td>
            </tr>
            <tr>
              <td height="26">&nbsp;</td>
              <td>��������� ����� </td>
              <td>
                <input name="SITE_TITLE" type="text" id="SITE_TITLE" value="{SITE_TITLE}" />              </td>
            </tr>
            <tr>
              <td height="26">&nbsp;</td>
              <td>�������� �����</td>
              <td>
                <input name="SITE_KEYWORDS" type="text" id="SITE_KEYWORDS" value="{SITE_KEYWORDS}" />              </td>
            </tr>
            <tr>
              <td height="31">&nbsp;</td>
              <td>������� ���� ��� ����� </td>
              <td>
                <select name="SKIN">
                	{SKIN}
				</select>              </td>
            </tr>
            <tr>
              <td height="30">&nbsp;</td>
              <td>������ ������ ���� </td>
              <td>
                <input name="DATEFORMAT" type="text" id="DATEFORMAT" value="{DATEFORMAT}" />              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>������������� &quot;�������� ������&quot; ������� ������ � ���� .htaccess</td>
              <td>
                <select name="SIMPLY_URL" id="SIMPLY_URL">
                 {SIMPLY_URL}
                </select>              </td>
            </tr>
           <tr>
              <td>&nbsp;</td>
              <td>����� �� ������� ������������ ��������� �������</td>
              <td>
                <select name="USERS_CAN_ADD_NEWS" id="USERS_CAN_ADD_NEWS">
                 {USERS_CAN_ADD_NEWS}
                </select>              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">��������� ����������� </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>���� ����������� </td>
              <td>
                <select name="ADMINPANEL_SKIN">
				{ADMINPANEL_SKIN}
                </select>              </td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>���������� �������� �� �������� </td>
              <td>
                <input name="ADMINPANEL_NEWSPERPAGE" type="text" id="ADMINPANEL_NEWSPERPAGE" value="{ADMINPANEL_NEWSPERPAGE}" />              </td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">�������� ������</td>
              <td>&nbsp;</td>
            </tr>
			<tr>
              <td height="28">&nbsp;</td>
              <td>���������� ��� ����������� ������</td>
              <td>
                <input name="UPLOADFILE_DIRECTORY" type="text" id="UPLOADFILE_DIRECTORY" value="{UPLOADFILE_DIRECTORY}" />              </td>
            </tr>
			<tr>
              <td height="28">&nbsp;</td>
              <td>������(� ������)������������ ����� (<a href="#" onclick="SetMaxUplodedFileSize('{maxuplodedfilesizeinbytes}');return false;" title="���������� ������������">����.</a> {maxuplodedfilesizeinbytes} = {maxiplodedfilesize})</td>
              <td>
                <input name="UPLOADFILE_SIZE" type="text" id="UPLOADFILE_SIZE" value="{UPLOADFILE_SIZE}" />              </td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">��������� ������</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>���� � ������</td>
              <td>
                <input name="FORUM_PATH" type="text" id="FORUM_PATH" value="{FORUM_PATH}" />              </td>
            </tr>
			<tr>
              <td>&nbsp;</td>
              <td class="NewDateStamp">������� ������ ��������������</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="28">&nbsp;</td>
              <td>����� ��������������</td>
              <td>
                <input name="ADMIN_LOGIN" type="text" id="ADMIN_LOGIN" value="{ADMIN_LOGIN}" />              </td>
            </tr>
			<tr>
              <td height="28">&nbsp;</td>
              <td>������ ��������������</td>
              <td>
                <input name="ADMIN_PASS" type="text" id="ADMIN_PASS" value="{ADMIN_PASS}" />              </td>
            </tr>	
            <tr>
              <td>&nbsp;</td>
              <td colspan="2" align="center" valign="middle">
              <input type="submit" name="submit" value="���������" /></td>
            </tr>
        
				
          </table>
	</form>