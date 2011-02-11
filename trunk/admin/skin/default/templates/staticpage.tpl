{javascript_admin}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top">
			<form id="staticpage" name="staticpage" method="post" action="./index.php?staticpageadd">
				
				{message}<br><br>
				Название страницы
				<br>
			    <label>
			      <input name="static_pagename" type="text" id="static_pagename" size="60" value="{static_pagename}" />
		       	<br><br>
				Содержимое страницы
				<br>
			    <textarea name="static_text" cols="50" rows="25" id="static_text">{static_text}</textarea>
				<br><br>
				<input name="static_apply" type="submit" id="static_apply" value="Применить" />
			    </label>
			</form>			</td>
          </tr>
        </table>