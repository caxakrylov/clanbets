<?php defined('SYSPATH') or die('No direct script access.');

class Model_Useful {
	public function generatePassword($number) {
		//$number - кол-во символов в пароле
		$arr = array('a','b','c','d','e','f',
		'g','h','i','j','k','l',
		'm','n','o','p','r','s',
		't','u','v','x','y','z',
		'A','B','C','D','E','F',
		'G','H','I','J','K','L',
		'M','N','O','P','R','S',
		'T','U','V','X','Y','Z',
		'1','2','3','4','5','6',
		'7','8','9','0');

	    	// Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++) {
		// Вычисляем случайный индекс массива
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}
		return $pass;
	}

	public function get_filename() {
		return strtolower(Text::random('alnum', 20));
	}



	public function save_image($image,$filename,$filename64)
	{
		if (
		! Upload::valid($image) OR
		! Upload::not_empty($image) OR
		! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
		{
			return FALSE;
		}

		$directory = DOCROOT.'/src/img/uploads/';

		if ($file = Upload::save($image, NULL, $directory))
		{
			Image::factory($file)
			->resize(24, 24, Image::AUTO)
			->save($directory.$filename);

			Image::factory($file)
			->resize(64, 64, Image::AUTO)
			->save($directory.$filename64);

			// Delete the temporary file
			unlink($file);
			return TRUE;
		}
		return FALSE;
	}

	public function save_image_discipline($image,$filename,$filename64)
	{
		if (
		! Upload::valid($image) OR
		! Upload::not_empty($image) OR
		! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
		{
			return FALSE;
		}

		$directory = DOCROOT.'/src/img/uploads/';

		if ($file = Upload::save($image, NULL, $directory))
		{
			Image::factory($file)
			->resize(18, 18, Image::AUTO)
			->save($directory.$filename);

			Image::factory($file)
			->resize(64, 64, Image::AUTO)
			->save($directory.$filename64);

			// Delete the temporary file
			unlink($file);
			return TRUE;
		}
		return FALSE;
	}

    	public function sendmail($to, $subject, $message, $from) {

		// $headers   = array();
		// $headers[] = "MIME-Version: 1.0";
		// $headers[] = "Content-type: text/html; charset=iso-8859-1";
		// $headers[] = "From: Clanbets team <noreply@clanbets.com>";
		// $headers[] = "Subject: {$subject}";
		// $headers[] = "X-Mailer: PHP/".phpversion();

		// try {
		// 	mail($to, $subject, $message, implode("\r\n", $headers));
		// 	return TRUE;
		// } catch (Exception $e) {
		// 	return FALSE;
		// }


		$message = array(
			'subject' => $subject,
			'body'     => $message,
			'from'     => $from,
			'to'          => $to
		);

		try {
			Email::send('default', $message['subject'], $message['body'], $message['from'], $message['to']);
			return TRUE;
		} catch (Exception $e) {
			return FALSE;
		}
	}










}
