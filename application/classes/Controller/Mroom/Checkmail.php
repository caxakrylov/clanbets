<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Checkmail extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';
	
    	public function action_index()
	{
		$data = array();
		$useful = new Model_Useful();

		if(isset($_POST['submit']))
		{
			$email = Arr::get($_POST, 'email', '');

			//Отправка электройнной почты
			$subject = 'TEST EMAIL clanbets.com';
			$message = 'Это тестовое письмо, отправленное с сайта clanbets.com. Для проверки работоспособности почты';
			$from = array('noreply@clanbets.com' => 'Clanbets.com test');

	   		if ($useful->sendmail($email,$subject,$message,$from))
				$data['ok']='';
			else 
				$data['errors']=$mres->errors;
			
		}

		$this->template->content = View::factory('mroom/mroom_checkmail_view',$data);	
	}

}