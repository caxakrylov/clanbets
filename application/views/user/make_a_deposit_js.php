<script type="text/javascript">
    	$(document).ready(function() {

    		$('#dataTable_dep').dataTable();

		var max = '999999999.99';
		$('#sum_deposit').autoNumeric('init', {aSep: '', vMax: max});
		$("#sum_deposit").blur(blur_check_sum);
		$('#deposit').submit(function(event) {
			var sum = blur_check_sum();

			if (sum) {
				//go deposit
			} else {
				event.preventDefault();
			}

		});


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


		// tooltip demo
		$('#deposit').tooltip({
			selector: "[data-toggle=tooltip]",
			container: "body"
		})

		$("[data-placement=right]").hover(function(){
		    $('.tooltip').css('text-align',parseInt($('.tooltip').css('left;')))
		});

    });

</script>
