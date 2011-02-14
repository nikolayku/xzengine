<?php
// 


class userPriviliges
{	
	// ��������� ����������� �� ������������ � ���������������
	// � cookies ������ ���� ����������� ���������
	// ��� ������������ � MD5 ��� ������
	// ���� ��� ��������� � ���������� �� ����� ��� ������������� ����� �����
	static function IsAdministrator()
	{	
		session_start();
		
		if(isset($_SESSION['login']) and isset($_SESSION['md5pass']))
		{				
			if((ADMIN_LOGIN == $_SESSION['login']) and (md5(ADMIN_PASS) == $_SESSION['md5pass']))
				return true;
		}
		
		return false;
	}
	
	// ��������� ������ Login.tpl
	// ���������� ���������� ����� �������
	static function render($message)
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/login.tpl");
		
		// �������� ����
		$render_str = str_replace("{message}", $message, $render_str);
		
		return $render_str;
	}	
	
	// ��������� ���������� �� ������������
	// true ���� ������������ � ����� ������ ����������	
	// $md5pass ������ ������ ($pass) ����� � ���� md5 ����
	static function IsUserExist($login, $pass, &$message, $md5pass=false)
	{	
		// ��� ������������ �� ����� ���� ������
		if(strlen($login) == 0)
			return false;	

		if(ADMIN_LOGIN != $login)
		{	
			// FIXME: ��������� � �����������
			$message = "������������ � ����� ������ �� ����������";
			return false;
		}		

		if($md5pass)
		{	
			if(md5(ADMIN_PASS) != $pass)
			{	
				//FIXME: ��������� � �����������
				$message = "������ � cookies �� �����.";
				return false;
			}
		}
		else	
		{
			if(ADMIN_PASS != $pass)
			{	
				//FIXME: ��������� � �����������
				$message = "������ �� �����.";
				return false;
			}
		}
		
		return true;
	}

	// ������������� Cookies � ������������
	// $md5pass ���� $pass ������� ��� md5 ���
	// $setcoockie - ������ ��������� ��� � � cookies
	static function SetAdminCookies($login, $pass, $setcoockie = false, $md5pass = false)
	{
		if($setcoockie)
		{	
			$expiredate = time()+60*60*24*30;		// 30 ����
			setcookie('login', $login, $expiredate);
			if($md5pass)
				setcookie('md5pass', $pass, $expiredate);
			else
				setcookie('md5pass', md5($pass), $expiredate);
		}
			
		session_start();
		
		$_SESSION['login'] = $login;
		
		if($md5pass)
			$_SESSION['md5pass'] = $pass;
		else
			$_SESSION['md5pass'] = md5($pass);	
	}	

	// remove administrator Cookies
	static function RemoveCookies()
	{	
		setcookie('login', '', 0);
		setcookie('md5pass', '', 0);
		
		session_start();
		
		$_SESSION['login'] = "";
		$_SESSION['md5pass'] = "";
		
	}	
}


?>