					<table width="473" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="30" align="left" class="ntitle">Обратная связь</td>
                    </tr>
                    <tr>
                      <td bgcolor="#B4DDED"><img src="{skin}/images/spacer.gif" width="1" height="1" alt="" /></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="news"> 
					  <!-- форма обратного сообщения -->
						<div align="center">{message}</div><br/>
						<form id="feedbackform" name="feedbackform" method="post" action="index.php?feedback=send">
						Вaше имя
						<br>
						<input name="feedback_from" type="text" id="feedback_from" value="{feedback_from}" size="40" />
						<br>
						<br>
						Сообщение
						<br>
						<textarea name="feedback_message" cols="40" rows="10" id="feedback_message">{feedback_message}</textarea>
						<br>
						<br>
						Код с картинки
						<br>
						<table align="center" width="163" border="0" cellspacing="0" cellpadding="0">
						<tr>
						<td width="75"><img src="{sitepath}/classes/antibot.php" width="75" height="32" /></td>
						<td width="88"><div align="center"><input name="feedback_picture" type="text" id="feedback_picture" size="4" maxlength="4" /></div></td>
						</tr>
						</table>
						<br>
						<input type="submit" name="Submit" value="Отправить сообщение" />
						</form>	
					<!-- конец формы обратного сообщения -->
					</td>
                    </tr>
                  </table>