<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends MControllerUser {

	public $template = 'user/base';

	public function action_edit() //valid, -, id
	{
		$data = array();
		$auth = Auth::instance();
		$user_id = $auth->get_user();
		$user =  ORM::factory('Muser',array('id'=>$user_id));
		$data['username'] = $user->username;
		$data['email'] = $user->email;
		$data['check_mail'] = $user->check_mail;

		if (isset($_POST['change_btnsubmit']))
		{
			$current_password = Arr::get($_POST, 'current_password', '');
			$new_password = Arr::get($_POST, 'signup_password', '');
			$password2 = Arr::get($_POST, 'signup_password2', '');

			$mres = new Model_Resources();

			if ($mres->change_password($current_password,$new_password,$password2))
			{
				$data['ok'] = '';
			} else {
				$data['errors']='';
			}
		}

		$this->template->content = View::factory('user/edit_profile_view', $data);
		$this->template->js = View::factory('user/edit_profile_js');
		$this->template->css = View::factory('user/index_view_css');
	}


	public function action_cashout() //valid, -, id
	{
		$data = array();
		$auth = Auth::instance();
		$user_id = $auth->get_user();
		$mres = new Model_Resources();
		$data['psystem'] = $mres->get_all_psystem();

		$data['cashouts'] = $mres->get_user_cashouts($user_id);
		$data['state_comm'] = 0;

		foreach($data['cashouts'] as $itemcashout){
			if ($itemcashout->timecreate > date(strtotime('-1 month'))) {
				$data['state_comm'] = 1;
				break;
			}
		}

		if (isset($_POST['btn_cashout']))
		{
			$psystem = Arr::get($_POST, 'psystem', '');
			$ewallet_number = Arr::get($_POST, 'ewallet_number', '');
			$sum_withdraw = Arr::get($_POST, 'sum_withdraw', '');

			if ($mres->go_cashout($psystem, $ewallet_number, $sum_withdraw, $data['state_comm']))
			{
				$data['ok'] = '';
			} else {
				$data['errors'] = '';
			}
		}

		$data['cashouts'] = $mres->get_user_cashouts($user_id);
		$data['usermoney'] = $mres->get_usermoney($user_id);
		$data['freemoney'] = $mres->get_userfreemoney($user_id);
		$data['offset'] = $_SESSION['utc_user']*60*60; //UTC user
		$data['UTCuser'] = date("d.m.Y", $data['offset']+time()); //real time

		$this->template->content = View::factory('user/cash_out_view', $data);
		$this->template->js = View::factory('user/cash_out_view_js', $data);
		$this->template->css = View::factory('user/index_view_css');
	}


	public function action_mybets() //valid, -, id
	{
		$data = array();
		$mres = new Model_Resources();
		$auth = Auth::instance();
		$user_id = $auth->get_user();
		$data['mainbets'] = $mres->get_user_mainbets($user_id);
		$data['offset'] = $_SESSION['utc_user']*60*60; //UTC user
		$data['UTCuser'] = date("d.m.Y", $data['offset']+time()); //real time

		$this->template->content = View::factory('user/stats_bets_user', $data);
		$this->template->js = View::factory('user/stats_bets_user_js');
		$this->template->css = View::factory('user/stats_bets_user_css');
	}

	public function action_deposit() //valid, -, id
	{
		$data = array();
		$auth = Auth::instance();
		$mres = new Model_Resources();
		$user_id = $auth->get_user();

		if (isset($_POST['btn_deposit']))
		{
			$sum_deposit = Arr::get($_POST, 'sum_deposit', '');
			$check_promo = Arr::get($_POST, 'check_promo', '');

			if ($temp = $mres->make_deposit($sum_deposit, $check_promo))
			{
				unset($_SESSION['depositcheck']);
				$data['sum'] = $sum_deposit;
				$data['check_promo'] = $check_promo;
				$data['deposit_id'] = $temp->id;
				$this->template->content = View::factory('user/make_a_deposit_go', $data);
				$this->template->js = View::factory('user/make_a_deposit_go_js');
				$this->template->css = View::factory('user/index_view_css');
				return TRUE;
			} else {
				$data['errors']='';
			}
		}

		if (isset($_GET['check']) && !isset($_SESSION['depositcheck'])) {
			$_SESSION['depositcheck'] = 1;
			if ($_GET['check'] == 'success')
				$data['ok'] = '';
			elseif ($_GET['check'] == 'fail')
				$data['errors'] = '';
		}

		$data['deposits'] = $mres->get_user_deposits_success($user_id);
		$data['offset'] = $_SESSION['utc_user']*60*60; //UTC user
		$data['UTCuser'] = date("d.m.Y", $data['offset']+time()); //real time

		$this->template->content = View::factory('user/make_a_deposit_view', $data);
		$this->template->js = View::factory('user/make_a_deposit_js');
		$this->template->css = View::factory('user/index_view_css');
	}

}
