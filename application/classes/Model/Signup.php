<?php defined('SYSPATH') or die('No direct script access.');

class Model_Signup {

	public function add_user($login,$email,$password,$password2,$terms) {  //valid, -, id
		if (isset($terms) &&  $terms == '1' && Valid::min_length($password, 5) && Valid::max_length($password, 254) && $password == $password2) {
			$auth = Auth::instance();
				//Генерируем hash для верификации
			$useful = new Model_Useful();
   			$genhash = $useful->generatePassword(18);
   			$muser = new Model_Muser();
			$muser->username = $login;
			$muser->email = $email;
			$muser->password = $auth->hash_password($password);
   			$muser->genhash = $genhash;
   			$muser->utc = '0';
   			$muser->freemoney = '0';
   			// $muser->money = '1.00';
			try {
				$usertemp = $muser->save();

				$userid = $usertemp->id;

				//Сохранение роли
				$addrole = new Model_Rolesuser();
				$addrole->user_id = $userid;
				$addrole->role_id = 1; //Обычный пользователь
				$addrole->save();

				//Отправка электройнной почты
				$subject = 'Your registration with clanbets.com';
				$data = array('genhash' => $genhash, 'login' => $login);
   				$message = View::factory('email/newuser',$data);
   				$from = array('noreply@clanbets.com' => 'Clanbets.com registration');
   				if ($useful->sendmail($email,$subject,$message,$from))
   					return TRUE;
   				else
       					return FALSE;
			} catch (ORM_Validation_Exception $e) {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}


	public function checkmail($hash) //valid, -, id
	{
		$usertemp = ORM::factory('Muser', array('genhash'=>$hash));

		if($usertemp->loaded())
		{
			$usertemp->check_mail = '1';
			$usertemp->save();
			return TRUE;
		} else {
			return FALSE;
		}
	}


	public function recoverypassword($email) //valid, -, id
	{
		if (Valid::max_length($email, 254) && Valid::email($email)) {

			$muser = ORM::factory('Muser', array('email'=>$email));

			if(!$muser->loaded())
			{
				return FALSE;
			}

			$auth = Auth::instance();
			$useful = new Model_Useful();
			$genpass = $useful->generatePassword(9);
			$muser->password = $auth->hash_password($genpass);
			$muser->save();

			//Отправка электройнной почты
			$subject = 'Password recovery on the clanbets.com';
			$data = array('genpass' => $genpass);
			$message = View::factory('email/recoverypassword',$data);
			$from = array('noreply@clanbets.com' => 'Clanbets.com recovery');

			if ($useful->sendmail($email,$subject,$message,$from))
				return TRUE;
			else
				return FALSE;
		} else {
			return FALSE;
		}
	}

}
