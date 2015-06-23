<?php defined('SYSPATH') or die('No direct script access.');

class Model_Team extends ORM {

    protected $errors = array();
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'discipline' => array(
			'model'       => 'Discipline',
			'foreign_key' => 'disciplineID',
		),
		'logotype' => array(
			'model'       => 'Logotype',
			'foreign_key' => 'logotypeID',
		),
		'flag' => array(
			'model'       => 'Flag',
			'foreign_key' => 'flagID',
		),		
	);


	public function rules() //valid, -, id
	{
		return array (
			'name' => array(
				array('not_empty'),
				array('max_length', array(':value', 30)),
			),
			'shortname' => array(
				array('not_empty'),
				array('max_length', array(':value', 15)),
			),			
		);
	}
}
