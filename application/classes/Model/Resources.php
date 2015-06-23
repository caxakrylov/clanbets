<?php defined('SYSPATH') or die('No direct script access.');

class Model_Resources {

	public function get_all_disciplines() //valid, -, id
	{
		return ORM::factory('Discipline')->find_all();
	}

	public function add_discipline($name,$shortname,$filename,$filename64) //valid, -, id
	{
		$temp = new Model_Discipline();
		$temp->name = $name;
		$temp->shortname = $shortname;
		$temp->icon = $filename;
		$temp->icon64 = $filename64;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function del_discipline($id) //valid, -, id
	{
		$temp = ORM::factory('Discipline', array('id'=>$id));
		$temp_link = ORM::factory('Team', array('disciplineID'=>$id));
		$temp_link2 = ORM::factory('Match', array('disciplineID'=>$id));

		if ($temp_link->disciplineID != $id && $temp_link2->disciplineID != $id) //Проверка на существавание связанных записей
		{
			$temp->delete();
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_discipline($id) //valid, -, id
	{
		return ORM::factory('Discipline',array('id'=>$id));
	}

	public function rename_discipline($id,$name,$shortname,$filename,$filename64) //valid, -, id
	{
		$temp = ORM::factory('Discipline',array('id'=>$id));
		$temp->name = $name;
		$temp->shortname = $shortname;
		$temp->icon = $filename;
		$temp->icon64 = $filename64;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

												// КОМАДЫ
	public function get_all_teams() //valid, -, id
	{
		return ORM::factory('Team')->find_all();
	}

	public function add_team($name,$shortname,$disciplineID,$logotypeID,$flagID) //valid, -, id
	{
		$temp = new Model_Team();
		$temp->name = $name;
		$temp->shortname = $shortname;
		$temp->disciplineID = $disciplineID;
		$temp->logotypeID = $logotypeID;
		$temp->flagID = $flagID;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function del_team($id) //valid, -, id
	{

		$temp = ORM::factory('Team', array('id'=>$id));

		$temp_link = ORM::factory('Player', array('teamID'=>$id));
		$temp_link2 = ORM::factory('Match', array('teamID1'=>$id));
		$temp_link3 = ORM::factory('Match', array('teamID2'=>$id));

		if ($temp_link->teamID != $id && $temp_link2->teamID1 != $id && $temp_link3->teamID2 != $id) //Проверка на существавание связанных записей
		{
			$temp->delete();
			return TRUE;
		} else {
			return FALSE;
		}


	}

	public function get_team($id) //valid, -, id
	{
		return ORM::factory('Team',array('id'=>$id));
	}

	public function edit_team($id,$name,$shortname,$disciplineID,$logotypeID,$flagID)  //valid, -, id
	{
		$temp = ORM::factory('Team',array('id'=>$id));
		$temp->name = $name;
		$temp->shortname = $shortname;
		$temp->disciplineID = $disciplineID;
		$temp->logotypeID = $logotypeID;
		$temp->flagID = $flagID;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

												// ГОТИПЫ
	public function get_all_logotypes() //valid, -, id
	{
		return DB::select()
		->from('logotypes')
		->execute()
		->as_array();
	}

	public function add_logotype($name,$filename,$filename64) //valid, -, id
	{
		$temp = new Model_Logotype();
		$temp->name = $name;
		$temp->icon = $filename;
		$temp->icon64 = $filename64;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function del_logotype($id) //valid, -, id
	{
		$temp = ORM::factory('Logotype', array('id'=>$id));
		$temp_link = ORM::factory('Team', array('logotypeID'=>$id));
		if ($temp_link->logotypeID != $id) //Проверка на существавание связанных записей
		{
			$temp->delete();
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function get_logotype($id)  //valid, -, id
	{
		return ORM::factory('Logotype',array('id'=>$id));
	}

	public function rename_logotype($id,$name,$filename,$filename64)  //valid, -, id
	{
		$temp = ORM::factory('Logotype',array('id'=>$id));
		$temp->name = $name;
		$temp->icon = $filename;
		$temp->icon64 = $filename64;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}
												// НАЦИОНАГИ
	public function get_all_flags() //valid, -, id
	{
		return DB::select()
		->from('flags')
		->execute()
		->as_array();
	}

	public function add_flag($name,$filename,$filename64)  //valid, -, id
	{
		$temp = new Model_Flag();
		$temp->name = $name;
		$temp->icon = $filename;
		$temp->icon64 = $filename64;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function del_flag($id)  //valid, -, id
	{
		$temp = ORM::factory('Flag', array('id'=>$id));
		$temp_link = ORM::factory('Team', array('flagID'=>$id));
		if ($temp_link->flagID != $id) //Проверка на существавание связанных записей
		{
			$temp->delete();
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function get_flag($id) //valid, -, id
	{
		return ORM::factory('Flag',array('id'=>$id));
	}

	public function rename_flag($id,$name,$filename,$filename64)  //valid, -, id
	{
		$temp = ORM::factory('Flag',array('id'=>$id));
		$temp->name = $name;
		$temp->icon = $filename;
		$temp->icon64 = $filename64;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

													// ИГРОКИ
	public function get_all_players() //valid, -, id
	{
		return ORM::factory('Player')->find_all();
	}

	public function add_player($name,$teamID)  //valid, -, id
	{
		$temp = new Model_Player();
		$temp->name = '.'.$name;
		$temp->teamID = $teamID;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function del_player($id) //valid, -, id
	{
		$temp = ORM::factory('Player', array('id'=>$id));

		$temp_link2 = ORM::factory('Match', array('playerID1'=>$id));
		$temp_link3 = ORM::factory('Match', array('playerID2'=>$id));

		if ($temp_link2->playerID1 != $id && $temp_link3->playerID2 != $id) //Проверка на существавание связанных записей
		{
			$temp->delete();
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_player($id) //valid, -, id
	{
		return ORM::factory('Player',array('id'=>$id));
	}

	public function edit_player($id,$name,$teamID) //valid, -, id
	{
		$temp = ORM::factory('Player',array('id'=>$id));
		$temp->name = $name;
		$temp->teamID = $teamID;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

													// ИВЕНТЫ
	public function get_all_events() //valid, -, id
	{
		return ORM::factory('Event')->find_all();
	}

	public function add_event($name) //valid, -, id
	{
		$temp = new Model_Event();
		$temp->name = $name;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function del_event($id)  //valid, -, id
	{
		$temp = ORM::factory('Event', array('id'=>$id));
		$temp_link = ORM::factory('Match', array('eventID'=>$id));

		if ($temp_link->eventID != $id) //Проверка на существавание связанных записей
		{
			$temp->delete();
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_event($id)  //valid, -, id
	{
		return ORM::factory('Event',array('id'=>$id));
	}

	public function rename_event($id,$name) //valid, -, id
	{
		$temp = ORM::factory('Event',array('id'=>$id));
		$temp->name = $name;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

													// МАТЧИ
	public function get_match_teams($disciplineID) //valid, -, id
	{
		return DB::select()
		->from('teams')
		->where('disciplineID', '=', $disciplineID)
		->order_by('name', 'ASC')
		->execute()
		->as_array();
	}

	public function get_match_players($teamID) //valid, -, id
	{
		return DB::select()
		->from('players')
		->where('teamID', '=', $teamID)
		->execute()
		->as_array();
	}

	public function add_match($disciplineID,$teamID1,$teamID2,$playerID1,$playerID2,$rate1,$rate2,$datetime,$eventID,$draw,$maxbet,$createdate,$bestof,$marge,$sum1,$sum2,$drawsum,$outsider,$allmap_rate1,$allmap_rate2,$allmap_rate1_allsum,$allmap_rate2_allsum,
		$map1_playerID1,$map1_playerID2,$map1_rate1,$map1_rate2,
		$map2_playerID1,$map2_playerID2,$map2_rate1,$map2_rate2,
		$map3_playerID1,$map3_playerID2,$map3_rate1,$map3_rate2,
		$map4_playerID1,$map4_playerID2,$map4_rate1,$map4_rate2,
		$map5_playerID1,$map5_playerID2,$map5_rate1,$map5_rate2,
		$map6_playerID1,$map6_playerID2,$map6_rate1,$map6_rate2,
		$map7_playerID1,$map7_playerID2,$map7_rate1,$map7_rate2,
		$map8_playerID1,$map8_playerID2,$map8_rate1,$map8_rate2,
		$map9_playerID1,$map9_playerID2,$map9_rate1,$map9_rate2,
		$map10_playerID1,$map10_playerID2,$map10_rate1,$map10_rate2,
		$map11_playerID1,$map11_playerID2,$map11_rate1,$map11_rate2,
		$map1_proc,$map2_proc,$map3_proc,$map4_proc,$map5_proc,$map6_proc,$map7_proc,$map8_proc,$map9_proc,$map10_proc,$map11_proc,$marge_map,$preim1,$preim2) //valid, -, id
	{
		$temp = new Model_Match();
		$temp->disciplineID = $disciplineID;
		$temp->teamID1 = $teamID1;
		$temp->teamID2 = $teamID2;
		$temp->playerID1 = $playerID1;
		$temp->playerID2 = $playerID2;
		$temp->rate1 = $rate1;
		$temp->rate2 = $rate2;
		$temp->datetime = $datetime;
		$temp->eventID = $eventID;
		$temp->draw = $draw;
		$temp->maxbet = $maxbet;
		$temp->createdate = $createdate;
		$temp->state = 1;
		$temp->new = 1;
		$temp->bestof = $bestof;
		$temp->marge = $marge;
		$temp->marge_map = $marge_map;
		if ($drawsum == 0.00) {
			$temp->allsum_rate1 = $sum1;
			$temp->allsum_rate2 = $sum2;
			$temp->allsum_draw = $drawsum;
		} else {
			$temp->allsum_rate1 = $sum1*100;
			$temp->allsum_rate2 = $sum2*100;
			$temp->allsum_draw = $drawsum*100;
		}
		$temp->outsider = $outsider;
		if ($bestof >= 2) {
			if ($map1_proc == 0 || $map1_proc == '') { //если нету специально выставленного для данной карты коэффициента, тогда устанавливаем общий коэффцициент.
				$temp->map1_rate1 = $allmap_rate1;
				$temp->map1_rate2 = $allmap_rate2;
				$temp->map1_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map1_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map1_rate1 = $map1_rate1;
				$temp->map1_rate2 = $map1_rate2;
				$temp->map1_allsum_rate1 = $map1_proc;
				$temp->map1_allsum_rate2 = 100 - $map1_proc;
			}

			if ($map2_proc == 0 || $map2_proc == '') {
				$temp->map2_rate1 = $allmap_rate1;
				$temp->map2_rate2 = $allmap_rate2;
				$temp->map2_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map2_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map2_rate1 = $map2_rate1;
				$temp->map2_rate2 = $map2_rate2;
				$temp->map2_allsum_rate1 = $map2_proc;
				$temp->map2_allsum_rate2 = 100 - $map2_proc;
			}

			if ($preim1 == 1) { //если есть преимущество в 1одну карту
				$temp->map1_state = 3;
				$temp->map1_score1 = 1;
				$temp->map1_score2 = 0;
			} elseif ($preim2 == 1) {
				$temp->map1_state = 3;
				$temp->map1_score1 = 0;
				$temp->map1_score2 = 1;
			} else {
				$temp->map1_state = 1; // 1 - active, 2 - start, 3 - close.
			}

			$temp->map2_state = 1;
			$temp->map1_playerID1 = $map1_playerID1;
			$temp->map1_playerID2 = $map1_playerID2;
			$temp->map2_playerID1 = $map2_playerID1;
			$temp->map2_playerID2 = $map2_playerID2;
		}

		if ($bestof >= 3) {
			if ($map3_proc == 0 || $map3_proc == '') {
				$temp->map3_rate1 = $allmap_rate1;
				$temp->map3_rate2 = $allmap_rate2;
				$temp->map3_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map3_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map3_rate1 = $map3_rate1;
				$temp->map3_rate2 = $map3_rate2;
				$temp->map3_allsum_rate1 = $map3_proc;
				$temp->map3_allsum_rate2 = 100 - $map3_proc;
			}
			$temp->map3_playerID1 = $map3_playerID1;
			$temp->map3_playerID2 = $map3_playerID2;
			$temp->map3_state = 1;


			if ($outsider > 0) {
				$rate1_outsider = $marge_map/(35 * 0.01);
				$rate2_outsider = $marge_map/(65 * 0.01);
				$temp->rate1_outsider3 = number_format($rate1_outsider, 3, '.', '');
				$temp->rate2_outsider3 = number_format($rate2_outsider, 3, '.', '');
				$temp->allsum_rate1_outsider3 = 35.00; //начальная сумма на rate1 аутсайдеров
				$temp->allsum_rate2_outsider3 = 65.00; //начальная сумма на rate2 аутсайдеров
			} else {
				$temp->rate1_outsider3 = 0.000; //Записываем rate на аутсайдера, нулевые значкния
				$temp->rate2_outsider3 = 0.000;
				$temp->allsum_rate1_outsider3 = 0.00;
				$temp->allsum_rate2_outsider3 = 0.00;
			}
		}


		if ($bestof >= 4) {
			if ($map4_proc == 0 || $map4_proc == '') {
				$temp->map4_rate1 = $allmap_rate1;
				$temp->map4_rate2 = $allmap_rate2;
				$temp->map4_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map4_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map4_rate1 = $map4_rate1;
				$temp->map4_rate2 = $map4_rate2;
				$temp->map4_allsum_rate1 = $map4_proc;
				$temp->map4_allsum_rate2 = 100 - $map4_proc;
			}
			$temp->map4_playerID1 = $map4_playerID1;
			$temp->map4_playerID2 = $map4_playerID2;
			$temp->map4_state = 1;
		}

		if ($bestof >= 5) {
			if ($map5_proc == 0 || $map5_proc == '') {
				$temp->map5_rate1 = $allmap_rate1;
				$temp->map5_rate2 = $allmap_rate2;
				$temp->map5_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map5_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map5_rate1 = $map5_rate1;
				$temp->map5_rate2 = $map5_rate2;
				$temp->map5_allsum_rate1 = $map5_proc;
				$temp->map5_allsum_rate2 = 100 - $map5_proc;
			}
			$temp->map5_playerID1 = $map5_playerID1;
			$temp->map5_playerID2 = $map5_playerID2;
			$temp->map5_state = 1;

			if ($outsider > 0) {
				$rate1_outsider = $marge_map/(20 * 0.01);
				$rate2_outsider = $marge_map/(80 * 0.01);
				$temp->rate1_outsider5 = number_format($rate1_outsider, 3, '.', '');
				$temp->rate2_outsider5 = number_format($rate2_outsider, 3, '.', '');
				$temp->allsum_rate1_outsider5 = 20.00; //начальная сумма на rate1 аутсайдеров
				$temp->allsum_rate2_outsider5 = 80.00; //начальная сумма на rate2 аутсайдеров
			} else {
				$temp->rate1_outsider5 = 0.000; //Записываем rate на аутсайдера, нулевые значкния
				$temp->rate2_outsider5 = 0.000;
				$temp->allsum_rate1_outsider5 = 0.00;
				$temp->allsum_rate2_outsider5 = 0.00;
			}
		}

		if ($bestof >= 6) {
			if ($map6_proc == 0 || $map6_proc == '') {
				$temp->map6_rate1 = $allmap_rate1;
				$temp->map6_rate2 = $allmap_rate2;
				$temp->map6_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map6_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map6_rate1 = $map6_rate1;
				$temp->map6_rate2 = $map6_rate2;
				$temp->map6_allsum_rate1 = $map6_proc;
				$temp->map6_allsum_rate2 = 100 - $map6_proc;
			}
			$temp->map6_state = 1;
			$temp->map6_playerID1 = $map6_playerID1;
			$temp->map6_playerID2 = $map6_playerID2;
		}

		if ($bestof >= 7) {
			if ($map7_proc == 0 || $map7_proc == '') {
				$temp->map7_rate1 = $allmap_rate1;
				$temp->map7_rate2 = $allmap_rate2;
				$temp->map7_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map7_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map7_rate1 = $map7_rate1;
				$temp->map7_rate2 = $map7_rate2;
				$temp->map7_allsum_rate1 = $map7_proc;
				$temp->map7_allsum_rate2 = 100 - $map7_proc;
			}
			$temp->map7_state = 1;
			$temp->map7_playerID1 = $map7_playerID1;
			$temp->map7_playerID2 = $map7_playerID2;

			if ($outsider > 0) {
				$rate1_outsider = $marge_map/(15 * 0.01);
				$rate2_outsider = $marge_map/(85 * 0.01);
				$temp->rate1_outsider7 = number_format($rate1_outsider, 3, '.', '');
				$temp->rate2_outsider7 = number_format($rate2_outsider, 3, '.', '');
				$temp->allsum_rate1_outsider7 = 15.00; //начальная сумма на rate1 аутсайдеров
				$temp->allsum_rate2_outsider7 = 85.00; //начальная сумма на rate2 аутсайдеров
			} else {
				$temp->rate1_outsider7 = 0.000; //Записываем rate на аутсайдера, нулевые значкния
				$temp->rate2_outsider7 = 0.000;
				$temp->allsum_rate1_outsider7 = 0.00;
				$temp->allsum_rate2_outsider7 = 0.00;
			}
		}

		if ($bestof >= 8) {
			if ($map8_proc == 0 || $map8_proc == '') {
				$temp->map8_rate1 = $allmap_rate1;
				$temp->map8_rate2 = $allmap_rate2;
				$temp->map8_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map8_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map8_rate1 = $map8_rate1;
				$temp->map8_rate2 = $map8_rate2;
				$temp->map8_allsum_rate1 = $map8_proc;
				$temp->map8_allsum_rate2 = 100 - $map8_proc;
			}
			$temp->map8_state = 1;
			$temp->map8_playerID1 = $map8_playerID1;
			$temp->map8_playerID2 = $map8_playerID2;
		}

		if ($bestof >= 9) {
			if ($map9_proc == 0 || $map9_proc == '') {
				$temp->map9_rate1 = $allmap_rate1;
				$temp->map9_rate2 = $allmap_rate2;
				$temp->map9_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map9_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map9_rate1 = $map9_rate1;
				$temp->map9_rate2 = $map9_rate2;
				$temp->map9_allsum_rate1 = $map9_proc;
				$temp->map9_allsum_rate2 = 100 - $map9_proc;
			}
			$temp->map9_state = 1;
			$temp->map9_playerID1 = $map9_playerID1;
			$temp->map9_playerID2 = $map9_playerID2;

			if ($outsider > 0) {
				$rate1_outsider = $marge_map/(10 * 0.01);
				$rate2_outsider = $marge_map/(90 * 0.01);
				$temp->rate1_outsider9 = number_format($rate1_outsider, 3, '.', '');
				$temp->rate2_outsider9 = number_format($rate2_outsider, 3, '.', '');
				$temp->allsum_rate1_outsider9 = 10.00; //начальная сумма на rate1 аутсайдеров
				$temp->allsum_rate2_outsider9 = 90.00; //начальная сумма на rate2 аутсайдеров
			} else {
				$temp->rate1_outsider9 = 0.000; //Записываем rate на аутсайдера, нулевые значкния
				$temp->rate2_outsider9 = 0.000;
				$temp->allsum_rate1_outsider9 = 0.00;
				$temp->allsum_rate2_outsider9 = 0.00;
			}
		}

		if ($bestof >= 10) {
			if ($map10_proc == 0 || $map10_proc == '') {
				$temp->map10_rate1 = $allmap_rate1;
				$temp->map10_rate2 = $allmap_rate2;
				$temp->map10_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map10_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map10_rate1 = $map10_rate1;
				$temp->map10_rate2 = $map10_rate2;
				$temp->map10_allsum_rate1 = $map10_proc;
				$temp->map10_allsum_rate2 = 100 - $map10_proc;
			}
			$temp->map10_state = 1;
			$temp->map10_playerID1 = $map10_playerID1;
			$temp->map10_playerID2 = $map10_playerID2;
		}

		if ($bestof >= 11) {
			if ($map11_proc == 0 || $map11_proc == '') {
				$temp->map11_rate1 = $allmap_rate1;
				$temp->map11_rate2 = $allmap_rate2;
				$temp->map11_allsum_rate1 = $allmap_rate1_allsum;
				$temp->map11_allsum_rate2 = $allmap_rate2_allsum;
			} else {
				$temp->map11_rate1 = $map11_rate1;
				$temp->map11_rate2 = $map11_rate2;
				$temp->map11_allsum_rate1 = $map11_proc;
				$temp->map11_allsum_rate2 = 100 - $map11_proc;
			}
			$temp->map11_state = 1;
			$temp->map11_playerID1 = $map11_playerID1;
			$temp->map11_playerID2 = $map11_playerID2;

			if ($outsider > 0) {
				$rate1_outsider = $marge_map/(10 * 0.01);
				$rate2_outsider = $marge_map/(90 * 0.01);
				$temp->rate1_outsider11 = number_format($rate1_outsider, 3, '.', '');
				$temp->rate2_outsider11 = number_format($rate2_outsider, 3, '.', '');
				$temp->allsum_rate1_outsider11 = 10.00; //начальная сумма на rate1 аутсайдеров
				$temp->allsum_rate2_outsider11 = 90.00; //начальная сумма на rate2 аутсайдеров
			} else {
				$temp->rate1_outsider11 = 0.000; //Записываем rate на аутсайдера, нулевые значкния
				$temp->rate2_outsider11 = 0.000;
				$temp->allsum_rate1_outsider11 = 0.00;
				$temp->allsum_rate2_outsider11 = 0.00;
			}
		}


		$newmatches = DB::select()
			->from('matches')
			->where('disciplineID', '=', $disciplineID)
			->and_where('new', '=', '1')
			->limit(3)
			->order_by('id', 'DESC')
			->execute()
			->as_array();

		if (count($newmatches) == 3) {
			$i = 0;
			foreach($newmatches as $match)
			{
				$i++;
				if ($i == 3) {
					$temp2 = ORM::factory('Match',array('id'=>$match['id']));
					$temp2->new = 0;
					$temp2->save();
				}
			}
		}

		try
		{
			$temp->save();
			return $temp;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}


	public function get_match($id) //valid, -, id
	{
		return ORM::factory('Match',array('id'=>$id));
	}


	public function edit_match($id,$eventID,$datetime,$maxbet,$fullstart) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		$temp->eventID = $eventID;
		$temp->datetime = $datetime;
		$temp->maxbet = $maxbet;
		$temp->auto_start = 0;
		$temp->fullstart = $fullstart;

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function get_all_matches() //только активные и начатые матчи //valid, -, id, Оптимизирован
	{
		return ORM::factory('Match')->where("state","=",'1')->or_where("state","=",'2')->order_by('datetime', 'ASC')->find_all();
	}

	public function get_all_oldmatches() //только завершенные матчи //valid, -, id, Оптимизирован
	{
		return ORM::factory('Match')->where("state","=",'0')->order_by('closetime', 'DESC')->find_all();
	}


	public function get_all_endmatches() //5 последних заверщенных матча по каждой дисциплине, для Usertable //valid, -, id, Оптимизирован
	{
		$alldisc = ORM::factory('Discipline')->find_all();
		foreach($alldisc as $disc)
		{
			$temp[$disc->id] = ORM::factory('Match')->where("state","=",'0')->and_where("disciplineID","=",$disc->id)->order_by('closetime', 'DESC')->limit(5)->find_all();
		}

		return $temp;
	}

	public function get_all_utc() //valid, -, id
	{
		return ORM::factory('UTC')->find_all();
	}

	public function get_count_matches() //valid, -, id
	{
		$temp = ORM::factory('Match')->find_all();
		return $temp->count();
	}

	public function start_match($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->state == 1) {
			$temp->state = 2;
			$temp->new = 0;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map1($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map1_state == 1) {
			$temp->map1_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map2($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map2_state == 1) {
			$temp->map2_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map3($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map3_state == 1) {
			$temp->map3_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map4($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map4_state == 1) {
			$temp->map4_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map5($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map5_state == 1) {
			$temp->map5_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map6($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map6_state == 1) {
			$temp->map6_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map7($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map7_state == 1) {
			$temp->map7_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map8($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map8_state == 1) {
			$temp->map8_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map9($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map9_state == 1) {
			$temp->map9_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map10($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map10_state == 1) {
			$temp->map10_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function start_map11($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map11_state == 1) {
			$temp->map11_state = 2;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_match($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->state == 2) {
			$temp->state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map1($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map1_state == 2) {
			$temp->map1_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map2($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map2_state == 2) {
			$temp->map2_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map3($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map3_state == 2) {
			$temp->map3_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map4($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map4_state == 2) {
			$temp->map4_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map5($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map5_state == 2) {
			$temp->map5_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map6($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map6_state == 2) {
			$temp->map6_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map7($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map7_state == 2) {
			$temp->map7_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map8($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map8_state == 2) {
			$temp->map8_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map9($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map9_state == 2) {
			$temp->map9_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map10($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map10_state == 2) {
			$temp->map10_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}

	public function stop_map11($id) //valid, -, id
	{
		$temp = ORM::factory('Match',array('id'=>$id));
		if ($temp->map11_state == 2) {
			$temp->map11_state = 1;
			try
			{
				$temp->save();
				return TRUE;
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}
		}
		return FALSE;
	}



	public function cancel_match($id,$canceltime) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данному матчу
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					switch ($bet->typebet) {
						case 1:
						case 3:
						case 5:
						case 7:
						case 9:
						case 11:
							if ($bet->match->state != 0) { //если матч не закрыт и не отменен
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 101:  //map1
							if ($bet->match->map1_state != 3 && $bet->match->map1_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 102:  //map2
							if ($bet->match->map2_state != 3 && $bet->match->map2_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 103:  //map3
							if ($bet->match->map3_state != 3 && $bet->match->map3_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 104:  //map4
							if ($bet->match->map4_state != 3 && $bet->match->map4_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 105:  //map5
							if ($bet->match->map5_state != 3 && $bet->match->map5_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 106:  //map6
							if ($bet->match->map6_state != 3 && $bet->match->map6_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 107:  //map7
							if ($bet->match->map7_state != 3 && $bet->match->map7_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 108:  //map8
							if ($bet->match->map8_state != 3 && $bet->match->map8_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 109:  //map9
							if ($bet->match->map9_state != 3 && $bet->match->map9_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 110:  //map10
							if ($bet->match->map10_state != 3 && $bet->match->map10_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
						case 111:  //map11
							if ($bet->match->map11_state != 3 && $bet->match->map11_state != 4) { //если карта не закрыта и не отменена
								$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
								$bet->state = 2; //помечаем ставку отмененной
								$bet->user->save();
								$bet->save();
							}
							break;
					} //switch
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) {
			$match->state = 0;
			//если карта была закрыта, ее отменять не нужно
			if ($match->map1_state != 3)
				$match->map1_state = 4;
			if ($match->map2_state != 3)
				$match->map2_state = 4;
			if ($match->map3_state != 3)
				$match->map3_state = 4;
			if ($match->map4_state != 3)
				$match->map4_state = 4;
			if ($match->map5_state != 3)
				$match->map5_state = 4;
			if ($match->map6_state != 3)
				$match->map6_state = 4;
			if ($match->map7_state != 3)
				$match->map7_state = 4;
			if ($match->map8_state != 3)
				$match->map8_state = 4;
			if ($match->map9_state != 3)
				$match->map9_state = 4;
			if ($match->map10_state != 3)
				$match->map10_state = 4;
			if ($match->map11_state != 3)
				$match->map11_state = 4;

			$match->cancel_state = 1;
		}

		$match->closetime = $canceltime;

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map1($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","101")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map1_state != 3 && $bet->match->map1_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map1_state != 3)
				$match->map1_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map2($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","102")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map2_state != 3 && $bet->match->map2_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map2_state != 3)
				$match->map2_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map3($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","103")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map3_state != 3 && $bet->match->map3_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map3_state != 3)
				$match->map3_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map4($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","104")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map4_state != 3 && $bet->match->map4_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map4_state != 3)
				$match->map4_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map5($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","105")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map5_state != 3 && $bet->match->map5_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map5_state != 3)
				$match->map5_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map6($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","106")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map6_state != 3 && $bet->match->map6_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map6_state != 3)
				$match->map6_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map7($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","107")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map7_state != 3 && $bet->match->map7_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map7_state != 3)
				$match->map7_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map8($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","108")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map8_state != 3 && $bet->match->map8_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map8_state != 3)
				$match->map8_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map9($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","109")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map9_state != 3 && $bet->match->map9_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map9_state != 3)
				$match->map9_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map10($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","110")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map10_state != 3 && $bet->match->map10_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map10_state != 3)
				$match->map10_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancel_map11($id) //valid, -, id
	{
		date_default_timezone_set('UTC');

		//Выбор всех не отмененных ставок по данной карте
		$mainbets = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","111")->find_all();

		if ($mainbets->count() > 0) {
			foreach($mainbets as $bet)
			{
				$sum1 = 	$bet->sum1;
				$sum2 = 	$bet->sum2;
				$sumdraw = 	$bet->sumdraw;

				if ($bet->match->cancel_state != 1)
					if ($bet->match->map11_state != 3 && $bet->match->map11_state != 4) { //если карта не закрыта и не отменена
						$bet->user->money += $sum1+$sum2+$sumdraw; //Возврат денег пользователю
						$bet->state = 2; //помечаем ставку отмененной
						$bet->user->save();
						$bet->save();
					}
			} //foreach
		} //if

		$match = ORM::factory('Match',array('id'=>$id));

		//если карта, матч не закрыта и не отменена, их нужно отменить
		if ($match->cancel_state != 1) { //если карта была закрыта, ее отменять не нужно
			if ($match->map11_state != 3)
				$match->map11_state = 4;
		}

		try
		{
			$match->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}








	public function close_match($id,$score1,$score2,$closetime) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2 &&  $temp->draw == '0.000') {
				return FALSE;
			}

			//Если хотябы одна карта не закрыта, тогда нельзя закрыть данный матч.
			$i = 1;
			do {
				switch ($i) {
					case 2:
						if ($temp->map1_state != 3 && $temp->map1_state != 4) return FALSE;
						if ($temp->map2_state != 3 && $temp->map2_state != 4) return FALSE;
						break;
					case 3:
						if ($temp->map3_state != 3 && $temp->map3_state != 4) return FALSE;
						break;
					case 4:
						if ($temp->map4_state != 3 && $temp->map4_state != 4) return FALSE;
						break;
					case 5:
						if ($temp->map5_state != 3 && $temp->map5_state != 4) return FALSE;
						break;
					case 6:
						if ($temp->map6_state != 3 && $temp->map6_state != 4) return FALSE;
						break;
					case 7:
						if ($temp->map7_state != 3 && $temp->map7_state != 4) return FALSE;
						break;
					case 8:
						if ($temp->map8_state != 3 && $temp->map8_state != 4) return FALSE;
						break;
					case 9:
						if ($temp->map9_state != 3 && $temp->map9_state != 4) return FALSE;
						break;
					case 10:
						if ($temp->map10_state != 3 && $temp->map10_state != 4) return FALSE;
						break;
					case 11:
						if ($temp->map11_state != 3 && $temp->map11_state != 4) return FALSE;
						break;
				}
			} while ($i++ < $temp->bestof);

			$temp->state = 0;
			$temp->score1 = $score1;
			$temp->score2 = $score2;
			$temp->closetime = $closetime;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок, ставки на карты расчитываются отдельно для каждой карты в частности.
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->find_all();

			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($bet->typebet == 1) { //main bet
						if ($score1 > $score2 && $bet->sum1 > 0)
							$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

						if ($score1 < $score2 && $bet->sum2 > 0)
							$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

						if ($score1 == $score2 && $bet->sumdraw > 0)
							$bet->user->money += round($bet->ratedraw * $bet->sumdraw, 2);




					} elseif ($bet->typebet == 3) { //АУТСАЙДЕРЫ
						if ($bet->sum1 > 0) {
							//Да, игрок-аутсайдер возьмет 1 карту
							if ($bet->match->outsider == 1 && $score1 >= 1) //аутсайдер это Player1 и его итоговый счет >= 1
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2); //да
							}
							elseif ($bet->match->outsider == 2 && $score2 >= 1)  //аутсайдер это Player2 и его итоговый счет >= 1
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2); //да
							}
						}

						if ($bet->sum2 > 0)
						{
							//Нет, игрок не возьмет 1 карту.
							if ($bet->match->outsider == 1 && $score1 < 1) //аутсайдер это Player1 и его итоговый счет < 1
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2); //нет
							}
							elseif ($bet->match->outsider == 2 && $score2 < 1)  //аутсайдер это Player2 и его итоговый счет < 1
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2); //нет
							}
						}
					} elseif ($bet->typebet == 5) {
						if ($bet->sum1 > 0) {
							//Да, игрок возьмет 2 карты
							if ($bet->match->outsider == 1 && $score1 >= 2) //аутсайдер это Player1 и его итоговый счет >= 2
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 >= 2)  //аутсайдер это Player2 и его итоговый счет >= 2
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
						}
						if ($bet->sum2 > 0)
						{
							//Нет, игрок не возьмет 2 карты.
							if ($bet->match->outsider == 1 && $score1 < 2) //аутсайдер это Player1 и его итоговый счет < 2
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 < 2)  //аутсайдер это Player2 и его итоговый счет < 2
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
						}
					} elseif ($bet->typebet == 7) {
						if ($bet->sum1 > 0) {
							//Да, игрок возьмет 3 карты
							if ($bet->match->outsider == 1 && $score1 >= 3) //аутсайдер это Player1 и его итоговый счет >= 3
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 >= 3)  //аутсайдер это Player2 и его итоговый счет >= 3
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
						}
						if ($bet->sum2 > 0)
						{
							//Нет, игрок не возьмет 3 карты.
							if ($bet->match->outsider == 1 && $score1 < 3) //аутсайдер это Player1 и его итоговый счет < 3
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 < 3)  //аутсайдер это Player2 и его итоговый счет < 3
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
						}
					} elseif ($bet->typebet == 9) {
						if ($bet->sum1 > 0) {
							//Да, игрок возьмет 4 карты
							if ($bet->match->outsider == 1 && $score1 >= 4) //аутсайдер это Player1 и его итоговый счет >= 4
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 >= 4)  //аутсайдер это Player2 и его итоговый счет >= 4
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
						}
						if ($bet->sum2 > 0)
						{
							//Нет, игрок не возьмент 4 карты.
							if ($bet->match->outsider == 1 && $score1 < 4) //аутсайдер это Player1 и его итоговый счет < 4
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 < 4)  //аутсайдер это Player2 и его итоговый счет < 4
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
						}
					} elseif ($bet->typebet == 11) {
						if ($bet->sum1 > 0) {
							//Да, игрок возьмет 5 карт
							if ($bet->match->outsider == 1 && $score1 >= 5) //аутсайдер это Player1 и его итоговый счет >= 5
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 >= 5)  //аутсайдер это Player2 и его итоговый счет >= 5
							{
								$bet->user->money += round($bet->rate1 * $bet->sum1, 2);
							}
						}
						if ($bet->sum2 > 0)
						{
							//Нет, игрок не возьмент 5 карт.
							if ($bet->match->outsider == 1 && $score1 < 5) //аутсайдер это Player1 и его итоговый счет < 5
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
							elseif ($bet->match->outsider == 2 && $score2 < 5)  //аутсайдер это Player2 и его итоговый счет < 5
							{
								$bet->user->money += round($bet->rate2 * $bet->sum2, 2);
							}
						}
					}

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map1($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map1_state = 3;
			$temp->map1_score1 = $score1;
			$temp->map1_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","101")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map2($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map2_state = 3;
			$temp->map2_score1 = $score1;
			$temp->map2_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","102")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map3($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map3_state = 3;
			$temp->map3_score1 = $score1;
			$temp->map3_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","103")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map4($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map4_state = 3;
			$temp->map4_score1 = $score1;
			$temp->map4_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","104")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map5($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map5_state = 3;
			$temp->map5_score1 = $score1;
			$temp->map5_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","105")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map6($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map6_state = 3;
			$temp->map6_score1 = $score1;
			$temp->map6_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","106")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map7($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map7_state = 3;
			$temp->map7_score1 = $score1;
			$temp->map7_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","107")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map8($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map8_state = 3;
			$temp->map8_score1 = $score1;
			$temp->map8_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","108")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map9($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map9_state = 3;
			$temp->map9_score1 = $score1;
			$temp->map9_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","109")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map10($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map10_state = 3;
			$temp->map10_score1 = $score1;
			$temp->map10_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","110")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}

	public function close_map11($id,$score1,$score2) //valid, -, id
	{
		date_default_timezone_set('UTC');
		if ($score1!='' && $score2!='' && Valid::digit($score1) && Valid::digit($score2) && Valid::max_length($score1, 2) && Valid::max_length($score2, 2)) {

			$temp = ORM::factory('Match',array('id'=>$id));

			if ($score1 == $score2) { //счет на карте не может быть ничейным.
				return FALSE;
			}

			$temp->map11_state = 3;
			$temp->map11_score1 = $score1;
			$temp->map11_score2 = $score2;

			try
			{
				$temp->save();
			} catch (ORM_Validation_Exception $e) {
				$this->errors = $e->errors('validation');
				return FALSE;
			}

			//Расчет ставок
			$mainbet = ORM::factory('Mainbet')->where("matchID","=",$id)->and_where("state","!=","2")->and_where("typebet","=","111")->find_all();
			if ($mainbet->count() > 0) {
				foreach($mainbet as $bet)
				{
					if ($score1 > $score2 && $bet->sum1 > 0)
						$bet->user->money += round($bet->rate1 * $bet->sum1, 2);

					if ($score1 < $score2 && $bet->sum2 > 0)
						$bet->user->money += round($bet->rate2 * $bet->sum2, 2);

					//для акции 10+1
					if ($bet->user->freemoney > 0) $bet->user->freemoney -= 0.5;

					try
					{
						$bet->user->save();
					} catch (ORM_Validation_Exception $e) {
						$this->errors = $e->errors('validation');
						return FALSE; //вызывается эта хуйня
					}
				}
			}
			return TRUE;
		}
		return FALSE;
	}


	public function add_log($state,$matchID,$notify = NULL,$title_notify = NULL) //valid, -, id
	{
		date_default_timezone_set('UTC');
		$temp = new Model_Log();
		$temp->matchID = $matchID;
		$temp->state = $state;
		$temp->createdate = time();
		$temp->notify = $notify;
		$temp->title_notify = $title_notify;
		$temp->save();
		return $temp;
		//1 - active(stop) match, 2-start match, 0 - close match, 9 - edit, 7 - new bet, 6 - cancel bet, 3 - cancel match
		//11 - active(stop) map1, 21 - start map1, 31 - close map1, 41 - cancel map1
	}


	public function update_utc($post,$user_id) //valid, -, id
	{

		$temp = ORM::factory('Muser',array('id'=>$user_id));
		$temp->utc = $post;
		$temp->save();

		return TRUE;
	}

	public function update_genhash($user_id) //valid, -, id
	{
		$useful = new Model_Useful();
		$genhash = $useful->generatePassword(18);

		$temp = ORM::factory('Muser',array('id'=>$user_id));
		$temp->genhash = $genhash;
		$temp->save();


		// Отправка электройнной почты

		$data = array();
		$subject = 'Confirmation email on the clanbets.com';
		$data = array('genhash' => $genhash);
		$message = View::factory('email/verifymail',$data);
		$from = array('noreply@clanbets.com' => 'Clanbets.com confirmation');
		$email = $temp->email;

		if ($useful->sendmail($email,$subject,$message,$from))
			return TRUE;
		else
			return FALSE;
	}

	public function check_currentpassword($user_id, $post) //valid, -, id
	{
		$auth = Auth::instance();
		$temp = ORM::factory('Muser',array('id'=>$user_id));
		$post = $auth->hash_password($post);

		if ($temp->password == $post)
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function change_password($current_password,$password,$password2) //valid, -, id
	{
		$auth = Auth::instance();

		if($auth->logged_in())
		{
			$user_id = $auth->get_user();
			$user = ORM::factory('Muser',array('id'=>$user_id));


			if (isset($current_password) &&  $user->password == $auth->hash_password($current_password) && Valid::min_length($password, 5) && Valid::max_length($password, 254) && $password == $password2) {

				$user->password = $auth->hash_password($password);

				try {
					$user->save();
					return TRUE;
				} catch (ORM_Validation_Exception $e) {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function make_deposit($sum_deposit, $check_promo) //valid, -, id
	{
		$auth = Auth::instance();
		date_default_timezone_set('UTC');
		if($auth->logged_in())
		{
			$user_id = $auth->get_user();
			//valid sum
			if (Valid::max_length($sum_deposit, 12) &&  Valid::min_length($sum_deposit, 1) && $sum_deposit > 0 && preg_match('/^\d+.\d{2}$/', $sum_deposit)) {

				$freemoney = 0;
				if (isset($check_promo) && $check_promo == '1') {
					$freemoney = intval($sum_deposit/10);
				}

				$temp = new Model_Transaction();
				$temp->user = $user_id;
				$temp->sumIN = $sum_deposit;
				$temp->timecreate = time();
				$temp->state = 4;
				$temp->freemoney = $freemoney;

				try
				{
					$temp->save();
					return $temp;
				} catch (ORM_Validation_Exception $e) {
					$this->errors = $e->errors('validation');
					return FALSE;
				}
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}


	public function add_bet($id,$user_id,$rate1,$rate2,$ratedraw,$sum1,$sum2,$draw,$newmaxbet,$typebet) //valid, -, id
	{
		$match = ORM::factory('Match',array('id'=>$id));

		//Создание новой ставки
		$temp = new Model_Mainbet();
		$temp->userID = $user_id;
		$temp->matchID = $id;
		$temp->rate1 = $rate1; //это все валидируется в mainbets.php
		$temp->rate2 = $rate2;

		$temp->sum1 = $sum1;
		$temp->sum2 = $sum2;
		$temp->sumdraw = $draw;
		$temp->typebet = $typebet;

		$dop_sum1 = 0.00;
		$dop_sum2 = 0.00;
		$dop_draw = 0.00;

		$new_rate1 = 0.000;
		$new_rate2 = 0.000;
		$new_drawrate = 0.000;

		//пересчет коэффициентов
		if ($typebet == 1) {
			$marge = $match->marge;
			$allsum_rate1 = $match->allsum_rate1;
			$allsum_rate2 = $match->allsum_rate2;
			$allsum_draw = $match->allsum_draw;

			if ($ratedraw != '0.000') {
				$allsum_rate1 += $sum1;
				$allsum_rate2 += $sum2;
				$allsum_draw += $draw;
				$allall_sum = $allsum_rate1 + $allsum_rate2 + $allsum_draw;

				//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.

				$proc10 = $allall_sum * 0.10;

				if ($allsum_rate1 < $proc10) {
					$dop_sum1 = $proc10 - $allsum_rate1;
					$allsum_rate1 = $proc10;
				}
				if ($allsum_rate2 < $proc10) {
					$dop_sum2 = $proc10 - $allsum_rate2;
					$allsum_rate2 = $proc10;
				}
				if ($allsum_draw < $proc10) {
					$dop_draw = $proc10 - $allsum_draw;
					$allsum_draw = $proc10;
				}
				$allall_sum = $allsum_rate1 + $allsum_rate2 + $allsum_draw;


				$new_rate1 = $marge/($allsum_rate1/$allall_sum);
				$new_rate2 = $marge/($allsum_rate2/$allall_sum);
				$new_drawrate = $marge/($allsum_draw/$allall_sum);
				$match->rate1 = number_format($new_rate1, 3, '.', '');
				$match->rate2 = number_format($new_rate2, 3, '.', '');
				$match->draw = number_format($new_drawrate, 3, '.', '');

				$match->allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
				$match->allsum_rate2 = number_format($allsum_rate2, 2, '.', '');
				$match->allsum_draw = number_format($allsum_draw, 2, '.', '');

			} else {
				$allsum_rate1 += $sum1;
				$allsum_rate2 += $sum2;
				$allall_sum = $allsum_rate1 + $allsum_rate2;

				//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;


				if ($allsum_rate1 < $proc10) {
					$dop_sum1 = $proc10 - $allsum_rate1;
					$allsum_rate1 = $proc10;
				}
				if ($allsum_rate2 < $proc10) {
					$dop_sum2 = $proc10 - $allsum_rate2;
					$allsum_rate2 = $proc10;
				}
				$allall_sum = $allsum_rate1 + $allsum_rate2;

				$new_rate1 = $marge/($allsum_rate1/$allall_sum);
				$new_rate2 = $marge/($allsum_rate2/$allall_sum);

				$match->rate1 = number_format($new_rate1, 3, '.', '');
				$match->rate2 = number_format($new_rate2, 3, '.', '');

				$match->allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
				$match->allsum_rate2 = number_format($allsum_rate2, 2, '.', '');
			}
		} elseif ($typebet == 3) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->allsum_rate1_outsider3;
			$allsum_rate2 = $match->allsum_rate2_outsider3;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->rate1_outsider3 = number_format($new_rate1, 3, '.', '');
			$match->rate2_outsider3 = number_format($new_rate2, 3, '.', '');

			$match->allsum_rate1_outsider3 = number_format($allsum_rate1, 2, '.', '');
			$match->allsum_rate2_outsider3 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 5) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->allsum_rate1_outsider5;
			$allsum_rate2 = $match->allsum_rate2_outsider5;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;


			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->rate1_outsider5 = number_format($new_rate1, 3, '.', '');
			$match->rate2_outsider5 = number_format($new_rate2, 3, '.', '');

			$match->allsum_rate1_outsider5 = number_format($allsum_rate1, 2, '.', '');
			$match->allsum_rate2_outsider5 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 7) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->allsum_rate1_outsider7;
			$allsum_rate2 = $match->allsum_rate2_outsider7;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;


			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->rate1_outsider7 = number_format($new_rate1, 3, '.', '');
			$match->rate2_outsider7 = number_format($new_rate2, 3, '.', '');

			$match->allsum_rate1_outsider7 = number_format($allsum_rate1, 2, '.', '');
			$match->allsum_rate2_outsider7 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 9) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->allsum_rate1_outsider9;
			$allsum_rate2 = $match->allsum_rate2_outsider9;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;


			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->rate1_outsider9 = number_format($new_rate1, 3, '.', '');
			$match->rate2_outsider9 = number_format($new_rate2, 3, '.', '');

			$match->allsum_rate1_outsider9 = number_format($allsum_rate1, 2, '.', '');
			$match->allsum_rate2_outsider9 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 11) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->allsum_rate1_outsider11;
			$allsum_rate2 = $match->allsum_rate2_outsider11;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;


			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->rate1_outsider11 = number_format($new_rate1, 3, '.', '');
			$match->rate2_outsider11 = number_format($new_rate2, 3, '.', '');

			$match->allsum_rate1_outsider11 = number_format($allsum_rate1, 2, '.', '');
			$match->allsum_rate2_outsider11 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 101) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map1_allsum_rate1;
			$allsum_rate2 = $match->map1_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map1_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map1_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map1_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map1_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 102) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map2_allsum_rate1;
			$allsum_rate2 = $match->map2_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map2_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map2_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map2_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map2_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 103) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map3_allsum_rate1;
			$allsum_rate2 = $match->map3_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map3_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map3_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map3_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map3_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 104) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map4_allsum_rate1;
			$allsum_rate2 = $match->map4_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map4_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map4_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map4_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map4_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 105) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map5_allsum_rate1;
			$allsum_rate2 = $match->map5_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map5_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map5_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map5_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map5_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 106) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map6_allsum_rate1;
			$allsum_rate2 = $match->map6_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map6_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map6_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map6_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map6_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 107) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map7_allsum_rate1;
			$allsum_rate2 = $match->map7_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map7_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map7_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map7_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map7_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 108) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map8_allsum_rate1;
			$allsum_rate2 = $match->map8_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map8_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map8_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map8_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map8_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 109) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map9_allsum_rate1;
			$allsum_rate2 = $match->map9_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map9_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map9_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map9_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map9_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 110) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map10_allsum_rate1;
			$allsum_rate2 = $match->map10_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map10_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map10_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map10_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map10_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;

		} elseif ($typebet == 111) {

			$marge = $match->marge_map;
			$allsum_rate1 = $match->map11_allsum_rate1;
			$allsum_rate2 = $match->map11_allsum_rate2;

			$allsum_rate1 += $sum1;
			$allsum_rate2 += $sum2;
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			//расчет, чтобы rate не падал меньше 10% от общей суммы ставки.
				$proc10 = $allall_sum * 0.10;

			if ($allsum_rate1 < $proc10) {
				$dop_sum1 = $proc10 - $allsum_rate1;
				$allsum_rate1 = $proc10;
			}
			if ($allsum_rate2 < $proc10) {
				$dop_sum2 = $proc10 - $allsum_rate2;
				$allsum_rate2 = $proc10;
			}
			$allall_sum = $allsum_rate1 + $allsum_rate2;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);

			$match->map11_rate1 = number_format($new_rate1, 3, '.', '');
			$match->map11_rate2 = number_format($new_rate2, 3, '.', '');

			$match->map11_allsum_rate1 = number_format($allsum_rate1, 2, '.', '');
			$match->map11_allsum_rate2 = number_format($allsum_rate2, 2, '.', '');

			$ratedraw = 0.000;
		}

		//сохранение разницы, если она есть.
		$temp->ratedraw = $ratedraw;
		$temp->dop_sum1 = $dop_sum1;
		$temp->dop_sum2 = $dop_sum2;
		$temp->dop_draw = $dop_draw;

		//Вычет денег у пользователя
		$user = ORM::factory('Muser',array('id'=>$user_id));
		$user->money -= $sum1+$sum2+$draw;

		//получаем maxbet текущего пользователя для данного матча или создаем новый
		$usermaxbet = ORM::factory('Usersmaxbet')->where("userID","=",$user_id)->and_where("matchID","=",$id)->find();

		try
		{
			$match->save(); //пересчет коэффициентов и общих сумм матча
			$temp->save();  //новая ставка
			$user->save(); //вычет денег у пользователя

			//cохранение нового maxbet
			if ($usermaxbet->loaded()) {
				$usermaxbet->maxbet = $newmaxbet;
				$usermaxbet->save();
			} else {
				$mxbet = new Model_Usersmaxbet();
				$mxbet->userID = $user_id;
				$mxbet->matchID = $id;
				$mxbet->maxbet = $newmaxbet;
				$mxbet->save();
			}
			$new_rate1 = number_format($new_rate1, 3, '.', '');
			$new_rate2 = number_format($new_rate2, 3, '.', '');
			$new_drawrate = number_format($new_drawrate, 3, '.', '');

			$ret = array('true'=>1, 'rate1'=>$new_rate1, 'rate2'=>$new_rate2, 'ratedraw'=>$new_drawrate, 'maxbet'=>$newmaxbet);
			return $ret;
		} catch (ORM_Validation_Exception $e) {
			// $this->errors = $e->errors('validation');
			return FALSE;
		}

	}


	public function get_all_users() //valid, -, id
	{
		return ORM::factory('Muser')->find_all();
	}

	public function get_all_mainbets() //valid, -, id
	{
		return ORM::factory('Mainbet')->find_all();
	}

	public function get_all_mainbets_state1() //valid, -, id
	{
		return ORM::factory('Mainbet')->where("state","=","1")->find_all();
	}

	public function get_user_mainbets($userID) //user valid, -, id, все ставки пользователя 1-11, 3-11
	{
		return ORM::factory('Mainbet')->where("userID","=",$userID)->order_by('id', 'DESC')->find_all();
	}

	public function get_user_mainbets_activemap($userID) //user valid, -, id, все ставки пользователя map1-11. Оптимизирован
	{
		$typebets = array(1,101,102,103,104,105,106,107,108,109,110,111);
		return ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("typebet","in",$typebets)->order_by('id', 'DESC')->find_all();
	}

	public function get_user_mainbets_activemap_not2($userID) //user valid, -, id, все ставки пользователя map1-11, активные. Оптимизирован
	{
		$typebets = array(1,101,102,103,104,105,106,107,108,109,110,111);
		return ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("typebet","in",$typebets)->and_where("state","!=","2")->order_by('id', 'DESC')->find_all();
	}

	public function get_user_mainbets_outsiders($userID) //mroom valid, -, id, все ставки на аутсайдеров. Оптимизирован
	{
		$typebets = array(3,5,7,9,11);
		return ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("typebet","in",$typebets)->order_by('id', 'DESC')->find_all();
	}

	public function get_user_mainbets_outsiders_not2($userID) //mroom valid, -, id, все не отмененные ставки на аутсайдеров. Оптимизирован
	{
		$typebets = array(3,5,7,9,11);
		return ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("typebet","in",$typebets)->and_where("state","!=","2")->order_by('id', 'DESC')->find_all();
	}

	public function get_betsuser_for_match($userID, $matchID)  //valid, -, id используется для вывода сумм ставок в usertable, userwindow
	{
		return ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("matchID","=",$matchID)->find_all();
	}

	public function get_all_transactions() //valid, -, id
	{
		return ORM::factory('Transaction')->find_all();
	}

	public function get_user($userID) //valid, -, id
	{
		return ORM::factory('Muser',array('id'=>$userID));
	}

	public function cancelbet_YES($id) //valid, -, id
	{
		$mainbet = ORM::factory('Mainbet',array('id'=>$id));

		if ($mainbet->state == 2) { //состояние ставки = Отменена, прервать функцию
			return FALSE;
		}

		switch ($mainbet->typebet) {
			case 1:
			case 3:
			case 5:
			case 7:
			case 9:
			case 11:
				if ($mainbet->match->state != 1) return FALSE; break;
			case 101:
				if ($mainbet->match->map1_state != 1) return FALSE; break;
			case 102:
				if ($mainbet->match->map2_state != 1) return FALSE; break;
			case 103:
				if ($mainbet->match->map3_state != 1) return FALSE; break;
			case 104:
				if ($mainbet->match->map4_state != 1) return FALSE; break;
			case 105:
				if ($mainbet->match->map5_state != 1) return FALSE; break;
			case 106:
				if ($mainbet->match->map6_state != 1) return FALSE; break;
			case 107:
				if ($mainbet->match->map7_state != 1) return FALSE; break;
			case 108:
				if ($mainbet->match->map8_state != 1) return FALSE; break;
			case 109:
				if ($mainbet->match->map9_state != 1) return FALSE; break;
			case 110:
				if ($mainbet->match->map10_state != 1) return FALSE; break;
			case 111:
				if ($mainbet->match->map11_state != 1) return FALSE; break;
		}


		$userID = 	$mainbet->userID;
		$matchID = 	$mainbet->matchID;
		$rate1 = 	$mainbet->rate1;
		$rate2 = 	$mainbet->rate2;
		$ratedraw = 	$mainbet->ratedraw;
		$sum1 = 	$mainbet->sum1;
		$sum2 = 	$mainbet->sum2;
		$sumdraw = 	$mainbet->sumdraw;
		$dop_sum1 = 	$mainbet->dop_sum1;
		$dop_sum2 = 	$mainbet->dop_sum2;
		$dop_draw = 	$mainbet->dop_draw;

		$marge = 	$mainbet->match->marge;
		$marge_map = $mainbet->match->marge_map;
		$allsum_draw = 0.00;

		//В зависимости от typebet выбрать нужные данные из таблицы матча.
		switch ($mainbet->typebet) {
			case 1: //main bet
				$allsum_rate1 = 	$mainbet->match->allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->allsum_rate2;
				$allsum_draw =  	$mainbet->match->allsum_draw;
				break;
			case 3: //outsider 3
				$allsum_rate1 = 	$mainbet->match->allsum_rate1_outsider3;
				$allsum_rate2 = 	$mainbet->match->allsum_rate2_outsider3;
				break;
			case 5:  //outsider 5
				$allsum_rate1 = 	$mainbet->match->allsum_rate1_outsider5;
				$allsum_rate2 = 	$mainbet->match->allsum_rate2_outsider5;
				break;
			case 7:  //outsider 7
				$allsum_rate1 = 	$mainbet->match->allsum_rate1_outsider7;
				$allsum_rate2 = 	$mainbet->match->allsum_rate2_outsider7;
				break;
			case 9:  //outsider 9
				$allsum_rate1 = 	$mainbet->match->allsum_rate1_outsider9;
				$allsum_rate2 = 	$mainbet->match->allsum_rate2_outsider9;
				break;
			case 11:  //outsider 11
				$allsum_rate1 = 	$mainbet->match->allsum_rate1_outsider11;
				$allsum_rate2 = 	$mainbet->match->allsum_rate2_outsider11;
				break;
			case 101:  //map1
				$allsum_rate1 = 	$mainbet->match->map1_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map1_allsum_rate2;
				break;
			case 102:  //map2
				$allsum_rate1 = 	$mainbet->match->map2_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map2_allsum_rate2;
				break;
			case 103:  //map3
				$allsum_rate1 = 	$mainbet->match->map3_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map3_allsum_rate2;
				break;
			case 104:  //map4
				$allsum_rate1 = 	$mainbet->match->map4_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map4_allsum_rate2;
				break;
			case 105:  //map5
				$allsum_rate1 = 	$mainbet->match->map5_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map5_allsum_rate2;
				break;
			case 106:  //map6
				$allsum_rate1 = 	$mainbet->match->map6_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map6_allsum_rate2;
				break;
			case 107:  //map7
				$allsum_rate1 = 	$mainbet->match->map7_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map7_allsum_rate2;
				break;
			case 108:  //map8
				$allsum_rate1 = 	$mainbet->match->map8_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map8_allsum_rate2;
				break;
			case 109:  //map9
				$allsum_rate1 = 	$mainbet->match->map9_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map9_allsum_rate2;
				break;
			case 110:  //map10
				$allsum_rate1 = 	$mainbet->match->map10_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map10_allsum_rate2;
				break;
			case 111:  //map11
				$allsum_rate1 = 	$mainbet->match->map11_allsum_rate1;
				$allsum_rate2 = 	$mainbet->match->map11_allsum_rate2;
				break;
		}

		$allsum_rate1 -= $dop_sum1;
		$allsum_rate2 -= $dop_sum2;
		$allsum_draw -= $dop_draw;

		if ($ratedraw != '0.000' && $mainbet->typebet == 1) { //Возможно только для main bet
			$allsum_rate1 -= $sum1;
			$allsum_rate2 -= $sum2;
			$allsum_draw -= $sumdraw;
			$allall_sum = $allsum_rate1 + $allsum_rate2 + $allsum_draw;

			$new_rate1 = $marge/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge/($allsum_rate2/$allall_sum);
			$new_drawrate = $marge/($allsum_draw/$allall_sum);

			$mainbet->match->rate1 = number_format($new_rate1, 3, '.', '');
			$mainbet->match->rate2 = number_format($new_rate2, 3, '.', '');
			$mainbet->match->draw = number_format($new_drawrate, 3, '.', '');
			$mainbet->match->allsum_rate1 = $allsum_rate1;
			$mainbet->match->allsum_rate2 = $allsum_rate2;
			$mainbet->match->allsum_draw = $allsum_draw;
		} else {
			$allsum_rate1 -= $sum1;
			$allsum_rate2 -= $sum2;
			$allsum_draw -= $sumdraw;
			$allall_sum = $allsum_rate1 + $allsum_rate2 + $allsum_draw;
			$new_rate1 = $marge_map/($allsum_rate1/$allall_sum);
			$new_rate2 = $marge_map/($allsum_rate2/$allall_sum);
			//В зависимости от typebet записываем новые коэффициенты для отдельных исходов матча.
			switch ($mainbet->typebet) {
				case 1: //main bet
					$new_rate1 = 				$marge/($allsum_rate1/$allall_sum); //Для главной ставки используется marge
					$new_rate2 = 				$marge/($allsum_rate2/$allall_sum);
					$mainbet->match->rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->rate2 =		number_format($new_rate2, 3, '.', '');
					$mainbet->match->allsum_rate1 = 	$allsum_rate1;
					$mainbet->match->allsum_rate2 = 	$allsum_rate2;
					break;
				case 3: //outsider 3
					$mainbet->match->rate1_outsider3 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->rate2_outsider3 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->allsum_rate1_outsider3 = 	$allsum_rate1;
					$mainbet->match->allsum_rate2_outsider3 = 	$allsum_rate2;
					break;
				case 5:  //outsider 5
					$mainbet->match->rate1_outsider5 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->rate2_outsider5 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->allsum_rate1_outsider5 = 	$allsum_rate1;
					$mainbet->match->allsum_rate2_outsider5 = 	$allsum_rate2;
					break;
				case 7:  //outsider 7
					$mainbet->match->rate1_outsider7 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->rate2_outsider7 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->allsum_rate1_outsider7 = 	$allsum_rate1;
					$mainbet->match->allsum_rate2_outsider7 = 	$allsum_rate2;
					break;
				case 9:  //outsider 9
					$mainbet->match->rate1_outsider9 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->rate2_outsider9 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->allsum_rate1_outsider9 = 	$allsum_rate1;
					$mainbet->match->allsum_rate2_outsider9 = 	$allsum_rate2;
					break;
				case 11:  //outsider 11
					$mainbet->match->rate1_outsider11 = 	number_format($new_rate1, 3, '.', '');
					$mainbet->match->rate2_outsider11 = 	number_format($new_rate2, 3, '.', '');
					$mainbet->match->allsum_rate1_outsider11 =	$allsum_rate1;
					$mainbet->match->allsum_rate2_outsider11 =	$allsum_rate2;
					break;
				case 101:  //map1
					$mainbet->match->map1_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map1_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map1_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map1_allsum_rate2 =	$allsum_rate2;
					break;
				case 102:  //map2
					$mainbet->match->map2_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map2_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map2_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map2_allsum_rate2 =	$allsum_rate2;
					break;
				case 103:  //map3
					$mainbet->match->map3_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map3_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map3_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map3_allsum_rate2 =	$allsum_rate2;
					break;
				case 104:  //map4
					$mainbet->match->map4_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map4_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map4_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map4_allsum_rate2 =	$allsum_rate2;
					break;
				case 105:  //map5
					$mainbet->match->map5_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map5_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map5_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map5_allsum_rate2 =	$allsum_rate2;
					break;
				case 106:  //map6
					$mainbet->match->map6_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map6_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map6_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map6_allsum_rate2 =	$allsum_rate2;
					break;
				case 107:  //map7
					$mainbet->match->map7_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map7_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map7_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map7_allsum_rate2 =	$allsum_rate2;
					break;
				case 108:  //map8
					$mainbet->match->map8_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map8_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map8_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map8_allsum_rate2 =	$allsum_rate2;
					break;
				case 109:  //map9
					$mainbet->match->map9_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map9_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map9_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map9_allsum_rate2 =	$allsum_rate2;
					break;
				case 110:  //map10
					$mainbet->match->map10_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map10_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map10_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map10_allsum_rate2 =	$allsum_rate2;
					break;
				case 111:  //map11
					$mainbet->match->map11_rate1 = 		number_format($new_rate1, 3, '.', '');
					$mainbet->match->map11_rate2 = 		number_format($new_rate2, 3, '.', '');
					$mainbet->match->map11_allsum_rate1 =	$allsum_rate1;
					$mainbet->match->map11_allsum_rate2 =	$allsum_rate2;
					break;
			}
		}

		//Возврат денег пользователю
		$mainbet->user->money += $sum1+$sum2+$sumdraw;
		//Возврат maxbet пользователю
		$usermaxbet = ORM::factory('Usersmaxbet')->where("userID","=",$userID)->and_where("matchID","=",$matchID)->find();
		if ($usermaxbet->loaded()) {
			$usermaxbet->maxbet += $sum1+$sum2+$sumdraw;
			$usermaxbet->save();
		}
		//Изменение статуса ставки - отмененная
		$mainbet->state = 2;

		try
		{
			$mainbet->match->save();
			$mainbet->user->save();
			$mainbet->save();

			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			// $this->errors = $e->errors('validation');
			return FALSE;
		}
	}

	public function cancelbet_NO($id) //valid, -, id
	{
		$mainbet = ORM::factory('Mainbet',array('id'=>$id));

		if ($mainbet->state == 2) {
			return FALSE;
		}

		switch ($mainbet->typebet) {
			case 1:
			case 3:
			case 5:
			case 7:
			case 9:
			case 11:
				if ($mainbet->match->state != 1) return FALSE; break;
			case 101:
				if ($mainbet->match->map1_state != 1) return FALSE; break;
			case 102:
				if ($mainbet->match->map2_state != 1) return FALSE; break;
			case 103:
				if ($mainbet->match->map3_state != 1) return FALSE; break;
			case 104:
				if ($mainbet->match->map4_state != 1) return FALSE; break;
			case 105:
				if ($mainbet->match->map5_state != 1) return FALSE; break;
			case 106:
				if ($mainbet->match->map6_state != 1) return FALSE; break;
			case 107:
				if ($mainbet->match->map7_state != 1) return FALSE; break;
			case 108:
				if ($mainbet->match->map8_state != 1) return FALSE; break;
			case 109:
				if ($mainbet->match->map9_state != 1) return FALSE; break;
			case 110:
				if ($mainbet->match->map10_state != 1) return FALSE; break;
			case 111:
				if ($mainbet->match->map11_state != 1) return FALSE; break;
		}


		//Изменение статуса ставки - НЕ отмененная, ставка остается
		$mainbet->state = 3;

		try
		{
			$mainbet->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			// $this->errors = $e->errors('validation');
			return FALSE;
		}
		//0 - active, 1 - request cencel, 2 - cancelled (отмененная ставка), 3 - no cancelled (не отмененная)
	}


	public function get_all_psystem() //valid, -, id
	{
		return ORM::factory('Psystem')->find_all();
	}


	public function get_usermoney($id) //valid, -, id
	{
		$user = ORM::factory('Muser',array('id'=>$id));
		return $user->money;
	}

	public function get_userfreemoney($id) //valid, -, id
	{
		$user = ORM::factory('Muser',array('id'=>$id));
		return $user->freemoney;
	}

	public function go_cashout($psystem, $ewallet_number, $sum_withdraw, $state_comm) //valid, -, id
	{
		$auth = Auth::instance();
		date_default_timezone_set('UTC');

		if($auth->logged_in())
		{
			$user_id = $auth->get_user();
			$user = ORM::factory('Muser',array('id'=>$user_id));

			if (Valid::max_length($psystem, 20) && Valid::alpha($psystem)) {
				$psystemID = ORM::factory('Psystem')->where("value","=",$psystem)->find();
				if ($psystemID->loaded()) {

					if ($state_comm == 1) {
						$sum_withdraw += $sum_withdraw * 0.04;
						$sum_withdraw = number_format($sum_withdraw, 2, '.', '');
					}

					if (Valid::max_length($sum_withdraw, 15) &&
					Valid::min_length($sum_withdraw, 1) &&
					$sum_withdraw >= 15 &&
					$sum_withdraw <= $user->money &&
					preg_match('/^\d+.\d{2}$/', $sum_withdraw) &&
					Valid::max_length($ewallet_number, 100) &&
					(Valid::alpha_numeric($ewallet_number) || Valid::email($ewallet_number)) &&
					$user->freemoney == 0
					) {
						$transact = new Model_Transaction();
						$transact->userID = $user_id;
						$transact->sumOUT = $sum_withdraw;
						$transact->timecreate = time();
						$transact->state = 1;  //1 - active cashout
						$user->money = $user->money - $sum_withdraw;
						$cashout = new Model_Usercashout();
						$cashout->psystemID = $psystemID->id;
						$cashout->ewallet_number = $ewallet_number;
						$cashout->sum_withdraw = $sum_withdraw;
						if ($state_comm == 1)
							$cashout->percent4 = 1;

						try
						{
							$transactID = $transact->save();
							$user->save();
						 	$cashout->transactionID = $transactID->id;
							$cashoutID =$cashout->save();
							$transactID->UsercashoutID = $cashoutID;
							$transactID->save();

							return TRUE;
						} catch (ORM_Validation_Exception $e) {
							$this->errors = $e->errors('validation');
							return FALSE;
						}
					} else {
						return FALSE;
					}

				} else {return FALSE;} //load psystem
			} else {return FALSE;} //psystem valid
		} else {
			return FALSE; //login user
		}
	}

	public function get_user_transaction($userID) //mroom //valid, -, id
	{
		return ORM::factory('Transaction')->where("userID","=",$userID)->order_by('id', 'DESC')->find_all();
// transactions 		1 - active cashout, 	2 - canceled cashout	3- Performed cashout 	4 - sum in waiting  	5 - sum in Success	6 - sum in failure
	}

	public function get_user_deposits_success($userID) //mroom //valid, -, id, Для файла User.php
	{
		return ORM::factory('Transaction')->where("userID","=",$userID)->and_where("state",">","3")->order_by('id', 'DESC')->find_all(); //SUM IN
// transactions 		1 - active cashout, 	2 - canceled cashout	3- Performed cashout 	4 - sum in waiting  	5 - sum in Success	6 - sum in failure
	}


	public function get_user_cashouts($userID) //mroom //valid, -, id, Оптимизирован
	{
		return ORM::factory('Transaction')->where("userID","=",$userID)->and_where("state","<=","3")->order_by('id', 'DESC')->find_all(); //Все кроме sum in
// transactions 		1 - active cashout, 	2 - canceled cashout	3- Performed cashout 	4 - sum in waiting  	5 - sum in Success	6 - sum in failure
	}


	public function close_transactionOUT($id) //valid, -, id Отмена вывода денег
	{
		$transact = ORM::factory('Transaction',array('id'=>$id));
		//Возврат денег пользователю
		$transact->user->money += $transact->sumOUT;
		//Cashout отмена.
		$transact->state = 2; //Вывод денег отменен
		try
		{
			$transact->user->save();
			$transact->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			// $this->errors = $e->errors('validation');
			return FALSE;
		}

	}

	public function perform_cashout($id) //valid, -, id Вывод денег успешно завершен
	{
		$transact = ORM::factory('Transaction',array('id'=>$id));
		$transact->state = 3; //Вывод успешно завершен
		try {
			$transact->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			// $this->errors = $e->errors('validation');
			return FALSE;
		}
	}


	public function change_state_deposit($id, $state) //valid, -, id Вывод успешно завершен, для walletone.com
	{
		$transact = ORM::factory('Transaction',array('id'=>$id));

		if ($transact->state == 5)  { //если транзакция помечана уже как успешная, тогда - это попытка зачисления повторного платежа.
			return FALSE; //попытка повторного зачисления
		} else {
			if ($state == 5) {
				$transact->state = $state;  //5 - Ввод денег успешно произведен
				$transact->user->money += $transact->sumIN; //Прибавлении суммы зачисления к текущему счету
				$transact->user->freemoney += $transact->freemoney;
				try {
					$transact->user->save();
					$transact->save();
					return TRUE; //деньги успешно зачисленны
				} catch (ORM_Validation_Exception $e) {
					return FALSE; //Ошибка сохранения изменений
				}
			}
			elseif ($state == 6)
			{
				$transact->state = $state; // 6 - неуспешная транзакция
				try {
					$transact->save();
					return TRUE; // пометка транзакции как неуспешная
				} catch (ORM_Validation_Exception $e) {
					return FALSE; // ошибка сохранения изменений
				}
			} else {
				return FALSE; //если ни 5 и ни 6, тогда возвращаем FALSE
			}
		}

	}

	public function get_all_usercashouts() //valid, -, id, все запросы на вывод денег
	{
		return ORM::factory('Usercashout')->order_by('id', 'DESC')->find_all();
	}

	public function get_count_cashouts() //valid, -, id
	{
		$temp = ORM::factory('Transaction')->where("state","=",'1')->find_all();
		return $temp->count();
	}

	public function get_count_cancelbets() //valid, -, id
	{
		$temp = ORM::factory('Mainbet')->where("state","=",'1')->find_all();
		$i = 0;
		foreach($temp as $item)
		{
			switch ($item->typebet) {
				case 1:
				case 3:
				case 5:
				case 7:
				case 9:
				case 11:
					if ($item->match->state == 1) $i++; break;
				case 101:
					if ($item->match->map1_state == 1) $i++; break;
				case 102:
					if ($item->match->map2_state == 1) $i++; break;
				case 103:
					if ($item->match->map3_state == 1) $i++; break;
				case 104:
					if ($item->match->map4_state == 1) $i++; break;
				case 105:
					if ($item->match->map5_state == 1) $i++; break;
				case 106:
					if ($item->match->map6_state == 1) $i++; break;
				case 107:
					if ($item->match->map7_state == 1) $i++; break;
				case 108:
					if ($item->match->map8_state == 1) $i++; break;
				case 109:
					if ($item->match->map9_state == 1) $i++; break;
				case 110:
					if ($item->match->map10_state == 1) $i++; break;
				case 111:
					if ($item->match->map11_state == 1) $i++; break;
			}
		}
		return $i;
	}


	public function request_cancelbet($id) //valid, -, id
	{
		$mainbet = ORM::factory('Mainbet',array('id'=>$id));
		$mainbet->state = 1;

		try {
			$mainbet->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			return FALSE;
		}
	}

	public function get_all_matchbets($id) //valid, -, id
	{
		return ORM::factory('Mainbet')->where("matchID","=",$id)->order_by('id', 'DESC')->find_all();
	}


	public function user_cancelbets($id)
	{
		$temp = ORM::factory('Muser',array('id'=>$id));

		if ($temp->set_cencelbets == 0) { //если разрешено отменять ставки, отменить
			$temp->set_cencelbets = 1;
		} else {
			$temp->set_cencelbets = 0;
		}
		$temp->save();
		return TRUE;
	}


	public function update_user_disciplines($id,$user_id) //valid, -, id
	{
		$temp = ORM::factory('Muser',array('id'=>$user_id));
		$temp->disciplines = $id;
		$temp->save();
		return TRUE;
	}




	public function savemessage($user_id, $post) //valid, -, id
	{
		date_default_timezone_set('UTC');
		$temp = new Model_Support();
		$temp->userID = $user_id;
		$temp->message = $post;
		$temp->adminID = 0;
		$temp->datetime = time();
		$temp->state = 0;
		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}


	public function savemessageadmin($userid, $adminid, $message) //valid, -, id
	{
		date_default_timezone_set('UTC');
		$temp = new Model_Support();
		$temp->userID = $userid;
		$temp->message = $message;
		$temp->adminID = $adminid;
		$temp->datetime = time();
		$temp->state = 1;

		$unread = ORM::factory('Support')->where("userID","=",$userid)->and_where("state","=","0")->find_all();

		foreach($unread as $item)
		{
			$item->state = 1;
			$item->save();
		}

		try
		{
			$temp->save();
			return TRUE;
		} catch (ORM_Validation_Exception $e) {
			$this->errors = $e->errors('validation');
			return FALSE;
		}
	}


	public function get_messages($user_id) //15 сообщений пользователя
	{
		$temp = ORM::factory('Support')->where("userID","=",$user_id)->order_by('datetime', 'DESC')->limit(15)->find_all();
		return $temp;
	}

	public function get_messages_admin($user_id) //15 сообщений пользователя
	{
		$temp = ORM::factory('Support')->where("userID","=",$user_id)->order_by('datetime', 'DESC')->limit(30)->find_all();
		return $temp;
	}

	public function get_count_unreadmessages() //valid, -, id
	{
		$temp = ORM::factory('Support')->where("state","=",'0')->find_all();
		return $temp->count();
	}

	public function get_unreadmessages() //valid, -, id
	{
		$temp = ORM::factory('Support')->where("state","=",'0')->find_all();
		return $temp;
	}


	// public function get_all_cancelbet() //valid, -, id
	// {
	// 	return ORM::factory('Mainbet')->where("state","=",'1')->find_all();
	// }


}
