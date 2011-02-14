<?php
// 


class userPriviliges
{	
	// �������� ��� ������������ � ������
	static function ChangeUsernameAndPass()
	{
		// ������ ���� ����������
		// $_POST['users_login'] ��� ������������
		// $_POST['users_password'] ������ ������������
		
		$q = "UPDATE ".DATABASE_TBLPERFIX."users SET users_login='".$_POST['users_login']."', users_password='".$_POST['users_password']."'";
		
		AbstractDataBase::Instance()->query($q);

		// ��������� ������ � ��� ������������ � ������
		$this->SetAdminCookies($_POST['users_login'], $_POST['users_password']);		
	}	
	
	// ��������� ������ ��������� ������ � ����� ������������
	static function LoadChangepasswordForm($message = "")
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/changepassword.tpl");
		
		//  �������� ��� ������������ � ��� ������

		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'users WHERE users_login="'.$_SESSION['login'].'" LIMIT 1' );
						
		if(!$result)
			return false;
		
		$user = AbstractDataBase::Instance()->get_row($result);
		
		// �������� ���� 
		// {message}
		$render_str = str_replace("{message}", $message, $render_str);		

		// {users_login}
		$render_str = str_replace("{users_login}", $user['users_login'], $render_str);	
		
		// {users_password}
		$render_str = str_replace("{users_password}", $user['users_password'], $render_str);	
		
		return $render_str;
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

	// ��������� ����������� �� ������������ � ���������������
	// � cookies ������ ���� ����������� ���������
	// ��� ������������ � MD5 ��� ������
	// ���� ��� ��������� � ���������� �� ����� ��� ������������� ����� �����
	static function IsAdministrator()
	{	
		session_start();
		
		//if(isset($_COOKIE['login']) and isset($_COOKIE['md5pass']))
		if(isset($_SESSION['login']) and isset($_SESSION['md5pass']))
		{	
			// �������� ��� ������������ � ������
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'users WHERE users_login="'.$_SESSION['login'].'" LIMIT 1' );
						
			if(!$result)
				return false;
			
			$user = AbstractDataBase::Instance()->get_row($result);
			
			if(($user['users_login'] == $_SESSION['login']) and (md5($user['users_password']) == $_SESSION['md5pass']))
				return true;
		
		}
		
		return false;
	}
	
	// ��������� ���������� �� ������������
	// true ���� ������������ � ����� ������ ����������	
	// $md5pass ������ ������ ($pass) ����� � ���� md5 ����
	static function IsUserExist($login, $pass, &$message, $md5pass=false)
	{	
		// ��� ������������ �� ����� ���� ������
		if(strlen($login) == 0)
			return false;	
		
		// ������������� �� sql �������� ����� ������
		$login = str_replace(";", "--", $login);
		
		// �������� ��� ������������ � ������
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'users WHERE users_login="'.$login.'" LIMIT 1' );
		

		if(!$result)
		{	
			$message = "������������ � ����� ������ �� ����������";
			return false;
		}		
		
		$user = AbstractDataBase::Instance()->get_row($result);
		
		if($md5pass)
		{	
			if(md5($user['users_password']) != $pass)
			{	
				$message = "������ � cookies �� �����.";
				return false;
			}
		}
		else	
		{
			if($user['users_password'] != $pass)
			{	
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