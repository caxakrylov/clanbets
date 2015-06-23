	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Сash out</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


	            	<div class="row">
	                	<div class="col-lg-12">

					<form action="" method="POST" id="cashout" role="form">
						<div class="form-group">
							<label class="label_psystem">Payment system</label>
							<select name="psystem" size="1" id="psystem" onchange="check_psystem(this)" class="form-control">
								<?foreach($psystem as $item){?>
										<option value="<?=$item->value?>"><?=$item->name?></option>
								<?}?>
							</select>
							<div style="clear:both;"></div>
							<span class="help-block">Select the payment system to transfer money</span>
						</div>

						<div class="form-group">
							<label class="label_ewallet">E-wallet number</label>
							<input type="text" name="ewallet_number" id="ewallet_number" class="form-control" placeholder="000000000000000000">
							<div style="clear:both;"></div>
							<span class="help-block">Enter e-wallet number or email</span>
						</div>

						<div class="form-group">
							<label class="label_withdraw">Amount</label>
							<input type="text" name="sum_withdraw" id="sum_withdraw" class="form-control" onkeyup=<? echo "'check_amount(".$usermoney.",".$state_comm.")'"; ?> maxlength="12">
							<div id="msg_sum_withdraw"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Enter the amount to be withdrawn</span>
						</div>

						<?
							if ($freemoney > 0) {
								$ibets = $freemoney / 0.5;
								echo "<div class='form-group'><span style='border-bottom:1px solid #333; padding-bottom:3px;'><i class='fa fa-exclamation-triangle fa-fw'></i>&nbsp;";
									if ($ibets == 1)
										echo "You should make another <span style='font-weight:bold'>1 bet</span>, before can withdraw the money.";
									else
										echo "You have to make <span style='font-weight:bold'>$ibets bets</span>, before can withdraw the money.";
								echo ' According promotions <a href="/promotions">"$10 + $1 FREE".</a></span></div>';
							}
						?>


						<button type="submit" class="btn btn-default" id="btn_cashout" name="btn_cashout">Withdraw</button>
						<? if (isset($ok)) {echo "<span style='margin-left:5px;' class='label lgreen'><i class='fa fa-check fa-fw'></i>&nbsp;Application for withdrawal accepted!</span>";}
						elseif(isset($errors)) {echo "<span style='margin-left:5px;' class='label lred'><i class='fa fa-times fa-fw'></i>&nbsp;Error withdrawal</span>";} ?>
					</form>

					<div style="margin-top:20px;">
						* The minimum size of the amount withdrawn $15.<br>
						* Once a month you can withdraw money without a fee. But if you want to withdraw money twice or more times per month, you will pay 4% of the withdrawal amount.<br>
						* Money derived during the day. Withdrawal can last from 3 minutes to 24 hours.
					</div>


					<? if ($cashouts->count() > 0) { ?>
						<div class="dline"></div>
						<h4>
							<i class="fa fa-th-list fa-fw"></i>&nbsp;All transactions withdrawal
						</h4>

						<table class="table table-bordered table-hover table-nomargin table-condensed" id="dataTable_cashout">
							<thead>
									<tr>
										<th style="display:none;"></th>
										<th>Transact ID</th>
										<th>Time create (<? if ($_SESSION['utc_user'] >= 0) {echo 'UTC+'.trim($_SESSION['utc_user']);} else {echo $_SESSION['utc_user'];}?>)</th>
										<th>Payment system</th>
										<th>E-wallet number</th>
										<th>Amount</th>
										<th>State</th>
									</tr>
							</thead>

							<tbody>
								<?
								foreach($cashouts as $itemcashout){ ?>
									<tr>
										<td style="display:none;"></td>
										<td class="td_id"><?=$itemcashout->id?></td>
										<td class="td_time">
											<?
												$UTCcashout = $offset+$itemcashout->timecreate; //UTC match

												if (date('d.m.Y',$UTCcashout) == $UTCuser) {
													echo date('H:i',$UTCcashout).' today';
												} else {
													echo date('d.m.y H:i',$UTCcashout);
												}
											?>
										</td>

										<td class="td_psustem"><?=$itemcashout->usercashout->psystem->name?></td>
										<td class="td_ewallet"><?=$itemcashout->usercashout->ewallet_number?></td>
										<td class="td_sum">$<?
											if ($itemcashout->usercashout->percent4 == 1) {
												$tmp = $itemcashout->sumOUT/1.04;
												$tmp = number_format($tmp, 2, '.', '');
												echo $itemcashout->sumOUT." ($".$tmp."+4%)";
											} else {
												echo $itemcashout->sumOUT;
											}
										?></td>
										<td class="td_state">
											<? if ($itemcashout->state == 1) {
												echo "<span class='label'>In processing</span>";
											} elseif ($itemcashout->state == 2) {
												echo "<span class='label lred'>Not withdrawn</span>";
											} else {
												echo "<span class='label lgreen'>Money withdrawn</span>";
											}?>
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


