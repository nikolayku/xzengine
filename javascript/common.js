// ��������� ���� � �������� 
// ������������ ���� ����������� ������� ����� , http://napisal.igorok.kiev.ua
// ��� ������������� � ������������ � ������������ xzengine

function bookmark(title, url)
{
	if (title == undefined)
		title = document.title;
	
	if (url == undefined)
		url = top.location.href;
	
	if (window.sidebar)
	{
		// Firefox
		window.sidebar.addPanel(title, url, '');
	} 
	else if (window.opera && window.print)
	{
		// Opera
		var t = document.createElement('a');
		t.setAttribute('rel', 'sidebar');
		t.setAttribute('href', url);
		t.setAttribute('title', title);
		t.click();
	}
	else if(window.external )
	{
		// IE
		window.external.AddFavorite(url, title);
	}
	else
	{
		// ���� �� ������� �������� �� ������� �������� �������� � ��������
		alert('Can not add page to your favorites');
	}
	return false;
}
