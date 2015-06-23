<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller {

	public function action_logout() //valid, -, id
	{
		$auth = Auth::instance();
		if($auth->logged_in())
		{
			$auth->logout();
			$session = Session::instance();
			$main_redirect = $session->get('main_redirect','');
			Controller::redirect($main_redirect);
		}
		else {
			throw HTTP_Exception::factory(404, 'File not found!');
		}
	}

}
