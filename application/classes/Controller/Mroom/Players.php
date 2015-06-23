<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Players extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';
	
    	public function action_index()
	{
		$data = array();
		$mres = new Model_Resources();

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$teamID = Arr::get($_POST, 'teamID', ''); 

			if ($mres->add_player($name,$teamID)) 
			{
				$data['ok']='';
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['players'] = $mres->get_all_players();
		$data['teams'] = $mres->get_all_teams();
		$this->template->content = View::factory('mroom/mroom_players_view',$data);	
	}

	public function action_delete()	
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		if ($mres->del_player($id)) 
		{
			$data['ok']='';
		} else {
			$data['errors']='';
		}

		$this->template->content = View::factory('mroom/mroom_player_del',$data);	
	}

	public function action_edit()
	{
		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$data['player'] = $mres->get_player($id);

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$teamID = Arr::get($_POST, 'teamID', '');			

			if ($mres->edit_player($id,$name,$teamID)) 
			{
				$data['ok']='';
				Controller::redirect('mroom/players');
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['teams'] = $mres->get_all_teams();
		$data['player'] = $mres->get_player($id);
		$this->template->content = View::factory('mroom/mroom_player_edit',$data);	
	}


}