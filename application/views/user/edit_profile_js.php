<script type="text/javascript">
	$(document).ready(function(){

		$(window).bind("load resize", function() {
			topOffset = 50;
			width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
			if (width < 1360) {
			    	$('div.navbar-collapse').addClass('collapse')
			    	topOffset = 100; // 2-row-menu
			} else {
			   	$('div.navbar-collapse').removeClass('collapse')
			}

			height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
			height = height - topOffset;
			if (height < 1) height = 1;
			if (height > topOffset) {
			    	$("#page-wrapper").css("min-height", (height) + "px");
			}
		})


		$('#verifymail').click(function(){
			$.ajax({
				type 		: 'POST',
				url 		: '/ajax/verifymail',
				dataType 	: 'json',
				cache		: false,
				success 	: function(data)
				{
					if(data.result)
					{
						$('#verifymail').css('display','none');
						$('#verifymailOK').css('display','inline');
					}
				}
			});
		});


		$("#current_password").blur(check_edit_currentpassword);
		$("#signup_password").blur(check_signup_password);
		$("#signup_password2").blur(check_signup_password2);


		$('#changepassword').submit(function(event) {
			var current_password = check_edit_currentpassword();
			var new_password = check_signup_password();
			var password2 = check_signup_password2();

			if (current_password[10]  == 1 && new_password[10] == 3 && password2 == 1) {
				//go reg
			} else {
				event.preventDefault();
			}

		});

	});
</script>
