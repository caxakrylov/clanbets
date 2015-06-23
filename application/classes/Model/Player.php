<?php defined('SYSPATH') or die('No direct script access.');

class Model_Player extends ORM {

    protected $errors = array();
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'team' => array(
			'model'       => 'Team',
			'foreign_key' => 'teamID',
		),	
	);


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
