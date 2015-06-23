	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Make a deposit</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


	            	<div class="row">
	                	<div class="col-lg-12">

					<? if (isset($ok)) { echo "<p><span class='label lgreen'><i class='fa fa-check fa-fw'></i>&nbsp;Money deposited in the near future. Thank you.</span></p>";}
					elseif(isset($errors)) { echo "<p><span class='label lred'><i class='fa fa-times fa-fw'></i>&nbsp;Error depositing money.</span></p>";} ?>

					<form action="" method="POST" id="deposit" role="form">
						<div class="form-group">
							<label class="label_amount">Amount $</label>
							<input type="text" name="sum_deposit" id="sum_deposit" class="form-control" onkeypress="check_sum();" maxlength="12">
							<div style="clear:both;"></div>
							<p class="help-block">Enter the amount to be deposited</p>
						</div>
						<button type="submit" class="btn btn-default" id="btn_deposit" name="btn_deposit">Next</button>
						<label class="checkbox-inline" style="margin-left:10px;">
							<input id="check_promo" name="check_promo" type="checkbox"  value="1" checked> <a href="#" data-toggle="tooltip" data-placement="right" title="" data-original-title="For every $10 add $1 for free. For every $1 free you need to put 2 bets before you withdraw the money.">For every $10 add $1 for FREE!</a>
						</label>
					</form>

					<div style="clear:both;"></div>

					<? if ($deposits->count() > 0) { //если есть ставки?>

						<div class="dline"></div>
						<h4>
							<i class="fa fa-th-list fa-fw"></i>&nbsp;All transactions deposit
						</h4>

	                            	<table class="table table-bordered table-hover table-nomargin table-condensed" id="dataTable_dep">
							<thead>
								<tr>
									<th style="display:none;"></th>
									<th>Transact ID</th>
									<th>Time create (<? if ($_SESSION['utc_user'] >= 0) {echo 'UTC+'.trim($_SESSION['utc_user']);} else {echo $_SESSION['utc_user'];}?>)</th>
									<th>Amount</th>
									<th>State</th>
								</tr>
							</thead>
							<tbody>
								<?
								$fiveday = time() - 86400*4;
								foreach($deposits as $itemdep){ ?>
									<tr>
										<td style="display:none;"></td>
										<td class="td_id"><?=$itemdep->id?></td>
										<td class="td_time">
											<?
												$UTCdep = $offset+$itemdep->timecreate; //UTC match

												if (date('d.m.Y',$UTCdep) == $UTCuser) {
													echo date('H:i',$UTCdep).' today';
												} else {
													echo date('d.m.y H:i',$UTCdep);
												}
											?>
										</td>
										<td class="td_sum">$<?=$itemdep->sumIN?></td>
										<td class="td_state">
											<?
												if ($itemdep->state == 4 && $itemdep->timecreate > $fiveday)
													echo "<span class='label'>Waiting</span>";
												elseif ($itemdep->state == 4 && $itemdep->timecreate < $fiveday)
													echo "<span class='label lred'>Failure</span>";
												elseif ($itemdep->state == 5)
													echo "<span class='label lgreen'>Success</span>";
												else
													echo "<span class='label lred'>Failure</span>";
											?>
										</td>
									</tr>
								<?}?>
							</tbody>
						</table>
					<?}?>

	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->
