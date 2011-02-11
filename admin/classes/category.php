<?php

//////////////////////////////////////////////////////////////////
// ����� ��� ������ � �����������
//////////////////////////////////////////////////////////////////

class Category
{
	///////////////////////////////////////////
	// �������� ��������� 
	///////////////////////////////////////////
	function DeleteCategory($id)
	{	
		// ������� � ��
		$q = "DELETE FROM ".DATABASE_TBLPERFIX."category WHERE category_id = ".$id;
		AbstractDataBase::Instance()->query($q, false);
		
		$q = "DELETE FROM ".DATABASE_TBLPERFIX."news WHERE news_category = ".$id;
		AbstractDataBase::Instance()->query($q, false);
			
	}		

		
	///////////////////////////////////////////
	// ���������� ���������
	///////////////////////////////////////////
	function AddCategory(&$main_page_template)
	{
		$message = '';
		
		$name = $_POST['category_name'];
		$descr = $_POST['category_description'];
		
		$q = "INSERT INTO ".DATABASE_TBLPERFIX."category (category_name, category_descr) VALUES ('".$name."', '".$descr."')";		
		AbstractDataBase::Instance()->query($q, false);	
			
		return '��������� ���������';
		
	}	
	

	///////////////////////////////////////////
	// ������ ���������
	///////////////////////////////////////////
	function GetCategoryList(&$main_page_template)
	{	
		// �������� ������
		$template = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/categorylist.tpl");
		$form = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/categoryform.tpl");
		$q = 'SELECT * FROM '.DATABASE_TBLPERFIX.'category';
		$q = AbstractDataBase::Instance()->query($q);
		if(AbstractDataBase::Instance()->num_rows($q) == 0)
			return $form;		

		$outputstr = $form;
		while($line = AbstractDataBase::Instance()->get_row($q))
		{	
			$t = $this->replaceTags($template, $line);			
			$outputstr = $outputstr.$t;
		}
		
		// �������� javascript ��� 
		$JavaScript = '<script src="./javascript/common.js" type="text/javascript" language="javascript"></script>';			
		
		// �������� ��� javascript �� ������� ��������
		// {javascript_admin}
		$main_page_template = str_replace("{javascript_admin}", $JavaScript, $main_page_template);		

		return $outputstr;		

	}

	///////////////////////////////////////////
	// �������� �������� ����
	// $temp - ������- ����� ������� ��� �����
	// $line - ������ � ���������� �������
	///////////////////////////////////////////
	function replaceTags($temp, $line)
	{	
		$ret = $temp;
		//{name}
		$ret = str_replace("{name}", $line['category_name'], $ret);	
		
		// {description}
		$ret = str_replace("{description}", $line['category_descr'], $ret);
		
		// {id}		
		$ret = str_replace("{id}", $line['category_id'], $ret);
		
		return $ret;	
		
	}		
	

}

?>