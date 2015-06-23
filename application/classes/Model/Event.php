<?php defined('SYSPATH') or die('No direct script access.');

class Model_Event extends ORM {

    protected $errors = array();

	public function rules() //valid, -, id
	{
		return array (
			'name' => array(
				array('not_empty'),
				array('max_length', array(':value', 30)),
			),		
		);
	}
}
