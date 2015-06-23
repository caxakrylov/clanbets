<?php defined('SYSPATH') or die('No direct script access.');

class AjaxController extends Controller { //Предназначен для всех пользователей, для главной таблицы

	public function before()
	{
		date_default_timezone_set('UTC');
		return parent::before();
	}
}
