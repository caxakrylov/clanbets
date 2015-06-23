<div class="page-header">
	<div class="pull-left">
		<h1>All users</h1>
	</div>
	<div class="pull-right">

	</div>
</div>

<a href="/mroom/users/cashoutlist">&raquo; Запросы пользователей на вывод денег</a>
<br/>
<br/>

<div class="box box-bordered box-color lightgrey">
	<div class="box-content nopadding">
		<table class="table table-hover table-nomargin dataTable-columnfilter dataTable table-condensed">
			<thead>
				<tr class='thefilter'>
					<th>Username</th>
					<th>Email</th>
					<th>Vfy</th>
					<th>UTC</th>
					<th>Last login +0</th>
					<th>Bets</th>
					<th>Balance</th>
					<th>sumIN</th>
					<th>sumOUT</th>
					<th>CancelB</th>
					<th>M</th>
				</tr>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Vfy</th>
					<th>UTC</th>
					<th>Last login +0</th>
					<th>Bets</th>
					<th>Balance</th>
					<th>sumIN</th>
					<th>sumOUT</th>
					<th>CancelB</th>
					<th>M</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($users as $item){ ?>
					<tr class='usertr' onclick=<? echo 'edituser('.$item->id.');' ?> >
						<td><?=$item->username?></td>
						<td><?=$item->email?></td>
						<td><? if ($item->check_mail==1) echo "Verify"; else echo "Not"; ?></td>
						<td><?=$item->utc?></td>
						<td><?=date('d.m.y H:i',$item->last_login)?></td>
						<td><?
							$mainbet = ORM::factory('Mainbet')->where("userID","=",$item->id)->find_all();
							if ($mainbet->count() > 0)
								echo $mainbet->count();
							else echo '0';
							?>
						</td>
						<td><?=$item->money." (".$item->freemoney.")"?></td>
						<td><? $sumIN = 0; $sumOUT = 0;
						foreach($transactions as $itemtransact) {
							if ($itemtransact->userID == $item->id) {$sumIN += $itemtransact->sumIN; $sumOUT += $itemtransact->sumOUT; }
						} echo $sumIN; ?></td>
						<td><?=$sumOUT?></td>
						<td><? $i=0;
						foreach($mainbets as $itembet) {
							if ($itembet->userID == $item->id && $itembet->state == 1)
								switch ($itembet->typebet) {
									case 1:
									case 3:
									case 5:
									case 7:
									case 9:
									case 11:
										if ($itembet->match->state == 1) $i++; break;
									case 101:
										if ($itembet->match->map1_state == 1) $i++; break;
									case 102:
										if ($itembet->match->map2_state == 1) $i++; break;
									case 103:
										if ($itembet->match->map3_state == 1) $i++; break;
									case 104:
										if ($itembet->match->map4_state == 1) $i++; break;
									case 105:
										if ($itembet->match->map5_state == 1) $i++; break;
									case 106:
										if ($itembet->match->map6_state == 1) $i++; break;
									case 107:
										if ($itembet->match->map7_state == 1) $i++; break;
									case 108:
										if ($itembet->match->map8_state == 1) $i++; break;
									case 109:
										if ($itembet->match->map9_state == 1) $i++; break;
									case 110:
										if ($itembet->match->map10_state == 1) $i++; break;
									case 111:
										if ($itembet->match->map11_state == 1) $i++; break;
								}
						}
						if ($i > 0) echo "<span class='label label-satgreen'>".$i."</span>";
						else echo $i;
						?></td>
						<td><? $i=0;
							foreach($unreadmess as $mess) {
								if ($mess->userID == $item->id)
									$i++;
							}
							if ($i > 0) echo "<span class='label lmessages'>".$i."</span>";
							else echo $i;
							?>
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>


	</div>
</div>

<script type="text/javascript">

	function edituser(e)
	{
		document.location.href = '/mroom/users/edit/'+e;
	}


</script>












