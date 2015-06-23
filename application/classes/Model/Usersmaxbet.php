<?php defined('SYSPATH') or die('No direct script access.');

class Model_Usersmaxbet extends ORM {

  	protected $errors = array();
	
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'user' => array(
			'model'       => 'Muser',
			'foreign_key' => 'userID',
		),
		'match' => array(
			'model'       => 'Match',
			'foreign_key' => 'matchID',
		),
	);


	public function rules() //valid, -, id
	{
		return array (
			'maxbet' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'), 
			),	
		);
	}
}
