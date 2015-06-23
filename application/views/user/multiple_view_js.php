<script type="text/javascript">
	$(document).ready(function(){
		refreshTable();
		$('#tableHolder').load('/ajax/usertablemultiple');

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
			url 			: '/ajax/checknewevents',
			dataType 	: 'json',
			cache		: false,
			success 	: function(data)
			{
				if(data.result != 'FALSE') {
					$('#tableHolder').load('/ajax/usertablemultiple');
					if (data.result != '') {
						show_notify(data.result, data.result_title);
					}
				}

			}
		});
		setTimeout(function(){refreshTable();}, 5000);
    	}


    	function checkrate() {
		var checkBoxes = document.getElementsByTagName('input');
		        //alert(checkBoxes.length);
			var sumrate = 0;
			for (var counter=0; counter < checkBoxes.length; counter++) {
		                if (checkBoxes[counter].type.toUpperCase()=='CHECKBOX' && checkBoxes[counter].checked == true) {
		                       sumrate += parseFloat(checkBoxes[counter].value.substring(2));
		                }
			}
		return sumrate.toFixed(3);
    	}


	function checkgroup(cb) {
		if (cb.checked)
		{
			var group = "input:checkbox[name='" + cb.name + "']";
		       $(group).prop("checked", false);
		       $(cb).prop("checked", true);
		       var rate = checkrate();
		       var sum = $('#summultiple').val();
		       if (sum > 0)
		       	document.getElementById('prize').innerHTML = rate+" * "+sum+" = "+(rate*sum).toFixed(2)+"$";
		       else
		       	document.getElementById('prize').innerHTML = '';
		} else {
			$(cb).prop("checked", false);
			document.getElementById('prize').innerHTML = '';
		}
	}


	function summultiple(rate)
	{
		$('#summultiple').bind("change keyup input", function() {

			if (this.value > 0 && rate > 0) {
				document.getElementById('prize').innerHTML = rate+" * "+this.value+" = "+(rate*this.value).toFixed(2)+"$";
				// $("#sum-r1"+e).css( "border-color", "#0cc431" );
				// $("#sum-r1"+e).css( "color", "#0cc431" );
			} else {
				// $("#sum-r1"+e).css( "border-color", "#ccc" );
				// $("#sum-r1"+e).css( "color", "#555" );
				document.getElementById('prize').innerHTML = '';
			}
		});
	}












  //   	function makemultibets() {
  //   		// id матча [n rate][rate]
  //   		// sum
  //   		// при не совпадении rates выводить сообщение

  //   	}






</script>