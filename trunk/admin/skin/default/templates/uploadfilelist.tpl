<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableborder">
          <tr>
            <td width="68%"><a href={filelink}  target="blank">{filename}</a></td>
            <td width="29%" align="left"><input name="CopyLink" type="submit" id="CopyLink" value="Копировать ссылку" onclick="link_to_post('{filename}'); return false;"/></td>
            <td width="3%"><a href="#" onclick="DeleteUploadedFile('{deleteurl}')"><img src="{skin_admin}/images/delete.png" width="20" height="20" alt="Удалить" border="0" /></a></td>
          </tr>
        </table>