	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Edit profile</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


	            	<div class="row">
	                	<div class="col-lg-12">
					<p>Username - <span style="font-size:16px;"><?=$username?></span></p>
					<p>Email - <span style="font-size:16px;"><?=$email?></span> <?if($check_mail==0) {echo "<span class='label lred'>Not verified!</span> <a id='verifymail' href='#'>Click here to confirm email</a> <span id='verifymailOK' style='display:none;'>Letter sent! Check your email for verification.</span>";} else {echo "<span class='label lgreen'>Verified!</span>";} ?></p>

					<form action="" method="POST" id="changepassword" role="form">

						<div class="form-group">
							<label class="label_currentpassword">Current password</label>
							<input type="password" name="current_password" id="current_password" class="form-control">
							<div id="msg_change_current"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Enter your current password</span>
						</div>

						<div class="form-group">
							<label class="label_password">New password</label>
							<input type="password" name="signup_password" id="signup_password" class="form-control">
							<div id="msg_signup_password"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Minimum length: 5</span>
						</div>
						<div class="form-group">
							<label class="label_password2">Confirm password</label>
							<input type="password" name="signup_password2" id="signup_password2" class="form-control">
							<div id="msg_signup_password2"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Enter your password again</span>
						</div>
						<button type="submit" class="btn btn-default" id="change_btnsubmit" name="change_btnsubmit">Сhange password</button>

						<? if (isset($ok)) { echo "<span style='margin-left:5px;' class='label lgreen'><i class='fa fa-check fa-fw'></i>&nbsp;Password is changed!</span>";}
						elseif(isset($errors)) { echo "<span style='margin-left:5px;' class='label lred'><i class='fa fa-times fa-fw'></i>&nbsp;Error change password</span>";} ?>
					</form>

	              	</div>
	              	<!-- /.col-lg-12 -->
	          	</div>
	          	<!-- /.row -->


