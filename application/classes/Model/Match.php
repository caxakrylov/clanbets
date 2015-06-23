<?php defined('SYSPATH') or die('No direct script access.');

class Model_Match extends ORM {

 	protected $errors = array();
 	
	protected $_belongs_to = array( //Связь между таблицами один ко многим
		'discipline' => array(
			'model'       => 'Discipline',
			'foreign_key' => 'disciplineID',
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
		'event' => array(
			'model'       => 'Event',
			'foreign_key' => 'eventID',
		),
		'map1playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map1_playerID1',
		),
		'map1playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map1_playerID2',
		),
		'map2playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map2_playerID1',
		),
		'map2playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map2_playerID2',
		),
		'map3playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map3_playerID1',
		),
		'map3playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map3_playerID2',
		),
		'map4playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map4_playerID1',
		),
		'map4playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map4_playerID2',
		),
		'map5playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map5_playerID1',
		),
		'map5playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map5_playerID2',
		),
		'map6playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map6_playerID1',
		),
		'map6playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map6_playerID2',
		),
		'map7playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map7_playerID1',
		),
		'map7playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map7_playerID2',
		),
		'map8playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map8_playerID1',
		),
		'map8playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map8_playerID2',
		),
		'map9playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map9_playerID1',
		),
		'map9playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map9_playerID2',
		),
		'map10playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map10_playerID1',
		),
		'map10playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map10_playerID2',
		),
		'map11playerID1' => array(
			'model'       => 'Player',
			'foreign_key' => 'map11_playerID1',
		),
		'map11playerID2' => array(
			'model'       => 'Player',
			'foreign_key' => 'map11_playerID2',
		)
	);

	public function rules() //valid, -, id
	{
		return array (
			'rate1' => array(
				array('not_empty'),
				array('max_length', array(':value', 6)),
				array('numeric'), //число с плавающей запятой
			),
			'rate2' => array(
				array('not_empty'),
				array('max_length', array(':value', 6)),
				array('numeric'),
			),
			'draw' => array(
				array('not_empty'),
				array('max_length', array(':value', 6)),
				array('numeric'),
			),
			'maxbet' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'), 
			),
			'datetime' => array(
				array('not_empty'),
				array('digit'), //число без дробной части
			),
			'bestof' => array(
				array('not_empty'),
				array('digit'),
				array('max_length', array(':value', 2)),
			),
			'marge' => array(
				array('not_empty'),
				array('max_length', array(':value', 4)),
				array('decimal', array(':value', 2, 1)), // дробное число с фиксированным колличеством знаков.
			),
			'allsum_rate1' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'),
			),
			'allsum_rate2' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'),
			),
			'allsum_draw' => array(
				array('not_empty'),
				array('max_length', array(':value', 7)),
				array('numeric'),
			),															
		);
	}
}




