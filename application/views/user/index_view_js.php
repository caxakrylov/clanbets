<script type="text/javascript">
	$(document).ready(function(){
		refreshTable();
		refresh5min();

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

		$("#descript").css('z-index','-5');
		$("#descript").css('position','absolute');
	});


	function show_notify(body,title_notify) {
		var stack_bottomleft = {"dir1": "right", "dir2": "up", "push": "top"};
		new PNotify({
				title: 'New match! '+title_notify,
				text: body,
				type: 'success',
				addclass: 'stack-bottomleft',
				icon: false,
				stack: stack_bottomleft
			});
	};


    	function refreshTable(){
		$.ajax({
			type 		: 'POST',
			url 		: '/ajax/checknewevents',
			dataType 	: 'json',
			cache		: false,
			success 	: function(data)
			{
				if(data.result != 'FALSE') {
					$('#tableHolder').load('/ajax/usertable');
					if (data.result != '') {
						show_notify(data.result, data.result_title);
					}
				}

			}
		});
		setTimeout(function(){refreshTable();}, 5000);
    	}


	function refresh5min(){
	   	$('#tableHolder').load('/ajax/usertable');
	    	setTimeout(function(){refresh5min();}, 5 * 60 * 1000);
	}

</script>