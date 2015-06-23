<script type="text/javascript">
    	$(document).ready(function() {

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

		$('#dataTable_cashout').dataTable();


		//visamastercard
		$("#ewallet_number").mask("9999999999999999?99",{placeholder:""});
		$("#ewallet_number").blur(blur_check_number);

		$("select#psystem").prop('selectedIndex', 0);

		var max = '999999999999.99';
		$('#sum_withdraw').autoNumeric('init', {aSep: '', vMax: max});

		$('#ewallet_number').keyup(function(){
			var selValue = $("select#psystem").val();

			var state = 0;

			if (selValue == 'webmoney') {
				if (this.value.length == 13) {
					state = 1;
				}
			} else if (selValue == 'yandexmoney') {
				if (this.value.length == 14) {
					state = 1;
				}
			} else if (selValue == 'visamastercard') {
				if (this.value.length == 16 || this.value.length == 18) {
					state = 1;
				}
			} else if (selValue == 'paypal') {
				if (this.value.length <= 100 && validateEmail(this.value)) {
					state = 1;
				}
			} else if (selValue == 'walletone') {
				if (this.value.length <= 100 && validateEmail(this.value)) {
					state = 1;
				}
			}

			if (state == 1) {
				$(".label_psystem").css( "color", "#0cc431" );
				$("#psystem").css( "border-color", "#0cc431" );
				$("#psystem").css( "color", "#0cc431" );

				$(".label_ewallet").css( "color", "#0cc431" );
				$("#ewallet_number").css( "border-color", "#0cc431" );
				$("#ewallet_number").css( "color", "#0cc431" );
			} else {
				$(".label_psystem").css( "color", "#BBB" );
				$("#psystem").css( "border-color", "#ccc" );
				$("#psystem").css( "color", "#555" );

				$(".label_ewallet").css( "color", "#BBB" );
				$("#ewallet_number").css( "border-color", "#ccc" );
				$("#ewallet_number").css( "color", "#555" );
			}
		});


		$('#cashout').submit(function(event) {
			var submit = <? echo "blur_check_submit(".$usermoney.",".$state_comm.",".$freemoney.")"; ?>

			if (submit) {
				//go deposit
			} else {
				event.preventDefault();
			}

		});

		document.getElementById('cashout').addEventListener('keypress', function(event) {
			if (event.keyCode == 13) {
				event.preventDefault();
			}
		});

    });

</script>
