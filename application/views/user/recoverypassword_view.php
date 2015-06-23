	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Recovery password</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


	            	<div class="row">
	                	<div class="col-lg-12">

					<? if(isset($ok)){?>

						<p>New password sent to your email.</p>
						<p>Сheck your email.</p>

					<?} else {?>

						<form action="" method="POST" id="recoverypass_form" role="form">

							<div class="form-group">
								<label class="label_email">Email</label>
								<input type="text" name="recovery_email" id="recovery_email" class="form-control">
								<div id="msg_recovery_email"></div>
								<div style="clear:both;"></div>
								<span class="help-block">Please enter your email address</span>
							</div>

							<button type="submit" class="btn btn-default" id="recovery_btnsubmit" name="recovery_btnsubmit">Recovery password</button><? if (isset($errors)) { echo "<span style='margin-left:5px;' class='label lred'><i class='fa fa-times fa-fw'></i>&nbsp;Error recovery password</span>"; } ?>
						</form>

					<?}?>

				</div>
			</div>
