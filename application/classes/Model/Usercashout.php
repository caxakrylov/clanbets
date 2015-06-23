<?php defined('SYSPATH') or die('No direct script access.');

class Model_Usercashout extends ORM {

 	protected $errors = array();
 	
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'psystem' => array(
			'model'       => 'Psystem',
			'foreign_key' => 'psystemID',
		),
		'transaction' => array(
			'model'       => 'Transaction',
			'foreign_key' => 'transactionID',
		),								
	);

	public function rules() //valid, -, id
	{
		return array (
			'ewallet_number' => array(
				array('max_length', array(':value', 100))
			),			
			'sum_withdraw' => array(
				array('max_length', array(':value', 15)),
				array('numeric'),
			),	
		);
	}
}




