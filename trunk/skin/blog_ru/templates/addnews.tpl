			<div class="nblock">
				<h1>���������� �������</h1>
				<div class="text"><!-- ����� ���������� ������� -->
					<form id="addNewsForm" name="form" method="post" action="index.php?addnews=post" >
						<p>{message}</p>
				        	<p>�������� ������� <br />
				            	<input name="news_name" type="text" id="news_name" size="60" value="{newsname}" />
				            </p>
					 	<p>���������<br/>
				             	<select name="news_category" id="news_category">
				    			{categorylist}
				  			</select>
				       	</p>		
				        	<p>������� ��������
				            	<br />
				            	<textarea name="news_sh_description" cols="50" rows="25" id="news_sh_description">{newsdescription}</textarea>
				        	</p>
						<p>��������� ��������
				            	<br />
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
				</div>
			</div>	
