	        	<div class="row">
	                	<div class="col-lg-12">
	                   		<h1 class="page-header">Confirm email address</h1>
	                	</div>
	                	<!-- /.col-lg-12 -->
	            	</div>
	            	<!-- /.row -->


	            	<div class="row">
	                	<div class="col-lg-12">

					<? if(isset($ok)){?>
						<p><span class='label lgreen'><i class='fa fa-check fa-fw'></i>&nbsp;Thanks for the confirmation email addresses!</span></p>
						<p>You have successfully confirmed your email.</p>
						<p><a href="/"><i class='fa fa-angle-left fa-fw'></i>&nbsp;Go back to main page.</a></p>
					<?}?>
					<? if(isset($error)){?>
						<p><span class='label lred'><i class='fa fa-times fa-fw'></i>&nbsp;Error. Email address is not confirmed!</span></p>
						<p>You are unable to confirm your email.</p>
						<p><a href="/"><i class='fa fa-angle-left fa-fw'></i>&nbsp;Go back to main page.</a></p>
					<?}?>

				</div>
			</div>



