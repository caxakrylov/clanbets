<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Oldmatches extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';
	
    	public function action_index()
	{
		date_default_timezone_set('UTC');
		$data = array();
		$mres = new Model_Resources();
		$data['UTC'] = $mres->get_all_utc();				
		$this->template->content =  View::factory('mroom/mroom_oldmatches_view',$data);	
	}
}