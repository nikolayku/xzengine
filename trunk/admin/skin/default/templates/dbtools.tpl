<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="4%">&nbsp;</td>
            <td width="6%">&nbsp;</td>
            <td width="86%"><div align="center">{message}</div></td>
            <td width="4%">&nbsp;</td>
          </tr>
          
          <tr>
            <td width="4%">&nbsp;</td>
            <td width="6%">&nbsp;</td>
            <td width="86%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><img src="{skin_admin}/images/backup.png"  width="64" height="64" /></td>
            <td>
			<form id="backup" name="backup" method="post" action="./classes/dbdump.php?action=backup">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                  <td height="18"><div align="center">Метод компрессии </div></td>
                  <td><div align="center">Степень компрессии </div></td>
                  <td>&nbsp;</td>
                </tr> 
				<tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
				<tr>
					
                  	<td width="26%">
					  <div align="center">
					    <select name="CompressionMethod" id="CompressionMethod">
					      <option value="0">Без компрессии</option>
					      <option value="1" selected>GZip</option>
				          </select>
			          </div></td>
                <td width="27%">
				 <div align="center">
						   <select name="CompressionLevel" id="CompressionLevel">
						     <option value="0">Не использовать</option>
						     <option value="1">Минимальная</option>
						     <option value="2">2</option>	
						     <option value="3">3</option>
						     <option value="4">4</option>
						     <option value="5">Средняя</option>
						     <option value="6">6</option>
						      <option value="7" selected>7</option>
						      <option value="8">8</option>	
						      <option value="9">Максимальная</option>
					          </select>
			             </div>
				</td>
                  <td width="47%"><div align="center">
                    <input type="submit" name="Submit" value="Создать резервную копию БД" onclick="DataBaseDoAction('backup');return false;"/>
                  </div></td>
                </tr>
              </table>
            	

			</form>
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><img src="{skin_admin}/images/restore.png" width="64" height="64" /></td>
            <td>
			<form id="restore" name="restore" method="post" action="./classes/dbdump.php?action=restore">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div align="center">Востановление с резервной копии </div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="53%"><div align="center">
                        <select name="filename" id="filename">
						{restorefiles}	
                        </select>
                        </div></td>
                      <td width="47%"><div align="center">
                        <input type="submit" name="Submit2" value="Востановить с резервной копии" onclick="DataBaseDoAction('restore');return false;"/>
                      </div></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            
			</form>
			</td>
            <td>&nbsp;</td>
          </tr>
			<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><img src="{skin_admin}/images/optimise.png" width="64" height="64" /></td>
            <td><form action="index.php?dbtools=optimize" name="optimize" id="optimize" method="post">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center">Оптимизация базы данных </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="submit" name="Submit2" value="Оптимизировать БД" />
                </div></td>
              </tr>
            </table> </form></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><img src="{skin_admin}/images/repair.png" width="64" height="64" /></td>
            <td><form id="repair" name="repair" method="post" action="index.php?dbtools=repair">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div align="center">Ремонт базы данных </div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><div align="center">
                    <input type="submit" name="Submit3" value="Произвести ремонт БД" />
                  </div></td>
                </tr>
              </table>
                                    </form>
            </td>
            <td>&nbsp;</td>
          </tr>	
        </table>