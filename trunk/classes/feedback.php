<?php
/*==========================================
����� �������� �����
==========================================*/


class FeedBack
{
		
	function __construct()
	{
		
	}	

	///////////////////////////////////////////
	// ��������� ����� 
	///////////////////////////////////////////
	function RenderFeedBackTemplate(&$main_page_template, $message='')
	{
		$template = file_get_contents("./skin/".SKIN."/templates/feedback.tpl");
		
		$feedback_from = '';
		if(isset($_POST['feedback_from']))
			$feedback_from = $_POST['feedback_from'];

		$feedback_message = '';
		if(isset($_POST['feedback_message']))
			$feedback_message = $_POST['feedback_message'];
		
		// {feedback_from}
		$template = str_replace("{feedback_from}", $feedback_from , $template);
		
		// {feedback_message}
		$template = str_replace("{feedback_message}", $feedback_message, $template);
		
		// {message}
		$template = str_replace("{message}", $message, $template);
		
		// ������� �������
		$main_page_template = str_replace("{lastpage}", "", $main_page_template);
		$main_page_template = str_replace("{nextpage}", "", $main_page_template);
		
		// ��������� ��������� 
		$main_page_template = str_replace("{title}", lang_feedback_form, $main_page_template);
			
	
		return $template; 
	}
	
	///////////////////////////////////////////
	// �������� ��������� �������� ����� 
	// ���������� ��������� �� ���������� ����������	
	///////////////////////////////////////////
	function SendFeedBack()
	{
		session_start();
		$feedback_picture = $_POST['feedback_picture'];
		$feedback_from = $_POST['feedback_from'];
		$feedback_message = $_POST['feedback_message'];

		if($feedback_picture != $_SESSION['image_from_pic'])
			return lang_feedback_invalidpiccode;
		
		if(strlen($feedback_from) >= 30)
			return lang_feedback_nameverylong;
		
		if(strlen($feedback_message) >= 500)
			return lang_feedback_messageverylong;		

		// ��������� � ����
		$q = "INSERT INTO ".DATABASE_TBLPERFIX."feedback (feedback_from, feedback_message, feedback_read) VALUES ('".htmlspecialchars($feedback_from)."', '".htmlspecialchars($feedback_message)."','0')";
		AbstractDataBase::Instance()->query($q);
		
		// ������� 
		$_POST['feedback_picture'] = '';
		$_POST['feedback_from'] = '';
		$_POST['feedback_message'] = '';	
				

		return lang_feedback_done;
		
		
	}
	
	////////////////////////////////////////////
	// ���������� ���������� feedback ��������� � ���-�� ����� ���������(���� ����)
	////////////////////////////////////////////
	function GetFeedbackMessageCount()
	{	
		// �������� ����� ���-�� ���������
		$r = AbstractDataBase::Instance()->query("SELECT * FROM ".DATABASE_TBLPERFIX."feedback ");
		$totem_sessages = AbstractDataBase::Instance()->num_rows($r);	

		$r = AbstractDataBase::Instance()->query("SELECT * FROM ".DATABASE_TBLPERFIX."feedback WHERE feedback_read = 0");
		$not_readed = AbstractDataBase::Instance()->num_rows($r);
	
		$message = '';
		
		if($not_readed > 0)
			$message = '<a href="index.php?feedbacklist"><b>����� ��������� '.$not_readed.'</b></a>';
		else	
			$message = '�����: '.$totem_sessages.'<a href="index.php?feedbacklist"> �����������</a>';

		return $message;
	}			
	
	////////////////////////////////////////////
	// ���������� ������ ��������� 
	////////////////////////////////////////////
	function FeedbackMessageList(&$main_page_template)
	{
		$render_str = '';	
		
		// ��� ������������� ��������� �������� ��� �����������
		
		$q = "UPDATE ".DATABASE_TBLPERFIX."feedback SET feedback_read=1 WHERE feedback_read=0" ;
		//echo $q;
		$result = AbstractDataBase::Instance()->query($q);
		
		
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/feedbackmessages.tpl");		
		
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'feedback ORDER BY feedback_id DESC' );
		
		if(!$result)
			return "";
		
		if(AbstractDataBase::Instance()->num_rows($result) == 0)
			return '��� feedback ���������';	
		
		while($line = AbstractDataBase::Instance()->get_row($result))
		{	
			$temp = $template;
			$this->ReplaceTags($temp, $line);
			
			$render_str = $render_str.$temp;
		}
		
		// �������� ��� {javascript_admin}
		$JavaScript = '<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>{javascript_admin}';	
		
		// �������� ��� javascript �� ������� ��������
		// {javascript}
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);				
	
		return $render_str;	
	}	
	
	////////////////////////////////////////////
	// �������� ����
	////////////////////////////////////////////
	function ReplaceTags(&$template, $row)
	{
		// {name} 
		$template = str_replace("{name}", $row['feedback_from'], $template);
		
		// {message} 
		$template = str_replace("{message}", $row['feedback_message'], $template);
		
		// {id}
		$template = str_replace("{id}", $row['feedback_id'], $template);
	}
	
	////////////////////////////////////////////
	// �������� feedback ���������
	////////////////////////////////////////////
	function FeedbackDelete($id)
	{
		if((is_numeric($id)) && ($id >= 1))
		{
			$q = AbstractDataBase::Instance()->query('DELETE FROM '.DATABASE_TBLPERFIX.'feedback WHERE feedback_id="'.$id.'"');
			
		}	
	}


};


?>