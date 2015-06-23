<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Matches extends MControllerAdmin
{
	public $template = 'mroom/base_mroom';

	public function action_index()
	{
		$data = array();
		$mres = new Model_Resources();

		$data['disciplines'] = $mres->get_all_disciplines();
		$this->template->content = View::factory('mroom/mroom_match_add_step0',$data);
	}

	public function action_addmatch()
	{
		date_default_timezone_set('UTC');

		$mres = new Model_Resources();
		$data = array();

		if(isset($_POST['submit']))
		{
			$disciplineID = Arr::get($_POST, 'disciplineID', '');
			$data['teams'] = $mres->get_match_teams($disciplineID);
			$data['discipline'] = $mres->get_discipline($disciplineID);

			$session = Session::instance();
			$session->set('discipline', $data['discipline']);			//session
			$this->template->content = View::factory('mroom/mroom_match_add_step1',$data);
		}

		if(isset($_POST['submit_step1']))
		{
			$session = Session::instance();
			$data['discipline'] = $session->get('discipline','');

			if (isset($_POST['checkplayers'])) //Есть игроки
			{
				$teamID1 = Arr::get($_POST, 'teamID1', '');
				$teamID2 = Arr::get($_POST, 'teamID2', '');
				$session->set('teamID1', $teamID1);
				$session->set('teamID2', $teamID2);
				$data['players1'] = $mres->get_match_players($teamID1);
				$data['players2'] = $mres->get_match_players($teamID2);
				$this->template->content = View::factory('mroom/mroom_match_add_step1-2',$data);
			} else {
				if (isset($_POST['playerID1'])) //Былыли игроки
				{
					$playerID1 = Arr::get($_POST, 'playerID1', '');
					$playerID2 = Arr::get($_POST, 'playerID2', '');
					$session->set('playerID1', $playerID1);
					$session->set('playerID2', $playerID2);
					$data['team1'] = $mres->get_team($session->get('teamID1',''));
					$data['team2'] = $mres->get_team($session->get('teamID2',''));
					$data['player1'] = $mres->get_player($playerID1);
					$data['player2'] = $mres->get_player($playerID2);

					$this->template->content = View::factory('mroom/mroom_match_add_step2',$data);
				} else { //нет игроков
					$teamID1 = Arr::get($_POST, 'teamID1', '');
					$teamID2 = Arr::get($_POST, 'teamID2', '');
					$session->set('teamID1', $teamID1);
					$session->set('teamID2', $teamID2);
					unset($_SESSION['playerID1']);
					unset($_SESSION['playerID2']);
					$data['team1'] = $mres->get_team($teamID1);
					$data['team2'] = $mres->get_team($teamID2);
					$data['players1'] = $mres->get_match_players($teamID1);
					$data['players2'] = $mres->get_match_players($teamID2);
					//$data['allplayers'] = $mres->get_all_players();		//STANDIN

					$this->template->content = View::factory('mroom/mroom_match_add_step2',$data);
				}

			}

		}


		if(isset($_POST['submit_step2']))
		{
			$session = Session::instance();

			$rate1 = Arr::get($_POST, 'rate11', '');
			$rate2 = Arr::get($_POST, 'rate22', '');
			$draw = Arr::get($_POST, 'rate33', '');
			$maxbet = Arr::get($_POST, 'maxbet', '');
			$bestof = Arr::get($_POST, 'bestof', '');
			$marge = Arr::get($_POST, 'marge', '');
			$marge_map = Arr::get($_POST, 'marge_map', '');
			$sum1 = Arr::get($_POST, 'sum1', '');
			$sum2 = Arr::get($_POST, 'sum2', '');
			$drawsum = Arr::get($_POST, 'draw', '');
			$preim1 = Arr::get($_POST, 'preim1', '');
			$preim2 = Arr::get($_POST, 'preim2', '');

			if (isset($_SESSION['playerID1'])) {
				$map1_playerID1 = $session->get('playerID1','');
				$map1_playerID2 = $session->get('playerID2','');

				$map2_playerID1 = $session->get('playerID1','');
				$map2_playerID2 = $session->get('playerID2','');

				$map3_playerID1 = $session->get('playerID1','');
				$map3_playerID2 = $session->get('playerID2','');

				$map4_playerID1 = $session->get('playerID1','');
				$map4_playerID2 = $session->get('playerID2','');

				$map5_playerID1 = $session->get('playerID1','');
				$map5_playerID2 = $session->get('playerID2','');

				$map6_playerID1 = $session->get('playerID1','');
				$map6_playerID2 = $session->get('playerID2','');

				$map7_playerID1 = $session->get('playerID1','');
				$map7_playerID2 = $session->get('playerID2','');

				$map8_playerID1 = $session->get('playerID1','');
				$map8_playerID2 = $session->get('playerID2','');

				$map9_playerID1 = $session->get('playerID1','');
				$map9_playerID2 = $session->get('playerID2','');

				$map10_playerID1 = $session->get('playerID1','');
				$map10_playerID2 = $session->get('playerID2','');

				$map11_playerID1 = $session->get('playerID1','');
				$map11_playerID2 = $session->get('playerID2','');
			} else {
				$map1_playerID1 = Arr::get($_POST, 'map1_playerID1', '');
				$map1_playerID2 = Arr::get($_POST, 'map1_playerID2', '');

				$map2_playerID1 = Arr::get($_POST, 'map2_playerID1', '');
				$map2_playerID2 = Arr::get($_POST, 'map2_playerID2', '');

				$map3_playerID1 = Arr::get($_POST, 'map3_playerID1', '');
				$map3_playerID2 = Arr::get($_POST, 'map3_playerID2', '');

				$map4_playerID1 = Arr::get($_POST, 'map4_playerID1', '');
				$map4_playerID2 = Arr::get($_POST, 'map4_playerID2', '');

				$map5_playerID1 = Arr::get($_POST, 'map5_playerID1', '');
				$map5_playerID2 = Arr::get($_POST, 'map5_playerID2', '');

				$map6_playerID1 = Arr::get($_POST, 'map6_playerID1', '');
				$map6_playerID2 = Arr::get($_POST, 'map6_playerID2', '');

				$map7_playerID1 = Arr::get($_POST, 'map7_playerID1', '');
				$map7_playerID2 = Arr::get($_POST, 'map7_playerID2', '');

				$map8_playerID1 = Arr::get($_POST, 'map8_playerID1', '');
				$map8_playerID2 = Arr::get($_POST, 'map8_playerID2', '');

				$map9_playerID1 = Arr::get($_POST, 'map9_playerID1', '');
				$map9_playerID2 = Arr::get($_POST, 'map9_playerID2', '');

				$map10_playerID1 = Arr::get($_POST, 'map10_playerID1', '');
				$map10_playerID2 = Arr::get($_POST, 'map10_playerID2', '');

				$map11_playerID1 = Arr::get($_POST, 'map11_playerID1', '');
				$map11_playerID2 = Arr::get($_POST, 'map11_playerID2', '');
			}

			$map1_rate1 = Arr::get($_POST, 'map1_rate1', '');
			$map1_rate2 = Arr::get($_POST, 'map1_rate2', '');
			$map1_proc = Arr::get($_POST, 'map1_proc', '');

			$map2_rate1 = Arr::get($_POST, 'map2_rate1', '');
			$map2_rate2 = Arr::get($_POST, 'map2_rate2', '');
			$map2_proc = Arr::get($_POST, 'map2_proc', '');

			$map3_rate1 = Arr::get($_POST, 'map3_rate1', '');
			$map3_rate2 = Arr::get($_POST, 'map3_rate2', '');
			$map3_proc = Arr::get($_POST, 'map3_proc', '');

			$map4_rate1 = Arr::get($_POST, 'map4_rate1', '');
			$map4_rate2 = Arr::get($_POST, 'map4_rate2', '');
			$map4_proc = Arr::get($_POST, 'map4_proc', '');

			$map5_rate1 = Arr::get($_POST, 'map5_rate1', '');
			$map5_rate2 = Arr::get($_POST, 'map5_rate2', '');
			$map5_proc = Arr::get($_POST, 'map5_proc', '');

			$map6_rate1 = Arr::get($_POST, 'map6_rate1', '');
			$map6_rate2 = Arr::get($_POST, 'map6_rate2', '');
			$map6_proc = Arr::get($_POST, 'map6_proc', '');

			$map7_rate1 = Arr::get($_POST, 'map7_rate1', '');
			$map7_rate2 = Arr::get($_POST, 'map7_rate2', '');
			$map7_proc = Arr::get($_POST, 'map7_proc', '');

			$map8_rate1 = Arr::get($_POST, 'map8_rate1', '');
			$map8_rate2 = Arr::get($_POST, 'map8_rate2', '');
			$map8_proc = Arr::get($_POST, 'map8_proc', '');

			$map9_rate1 = Arr::get($_POST, 'map9_rate1', '');
			$map9_rate2 = Arr::get($_POST, 'map9_rate2', '');
			$map9_proc = Arr::get($_POST, 'map9_proc', '');

			$map10_rate1 = Arr::get($_POST, 'map10_rate1', '');
			$map10_rate2 = Arr::get($_POST, 'map10_rate2', '');
			$map10_proc = Arr::get($_POST, 'map10_proc', '');

			$map11_rate1 = Arr::get($_POST, 'map11_rate1', '');
			$map11_rate2 = Arr::get($_POST, 'map11_rate2', '');
			$map11_proc = Arr::get($_POST, 'map11_proc', '');

			$session->set('map1_playerID1', $map1_playerID1);
			$session->set('map1_playerID2', $map1_playerID2);
			$session->set('map1_rate1', $map1_rate1);
			$session->set('map1_rate2', $map1_rate2);
			$session->set('map1_proc', $map1_proc);

			$session->set('map2_playerID1', $map2_playerID1);
			$session->set('map2_playerID2', $map2_playerID2);
			$session->set('map2_rate1', $map2_rate1);
			$session->set('map2_rate2', $map2_rate2);
			$session->set('map2_proc', $map2_proc);

			$session->set('map3_playerID1', $map3_playerID1);
			$session->set('map3_playerID2', $map3_playerID2);
			$session->set('map3_rate1', $map3_rate1);
			$session->set('map3_rate2', $map3_rate2);
			$session->set('map3_proc', $map3_proc);

			$session->set('map4_playerID1', $map4_playerID1);
			$session->set('map4_playerID2', $map4_playerID2);
			$session->set('map4_rate1', $map4_rate1);
			$session->set('map4_rate2', $map4_rate2);
			$session->set('map4_proc', $map4_proc);

			$session->set('map5_playerID1', $map5_playerID1);
			$session->set('map5_playerID2', $map5_playerID2);
			$session->set('map5_rate1', $map5_rate1);
			$session->set('map5_rate2', $map5_rate2);
			$session->set('map5_proc', $map5_proc);

			$session->set('map6_playerID1', $map6_playerID1);
			$session->set('map6_playerID2', $map6_playerID2);
			$session->set('map6_rate1', $map6_rate1);
			$session->set('map6_rate2', $map6_rate2);
			$session->set('map6_proc', $map6_proc);

			$session->set('map7_playerID1', $map7_playerID1);
			$session->set('map7_playerID2', $map7_playerID2);
			$session->set('map7_rate1', $map7_rate1);
			$session->set('map7_rate2', $map7_rate2);
			$session->set('map7_proc', $map7_proc);

			$session->set('map8_playerID1', $map8_playerID1);
			$session->set('map8_playerID2', $map8_playerID2);
			$session->set('map8_rate1', $map8_rate1);
			$session->set('map8_rate2', $map8_rate2);
			$session->set('map8_proc', $map8_proc);

			$session->set('map9_playerID1', $map9_playerID1);
			$session->set('map9_playerID2', $map9_playerID2);
			$session->set('map9_rate1', $map9_rate1);
			$session->set('map9_rate2', $map9_rate2);
			$session->set('map9_proc', $map9_proc);

			$session->set('map10_playerID1', $map10_playerID1);
			$session->set('map10_playerID2', $map10_playerID2);
			$session->set('map10_rate1', $map10_rate1);
			$session->set('map10_rate2', $map10_rate2);
			$session->set('map10_proc', $map10_proc);

			$session->set('map11_playerID1', $map11_playerID1);
			$session->set('map11_playerID2', $map11_playerID2);
			$session->set('map11_rate1', $map11_rate1);
			$session->set('map11_rate2', $map11_rate2);
			$session->set('map11_proc', $map11_proc);

			$session->set('rate1', $rate1);
			$session->set('rate2', $rate2);
			$session->set('draw', $draw);
			$session->set('maxbet', $maxbet);
			$session->set('bestof', $bestof);
			$session->set('marge', $marge);
			$session->set('marge_map', $marge_map);
			$session->set('sum1', $sum1);
			$session->set('sum2', $sum2);
			$session->set('drawsum', $drawsum);
			$session->set('preim1', $preim1);
			$session->set('preim2', $preim2);

			$data['discipline'] = $session->get('discipline','');
			$data['team1'] = $mres->get_team($session->get('teamID1',''));
			$data['team2'] = $mres->get_team($session->get('teamID2',''));
			$data['player1'] = $mres->get_player($session->get('playerID1',''));
			$data['player2'] = $mres->get_player($session->get('playerID2',''));
			$data['rate1'] = $rate1;
			$data['rate2'] = $rate2;
			$data['draw'] = $draw;
			$data['maxbet'] = $maxbet;
			$data['bestof'] = $bestof;
			$data['events'] = $mres->get_all_events();

			$this->template->content = View::factory('mroom/mroom_match_add_step_final',$data);
		}


		if(isset($_POST['submit_final']))
		{
			$session = Session::instance();
			$data['discipline'] = $session->get('discipline','');

			$disciplineID = $data['discipline']->id;
			$teamID1 = $session->get('teamID1','');
			$teamID2 = $session->get('teamID2','');
			$playerID1 = $session->get('playerID1','');
			$playerID2 = $session->get('playerID2','');
			$rate1 = $session->get('rate1','');
			$rate2 = $session->get('rate2','');
			$bestof = $session->get('bestof','');
			$datetime = Arr::get($_POST, 'datetime', '');
			$datetime = strtotime($datetime)-3600; // 3600 Для корректного ввода времени матча по CET! -1 час
			$eventID = Arr::get($_POST, 'eventID', '');
			$draw = $session->get('draw');
			$maxbet = $session->get('maxbet','');
			$marge = $session->get('marge','');
			$marge_map = $session->get('marge_map','');
			$createdate = time();
			$sum1 = $session->get('sum1','');
			$sum2 = $session->get('sum2','');
			$drawsum = $session->get('drawsum','');
			$preim1 = $session->get('preim1','');
			$preim2 = $session->get('preim2','');


			$map1_playerID1 = $session->get('map1_playerID1', '');
			$map1_playerID2 = $session->get('map1_playerID2', '');
			$map1_rate1 = $session->get('map1_rate1', '');
			$map1_rate2 = $session->get('map1_rate2', '');
			$map1_proc = $session->get('map1_proc', '');

			$map2_playerID1 = $session->get('map2_playerID1', '');
			$map2_playerID2 = $session->get('map2_playerID2', '');
			$map2_rate1 = $session->get('map2_rate1', '');
			$map2_rate2 = $session->get('map2_rate2', '');
			$map2_proc = $session->get('map2_proc', '');

			$map3_playerID1 = $session->get('map3_playerID1', '');
			$map3_playerID2 = $session->get('map3_playerID2', '');
			$map3_rate1 = $session->get('map3_rate1', '');
			$map3_rate2 = $session->get('map3_rate2', '');
			$map3_proc = $session->get('map3_proc', '');

			$map4_playerID1 = $session->get('map4_playerID1', '');
			$map4_playerID2 = $session->get('map4_playerID2', '');
			$map4_rate1 = $session->get('map4_rate1', '');
			$map4_rate2 = $session->get('map4_rate2', '');
			$map4_proc = $session->get('map4_proc', '');

			$map5_playerID1 = $session->get('map5_playerID1', '');
			$map5_playerID2 = $session->get('map5_playerID2', '');
			$map5_rate1 = $session->get('map5_rate1', '');
			$map5_rate2 = $session->get('map5_rate2', '');
			$map5_proc = $session->get('map5_proc', '');

			$map6_playerID1 = $session->get('map6_playerID1', '');
			$map6_playerID2 = $session->get('map6_playerID2', '');
			$map6_rate1 = $session->get('map6_rate1', '');
			$map6_rate2 = $session->get('map6_rate2', '');
			$map6_proc = $session->get('map6_proc', '');

			$map7_playerID1 = $session->get('map7_playerID1', '');
			$map7_playerID2 = $session->get('map7_playerID2', '');
			$map7_rate1 = $session->get('map7_rate1', '');
			$map7_rate2 = $session->get('map7_rate2', '');
			$map7_proc = $session->get('map7_proc', '');

			$map8_playerID1 = $session->get('map8_playerID1', '');
			$map8_playerID2 = $session->get('map8_playerID2', '');
			$map8_rate1 = $session->get('map8_rate1', '');
			$map8_rate2 = $session->get('map8_rate2', '');
			$map8_proc = $session->get('map8_proc', '');

			$map9_playerID1 = $session->get('map9_playerID1', '');
			$map9_playerID2 = $session->get('map9_playerID2', '');
			$map9_rate1 = $session->get('map9_rate1', '');
			$map9_rate2 = $session->get('map9_rate2', '');
			$map9_proc = $session->get('map9_proc', '');

			$map10_playerID1 = $session->get('map10_playerID1', '');
			$map10_playerID2 = $session->get('map10_playerID2', '');
			$map10_rate1 = $session->get('map10_rate1', '');
			$map10_rate2 = $session->get('map10_rate2', '');
			$map10_proc = $session->get('map10_proc', '');

			$map11_playerID1 = $session->get('map11_playerID1', '');
			$map11_playerID2 = $session->get('map11_playerID2', '');
			$map11_rate1 = $session->get('map11_rate1', '');
			$map11_rate2 = $session->get('map11_rate2', '');
			$map11_proc = $session->get('map11_proc', '');

			//Ставка с преимуществом
			$outsider = 0;

			if ($bestof >= 3) {
				if ($sum1 <= 20) {
					$outsider = 1;
				} elseif ($sum2 <= 20) {
					$outsider = 2;
				}
			}

			//расчет ставок для отдельных карт, общий коэффциент, если не будет указан конкретный коэффициент. Маржа marge_map
			if ($bestof >=2) {
				if ($drawsum == '') {
					$allmap_rate1 = $marge_map/($sum1 * 0.01);
					$allmap_rate2 = $marge_map/($sum2 * 0.01);

					$allmap_rate1 = number_format($allmap_rate1, 3, '.', '');
					$allmap_rate2 = number_format($allmap_rate2, 3, '.', '');

					$allmap_rate1_allsum = $sum1; //начальная сумма как и у основной ставки.
					$allmap_rate2_allsum = $sum2;
				} else {
					$tmpdraw = $drawsum/2; //если есть ничая, то делим сумму ничьи и прибавляем к sum1 и sum2, вычисляем новый коэфф для отдельных карт.
					$tmpdraw = number_format($tmpdraw, 2, '.', '');
					$allmap_rate1_allsum = $sum1+$tmpdraw;
					$allmap_rate2_allsum = $sum2+$tmpdraw;
					$allmap_rate1 = $marge_map/($allmap_rate1_allsum * 0.01);
					$allmap_rate2 = $marge_map/($allmap_rate2_allsum * 0.01);

					$allmap_rate1 = number_format($allmap_rate1, 3, '.', '');
					$allmap_rate2 = number_format($allmap_rate2, 3, '.', '');
				}
			} else {
				$allmap_rate1 = 0.000; //если BO равно 1, тогда rate и sum для карт будет нулевыми.
				$allmap_rate2 = 0.000;
				$allmap_rate1_allsum = 0.00;
				$allmap_rate2_allsum = 0.00;
			}


			if (trim($drawsum) == '') $drawsum = 0.00;
			if (trim($draw) == '') $draw = 0.000;

			if ($temp = $mres->add_match($disciplineID,$teamID1,$teamID2,$playerID1,$playerID2,$rate1,$rate2,$datetime,$eventID,$draw,$maxbet,$createdate,$bestof,$marge,$sum1,$sum2,$drawsum,$outsider,$allmap_rate1,$allmap_rate2,$allmap_rate1_allsum,$allmap_rate2_allsum,
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
				$map1_proc,$map2_proc,$map3_proc,$map4_proc,$map5_proc,$map6_proc,$map7_proc,$map8_proc,$map9_proc,$map10_proc,$map11_proc,$marge_map,$preim1,$preim2))
			{

					$log_id = $mres->add_log(1,$temp->id,"<img src='/src/img/uploads/".$temp->team1->flag->icon."'/> ".$temp->team1->shortname.$temp->player1->name."&nbsp;&nbsp;vs&nbsp;&nbsp;<img src='/src/img/uploads/".$temp->team2->flag->icon."'/> ".$temp->team2->shortname.$temp->player2->name,$temp->discipline->name);

					$data['ok']='';
					$session->delete('discipline');
					$session->delete('teamID1');
					$session->delete('teamID2');
					$session->delete('playerID1');
					$session->delete('playerID2');
					$session->delete('rate1');
					$session->delete('rate2');
					$session->delete('draw');
					$session->delete('maxbet');
					$session->delete('bestof');
					$session->delete('marge');
					$session->delete('marge_map');
					$session->delete('sum1');
					$session->delete('sum2');
					$session->delete('drawsum');
					$i = 1;
					do {
						$session->delete('map'.$i.'_playerID1');
						$session->delete('map'.$i.'_playerID2');
						$session->delete('map'.$i.'_rate1');
						$session->delete('map'.$i.'_rate2');
						$session->delete('map'.$i.'_proc');
					} while ($i++ < 11);


					$session->set('okaddmatch', '');

					Controller::redirect('mroom/matches');
			} else {
				$data['errors']=$mres->errors;

				$data['discipline'] = $session->get('discipline','');
				$data['team1'] = $mres->get_team($teamID1);
				$data['team2'] = $mres->get_team($teamID2);
				$data['player1'] = $mres->get_player($playerID1);
				$data['player2'] = $mres->get_player($playerID2);
				$data['rate1'] = $rate1;
				$data['rate2'] = $rate2;
				$data['draw'] = $draw;
				$data['maxbet'] = $maxbet;
				$data['events'] = $mres->get_all_events();
				$data['event'] = $mres->get_event($eventID);
				$data['datetime'] = date('d-m-Y H:i',$datetime);
				$data['bestof'] = $bestof;

				$this->template->content = View::factory('mroom/mroom_match_add_step_final',$data);
			}
		}
	}

	public function action_edit()
	{
		date_default_timezone_set('UTC');
		$data = array();
		$id = $this->request->param('id');
		$mres = new Model_Resources();
		$data['match'] = $mres->get_match($id);
		$data['events'] = $mres->get_all_events();
		$data['mainbets'] = $mres->get_all_matchbets($id);

		if(isset($_POST['editmatchsubmit']))
		{
			$eventID = Arr::get($_POST, 'eventID', '');
			$datetime = Arr::get($_POST, 'datetime', '');
			$datetime = strtotime($datetime)-3600; // 3600 Для корректного ввода времени матча по CET! -1 час
			$maxbet = Arr::get($_POST, 'maxbet', '');
			$fullstart = Arr::get($_POST, 'fullstart', '');
			if (!isset($fullstart))
				$fullstart = 0;

			if ($mres->edit_match($id,$eventID,$datetime,$maxbet,$fullstart))
			{
				$mres->add_log(9, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id");
			} else {
				$data['errors']=$mres->errors;
			}
		}


		if(isset($_POST['closesubmit_match']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'score1', '');
			$score2 = Arr::get($_POST, 'score2', '');
			$closetime = time();

			if ($mres->close_match($id,$score1,$score2,$closetime))
			{
				$mres->add_log(0, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmatch");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_match']))
		{
			date_default_timezone_set('UTC');

			$canceltime = time();

			if ($mres->cancel_match($id,$canceltime))
			{
				$mres->add_log(3, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmatch");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map1']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map1_score1', '');
			$score2 = Arr::get($_POST, 'map1_score2', '');

			if ($mres->close_map1($id,$score1,$score2))
			{
				$mres->add_log(31, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap1");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map1']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map1($id))
			{
				$mres->add_log(41, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap1");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map2']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map2_score1', '');
			$score2 = Arr::get($_POST, 'map2_score2', '');

			if ($mres->close_map2($id,$score1,$score2))
			{
				$mres->add_log(32, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap2");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map2']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map2($id))
			{
				$mres->add_log(42, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap2");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map3']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map3_score1', '');
			$score2 = Arr::get($_POST, 'map3_score2', '');

			if ($mres->close_map3($id,$score1,$score2))
			{
				$mres->add_log(33, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap3");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map3']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map3($id))
			{
				$mres->add_log(43, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap3");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map4']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map4_score1', '');
			$score2 = Arr::get($_POST, 'map4_score2', '');

			if ($mres->close_map4($id,$score1,$score2))
			{
				$mres->add_log(34, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap4");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map4']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map4($id))
			{
				$mres->add_log(44, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap4");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map5']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map5_score1', '');
			$score2 = Arr::get($_POST, 'map5_score2', '');

			if ($mres->close_map5($id,$score1,$score2))
			{
				$mres->add_log(35, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap5");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map5']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map5($id))
			{
				$mres->add_log(45, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap5");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map6']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map6_score1', '');
			$score2 = Arr::get($_POST, 'map6_score2', '');

			if ($mres->close_map6($id,$score1,$score2))
			{
				$mres->add_log(36, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap6");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map6']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map6($id))
			{
				$mres->add_log(46, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap6");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map7']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map7_score1', '');
			$score2 = Arr::get($_POST, 'map7_score2', '');

			if ($mres->close_map7($id,$score1,$score2))
			{
				$mres->add_log(37, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap7");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map7']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map7($id))
			{
				$mres->add_log(47, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap7");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map8']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map8_score1', '');
			$score2 = Arr::get($_POST, 'map8_score2', '');

			if ($mres->close_map8($id,$score1,$score2))
			{
				$mres->add_log(38, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap8");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map8']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map8($id))
			{
				$mres->add_log(48, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap8");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map9']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map9_score1', '');
			$score2 = Arr::get($_POST, 'map9_score2', '');

			if ($mres->close_map9($id,$score1,$score2))
			{
				$mres->add_log(39, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap9");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map9']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map9($id))
			{
				$mres->add_log(49, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap9");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		if(isset($_POST['closesubmit_map10']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map10_score1', '');
			$score2 = Arr::get($_POST, 'map10_score2', '');

			if ($mres->close_map10($id,$score1,$score2))
			{
				$mres->add_log(310, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap10");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map10']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map10($id))
			{
				$mres->add_log(410, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap10");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}



		if(isset($_POST['closesubmit_map11']))
		{
			date_default_timezone_set('UTC');

			$score1 = Arr::get($_POST, 'map11_score1', '');
			$score2 = Arr::get($_POST, 'map11_score2', '');

			if ($mres->close_map11($id,$score1,$score2))
			{
				$mres->add_log(311, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap11");
			} else {
				$data['closeerr']='';
			}
		}
		if(isset($_POST['cancelsubmit_map11']))
		{
			date_default_timezone_set('UTC');

			if ($mres->cancel_map11($id))
			{
				$mres->add_log(411, $id);
				$data['ok']='';
				Controller::redirect("mroom/matches/edit/$id#redirectmap11");
			} else {
				$data['cancelerr']=''; //добавить
			}
		}


		$this->template->content = View::factory('mroom/mroom_match_edit',$data);
	}



	// public function action_close()
	// {
	// 	$id = $this->request->param('id');
	// 	$mres = new Model_Resources();

	// 	//Если матч был закрыт (3), то матч нельзя стартануть.
	// 	$mres->close_match($id);
	// 	$mres->add_log(0, $id);
	// 	Controller::redirect("mroom/matches/edit/$id");

	// }


	// public function action_delete()	//Нарушается целостность сессии
	// {
	// 	$id = $this->request->param('id');
	// 	$mres = new Model_Resources();
	// 	$mres->del_match($id);
	// 	Controller::redirect('mroom/');
	// }

	// 0 - Закрыт, 1 - открыт, 2 - стартанут

}