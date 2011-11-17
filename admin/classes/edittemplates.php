<?php

require_once 'settings.php';

class EditTemplates
{
	//////////////////////////////////////////
	// ������� ��������� ������ edittemplates.tpl, �������� ����
	////////////////////////////////////////// 	
	function LoadTemplate(&$main_page_template)
	{	
		$message = '';
		$curentTemplate = '';
		$currentFile = '';
		
		// ���������� ���������� ��������� ���������� codepress (codepress.org)
		$JavaScript = '<script src="./javascript/codepress/codepress.js" type="text/javascript"></script>';
		// �������� ������ �� ������� ��������
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);
			
		$this->ParseInputParams($curentTemplate, $currentFile);		
		
		// �������� �������
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/edittemplates.tpl");
		
		// �������� ���� 

		// {templates}	
		$render_str = str_replace("{templates}", EngineSettings::SkinList('../skin/', $curentTemplate), $render_str);	
		
		// {templateFile}	
		$render_str = str_replace("{templateFile}", EngineSettings::SkinList('../skin/'.$curentTemplate.'/templates/', $currentFile, true), $render_str);	
		
		// {edittemplatescontent}	
		$pathToFile = '../skin/'.$curentTemplate.'/templates/'.$currentFile;
		if($_GET['edittemplates'] == 'load')
		{	
			
			if(!is_writable($pathToFile))
			{	
				$message = '���� '.$currentFile.' �� ����� ���� �� ������';
				// {message}	
				$render_str = str_replace("{message}", $message, $render_str);		
			}
			else
			{
				// {message}	
				$render_str = str_replace("{message}", '', $render_str);
			}	
			$render_str = str_replace("{edittemplatescontent}", $this->LoadTemplateBody($curentTemplate, $currentFile), $render_str);	
			
		}		
		else if($_GET['edittemplates'] == 'save')
		{	
			if(!is_writable($pathToFile))
			{	

				$message = '���������� ��������� ������, ���� '.$currentFile.' ������� �� ������';
				// {message}	
				$render_str = str_replace("{message}", $message, $render_str);		
				
				$templateBody = stripslashes($_POST['editTemplateData']);
				$templateBody = htmlspecialchars($templateBody);
				// {edittemplatescontent}
				$render_str = str_replace("{edittemplatescontent}", $templateBody, $render_str);
			}
			else
			{
				$message = '������ �������';
				// {message}	
				$render_str = str_replace("{message}", $message, $render_str);
				
				$data = $_POST['editTemplateData'];
				$data = stripslashes($data);
				$data = htmlspecialchars_decode($data);
				file_put_contents($pathToFile, $data);
				$render_str = str_replace("{edittemplatescontent}", '', $render_str);	
				$this->ClearSession();	
			}
		}
		else
		{	
			$render_str = str_replace("{message}", '', $render_str);
			$render_str = str_replace("{edittemplatescontent}", '', $render_str);		
		}
		

		return 	$render_str;
	}
	
	//////////////////////////////////////////
	// ��������� ���� �������������� �������
	//////////////////////////////////////////
	function LoadTemplateBody(&$templateName, &$templateFile)
	{
		$fileContent = file_get_contents('../skin/'.$templateName.'/templates/'.$templateFile);
		return htmlspecialchars($fileContent);	 	
	}
	
	//////////////////////////////////////////
	// ��������� ������� ���������
	//////////////////////////////////////////
	function ParseInputParams(&$curentTemplate, &$currentFile)
	{
		@session_start();
		
		// ����� POST ����� ���� ��������� ���������� 
		$curentTemplate = SKIN;
		if(isset($_POST['template']))
		{	
			$curentTemplate = $_POST['template'];
			$_SESSION['template'] = $curentTemplate;
		}
		
		$currentFile = '';
		if(isset($_POST['templateFile']))
		{	
			$currentFile = $_POST['templateFile'];
			$_SESSION['templateFile'] = $currentFile;
		}
		
		if($_GET['edittemplates']!='')
		{
			// ��������� ���������� � ����� ��������
			if(isset($_SESSION['template']))
				$curentTemplate = $_SESSION['template'];		

			if(isset($_SESSION['templateFile']))
				$currentFile = $_SESSION['templateFile'];	
		}	
		

	}
	
	//////////////////////////////////////////
	// ��������� ������� ���������
	//////////////////////////////////////////
	function ClearSession()
	{
		unset($_SESSION['template']);
		unset($_SESSION['templateFile']);
	}	

};

?>
