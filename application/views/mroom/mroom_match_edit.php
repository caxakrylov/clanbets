<script type="text/javascript">

	$(document).ready(function(){
		$('#edit_form_main_bet').submit(function(event) {
			if (confirm("Главная ставка матча. Изменить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map1').submit(function(event) {
			if (confirm("Карта 1. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map2').submit(function(event) {
			if (confirm("Карта 2. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map3').submit(function(event) {
			if (confirm("Карта 3. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map4').submit(function(event) {
			if (confirm("Карта 4. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map5').submit(function(event) {
			if (confirm("Карта 5. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map6').submit(function(event) {
			if (confirm("Карта 6. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map7').submit(function(event) {
			if (confirm("Карта 7. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map8').submit(function(event) {
			if (confirm("Карта 8. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map9').submit(function(event) {
			if (confirm("Карта 9. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map10').submit(function(event) {
			if (confirm("Карта 10. Применить?")) {
			} else {
				event.preventDefault();
			}
		});

		$('#edit_form_map11').submit(function(event) {
			if (confirm("Карта 11. Применить?")) {
			} else {
				event.preventDefault();
			}
		});
	});

</script>


<h3>Редактирование матча</h3>

<p class="adm_notification">
	<? if (isset($ok)) { ?>
	Матч успешно изменен.
	<? } elseif (isset($errors)) {
		foreach ($errors as $item) { ?>
			<?=$item?>
		<? }
	} elseif (isset($closeerr)) { ?>
		Не заполнен результат матча, неправильно выставлен результат. Или незакрыты карты.
	<? } elseif (isset($cancelerr)) { ?>
		Ошибка отмены матча!
	<?} ?>
</p>


<form method="post" action="" enctype="multipart/form-data" id="edit_form_main_bet">
	<p>Дисциплина: <?=$match->discipline->name?></p>
	<p><span class="editplayer2">Bo<? echo $match->bestof;?></span> Если нужно изменить BO, тогда нужно пересоздавать карту с нужным BO. Текущий матч нужно отменить.</p>
	<p>Выберите ивент:
		<select name="eventID">
			<?foreach($events as $item) {?>
				<option <?if ($item->id == $match->eventID) echo "selected";?> value="<?=$item->id?>"><?=$item->name?></option>
				<?}?>
		</select>
	</p>
	<?date_default_timezone_set('CET'); ?>
	<p>Введите дату и время матча: <input type="text" name="datetime" id="datetime" value="<?=date('d.m.Y H:i',$match->datetime)?>"></p>
	<p>Введите максимальную ставку: <input type="text" name="maxbet" value="<?=$match->maxbet?>"> Маржа: <?=$match->marge?></p>
	<p>Стартовать все карты? <input type="checkbox" name="fullstart" value="1" <?if($match->fullstart == 1) echo "checked"?>></p>

	<input type="submit" value="Изменить" name="editmatchsubmit">

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- Редактирование главной ставки-->


<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Главная ставка, на общий исход</h4>


	<p>Участник №1: <span class="editplayer1"><?=$match->team1->shortname.$match->player1->name?> (<?=$match->rate1?>)</span>
	Score1:<input style="margin-left:10px;" type="text" name="score1" value="<?=$match->score1?>"></p>
	<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->player2->name?> (<?=$match->rate2?>)</span>
	Score2:<input style="margin-left:10px;" type="text" name="score2" value="<?=$match->score2?>"></p>
	<p>Коэффициент ничьи: (<?=$match->draw?>)</p>
	<p>
		<? if ($match->state == 1) {
			echo "<span class='btn btn-green' id='redirectmatch' onclick='match_startstop($match->id);'>Старт (Начать матч)</span>";
		} elseif ($match->state == 2) {
			echo "<span class='btn btn-red' id='redirectmatch' onclick='match_startstop($match->id);'>Стоп (Сделать матч активным для ставок)</span>";
		} elseif ($match->cancel_state == 1) {
			echo "<span class='editstatus'>Матч отменен!</span><a href='#' name='redirectmatch'></a>";
		} else {
			echo "<span class='editstatus'>Матч закрыт!</span><a href='#' name='redirectmatch'></a>";
		}

		if($match->state != 0) {
			echo "<input type='submit' style='margin-left:150px;' value='Закрыть матч'' name='closesubmit_match'>";
		}

		if ($match->state == 1 || $match->state == 2)
			echo '<input style="float:right;" type="submit" value="Отменить матч" name="cancelsubmit_match">';
		?>


	</p>

</form>



<table class="table table-hover table-nomargin dataTable table-condensed">
	<thead>
		<tr>
			<th style="display:none;"></th>
			<th>User</th>
			<th>Player #1</th>
			<th>Player #2</th>
			<th>Draw</th>
			<th>State</th>
		</tr>
	</thead>
	<tbody>
		<?
		$all_sum1 = 0.00;
		$all_sum2 = 0.00;
		$all_sumdraw = 0.00;
		foreach($mainbets as $itembet){
			if ($itembet->typebet == 1) {
				// подсчет общих сумм
				if ($itembet->state != 2) {
					$all_sum1 += $itembet->sum1;
					$all_sum2 += $itembet->sum2;
					$all_sumdraw += $itembet->sumdraw;
				}

				if ($itembet->match->state == 1 || $itembet->match->state == 2) { //Матч активный или в режиме старт
					if ($itembet->state == 0) {?>
					<!-- Обычная ставка -->
						<tr class='usertr_notlink'>
							<td style="display:none;"></td>
							<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)
								echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
								else
								echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
								else
								echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
								?>
							</td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sumdraw > 0)
								echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
								else
								echo $itembet->ratedraw." (".$itembet->sumdraw.")";
								?>
							</td>
							<td style="width:75px;"><? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>"; else echo "<span class='label label-lightred'>Started</span>"; ?>
							</td>
						</tr>

					<?} elseif ($itembet->state == 1) {?>
					<!-- Ставка помеченная пользователем на отмену -->
						<tr class='usertr_notlink'>
							<td style="display:none;"></td>
							<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)
								echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
								else
								echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
								else
								echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
								?>
							</td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sumdraw > 0)
								echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
								else
								echo $itembet->ratedraw." (".$itembet->sumdraw.")";
								?>
							</td>
							<td style="width:80px;"><? if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
							<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>

							<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";  else echo "<span class='label label-lightred'>Started</span>"; ?>
							</td>
						</tr>
					<?} elseif ($itembet->state == 2) {?>
					<!-- Отмененная ставка -->
						<tr class='usertr_notlink trcancelbetYES'>
							<td style="display:none;"></td>
							<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
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
								else
								echo $itembet->ratedraw." (".$itembet->sumdraw.")";
								?>
							</td>
							<td style="width:80px;"><span class='label cancelbetYES'>Cancel</span>
							</td>
						</tr>
					<?} elseif ($itembet->state == 3) {?>
					<!-- НЕ Отмененная ставка -->
						<tr class='usertr_notlink trcancelbetNO'>
							<td style="display:none;"></td>
							<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)
								echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
								else
								echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
								else
								echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
								?>
							</td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sumdraw > 0)
								echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
								else
								echo $itembet->ratedraw." (".$itembet->sumdraw.")";
								?>
							</td>
							<td style="width:80px;"><? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";  else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
							</td>
						</tr>
					<?}?>
				<?}elseif ($itembet->match->state == 0){  //Закрытый матч.
					if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
						<tr class='usertr_notlink trcancelbetYES'>
							<td style="display:none;"></td>
							<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
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
								elseif ($itembet->match->draw == '0.000') //ставки не было
									echo 'none';
								else echo $itembet->ratedraw;
							?>

							</td>
							<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
							</td>
						</tr>
					<?} else {?>
						<tr class='usertr_notlink'>
							<td style="display:none;"></td>
							<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)
									if ($itembet->match->score1 > $itembet->match->score2) //матч завершен, ставка сыграла
										echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									else //ставка проиграна, матч завершен.
										echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
								else //ставки не было на rate1
									echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
									if ($itembet->match->score1 < $itembet->match->score2) //матч завершен, ставка сыграла
										echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									else //ставка проиграна, матч закрыт
										echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
								else //ставки не было
									echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
								?>
							</td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sumdraw > 0)
									if ($itembet->match->score1 == $itembet->match->score2) //ставка сыграла
										echo $itembet->ratedraw."*".$itembet->sumdraw."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sumdraw*$itembet->ratedraw,2)."</span>";
									else //ставка не сыграла
										echo $itembet->ratedraw."*".$itembet->sumdraw."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sumdraw."</span>";
								elseif ($itembet->match->draw == '0.000') //ставки не было
									echo 'none';
								else echo $itembet->ratedraw;
								?>
							</td>
							<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->score1.':'.$itembet->match->score2?></span>
							</td>
						</tr>
					<?}?>
				<?}?>
			<?}?> <!-- typebet == 1 -->
		<?}?>
	</tbody>
</table>

<div style="clear:both;"></div>
<div style="margin-top:10px; float:right;">
	<span class="editplayer1"><?=$match->team1->shortname.$match->player1->name?> (<?=$match->rate1?>): <?=$all_sum1?>$</span>
	<span class="editplayer2"><?=$match->team2->shortname.$match->player2->name?> (<?=$match->rate2?>): <?=$all_sum2?>$</span>
	<span class="editplayer1">Draw (<?=$match->draw?>): <?=$all_sumdraw?>$</span>
	<span class="editplayer2"> = <?=$all_sum1+$all_sum2+$all_sumdraw?>$</span>
</div>

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- Редактирование отдельных карт  1 - active, 2 - start, 3 - close.-->
<?
if ($match->bestof >= 2) {
	$i = 1;
	do {

		switch ($i) {
			case 1:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #1 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map1">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map1playerID1->name?> (<?=$match->map1_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map1_score1" value="<?=$match->map1_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map1playerID2->name?> (<?=$match->map1_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map1_score2" value="<?=$match->map1_score2?>"></p>
					<p>

						<? if ($match->map1_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map1_startstop($match->id);' class='btn btn-green' id='redirectmap1'>Старт Map #1</span>";
						} elseif ($match->map1_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map1_startstop($match->id);' class='btn btn-red' id='redirectmap1'>Стоп Map #1 (Открыть для ставок)</span>";
						} elseif ($match->map1_state == 3) {
							echo "<span class='editstatus'>Map #1 закрыта!</span><a href='#' name='redirectmap1'></a>";
						} else {
							echo "<span class='editstatus'>Map #1 ОТМЕНЕНА!</span><a href='#' name='redirectmap1'></a>";
						}

						if ($match->map1_state != 3 && $match->map1_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #1" name="closesubmit_map1">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #1" name="cancelsubmit_map1">';
						}
						?>

					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 101) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map1_state == 1 || $itembet->match->map1_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map1_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map1_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map1_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map1_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map1_score1 > $itembet->match->map1_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map1_score1 < $itembet->match->map1_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map1_score1.':'.$itembet->match->map1_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 101 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map1playerID1->name?> (<?=$match->map1_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map1playerID2->name?> (<?=$match->map1_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 2:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #2 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map2">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map2playerID1->name?> (<?=$match->map2_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map2_score1" value="<?=$match->map2_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map2playerID2->name?> (<?=$match->map2_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map2_score2" value="<?=$match->map2_score2?>"></p>
					<p>

						<? if ($match->map2_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map2_startstop($match->id);' class='btn btn-green' id='redirectmap2'>Старт Map #2</span>";
						} elseif ($match->map2_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map2_startstop($match->id);' class='btn btn-red' id='redirectmap2'>Стоп Map #2 (Открыть для ставок)</span>";
						} elseif ($match->map2_state == 3) {
							echo "<span class='editstatus'>Map #2 закрыта!</span><a href='#' name='redirectmap2'></a>";
						} else {
							echo "<span class='editstatus'>Map #2 ОТМЕНЕНА!</span><a href='#' name='redirectmap2'></a>";
						}

						if ($match->map2_state != 3 && $match->map2_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #2" name="closesubmit_map2">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #2" name="cancelsubmit_map2">';
						}
						?>

					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 102) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map2_state == 1 || $itembet->match->map2_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map2_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map2_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map2_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map2_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map2_score1 > $itembet->match->map2_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map2_score1 < $itembet->match->map2_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map2_score1.':'.$itembet->match->map2_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 102 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map2playerID1->name?> (<?=$match->map2_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map2playerID2->name?> (<?=$match->map2_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 3:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #3 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map3">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map3playerID1->name?> (<?=$match->map3_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map3_score1" value="<?=$match->map3_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map3playerID2->name?> (<?=$match->map3_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map3_score2" value="<?=$match->map3_score2?>"></p>
					<p>
						<? if ($match->map3_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map3_startstop($match->id);' class='btn btn-green' id='redirectmap3'>Старт Map #3</span>";
						} elseif ($match->map3_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map3_startstop($match->id);' class='btn btn-red' id='redirectmap3'>Стоп Map #3 (Открыть для ставок)</span>";
						} elseif ($match->map3_state == 3) {
							echo "<span class='editstatus'>Map #3 закрыта!</span><a href='#' name='redirectmap3'></a>";
						} else {
							echo "<span class='editstatus'>Map #3 ОТМЕНЕНА!</span><a href='#' name='redirectmap3'></a>";
						}

						if ($match->map3_state != 3 && $match->map3_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #3" name="closesubmit_map3">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #3" name="cancelsubmit_map3">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 103) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map3_state == 1 || $itembet->match->map3_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map3_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map3_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map3_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map3_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map3_score1 > $itembet->match->map3_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map3_score1 < $itembet->match->map3_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map3_score1.':'.$itembet->match->map3_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 103 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map3playerID1->name?> (<?=$match->map3_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map3playerID2->name?> (<?=$match->map3_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 4:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #4 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map4">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map4playerID1->name?> (<?=$match->map4_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map4_score1" value="<?=$match->map4_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map4playerID2->name?> (<?=$match->map4_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map4_score2" value="<?=$match->map4_score2?>"></p>
					<p>

						<? if ($match->map4_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map4_startstop($match->id);' class='btn btn-green' id='redirectmap4'>Старт Map #4</span>";
						} elseif ($match->map4_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map4_startstop($match->id);' class='btn btn-red' id='redirectmap4'>Стоп Map #4 (Открыть для ставок)</span>";
						} elseif ($match->map4_state == 3) {
							echo "<span class='editstatus'>Map #4 закрыта!</span><a href='#' name='redirectmap4'></a>";
						} else {
							echo "<span class='editstatus'>Map #4 ОТМЕНЕНА!</span><a href='#' name='redirectmap4'></a>";
						}

						if ($match->map4_state != 3 && $match->map4_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #4" name="closesubmit_map4">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #4" name="cancelsubmit_map4">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 104) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map4_state == 1 || $itembet->match->map4_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map4_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map4_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map4_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map4_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map4_score1 > $itembet->match->map4_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map4_score1 < $itembet->match->map4_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map4_score1.':'.$itembet->match->map4_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 104 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map4playerID1->name?> (<?=$match->map4_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map4playerID2->name?> (<?=$match->map4_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 5:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #5 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map5">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map5playerID1->name?> (<?=$match->map5_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map5_score1" value="<?=$match->map5_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map5playerID2->name?> (<?=$match->map5_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map5_score2" value="<?=$match->map5_score2?>"></p>
					<p>

						<? if ($match->map5_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map5_startstop($match->id);' class='btn btn-green' id='redirectmap5'>Старт Map #5</span>";
						} elseif ($match->map5_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map5_startstop($match->id);' class='btn btn-red' id='redirectmap5'>Стоп Map #5 (Открыть для ставок)</span>";
						} elseif ($match->map5_state == 3) {
							echo "<span class='editstatus'>Map #5 закрыта!</span><a href='#' name='redirectmap5'></a>";
						} else {
							echo "<span class='editstatus'>Map #5 ОТМЕНЕНА!</span><a href='#' name='redirectmap5'></a>";
						}

						if ($match->map5_state != 3 && $match->map5_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #5" name="closesubmit_map5">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #5" name="cancelsubmit_map5">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 105) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map5_state == 1 || $itembet->match->map5_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map5_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map5_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map5_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map5_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map5_score1 > $itembet->match->map5_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map5_score1 < $itembet->match->map5_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map5_score1.':'.$itembet->match->map5_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 105 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map5playerID1->name?> (<?=$match->map5_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map5playerID2->name?> (<?=$match->map5_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 6:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #6 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map6">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map6playerID1->name?> (<?=$match->map6_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map6_score1" value="<?=$match->map6_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map6playerID2->name?> (<?=$match->map6_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map6_score2" value="<?=$match->map6_score2?>"></p>
					<p>

						<? if ($match->map6_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map6_startstop($match->id);' class='btn btn-green' id='redirectmap6'>Старт Map #6</span>";
						} elseif ($match->map6_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map6_startstop($match->id);' class='btn btn-red' id='redirectmap6'>Стоп Map #6 (Открыть для ставок)</span>";
						} elseif ($match->map6_state == 3) {
							echo "<span class='editstatus'>Map #6 закрыта!</span><a href='#' name='redirectmap6'></a>";
						} else {
							echo "<span class='editstatus'>Map #6 ОТМЕНЕНА!</span><a href='#' name='redirectmap6'></a>";
						}

						if ($match->map6_state != 3 && $match->map6_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #6" name="closesubmit_map6">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #6" name="cancelsubmit_map6">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 106) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map6_state == 1 || $itembet->match->map6_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map6_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map6_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map6_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map6_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map6_score1 > $itembet->match->map6_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map6_score1 < $itembet->match->map6_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map6_score1.':'.$itembet->match->map6_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 106 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map6playerID1->name?> (<?=$match->map6_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map6playerID2->name?> (<?=$match->map6_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 7:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #7 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map7">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map7playerID1->name?> (<?=$match->map7_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map7_score1" value="<?=$match->map7_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map7playerID2->name?> (<?=$match->map7_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map7_score2" value="<?=$match->map7_score2?>"></p>
					<p>

						<? if ($match->map7_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map7_startstop($match->id);' class='btn btn-green' id='redirectmap7'>Старт Map #7</span>";
						} elseif ($match->map7_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map7_startstop($match->id);' class='btn btn-red' id='redirectmap7'>Стоп Map #7 (Открыть для ставок)</span>";
						} elseif ($match->map7_state == 3) {
							echo "<span class='editstatus'>Map #7 закрыта!</span><a href='#' name='redirectmap7'></a>";
						} else {
							echo "<span class='editstatus'>Map #7 ОТМЕНЕНА!</span><a href='#' name='redirectmap7'></a>";
						}

						if ($match->map7_state != 3 && $match->map7_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #7" name="closesubmit_map7">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #7" name="cancelsubmit_map7">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 107) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map7_state == 1 || $itembet->match->map7_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map7_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map7_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map7_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map7_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map7_score1 > $itembet->match->map7_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map7_score1 < $itembet->match->map7_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map7_score1.':'.$itembet->match->map7_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 107 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map7playerID1->name?> (<?=$match->map7_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map7playerID2->name?> (<?=$match->map7_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 8:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #8 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map8">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map8playerID1->name?> (<?=$match->map8_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map8_score1" value="<?=$match->map8_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map8playerID2->name?> (<?=$match->map8_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map8_score2" value="<?=$match->map8_score2?>"></p>
					<p>
						<? if ($match->map8_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map8_startstop($match->id);' class='btn btn-green' id='redirectmap8'>Старт Map #8</span>";
						} elseif ($match->map8_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map8_startstop($match->id);' class='btn btn-red' id='redirectmap8'>Стоп Map #8 (Открыть для ставок)</span>";
						} elseif ($match->map8_state == 3) {
							echo "<span class='editstatus'>Map #8 закрыта!</span><a href='#' name='redirectmap8'></a>";
						} else {
							echo "<span class='editstatus'>Map #8 ОТМЕНЕНА!</span><a href='#' name='redirectmap8'></a>";
						}
						if ($match->map8_state != 3 && $match->map8_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #8" name="closesubmit_map8">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #8" name="cancelsubmit_map8">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 108) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map8_state == 1 || $itembet->match->map8_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map8_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map8_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map8_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map8_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map8_score1 > $itembet->match->map8_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map8_score1 < $itembet->match->map8_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map8_score1.':'.$itembet->match->map8_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 108 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map8playerID1->name?> (<?=$match->map8_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map8playerID2->name?> (<?=$match->map8_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 9:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #9 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map9">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map9playerID1->name?> (<?=$match->map9_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map9_score1" value="<?=$match->map9_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map9playerID2->name?> (<?=$match->map9_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map9_score2" value="<?=$match->map9_score2?>"></p>
					<p>
						<? if ($match->map9_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map9_startstop($match->id);' class='btn btn-green' id='redirectmap9'>Старт Map #9</span>";
						} elseif ($match->map9_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map9_startstop($match->id);' class='btn btn-red' id='redirectmap9'>Стоп Map #9 (Открыть для ставок)</span>";
						} elseif ($match->map9_state == 3) {
							echo "<span class='editstatus'>Map #9 закрыта!</span><a href='#' name='redirectmap9'></a>";
						} else {
							echo "<span class='editstatus'>Map #9 ОТМЕНЕНА!</span><a href='#' name='redirectmap9'></a>";
						}

						if ($match->map9_state != 3 && $match->map9_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #9" name="closesubmit_map9">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #9" name="cancelsubmit_map9">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 109) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map9_state == 1 || $itembet->match->map9_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map9_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map9_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map9_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map9_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map9_score1 > $itembet->match->map9_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map9_score1 < $itembet->match->map9_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map9_score1.':'.$itembet->match->map9_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 109 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map9playerID1->name?> (<?=$match->map9_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map9playerID2->name?> (<?=$match->map9_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 10:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #10 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map10">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map10playerID1->name?> (<?=$match->map10_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map10_score1" value="<?=$match->map10_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map10playerID2->name?> (<?=$match->map10_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map10_score2" value="<?=$match->map10_score2?>"></p>
					<p>
						<? if ($match->map10_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map10_startstop($match->id);' class='btn btn-green' id='redirectmap10'>Старт Map #10</span>";
						} elseif ($match->map10_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map10_startstop($match->id);' class='btn btn-red' id='redirectmap10'>Стоп Map #10 (Открыть для ставок)</span>";
						} elseif ($match->map10_state == 3) {
							echo "<span class='editstatus'>Map #10 закрыта!</span><a href='#' name='redirectmap10'></a>";
						} else {
							echo "<span class='editstatus'>Map #10 ОТМЕНЕНА!</span><a href='#' name='redirectmap10'></a>";
						}

						if ($match->map10_state != 3 && $match->map10_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #10" name="closesubmit_map10">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #10" name="cancelsubmit_map10">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 110) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map10_state == 1 || $itembet->match->map10_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map10_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map10_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map10_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map10_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map10_score1 > $itembet->match->map10_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map10_score1 < $itembet->match->map10_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map10_score1.':'.$itembet->match->map10_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 110 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map10playerID1->name?> (<?=$match->map10_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map10playerID2->name?> (<?=$match->map10_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 11:
?>
				<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Map #11 /// <?=$match->team1->shortname.$match->map1playerID1->name.' _ '.$match->team2->shortname.$match->map1playerID2->name?></h4>

				<form method="post" action="" enctype="multipart/form-data" id="edit_form_map11">

					<p>Участник №1: <span class="editplayer1" style=""><?=$match->team1->shortname.$match->map11playerID1->name?> (<?=$match->map11_rate1?>)</span>
					Score1:<input style="margin-left:10px;" type="text" name="map11_score1" value="<?=$match->map11_score1?>"></p>
					<p>Участник №2: <span class="editplayer2"><?=$match->team2->shortname.$match->map11playerID2->name?> (<?=$match->map11_rate2?>)</span>
					Score2:<input style="margin-left:10px;" type="text" name="map11_score2" value="<?=$match->map11_score2?>"></p>
					<p>
						<? if ($match->map11_state == 1) {
							echo "<span style='margin-left:30px;' onclick='map11_startstop($match->id);' class='btn btn-green' id='redirectmap11'>Старт Map #11</span>";
						} elseif ($match->map11_state == 2) {
							echo "<span style='margin-left:30px;' onclick='map11_startstop($match->id);' class='btn btn-red' id='redirectmap11'>Стоп Map #11 (Открыть для ставок)</span>";
						} elseif ($match->map11_state == 3) {
							echo "<span class='editstatus'>Map #11 закрыта!</span><a href='#' name='redirectmap11'></a>";
						} else {
							echo "<span class='editstatus'>Map #11 ОТМЕНЕНА!</span><a href='#' name='redirectmap11'></a>";
						}

						if ($match->map11_state != 3 && $match->map11_state != 4) {
							echo '<input type="submit" style="margin-left:170px;"  value="Закрыть Map #11" name="closesubmit_map11">';
							echo '<input style="float:right;" type="submit" value="Отменить карту #11" name="cancelsubmit_map11">';
						}
						?>
					</p>

				</form>


				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Player #1</th>
							<th>Player #2</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 111) { //Выбираем только ставки для данной карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->map11_state == 1 || $itembet->match->map11_state == 2) { //Карта активна или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->map11_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map11_state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->map11_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->map11_state == 3){  //Закрытая карта
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
												else
												echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
												else
												echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													if ($itembet->match->map11_score1 > $itembet->match->map11_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
													else //ставка проиграна, матч завершен.
														echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
												else //ставки не было на rate1
													echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													if ($itembet->match->map11_score1 < $itembet->match->map11_score2) //матч завершен, ставка сыграла
														echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
													else //ставка проиграна, матч закрыт
														echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
												else //ставки не было
													echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
												?>
											</td>
											<td  style="width:30px;"><span class='label'>Close <?=$itembet->match->map11_score1.':'.$itembet->match->map11_score2?></span>
											</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 111 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1" style=""><?=$match->team1->shortname.$match->map11playerID1->name?> (<?=$match->map11_rate1?>): <?=$all_sum1?>$</span>
					<span class="editplayer2"><?=$match->team2->shortname?><?=$match->map11playerID2->name?> (<?=$match->map11_rate2?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
		} //switch
	} while ($i++ < $match->bestof);
} //if bestof >= 2
?>

<!-- //END!! -->


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- Вывод ставок на аутсайдера -->

<?
if ($match->outsider > 0 && $match->bestof >= 3 && $match->bestof <= 11) {
?>
	<h4 style="text-align:center; border-top:5px solid #1fb509; padding-top:10px; margin-top:50px;">Ставки на аутсайдера -
		<?
			if ($match->outsider == 1) {
				echo $match->team1->shortname.$match->player1->name;
			} elseif ($match->outsider == 2) {
				echo $match->team2->shortname.$match->player2->name;
			}
		?>
	</h4>

	<? $i = 3;
	do {
		// if ($i==4 || $i==6 || $i==8 || $i==10) continue;
		switch ($i) {
			case 3: ?>
				<h5 style="text-align:center;">Возьмет ли 1 карту
					<?
						if ($match->outsider == 1) {
							echo $match->team1->shortname.$match->player1->name;
						} elseif ($match->outsider == 2) {
							echo $match->team2->shortname.$match->player2->name;
						}
					?>
				?</h5>
				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Yes</th>
							<th>No</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 3) { //Выбираем только ставки на аутсайдера, который может взять 1 карту.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->state == 1 || $itembet->match->state == 2) { //Матч активный или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->state == 0){  //Закрытый матч
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)  //Да, игрок возьмет 1 карту
									if ($itembet->match->outsider == 1 && $itembet->match->score1 >= 1)
										 //аутсайдер это Player1 и его итоговый счет >= 1
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 >= 1)
										//аутсайдер это Player2 и его итоговый счет >= 1
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									else
										//Ставка проиграна
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
								else //ставки не было на rate1
									echo $itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								//Нет, игрок не возьмент 1 карту.
									if ($itembet->match->outsider == 1 && $itembet->match->score1 < 1) //аутсайдер это Player1 и его итоговый счет < 1
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 < 1) //аутсайдер это Player2 и его итоговый счет < 1
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									else //ставка проиграна, матч закрыт
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
								else //ставки не было
									echo $itembet->rate2;
								?>
							</td>
							<td  style="width:30px;">
								<span class='label'>Close <?=$itembet->match->score1.':'.$itembet->match->score2?></span>
							</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 3 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1">Да - (<?=$match->rate1_outsider3?>): <?=$all_sum1?>$</span>
					<span class="editplayer2">Нет - (<?=$match->rate2_outsider3?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 5:
?>
				<div style="clear:both;"></div>
				<h5 style="text-align:center;">Возьмет ли 2 карты
					<?
						if ($match->outsider == 1) {
							echo $match->team1->shortname.$match->player1->name;
						} elseif ($match->outsider == 2) {
							echo $match->team2->shortname.$match->player2->name;
						}
					?>
				?</h5>
				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Yes</th>
							<th>No</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 5) { //Выбираем только ставки на аутсайдера, который может взять 2 карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->state == 1 || $itembet->match->state == 2) { //Матч активный или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->state == 0){  //Закрытый матч
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)  //Да, игрок возьмет 2 карты
									if ($itembet->match->outsider == 1 && $itembet->match->score1 >= 2)
										 //аутсайдер это Player1 и его итоговый счет >= 2
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 >= 2)
										//аутсайдер это Player2 и его итоговый счет >= 2
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									else
										//Ставка проиграна
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
								else //ставки не было на rate1
									echo $itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								//Нет, игрок не возьмент 2 карты.
									if ($itembet->match->outsider == 1 && $itembet->match->score1 < 2) //аутсайдер это Player1 и его итоговый счет < 2
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 < 2) //аутсайдер это Player2 и его итоговый счет < 2
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									else //ставка проиграна, матч закрыт
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
								else //ставки не было
									echo $itembet->rate2;
								?>
							</td>
							<td  style="width:30px;">
								<span class='label'>Close <?=$itembet->match->score1.':'.$itembet->match->score2?></span>
							</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 5 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1">Да - (<?=$match->rate1_outsider5?>): <?=$all_sum1?>$</span>
					<span class="editplayer2">Нет - (<?=$match->rate2_outsider5?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 7:
?>
				<div style="clear:both;"></div>
				<h5 style="text-align:center;">Возьмет ли 3 карты
					<?
						if ($match->outsider == 1) {
							echo $match->team1->shortname.$match->player1->name;
						} elseif ($match->outsider == 2) {
							echo $match->team2->shortname.$match->player2->name;
						}
					?>
				?</h5>
				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Yes</th>
							<th>No</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 7) { //Выбираем только ставки на аутсайдера, который может взять 3 карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->state == 1 || $itembet->match->state == 2) { //Матч активный или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->state == 0){  //Закрытый матч
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)  //Да, игрок возьмет 3 карты
									if ($itembet->match->outsider == 1 && $itembet->match->score1 >= 3)
										 //аутсайдер это Player1 и его итоговый счет >= 3
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 >= 3)
										//аутсайдер это Player2 и его итоговый счет >= 3
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									else
										//Ставка проиграна
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
								else //ставки не было на rate1
									echo $itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								//Нет, игрок не возьмент 3 карты.
									if ($itembet->match->outsider == 1 && $itembet->match->score1 < 3) //аутсайдер это Player1 и его итоговый счет < 3
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 < 3) //аутсайдер это Player2 и его итоговый счет < 3
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									else //ставка проиграна, матч закрыт
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
								else //ставки не было
									echo $itembet->rate2;
								?>
							</td>
							<td  style="width:30px;">
								<span class='label'>Close <?=$itembet->match->score1.':'.$itembet->match->score2?></span>
							</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 7 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1">Да - (<?=$match->rate1_outsider7?>): <?=$all_sum1?>$</span>
					<span class="editplayer2">Нет - (<?=$match->rate2_outsider7?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 9:
?>
				<div style="clear:both;"></div>
				<h5 style="text-align:center;">Возьмет ли 4 карты
					<?
						if ($match->outsider == 1) {
							echo $match->team1->shortname.$match->player1->name;
						} elseif ($match->outsider == 2) {
							echo $match->team2->shortname.$match->player2->name;
						}
					?>
				?</h5>
				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Yes</th>
							<th>No</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 9) { //Выбираем только ставки на аутсайдера, который может взять 3 карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->state == 1 || $itembet->match->state == 2) { //Матч активный или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->state == 0){  //Закрытый матч
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)  //Да, игрок возьмет 4 карты
									if ($itembet->match->outsider == 1 && $itembet->match->score1 >= 4)
										 //аутсайдер это Player1 и его итоговый счет >= 4
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 >= 4)
										//аутсайдер это Player2 и его итоговый счет >= 4
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									else
										//Ставка проиграна
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
								else //ставки не было на rate1
									echo $itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								//Нет, игрок не возьмент 4 карты.
									if ($itembet->match->outsider == 1 && $itembet->match->score1 < 4) //аутсайдер это Player1 и его итоговый счет < 4
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 < 4) //аутсайдер это Player2 и его итоговый счет < 4
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									else //ставка проиграна, матч закрыт
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
								else //ставки не было
									echo $itembet->rate2;
								?>
							</td>
							<td  style="width:30px;">
								<span class='label'>Close <?=$itembet->match->score1.':'.$itembet->match->score2?></span>
							</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 9 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1">Да - (<?=$match->rate1_outsider9?>): <?=$all_sum1?>$</span>
					<span class="editplayer2">Нет - (<?=$match->rate2_outsider9?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
			case 11:
?>
				<div style="clear:both;"></div>
				<h5 style="text-align:center;">Возьмет ли 5 карты
					<?
						if ($match->outsider == 1) {
							echo $match->team1->shortname.$match->player1->name;
						} elseif ($match->outsider == 2) {
							echo $match->team2->shortname.$match->player2->name;
						}
					?>
				?</h5>
				<table class="table table-hover table-nomargin dataTable table-condensed">
					<thead>
						<tr>
							<th style="display:none;"></th>
							<th>User</th>
							<th>Yes</th>
							<th>No</th>
							<th>State</th>
						</tr>
					</thead>
					<tbody>
						<?
						$all_sum1 = 0.00;
						$all_sum2 = 0.00;
						foreach($mainbets as $itembet){
							if ($itembet->typebet == 11) { //Выбираем только ставки на аутсайдера, который может взять 3 карты.
								// подсчет общих сумм
								if ($itembet->state != 2) {
									$all_sum1 += $itembet->sum1;
									$all_sum2 += $itembet->sum2;
								}

								if ($itembet->match->state == 1 || $itembet->match->state == 2) { //Матч активный или в режиме старт
									if ($itembet->state == 0) {?>
									<!-- Обычная ставка -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:75px;"><?
												if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>

									<?} elseif ($itembet->state == 1) {?>
									<!-- Ставка помеченная пользователем на отмену -->
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
												<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>
												<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";
												else echo "<span class='label label-lightred'>Started</span>"; ?>
											</td>
										</tr>
									<?} elseif ($itembet->state == 2) {?>
									<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<span class='label cancelbetYES'>Cancel</span>
											</td>
										</tr>
									<?} elseif ($itembet->state == 3) {?>
									<!-- НЕ Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetNO'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;">
												<? if ($itembet->match->state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
												else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
											</td>
										</tr>
									<?}?>
								<?}elseif ($itembet->match->state == 0){  //Закрытый матч
									if ($itembet->state == 2) {?>	<!-- Отмененная ставка -->
										<tr class='usertr_notlink trcancelbetYES'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum1 > 0)
													echo $itembet->rate1." <span class='label activesumlabel'>$".$itembet->sum1."</span>";
													else
													echo $itembet->rate1;
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembet->sum2 > 0)
													echo $itembet->rate2." <span class='label activesumlabel'>$".$itembet->sum2."</span>";
													else
													echo $itembet->rate2;
												?>
											</td>
											<td style="width:80px;"><span class='label cancelbetYES'>Cancelled</span>
											</td>
										</tr>
									<?} else {?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="border-right:1px dotted #bbb;"><?=$itembet->user->username?></td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum1 > 0)  //Да, игрок возьмет 5 карт
									if ($itembet->match->outsider == 1 && $itembet->match->score1 >= 5)
										 //аутсайдер это Player1 и его итоговый счет >= 5
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 >= 5)
										//аутсайдер это Player2 и его итоговый счет >= 5
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum1*$itembet->rate1,2)."</span>";
									else
										//Ставка проиграна
										echo $itembet->rate1."*".$itembet->sum1."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum1."</span>";
								else //ставки не было на rate1
									echo $itembet->rate1;
								?>
							 </td>
							<td style="border-right:1px dotted #bbb;">
								<? if ($itembet->sum2 > 0)
								//Нет, игрок не возьмент 5 карт.
									if ($itembet->match->outsider == 1 && $itembet->match->score1 < 5) //аутсайдер это Player1 и его итоговый счет < 5
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									elseif ($itembet->match->outsider == 2 && $itembet->match->score2 < 5) //аутсайдер это Player2 и его итоговый счет < 5
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-satgreen sumlabel' style='float:right'>+$".round($itembet->sum2*$itembet->rate2,2)."</span>";
									else //ставка проиграна, матч закрыт
										echo $itembet->rate2."*".$itembet->sum2."<span class='label label-lightred sumlabel' style='float:right'>-$".$itembet->sum2."</span>";
								else //ставки не было
									echo $itembet->rate2;
								?>
							</td>
							<td  style="width:30px;">
								<span class='label'>Close <?=$itembet->match->score1.':'.$itembet->match->score2?></span>
							</td>
										</tr>
									<?}?>
								<?}?>
							<?}?> <!-- typebet == 11 -->
						<?}?>
					</tbody>
				</table>

				<div style="clear:both;"></div>
				<div style="margin-top:10px; float:right;">
					<span class="editplayer1">Да - (<?=$match->rate1_outsider11?>): <?=$all_sum1?>$</span>
					<span class="editplayer2">Нет - (<?=$match->rate2_outsider11?>): <?=$all_sum2?>$</span>
					<span class="editplayer1"> = <?=$all_sum1+$all_sum2?>$</span>
				</div>
<?
				break;
		}


	} while ($i++ < $match->bestof);
}
?>






<script type="text/javascript">

  $(document).ready(function(){

   	$("#datetime").datetimeEntry({datetimeFormat: 'D.O.Y H:M', spinnerImage: ''});


  });

</script>



