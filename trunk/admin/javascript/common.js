/////////////////////////////////////////
// содержит общие функции 
/////////////////////////////////////////

// для будущей локализации

var PromtMessage = 'Ссылка для копирования';

var DeleteNewsConfirm = "Действительно удалить ?";
var DeleteStaticPageConfirm = "Удалить статическую страницу ?";
var DeleteFileConfirm = "Удалить этот файл ?";
var DeleteFeedbackMessage = "Удалить это feedback сообщение?";
var DeleteCategoryMessage = "Удаление категории повлечёт за собой удаление новостей связанных с этой категорией . Продолжить ?";

/////////////////////////////////////////
// функция копирования ссылки на статическую страницу
/////////////////////////////////////////
function link_to_post(pid)
{
	temp = prompt( "Ссылка для копирования", "{sitepath}" + pid );
	return false;
}




/////////////////////////////////////////
// функция копирования ссылки на категорию
/////////////////////////////////////////
function CopyLinkToCategory(pid)
{
	temp = prompt( PromtMessage, "{sitepath}/index.php?category=" + pid );
	return false;
}





/////////////////////////////////////////
// Удаляет категорию
// id - идентификатор категории
/////////////////////////////////////////

function DeleteCategory(id)
{
	action = confirm(DeleteCategoryMessage );
	if(action)
		document.location = "./index.php?category=delete&ID="+id;
}


/////////////////////////////////////////
// удаляет новость
// id - идентификатор новости
/////////////////////////////////////////

function DeleteNews(id)
{
	action = confirm(DeleteNewsConfirm);
	if(action)
		document.location = "./index.php?listnews&deleteid="+id;
}

/////////////////////////////////////////
// удаляет статическую страницу
// id - идентификатор новости
/////////////////////////////////////////
function DeleteStaticPage(id)
{
	action = confirm(DeleteStaticPageConfirm );
	if(action)
		document.location = "./index.php?staticpagedelete="+id;
}


/////////////////////////////////////////
// диалоговое окно удаления файла
// filename - имя файла для удаления
/////////////////////////////////////////
function DeleteUploadedFile(filename)
{
	action = confirm(DeleteFileConfirm );
	if(action)
		document.location = "./index.php?uploadfilelist&deleteuploadfile="+filename;
}

/////////////////////////////////////////
// диалоговое окно удаления feedback сообщения
// messageid - имя файла для удаления
/////////////////////////////////////////
function DeleteFeedback(messageid)
{
	action = confirm(DeleteFeedbackMessage );
	if(action)
		document.location = "./index.php?feedbacklist&delete="+messageid;
}


/////////////////////////////////////////
// Окно создание резеврной копии или востановления бд
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
