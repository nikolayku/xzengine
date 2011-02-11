<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableborder">
          <tr>
            <td width="68%">{name}</td>
            <td width="29%" align="left"><input name="CopyLink" type="submit" id="CopyLink" value="Копировать ссылку" onclick="CopyLinkToCategory('{id}'); return false;"/></td>
            <td width="3%"><a href="#" onclick="DeleteCategory({id})"><img src="{skin_admin}/images/delete.png" width="20" height="20" alt="Удалить категорию" border="0" /></a></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="12%"><strong>Описание: </strong></td>
                <td width="88%"><div align="justify">{description}</div></td>
              </tr>
            </table></td>
          </tr>
        </table>