<?php defined('SYSPATH') or die('No direct script access.');

class Model_Transaction extends ORM {

	protected $errors = array();
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'user' => array(
			'model'       => 'Muser',
			'foreign_key' => 'userID',
		),
		'usercashout' => array(
			'model'       => 'Usercashout',
			'foreign_key' => 'UsercashoutID',
		),							
	);

}
