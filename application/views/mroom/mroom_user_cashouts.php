<div class="page-header">
	<div class="pull-left">
		<h1>Users cashout list</h1>
	</div>
	<div class="pull-right">

	</div>
</div>

<div class="box box-bordered box-color lightgrey">
	<div class="box-content nopadding">
		<table class="table table-hover table-nomargin dataTable-columnfilter dataTable table-condensed">
			<thead>
				<tr class='thefilter'>
					<th style="display:none;"></th>
					<th>Create time</th>
					<th>Username</th>
					<th>User money</th>
					<th>Psystem</th>
					<th>Ewallet</th>
					<th>Sum OUT</th>
					<th>State</th>
					<th></th>
					<th></th>
				</tr>
				<tr>
					<th style="display:none;"></th>
					<th>Create time</th>
					<th>Username</th>
					<th>User money</th>
					<th>Psystem</th>
					<th>Ewallet</th>
					<th>Sum OUT</th>
					<th>State</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?foreach($usercashouts as $item){ ?>
					<tr class='usertr_notlink'>
						<td style="display:none;"></td>
						<td><?=date('d.m.y H:i',$item->transaction->timecreate)?></td>
						<td><?=$item->transaction->user->username?></td>
						<td><?=$item->transaction->user->money?></td>
						<td><?=$item->psystem->name?></td>
						<td><?=$item->ewallet_number?></td>
						<td>
						<?

							if ($item->percent4 == 1) {
								$tmp = $item->sum_withdraw/1.04;
								$tmp = number_format($tmp, 2, '.', '');
								echo $tmp." ($".$item->sum_withdraw."-4%)";
							} else {
								echo $item->sum_withdraw;
							}
						?>


						</td>
						<td><? if($item->transaction->state == 1) {echo "<span class='label label-satgreen'>Active</span>";} elseif ($item->transaction->state == 2) {echo "<span class='label label-lightred'>Сanceled</span>";} elseif ($item->transaction->state == 3) {echo "<span class='label label-lightgrey'>Performed</span>";}?></td>
						<td><? if ($item->transaction->state == 1) {?><a href="/mroom/users/closetransaction/<?=$item->transaction->id?>">Отменить</a><?}?></td>
						<td><? if ($item->transaction->state == 1) {?><a href="/mroom/users/performcashout/<?=$item->transaction->id?>">Выполнить</a><?}?></td>
					</tr>
				<?}?>
			</tbody>
		</table>


	</div>
</div>