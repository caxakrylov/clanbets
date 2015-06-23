<div class="page-header">
	<div class="pull-left">
		<h1><?=$user->username?> - User outsiders bets (ACTIVE)</h1>
	</div>
	<div class="pull-right">

	</div>
</div>


<?if (!isset($error)) { ?>

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
					<th>Map(s)</th>
					<th>Yes</th>
					<th>No</th>
					<th>Event</th>
					<th>Discipline</th>
					<th>State</th>				
				</tr>
			</thead>
			<tbody>
				<? foreach($mainbets as $itembet){
					if ($itembet->match->state != 0) {  //только для активных матчей, старт. 
						if ($itembet->state == 0) {?> 
						<!-- активная ставка -->
							<tr class='usertr_notlink'>
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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

								?></td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum1 > 0)  
									echo $itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>"; 
									else 
									echo $itembet->rate1; 
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum2 > 0)  
									echo $itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>"; 
									else 
									echo $itembet->rate2; 
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:75px;"><? 
									if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";  
									else echo "<span class='label label-lightred'>Started</span>"; ?>
								</td>
							</tr>

						<?} elseif ($itembet->state == 1) {?>
						<!-- Ставка помеченная пользователем на отмену -->
							<tr class='usertr_notlink btop'> 
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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

								?></td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum1 > 0)  
									echo $itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>"; 
									else 
									echo $itembet->rate1; 
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum2 > 0)  
									echo $itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>"; 
									else 
									echo $itembet->rate2; 
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:80px;"><? 
									if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
						<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>

						<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";  else echo "<span class='label label-lightred'>Started</span>"; ?>
								</td>
							</tr>
							<? 
							if ($itembet->match->state == 1){ //Только для Активных матчей
								$allsum1 = 0; $allsum2 = 0; 
								foreach($mainbets2 as $itembetbet){
									if ($itembet->matchID == $itembetbet->matchID && $itembet->typebet == $itembetbet->typebet) {	
										$allsum1 += $itembetbet->sum1;
										$allsum2 += $itembetbet->sum2;
									}

									if (	$itembet->matchID == $itembetbet->matchID && 
										$itembet->id != $itembetbet->id && 
										$itembet->typebet == $itembetbet->typebet) { ?>
										<tr class='usertr_notlink'> 
											<td style="display:none;"></td>
											<td style="width:15px; border-right:1px dotted #bbb;"></td>
											<td style="width:15px; border-right:1px dotted #bbb;"></td>
											<td style="width:70px; border-right:1px dotted #bbb;"></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembetbet->sum1 > 0)
												echo $itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
												else 
												echo $itembetbet->rate1; 
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembetbet->sum2 > 0)  
												echo $itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>"; 
												else 
												echo $itembetbet->rate2; 
												?>
											</td>
											<td style="width:15px;"></td>
											<td style="width:15px;"></td>
											<td style="width:75px;"></td>
										</tr>
									<?}?>
								<?}?>
								<tr class='bbottom'>
									<td style="display:none;"></td>
									<td></td>
									<td></td>
									<td></td>
									<td>All sum: <span style='float:right' class='label allsumlabel'>$<?=$allsum1?></span></td>
									<td>All sum: <span style='float:right' class='label allsumlabel'>$<?=$allsum2?></span></td>
									<td></td>
									<td></td>
									<td></td>							
								</tr>
							<?}?>
						<?} elseif ($itembet->state == 2) {?>
						<!-- Отмененная ставка -->
							<tr class='usertr_notlink trcancelbetYES'> 
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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

								?></td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum1 > 0)  
									echo $itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>"; 
									else 
									echo $itembet->rate1; 
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum2 > 0)  
									echo $itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>"; 
									else 
									echo $itembet->rate2; 
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:80px;"><? 
									if ($itembet->match->state == 1) echo "<span class='label cancelbetYES'>Cancel (Active)</span>";  else echo "<span class='label cancelbetYES'> Cancel (Started)</span>"; ?>
								</td>
							</tr>
						<?} elseif ($itembet->state == 3) {?>
						<!-- НЕ Отмененная ставка -->
							<tr class='usertr_notlink trcancelbetNO'> 
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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

								?></td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum1 > 0)  
									echo $itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>"; 
									else 
									echo $itembet->rate1; 
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sum2 > 0)  
									echo $itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>"; 
									else 
									echo $itembet->rate2; 
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:80px;"><? 
									if ($itembet->match->state == 1)  echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";  else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
								</td>							
							</tr>
						<?}?>
					<?}?>	
				<?}?>
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
<a href="/mroom/users/oldmatchoutsiders/<?=$user->id?>">&raquo; Ставки на <strong>аутсайдеров (Закрытые)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/transaction/<?=$user->id?>">&raquo; Транзакции пользователя <?=$user->username?></a>


<? } else { echo "<p>Ошибка изменения статуса ставки!!!</p>"; } ?>
