<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Logotypes extends MControllerAdmin
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

			if ($mres->add_logotype($name,$filename,$filename64)) 
			{
	            			$useful->save_image($_FILES['icon'], $filename,$filename64);
				$data['ok']='';
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['logotypes'] = $mres->get_all_logotypes();
		$this->template->content = View::factory('mroom/mroom_logotypes_view',$data);	
	}

	public function action_delete()	
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		if ($mres->del_logotype($id)) 
		{
			$data['ok']='';
		} else {
			$data['errors']='';
		}

		$this->template->content = View::factory('mroom/mroom_logotype_del',$data);	
	}

	public function action_edit()
	{
		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$useful = new Model_Useful();
		$filename = NULL;
		$data['logotype'] = $mres->get_logotype($id);

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$filename = $data['logotype']->icon;

			if (Upload::not_empty($_FILES['icon']) && Upload::valid($_FILES['icon']))
		            {
				$filename = $useful->get_filename();
				$filename64 = $filename."64.jpg";
				$filename .= ".jpg";
		            }

			if ($mres->rename_logotype($id,$name,$filename, $filename64)) 
			{
				if ($filename != $data['logotype']->icon)  //Проверка изменилось ли название файла или нет, т.е. был ли указан новый файл
				{ 
					$useful->save_image($_FILES['icon'], $filename, $filename64);
				}
				$data['ok']='';
				Controller::redirect('mroom/logotypes');
			} else {
				$data['errors']=$mres->errors;
			}

		}

		$data['logotype'] = $mres->get_logotype($id);
		$this->template->content = View::factory('mroom/mroom_logotype_edit',$data);	
	}
}