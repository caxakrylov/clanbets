<?php defined('SYSPATH') or die('No direct script access.');

class MControllerAdmin extends Controller_Template { //Только для администраторов

	public function before()
	{
		$session = Session::instance();
		// $session->set('auth_redirect', $_SERVER['REQUEST_URI']); //неиспользуются
		if (isset($_SERVER['HTTP_REFERER'])) {
			$session->set('back_redirect', $_SERVER['HTTP_REFERER']);
		}

		$auth = Auth::instance();
		if ($auth->logged_in('admin') == 0) throw HTTP_Exception::factory(404, 'File not found!');
		return parent::before();
	}
}
