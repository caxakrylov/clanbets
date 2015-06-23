<?php defined('SYSPATH') or die('No direct script access.');

class Model_Muser extends ORM {

	protected $_table_name = 'users';
	protected $errors = array();

	public function rules() //valid, -, id
	{
		return array (
			'username' => array(
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 254)),
				array('alpha_dash'),
				array(array($this, 'login_uniq')),
			),
			'email' => array(
				array('not_empty'),
				array('max_length', array(':value', 254)),
				array('email'),
				array(array($this, 'email_uniq')),	
			),
			'money' => array(
				// array('max_length', array(':value', 15)), //валид-ся как 12 в Resources (make_deposit)
				array('numeric'),
			),				
		);
	}


	public function login_uniq($login)
	{
		$db = Database::instance();
		if ($this->id)
		{
			$query =
				'SELECT id
				FROM users
				WHERE id != '.$this->id.' AND username = '.$db->escape($login);
		} else {
			$query =
				'SELECT id
				FROM users
				WHERE username = '.$db->escape($login);
		}

		$result = $db->query(Database::SELECT, $query, FALSE)->as_array();
		if (count($result) > 0)
		{
			return FALSE;
		} else {
			return TRUE; //Yes, uniq
		}
	}

	public function email_uniq($email)
	{
		$db = Database::instance();
		if ($this->id)
		{
			$query =
				'SELECT id
				FROM users
				WHERE id != '.$this->id.' AND email = '.$db->escape($email);
		} else {
			$query =
				'SELECT id
				FROM users
				WHERE email = '.$db->escape($email);
		}

		$result = $db->query(Database::SELECT, $query, FALSE)->as_array();
		if (count($result) > 0)
		{
			return FALSE;
		} else {
			return TRUE; //Yes, uniq
		}
	}

}
