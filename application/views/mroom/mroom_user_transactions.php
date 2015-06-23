<div class="page-header">
	<div class="pull-left">
		<h1><?=$user->username?> - User transactions</h1>
	</div>
	<div class="pull-right">

	</div>
</div>

<div class="box box-bordered box-color lightgrey">
	<div class="box-content nopadding">
		<div class="tab-content padding tab-content-inline tab-content-bottom">
			<div class="tab-pane active" id="maintable">
				<div class="box-content nopadding">
<?if (!isset($error)) { ?>				
				<p>Username - <span class="editplayer2"><? echo $user->username.' ('.$user->utc.')';?></span>. Balance - <span class="editplayer2">$<?=$user->money?></span></p>

				<table class="table table-hover table-nomargin dataTable-columnfilter dataTable table-condensed">
					<thead>
						<tr class='thefilter'>
							<th style="display:none;"></th>
							<th>Time create</th>
							<th>Sum IN</th>
							<th>Sum OUT</th>
							<th>State</th>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th style="display:none;"></th>
							<th>Time create</th>
							<th>Sum IN</th>
							<th>Sum OUT</th>
							<th>State</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<? foreach($transactions as $itemtrans){  ?>
							<tr class='usertr_notlink'>
								<td style="display:none;"></td>
								<td><?=date('d.m.y H:i',$itemtrans->timecreate)?></td>
								<? if ($itemtrans->sumIN != 0.00) {?>
									<td><?=$itemtrans->sumIN?></td>
								<?} else {echo '<td></td>';} if ($itemtrans->sumOUT != 0.00) {?>
									<td><?=$itemtrans->sumOUT?></td>
								<?} else {echo '<td></td>';} ?>
				<td><? if($itemtrans->state == 1) echo "<span class='label label-satgreen'>Active (Для исполнения)</span>"; elseif ($itemtrans->state == 2) echo "<span class='label label-lightred'>Сanceled (Отменен)</span>"; elseif ($itemtrans->state == 3) echo "<span class='label label-lightgrey'>Performed (Выполнен)</span>"; elseif ($itemtrans->state == 4) echo "<span class='label label'>SumIN Waiting</span>"; elseif ($itemtrans->state == 5) echo "<span class='label label-satgreen'>SumIN Success</span>"; elseif ($itemtrans->state == 6) echo "<span class='label label-lightred'>SumIN Failure</span>";?> </td>
				<td><? if ($itemtrans->sumOUT != 0.00 && $itemtrans->state == 1) {?><a href="/mroom/users/closetransaction/<?=$itemtrans->id?>">Cancel(Отмена)</a><?}?></td>
				<td><? if ($itemtrans->sumOUT != 0.00 && $itemtrans->state == 1) {?><a href="/mroom/users/performcashout/<?=$itemtrans->id?>">Perform(Выполнен)</a><?}?></td>



							</tr>
						<?}?>
					</tbody>
				</table>

<? } else { echo "<p>Ошибка отмены транзакции!!!</p>"; } ?>

				</div>
			</div>
		</div>



	</div>
</div>

<a href="/mroom/users/cashoutlist">&raquo; Запросы пользователей на вывод денег</a>