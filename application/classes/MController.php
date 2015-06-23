<?php defined('SYSPATH') or die('No direct script access.');

class MController extends Controller_Template { //Предназначен для всех пользователей, для главной таблицы

	public function before()
	{
		$session = Session::instance();
		$session->set('main_redirect', $_SERVER['REQUEST_URI']);
		date_default_timezone_set('UTC');


		$auth = Auth::instance();
		if($auth->logged_in())
		{
			$user_id = $auth->get_user();
			$user = ORM::factory('Muser',array('id'=>$user_id));
			$_SESSION['utc_user'] = $user->utc;
			if ($user->disciplines == "")
			{
				$_SESSION['disciplines_user'] = 'all';
			} else {
				$_SESSION['disciplines_user'] = explode(",", $user->disciplines);
			}
		} else {
			if (!isset($_SESSION['utc_user'])) {
				$_SESSION['utc_user'] = '+0';
			}

			if (!isset($_SESSION['disciplines_user'])) {
				$_SESSION['disciplines_user'] = 'all';
			}
		}

		return parent::before();
	}
}
