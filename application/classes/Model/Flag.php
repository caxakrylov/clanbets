<?php defined('SYSPATH') or die('No direct script access.');

class Model_Flag extends ORM {

	protected $errors = array();

	public function rules() //valid, -, id
	{
		return array (
			'name' => array(
				array('not_empty'),
	            			array('max_length', array(':value', 10)),
				array(array($this, 'name_unique')),
			),
			'icon' => array(
			           array('not_empty'),
	        		),            
		);
	}

	public function name_unique($name)
	{
		$db = Database::instance();

		if ($this->id)
		{
			$query =
			    	'SELECT id
			    	FROM flags
			    	WHERE id != '.$this->id.' AND name = '.$db->escape($name);
		} else {
			$query =
				'SELECT id
			        	FROM flags
			        	WHERE name = '.$db->escape($name);
		}

		$result = $db->query(Database::SELECT, $query, FALSE)->as_array();
		if (count($result) > 0)
		{
		        	return FALSE;
		} else {
		        	return TRUE;
		}
	}

}
