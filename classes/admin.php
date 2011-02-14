<?php
// 


class userPriviliges
{	
	// проверяет принадлежит ли пользователь к администраторам
	// в cookies должно быть установлено следующее
	// имя пользователя и MD5 хэш пароль
	// если они совпадают с правльными то тогда это администратор иначе гость
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
	
	// загружает шаблон Login.tpl
	// возврящяет водержимое этого шаблона
	static function render($message)
	{
		$render_str = file_get_contents("./skin/".ADMINPANEL_SKIN."/templates/login.tpl");
		
		// заменяем теги
		$render_str = str_replace("{message}", $message, $render_str);
		
		return $render_str;
	}	
	
	// Проверяет существует ли пользователь
	// true если пользователь с таким именем существует	
	// $md5pass значит пароль ($pass) задан в виде md5 кэша
	static function IsUserExist($login, $pass, &$message, $md5pass=false)
	{	
		// имя пользователя не может быть пустым
		if(strlen($login) == 0)
			return false;	

		if(ADMIN_LOGIN != $login)
		{	
			// FIXME: перенести в локализацию
			$message = "Пользователь с таким именем не существует";
			return false;
		}		

		if($md5pass)
		{	
			if(md5(ADMIN_PASS) != $pass)
			{	
				//FIXME: перенести в локализацию
				$message = "Пароль в cookies не верен.";
				return false;
			}
		}
		else	
		{
			if(ADMIN_PASS != $pass)
			{	
				//FIXME: перенести в локализацию
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