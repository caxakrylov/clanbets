<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mroom_Jx extends Controller {

	public function action_mrtable() //valid, -, id, logged
	{
		date_default_timezone_set('UTC');

		$auth = Auth::instance();
		//если пользователь залогинен и является администратором
		if ($auth->logged_in() && $auth->logged_in('admin') != 0 )
		{
			$data = array();
			$mres = new Model_Resources();
			$session = Session::instance();

			$data['matches'] = $mres->get_all_matches();
			$data['disciplines'] = $mres->get_all_disciplines();
			$data['mainbets_state1'] = $mres->get_all_mainbets_state1(); //Запросы на отмену ставки.
			$str_result = "";

			foreach($data['disciplines'] as $item_disc) {
				$n=0;
				foreach($data['matches'] as $item_match) {
					if ($item_disc->id == $item_match->discipline->id) {
						if ($n==0) {
							$str_result .= "<tr><td colspan='12' class='tr_disc'>".$item_disc->name."</td></tr>";
							$n=1;
						}

						$offset=$_SESSION['utc_user']*60*60; //UTC user
						$UTCuser=date("d.m.Y", $offset+time()); //real time
						// $UTC0=date(time()); //UTC+0
						$UTCmatch = $offset+$item_match->datetime; //UTC match

						$str_result .= "<tr class='usertr' onclick='goedit(".$item_match->id.");'>";


						if (date('d.m.Y',$UTCmatch) == $UTCuser) {
							$str_result .= '<td style="width:80px;">'.date('H:i',$UTCmatch).' today</td>';
						} else {
							$str_result .= '<td style="width:80px;">'.date('d.m H:i',$UTCmatch).'</td>';
						}

						$str_result .= "
						<td style='border-left:1px dotted #bbb; width:45px;'>".$item_match->id."</td>
						<td style='border-left:1px dotted #bbb; width:45px;'>";
						if ($item_match->outsider>0) $str_result .= "<span class='label sumlabel oddslable'>Bo".$item_match->bestof."</span>";
						else $str_result .= "Bo".$item_match->bestof;

						$str_result .= "</td>
						<td style='border-left:1px dotted #bbb; width:190px;'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
						<td style='border-right:1px dotted #bbb;'>".$item_match->rate1."</td>
						<td style='width:190px;'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
						<td style='border-right:1px dotted #bbb;'>".$item_match->rate2."</td>
						<td style='border-right:1px dotted #bbb;'>";
							if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
						$str_result .= "</td>

						<td style='min-width:100px;'>".$item_match->event->name."</td>";


						if ($item_match->state == 1 && $item_match->new == 1) {
							$str_result .= "<td><span class='label label-satgreen labelad'>Active</span><span class='label sumlabel newlabel'>N</span>";
						} elseif ($item_match->state == 1 && $item_match->new == 0){
							$str_result .= "<td><span class='label label-satgreen labelad'>Active</span>";
						} elseif ($item_match->state == 2) {
							$str_result .= "<td><span class='label label-lightred labelad'>Started</span>";
						}
						$i = 0;
						foreach($data['mainbets_state1'] as $itembets) {
							if ($itembets->match->id == $item_match->id)
								switch ($itembets->typebet) {
									case 1:
									case 3:
									case 5:
									case 7:
									case 9:
									case 11:
										if ($itembets->match->state == 1) $i++; break;
									case 101:
										if ($itembets->match->map1_state == 1) $i++; break;
									case 102:
										if ($itembets->match->map2_state == 1) $i++; break;
									case 103:
										if ($itembets->match->map3_state == 1) $i++; break;
									case 104:
										if ($itembets->match->map4_state == 1) $i++; break;
									case 105:
										if ($itembets->match->map5_state == 1) $i++; break;
									case 106:
										if ($itembets->match->map6_state == 1) $i++; break;
									case 107:
										if ($itembets->match->map7_state == 1) $i++; break;
									case 108:
										if ($itembets->match->map8_state == 1) $i++; break;
									case 109:
										if ($itembets->match->map9_state == 1) $i++; break;
									case 110:
										if ($itembets->match->map10_state == 1) $i++; break;
									case 111:
										if ($itembets->match->map11_state == 1) $i++; break;
								}
						}
						if ($i > 0) $str_result .= "<span class='label sumlabel allsumlabel'>".$i."</span>";


						//вывод состояния отдельных карт.
						$i = 1;
						do {
							switch ($i) {
								case 2:
									switch ($item_match->map1_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>1</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>1</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>1</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>1</span>";
											break;
									}
									switch ($item_match->map2_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>2</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>2</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>2</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>2</span>";
											break;
									}
									break;
								case 3:
									switch ($item_match->map3_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>3</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>3</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>3</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>3</span>";
											break;
									}
									break;
								case 4:
									switch ($item_match->map4_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>4</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>4</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>4</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>4</span>";
											break;
									}
									break;
								case 5:
									switch ($item_match->map5_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>5</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>5</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>5</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>5</span>";
											break;
									}
									break;
								case 6:
									switch ($item_match->map6_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>6</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>6</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>6</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>6</span>";
											break;
									}
									break;
								case 7:
									switch ($item_match->map7_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>7</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>7</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>7</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>7</span>";
											break;
									}
									break;
								case 8:
									switch ($item_match->map8_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>8</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>8</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>8</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>8</span>";
											break;
									}
									break;
								case 9:
									switch ($item_match->map9_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>9</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>9</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>9</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>9</span>";
											break;
									}
									break;
								case 10:
									switch ($item_match->map10_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>10</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>10</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>10</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>10</span>";
											break;
									}
									break;
								case 11:
									switch ($item_match->map11_state) {
										case 1:
											$str_result .= "<span style='color:#19c611; font-weight:bold; background:#ccfaca;'>11</span>";
											break;
										case 2:
											$str_result .= "<span style='color:#fc0717; font-weight:bold; background:#fed0d3;'>11</span>";
											break;
										case 3:
											$str_result .= "<span style='color:#155bdf; text-decoration:line-through; font-weight:bold; background:#a7c3f7;'>11</span>";
											break;
										case 4:
											$str_result .= "<span style='color:#000; text-decoration:line-through; font-weight:bold; background:#909090;'>11</span>";
											break;
									}
									break;
							}
						} while ($i++ < $item_match->bestof);

						$str_result .= "</td></tr>";
					}
				}

			}
			echo $str_result;
		}// login admin
	}



	public function action_oldmatchtable() //valid, -, id, logged
	{
		date_default_timezone_set('UTC');

		$auth = Auth::instance();
		//если пользователь залогинен и является администратором
		if ($auth->logged_in() && $auth->logged_in('admin') != 0 )
		{
			$data = array();
			$mres = new Model_Resources();
			$session = Session::instance();

			$data['matches'] = $mres->get_all_oldmatches();
			$data['disciplines'] = $mres->get_all_disciplines();
			$str_result = "";

			foreach($data['disciplines'] as $item_disc) {
				$n=0;
				foreach($data['matches'] as $item_match) {
					if ($item_disc->id == $item_match->discipline->id) {
						if ($n==0) {
							$str_result .= "<tr><td colspan='12' class='tr_disc'>".$item_disc->name."</td></tr>";
							$n=1;
						}

						$offset=$_SESSION['utc_user']*60*60; //UTC user
						$UTCuser=date("d.m.Y", $offset+time()); //real time
						// $UTC0=date(time()); //UTC+0
						$UTCmatch = $offset+$item_match->datetime; //UTC match

						$str_result .= "<tr class='usertr' onclick='goedit(".$item_match->id.");'>";


						if (date('d.m.Y',$UTCmatch) == $UTCuser) {
							$str_result .= '<td style="width:85px;">'.date('H:i',$UTCmatch).' today</td>';
						} else {
							$str_result .= '<td style="width:87px;">'.date('d.m.y H:i',$UTCmatch).'</td>';
						}

						$str_result .= "
						<td style='border-left:1px dotted #bbb; width:45px;'>".$item_match->id."</td>
						<td style='border-left:1px dotted #bbb; width:45px;'>";
						if ($item_match->outsider>0) $str_result .= "<span class='label sumlabel oddslable'>Bo".$item_match->bestof."</span>";
						else $str_result .= "Bo".$item_match->bestof;

						$str_result .= "</td>";

						if ($item_match->score1 > $item_match->score2) {
						$str_result .= "
						<td style='border-left:1px dotted #bbb; width:180px; background:#89e48c;'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
						<td style='border-right:1px dotted #bbb; background:#89e48c;'>".$item_match->rate1." (".$item_match->score1.")</td>
						<td style='width:180px;'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
						<td style='border-right:1px dotted #bbb;'>".$item_match->rate2." (".$item_match->score2.")</td>
						<td style='border-right:1px dotted #bbb;'>";
							if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
						$str_result .= "</td>";

						} elseif ($item_match->score1 < $item_match->score2) {

						$str_result .= "
						<td style='border-left:1px dotted #bbb; width:180px;'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
						<td style='border-right:1px dotted #bbb;'>".$item_match->rate1." (".$item_match->score1.")</td>
						<td style='width:180px; background:#89e48c;'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
						<td style='border-right:1px dotted #bbb; background:#89e48c;' >".$item_match->rate2." (".$item_match->score2.")</td>
						<td style='border-right:1px dotted #bbb;'>";
							if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
						$str_result .= "</td>";

						} elseif ($item_match->score1 == $item_match->score2 && $item_match->cancel_state != 1) {

						$str_result .= "
						<td style='border-left:1px dotted #bbb; width:180px;'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
						<td style='border-right:1px dotted #bbb;'>".$item_match->rate1." (".$item_match->score1.")</td>
						<td style='width:180px;'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
						<td style='border-right:1px dotted #bbb;' >".$item_match->rate2." (".$item_match->score2.")</td>
						<td style='border-right:1px dotted #bbb; background:#89e48c;'>";
							if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
						$str_result .= "</td>";

						} else {

						$str_result .= "
						<td style='border-left:1px dotted #bbb; width:180px;'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
						<td style='border-right:1px dotted #bbb;'>".$item_match->rate1." (".$item_match->score1.")</td>
						<td style='width:180px;'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
						<td style='border-right:1px dotted #bbb;' >".$item_match->rate2." (".$item_match->score2.")</td>
						<td style='border-right:1px dotted #bbb;'>";
							if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
						$str_result .= "</td>";

						}


						$str_result .= "<td>".$item_match->maxbet." (".$item_match->marge.")</td>

						<td style='min-width:100px;'>".$item_match->event->name."</td>";


						if ($item_match->state == 0 && $item_match->cancel_state == 0) {
							$str_result .= "<td><span class='label'>Close ".$item_match->score1.':'.$item_match->score2."</span></td></tr>";
						} else {
							$str_result .= "<td><span class='label'>Cancelled</span></td></tr>";
						}

					}
				}

			}
			echo $str_result;
		}// login admin
	}

	public function action_checkCountCashout() //valid, -, id, logged
	{
		$auth = Auth::instance();
		//если пользователь залогинен и является администратором
		if (isset($_POST) && $auth->logged_in() && $auth->logged_in('admin') != 0 )
		{
			// проверка count
			$post = Validation::factory($_POST)
				->rule('count', 'digit')
				->rule('count', 'max_length', array(':value', 10));

			if ($post->check()) {
				$count = $_POST['count'];
				$mres = new Model_Resources();
				$newcount = $mres->get_count_cashouts();

				if ($newcount != $count) {
					echo json_encode(array('result' => $newcount));
				} else {
					echo json_encode(array('result' => $count));
				}
			} else {
				echo json_encode(array('result' => $count));
			}

		} else {echo json_encode(array('result' => 0));}
	}

	public function action_checkCountCancelBet() //valid, -, id, logged
	{
		$auth = Auth::instance();
		//если пользователь залогинен и является администратором
		if (isset($_POST) && $auth->logged_in() && $auth->logged_in('admin') != 0 )
		{
			// проверка count
			$post = Validation::factory($_POST)
				->rule('count', 'digit')
				->rule('count', 'max_length', array(':value', 10));

			if ($post->check()) {
				$count = $_POST['count'];
				$mres = new Model_Resources();
				$newcount = $mres->get_count_cancelbets();

				if ($newcount != $count) {
					echo json_encode(array('result' => $newcount));
				} else {
					echo json_encode(array('result' => $count));
				}
			} else {
				echo json_encode(array('result' => $count));
			}

		} else {echo json_encode(array('result' => 0));}
	}


	public function action_checkCountMessages() //valid, -, id, logged
	{
		$auth = Auth::instance();
		//если пользователь залогинен и является администратором
		if (isset($_POST) && $auth->logged_in() && $auth->logged_in('admin') != 0 )
		{
			// проверка count
			$post = Validation::factory($_POST)
				->rule('count', 'digit')
				->rule('count', 'max_length', array(':value', 10));

			if ($post->check()) {
				$count = $_POST['count'];
				$mres = new Model_Resources();
				$newcount = $mres->get_count_unreadmessages();

				if ($newcount != $count) {
					echo json_encode(array('result' => $newcount));
				} else {
					echo json_encode(array('result' => $count));
				}
			} else {
				echo json_encode(array('result' => $count));
			}

		} else {echo json_encode(array('result' => 0));}
	}


	public function action_cancelbetYES() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();

					if ($mres->cancelbet_YES($id)) {
						$mres->add_log(6, $id);
						echo json_encode(array('result' => 1));
					} else {
						echo json_encode(array('result' => 0)); //ошибка сохранения
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_cancelbetNO() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();

					if ($mres->cancelbet_NO($id)) {
						echo json_encode(array('result' => 1));
					} else {
						echo json_encode(array('result' => 0)); //ошибка сохранения
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}


	public function action_matchstartstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->state == 1) {
						if ($mres->start_match($id)) {
							$mres->add_log(2, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->state == 2)
					{
						if ($mres->stop_match($id)) {
							$mres->add_log(1, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}


	public function action_map1startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map1_state == 1) {
						if ($mres->start_map1($id)) {
							$mres->start_match($id);
							$mres->add_log(21, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map1_state == 2)
					{
						if ($mres->stop_map1($id)) {
							$mres->add_log(11, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}


	public function action_map2startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map2_state == 1) {
						if ($mres->start_map2($id)) {
							$mres->start_match($id);
							$mres->add_log(22, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map2_state == 2)
					{
						if ($mres->stop_map2($id)) {
							$mres->add_log(12, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}


	public function action_map3startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map3_state == 1) {
						if ($mres->start_map3($id)) {
							$mres->start_match($id);
							$mres->add_log(23, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map3_state == 2)
					{
						if ($mres->stop_map3($id)) {
							$mres->add_log(13, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map4startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map4_state == 1) {
						if ($mres->start_map4($id)) {
							$mres->start_match($id);
							$mres->add_log(24, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map4_state == 2)
					{
						if ($mres->stop_map4($id)) {
							$mres->add_log(14, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map5startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map5_state == 1) {
						if ($mres->start_map5($id)) {
							$mres->start_match($id);
							$mres->add_log(25, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map5_state == 2)
					{
						if ($mres->stop_map5($id)) {
							$mres->add_log(15, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map6startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map6_state == 1) {
						if ($mres->start_map6($id)) {
							$mres->start_match($id);
							$mres->add_log(26, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map6_state == 2)
					{
						if ($mres->stop_map6($id)) {
							$mres->add_log(16, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map7startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map7_state == 1) {
						if ($mres->start_map7($id)) {
							$mres->start_match($id);
							$mres->add_log(27, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map7_state == 2)
					{
						if ($mres->stop_map7($id)) {
							$mres->add_log(17, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map8startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map8_state == 1) {
						if ($mres->start_map8($id)) {
							$mres->start_match($id);
							$mres->add_log(28, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map8_state == 2)
					{
						if ($mres->stop_map8($id)) {
							$mres->add_log(18, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map9startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map9_state == 1) {
						if ($mres->start_map9($id)) {
							$mres->start_match($id);
							$mres->add_log(29, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map9_state == 2)
					{
						if ($mres->stop_map9($id)) {
							$mres->add_log(19, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map10startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map10_state == 1) {
						if ($mres->start_map10($id)) {
							$mres->start_match($id);
							$mres->add_log(210, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map10_state == 2)
					{
						if ($mres->stop_map10($id)) {
							$mres->add_log(110, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}

	public function action_map11startstop() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					$mres = new Model_Resources();
					$match = $mres->get_match($id);

					if ($match->map11_state == 1) {
						if ($mres->start_map11($id)) {
							$mres->start_match($id);
							$mres->add_log(211, $id);
							echo json_encode(array('result' => 1));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}
					elseif ($match->map11_state == 2)
					{
						if ($mres->stop_map11($id)) {
							$mres->add_log(111, $id);
							echo json_encode(array('result' => 2));
						} else {
							echo json_encode(array('result' => 0)); //ошибка сохранения
						}
					}

				} else {
					echo json_encode(array('result' => 0)); // ID не корректное.
				}
			} else {
				echo json_encode(array('result' => 0)); //Пользователь не залогинен
			}
		} else {
			echo json_encode(array('result' => 0)); //POST
		}
	}



	public function action_wallmessadmin()  //valid, -, id, logged
	{
		$auth = Auth::instance();
		$body = '';

		if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
		{
			if (isset($_POST) && Valid::not_empty($_POST))
			{
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {
					$data = array();
					$mres = new Model_Resources();
					$data['message'] = $mres->get_messages_admin($id);
					$offset = $_SESSION['utc_user']*60*60; //UTC user


					foreach($data['message'] as $message) {
						if ($message->state == 0)
							$new = '<span class="label sumlabel newlabel">N</span>';
						else
							$new = '';
						if ($message->adminID > 0)
							$body = '
		                                <li class="clearfix admin">
		                                    <div class="chat-body clearfix">
		                                        <div class="header">
			                                            <small class="text-muted">
			                                                '.$message->admin->realname.' <i class="fa fa-clock-o fa-fw"></i> '.date('d.m.y H:i',$offset+$message->datetime).'
			                                            </small>
		                                        </div>
		                                       <div class="textbody">'.$message->message.'</div>
		                                    </div>
		                                </li>'.$body;
						else
							$body = '
		                                <li class="clearfix">
		                                    <div class="chat-body clearfix">
		                                        <div class="header">
			                                            <small class="text-muted">
			                                                '.$message->user->username.' <i class="fa fa-clock-o fa-fw"></i> '.date('d.m.y H:i',$offset+$message->datetime).$new.'
			                                            </small>
		                                        </div>
		                                        <div class="textbody">'.$message->message.'</div>
		                                    </div>
		                                </li>'.$body;
					}
				}
			}
		} //logged in
		echo $body;
	}


	public function action_usermessage()  //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$message = $_POST['usermessage'];
			$userid = $_POST['id']; //id пользователя

			$auth = Auth::instance();

			if($auth->logged_in() && $auth->logged_in('admin') != 0) //залогинен, нет
			{
				$adminid = $auth->get_user(); //id админа

				$mres = new Model_Resources();
				if  (!Valid::max_length($message, 5000)) //max 5000 символов
				{
					echo json_encode(array('result' => 3));
				}
				elseif (!Valid::not_empty($message)) //не пустое
				{
					echo json_encode(array('result' => 4));
				} else {
					$check = $mres->savemessageadmin($userid, $adminid, $message);
					if($check) {
						echo json_encode(array('result' => 1));  //Сообщение сохранено
					} else {
						echo json_encode(array('result' => 0)); // Ошибка сохранения
					}
				}
			} else {
				echo json_encode(array('result' => 0)); // Пользователь не залогинен
			}

		} else {	throw HTTP_Exception::factory(404, 'File not found!');}
	}



}
