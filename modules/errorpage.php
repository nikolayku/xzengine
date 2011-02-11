<?php

class errorpage
{
	function errorwindow($header = '', $body = '', $type='error')
	{
		$template = file_get_contents("./skin/".SKIN."/templates/errorpage.tpl");
		
		// заменяем шаблон
		// {header}
		$template = str_replace("{header}", $header, $template);		
		
		// {body}
		$template = str_replace("{body}", $body, $template);	
		
		// {body}
		$template = str_replace("{type}", $type, $template);	
				

		echo $template;
	}
}

/* TODO: Add code here */

?>