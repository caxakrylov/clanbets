<div class="page-header">
	<div class="pull-left">
		<h1><?=$user->username?> - User match, map1-map11 bets (ACTIVE)</h1>
	</div>
	<div class="pull-right">

	</div>
</div>


<?if (!isset($error)) { ?>

<a href="/mroom/users/messages/<?=$user->id?>">&raquo; <strong>Сообщения пользователя</strong> <?=$user->username?></a>

<div class="box box-bordered box-color lightgrey" style="margin:15px 0;">
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
					<th>Typebet</th>
					<th>Player #1</th>
					<th>Player #2</th>
					<th>Draw</th>
					<th>Event</th>
					<th>Discipline</th>
					<th>State</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($mainbets as $itembet){
					if ($itembet->match->state != 0) { //активный матч
						if ($itembet->state == 0) {?> <!-- активная ставка -->
							<tr class='usertr_notlink'>
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
											break;
										case 101:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
											break;
										case 102:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
											break;
										case 103:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
											break;
										case 104:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
											break;
										case 105:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
											break;
										case 106:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
											break;
										case 107:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
											break;
										case 108:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
											break;
										case 109:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
											break;
										case 110:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
											break;
										case 111:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
											break;
									}
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
											break;
										case 101:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
											break;
										case 102:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
											break;
										case 103:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
											break;
										case 104:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
											break;
										case 105:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
											break;
										case 106:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
											break;
										case 107:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
											break;
										case 108:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
											break;
										case 109:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
											break;
										case 110:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
											break;
										case 111:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
											break;
									}
									?>
								</td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sumdraw > 0)
									echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
									else
									echo $itembet->ratedraw." (".$itembet->sumdraw.")";
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:75px;"><?
									$ch_state = 0;
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->match->state == 1) $ch_state = 1; break;
										case 101:
											if ($itembet->match->map1_state == 1) $ch_state = 1; break;
										case 102:
											if ($itembet->match->map2_state == 1) $ch_state = 1; break;
										case 103:
											if ($itembet->match->map3_state == 1) $ch_state = 1; break;
										case 104:
											if ($itembet->match->map4_state == 1) $ch_state = 1; break;
										case 105:
											if ($itembet->match->map5_state == 1) $ch_state = 1; break;
										case 106:
											if ($itembet->match->map6_state == 1) $ch_state = 1; break;
										case 107:
											if ($itembet->match->map7_state == 1) $ch_state = 1; break;
										case 108:
											if ($itembet->match->map8_state == 1) $ch_state = 1; break;
										case 109:
											if ($itembet->match->map9_state == 1) $ch_state = 1; break;
										case 110:
											if ($itembet->match->map10_state == 1) $ch_state = 1; break;
										case 111:
											if ($itembet->match->map11_state == 1) $ch_state = 1; break;
									}

								if ($ch_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>Active</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";
								else echo "<span class='label label-lightred'>Started</span>"; ?>
								</td>
							</tr>

						<?} elseif ($itembet->state == 1) {?>
						<!-- Ставка помеченная пользователем на отмену -->
							<tr class='usertr_notlink btop'>
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
											break;
										case 101:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
											break;
										case 102:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
											break;
										case 103:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
											break;
										case 104:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
											break;
										case 105:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
											break;
										case 106:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
											break;
										case 107:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
											break;
										case 108:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
											break;
										case 109:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
											break;
										case 110:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
											break;
										case 111:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
											break;
									}
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
											break;
										case 101:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
											break;
										case 102:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
											break;
										case 103:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
											break;
										case 104:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
											break;
										case 105:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
											break;
										case 106:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
											break;
										case 107:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
											break;
										case 108:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
											break;
										case 109:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
											break;
										case 110:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
											break;
										case 111:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
											break;
									}
									?>
								</td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sumdraw > 0)
									echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
									else
									echo $itembet->ratedraw." (".$itembet->sumdraw.")";
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:80px;"><?
									$ch_state = 0;
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->match->state == 1) $ch_state = 1; break;
										case 101:
											if ($itembet->match->map1_state == 1) $ch_state = 1; break;
										case 102:
											if ($itembet->match->map2_state == 1) $ch_state = 1; break;
										case 103:
											if ($itembet->match->map3_state == 1) $ch_state = 1; break;
										case 104:
											if ($itembet->match->map4_state == 1) $ch_state = 1; break;
										case 105:
											if ($itembet->match->map5_state == 1) $ch_state = 1; break;
										case 106:
											if ($itembet->match->map6_state == 1) $ch_state = 1; break;
										case 107:
											if ($itembet->match->map7_state == 1) $ch_state = 1; break;
										case 108:
											if ($itembet->match->map8_state == 1) $ch_state = 1; break;
										case 109:
											if ($itembet->match->map9_state == 1) $ch_state = 1; break;
										case 110:
											if ($itembet->match->map10_state == 1) $ch_state = 1; break;
										case 111:
											if ($itembet->match->map11_state == 1) $ch_state = 1; break;
									}

								if ($ch_state == 1)
								echo "<span class='label label-lightred' id='cancel-$itembet->id'>Отменить?</span><br>
						<span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id' style='margin-left:0;'>Yes</span>

						<span class='cancelX label' onclick='cancelbetNO($itembet->id);' style='margin-left:19px;' id='xidNo-$itembet->id'>No</span>";  else echo "<span class='label label-lightred'>Started</span>"; ?>
								</td>
							</tr>
							<?
							if ($ch_state == 1){ //Только для Активных карт и матчей
								$allsum1 = 0; $allsum2 = 0; $allsumdraw = 0;
								foreach($mainbets2 as $itembetbet){
									if ($itembet->matchID == $itembetbet->matchID && $itembet->typebet == $itembetbet->typebet) {
										$allsum1 += $itembetbet->sum1;
										$allsum2 += $itembetbet->sum2;
										$allsumdraw += $itembetbet->sumdraw;
									}

									if (	$itembet->matchID == $itembetbet->matchID &&
										$itembet->id != $itembetbet->id &&
										$itembet->typebet == $itembetbet->typebet) { ?>
										<tr class='usertr_notlink'>
											<td style="display:none;"></td>
											<td style="width:15px; border-right:1px dotted #bbb;"></td>
											<td style="width:15px; border-right:1px dotted #bbb;"></td>
											<td style="width:15px; border-right:1px dotted #bbb;"></td>
											<td style="border-right:1px dotted #bbb;">
												<?
												switch ($itembetbet->typebet) {
												case 1:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->player1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->player1->name." - ".$itembetbet->rate1;
													break;
												case 101:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map1playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map1playerID1->name." - ".$itembetbet->rate1;
													break;
												case 102:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map2playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map2playerID1->name." - ".$itembetbet->rate1;
													break;
												case 103:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map3playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map3playerID1->name." - ".$itembetbet->rate1;
													break;
												case 104:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map4playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map4playerID1->name." - ".$itembetbet->rate1;
													break;
												case 105:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map5playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map5playerID1->name." - ".$itembetbet->rate1;
													break;
												case 106:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map6playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map6playerID1->name." - ".$itembetbet->rate1;
													break;
												case 107:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map7playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map7playerID1->name." - ".$itembetbet->rate1;
													break;
												case 108:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map8playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map8playerID1->name." - ".$itembetbet->rate1;
													break;
												case 109:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map9playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map9playerID1->name." - ".$itembetbet->rate1;
													break;
												case 110:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map10playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map10playerID1->name." - ".$itembetbet->rate1;
													break;
												case 111:
													if ($itembetbet->sum1 > 0)
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map11playerID1->name." - ".$itembetbet->rate1." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum1."</span>";
													else
													echo $itembetbet->match->team1->shortname.$itembetbet->match->map11playerID1->name." - ".$itembetbet->rate1;
													break;
												}
												?>
											 </td>
											<td style="border-right:1px dotted #bbb;">
												<?
												switch ($itembetbet->typebet) {
												case 1:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->player2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->player2->name." - ".$itembetbet->rate2;
													break;
												case 101:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map1playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map1playerID2->name." - ".$itembetbet->rate2;
													break;
												case 102:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map2playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map2playerID2->name." - ".$itembetbet->rate2;
													break;
												case 103:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map3playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map3playerID2->name." - ".$itembetbet->rate2;
													break;
												case 104:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map4playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map4playerID2->name." - ".$itembetbet->rate2;
													break;
												case 105:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map5playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map5playerID2->name." - ".$itembetbet->rate2;
													break;
												case 106:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map6playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map6playerID2->name." - ".$itembetbet->rate2;
													break;
												case 107:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map7playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map7playerID2->name." - ".$itembetbet->rate2;
													break;
												case 108:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map8playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map8playerID2->name." - ".$itembetbet->rate2;
													break;
												case 109:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map9playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map9playerID2->name." - ".$itembetbet->rate2;
													break;
												case 110:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map10playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map10playerID2->name." - ".$itembetbet->rate2;
													break;
												case 111:
													if ($itembetbet->sum2 > 0)
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map11playerID2->name." - ".$itembetbet->rate2." <span style='float:right' class='label betbetsum'>$".$itembetbet->sum2."</span>";
													else
													echo $itembetbet->match->team2->shortname.$itembetbet->match->map11playerID2->name." - ".$itembetbet->rate2;
													break;
												}
												?>
											</td>
											<td style="border-right:1px dotted #bbb;">
												<? if ($itembetbet->sumdraw > 0)
												echo $itembetbet->ratedraw." <span style='float:right' class='label betbetsum'>$".$itembetbet->sumdraw."</span>";
												else
												echo $itembetbet->ratedraw." (".$itembetbet->sumdraw.")";
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
									<td>All sum: <span style='float:right' class='label allsumlabel'>$<?=$allsumdraw?></span></td>
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
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
											break;
										case 101:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
											break;
										case 102:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
											break;
										case 103:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
											break;
										case 104:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
											break;
										case 105:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
											break;
										case 106:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
											break;
										case 107:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
											break;
										case 108:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
											break;
										case 109:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
											break;
										case 110:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
											break;
										case 111:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
											break;
									}
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
											break;
										case 101:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
											break;
										case 102:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
											break;
										case 103:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
											break;
										case 104:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
											break;
										case 105:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
											break;
										case 106:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
											break;
										case 107:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
											break;
										case 108:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
											break;
										case 109:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
											break;
										case 110:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
											break;
										case 111:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
											break;
									}
									?>
								</td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sumdraw > 0)
									echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
									else
									echo $itembet->ratedraw." (".$itembet->sumdraw.")";
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:80px;"><?

									$ch_state = 0;
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->match->state == 1) $ch_state = 1; break;
										case 101:
											if ($itembet->match->map1_state == 1) $ch_state = 1; break;
										case 102:
											if ($itembet->match->map2_state == 1) $ch_state = 1; break;
										case 103:
											if ($itembet->match->map3_state == 1) $ch_state = 1; break;
										case 104:
											if ($itembet->match->map4_state == 1) $ch_state = 1; break;
										case 105:
											if ($itembet->match->map5_state == 1) $ch_state = 1; break;
										case 106:
											if ($itembet->match->map6_state == 1) $ch_state = 1; break;
										case 107:
											if ($itembet->match->map7_state == 1) $ch_state = 1; break;
										case 108:
											if ($itembet->match->map8_state == 1) $ch_state = 1; break;
										case 109:
											if ($itembet->match->map9_state == 1) $ch_state = 1; break;
										case 110:
											if ($itembet->match->map10_state == 1) $ch_state = 1; break;
										case 111:
											if ($itembet->match->map11_state == 1) $ch_state = 1; break;
									}

								if ($ch_state == 1) echo "<span class='label cancelbetYES'>Cancel (Active)</span>";  else echo "<span class='label cancelbetYES'> Cancel (Started)</span>"; ?>
								</td>
							</tr>
						<?} elseif ($itembet->state == 3) {?>
						<!-- НЕ Отмененная ставка -->
							<tr class='usertr_notlink trcancelbetNO'>
								<td style="display:none;"></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=date('d.m.y H:i',$itembet->match->datetime)?></td>
								<td style="width:15px; border-right:1px dotted #bbb;"><?=$itembet->match->id?></td>
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
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->player1->name." - ".$itembet->rate1;
											break;
										case 101:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map1playerID1->name." - ".$itembet->rate1;
											break;
										case 102:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map2playerID1->name." - ".$itembet->rate1;
											break;
										case 103:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map3playerID1->name." - ".$itembet->rate1;
											break;
										case 104:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map4playerID1->name." - ".$itembet->rate1;
											break;
										case 105:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map5playerID1->name." - ".$itembet->rate1;
											break;
										case 106:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map6playerID1->name." - ".$itembet->rate1;
											break;
										case 107:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map7playerID1->name." - ".$itembet->rate1;
											break;
										case 108:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map8playerID1->name." - ".$itembet->rate1;
											break;
										case 109:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map9playerID1->name." - ".$itembet->rate1;
											break;
										case 110:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map10playerID1->name." - ".$itembet->rate1;
											break;
										case 111:
											if ($itembet->sum1 > 0)
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1." <span style='float:right' class='label activesumlabel'>$".$itembet->sum1."</span>";
											else
											echo $itembet->match->team1->shortname.$itembet->match->map11playerID1->name." - ".$itembet->rate1;
											break;
									}
									?>
								 </td>
								<td style="border-right:1px dotted #bbb;">
									<?
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->player2->name." - ".$itembet->rate2;
											break;
										case 101:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map1playerID2->name." - ".$itembet->rate2;
											break;
										case 102:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map2playerID2->name." - ".$itembet->rate2;
											break;
										case 103:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map3playerID2->name." - ".$itembet->rate2;
											break;
										case 104:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map4playerID2->name." - ".$itembet->rate2;
											break;
										case 105:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map5playerID2->name." - ".$itembet->rate2;
											break;
										case 106:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map6playerID2->name." - ".$itembet->rate2;
											break;
										case 107:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map7playerID2->name." - ".$itembet->rate2;
											break;
										case 108:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map8playerID2->name." - ".$itembet->rate2;
											break;
										case 109:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map9playerID2->name." - ".$itembet->rate2;
											break;
										case 110:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map10playerID2->name." - ".$itembet->rate2;
											break;
										case 111:
											if ($itembet->sum2 > 0)
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2." <span style='float:right' class='label activesumlabel'>$".$itembet->sum2."</span>";
											else
											echo $itembet->match->team2->shortname.$itembet->match->map11playerID2->name." - ".$itembet->rate2;
											break;
									}
									?>
								</td>
								<td style="border-right:1px dotted #bbb;">
									<? if ($itembet->sumdraw > 0)
									echo $itembet->ratedraw." <span style='float:right' class='label activesumlabel'>$".$itembet->sumdraw."</span>";
									else
									echo $itembet->ratedraw." (".$itembet->sumdraw.")";
									?>
								</td>
								<td style="width:15px;"><?=$itembet->match->event->name?> (Bo<?=$itembet->match->bestof?>)</td>
								<td style="width:15px;"><?=$itembet->match->discipline->name?></td>
								<td style="width:80px;"><?
									$ch_state = 0;
									switch ($itembet->typebet) {
										case 1:
											if ($itembet->match->state == 1) $ch_state = 1; break;
										case 101:
											if ($itembet->match->map1_state == 1) $ch_state = 1; break;
										case 102:
											if ($itembet->match->map2_state == 1) $ch_state = 1; break;
										case 103:
											if ($itembet->match->map3_state == 1) $ch_state = 1; break;
										case 104:
											if ($itembet->match->map4_state == 1) $ch_state = 1; break;
										case 105:
											if ($itembet->match->map5_state == 1) $ch_state = 1; break;
										case 106:
											if ($itembet->match->map6_state == 1) $ch_state = 1; break;
										case 107:
											if ($itembet->match->map7_state == 1) $ch_state = 1; break;
										case 108:
											if ($itembet->match->map8_state == 1) $ch_state = 1; break;
										case 109:
											if ($itembet->match->map9_state == 1) $ch_state = 1; break;
										case 110:
											if ($itembet->match->map10_state == 1) $ch_state = 1; break;
										case 111:
											if ($itembet->match->map11_state == 1) $ch_state = 1; break;
									}

									if ($ch_state == 1) echo "<span class='label label-satgreen' id='cancel-$itembet->id'>No (Active)</span><span class='cancelX label' onclick='cancelbetYES($itembet->id);' id='xid-$itembet->id'>X</span>";  else echo "<span class='label label-lightred'>No (Started)</span>"; ?>
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

<a href="/mroom/users/oldmatch/<?=$user->id?>">&raquo; Ставки на <strong>матчи, карты (Закрытые)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/editoutsiders/<?=$user->id?>">&raquo; Ставки на <strong>аутсайдеров (Активные)</strong> <?=$user->username?></a>
<br/>
<a href="/mroom/users/oldmatchoutsiders/<?=$user->id?>">&raquo; Ставки на <strong>аутсайдеров (Закрытые)</strong> <?=$user->username?></a>
<br/>
<br/>
<a href="/mroom/users/transaction/<?=$user->id?>">&raquo; Транзакции пользователя <?=$user->username?></a>

<a style='float:right;' href="/mroom/users/setcencelbets/<?=$user->id?>" class='btn btn-green'>
	<?
		if ($user->set_cencelbets == 0) echo 'Откл. отмену ставок';
		else echo 'Вкл. отмену ставок';
	?>
</a>

<? } else { echo "<p>Ошибка изменения статуса ставки!!!</p>"; } ?>
