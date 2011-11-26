function showHidePricePlugin()
{	
	var main_div = document.getElementById("price_plugin_main_div");
	
	if(document.getElementById("google_document_viewer") == null)
	{
		var el = document.createElement('iframe');
		el.setAttribute('id', 'google_document_viewer');
		el.setAttribute('src', 'http://docs.google.com/viewer?embedded=true&url={price_url}');
		el.setAttribute('width', "100%");
		el.setAttribute('height', "100%");
		main_div.appendChild(el);
	}
	
	if(main_div.style.visibility == "visible")
	{
		main_div.style.visibility = "hidden"; 
		return;
	}
	
	if(main_div.style.visibility == "hidden")
	{
		main_div.style.visibility = "visible";
		return;
	}
}