<div align="center">				
	<br/>
	<div align="center"><b>{message}</b></div><br/>
	<div align="center">Последний прайс был загружен: {price_time}</div><br/>
	<form method="post" enctype="multipart/form-data" name="uploadfile" id="uploadfile" action="{new}">
		<input type="hidden" name="MAX_FILE_SIZE" value="{maxfilesize}"> 
		Путь к файлу(можно загружать файлы размером {maxfilesize_str})<br>
		<input name="uploadfilename" type="file" id="uploadfilename" size="40" /> 
		<input name="StartUpload" type="submit" id="StartUpload" value="Загрузить прайслист" />

	</form>
	<br/>
	<br/>
	{help}
</div>
<br/>
<br/>
