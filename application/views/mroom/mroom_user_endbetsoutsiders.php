<div class="page-header">
	<div class="pull-left">
		<h1><?=$user->username?> - User outsiders bets (CLOSE)</h1>
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

<!-- Таблица для ставок на матч и карты -->
		<table class="table table-hover table-nomargin dataTable table-condensed">
			<thead>
				<tr>
					<th style="display:none;"></th>
					<th>DMatch +0</th>
					<th>IDmatch</th>
					<th>Event</th>
					<th>Discipline</th>					
					<th>Map(s)</th>
					<th>Yes</th>
					<th>No</th>
					<th>State</th>				
				</tr>
			</thead>
			<tbody>
				<? foreach($mainbets as $itembet){
					if ($itembet->match->state == 0) {  //только для закрытых матчей ?>
						<tr class='usertr_notlink'>
							<td style="display:none;"></td>
							<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
							<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
							<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
							<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->discipline->name?></td>
							<td style="width:70px; border-right:1px dotted #bbb;"><?
								switch ($itembet->typebet) {
									case 3:
										echo 'One map?'; break;
									case 5:
										echo 'Two maps?'; break;
									case 7:
										echo 'Three maps?'; break;	
									case 9:
										echo 'Four maps?'; break;
									case 11:
										echo 'Five maps?'; break;
								}
								?>
							</td>

							<?
							if ($itembet->state != 2) {//все кроме отмененных ставок
								switch ($itembet->typebet) {
									case 3:
										echo '<td style="border-right:1px dotted #bbb;">';
										if ($itembet->sum1 > 0)
											if (($itembet->match->outsider==1 && $itembet->match->score1>=1) || ($itembet->match->outsider==2 && $itembet->match->score2>=1)) 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
											else 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
										else //ставки не было
											echo $itembet->rate1;

										echo '</td><td style="border-right:1px dotted #bbb;">';
										if ($itembet->sum2 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1<1)|| ($itembet->match->outsider==2 && $itembet->match->score2<1)) 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
											else 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
										else //ставки не было
											echo $itembet->rate2;
										echo '</td>';
										break;
									case 5:
										echo '<td style="border-right:1px dotted #bbb;">';
										if ($itembet->sum1 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1>=2) || ($itembet->match->outsider==2 && $itembet->match->score2>=2)) 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
											else 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
										else //ставки не было
											echo $itembet->rate1;

										echo '</td><td style="border-right:1px dotted #bbb;">';

										if ($itembet->sum2 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1<2)|| ($itembet->match->outsider==2 && $itembet->match->score2<2)) 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
											else 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
										else //ставки не было
											echo $itembet->rate2;
										echo '</td>';
										break;
									case 7:
										echo '<td style="border-right:1px dotted #bbb;">';
										if ($itembet->sum1 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1>=3) || ($itembet->match->outsider==2 && $itembet->match->score2>=3)) 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
											else 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
										else //ставки не было
											echo $itembet->rate1;

										echo '</td><td style="border-right:1px dotted #bbb;">';

										if ($itembet->sum2 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1<3)|| ($itembet->match->outsider==2 && $itembet->match->score2<3)) 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
											else 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
										else //ставки не было
											echo $itembet->rate2;
										echo '</td>';
										break;
									case 9:
										echo '<td style="border-right:1px dotted #bbb;">';
										if ($itembet->sum1 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1>=4) || ($itembet->match->outsider==2 && $itembet->match->score2>=4)) 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
											else 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
										else //ставки не было
											echo $itembet->rate1;

										echo '</td><td style="border-right:1px dotted #bbb;">';

										if ($itembet->sum2 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1<4)|| ($itembet->match->outsider==2 && $itembet->match->score2<4)) 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
											else 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
										else //ставки не было
											echo $itembet->rate2;
										echo '</td>';
										break;							
									case 11:
										echo '<td style="border-right:1px dotted #bbb;">';
										if ($itembet->sum1 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1>=5) || ($itembet->match->outsider==2 && $itembet->match->score2>=5)) 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>"; 
											else 
												echo "$".$itembet->sum1."*".$itembet->rate1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
										else //ставки не было
											echo $itembet->rate1;

										echo '</td><td style="border-right:1px dotted #bbb;">';

										if ($itembet->sum2 > 0)  
											if (($itembet->match->outsider==1 && $itembet->match->score1<5)|| ($itembet->match->outsider==2 && $itembet->match->score2<5)) 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>"; 
											else 
												echo $itembet->sum2."*".$itembet->rate2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
										else //ставки не было
											echo $itembet->rate2;
										echo '</td>';
										break;
								}

								echo '<td style="width:80px;">
									<span class="label">Close. ';
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
								echo '</td>';


							} elseif ($itembet->state == 2) { //выводим отмененные ставки
								echo '
								<td style="border-right:1px dotted #bbb;">';
									if ($itembet->sum1 > 0)  
										//Возврат денег
										echo $itembet->rate1."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sum1."</span>";
									else //ставки не было на rate1
										echo $itembet->rate1; 
								echo '</td>
								<td style="border-right:1px dotted #bbb;">';
									if ($itembet->sum2 > 0)  
										//Возврат денег
										echo $itembet->rate2."<span class='label cancelbetYES' style='float:right'>back $".$itembet->sum2."</span>";
									else //ставки не было
										echo $itembet->rate2; 
									
								echo '</td>
								<td style="width:80px;">
									<span class="cancelbetYES label">Cancelled</span>
								</td>';
							}
							?>

						</tr>

					<?} // Только закрытые матчи?>
				<?} // foreach?>
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
<a href="/mroom/users/oldmatch/<?=$user->id?>">&raquo; Ставки на <strong>матчи, карты (Закрытые)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/editoutsiders/<?=$user->id?>">&raquo; Ставки на <strong>аутсайдеров (Активные)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/transaction/<?=$user->id?>">&raquo; Транзакции пользователя <?=$user->username?></a>