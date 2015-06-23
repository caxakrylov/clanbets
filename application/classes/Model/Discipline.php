<?php defined('SYSPATH') or die('No direct script access.');

class Model_Discipline extends ORM {

	protected $errors = array();

	public function rules() //valid, -, id
	{
		return array (
			'name' => array(
				array('not_empty'),
	          		array('max_length', array(':value', 30)),
				array(array($this, 'name_unique')),
			),
			'shortname' => array(
				array('not_empty'),
	          		array('max_length', array(':value', 10)),
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
			    	FROM disciplines
			    	WHERE id != '.$this->id.' AND name = '.$db->escape($name);
		} else {
			$query =
				'SELECT id
			        	FROM disciplines
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
