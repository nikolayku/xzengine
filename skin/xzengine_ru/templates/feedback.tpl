			<div class="post">
				<br/>
				<div align="center">{message}</div><br/>
				<form id="feedbackform" name="feedbackform" method="post" action="index.php?feedback=send">
					�a�� ���
					<br>
              			<input name="feedback_from" type="text" id="feedback_from" value="{feedback_from}" size="40" />
					<br>
					<br>
					���������
					<br>
					<textarea name="feedback_message" cols="40" rows="10" id="feedback_message">{feedback_message}</textarea>
					<br>
					<br>
					��� � ��������
					<br>
					<table align="center" width="163" border="0" cellspacing="0" cellpadding="0">
  						<tr>
    							<td width="75"><img src="{sitepath}/classes/antibot.php" width="75" height="32" /></td>
    							<td width="88"><div align="center"><input name="feedback_picture" type="text" id="feedback_picture" size="4" maxlength="4" /></div></td>
 						</tr>
					</table>
					<br>

					<input type="submit" name="Submit" value="��������� ���������" />

				</form>	
			</div>