<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Maintable extends MController {

	public $template = 'user/base';

	public function action_index() //valid, -, id
	{
		$data = array();
		$mres = new Model_Resources();
		$data['UTC'] = $mres->get_all_utc();
		$data['disciplines'] = $mres->get_all_disciplines();
		$this->template->content = View::factory('user/index_view',$data);
		$this->template->js = View::factory('user/index_view_js');
		$this->template->css = View::factory('user/index_view_css');
	}

}
