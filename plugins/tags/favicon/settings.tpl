<div align="center">				
	<br/>
	<div align="center"><b>{message}</b></div><br/>
		
	���� � ����� favicon.ico
	<br>
		<img src="{favicon_path}" width="16" height="16"> &nbsp;&nbsp;
		<input name="favicon_path" type="text" id="favicon_path" size="40" value="{favicon_path}" />
		<a href="{delete}">������� �������</a>
	<br><br>
	<br>
	<form method="post" enctype="multipart/form-data" name="uploadfile" id="uploadfile" action="{new}">
		<input type="hidden" name="MAX_FILE_SIZE" value="{maxfilesize}"> 
		���� � �����(���������� ������ <b>.ico</b>, ����� ��������� ����� �������� {maxfilesize_str})<br>
		<input name="uploadfilename" type="file" id="uploadfilename" size="40" /> 
		<input name="StartUpload" type="submit" id="StartUpload" value="��������� favicon" />

	</form>
	<br>

</div>
<br/>
<br/>
