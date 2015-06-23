<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Events extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';
	
    	public function action_index()
	{
		$data = array();
		$mres = new Model_Resources();

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');


			if ($mres->add_event($name)) 
			{
				$data['ok']='';
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['events'] = $mres->get_all_events();
		$this->template->content = View::factory('mroom/mroom_events_view',$data);	
	}

	public function action_delete()	
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		if ($mres->del_event($id)) 
		{
			$data['ok']='';
		} else {
			$data['errors']='';
		}

		$this->template->content = View::factory('mroom/mroom_event_del',$data);	

	}

	public function action_edit()	{

		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$data['event'] = $mres->get_event($id);

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');

			if ($mres->rename_event($id,$name)) 
			{
				$data['ok']='';
				Controller::redirect('mroom/events');
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['event'] = $mres->get_event($id);
		$this->template->content = View::factory('mroom/mroom_event_edit',$data);	
	}


}