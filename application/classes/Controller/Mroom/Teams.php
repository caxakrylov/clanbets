<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Teams extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';
	
    	public function action_index()
	{
		$data = array();
		$mres = new Model_Resources();

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$shortname = Arr::get($_POST, 'shortname', '');
			$disciplineID = Arr::get($_POST, 'disciplineID', '');   
			$logotypeID = Arr::get($_POST, 'logotypeID', ''); 
			$flagID = Arr::get($_POST, 'flagID', ''); 

			if ($mres->add_team($name,$shortname,$disciplineID,$logotypeID,$flagID)) 
			{
				$data['ok']='';
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['disciplines'] = $mres->get_all_disciplines();
		$data['logotypes'] = $mres->get_all_logotypes();
		$data['flags'] = $mres->get_all_flags();
		$data['teams'] = $mres->get_all_teams();
		$this->template->content = View::factory('mroom/mroom_teams_view',$data);	
	}


	public function action_delete()	
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		if ($mres->del_team($id)) 
		{
			$data['ok']='';
		} else {
			$data['errors']='';
		}

		$this->template->content = View::factory('mroom/mroom_team_del',$data);	
	}

	public function action_edit()
	{
		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$data['team'] = $mres->get_team($id);

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$shortname = Arr::get($_POST, 'shortname', '');			
			$disciplineID = Arr::get($_POST, 'disciplineID', '');   
			$logotypeID = Arr::get($_POST, 'logotypeID', ''); 
			$flagID = Arr::get($_POST, 'flagID', ''); 

			if ($mres->edit_team($id,$name,$shortname,$disciplineID,$logotypeID,$flagID)) 
			{
				$data['ok']='';
				Controller::redirect('mroom/teams');	
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['disciplines'] = $mres->get_all_disciplines();
		$data['logotypes'] = $mres->get_all_logotypes();
		$data['flags'] = $mres->get_all_flags();
		$data['team'] = $mres->get_team($id);
		$this->template->content = View::factory('mroom/mroom_team_edit',$data);	
	}


}