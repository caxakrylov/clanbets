<?php defined('SYSPATH') or die('No direct script access.');

class Model_Mainbet extends ORM {

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
		'team1' => array(
			'model'       => 'Team',
			'foreign_key' => 'teamID1',
		),
		'team2' => array(
			'model'       => 'Team',
			'foreign_key' => 'teamID2',
		),
		'player1' => array(
			'model'       => 'Player',
			'foreign_key' => 'playerID1',
		),
		'player2' => array(
			'model'       => 'Player',
			'foreign_key' => 'playerID2',
		),						
	);

	public function rules() //valid, -, id
	{
		return array (
			'rate1' => array(
				array('not_empty'),
				array('max_length', array(':value', 6)),
				array('numeric'),
			),
			'rate2' => array(
				array('not_empty'),
				array('max_length', array(':value', 6)),
				array('numeric'),
			),	
			'ratedraw' => array(
				array('not_empty'),
				array('max_length', array(':value', 6)),
				array('numeric'),
			),
			'sum1' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'),
			),
			'sum2' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'),
			),
			'sumdraw' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'),
			),
		);
	}


}
