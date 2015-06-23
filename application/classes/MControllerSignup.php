<?php defined('SYSPATH') or die('No direct script access.');

class MControllerSignup extends Controller_Template { // для защиты SINGUP функций от уже авторизовавщегося пользователя

	public function before()
	{
		date_default_timezone_set('UTC');
		$session = Session::instance();
		$auth = Auth::instance();
		if(!$auth->logged_in()) {
			$session->set('main_redirect', $_SERVER['REQUEST_URI']);
		}  else {
			Controller::redirect(''); //True redirect
		}

		return parent::before();
	}
}
