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


		$("#signup_login").blur(check_signup_login);
		$("#signup_email").blur(check_signup_email);
		$("#signup_password").blur(check_signup_password);
		$("#signup_password2").blur(check_signup_password2);
		$("#signup_terms").click(check_signup_terms);


		$('#signup_form').submit(function(event) {
			var login = check_signup_login();
			var email = check_signup_email();
			var password = check_signup_password();
			var password2 = check_signup_password2();
			var terms = check_signup_terms();
			if (login[10] == 5 && email[10] == 4 && password[10] == 3 && password2 == 1 && terms ==1) {
				//go reg
			} else {
				event.preventDefault();
			}
		});


	});
</script>
