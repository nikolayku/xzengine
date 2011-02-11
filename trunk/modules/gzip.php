<?php
/////////////////////////////////////////////////////////
// ������ gzip
/////////////////////////////////////////////////////////

class GZip
{	
	//////////////////////////////////
	///
	/////////////////////////////////
	function CheckCanGzip()
	{
		if (headers_sent() || connection_aborted())
			return 0; 
		
		if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return "x-gzip"; 
		if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) return "gzip"; 
		return 0; 
	}
	

	//////////////////////
	/////////

	function gzip_PrintFourChars($Val)
	{
		for ($i = 0; $i < 4; $i ++)
		{
			echo chr($Val % 256);
			$Val = floor($Val / 256);
		}
	}
		

		

	/////////////////////////////////
	// ������������ 
	// ���������� true ���� ������ ���������� ����� false
	/////////////////////////////////
	function UseGZip($compression = 3)
	{	
		$encoding = $this->CheckCanGzip();
		if($encoding)
		{	
			$contents = ob_get_contents();
			ob_end_clean();		
			// �������������� ����������
			$s = "<!-- ��� ������ �������������� ���������� � ������� ".$compression." -->\n";
			$s = $s."<!-- ������ ����� ".strlen($contents)." ���� -->\n";		
			$s = $s."<!-- ������ ������������� ����� ".strlen(gzcompress($contents, $compression))." ���� -->\n";		
			
			$contents = $contents.$s;
					
			header("Content-Encoding: ".$encoding);
			//header("Content-Length: ".strlen($encoding));
			
			echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
			$Size = strlen($contents);
			$Crc = crc32($contents);
			
			$contents = gzcompress($contents, $compression);
			$contents = substr($contents, 0, strlen($contents) - 4);
			echo $contents;
			
			$this->gzip_PrintFourChars($Crc);
			$this->gzip_PrintFourChars($Size); 
	
			return true;
		}
		
		
		return false;
		
	}	

}



?>