					<table width="473" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="30" align="left" class="ntitle">���������� �������</td>
                    </tr>
                    <tr>
                      <td bgcolor="#B4DDED"><img src="{skin}/images/spacer.gif" width="1" height="1" alt="" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"> <!-- ����� ���������� ������� -->
						<form id="addNewsForm" name="form" method="post" action="index.php?addnews=post" >
							<p>{message}</p>
								<p>�������� ������� <br />
									<input name="news_name" type="text" id="news_name" size="60" value="{newsname}" />
								</p>
								<p>���������
									<br/>
									<select name="news_category" id="news_category">
										{categorylist}
									</select>
								</p>		
								<p>������� ��������
									<br/>
									<textarea name="news_sh_description" cols="50" rows="25" id="news_sh_description">{newsdescription}</textarea>
								</p>
								<p>��������� ��������
									<br/>
									<textarea name="news_showfull" cols="50" rows="25" id="news_showfull">{newsshowfull}</textarea>
								</p>
								<p>��� ������ �� ������ ������� 
									<br/>
									<input name="news_full_link" type="text" id="news_full_link" size="60" value="{newsfulllink}"/>
								</p>
								<p>�������� �����
									<br/>
									<input name="news_keyword" type="text" id="news_keyword" size="60" value="{newskeyword}"/>
								</p>
								<p>����� ������� 
									<br/>
									<input name="news_autor" type="text" id="news_autor" size="60" value="{autor}"/>
								</p>
								<!-- -->
								{private}
								<p>{message}</p>	
								<p>
								<input type="submit" name="Submit" value="�������� �������" />
								</p>
						</form>
					<!-- ����� ����� ���������� �������� -->	
					</td>
                    </tr>
                  </table>