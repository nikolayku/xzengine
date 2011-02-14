<?php
// 


class userPriviliges
{	
	// изменяем иня пользователя и пароль
	static function ChangeUsernameAndPass()
	{
		// должно быть определено
		// $_POST['users_login'] имя пользователя
		// $_POST['users_password'] пароль пользователя
		
		$q = "UPDATE ".DATABASE_TBLPERFIX."users SET users_login='".$_POST['users_login']."', users_password='".$_POST['users_password']."'";
		
		AbstractDataBase::Instance()->query($q);

		// сохраняем пароль и иня пользователя в сессии
		$this->SetAdminCookies($_POST['users_login'], $_POST['users_password']);		
	}	
	
	// загружает шаблон изменения пароля и имени пользователя
	static function LoadChangepasswordForm($message = "")
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/changepassword.tpl");
		
		//  получаем имя пользователя и его пароль

		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'users WHERE users_login="'.$_SESSION['login'].'" LIMIT 1' );
						
		if(!$result)
			return false;
		
		$user = AbstractDataBase::Instance()->get_row($result);
		
		// заменяем теги 
		// {message}
		$render_str = str_replace("{message}", $message, $render_str);		

		// {users_login}
		$render_str = str_replace("{users_login}", $user['users_login'], $render_str);	
		
		// {users_password}
		$render_str = str_replace("{users_password}", $user['users_password'], $render_str);	
		
		return $render_str;
	}
	
	// загружает шаблон Login.tpl
	// возврящяет водержимое этого шаблона
	static function render($message)
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/login.tpl");
		
		// заменяем теги
		$render_str = str_replace("{message}", $message, $render_str);
		
		return $render_str;
	}	

	// проверяет принадлежит ли пользователь к администраторам
	// в cookies должно быть установлено следующее
	// имя пользователя и MD5 хэш пароль
	// если они совпадают с правльными то тогда это администратор иначе гость
	static function IsAdministrator()
	{	
		session_start();
		
		//if(isset($_COOKIE['login']) and isset($_COOKIE['md5pass']))
		if(isset($_SESSION['login']) and isset($_SESSION['md5pass']))
		{	
			// получаем имя пользователя и пароль
			$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'users WHERE users_login="'.$_SESSION['login'].'" LIMIT 1' );
						
			if(!$result)
				return false;
			
			$user = AbstractDataBase::Instance()->get_row($result);
			
			if(($user['users_login'] == $_SESSION['login']) and (md5($user['users_password']) == $_SESSION['md5pass']))
				return true;
		
		}
		
		return false;
	}
	
	// Проверяет существует ли пользователь
	// true если пользователь с таким именем существует	
	// $md5pass значит пароль ($pass) задан в виде md5 кэша
	static function IsUserExist($login, $pass, &$message, $md5pass=false)
	{	
		// имя пользователя не может быть пустым
		if(strlen($login) == 0)
			return false;	
		
		// предотвращяем от sql инъекции через кукисы
		$login = str_replace(";", "--", $login);
		
		// получаем имя пользователя и пароль
		$result = AbstractDataBase::Instance()->query('SELECT * FROM '.DATABASE_TBLPERFIX.'users WHERE users_login="'.$login.'" LIMIT 1' );
		

		if(!$result)
		{	
			$message = "Пользователь с таким именем не существует";
			return false;
		}		
		
		$user = AbstractDataBase::Instance()->get_row($result);
		
		if($md5pass)
		{	
			if(md5($user['users_password']) != $pass)
			{	
				$message = "Пароль в cookies не верен.";
				return false;
			}
		}
		else	
		{
			if($user['users_password'] != $pass)
			{	
				$message = "Пароль не верен.";
				return false;
			}
		}
		
		return true;
		
		
	}

	// устанавливает Cookies у пользователя
	// $md5pass если $pass передан как md5 хэш
	// $setcoockie - значит сохранять ещё и в cookies
	static function SetAdminCookies($login, $pass, $setcoockie = false, $md5pass = false)
	{

		if($setcoockie)
		{	
			$expiredate = time()+60*60*24*30;		// 30 дней
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