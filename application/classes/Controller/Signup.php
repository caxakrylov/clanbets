<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signup extends MControllerSignup {

	public $template = 'user/base';

	public function action_index() //valid, -, id
	{
		$data = array();

		if (isset($_POST['signup_btnsubmit']))
		{
			$login = Arr::get($_POST, 'signup_login', '');
			$email = Arr::get($_POST, 'signup_email', '');
			$password = Arr::get($_POST, 'signup_password', '');
			$password2 = Arr::get($_POST, 'signup_password2', '');
			$terms = Arr::get($_POST, 'signup_terms', '');
			$msignup = new Model_Signup();

			if ($msignup->add_user($login,$email,$password,$password2,$terms))
			{
				$data['email'] = $email;
				$this->template->content = View::factory('user/signupOK_view', $data);
				$this->template->js = View::factory('user/signupOK_view_js');
				$this->template->css = View::factory('user/index_view_css');
			} else {
				$data['errors']='';
				$this->template->content = View::factory('user/signup_view', $data);
				$this->template->js = View::factory('user/signup_view_js');
				$this->template->css = View::factory('user/index_view_css');
			}
		} else {
			$this->template->content = View::factory('user/signup_view', $data);
			$this->template->js = View::factory('user/signup_view_js');
			$this->template->css = View::factory('user/index_view_css');
		}
	}



	public function action_recoverypassword() //valid, -, id
	{
		$data = array();

		if (isset($_POST['recovery_btnsubmit']))
		{
			$email = Arr::get($_POST, 'recovery_email', '');
			$msignup = new Model_Signup();
			if($msignup->recoverypassword($email))
			{
				$data["ok"] = "";
			}
			else {
				$data["errors"] = "";
			}
		}

		$this->template->content =  View::factory('user/recoverypassword_view', $data);
		$this->template->js = View::factory('user/recoverypassword_view_js');
		$this->template->css = View::factory('user/index_view_css');
	}

}
