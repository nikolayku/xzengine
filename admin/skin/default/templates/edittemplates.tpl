<form id="editTemplate" name="editTemplate" method="post" action="./index.php?edittemplates=load">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center"><br>{message}<br><br></div></td>
  </tr>
  <tr>
    <td><div align="center">Шаблон 
          <select name="template">
		  {templates}		
          </select>
          Файл шаблона
          <select name="templateFile">
		  {templateFile}		
          </select>
          <input type="submit" name="Submit" value="Загрузить файл шаблона" />
          </div></td>
  </tr>
  </form>
  <form id="editTemplate" method="post" action="./index.php?edittemplates=save">
	<input id="editTemplateData" type="hidden" name="editTemplateData"/>  
<tr>
    <td><div align="center"><br>
      <textarea id="fileContent" name="fileContent" cols="70" rows="15" wrap="off" class="codepress html">{edittemplatescontent}</textarea>
    </div></td>
  </tr>
  <tr>
    <td><div align="center"><br>
	<input type="submit" onclick="document.getElementById('editTemplateData').value = fileContent.getCode();" value="Применить" />
    </div></td>
  </tr>
</table>
</form>