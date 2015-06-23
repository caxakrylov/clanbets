<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Flags extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';

	public function action_index()
	{
		$data = array();
		$mres = new Model_Resources();
		$useful = new Model_Useful();
		$filename = NULL;
		$filename64 = NULL;

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');

			if (Upload::not_empty($_FILES['icon']) && Upload::valid($_FILES['icon']))
			{
				$filename = $useful->get_filename();
				$filename64 = $filename."64.jpg";
				$filename .= ".jpg";
            		}

			if ($mres->add_flag($name,$filename,$filename64)) 
			{
	            			$useful->save_image($_FILES['icon'], $filename, $filename64);
				$data['ok']='';
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['flags'] = $mres->get_all_flags();
		$this->template->content = View::factory('mroom/mroom_flags_view',$data);	
	}

	public function action_delete()	
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		if ($mres->del_flag($id)) 
		{
			$data['ok']='';
		} else {
			$data['errors']='';
		}

		$this->template->content = View::factory('mroom/mroom_flag_del',$data);	
	}

	public function action_edit()
	{
		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$useful = new Model_Useful();
		$filename = NULL;
		$data['flag'] = $mres->get_flag($id);

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$filename = $data['flag']->icon;

			if (Upload::not_empty($_FILES['icon']) && Upload::valid($_FILES['icon']))
            			{
					$filename = $useful->get_filename();
					$filename64 = $filename."64.jpg";
					$filename .= ".jpg";
            			}

			if ($mres->rename_flag($id,$name,$filename,$filename64)) 
			{
				if ($filename != $data['flag']->icon)  //Проверка изменилось ли название файла или нет, т.е. был ли указан новый файл
				{ 
					$useful->save_image($_FILES['icon'], $filename,$filename64);
				}
				$data['ok']='';
				Controller::redirect('mroom/flags');
			} else {
				$data['errors']=$mres->errors;
			}

		}

		$data['flag'] = $mres->get_flag($id);
		$this->template->content = View::factory('mroom/mroom_flag_edit',$data);	
	}


}