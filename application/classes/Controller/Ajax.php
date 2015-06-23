<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends AjaxController {

	public function action_login() //valid, -, id, logged, OK
	{
		$auth = Auth::instance();
		if (isset($_POST) && Valid::not_empty($_POST) && !$auth->logged_in()) {
			if (Valid::email($_POST['login'])) //email
			{
				$post = Validation::factory($_POST)
					->rule('login', 'max_length', array(':value', 245))
					->rule('password', 'not_empty')
					->rule('password', 'max_length', array(':value', 245))
					->rule('password', 'min_length', array(':value', 5));

				if ($post->check()) {
					$password = Arr::get($_POST, 'password', '');
					$login = Arr::get($_POST, 'login', '');
					$res = $auth->login_email($login, $password, true);
					echo json_encode(array('result' => $res));
				} else {
					echo json_encode(array('result' => FALSE));
				}
			}
			elseif(Valid::alpha_dash($_POST['login']))  //login, alpha numeric _ -
			{
				$post = Validation::factory($_POST)
					->rule('login', 'max_length', array(':value', 245))
					->rule('password', 'not_empty')
					->rule('password', 'max_length', array(':value', 245))
					->rule('password', 'min_length', array(':value', 5));

				if ($post->check()) {
					$password = Arr::get($_POST, 'password', '');
					$login = Arr::get($_POST, 'login', '');
					$res = $auth->login($login, $password, true);
					echo json_encode(array('result' => $res));
				} else {
					echo json_encode(array('result' => FALSE));
				}
			} else {
				echo json_encode(array('result' => FALSE));
			}
		} else {
			echo json_encode(array('result' => FALSE));
		}
	}



	public function action_usertable()  //valid, -, id, logged, OK
	{
		$data = array();
		$mres = new Model_Resources();
		// $session = Session::instance();

		$data['matches'] = $mres->get_all_matches();
		$data['disciplines'] = $mres->get_all_disciplines();
		$data['endmatches'] = $mres->get_all_endmatches();
		$str_result = "";

		$auth = Auth::instance();

		if($auth->logged_in()) { //если пользователь залогинен, показывать его ставки в таблице
			$userID = $auth->get_user();
			foreach($data['disciplines'] as $item_disc) {
				if ($_SESSION['disciplines_user'] == 'all' || in_array($item_disc, $_SESSION['disciplines_user'])) {
					$n=0;
					foreach($data['matches'] as $item_match){
						$betsuser_for_match = ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("matchID","=",$item_match->id)->and_where("state","!=","2")->find_all();

						$betsum1=0.00;
						$betsum2=0.00;
						$betdrawsum=0.00;

						foreach($betsuser_for_match as $itembet) {
							if ($itembet->typebet == 3 || //если ставки на аутсайдера, тогда прибавлять к общей сумме ставок на него.
							$itembet->typebet == 5 ||
							$itembet->typebet == 7 ||
							$itembet->typebet == 9 ||
							$itembet->typebet == 11) {
								if ($item_match->outsider == 1)
									$betsum1 += $itembet->sum1 + $itembet->sum2;
								else
									$betsum2 += $itembet->sum1 + $itembet->sum2;
							} else {
								$betsum1 += $itembet->sum1;
								$betsum2 += $itembet->sum2;
								$betdrawsum += $itembet->sumdraw;
							}

						}

						if ($betsum1 == 0.00) {$betsum1 = '';} else {$betsum1 = " <span class='label lgreen'>$".$betsum1."</span>";}
						if ($betsum2 == 0.00) {$betsum2 = '';} else {$betsum2 = " <span class='label lgreen'>$".$betsum2."</span>";}
						if ($betdrawsum == 0.00) {$betdrawsum = '';} else {$betdrawsum = " <span class='label lgreen'>$".$betdrawsum."</span>";}

						if ($item_disc->id == $item_match->discipline->id) {
							if ($n==0) {
								$str_result .= "<tr><td colspan='9' class='tr_disc'><img src='/src/img/uploads/".$item_match->discipline->icon."'/><span>".$item_disc->name."</span></td></tr>";
								$n=1;
							}

							$offset=$_SESSION['utc_user']*60*60; //UTC user
							$UTCuser=date("d.m.Y", $offset+time()); //real time
							// $UTC0=date(time()); //UTC+0
							$UTCmatch = $offset+$item_match->datetime; //UTC match

							$str_result .= "<tr class='usertr' onclick='betswindow(".$item_match->id.");'>";


							if (date('d.m.Y',$UTCmatch) == $UTCuser) {
								$str_result .= "<td class='td_utc'>".date('H:i',$UTCmatch)." today</td>";
							} else {
								$str_result .= "<td class='td_utc'>".date('d.m H:i',$UTCmatch)."</td>";
							}

							$str_result .= "
							<td class='td_bof'>";
							if ($item_match->outsider>0) $str_result .= "<span class='label lodds' title='Rate with the advantage'>Bo".$item_match->bestof."</span>";
							else $str_result .= "Bo".$item_match->bestof;

							$str_result .= "</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
							<td class='td_rate'>".$item_match->rate1.$betsum1."</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
							<td class='td_rate'>".$item_match->rate2.$betsum2."</td>
							<td class='td_rate'>";
								if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw.$betdrawsum;}
							$str_result .= "</td><td class='td_event'>".$item_match->event->name."</td>";

							if ($item_match->state == 1 && $item_match->new == 1) {
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span><span class='label lnew' title='New match'>N</span></td></tr>";
							} elseif ($item_match->state == 1 && $item_match->new == 0){
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span></td></tr>";
							} elseif ($item_match->state == 2) {
								$str_result .= "<td class='td_state'><span class='label lred' title='The match started'>Started</span></td></tr>";
							}
						}
					}

					//Cloced matches
					foreach($data['endmatches'][$item_disc->id] as $item_endmatch) {
						if ($item_disc->id == $item_endmatch->discipline->id) {
							if ($n==0) {
								$str_result .= "<tr><td colspan='9' class='tr_disc'><img src='/src/img/uploads/".$item_endmatch->discipline->icon."'/><span>".$item_disc->name."</span></td></tr>";
								$n=1;
							}

							$offset=$_SESSION['utc_user']*60*60; //UTC user
							$UTCuser=date("d.m.Y", $offset+time()); //real time
							// $UTC0=date(time()); //UTC+0
							$UTCmatch = $offset+$item_endmatch->datetime; //UTC match

						$str_result .= "<tr class='usertr closetr' onclick='betswindow(".$item_endmatch->id.");'>";

							if (date('d.m.Y',$UTCmatch) == $UTCuser) {
								$str_result .= "<td class='td_utc'>".date('H:i',$UTCmatch)." today</td>";
							} else {
								$str_result .= "<td class='td_utc'>".date('d.m H:i',$UTCmatch)."</td>";
							}

							$str_result .= "
							<td class='td_bof'>";
							if ($item_endmatch->outsider>0) $str_result .= "<span class='label lodds' title='Rate with the advantage'>Bo".$item_endmatch->bestof."</span>";
							else $str_result .= "Bo".$item_endmatch->bestof;
							$str_result .= "</td>";

							if ($item_endmatch->score1 > $item_endmatch->score2) {
								$str_result .= "<td class='td_player td_win'>
								<img src='/src/img/uploads/".$item_endmatch->team1->flag->icon."'/> ".$item_endmatch->team1->shortname.$item_endmatch->player1->name."</td><td class='td_rate td_win'>".$item_endmatch->rate1." (".$item_endmatch->score1.")</td>";
							} else {
								$str_result .= "<td class='td_player'>
								<img src='/src/img/uploads/".$item_endmatch->team1->flag->icon."'/> ".$item_endmatch->team1->shortname.$item_endmatch->player1->name."</td><td class='td_rate'>".$item_endmatch->rate1." (".$item_endmatch->score1.")</td>";
							}

							if ($item_endmatch->score1 < $item_endmatch->score2) {
								$str_result .= "<td class='td_player td_win'><img src='/src/img/uploads/".$item_endmatch->team2->flag->icon."'/> ".$item_endmatch->team2->shortname.$item_endmatch->player2->name."</td>
									<td class='td_rate td_win'>".$item_endmatch->rate2." (".$item_endmatch->score2.")</td>";
							} else {
								$str_result .= "<td class='td_player'><img src='/src/img/uploads/".$item_endmatch->team2->flag->icon."'/> ".$item_endmatch->team2->shortname.$item_endmatch->player2->name."</td>
									<td class='td_rate'>".$item_endmatch->rate2." (".$item_endmatch->score2.")</td>";
							}

							if ($item_endmatch->score1 == $item_endmatch->score2  && $item_endmatch->cancel_state != 1) {
								$str_result .= "<td class='td_rate td_win'>";
								if ($item_endmatch->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_endmatch->draw;}
							} else {
								$str_result .= "<td class='td_rate'>";
								if ($item_endmatch->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_endmatch->draw;}
							}

							$str_result .= "</td><td class='td_event'>".$item_endmatch->event->name."</td>";


							if ($item_endmatch->cancel_state != 1) {
								$str_result .= "<td class='td_state'><span class='label' title='Match closed'>Close ".$item_endmatch->score1.':'.$item_endmatch->score2."</span></td></tr>";
							} else {
								$str_result .= "<td class='td_state'><span class='label' title='The match is cancelled or postponed'>Cancelled</span></td></tr>";
							}

						}
					}
				}
			} //foreach disciplines

		} else { //если пользователь не залогинен, таблица без ставок

			foreach($data['disciplines'] as $item_disc) {
				if ($_SESSION['disciplines_user'] == 'all' || in_array($item_disc, $_SESSION['disciplines_user']))
				{
					$n=0;
					foreach($data['matches'] as $item_match) {
						if ($item_disc->id == $item_match->discipline->id) {
							if ($n==0) {
								$str_result .= "<tr><td colspan='9' class='tr_disc'><img src='/src/img/uploads/".$item_match->discipline->icon."'/><span>".$item_disc->name."</span></td></tr>";
								$n=1;
							}
							$offset=$_SESSION['utc_user']*60*60; //UTC user
							$UTCuser=date("d.m.Y", $offset+time()); //real time
							// $UTC0=date(time()); //UTC+0
							$UTCmatch = $offset+$item_match->datetime; //UTC match

							$str_result .= "<tr class='usertr' onclick='betswindow(".$item_match->id.");'>";


							if (date('d.m.Y',$UTCmatch) == $UTCuser) {
								$str_result .= "<td class='td_utc'>".date('H:i',$UTCmatch)." today</td>";
							} else {
								$str_result .= "<td class='td_utc'>".date('d.m H:i',$UTCmatch)."</td>";
							}

							$str_result .= "
							<td class='td_bof'>";
							if ($item_match->outsider>0) $str_result .= "<span class='label lodds' title='Rate with the advantage'>Bo".$item_match->bestof."</span>";
							else $str_result .= "Bo".$item_match->bestof;

							$str_result .= "</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
							<td class='td_rate'>".$item_match->rate1."</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
							<td class='td_rate'>".$item_match->rate2."</td>
							<td class='td_rate'>";
								if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
							$str_result .= "</td><td class='td_event'>".$item_match->event->name."</td>";

							if ($item_match->state == 1 && $item_match->new == 1) {
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span><span class='label lnew' title='New match'>N</span></td></tr>";
							} elseif ($item_match->state == 1 && $item_match->new == 0){
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span></td></tr>";
							} elseif ($item_match->state == 2) {
								$str_result .= "<td class='td_state'><span class='label lred' title='The match started'>Started</span></td></tr>";
							}
						}
					}

					//Cloced matches
					foreach($data['endmatches'][$item_disc->id] as $item_endmatch) {
						if ($item_disc->id == $item_endmatch->discipline->id) {
							if ($n==0) {
								$str_result .= "<tr><td colspan='9' class='tr_disc'><img src='/src/img/uploads/".$item_endmatch->discipline->icon."'/><span>".$item_disc->name."</span></td></tr>";
								$n=1;
							}

							$offset=$_SESSION['utc_user']*60*60; //UTC user
							$UTCuser=date("d.m.Y", $offset+time()); //real time
							// $UTC0=date(time()); //UTC+0
							$UTCmatch = $offset+$item_endmatch->datetime; //UTC match

						$str_result .= "<tr class='usertr closetr' onclick='betswindow(".$item_endmatch->id.");'>";

							if (date('d.m.Y',$UTCmatch) == $UTCuser) {
								$str_result .= "<td class='td_utc'>".date('H:i',$UTCmatch)." today</td>";
							} else {
								$str_result .= "<td class='td_utc'>".date('d.m H:i',$UTCmatch)."</td>";
							}

							$str_result .= "
							<td class='td_bof'>";
							if ($item_endmatch->outsider>0) $str_result .= "<span class='label lodds' title='Rate with the advantage'>Bo".$item_endmatch->bestof."</span>";
							else $str_result .= "Bo".$item_endmatch->bestof;
							$str_result .= "</td>";

							if ($item_endmatch->score1 > $item_endmatch->score2) {
								$str_result .= "<td class='td_player td_win'>
								<img src='/src/img/uploads/".$item_endmatch->team1->flag->icon."'/> ".$item_endmatch->team1->shortname.$item_endmatch->player1->name."</td><td class='td_rate td_win'>".$item_endmatch->rate1." (".$item_endmatch->score1.")</td>";
							} else {
								$str_result .= "<td class='td_player'>
								<img src='/src/img/uploads/".$item_endmatch->team1->flag->icon."'/> ".$item_endmatch->team1->shortname.$item_endmatch->player1->name."</td><td class='td_rate'>".$item_endmatch->rate1." (".$item_endmatch->score1.")</td>";
							}

							if ($item_endmatch->score1 < $item_endmatch->score2) {
								$str_result .= "<td class='td_player td_win'><img src='/src/img/uploads/".$item_endmatch->team2->flag->icon."'/> ".$item_endmatch->team2->shortname.$item_endmatch->player2->name."</td>
									<td class='td_rate td_win'>".$item_endmatch->rate2." (".$item_endmatch->score2.")</td>";
							} else {
								$str_result .= "<td class='td_player'><img src='/src/img/uploads/".$item_endmatch->team2->flag->icon."'/> ".$item_endmatch->team2->shortname.$item_endmatch->player2->name."</td>
									<td class='td_rate'>".$item_endmatch->rate2." (".$item_endmatch->score2.")</td>";
							}

							if ($item_endmatch->score1 == $item_endmatch->score2  && $item_endmatch->cancel_state != 1) {
								$str_result .= "<td class='td_rate td_win'>";
								if ($item_endmatch->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_endmatch->draw;}
							} else {
								$str_result .= "<td class='td_rate'>";
								if ($item_endmatch->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_endmatch->draw;}
							}

							$str_result .= "</td><td class='td_event'>".$item_endmatch->event->name."</td>";


							if ($item_endmatch->cancel_state != 1) {
								$str_result .= "<td class='td_state'><span class='label' title='Match closed'>Close ".$item_endmatch->score1.':'.$item_endmatch->score2."</span></td></tr>";
							} else {
								$str_result .= "<td class='td_state'><span class='label' title='The match is cancelled or postponed'>Cancelled</span></td></tr>";
							}

						}
					}
				}
			}
		} //else
		echo $str_result;
	}


	public function action_usertablemultiple()  //valid, -, id, logged, OK
	{
		$data = array();
		$mres = new Model_Resources();
		// $session = Session::instance();

		$data['matches'] = $mres->get_all_matches();
		$data['disciplines'] = $mres->get_all_disciplines();
		$str_result = "";

		$auth = Auth::instance();

		if($auth->logged_in()) { //если пользователь залогинен, показывать его ставки в таблице
			$userID = $auth->get_user();
			foreach($data['disciplines'] as $item_disc) {
				if ($_SESSION['disciplines_user'] == 'all' || in_array($item_disc, $_SESSION['disciplines_user'])) {
					$n=0;
					foreach($data['matches'] as $item_match){
						$betsuser_for_match = ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("matchID","=",$item_match->id)->and_where("state","!=","2")->find_all();

						$betsum1=0.00;
						$betsum2=0.00;
						$betdrawsum=0.00;

						foreach($betsuser_for_match as $itembet) {
							if ($itembet->typebet == 3 || //если ставки на аутсайдера, тогда прибавлять к общей сумме ставок на него.
							$itembet->typebet == 5 ||
							$itembet->typebet == 7 ||
							$itembet->typebet == 9 ||
							$itembet->typebet == 11) {
								if ($item_match->outsider == 1)
									$betsum1 += $itembet->sum1 + $itembet->sum2;
								else
									$betsum2 += $itembet->sum1 + $itembet->sum2;
							} else {
								$betsum1 += $itembet->sum1;
								$betsum2 += $itembet->sum2;
								$betdrawsum += $itembet->sumdraw;
							}

						}

						if ($item_disc->id == $item_match->discipline->id) {
							if ($n==0) {
								$str_result .= "<tr><td colspan='9' class='tr_disc'><img src='/src/img/uploads/".$item_match->discipline->icon."'/><span>".$item_disc->name."</span></td></tr>";
								$n=1;
							}

							$offset=$_SESSION['utc_user']*60*60; //UTC user
							$UTCuser=date("d.m.Y", $offset+time()); //real time
							// $UTC0=date(time()); //UTC+0
							$UTCmatch = $offset+$item_match->datetime; //UTC match

							$str_result .= "<tr class='usertr_multiple'>";


							if (date('d.m.Y',$UTCmatch) == $UTCuser) {
								$str_result .= "<td class='td_utc'>".date('H:i',$UTCmatch)." today</td>";
							} else {
								$str_result .= "<td class='td_utc'>".date('d.m H:i',$UTCmatch)."</td>";
							}

							$str_result .= "
							<td class='td_bof'>";
							if ($item_match->outsider>0) $str_result .= "<span class='label lodds' title='Rate with the advantage'>Bo".$item_match->bestof."</span>";
							else $str_result .= "Bo".$item_match->bestof;

							$str_result .= "</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
							<td class='td_rate'>".$item_match->rate1."<input type='checkbox' name='".$item_match->id."' value='1,".$item_match->rate1."' onclick='checkgroup(this);'></td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
							<td class='td_rate'>".$item_match->rate2."<input type='checkbox' name='".$item_match->id."' value='2,".$item_match->rate2."' onclick='checkgroup(this);'></td>
							<td class='td_rate'>";
								if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw."<input type='checkbox' name='".$item_match->id."' value='3,".$item_match->draw."' onclick='checkgroup(this);'>";}
							$str_result .= "</td><td class='td_event'>".$item_match->event->name."</td>";

							if ($item_match->state == 1 && $item_match->new == 1) {
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span><span class='label lnew' title='New match'>N</span></td></tr>";
							} elseif ($item_match->state == 1 && $item_match->new == 0){
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span></td></tr>";
							} elseif ($item_match->state == 2) {
								$str_result .= "<td class='td_state'><span class='label lred' title='The match started'>Started</span></td></tr>";
							}
						}
					}
				}
			} //foreach disciplines

		} else { //если пользователь не залогинен, таблица без ставок

			foreach($data['disciplines'] as $item_disc) {
				if ($_SESSION['disciplines_user'] == 'all' || in_array($item_disc, $_SESSION['disciplines_user']))
				{
					$n=0;
					foreach($data['matches'] as $item_match) {
						if ($item_disc->id == $item_match->discipline->id) {
							if ($n==0) {
								$str_result .= "<tr><td colspan='9' class='tr_disc'><img src='/src/img/uploads/".$item_match->discipline->icon."'/><span>".$item_disc->name."</span></td></tr>";
								$n=1;
							}
							$offset=$_SESSION['utc_user']*60*60; //UTC user
							$UTCuser=date("d.m.Y", $offset+time()); //real time
							// $UTC0=date(time()); //UTC+0
							$UTCmatch = $offset+$item_match->datetime; //UTC match

							$str_result .= "<tr class='usertr' onclick='betswindow(".$item_match->id.");'>";


							if (date('d.m.Y',$UTCmatch) == $UTCuser) {
								$str_result .= "<td class='td_utc'>".date('H:i',$UTCmatch)." today</td>";
							} else {
								$str_result .= "<td class='td_utc'>".date('d.m H:i',$UTCmatch)."</td>";
							}

							$str_result .= "
							<td class='td_bof'>";
							if ($item_match->outsider>0) $str_result .= "<span class='label lodds' title='Rate with the advantage'>Bo".$item_match->bestof."</span>";
							else $str_result .= "Bo".$item_match->bestof;

							$str_result .= "</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team1->flag->icon."'/> ".$item_match->team1->shortname.$item_match->player1->name."</td>
							<td class='td_rate'>".$item_match->rate1."</td>
							<td class='td_player'><img src='/src/img/uploads/".$item_match->team2->flag->icon."'/> ".$item_match->team2->shortname.$item_match->player2->name."</td>
							<td class='td_rate'>".$item_match->rate2."</td>
							<td class='td_rate'>";
								if ($item_match->draw == 0.000) {$str_result .= "none";} else {$str_result .= $item_match->draw;}
							$str_result .= "</td><td class='td_event'>".$item_match->event->name."</td>";

							if ($item_match->state == 1 && $item_match->new == 1) {
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span><span class='label lnew' title='New match'>N</span></td></tr>";
							} elseif ($item_match->state == 1 && $item_match->new == 0){
								$str_result .= "<td class='td_state'><span class='label lgreen'>Active</span></td></tr>";
							} elseif ($item_match->state == 2) {
								$str_result .= "<td class='td_state'><span class='label lred' title='The match started'>Started</span></td></tr>";
							}
						}
					}

				}
			}
		} //else
		echo $str_result;
	}



	public function action_checknewevents()  //valid, -, id, logged, OK
	{
		$log = array();
		$ttime = time()-10;

		$log = ORM::factory('Log')->where("createdate", ">", $ttime)->find();

		if ($log->loaded()) {
			echo json_encode(array('result' => $log->notify, 'result_title' => $log->title_notify));
		} else {
			echo json_encode(array('result' => 'FALSE'));
		}
	}


	public function action_setUTC()  //valid, -, id, logged, OK
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$post = Validation::factory($_POST)
				->rule('selNum', 'range', array(':value', -12, +14))
				->rule('selNum', 'max_length', array(':value', 3))
				->rule('selNum', 'min_length', array(':value', 2));

			if ($post->check()) {

				$auth = Auth::instance();
				$selNum = Arr::get($_POST, 'selNum', '+0');

				if($auth->logged_in())
				{
					$user_id = $auth->get_user();
					$mres = new Model_Resources();
					$mres->update_utc($selNum,$user_id);
					$_SESSION['utc_user'] = $selNum;
					echo json_encode(array('result' => TRUE));
				}
				else {
					$_SESSION['utc_user'] = $selNum;
					echo json_encode(array('result' => TRUE));
				}
			} else {
				echo json_encode(array('result' => FALSE));
			}
		} else {echo json_encode(array('result' => FALSE));}
	}


	public function action_supportwindow() //valid, -, id, logged, OK
	{
		$auth = Auth::instance();
		$data = array();

		if($auth->logged_in()) // пользователь залогинен, выводим его макс.сумму и его ставки
		{
			$body = '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalLabelbets" aria-hidden="true" id="Modalsupport" onfocus="refreshchat();">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closesupport();">&times;</button>
									<h3 id="ModalLabelbets">Support</h3>
								</div>
								<div class="modal-body">

									<ul class="chat">
										<div id="wallmess">

										</div>
									</ul>

									<table class="tablesupport">
										<tbody>
											<tr>
												<td style="border-top:1px solid #ddd; padding-top:10px;">Message:</td>
											<tr>
												<td><textarea class="form-control" rows="3" name="usermessage" id="usermessage"></textarea></td>
											</tr>
											<tr>
												<td style="border-bottom:1px solid #ddd; padding-bottom:10px;">
													<button class="btn btn-primary" onclick="btnsendmessage();">Send</button>
													<span style="margin-left:5px;" class="label lred" id="messerror"></span>
												</td>
											</tr>
										</tbody>
									</table>


								</div>
								<div class="modal-footer">
									<button class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="closesupport();">Close</button>
								</div>
							</div>
						</div>
					</div>';
			echo $body;
		}
	}


	public function action_wallmess()  //valid, -, id, logged
	{
		$body = '';
		$auth = Auth::instance();
		if($auth->logged_in()) //залогинен, нет
		{

			$userID = $auth->get_user();
			$data = array();
			$mres = new Model_Resources();
			$data['message'] = $mres->get_messages($userID);
			$offset = $_SESSION['utc_user']*60*60; //UTC user


			foreach($data['message'] as $message) {
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
	                                                '.$message->user->username.' <i class="fa fa-clock-o fa-fw"></i> '.date('d.m.y H:i',$offset+$message->datetime).'
	                                            </small>
                                        </div>
                                        <div class="textbody">'.$message->message.'</div>
                                    </div>
                                </li>'.$body;
			}
		} //logged in
		echo $body;
	}


	public function action_betswindow() //valid, -, id, logged, OK
	{
		if (isset($_GET) && Valid::not_empty($_GET))
		{
			$post = Validation::factory($_GET)
				->rule('id', 'max_length', array(':value', 10))
				->rule('id', 'not_empty')
				->rule('id', 'digit');

			$id = $_GET['id'];

			if ($post->check() && $id > 0) {

				$auth = Auth::instance();

				$data = array();
				$mres = new Model_Resources();
				$data['match'] = $mres->get_match($id);

				$offset=$_SESSION['utc_user']*60*60; //UTC user
				$UTCuser=date("d.m.Y", $offset+time()); //real time
				// $UTC0=date(time()); //UTC+0
				$UTCmatch = $offset+$data['match']->datetime; //UTC match
				$UTCtimer = $data['match']->datetime;

				if ($data['match']->state == 1 || $data['match']->state == 2 || $data['match']->state == 0) {

					$body = '<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalLabelbets" aria-hidden="true" id="Modalbet" onfocus="betsinit('.$UTCtimer.','.$id.')">
						<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="closebet();">&times;</button>
								<h3 id="ModalLabelbets">'.$data['match']->discipline->name.'</h3>
							</div>
							<div class="modal-body">
								<table class="modal-body-header"><tr>';
									if (date('d.m.Y',$UTCmatch) == $UTCuser) {
										$body .= '<td style="text-align:left;">'.date('H:i',$UTCmatch).' today</td>';
									} else {
										$body .= '<td style="text-align:left;">'.date('d.m.Y H:i',$UTCmatch).'</td>';
									}

									if ($data['match']->state != 0 && $data['match']->state != 2) {
										$body .= '<td id="btimer"></td>';
									}

									$body .= '<td style="text-align:right;">'.$data['match']->event->name.'</td>';
								$body .= '</tr></table>';


//Accordion
$body .= '
<div class="panel-group" id="accordion2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1" onclick="clearAccord(1);">
				<span>Bet on a match</span>
			</a>';
		if ($data['match']->state == 2) $body .= '<span class="label lred accordstate">Started</span>';
		elseif ($data['match']->state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
		elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) $body .= '<span class="label accordstate">Completed '.$data['match']->score1.':'.$data['match']->score2.'</span>';
		elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) $body .= '<span class="label accordstate">Cancelled</span>';
		$body .= '</div>
		<div id="collapse1" class="panel-collapse collapse in">
			<div class="panel-body">
				<p id="infomessage1"></p>
				<table class="tableformbets">
				<tr>';

					if ($data['match']->draw != '0.000') {
						$body .= '
						<td style="border-top:1px solid #ddd; width:33%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
						<td style="border-top:1px solid #ddd;">Draw</td>
						<td style="border-top:1px solid #ddd; width:33%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>';
					} else {
						$body .= '
						<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
						<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>';
					}

				$body .= '</tr>
				<tr>
					<td>Rate: <span id="r011">'.$data['match']->rate1.'</span></td>';
					if ($data['match']->draw != '0.000') {
						$body .= '<td>Rate: <span id="d011">'.$data['match']->draw.'</span></td>';
					}
					$body .= '<td>Rate: <span id="r021">'.$data['match']->rate2.'</span></td>
				</tr>';
				if ($data['match']->state == 1) {
					$body .= '<tr>
						<td><input type="text" id="sum-r11" class="form-control" onkeypress="sumr1(1);" maxlength="6"></td>';
						if ($data['match']->draw != '0.000') {
							$body .= '<td><input type="text" id="sum-d1" class="form-control" onkeypress="sumrdraw(1);" maxlength="6"></td>';
						}
						$body .= '<td><input type="text" id="sum-r21" class="form-control" onkeypress="sumr2(1);" maxlength="6"></td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r11">0</span>$</td>';
						if ($data['match']->draw != '0.000') {
							$body .= '<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-d11">0</span>$</td>';
						}
						$body .= '<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r21">0</span>$</td>
					</tr>';
				} elseif ($data['match']->state == 2) {
					$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The match started</td></tr>';
				} elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) { //match close
					$body .= '<tr class="trcenter">';

						if ($data['match']->score1 > $data['match']->score2 && $data['match']->draw == '0.000') {
							$body .= '<td class="tdgreen">Win</td><td></td>';
						} elseif($data['match']->score1 > $data['match']->score2 && $data['match']->draw != '0.000') {
							$body .= '<td class="tdgreen">Win</td><td></td><td></td>';
						} elseif($data['match']->score1 < $data['match']->score2 && $data['match']->draw == '0.000') {
							$body .= '<td></td><td class="tdgreen">Win</td>';
						} elseif($data['match']->score1 < $data['match']->score2 && $data['match']->draw != '0.000') {
							$body .= '<td></td><td></td ><td class="tdgreen">Win</td>';
						} elseif($data['match']->score1 == $data['match']->score2) {
							$body .= '<td></td><td class="tdgreen">Draw</td><td></td>';
						}

					$body .= '
					</tr>
					<tr class="trcenter">
						<td>Score: '.$data['match']->score1.'</td>';
						if ($data['match']->draw != '0.000') {
							$body .= '<td></td>';
						}
						$body .= '<td>Score: '.$data['match']->score2.'</td>
					</tr>

					<tr class="trcenter"><td  colspan="3" class="tdborder">The match is completed</td></tr>';
				} elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) {
					$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The match is cancelled</td></tr>';
				}
				$body .= '</table>';
				//end main bets
			$body .= '</div>
		</div>
	</div>';

//Вывод карт
	if ($data['match']->bestof >= 2 && $data['match']->bestof <= 11) {
		$i = 101; //начинаем не с 1, а со 101
		do {
			$body .= '<div class="panel panel-default">
				<div class="panel-heading">
					';
						switch ($i) {
						case 101:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 1st map</span></a>';

							if ($data['match']->map1_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map1_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map1_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map1_score1.':'.$data['match']->map1_score2.'</span>';
							elseif ($data['match']->map1_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 102:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on the 2nd map</span></a>';
							if ($data['match']->map2_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map2_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map2_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map2_score1.':'.$data['match']->map2_score2.'</span>';
							elseif ($data['match']->map2_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 103:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on the 3rd map</span></a>';
							if ($data['match']->map3_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map3_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map3_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map3_score1.':'.$data['match']->map3_score2.'</span>';
							elseif ($data['match']->map3_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 104:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 4th map</span></a>';
							if ($data['match']->map4_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map4_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map4_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map4_score1.':'.$data['match']->map4_score2.'</span>';
							elseif ($data['match']->map4_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 105:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 5th map</span></a>';
							if ($data['match']->map5_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map5_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map5_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map5_score1.':'.$data['match']->map5_score2.'</span>';
							elseif ($data['match']->map5_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 106:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 6th map</span></a>';
							if ($data['match']->map6_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map6_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map6_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map6_score1.':'.$data['match']->map6_score2.'</span>';
							elseif ($data['match']->map6_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 107:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 7th map</span></a>';
							if ($data['match']->map7_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map7_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map7_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map7_score1.':'.$data['match']->map7_score2.'</span>';
							elseif ($data['match']->map7_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 108:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 8th map</span></a>';
							if ($data['match']->map8_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map8_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map8_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map8_score1.':'.$data['match']->map8_score2.'</span>';
							elseif ($data['match']->map8_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 109:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 9th map</span></a>';
							if ($data['match']->map9_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map9_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map9_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map9_score1.':'.$data['match']->map9_score2.'</span>';
							elseif ($data['match']->map9_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 110:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 10th map</span></a>';
							if ($data['match']->map10_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map10_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map10_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map10_score1.':'.$data['match']->map10_score2.'</span>';
							elseif ($data['match']->map10_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						case 111:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');"><span>Bet on 11th map</span></a>';
							if ($data['match']->map11_state == 1) $body .= '<span class="label lgreen accordstate">Active</span>';
							elseif ($data['match']->map11_state == 2) $body .= '<span class="label lred accordstate">Started</span>';
							elseif ($data['match']->map11_state == 3)
								$body .= '<span class="label accordstate">Completed '.$data['match']->map11_score1.':'.$data['match']->map11_score2.'</span>';
							elseif ($data['match']->map11_state == 4) $body.='<span class="label accordstate">Cancelled</span>';
							break;
						}
					$body .= '</a>
				</div>
				<div id="collapse'.$i.'" class="panel-collapse collapse">
					<div class="panel-body">
						<p id="infomessage'.$i.'"></p>';
						$body .= '<table class="tableaccord">';
						switch ($i) {
							case 101:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map1playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map1playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map1_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map1_rate2.'</span></td>
								</tr>';
								if ($data['match']->map1_state == 1) { // 1 - active, 2 - start, 3 - close.
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';

								} elseif ($data['match']->map1_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map1_state == 3) {

									$body .= '<tr class="trcenter">';
									if ($data['match']->map1_score1 > $data['match']->map1_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map1_score1 < $data['match']->map1_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map1_score1.'</td>
										<td>Score: '.$data['match']->map1_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map1_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 102:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map2playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map2playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map2_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map2_rate2.'</span></td>
								</tr>';
								if ($data['match']->map2_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map2_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map2_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map2_score1 > $data['match']->map2_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map2_score1 < $data['match']->map2_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map2_score1.'</td>
										<td>Score: '.$data['match']->map2_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map2_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 103:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map3playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map3playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map3_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map3_rate2.'</span></td>
								</tr>';
								if ($data['match']->map3_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map3_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map3_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map3_score1 > $data['match']->map3_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map3_score1 < $data['match']->map3_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map3_score1.'</td>
										<td>Score: '.$data['match']->map3_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map3_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 104:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map4playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map4playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map4_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map4_rate2.'</span></td>
								</tr>';
								if ($data['match']->map4_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map4_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map4_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map4_score1 > $data['match']->map4_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map4_score1 < $data['match']->map4_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map4_score1.'</td>
										<td>Score: '.$data['match']->map4_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map4_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 105:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map5playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map5playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map5_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map5_rate2.'</span></td>
								</tr>';
								if ($data['match']->map5_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map5_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map5_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map5_score1 > $data['match']->map5_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map5_score1 < $data['match']->map5_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map5_score1.'</td>
										<td>Score: '.$data['match']->map5_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map5_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 106:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map6playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map6playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map6_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map6_rate2.'</span></td>
								</tr>';
								if ($data['match']->map6_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map6_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map6_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map6_score1 > $data['match']->map6_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map6_score1 < $data['match']->map6_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map6_score1.'</td>
										<td>Score: '.$data['match']->map6_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map6_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 107:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map7playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map7playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map7_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map7_rate2.'</span></td>
								</tr>';
								if ($data['match']->map7_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map7_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map7_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map7_score1 > $data['match']->map7_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map7_score1 < $data['match']->map7_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map7_score1.'</td>
										<td>Score: '.$data['match']->map7_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map7_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 108:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map8playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map8playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map8_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map8_rate2.'</span></td>
								</tr>';
								if ($data['match']->map8_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map8_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map8_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map8_score1 > $data['match']->map8_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map8_score1 < $data['match']->map8_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map8_score1.'</td>
										<td>Score: '.$data['match']->map8_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map8_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 109:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map9playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map9playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map9_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map9_rate2.'</span></td>
								</tr>';
								if ($data['match']->map9_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map9_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map9_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map9_score1 > $data['match']->map9_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map9_score1 < $data['match']->map9_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map9_score1.'</td>
										<td>Score: '.$data['match']->map9_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map9_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 110:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map10playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map10playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map10_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map10_rate2.'</span></td>
								</tr>';
								if ($data['match']->map10_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map10_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map10_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map10_score1 > $data['match']->map10_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map10_score1 < $data['match']->map10_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map10_score1.'</td>
										<td>Score: '.$data['match']->map10_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map10_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
							case 111:
								$body .= '
								<tr>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->map11playerID1->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/></td>
									<td style="border-top:1px solid #ddd; width:50%;"><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->map11playerID2->name.'<img style="float:right;" src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/></td>
								</tr>
								<tr>
									<td>Rate: <span id="r01'.$i.'">'.$data['match']->map11_rate1.'</span></td>
									<td>Rate: <span id="r02'.$i.'">'.$data['match']->map11_rate2.'</span></td>
								</tr>';
								if ($data['match']->map11_state == 1) {
									$body .= '<tr>
										<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
										<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
									</tr>
									<tr>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
										<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
									</tr>';
								} elseif ($data['match']->map11_state == 2) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map started</td></tr>';
								} elseif ($data['match']->map11_state == 3) {
									$body .= '<tr class="trcenter">';
									if ($data['match']->map11_score1 > $data['match']->map11_score2) {
										$body .= '<td class="tdgreen">Win</td><td></td>';
									} elseif($data['match']->map11_score1 < $data['match']->map11_score2) {
										$body .= '<td></td><td class="tdgreen">Win</td>';
									}
									$body .= '</tr>

									<tr class="trcenter">
										<td>Score: '.$data['match']->map11_score1.'</td>
										<td>Score: '.$data['match']->map11_score2.'</td>
									</tr>';

									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">Map completed</td></tr>';
								} elseif ($data['match']->map11_state == 4) {
									$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The map is cancelled</td></tr>';
								}
								break;
						}
						$body .= '</table>';
						//end maps bets table
					$body .= '</div>
				</div>
			</div>';
		} while ($i++ < $data['match']->bestof+100);
	} //Конец вывода ставок на отдельные карты.

//Вывод ставок с преимуществом
	if ($data['match']->outsider > 0 && $data['match']->bestof >= 3 && $data['match']->bestof <= 11) {
		$i = 3;
		do {
			if ($i==4 || $i==6 || $i==8 || $i==10) continue;
			$body .= '<div class="panel panel-default">
				<div class="panel-heading">';

						switch ($i) {
						case 3:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');">';
							if ($data['match']->outsider == 1) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.' will win one map?</span>';
							} elseif ($data['match']->outsider == 2) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.' will win one map?</span>';
							}
							$body .= '</a>';

							if ($data['match']->state == 2) $body .= '<span class="label lred accordstateOut">Started</span>';
							elseif ($data['match']->state == 1) $body .= '<span class="label lgreen accordstateOut">Active</span>';
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) {
								$body .= '<span class="label accordstateOut">';
									if 	(($data['match']->outsider == 1 && $data['match']->score1 >= 1) ||
										($data['match']->outsider == 2 && $data['match']->score2 >= 1)) $body .= 'Yes, won';
									else $body .= 'No, not won';
								$body .= '</span>';
							}
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) $body .= '<span class="label accordstateOut">Cancelled</span>';
							break;
						case 5:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');">';
							if ($data['match']->outsider == 1) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.' will wins two maps?</span>';
							} elseif ($data['match']->outsider == 2) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.' will wins two maps?</span>';
							}
							$body .= '</a>';


							if ($data['match']->state == 2) $body .= '<span class="label lred accordstateOut">Started</span>';
							elseif ($data['match']->state == 1) $body .= '<span class="label lgreen accordstateOut">Active</span>';
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) {
								$body .= '<span class="label accordstateOut">';
									if 	(($data['match']->outsider == 1 && $data['match']->score1 >= 2) ||
										($data['match']->outsider == 2 && $data['match']->score2 >= 2)) $body .= 'Yes, won';
									else $body .= 'No, not won';
								$body .= '</span>';
							}
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) $body .= '<span class="label accordstateOut">Cancelled</span>';
							break;
						case 7:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');">';
							if ($data['match']->outsider == 1) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.' will wins three maps?</span>';
							} elseif ($data['match']->outsider == 2) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.' will wins three maps?</span>';
							}
							$body .= '</a>';

							if ($data['match']->state == 2) $body .= '<span class="label lred accordstateOut">Started</span>';
							elseif ($data['match']->state == 1) $body .= '<span class="label lgreen accordstateOut">Active</span>';
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) {
								$body .= '<span class="label accordstateOut">';
									if 	(($data['match']->outsider == 1 && $data['match']->score1 >= 3) ||
										($data['match']->outsider == 2 && $data['match']->score2 >= 3)) $body .= 'Yes, won';
									else $body .= 'No, not won';
								$body .= '</span>';
							}
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) $body .= '<span class="label accordstateOut">Cancelled</span>';
							break;
						case 9:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');">';
							if ($data['match']->outsider == 1) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.' will wins four maps?</span>';
							} elseif ($data['match']->outsider == 2) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.' will wins four maps?</span>';
							}
							$body .= '</a>';

							if ($data['match']->state == 2) $body .= '<span class="label lred accordstateOut">Started</span>';
							elseif ($data['match']->state == 1) $body .= '<span class="label lgreen accordstateOut">Active</span>';
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) {
								$body .= '<span class="label accordstateOut">';
									if 	(($data['match']->outsider == 1 && $data['match']->score1 >= 4) ||
										($data['match']->outsider == 2 && $data['match']->score2 >= 4)) $body .= 'Yes, won';
									else $body .= 'No, not won';
								$body .= '</span>';
							}
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) $body .= '<span class="label accordstateOut">Cancelled</span>';
							break;
						case 11:
							$body .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse'.$i.'" onclick="clearAccord('.$i.');">';
							if ($data['match']->outsider == 1) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.' will wins five maps?</span>';
							} elseif ($data['match']->outsider == 2) {
								$body .= '<span><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.' will wins five maps?</span>';
							}
							$body .= '</a>';

							if ($data['match']->state == 2) $body .= '<span class="label lred accordstateOut">Started</span>';
							elseif ($data['match']->state == 1) $body .= '<span class="label lgreen accordstateOut">Active</span>';
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) {
								$body .= '<span class="label accordstateOut">';
									if 	(($data['match']->outsider == 1 && $data['match']->score1 >= 5) ||
										($data['match']->outsider == 2 && $data['match']->score2 >= 5)) $body .= 'Yes, won';
									else $body .= 'No, not won';
								$body .= '</span>';
							}
							elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1) $body .= '<span class="label accordstateOut">Cancelled</span>';
							break;
						}
					$body .= '
				</div>
				<div id="collapse'.$i.'" class="panel-collapse collapse">
					<div class="panel-body">
						<p id="infomessage'.$i.'"></p>
						<table class="tableaccord">
						<tr>
							<td style="border-top:1px solid #ddd; width:50%;">Yes</td>
							<td style="border-top:1px solid #ddd; width:50%;">No</td>
						</tr>
						<tr>';

							switch ($i) {
							case 3:
								$body .= '<td>Rate: <span id="r01'.$i.'">'.$data['match']->rate1_outsider3.'</span></td>
								<td>Rate: <span id="r02'.$i.'">'.$data['match']->rate2_outsider3.'</span></td>';
								break;
							case 5:
								$body .= '<td>Rate: <span id="r01'.$i.'">'.$data['match']->rate1_outsider5.'</span></td>
								<td>Rate: <span id="r02'.$i.'">'.$data['match']->rate2_outsider5.'</span></td>';
								break;
							case 7:
								$body .= '<td>Rate: <span id="r01'.$i.'">'.$data['match']->rate1_outsider7.'</span></td>
								<td>Rate: <span id="r02'.$i.'">'.$data['match']->rate2_outsider7.'</span></td>';
								break;
							case 9:
								$body .= '<td>Rate: <span id="r01'.$i.'">'.$data['match']->rate1_outsider9.'</span></td>
								<td>Rate: <span id="r02'.$i.'">'.$data['match']->rate2_outsider9.'</span></td>';
								break;
							case 11:
								$body .= '<td>Rate: <span id="r01'.$i.'">'.$data['match']->rate1_outsider11.'</span></td>
								<td>Rate: <span id="r02'.$i.'">'.$data['match']->rate2_outsider11.'</span></td>';
								break;
							}


						$body .= '</tr>';


						if ($data['match']->state == 2)
							$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The match started</td></tr>';
						elseif ($data['match']->state == 1)
							$body .= '<tr>
								<td><input type="text" id="sum-r1'.$i.'" class="form-control" onkeypress="sumr1('.$i.');" maxlength="6"></td>
								<td><input type="text" id="sum-r2'.$i.'" class="form-control" onkeypress="sumr2('.$i.');" maxlength="6"></td>
							</tr>
							<tr>
								<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r1'.$i.'">0</span>$</td>
								<td style="border-bottom:1px solid #ddd;">Cash prize: <span id="prize-r2'.$i.'">0</span>$</td>
							</tr>';
						elseif ($data['match']->state == 0 && $data['match']->cancel_state == 0) {
							$body .= '<tr class="trcenter">';

							switch ($i) {
							case 3:
								if (($data['match']->outsider == 1 && $data['match']->score1 >= 1) || ($data['match']->outsider == 2 && $data['match']->score2 >= 1))
									$body .= '<td class="tdgreen">Yes, won</td><td></td>';
								else $body .= '<td></td><td class="tdgreen">No, not won</td>';
								break;
							case 5:
								if (($data['match']->outsider == 1 && $data['match']->score1 >= 2) || ($data['match']->outsider == 2 && $data['match']->score2 >= 2))
									$body .= '<td class="tdgreen">Yes, won</td><td></td>';
								else $body .= '<td></td><td class="tdgreen">No, not won</td>';
								break;;
							case 7:
								if (($data['match']->outsider == 1 && $data['match']->score1 >= 3) || ($data['match']->outsider == 2 && $data['match']->score2 >= 3))
									$body .= '<td class="tdgreen">Yes, won</td><td></td>';
								else $body .= '<td></td><td class="tdgreen">No, not won</td>';
								break;
							case 9:
								if (($data['match']->outsider == 1 && $data['match']->score1 >= 4) || ($data['match']->outsider == 2 && $data['match']->score2 >= 4))
									$body .= '<td class="tdgreen">Yes, won</td><td></td>';
								else $body .= '<td></td><td class="tdgreen">No, not won</td>';
								break;
							case 11:
								if (($data['match']->outsider == 1 && $data['match']->score1 >= 5) || ($data['match']->outsider == 2 && $data['match']->score2 >= 5))
									$body .= '<td class="tdgreen">Yes, won</td><td></td>';
								else $body .= '<td></td><td class="tdgreen">No, not won</td>';
								break;
							}

							$body .= '</tr><tr class="trcenter"><td  colspan="3" class="tdborder">The match is completed</td></tr>';

						} elseif ($data['match']->state == 0 && $data['match']->cancel_state == 1)
							$body .= '<tr class="trcenter"><td  colspan="3" class="tdborder">The match is cancelled</td></tr>';

						$body .= '</table>';
						//end main bets
					$body .= '</div>
				</div>
			</div>';
		} while ($i++ < $data['match']->bestof);
	} //Конец вывода ставок с преимуществом.
$body .= '</div>'; //Accordion close

	//Max bet и ставки пользователя
	$body .= '<p>Max bet: <span id="maxbet1">';
	if($auth->logged_in()) // пользователь залогинен, выводим его макс.сумму и его ставки
	{
		$userID = $auth->get_user();

		$usermaxbet = ORM::factory('Usersmaxbet')->where("userID","=",$userID)->and_where("matchID","=",$id)->find();
		if ($usermaxbet->loaded()) {
			$body .= $usermaxbet->maxbet;
		} else {
			$body .= $data['match']->maxbet;
		}
		$body .= '</span>$<span style="float:right;">Min bet: 1.00$</span></p>';

		$body .= '<div id="tablemadebets">
		</div>';

	} else { // пользователь не залогинен
		$body .= $data['match']->maxbet.'</span>$<span style="float:right;">Min bet: 1.00$</span></p>';
	}


	//modal body end
	$body .= '</div>
	<div class="modal-footer">';
		//BEST OF
		$body .= '<p class="pcenter ';
			if ($data['match']->state == 1) {
				$body .= 'lgreen">Best of '.$data['match']->bestof;
			} elseif ($data['match']->state == 2) {
				$body .= 'lred">Best of '.$data['match']->bestof;
			} else {
				$body .= 'lgrey">Best of '.$data['match']->bestof;
			}
		$body .= '</p>';

		if ($data['match']->state == 1 ||
			$data['match']->map1_state == 1 ||
			$data['match']->map2_state == 1 ||
			$data['match']->map3_state == 1 ||
			$data['match']->map4_state == 1 ||
			$data['match']->map5_state == 1 ||
			$data['match']->map6_state == 1 ||
			$data['match']->map7_state == 1 ||
			$data['match']->map8_state == 1 ||
			$data['match']->map9_state == 1 ||
			$data['match']->map10_state == 1 ||
			$data['match']->map11_state == 1)
		{
			$body .= '<button class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="closebet();">Close</button>
			<button class="btn btn-primary" onclick="btngobets('.$id.');">Make a bet</button>';
		} else {
			$body .= '<button class="btn btn-default" data-dismiss="modal" aria-hidden="true" onclick="closebet();">Close</button>';
		}
	$body .= '</div></div></div</div>';
	echo $body;


			} else { //state != 0,1,2
				echo '';
			} //конец проверки состояния матча
		} else { //Проверка id матча
			echo '';
		}
	} else { //Проверка передачи массива GET
		echo '';
	}
} // Конец функции betswindow





	public function action_checkusermoney() //valid, -, id, logged, OK
	{
		if (isset($_POST))
		{
			// проверка money
			$post = Validation::factory($_POST)
				->rule('money', 'numeric')
				->rule('money', 'max_length', array(':value', 15));

			if ($post->check()) {
				$money = $_POST['money'];
				$auth = Auth::instance();
				if($auth->logged_in()) { //если пользователь залогинен
					$userID = $auth->get_user();
					$user = ORM::factory('Muser',array('id'=>$userID));

					if ($user->money != $money) {
						echo json_encode(array('result' => $user->money));
					} else {
						echo json_encode(array('result' => $money));
					}
				} else {
					echo json_encode(array('result' => $money));
				}
			} else {
				echo json_encode(array('result' => $money));
			}

		} else {echo json_encode(array('result' => $money));}
	}



	public function action_gobets() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in()) //залогинен, нет - вывести сообщение
			{
				// проверка id и rate
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit')
					->rule('rate1', 'not_empty')
					->rule('rate1', 'max_length', array(':value', 6))
					->rule('rate1', 'numeric')
					->rule('rate2', 'not_empty')
					->rule('rate2', 'max_length', array(':value', 6))
					->rule('rate2', 'numeric');

				$id = $_POST['id'];
				$typebet = $_POST['typebet'];
				$arrTypebet=array('1','3','5','7','9','11','101','102','103','104','105','106','107','108','109','110','111');

				if ($post->check() && $id > 0 && in_array($typebet, $arrTypebet)) {

					$mres = new Model_Resources();
					$data = array();
					$data['match'] = $mres->get_match($id);

					$sum1 = $_POST['sum1'];
					$sum2 = $_POST['sum2'];
					if ($data['match']->draw == '0.000' || $typebet > 1) {
						$draw = 0;
					} else {
						$draw = $_POST['draw']; //сумма ничьи
					}
					$rate1 = $_POST['rate1'];
					$rate2 = $_POST['rate2'];
					$ratedraw = $data['match']->draw;
					$state_sum1 = 0;
					$state_sum2 = 0;
					$state_draw = 0;

					$user_id = $auth->get_user();

					//получаем maxbet текущего пользователя
					$usermaxbet = ORM::factory('Usersmaxbet')->where("userID","=",$user_id)->and_where("matchID","=",$id)->find();
					if ($usermaxbet->loaded()) {
						$maxbet = $usermaxbet->maxbet;
					} else {
						$maxbet = $data['match']->maxbet;
					}

					$ch_state = 0;
					switch ($typebet) {
						case 1:
						case 3:
						case 5:
						case 7:
						case 9:
						case 11:
							if ($data['match']->state != 1) $ch_state = 1; break;
						case 101:
							if ($data['match']->map1_state != 1) $ch_state = 1; break;
						case 102:
							if ($data['match']->map2_state != 1) $ch_state = 1; break;
						case 103:
							if ($data['match']->map3_state != 1) $ch_state = 1; break;
						case 104:
							if ($data['match']->map4_state != 1) $ch_state = 1; break;
						case 105:
							if ($data['match']->map5_state != 1) $ch_state = 1; break;
						case 106:
							if ($data['match']->map6_state != 1) $ch_state = 1; break;
						case 107:
							if ($data['match']->map7_state != 1) $ch_state = 1; break;
						case 108:
							if ($data['match']->map8_state != 1) $ch_state = 1; break;
						case 109:
							if ($data['match']->map9_state != 1) $ch_state = 1; break;
						case 110:
							if ($data['match']->map10_state != 1) $ch_state = 1; break;
						case 111:
							if ($data['match']->map11_state != 1) $ch_state = 1; break;
					}

					if ($ch_state == 0) { //Проверка на состояние матча и карт

						if ($sum1 > 0) { //проверка на отрицательное значение
							$state_sum1 = 1; //ошибка валидации
							if (Valid::max_length($sum1, 6) && $sum1 <= $maxbet && preg_match('/^\d+.\d{2}$/', $sum1)) {
								$state_sum1 = 2; //валидация пройдена
							}
						} else {
							$sum1 = 0;
						}

						if ($sum2 > 0) {
							$state_sum2 = 1; //ошибка валидации
							if (Valid::max_length($sum2, 6) && $sum2 <= $maxbet && preg_match('/^\d+.\d{2}$/', $sum2)) {
								$state_sum2 = 2; //валидация пройдена
							}
						} else {
							$sum2 = 0;
						}

						if ($draw > 0) {
							$state_draw = 1; //ошибка валидации
							if (Valid::max_length($draw, 6) && $draw <= $maxbet && preg_match('/^\d+.\d{2}$/', $draw)) {
								$state_draw = 2; //валидация пройдена
							}
						} else {
							$draw = 0;
						}

						if ($state_sum1 == 1 || $state_sum2 == 1 || $state_draw == 1) {
							echo json_encode(array('result' => 0)); //Ошибка валидации
						} elseif ($state_sum1 == 2 || $state_sum2 == 2 || $state_draw == 2) {
							//если хотябы одна ставка прошла валидацию, а другие == 0

							$user = $mres->get_user($user_id);
							$finalsum = $sum1 + $sum2 + $draw;

							//проверка на максимальную ставку
							if ($finalsum > $maxbet) {
								echo json_encode(array('result' => 3)); // превышена максимальная ставка
							} else {
								if ($user->money >= $finalsum) {//Достаточно ли денег
									$ratestate = 0;
									//проверка на измененный коэффициент
									switch ($typebet) {
										case 1:
											if ($data['match']->rate1 != $rate1 || $data['match']->rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1'] = $data['match']->rate1;
												$data_rate['rate2'] = $data['match']->rate2;
												if ($data['match']->draw != '0.000') {
													$data_rate['draw']  = $data['match']->draw;
												}
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 101:
											if ($data['match']->map1_rate1 != $rate1 || $data['match']->map1_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1101'] = $data['match']->map1_rate1;
												$data_rate['rate2101'] = $data['match']->map1_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 102:
											if ($data['match']->map2_rate1 != $rate1 || $data['match']->map2_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1102'] = $data['match']->map2_rate1;
												$data_rate['rate2102'] = $data['match']->map2_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 103:
											if ($data['match']->map3_rate1 != $rate1 || $data['match']->map3_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1103'] = $data['match']->map3_rate1;
												$data_rate['rate2103'] = $data['match']->map3_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 104:
											if ($data['match']->map4_rate1 != $rate1 || $data['match']->map4_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1104'] = $data['match']->map4_rate1;
												$data_rate['rate2104'] = $data['match']->map4_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 105:
											if ($data['match']->map5_rate1 != $rate1 || $data['match']->map5_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1105'] = $data['match']->map5_rate1;
												$data_rate['rate2105'] = $data['match']->map5_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 106:
											if ($data['match']->map6_rate1 != $rate1 || $data['match']->map6_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1106'] = $data['match']->map6_rate1;
												$data_rate['rate2106'] = $data['match']->map6_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 107:
											if ($data['match']->map7_rate1 != $rate1 || $data['match']->map7_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1107'] = $data['match']->map7_rate1;
												$data_rate['rate2107'] = $data['match']->map7_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 108:
											if ($data['match']->map8_rate1 != $rate1 || $data['match']->map8_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1108'] = $data['match']->map8_rate1;
												$data_rate['rate2108'] = $data['match']->map8_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 109:
											if ($data['match']->map9_rate1 != $rate1 || $data['match']->map9_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1109'] = $data['match']->map9_rate1;
												$data_rate['rate2109'] = $data['match']->map9_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 110:
											if ($data['match']->map10_rate1 != $rate1 || $data['match']->map10_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1110'] = $data['match']->map10_rate1;
												$data_rate['rate2110'] = $data['match']->map10_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 111:
											if ($data['match']->map11_rate1 != $rate1 || $data['match']->map11_rate2 != $rate2) {
												$data_rate = array();
												$data_rate['rate1111'] = $data['match']->map11_rate1;
												$data_rate['rate2111'] = $data['match']->map11_rate2;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;

										case 3:
											if ($data['match']->rate1_outsider3 != $rate1 || $data['match']->rate2_outsider3 != $rate2) {
												$data_rate = array();
												$data_rate['rate13'] = $data['match']->rate1_outsider3;
												$data_rate['rate23'] = $data['match']->rate2_outsider3;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 5:
											if ($data['match']->rate1_outsider5 != $rate1 || $data['match']->rate2_outsider5 != $rate2) {
												$data_rate = array();
												$data_rate['rate15'] = $data['match']->rate1_outsider5;
												$data_rate['rate25'] = $data['match']->rate2_outsider5;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 7:
											if ($data['match']->rate1_outsider7 != $rate1 || $data['match']->rate2_outsider7 != $rate2) {
												$data_rate = array();
												$data_rate['rate17'] = $data['match']->rate1_outsider7;
												$data_rate['rate27'] = $data['match']->rate2_outsider7;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 9:
											if ($data['match']->rate1_outsider9 != $rate1 || $data['match']->rate2_outsider9 != $rate2) {
												$data_rate = array();
												$data_rate['rate19'] = $data['match']->rate1_outsider9;
												$data_rate['rate29'] = $data['match']->rate2_outsider9;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
										case 11:
											if ($data['match']->rate1_outsider11 != $rate1 || $data['match']->rate2_outsider11 != $rate2) {
												$data_rate = array();
												$data_rate['rate111'] = $data['match']->rate1_outsider11;
												$data_rate['rate211'] = $data['match']->rate2_outsider11;
												echo json_encode(array('data_rate' => $data_rate));
											} else $ratestate = 1;
											break;
									}

									if ($ratestate == 1) {
										// Все ОК, можно сохранять ставку
										$newmaxbet = $maxbet - ($sum1 + $sum2 + $draw);
										$newmaxbet = number_format($newmaxbet, 2, '.', '');

										$temp = $mres->add_bet(
											$id,
											$user_id,
											$rate1,
											$rate2,
											$ratedraw,
											$sum1,
											$sum2,
											$draw,
											$newmaxbet,
											$typebet
										);

										if ($temp['true']) {
											$mres->add_log(7, $id);
											echo json_encode(array('result' => 2, 'new_rate' => $temp));
										} else {
											echo json_encode(array('result' => 0));
										}
									}

								} else {
									//недостаточно денег
									echo json_encode(array('result' => 1));
								}
							}

						} else {
							echo json_encode(array('result' => 0));
						}

						// 0 - нас пытаются наебать, не корректное значение
						// 1 - недостаточно денег
						// date_rate - изменились коэффициенты
						// 2 - все ок
						// 3 - сумма больше чем maxbet
						// 4 - пользователь не залогинен
						// 5 - матч стартанут
					} else {
						echo json_encode(array('result' => 5)); // state != 1, матч стартанут или завершен
					}
				} else {
					echo json_encode(array('result' => 0)); // ID или Rate, не корректные.
				}
			} else {
				echo json_encode(array('result' => 4)); //Пользователь не залогинен
			}

		} else {throw HTTP_Exception::factory(404, 'File not found!');}
	}


public function action_madebets()  //valid, -, id, logged
	{
		$body = "";

		$auth = Auth::instance();

		if($auth->logged_in()) //залогинен, нет
		{
			if (isset($_POST) && Valid::not_empty($_POST))
			{
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {
					$auth = Auth::instance();
					$data = array();
					$mres = new Model_Resources();
					$data['match'] = $mres->get_match($id);
					$userID = $auth->get_user();
					$user = ORM::factory('Muser',array('id'=>$userID));
					$betsuser_for_match = ORM::factory('Mainbet')->where("userID","=",$userID)->and_where("matchID","=",$id)->find_all();
					if ($betsuser_for_match->count() > 0) { //есть ли ставки

						$ch_head = 0;
						foreach($betsuser_for_match as $itembet) {
							if ($itembet->typebet == 1 || ($itembet->typebet >= 101 && $itembet->typebet <= 111))
							{ //Ставки на матч и отдельные карты.
								if ($ch_head == 0) {
									$body .= '
									<p style="text-align:center;">Your bets:</p>
									<table class="table table-bordered table-hover table-nomargin table-condensed tblwinbet">
									<thead>
										<tr>
											<th><img src="/src/img/uploads/'.$data['match']->team1->flag->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.'</th>
											<th><img src="/src/img/uploads/'.$data['match']->team2->flag->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.'</th>
											<th>Draw</th>
											<th>Type</th>
											<th>State</th>
										</tr>
									</thead>';
									$ch_head = 1;
								}



								//выводим активные ставки
								if ($itembet->state != 2) {//все кроме отмененных ставок
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->match->state != 0){ //Матч активен
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>';
													if ($itembet->sumdraw > 0)
														$body .= "$".$itembet->sumdraw." * ".$itembet->ratedraw."<span class='label lyellow' style='float:right'>$".round($itembet->sumdraw*$itembet->ratedraw,2)."</span>";
													elseif ($itembet->ratedraw == '0.000')
														$body .= 'none';
													else $body .= $itembet->ratedraw; //ставки не было
												$body .= '</td>
												<td class="td_type">
													<span>Match</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Матч закрыт и расчитан.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->score1 > $itembet->match->score2) //матч завершен, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //ставка проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->score1 < $itembet->match->score2) //матч завершен, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //ставка проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>';
														if ($itembet->sumdraw > 0)
															if ($itembet->match->score1 == $itembet->match->score2) //ставка сыграла
																$body .= $itembet->sumdraw."*".$itembet->ratedraw."<span class='label lgreen' style='float:right'>+$".round($itembet->sumdraw*$itembet->ratedraw,2)."</span>";
															else //ставка не сыграла
																$body .= $itembet->sumdraw."*".$itembet->ratedraw."<span class='label lred' style='float:right'>-$".$itembet->sumdraw."</span>";
														elseif ($itembet->ratedraw == '0.000')
															$body .= 'none';
														else $body .= $itembet->ratedraw; //ставки не было
													$body .= '</td>
													<td class="td_type">
														<span>Match</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->score1.':'.$itembet->match->score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 101:
											if ($itembet->match->map1_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>1st map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map1_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map1_score1 > $itembet->match->map1_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map1_score1 < $itembet->match->map1_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>1st map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map1_score1.':'.$itembet->match->map1_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 102:
											if ($itembet->match->map2_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>2nd map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map2_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map2_score1 > $itembet->match->map2_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map2_score1 < $itembet->match->map2_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>2nd map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map2_score1.':'.$itembet->match->map2_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 103:
											if ($itembet->match->map3_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>3rd map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map3_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map3_score1 > $itembet->match->map3_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map3_score1 < $itembet->match->map3_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>3rd map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map3_score1.':'.$itembet->match->map3_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 104:
											if ($itembet->match->map4_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>4th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map4_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map4_score1 > $itembet->match->map4_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map4_score1 < $itembet->match->map4_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>4th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map4_score1.':'.$itembet->match->map4_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 105:
											if ($itembet->match->map5_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>5th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map5_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map5_score1 > $itembet->match->map5_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map5_score1 < $itembet->match->map5_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>5th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map5_score1.':'.$itembet->match->map5_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 106:
											if ($itembet->match->map6_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>6th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map6_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map6_score1 > $itembet->match->map6_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map6_score1 < $itembet->match->map6_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>6th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map6_score1.':'.$itembet->match->map6_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 107:
											if ($itembet->match->map7_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>7th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map7_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map7_score1 > $itembet->match->map7_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map7_score1 < $itembet->match->map7_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>7th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map7_score1.':'.$itembet->match->map7_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 108:
											if ($itembet->match->map8_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>8th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map8_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map8_score1 > $itembet->match->map8_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map8_score1 < $itembet->match->map8_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>8th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map8_score1.':'.$itembet->match->map8_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 109:
											if ($itembet->match->map9_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>9th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map9_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map9_score1 > $itembet->match->map9_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map9_score1 < $itembet->match->map9_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>9th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map9_score1.':'.$itembet->match->map9_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 110:
											if ($itembet->match->map10_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>10th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map10_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map10_score1 > $itembet->match->map10_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map10_score1 < $itembet->match->map10_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>10th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map10_score1.':'.$itembet->match->map10_score2.'</span>
													</td>
												</tr>';
											}
											break;
										case 111:
											if ($itembet->match->map11_state != 3){ //Карта активная
												$body .= '<tr>
												<td>';
													if ($itembet->sum1 > 0)
														$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставки не было на rate1
														$body .= $itembet->rate1;
												$body .= '</td>
												<td>';
													if ($itembet->sum2 > 0)
														$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставки не было
														$body .= $itembet->rate2;
												$body .= '</td>
												<td>
													none
												</td>
												<td class="td_type">
													<span>11th map</span>
												</td>
												<td class="td_state">';
												if ($itembet->match->map11_state == 1){
													if ($itembet->state == 0) {
														$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
														if ($user->set_cencelbets == 0)
															$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
													} elseif ($itembet->state == 1) {
														$body .= "<span class='sentX label'>Request sent</span>";
													} elseif ($itembet->state == 3) {
														$body .= "<span class='label lgreen'>Active (denied)</span>";
													}
												} else {
													$body .= "<span class='label lred'>Started</span>";
												}
												$body .= '</td>
												</tr>';
											} else { //Карта закрыта и расчитана.
												$body .= '<tr>
													<td>';
														if ($itembet->sum1 > 0)
															if ($itembet->match->map11_score1 > $itembet->match->map11_score2) //карта завершена, ставка сыграла
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //карта проиграна, матч завершен.
																$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
														else //ставки не было на rate1
															$body .= $itembet->rate1;
													$body .= '</td>
													<td>';
														if ($itembet->sum2 > 0)
															if ($itembet->match->map11_score1 < $itembet->match->map11_score2) //карта завершена, ставка сыграла
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //карта проиграна, матч закрыт
																$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
														else //ставки не было
															$body .= $itembet->rate2;
													$body .= '</td>
													<td>
														none
													</td>
													<td class="td_type">
														<span>11th map</span>
													</td>
													<td class="td_state">
														<span class="label">Close '.$itembet->match->map11_score1.':'.$itembet->match->map11_score2.'</span>
													</td>
												</tr>';
											}
											break;
									}//switch
								} elseif ($itembet->state == 2) { //выводим отмененные ставки
									$body .= '<tr>
										<td>';
											if ($itembet->sum1 > 0)
												//Возврат денег
												$body .= $itembet->rate1."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sum1."</span>";
											else //ставки не было на rate1
												$body .= $itembet->rate1;

										$body .= '</td>
										<td>';
											if ($itembet->sum2 > 0)
												//Возврат денег
												$body .= $itembet->rate2."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sum2."</span>";
											else //ставки не было
												$body .= $itembet->rate2;

										$body .= '</td>
										<td>';
											if ($itembet->sumdraw > 0)
												$body .= $itembet->ratedraw."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sumdraw."</span>";
											elseif ($itembet->ratedraw == '0.000') //ставки не было
												$body .= 'none';
											else $body .= $itembet->ratedraw;
										$body .= '</td>
										<td class="td_type">';
										switch ($itembet->typebet) {
											case 1:
												$body .= '<span>Match</span>';
												break;
											case 101:
												$body .= '<span>1st map</span>';
												break;
											case 102:
												$body .= '<span>2nd map</span>';
												break;
											case 103:
												$body .= '<span>3rd map</span>';
												break;
											case 104:
												$body .= '<span>4th map</span>';
												break;
											case 105:
												$body .= '<span>5th map</span>';
												break;
											case 106:
												$body .= '<span>6th map</span>';
												break;
											case 107:
												$body .= '<span>7th map</span>';
												break;
											case 108:
												$body .= '<span>8th map</span>';
												break;
											case 109:
												$body .= '<span>9th map</span>';
												break;
											case 110:
												$body .= '<span>10th map</span>';
												break;
											case 111:
												$body .= '<span>11th map</span>';
												break;
										}
										$body .= '
										</td>
										<td class="td_state">
											<span class="cancelbetYES label">Cancelled</span>
										</td>
									</tr>';
								}
							} //if typebet
						} //foreach

						//Вывод отдельной таблицы для ставок на аутсайдера. Yes и No
						$ch_head2 = 0;
						foreach($betsuser_for_match as $itembet) {
							if ($itembet->typebet == 3 || $itembet->typebet == 5 || $itembet->typebet == 7 || $itembet->typebet == 9 || $itembet->typebet == 11) {
								if ($ch_head2 == 0) {
									if ($ch_head == 1) {
										$body .= '</table>';
									}
									$body .= '<p style="text-align:center; margin-top:20px;">';
										if ($data['match']->outsider == 1) {
											$body .= '<span><img src="/src/img/uploads/'.$data['match']->team1->logotype->icon.'"/> '.$data['match']->team1->shortname.$data['match']->player1->name.' will win...</span>';
										} elseif ($data['match']->outsider == 2) {
											$body .= '<span><img src="/src/img/uploads/'.$data['match']->team2->logotype->icon.'"/> '.$data['match']->team2->shortname.$data['match']->player2->name.' will win...</span>';
										}
									$body .= '</p>';
									$body .= '<table class="table table-bordered table-hover table-nomargin table-condensed tblwinbet">
									<thead>
										<tr>
											<th>Map(s)</th>
											<th>Yes</th>
											<th>No</th>
											<th>State</th>
										</tr>
									</thead>';
									$ch_head2 = 1;
								}
								$body .= '<tr>
									<td class="td_maps">';
									if ($itembet->typebet == 3)
										$body .= 'one map?';
									elseif ($itembet->typebet == 5)
										$body .= 'two maps?';
									elseif ($itembet->typebet == 7)
										$body .= 'three maps?';
									elseif ($itembet->typebet == 9)
										$body .= 'four maps?';
									elseif ($itembet->typebet == 11)
										$body .= 'five maps?';
								$body .= '</td>
								';
								//выводим активные ставки
								if ($itembet->state != 2) {//все кроме отмененных ставок
									if ($itembet->match->state != 0){
										$body .= '
										<td>';
											if ($itembet->sum1 > 0)
												//матч активен, старт
												$body .= "$".$itembet->sum1." * ".$itembet->rate1."<span class='label lyellow' style='float:right'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
											else //ставки не было на rate1
												$body .= $itembet->rate1;
										$body .= '</td>
										<td>';
											if ($itembet->sum2 > 0)
												//матч активен, старт
												$body .= "$".$itembet->sum2." * ".$itembet->rate2."<span class='label lyellow' style='float:right'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
											else //ставки не было
												$body .= $itembet->rate2;
										$body .= '</td>';
									} else { //матч закрыт.
										switch ($itembet->typebet) {
											case 3:
												$body .= '<td>';
												if ($itembet->sum1 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1>=1) || ($itembet->match->outsider==2 && $itembet->match->score2>=1))
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было
													$body .= $itembet->rate1;

												$body .= '</td><td>';
												if ($itembet->sum2 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1<1)|| ($itembet->match->outsider==2 && $itembet->match->score2<1))
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													$body .= $itembet->rate2;
												$body .= '</td>';
												break;
											case 5:
												$body .= '<td>';
												if ($itembet->sum1 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1>=2) || ($itembet->match->outsider==2 && $itembet->match->score2>=2))
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было
													$body .= $itembet->rate1;

												$body .= '</td><td>';
												if ($itembet->sum2 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1<2)|| ($itembet->match->outsider==2 && $itembet->match->score2<2))
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													$body .= $itembet->rate2;
												$body .= '</td>';
												break;
											case 7:
												$body .= '<td>';
												if ($itembet->sum1 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1>=3) || ($itembet->match->outsider==2 && $itembet->match->score2>=3))
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было
													$body .= $itembet->rate1;

												$body .= '</td><td>';
												if ($itembet->sum2 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1<3)|| ($itembet->match->outsider==2 && $itembet->match->score2<3))
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													$body .= $itembet->rate2;
												$body .= '</td>';
												break;
											case 9:
												$body .= '<td>';
												if ($itembet->sum1 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1>=4) || ($itembet->match->outsider==2 && $itembet->match->score2>=4))
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было
													$body .= $itembet->rate1;

												$body .= '</td><td>';
												if ($itembet->sum2 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1<4)|| ($itembet->match->outsider==2 && $itembet->match->score2<4))
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													$body .= $itembet->rate2;
												$body .= '</td>';
												break;
											case 11:
												$body .= '<td>';
												if ($itembet->sum1 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1>=5) || ($itembet->match->outsider==2 && $itembet->match->score2>=5))
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lgreen' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else
														$body .= "$".$itembet->sum1."*".$itembet->rate1."<span class='label lred' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было
													$body .= $itembet->rate1;

												$body .= '</td><td>';
												if ($itembet->sum2 > 0)
													if (($itembet->match->outsider==1 && $itembet->match->score1<5)|| ($itembet->match->outsider==2 && $itembet->match->score2<5))
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lgreen' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else
														$body .= $itembet->sum2."*".$itembet->rate2."<span class='label lred' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													$body .= $itembet->rate2;
												$body .= '</td>';
												break;
										}
									}


									$body .= '<td class="td_state">';
									if ($itembet->match->state == 1){
										if ($itembet->state == 0) {
											$body .= "<span class='label lgreen' id='req-$itembet->id'>Active</span>";
											if ($user->set_cencelbets == 0)
												$body .= "<span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbetwin($itembet->id, $id);' id='xwin-$itembet->id'>X</span>";
										} elseif ($itembet->state == 1) {
											$body .= "<span class='sentX label'>Request sent</span>";
										} elseif ($itembet->state == 3) {
											$body .= "<span class='label lgreen'>Active (denied)</span>";
										}
									} elseif ($itembet->match->state == 0) {
										$body .= "<span class='label'>Close. ";
										switch ($itembet->typebet) {
											case 3:
												if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 1) ||
												($itembet->match->outsider == 2 && $itembet->match->score2 >= 1)) $body .= 'Yes, won';
												else $body .= 'No, not won';
												break;
											case 5:
												if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 2) ||
												($itembet->match->outsider == 2 && $itembet->match->score2 >= 2)) $body .= 'Yes, won';
												else $body .= 'No, not won';
												break;
											case 7:
												if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 3) ||
												($itembet->match->outsider == 2 && $itembet->match->score2 >= 3)) $body .= 'Yes, won';
												else $body .= 'No, not won';
												break;
											case 9:
												if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 4) ||
												($itembet->match->outsider == 2 && $itembet->match->score2 >= 4)) $body .= 'Yes, won';
												else $body .= 'No, not won';
												break;
											case 11:
												if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 5) ||
												($itembet->match->outsider == 2 && $itembet->match->score2 >= 5)) $body .= 'Yes, won';
												else $body .= 'No, not won';
												break;
										}
										$body .= '</span>';
									} else {
										$body .= "<span class='label lred'>Started</span>";
									}
									$body .= '</td>';
								} elseif ($itembet->state == 2) { //выводим отмененные ставки
									$body .= '
									<td>';
										if ($itembet->sum1 > 0)
											//Возврат денег
											$body .= $itembet->rate1."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sum1."</span>";
										else //ставки не было на rate1
											$body .= $itembet->rate1;
									$body .= '</td>
									<td>';
										if ($itembet->sum2 > 0)
											//Возврат денег
											$body .= $itembet->rate2."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sum2."</span>";
										else //ставки не было
											$body .= $itembet->rate2;

									$body .= '</td>
									<td class="td_state">
										<span class="cancelbetYES label">Cancelled</span>
									</td>';
								}
								$body .= '</tr>';
							} //if typebet
						} //foreach

						if ($ch_head2 == 1)
							$body .= '</table>';
						elseif ($ch_head2 == 0 && $ch_head == 1)
							$body .= '</table>';

					} //есть ли ставки
				} // check id
			} //isset get
		} //logged in
		echo $body;
	}



	public function action_requestcancelbet() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$auth = Auth::instance();

			if($auth->logged_in()) //залогинен, нет
			{
				// проверка id bet
				$post = Validation::factory($_POST)
					->rule('id', 'max_length', array(':value', 10))
					->rule('id', 'not_empty')
					->rule('id', 'digit');

				$id = $_POST['id'];

				if ($post->check() && $id > 0) {

					//относится ли ставка к данному аккаунту
					$user_id = $auth->get_user();
					$bet = ORM::factory('Mainbet')->where("id","=",$id)->and_where("userID","=",$user_id)->and_where("state","=",0)->find();
					if ($bet->loaded()) {
						$user = ORM::factory('Muser',array('id'=>$user_id));
						if ($user->set_cencelbets == 0) {
							$ch_active = 0;
							switch ($bet->typebet) { //активный ли это матч или карта?
								case 1:
								case 3:
								case 5:
								case 7:
								case 9:
								case 11:
									if ($bet->match->state != 1)  $ch_active = 1; //матч не активный
									break;
								case 101:
									if ($bet->match->map1_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 102:
									if ($bet->match->map2_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 103:
									if ($bet->match->map3_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 104:
									if ($bet->match->map4_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 105:
									if ($bet->match->map5_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 106:
									if ($bet->match->map6_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 107:
									if ($bet->match->map7_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 108:
									if ($bet->match->map8_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 109:
									if ($bet->match->map9_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 110:
									if ($bet->match->map10_state != 1)  $ch_active = 1; //матч не активный
									break;
								case 111:
									if ($bet->match->map11_state != 1)  $ch_active = 1; //матч не активный
									break;
							}

							if ($ch_active == 0) {
								$mres = new Model_Resources();
								if ($mres->request_cancelbet($id)) {
									echo json_encode(array('result' => 1));
								} else {
									echo json_encode(array('result' => 0)); //ошибка сохранения
								}
							} else {
								echo json_encode(array('result' => 0)); //матч не активный
							}
						} else {
							echo json_encode(array('result' => 0)); //У пользователя отключена возможность отмены ставки
						}
					} else {
						echo json_encode(array('result' => 0)); //Ставка не данного пользователя
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


	public function action_setDisciplines()  //valid, -, id, logged, OK
	{
		if (isset($_POST))
		{
			$post = Validation::factory($_POST)
				->rule('id', 'max_length', array(':value', 100))
				->rule('id', 'min_length', array(':value', 0))
				->rule('id', 'regex', array(':value', '/^[,0-9]+$/'));

			if ($post->check()) {

				$auth = Auth::instance();
				$id = Arr::get($_POST, 'id');

				if($auth->logged_in())
				{
					$user_id = $auth->get_user();
					$mres = new Model_Resources();
					$mres->update_user_disciplines($id,$user_id);
					$_SESSION['disciplines_user'] = explode(",", $id);
					echo json_encode(array('result' => TRUE));
				}
				else {
					$_SESSION['disciplines_user'] = explode(",", $id);
					echo json_encode(array('result' => TRUE));
				}
			} else {
				echo json_encode(array('result' => FALSE));
			}
		} else {echo json_encode(array('result' => FALSE));}
	}


	public function action_verifymail()  //valid, -, id, logged
	{

		$auth = Auth::instance();

		if($auth->logged_in())
		{
			$user_id = $auth->get_user();

			$mres = new Model_Resources();
			$mres->update_genhash($user_id);

			echo json_encode(array('result' => TRUE));
		} else {
			echo json_encode(array('result' => FALSE));
		}
	}


	public function action_currentpassword() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$post = $_POST['current_password'];
			$auth = Auth::instance();

			if($auth->logged_in())
			{
				$user_id = $auth->get_user();
				$mres = new Model_Resources();

				$check = $mres->check_currentpassword($user_id, $post);
				if($check) {
					echo json_encode(array('result' => 1));
				} else {
					echo json_encode(array('result' => 0));
				}
			} else {
				echo json_encode(array('result' => 0));
			}

		} else {throw HTTP_Exception::factory(404, 'File not found!');}
	}


	public function action_signuppassword() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$post = $_POST['signup_password'];
			if  (!Valid::min_length($post, 5))
			{
				echo json_encode(array('result' => 1));

			} elseif (!Valid::max_length($post, 254)) {

				echo json_encode(array('result' => 2));

			} else {

				echo json_encode(array('result' => 3));
			}

		} else {	throw HTTP_Exception::factory(404, 'File not found!');}
	}


	public function action_signuplogin() //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$post = $_POST['signup_login'];
			$muser = new Model_Muser();
			if (!Valid::min_length($post, 3))
			{
				echo json_encode(array('result' => 1));

			} elseif (!Valid::max_length($post, 254)) {

				echo json_encode(array('result' => 2));

			} elseif (!Valid::alpha_dash($post)) {

				echo json_encode(array('result' => 3));

			} elseif (!$muser->login_uniq($post)) {

				echo json_encode(array('result' => 4));

			} else {

				echo json_encode(array('result' => 5));

			}

		} else {	throw HTTP_Exception::factory(404, 'File not found!');}
	}



	public function action_signupemail()  //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$post = $_POST['signup_email'];
			$muser = new Model_Muser();
			if  (!Valid::max_length($post, 254))
			{
				echo json_encode(array('result' => 1));

			} elseif (!Valid::email($post)) {

				echo json_encode(array('result' => 2));

			} elseif (!$muser->email_uniq($post)) {

				echo json_encode(array('result' => 3));

			} else {

				echo json_encode(array('result' => 4));
			}

		} else {	throw HTTP_Exception::factory(404, 'File not found!');}
	}


	public function action_usermessage()  //valid, -, id, logged
	{
		if (isset($_POST) && Valid::not_empty($_POST))
		{
			$post = $_POST['usermessage'];
			$auth = Auth::instance();

			if($auth->logged_in()) //Залогинен, можно сохранять
			{
				$user_id = $auth->get_user();

				$mres = new Model_Resources();
				if  (!Valid::max_length($post, 5000)) //max 5000 символов
				{
					echo json_encode(array('result' => 3));
				}
				elseif (!Valid::not_empty($post)) //не пустое
				{
					echo json_encode(array('result' => 4));
				} else {
					$check = $mres->savemessage($user_id, $post);
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


