<!-- price plugin -->
<!-- download/view block -->
<table class="price_plugin_table">
	<tr> 
		<td colspan="3" >{title}</td>
	</tr>
	<tr>
		<td><a href="{price_url}"><img src="{skin}/plugins/price/img/download_large.png" title="{title_download}" alt="{alt_download}"/></a></td>
		<td width="10">&nbsp;</td>
		<td>{canview}<a href="#" onclick="showHidePricePlugin()" ><img src="{icon}" title="{title_watch}" alt="{alt_watch}"/></a>{/canview}</td>
	</tr>
</table>
<!-- end download/view block -->
<div class="price_plugin_div1" id="price_plugin_main_div" style="visibility: hidden">
	<div class="price_plugin_div2">
		<a href="{price_url}"><img src="{skin}/plugins/price/img/download.png" title="{title_download}" alt="{alt_download}"/></a>&nbsp;&nbsp;&nbsp;
		<a href="#" onclick="showHidePricePlugin()" ><img src="{skin}/plugins/price/img/close.png" title="{title_close}" alt="{alt_close}" /></a>&nbsp;&nbsp;
	</div>
</div> 
<!-- end price plugin-->
