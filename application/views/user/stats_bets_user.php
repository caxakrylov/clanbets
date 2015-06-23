	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">All my bets</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->
	            	<div class="row">
	                	<div class="col-lg-12">

					<? if ($mainbets->count() > 0) { //если есть ставки?>
						<h4 style="margin-top:20px;">
							<i class="fa fa-th-list fa-fw"></i>&nbsp;Bets on matches and maps
						</h4>
						<div class="table-responsive">
                                			<table class="table table-bordered table-hover table-nomargin table-condensed" id="dataTable">
		                                    	<thead>
		                                       	<tr>
		                                       		<th style="display:none;"></th>
										<th>Match (<? if ($_SESSION['utc_user'] >= 0) {echo '+'.trim($_SESSION['utc_user']);} else {echo $_SESSION['utc_user'];}?>)</th>
										<th>Discipline</th>
										<th>Type</th>
										<th>Player #1</th>
										<th>Player #2</th>
										<th>Draw</th>
										<th>State</th>
		                                        	</tr>
		                                    	</thead>
								<tbody>
									<? foreach($mainbets as $itembet){
										if ($itembet->typebet == 1 || ($itembet->typebet >= 101 && $itembet->typebet <= 111))
										if ($itembet->state != 2) {//все кроме отмененных ставок
										?>
											<tr>
												<td style="display:none;"></td>
												<?
													$UTCmatch = $offset+$itembet->match->datetime; //UTC match

													if (date('d.m.Y',$UTCmatch) == $UTCuser) {
														echo '<td class="td_utc">'.date('H:i',$UTCmatch).' today</td>';
													} else {
														echo '<td class="td_utc">'.date('d.m.y H:i',$UTCmatch).'</td>';
													}
												?>


												<td class="td_disc"><?=$itembet->match->discipline->shortname?></td>

												<td class="td_type">
													<? switch ($itembet->typebet) {
														case 1:
															echo '<span>Match</span>';
															break;
														case 101:
															echo '<span>1st map</span>';
															break;
														case 102:
															echo '<span>2nd map</span>';
															break;
														case 103:
															echo '<span>3rd map</span>';
															break;
														case 104:
															echo '<span>4th map</span>';
															break;
														case 105:
															echo '<span>5th map</span>';
															break;
														case 106:
															echo '<span>6th map</span>';
															break;
														case 107:
															echo '<span>7th map</span>';
															break;
														case 108:
															echo '<span>8th map</span>';
															break;
														case 109:
															echo '<span>9th map</span>';
															break;
														case 110:
															echo '<span>10th map</span>';
															break;
														case 111:
															echo '<span>11th map</span>';
															break;
													} ?>
												</td>

												<td class="td_player">
													<? if ($itembet->sum1 > 0)
														switch ($itembet->typebet) {
															case 1:
																if ($itembet->match->score1 > $itembet->match->score2 && $itembet->match->state == 0) //матч завершен, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->state != 0) //матч активен, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 101:
																if ($itembet->match->map1_score1 > $itembet->match->map1_score2 && $itembet->match->map1_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map1_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 102:
																if ($itembet->match->map2_score1 > $itembet->match->map2_score2 && $itembet->match->map2_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map2_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 103:
																if ($itembet->match->map3_score1 > $itembet->match->map3_score2 && $itembet->match->map3_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map3_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 104:
																if ($itembet->match->map4_score1 > $itembet->match->map4_score2 && $itembet->match->map4_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map4_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 105:
																if ($itembet->match->map5_score1 > $itembet->match->map5_score2 && $itembet->match->map5_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map5_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 106:
																if ($itembet->match->map6_score1 > $itembet->match->map6_score2 && $itembet->match->map6_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map6_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 107:
																if ($itembet->match->map7_score1 > $itembet->match->map7_score2 && $itembet->match->map7_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map7_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 108:
																if ($itembet->match->map8_score1 > $itembet->match->map8_score2 && $itembet->match->map8_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map8_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 109:
																if ($itembet->match->map9_score1 > $itembet->match->map9_score2 && $itembet->match->map9_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map9_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 110:
																if ($itembet->match->map10_score1 > $itembet->match->map10_score2 && $itembet->match->map10_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map10_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
															case 111:
																if ($itembet->match->map11_score1 > $itembet->match->map11_score2 && $itembet->match->map11_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																elseif ($itembet->match->map11_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																else //ставка проиграна, матч завершен.
																	echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																break;
														}

													else //ставки не было на rate1
														echo "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1."</span>";
													?>
												 </td>

												<td class="td_player">
													<? if ($itembet->sum2 > 0)
														switch ($itembet->typebet) {
															case 1:
																if ($itembet->match->score1 < $itembet->match->score2 && $itembet->match->state == 0) //матч завершен, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->state != 0) //матч активен, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 101:
																if ($itembet->match->map1_score1 < $itembet->match->map1_score2 && $itembet->match->map1_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map1_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 102:
																if ($itembet->match->map2_score1 < $itembet->match->map2_score2 && $itembet->match->map2_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map2_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 103:
																if ($itembet->match->map3_score1 < $itembet->match->map3_score2 && $itembet->match->map3_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map3_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 104:
																if ($itembet->match->map4_score1 < $itembet->match->map4_score2 && $itembet->match->map4_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map4_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 105:
																if ($itembet->match->map5_score1 < $itembet->match->map5_score2 && $itembet->match->map5_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map5_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 106:
																if ($itembet->match->map6_score1 < $itembet->match->map6_score2 && $itembet->match->map6_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map6_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 107:
																if ($itembet->match->map7_score1 < $itembet->match->map7_score2 && $itembet->match->map7_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map7_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 108:
																if ($itembet->match->map8_score1 < $itembet->match->map8_score2 && $itembet->match->map8_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map8_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 109:
																if ($itembet->match->map9_score1 < $itembet->match->map9_score2 && $itembet->match->map9_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map9_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 110:
																if ($itembet->match->map10_score1 < $itembet->match->map10_score2 && $itembet->match->map10_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map10_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
															case 111:
																if ($itembet->match->map11_score1 < $itembet->match->map11_score2 && $itembet->match->map11_state == 3) //карта завершена, ставка сыграла
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																elseif ($itembet->match->map11_state != 3) //карта активна, старт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																else //ставка проиграна, матч закрыт
																	echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																break;
														}

													else //ставки не было
														echo "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2."</span>";
													?>
												</td>

												<td class="td_draw">
													<? if ($itembet->sumdraw > 0)
														if ($itembet->match->score1 == $itembet->match->score2 && $itembet->match->state == 0) //матч завершен
															echo "<span class='lefttext'>".$itembet->ratedraw." * <span class='greentext'>$".$itembet->sumdraw."</span></span><span class='label lgreen'>+$".round($itembet->sumdraw*$itembet->ratedraw,2)."</span>";
														elseif ($itembet->match->state != 0) //матч активен, старт
															echo "<span class='lefttext'>".$itembet->ratedraw." * <span class='greentext'>$".$itembet->sumdraw."</span></span><span class='label lnew'>$".round($itembet->sumdraw*$itembet->ratedraw,2)."</span>";
														else //ставка не сыграла
															echo "<span class='lefttext'>".$itembet->ratedraw." * <span class='greentext'>$".$itembet->sumdraw."</span></span><span class='label lred'>-$".$itembet->sumdraw."</span>";
													elseif ($itembet->match->draw == '0.000' || $itembet->typebet != 1) //ставки не было
														echo "<span class='lefttext'>none</span>";
													else echo "<span class='lefttext'>".$itembet->ratedraw."</span>";
													?>
												</td>

												<td class="td_state">

													<? switch ($itembet->typebet) {
														case 1:
															if ($itembet->match->state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->score1.':'.$itembet->match->score2."</span>";
															break;
														case 101:
															if ($itembet->match->map1_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map1_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map1_score1.':'.$itembet->match->map1_score2."</span>";
															break;
														case 102:
															if ($itembet->match->map2_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map2_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map2_score1.':'.$itembet->match->map2_score2."</span>";
															break;
														case 103:
															if ($itembet->match->map3_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map3_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map3_score1.':'.$itembet->match->map3_score2."</span>";
															break;
														case 104:
															if ($itembet->match->map4_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map4_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map4_score1.':'.$itembet->match->map4_score2."</span>";
															break;
														case 105:
															if ($itembet->match->map5_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map5_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map5_score1.':'.$itembet->match->map5_score2."</span>";
															break;
														case 106:
															if ($itembet->match->map6_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map6_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map6_score1.':'.$itembet->match->map6_score2."</span>";
															break;
														case 107:
															if ($itembet->match->map7_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map7_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map7_score1.':'.$itembet->match->map7_score2."</span>";
															break;
														case 108:
															if ($itembet->match->map8_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map8_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map8_score1.':'.$itembet->match->map8_score2."</span>";
															break;
														case 109:
															if ($itembet->match->map9_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map9_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map9_score1.':'.$itembet->match->map9_score2."</span>";
															break;
														case 110:
															if ($itembet->match->map10_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map10_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map10_score1.':'.$itembet->match->map10_score2."</span>";
															break;
														case 111:
															if ($itembet->match->map11_state == 1){
																if ($itembet->state == 0) {
																	echo "<span class='label lgreen'>Active</span><span class='cancelX label' title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
																} elseif ($itembet->state == 1) {
																	echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
																} elseif ($itembet->state == 3) {
																	echo "<span class='label lgreen'>Active (denied)</span>";
																}
															}
															elseif ($itembet->match->map11_state == 2) echo "<span class='label lred'>Started</span>";
															else echo "<span class='label'>Close ".$itembet->match->map11_score1.':'.$itembet->match->map11_score2."</span>";
															break;
													} ?>


												</td>
											</tr>

										<?} elseif ($itembet->state == 2) {?>

											<tr>
												<td style="display:none;"></td>
												<?
													$UTCmatch = $offset+$itembet->match->datetime; //UTC match

													if (date('d.m.Y',$UTCmatch) == $UTCuser) {
														echo '<td class="td_utc">'.date('H:i',$UTCmatch).' today</td>';
													} else {
														echo '<td class="td_utc">'.date('d.m.y H:i',$UTCmatch).'</td>';
													}
												?>
												<td class="td_disc"><?=$itembet->match->discipline->shortname?></td>

												<td class="td_type">
													<? switch ($itembet->typebet) {
														case 1:
															echo '<span>Match</span>';
															break;
														case 101:
															echo '<span>1st map</span>';
															break;
														case 102:
															echo '<span>2nd map</span>';
															break;
														case 103:
															echo '<span>3rd map</span>';
															break;
														case 104:
															echo '<span>4th map</span>';
															break;
														case 105:
															echo '<span>5th map</span>';
															break;
														case 106:
															echo '<span>6th map</span>';
															break;
														case 107:
															echo '<span>7th map</span>';
															break;
														case 108:
															echo '<span>8th map</span>';
															break;
														case 109:
															echo '<span>9th map</span>';
															break;
														case 110:
															echo '<span>10th map</span>';
															break;
														case 111:
															echo '<span>11th map</span>';
															break;
													} ?>
												</td>

												<td class="td_player">
													<? if ($itembet->sum1 > 0)
														 //Возврат денег
														echo  "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label cancelbetYES'>back $".$itembet->sum1."</span>";
													else //ставки не было на rate1
														echo  "<span class='lefttext'>".$itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1."</span>";
													?>
												 </td>
												<td class="td_player">
													<? if ($itembet->sum2 > 0)
														 //Возврат денег
														echo  "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label cancelbetYES'>back $".$itembet->sum2."</span>";
													else //ставки не было
														echo  "<span class='lefttext'>".$itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2."</span>";
													?>
												</td>
												<td class="td_draw">
													<? if ($itembet->sumdraw > 0)
														echo "<span class='lefttext'>".$itembet->ratedraw." * <span class='greentext'>$".$itembet->sumdraw."</span></span><span class='label cancelbetYES'>back $".$itembet->sumdraw."</span>";
													elseif ($itembet->match->draw == '0.000' || $itembet->typebet != 1) //ставки не было
														echo "<span class='lefttext'>none</span>";
													else echo "<span class='lefttext'>".$itembet->ratedraw."</span>";
													?>
												</td>


												<td class="td_state">
													<span class='cancelbetYES label'>Cancelled</span>
												</td>
											</tr>
										<?}?>
									<?}?>
								</tbody>
                                			</table>
                            		</div>
                            		<!-- /.table-responsive -->





                            		<div class="dline"></div>

						<h4>
							<i class="fa fa-th-list fa-fw"></i>&nbsp;Betting to win a few maps
						</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-nomargin table-condensed" id="dataTable2">
								<thead>
									<tr>
										<th style="display:none;"></th>
										<th>Match (<? if ($_SESSION['utc_user'] >= 0) {echo '+'.trim($_SESSION['utc_user']);} else {echo $_SESSION['utc_user'];}?>)</th>
										<th>Bo</th>
										<th>Player</th>
										<th>Map(s)</th>
										<th>Yes</th>
										<th>No</th>
										<th>Discipline</th>
										<th>State</th>
									</tr>
								</thead>
								<tbody>
									<? foreach($mainbets as $itembet){
										if ($itembet->typebet == 3 || $itembet->typebet == 5 || $itembet->typebet == 7 || $itembet->typebet == 9 || $itembet->typebet == 11) {
										?>
											<tr>
												<td style="display:none;"></td>
												<?
													$UTCmatch = $offset+$itembet->match->datetime; //UTC match

													if (date('d.m.Y',$UTCmatch) == $UTCuser) {
														echo '<td class="td_utc">'.date('H:i',$UTCmatch).' today</td>';
													} else {
														echo '<td class="td_utc">'.date('d.m.y H:i',$UTCmatch).'</td>';
													}
												?>

												<td class="td_bof">Bo<?=$itembet->match->bestof?></td>

												<td class="td_player"><?
													if ($itembet->match->outsider == 1) {
														echo $itembet->match->team1->shortname.$itembet->match->player1->name;
													} elseif ($itembet->match->outsider == 2) {
														echo $itembet->match->team2->shortname.$itembet->match->player2->name;
													}
												?>
												</td>

												<td class="td_maps">
												<?
													if ($itembet->typebet == 3)
														echo 'one map?';
													elseif ($itembet->typebet == 5)
														echo 'two maps?';
													elseif ($itembet->typebet == 7)
														echo 'three maps?';
													elseif ($itembet->typebet == 9)
														echo 'four maps?';
													elseif ($itembet->typebet == 11)
														echo 'five maps?';
												?>
												</td>

												<?
												//выводим активные ставки
												if ($itembet->state != 2) {//все кроме отмененных ставок
													if ($itembet->match->state != 0){ //матч не закрыт
														echo '
														<td class="td_yesno">';
															if ($itembet->sum1 > 0)
																//матч активен, старт
																echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lnew'>$".round($itembet->sum1*$itembet->rate1,2)."</span>";
															else //ставки не было на rate1
																echo "<span class='lefttext'>".$itembet->rate1."</span>";

														echo '</td><td class="td_yesno">';

															if ($itembet->sum2 > 0)
																//матч активен, старт
																echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lnew'>$".round($itembet->sum2*$itembet->rate2,2)."</span>";
															else //ставки не было
																echo "<span class='lefttext'>".$itembet->rate2."</span>";
														echo '</td>';
													} else { //матч закрыт.
														switch ($itembet->typebet) {
															case 3:
																echo '<td class="td_yesno">';
																if ($itembet->sum1 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1>=1) || ($itembet->match->outsider==2 && $itembet->match->score2>=1))
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate1."</span>";

																echo '</td><td class="td_yesno">';

																if ($itembet->sum2 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1<1)|| ($itembet->match->outsider==2 && $itembet->match->score2<1))
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate2."</span>";
																echo '</td>';
																break;
															case 5:
																echo '<td class="td_yesno">';
																if ($itembet->sum1 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1>=2) || ($itembet->match->outsider==2 && $itembet->match->score2>=2))
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate1."</span>";

																echo '</td><td class="td_yesno">';

																if ($itembet->sum2 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1<2)|| ($itembet->match->outsider==2 && $itembet->match->score2<2))
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate2."</span>";
																echo '</td>';
																break;
															case 7:
																echo '<td class="td_yesno">';
																if ($itembet->sum1 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1>=3) || ($itembet->match->outsider==2 && $itembet->match->score2>=3))
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate1."</span>";

																echo '</td><td class="td_yesno">';

																if ($itembet->sum2 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1<3)|| ($itembet->match->outsider==2 && $itembet->match->score2<3))
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate2."</span>";
																echo '</td>';
																break;
															case 9:
																echo '<td class="td_yesno">';
																if ($itembet->sum1 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1>=4) || ($itembet->match->outsider==2 && $itembet->match->score2>=4))
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate1."</span>";

																echo '</td><td class="td_yesno">';

																if ($itembet->sum2 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1<4)|| ($itembet->match->outsider==2 && $itembet->match->score2<4))
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate2."</span>";
																echo '</td>';
																break;
															case 11:
																echo '<td class="td_yesno">';
																if ($itembet->sum1 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1>=5) || ($itembet->match->outsider==2 && $itembet->match->score2>=5))
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lgreen'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate1." * <span class='greentext'>$".$itembet->sum1."</span></span><span class='label lred'>-$".$itembet->sum1."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate1."</span>";

																echo '</td><td class="td_yesno">';

																if ($itembet->sum2 > 0)
																	if (($itembet->match->outsider==1 && $itembet->match->score1<5)|| ($itembet->match->outsider==2 && $itembet->match->score2<5))
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lgreen'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
																	else
																		echo "<span class='lefttext'>".$itembet->rate2." * <span class='greentext'>$".$itembet->sum2."</span></span><span class='label lred'>-$".$itembet->sum2."</span>";
																else //ставки не было
																	echo "<span class='lefttext'>".$itembet->rate2."</span>";
																echo '</td>';
																break;
														}
													}


													echo '<td class="td_disc">'.$itembet->match->discipline->shortname.'</td>';
													echo '<td class="td_state">';
													if ($itembet->match->state == 1){

														if ($itembet->state == 0) {
															echo "<span class='label lgreen'>Active</span><span class='cancelX label' rel='tooltip' data-original-title='Request to cancel bets' onclick='request_cancelbet($itembet->id);' id='x-$itembet->id'>X</span>";
														} elseif ($itembet->state == 1) {
															echo "<span class='label lgreen'>Active</span><span class='sentX label'>Sent</span>";
														} elseif ($itembet->state == 3) {
															echo "<span class='label lgreen'>Active (denied)</span>";
														}

													} elseif ($itembet->match->state == 0) {
														echo "<span class='label'>Close. ";
														switch ($itembet->typebet) {
															case 3:
																if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 1) ||
																($itembet->match->outsider == 2 && $itembet->match->score2 >= 1)) echo 'Yes, won';
																else echo 'No, not won';
																break;
															case 5:
																if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 2) ||
																($itembet->match->outsider == 2 && $itembet->match->score2 >= 2)) echo 'Yes, won';
																else echo 'No, not won';
																break;
															case 7:
																if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 3) ||
																($itembet->match->outsider == 2 && $itembet->match->score2 >= 3)) echo 'Yes, won';
																else echo 'No, not won';
																break;
															case 9:
																if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 4) ||
																($itembet->match->outsider == 2 && $itembet->match->score2 >= 4)) echo 'Yes, won';
																else echo 'No, not won';
																break;
															case 11:
																if (($itembet->match->outsider == 1 && $itembet->match->score1 >= 5) ||
																($itembet->match->outsider == 2 && $itembet->match->score2 >= 5)) echo 'Yes, won';
																else echo 'No, not won';
																break;
														}
														echo '</span>';
													} else {
														echo "<span class='label lred'>Started</span>";
													}
													echo '</td>';
												} elseif ($itembet->state == 2) { //выводим отмененные ставки
													echo '
													<td class="td_yesno">';
														if ($itembet->sum1 > 0)
															//Возврат денег
															echo "<span class='lefttext'>".$itembet->rate1."</span><span class='label cancelbetYES'>back $".$itembet->sum1."</span>";
														else //ставки не было на rate1
															echo "<span class='lefttext'>".$itembet->rate1."</span>";
													echo '</td>
													<td class="td_yesno">';
														if ($itembet->sum2 > 0)
															//Возврат денег
															echo "<span class='lefttext'>".$itembet->rate2."</span><span class='label cancelbetYES'>back $".$itembet->sum2."</span>";
														else //ставки не было
															echo "<span class='lefttext'>".$itembet->rate2."</span>";

													echo '</td>
													<td class="td_disc">'.$itembet->match->discipline->shortname.'</td>
													<td class="td_state">
														<span class="cancelbetYES label">Cancelled</span>
													</td>';
												}

												?>
											</tr>
										<?}?>
									<?}?>
								</tbody>
							</table>
						</div>
                            		<!-- /.table-responsive -->

















					<?} else {echo "Sorry, you have not been betting on matches.";}?>





	                	<!-- ВНИЗ -->
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->
