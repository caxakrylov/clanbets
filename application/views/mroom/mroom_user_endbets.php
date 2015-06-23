<div class="page-header">
	<div class="pull-left">
		<h1><?=$user->username?> - User match, map1-map11 bets (CLOSE)</h1>
	</div>
	<div class="pull-right">

	</div>
</div>
<div class="box box-bordered box-color lightgrey">
	<div class="box-content nopadding">

		<ul class="tabs tabs-inline tabs-top">
			<li class='active'>
				<a href="#maintable" data-toggle='tab'><i class="icon-reorder"></i> Main table </a>
			</li>
			<li>
				<a href="#express" data-toggle='tab'><i class=" icon-check"></i> Multiple bets </a>
			</li>
			<li>
				<a href="#events" data-toggle='tab'><i class="icon-trophy"></i> Champion </a>
			</li>
		</ul>
		<div class="tab-content padding tab-content-inline tab-content-bottom">
<div class="tab-pane active" id="maintable">
	<div class="box-content nopadding">
		<p>Username - <span class="editplayer2"><? echo $user->username.' ('.$user->utc.')';?></span>. Balance - <span class="editplayer2">$<?=$user->money?></span></p>

		<table class="table table-hover table-nomargin dataTable table-condensed">
			<thead>
				<tr>
					<th style="display:none;"></th>
					<th>DMatch +0</th>
					<th>IDmatch</th>
					<th>Event (Bo)</th>
					<th>Discipline</th>
					<th>Typebet</th>				
					<th>Player #1</th>
					<th>Player #2</th>
					<th>Draw</th>
					<th>State</th>				
				</tr>
			</thead>
			<tbody>
				<? foreach($mainbets as $itembet){ ?>
					<? if ($itembet->match->state == 0){  //матч завершен, значит и завершены все карты данного матча
						if ($itembet->state == 2) {?>
						<!-- Отмененная ставка -->
							<tr class='usertr_notlink trcancelbetYES'> 
								<td style="display:none;"></td>
								<td style="width:30px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
								<td style="width:30px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:30px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?
									switch ($itembet->typebet) {
										case 1:
											echo 'Match'; break;
										case 101:
											echo '1st map'; break;
										case 102:
											echo '2nd map'; break;	
										case 103:
											echo '3rd map'; break;
										case 104:
											echo '4th map'; break;	
										case 105:
											echo '5th map'; break;
										case 106:
											echo '6th map'; break;
										case 107:
											echo '7th map'; break;
										case 108:
											echo '8th map'; break;
										case 109:
											echo '9th map'; break;
										case 110:
											echo '10th map'; break;
										case 111:
											echo '11th map'; break;
									}
								?></td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum1 > 0)
									echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label cancelbetYES'>$".$itembet->sum1."</span>";
									else 
									echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1; 
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum2 > 0)  
									echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label cancelbetYES'>$".$itembet->sum2."</span>"; 
									else 
									echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2; 
									?>
								</td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sumdraw > 0)  
										echo $itembet->ratedraw." <span style='float:right' class='label cancelbetYES'>$".$itembet->sumdraw."</span>"; 
									elseif ($itembet->ratedraw == '0.000') //ставки не было
										echo 'none';
									else echo $itembet->ratedraw;
								?>	
								</td>
								<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span></td>
							</tr>
						<?} else {?> 
							<tr class='usertr_notlink'>
								<td style="display:none;"></td>
								<td style="width:30px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
								<td  style="width:30px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td  style="width:30px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?
									switch ($itembet->typebet) {
										case 1:
											echo 'Match'; break;
										case 101:
											echo '1st map'; break;
										case 102:
											echo '2nd map'; break;	
										case 103:
											echo '3rd map'; break;
										case 104:
											echo '4th map'; break;	
										case 105:
											echo '5th map'; break;
										case 106:
											echo '6th map'; break;
										case 107:
											echo '7th map'; break;
										case 108:
											echo '8th map'; break;
										case 109:
											echo '9th map'; break;
										case 110:
											echo '10th map'; break;
										case 111:
											echo '11th map'; break;
									}
								?></td>

								<?
								switch ($itembet->typebet) {
									case 1:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->score1 > $itembet->match->score2) //матч завершен, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //ставка проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->score1 < $itembet->match->score2) //матч завершен, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //ставка проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sumdraw > 0)  
												if ($itembet->match->score1 == $itembet->match->score2) //ставка сыграла
													echo $itembet->sumdraw."*".$itembet->ratedraw."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sumdraw*$itembet->ratedraw,2)."</span>";
												else //ставка не сыграла
													echo $itembet->sumdraw."*".$itembet->ratedraw."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sumdraw."</span>";
											elseif ($itembet->ratedraw == '0.000') 
												echo 'none'; 
											else echo $itembet->ratedraw; //ставки не было					
										echo '</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->score1.':'.$itembet->match->score2.'</span>
										</td>';
										break;
									case 101:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map1_score1 > $itembet->match->map1_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map1_score1 < $itembet->match->map1_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map1_score1.':'.$itembet->match->map1_score2.'</span>
										</td>';
										break;
									case 102:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map2_score1 > $itembet->match->map2_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map2_score1 < $itembet->match->map2_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map2_score1.':'.$itembet->match->map2_score2.'</span>
										</td>';
										break;
									case 103:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map3_score1 > $itembet->match->map3_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map3_score1 < $itembet->match->map3_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map3_score1.':'.$itembet->match->map3_score2.'</span>
										</td>';
										break;
									case 104:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map4_score1 > $itembet->match->map4_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map4_score1 < $itembet->match->map4_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map4_score1.':'.$itembet->match->map4_score2.'</span>
										</td>';
										break;
									case 105:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map5_score1 > $itembet->match->map5_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map5_score1 < $itembet->match->map5_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map5_score1.':'.$itembet->match->map5_score2.'</span>
										</td>';
										break;
									case 106:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map6_score1 > $itembet->match->map6_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map6_score1 < $itembet->match->map6_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map6_score1.':'.$itembet->match->map6_score2.'</span>
										</td>';
										break;
									case 107:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map7_score1 > $itembet->match->map7_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map7_score1 < $itembet->match->map7_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map7_score1.':'.$itembet->match->map7_score2.'</span>
										</td>';
										break;
									case 108:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map8_score1 > $itembet->match->map8_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map8_score1 < $itembet->match->map8_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map8_score1.':'.$itembet->match->map8_score2.'</span>
										</td>';
										break;
									case 109:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map9_score1 > $itembet->match->map9_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map9_score1 < $itembet->match->map9_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map9_score1.':'.$itembet->match->map9_score2.'</span>
										</td>';
										break;
									case 110:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map10_score1 > $itembet->match->map10_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map10_score1 < $itembet->match->map10_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map10_score1.':'.$itembet->match->map10_score2.'</span>
										</td>';
										break;	
									case 111:
										echo '
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum1 > 0)  
												if ($itembet->match->map11_score1 > $itembet->match->map11_score2) //карта завершена, ставка сыграла
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
												else //карта проиграна, матч завершен.
													echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
											else //ставки не было на rate1
												echo $itembet->rate1;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">';
											if ($itembet->sum2 > 0)  
												if ($itembet->match->map11_score1 < $itembet->match->map11_score2) //карта завершена, ставка сыграла
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
												else //карта проиграна, матч закрыт
													echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
											else //ставки не было
												echo $itembet->rate2;
										echo '</td>
										<td style="border-right:1px dotted #bbb;">
											none
										</td>
										<td style="width:80px;">
											<span class="label">Close '.$itembet->match->map11_score1.':'.$itembet->match->map11_score2.'</span>
										</td>';
										break;
								}//switch
								?>
							</tr>
						<?} // неотмененная ставка?>
					<?} //матч завершен?>	
				<?}//foreach ?>
			</tbody>
		</table>
	</div>
</div>
			<div class="tab-pane" id="express">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto vel labore sed odio laudantium in eum aliquid reiciendis blanditiis consequatur excepturi dicta quisquam soluta quis neque nostrum expedita temporibus illum aliquam voluptatibus a cumque sit nulla et consectetur ex maiores sequi culpa suscipit. Voluptate quae id consequatur consequuntur exercitationem cumque beatae obcaecati 
			</div>
			<div class="tab-pane" id="events">
				bo ut ad accusamus neque. Commodi ipsam quia aperiam nisi id unde sapiente 
			</div>
		</div>



	</div>
</div>


<a href="/mroom/users/edit/<?=$user->id?>">&raquo; Ставки на <strong>матчи, карты (Активные)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/editoutsiders/<?=$user->id?>">&raquo; Ставки на <strong>аутсайдеров (Активные)</strong> <?=$user->username?></a>
<br/>
<a href="/mroom/users/oldmatchoutsiders/<?=$user->id?>">&raquo; Ставки на <strong>аутсайдеров (Закрытые)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/transaction/<?=$user->id?>">&raquo; Транзакции пользователя <?=$user->username?></a>