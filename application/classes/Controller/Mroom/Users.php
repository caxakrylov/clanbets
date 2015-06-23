<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Users extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';

    	public function action_index()
	{
		date_default_timezone_set('UTC');
		$data = array();
		$mres = new Model_Resources();
		$data['users'] = $mres->get_all_users();
		$data['mainbets'] = $mres->get_all_mainbets();
		$data['transactions'] = $mres->get_all_transactions();
		$data['unreadmess'] = $mres->get_unreadmessages();

		$this->template->content =  View::factory('mroom/mroom_users_view',$data);
	}

	public function action_edit()
	{
		date_default_timezone_set('UTC');
		$data = array();
		$id = $this->request->param('id');
		if ($id == 0)  // ошибка удаления ставки, action_del()
		{
			$data['error']='';
		}
		else
		{
			$mres = new Model_Resources();
			$data['user'] = $mres->get_user($id);
			$data['mainbets'] = $mres->get_user_mainbets_activemap($id);
			$data['mainbets2'] = $mres->get_user_mainbets_activemap_not2($id);
		}

		$this->template->content = View::factory('mroom/mroom_user_edit',$data);
	}


	public function action_setcencelbets()
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$mres->user_cancelbets($id);
		Controller::redirect("mroom/users/edit/$id");
	}

	public function action_editoutsiders()
	{
		date_default_timezone_set('UTC');
		$data = array();
		$id = $this->request->param('id');
		if ($id == 0)  // ошибка удаления ставки, action_del()
		{
			$data['error']='';
		}
		else
		{
			$mres = new Model_Resources();
			$data['user'] = $mres->get_user($id); // Запрос оптимизирован
			$data['mainbets'] = $mres->get_user_mainbets_outsiders($id);
			$data['mainbets2'] = $mres->get_user_mainbets_outsiders_not2($id);
		}

		$this->template->content = View::factory('mroom/mroom_user_editoutsiders',$data);
	}

	public function action_oldmatch()
	{
		date_default_timezone_set('UTC');
		$id = $this->request->param('id');
		$data = array();
		$mres = new Model_Resources();
		$data['user'] = $mres->get_user($id);
		$data['mainbets'] = $mres->get_user_mainbets_activemap($id);

		$this->template->content =  View::factory('mroom/mroom_user_endbets',$data);
	}

	public function action_oldmatchoutsiders()
	{
		date_default_timezone_set('UTC');
		$id = $this->request->param('id');
		$data = array();
		$mres = new Model_Resources();
		$data['user'] = $mres->get_user($id);
		$data['mainbets'] = $mres->get_user_mainbets_outsiders($id);

		$this->template->content =  View::factory('mroom/mroom_user_endbetsoutsiders',$data);
	}

	public function action_transaction()
	{
		date_default_timezone_set('UTC');
		$id = $this->request->param('id');
		$data = array();

		if ($id == 0)  // ошибка Отмены ставки
		{
			$data['error']='';
		}
		else
		{
			$mres = new Model_Resources();
			$data['user'] = $mres->get_user($id);
			$data['transactions'] = $mres->get_user_transaction($id);
		}

		$this->template->content = View::factory('mroom/mroom_user_transactions',$data);
	}

	public function action_cashoutlist()
	{
		date_default_timezone_set('UTC');
		$data = array();
		$mres = new Model_Resources();
		$data['usercashouts'] = $mres->get_all_usercashouts();

		$this->template->content =  View::factory('mroom/mroom_user_cashouts',$data);
	}


	public function action_closetransaction()
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();

		if ($mres->close_transactionOUT($id)) {
			Controller::redirect("mroom/users/cashoutlist");
		} else {
			Controller::redirect("mroom/users/transaction/0");
		}
	}


	public function action_performcashout()
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();

		if ($mres->perform_cashout($id)) {
			Controller::redirect("mroom/users/cashoutlist");
		} else {
			Controller::redirect("mroom/users/transaction/0");
		}
	}


	public function action_messages()
	{
		date_default_timezone_set('UTC');
		$id = $this->request->param('id');
		$data = array();
		$mres = new Model_Resources();
		$data['user'] = $mres->get_user($id);

		$this->template->content =  View::factory('mroom/mroom_user_messages',$data);
	}

}

