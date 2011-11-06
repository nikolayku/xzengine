/////////////////////////////////////////
// �������� ����� ������� 
/////////////////////////////////////////

// ��� ������� �����������

var PromtMessage = '������ ��� �����������';

var DeleteNewsConfirm = "������������� ������� ?";
var DeleteStaticPageConfirm = "������� ����������� �������� ?";
var DeleteFileConfirm = "������� ���� ���� ?";
var DeleteFeedbackMessage = "������� ��� feedback ���������?";
var DeleteCategoryMessage = "�������� ��������� �������� �� ����� �������� �������� ��������� � ���� ���������� . ���������� ?";

/////////////////////////////////////////
// ������� ����������� ������ �� ����������� ��������
/////////////////////////////////////////
function link_to_post(pid)
{
	temp = prompt( "������ ��� �����������", "{sitepath}" + pid );
	return false;
}




/////////////////////////////////////////
// ������� ����������� ������ �� ���������
/////////////////////////////////////////
function CopyLinkToCategory(pid)
{
	temp = prompt( PromtMessage, "{sitepath}/index.php?category=" + pid );
	return false;
}





/////////////////////////////////////////
// ������� ���������
// id - ������������� ���������
/////////////////////////////////////////

function DeleteCategory(id)
{
	action = confirm(DeleteCategoryMessage );
	if(action)
		document.location = "./index.php?category=delete&ID="+id;
}


/////////////////////////////////////////
// ������� �������
// id - ������������� �������
/////////////////////////////////////////

function DeleteNews(id)
{
	action = confirm(DeleteNewsConfirm);
	if(action)
		document.location = "./index.php?listnews&deleteid="+id;
}

/////////////////////////////////////////
// ������� ����������� ��������
// id - ������������� �������
/////////////////////////////////////////
function DeleteStaticPage(id)
{
	action = confirm(DeleteStaticPageConfirm );
	if(action)
		document.location = "./index.php?staticpagedelete="+id;
}


/////////////////////////////////////////
// ���������� ���� �������� �����
// filename - ��� ����� ��� ��������
/////////////////////////////////////////
function DeleteUploadedFile(filename)
{
	action = confirm(DeleteFileConfirm );
	if(action)
		document.location = "./index.php?uploadfilelist&deleteuploadfile="+filename;
}

/////////////////////////////////////////
// ���������� ���� �������� feedback ���������
// messageid - ��� ����� ��� ��������
/////////////////////////////////////////
function DeleteFeedback(messageid)
{
	action = confirm(DeleteFeedbackMessage );
	if(action)
		document.location = "./index.php?feedbacklist&delete="+messageid;
}


/////////////////////////////////////////
// ���� �������� ��������� ����� ��� ������������� ��
// 
/////////////////////////////////////////

function DataBaseDoAction(action)
{
	dd=window.open('./classes/dbdump.php?action='+action,'bcp','height=316,width=396,resizable=1,scrollbars=1');
	
	//document.backup.target='bcp';
	
	if(action=='backup')
	{	
		document.getElementById("backup").target ='bcp';
		document.getElementById("backup").submit();
	}
		
	if(action=='restore')
	{	
		document.getElementById("restore").target ='bcp';
		document.getElementById("restore").submit();
	}
	
	dd.focus();
}
