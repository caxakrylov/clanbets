<?php defined('SYSPATH') or die('No direct script access.');

class Model_Log extends ORM {

    protected $errors = array();
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'match' => array(
			'model'       => 'Match',
			'foreign_key' => 'matchID',
		),
	);

	public function rules() //valid, -, id
	{
		return array (
			'state' => array(
				array('not_empty'),
				array('max_length', array(':value', 3)),
				array('digit'),
			),
		);
	}
}
