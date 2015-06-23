<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Promotions extends MController {

	public $template = 'user/base';

	public function action_index() //valid, -, id
	{
		$data = array();
		$this->template->content = View::factory('user/promotions_view',$data);
		$this->template->js = View::factory('user/promotions_view_js');
		$this->template->css = View::factory('user/index_view_css');
	}

}
