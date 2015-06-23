<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Disciplines extends MControllerAdmin
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
			$shortname = Arr::get($_POST, 'shortname', '');

			if (Upload::not_empty($_FILES['icon']) && Upload::valid($_FILES['icon']))
			{
				$filename = $useful->get_filename();
				$filename64 = $filename."64.jpg";
				$filename .= ".jpg";
			}

			if ($mres->add_discipline($name,$shortname,$filename,$filename64))
			{
	            		$useful->save_image_discipline($_FILES['icon'], $filename, $filename64);
				$data['ok']='';
			} else {
				$data['errors']=$mres->errors;
			}
		}

		$data['disciplines'] = $mres->get_all_disciplines();
		$this->template->content = View::factory('mroom/mroom_disciplines_view',$data);
	}

	public function action_delete()
	{
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		if ($mres->del_discipline($id))
		{
			$data['ok']='';
		} else {
			$data['errors']='';
		}

		$this->template->content = View::factory('mroom/mroom_discipline_del',$data);


	}

	public function action_edit(){

		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$useful = new Model_Useful();
		$filename = NULL;
		$filename64 = NULL;
		$data['discipline'] = $mres->get_discipline($id);

		if(isset($_POST['submit']))
		{
			$name = Arr::get($_POST, 'name', '');
			$shortname = Arr::get($_POST, 'shortname', '');
			$filename = $data['discipline']->icon;

			if (Upload::not_empty($_FILES['icon']) && Upload::valid($_FILES['icon']))
			{
				$filename = $useful->get_filename();
				$filename64 = $filename."64.jpg";
				$filename .= ".jpg";
			}

			if ($mres->rename_discipline($id,$name,$shortname,$filename,$filename64))
			{
				if ($filename != $data['discipline']->icon) //Проверка изменилось ли название файла или нет, т.е. был ли указан новый фаил
				{
					$useful->save_image_discipline($_FILES['icon'], $filename, $filename64);
				}
				$data['ok']='';
				Controller::redirect('mroom/disciplines');
			} else {
				$data['errors']=$mres->errors;
			}

		}

		$data['discipline'] = $mres->get_discipline($id);
		$this->template->content = View::factory('mroom/mroom_discipline_edit',$data);
	}


}