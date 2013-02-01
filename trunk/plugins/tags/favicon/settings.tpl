<div align="center">				
	<br/>
	<div align="center"><b>{message}</b></div><br/>
		
	Путь к файлу favicon.ico
	<br>
		<img src="{favicon_path}" width="16" height="16"> &nbsp;&nbsp;
		<input name="favicon_path" type="text" id="favicon_path" size="40" value="{favicon_path}" />
		<a href="{delete}">Удалить текущий</a>
	<br><br>
	<br>
	<form method="post" enctype="multipart/form-data" name="uploadfile" id="uploadfile" action="{new}">
		<input type="hidden" name="MAX_FILE_SIZE" value="{maxfilesize}"> 
		Путь к файлу(расширение только <b>.ico</b>, можно загружать файлы размером {maxfilesize_str})<br>
		<input name="uploadfilename" type="file" id="uploadfilename" size="40" /> 
		<input name="StartUpload" type="submit" id="StartUpload" value="Загрузить favicon" />

	</form>
	<br>

</div>
<br/>
<br/>
