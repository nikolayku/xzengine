<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top"><form action="./index.php?uploadfile=upload&uploadfilelist" method="post" enctype="multipart/form-data" name="uploadfile" id="uploadfile">
              	<input type="hidden" name="MAX_FILE_SIZE" value="{maxfilesize}"> 
              	<br>
              	  {message}<br><br>		
              	  ���� � �����(����� ��������� ����� �������� {maxfilesize_str})<br>
              	  <input name="uploadfilename" type="file" id="uploadfilename" size="40" /> <input name="StartUpload" type="submit" id="StartUpload" value="������ ��������" />
              	  <br>   
              	  <input name="uniquefilename" type="checkbox" id="uniquefilename" value="1" />
              	  ������������ ���������� ��� �����<br><br>
            </form>
            </td>
          </tr>
        </table>