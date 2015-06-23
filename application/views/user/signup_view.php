	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Create new account</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


	            	<div class="row">
	                	<div class="col-lg-12">

					<form action="" method="POST" id="signup_form" role="form">

						<div class="form-group">
							<label class="label_login">Username</label>
							<input type="text" name="signup_login" id="signup_login" class="form-control">
							<div id="msg_signup_login"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Only letters, numbers, hyphen, underscore</span>
						</div>
						<div class="form-group">
							<label class="label_email">Email</label>
							<input type="text" name="signup_email" id="signup_email" class="form-control">
							<div id="msg_signup_email"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Enter your email address</span>
						</div>
						<div class="form-group">
							<label for="signup_password" class="label_password">Password</label>
							<input type="password" name="signup_password" id="signup_password" class="form-control">
							<div id="msg_signup_password"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Minimum length: 5</span>
						</div>

						<div class="form-group">
							<label for="signup_password2" class="label_password2">Confirm password</label>
							<input type="password" name="signup_password2" id="signup_password2" class="form-control">
							<div id="msg_signup_password2"></div>
							<div style="clear:both;"></div>
							<span class="help-block">Enter your password again</span>
						</div>

						<div class="form-group">
							<label class="label_terms" for="signup_terms">Conditions</label>
							<div class="terms_of_use"><input type="checkbox" name="signup_terms" id="signup_terms" value="1"><span>I agree with <a href="/check/termsofuse">Terms of Use</a></span></div>
							<div id="msg_signup_terms"></div>
							<div style="clear:both;"></div>
						</div>
						<button type="submit" class="btn btn-default" id="signup_btnsubmit" name="signup_btnsubmit">Sign up now</button>

						<? if (isset($errors)) { echo "<span style='margin-left:5px;' class='label lred'><i class='fa fa-times fa-fw'></i>&nbsp;Error creating user</span>"; } ?>
					</form>

	              	</div>
	              	<!-- /.col-lg-12 -->
	          	</div>
	          	<!-- /.row -->





