<?php defined('SYSPATH') or die('No direct script access.');

class MControllerUser extends Controller_Template { //Только для авторизовавшегося пользователя

	public function before()
	{
		date_default_timezone_set('UTC');
		$auth = Auth::instance();
		if ($auth->logged_in() == 0) throw HTTP_Exception::factory(404, 'File not found!');
		return parent::before();
	}
}