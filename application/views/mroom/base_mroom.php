<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<title>Clanbets.com - ADMIN</title>

	<!-- Bootstrap -->
	<link rel="stylesheet" href="/src/src_mroom/css/bootstrap.min.css">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="/src/src_mroom/css/bootstrap-responsive.min.css">
	<!-- jQuery UI -->
	<link rel="stylesheet" href="/src/src_mroom/css/plugins/jquery-ui/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="/src/src_mroom/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
	<link rel="stylesheet" href="/src/src_mroom/js/plugins/gritter/css/jquery.gritter.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="/src/src_mroom/css/style-fonts.css">
	<!-- Theme CSS -->
	<link rel="stylesheet" href="/src/src_mroom/css/style.css">
	<link rel="stylesheet" href="/src/src_mroom/css/chosen.css">
	<!-- Color CSS -->
	<link rel="stylesheet" href="/src/src_mroom/css/themes.css">
	<!-- Other CSS -->
	<link rel="stylesheet" href="/src/src_mroom/css/other.css">

	<!-- jQuery -->
	<script src="/src/src_mroom/js/jquery.min.js"></script>
	<!-- Nice Scroll -->
	<script src="/src/src_mroom/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
	<!-- jQuery UI -->
	<script src="/src/src_mroom/js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
	<script src="/src/src_mroom/js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
	<script src="/src/src_mroom/js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
	<script src="/src/src_mroom/js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
	<script src="/src/src_mroom/js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
	<!-- slimScroll -->
	<script src="/src/src_mroom/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Bootstrap -->
	<script src="/src/src_mroom/js/bootstrap.min.js"></script>
	<!-- Form -->
	<script src="/src/src_mroom/js/plugins/form/jquery.form.min.js"></script>
	<!-- Notify -->
	<script src="/src/src_mroom/js/plugins/gritter/js/jquery.gritter.min.js"></script>
	<script src="/src/src_mroom/js/notify.min.js"></script>

	<!-- Theme scripts -->
	<script src="/src/src_mroom/js/application.min.js"></script>
	<!-- Just for demonstration -->
	<script src="/src/src_mroom/js/demonstration.min.js"></script>
	<!-- other js -->
	<script src="/src/src_mroom/js/other.js"></script>

	<!-- ADMIN -->
		<script src="/src/src_mroom/js/datetime/jquery.datetimeentry.js"></script>

		<!-- dataTables -->
		<script src="/src/src_mroom/js/datatable/jquery.dataTables.min.js"></script>
		<script src="/src/src_mroom/js/datatable/jquery.dataTables.grouping.js"></script>
		<script src="/src/src_mroom/js/datatable/chosen.jquery.min.js"></script>
		<script src="/src/src_mroom/js/datatable/TableTools.min.js"></script>
		<script src="/src/src_mroom/js/datatable/jquery.dataTables.columnFilter.js"></script>
		<script src="/src/src_mroom/js/jquery.maskedinput.min.js"></script>


	<!--[if lte IE 9]>
		<script src="/src/src_mroom/js/plugins/placeholder/jquery.placeholder.min.js"></script>
		<script>
			$(document).ready(function() {
				$('input, textarea').placeholder();
			});
		</script>
	<![endif]-->

	<script type="text/javascript">

		$(document).ready(function(){
						//  LOGIN
			$('#form_login').submit(function(event) {

				// get the form data
				var formData = {
					'login': $("#login").val(),
					'password': $("#password").val(),
					'remember': $("#remember").is(':checked')
				};

				// process the form
				$.ajax({
					type 		: 'POST',
					url 		: '/ajax/login',
					data 		: formData,
					dataType 	: 'json',
					success 	: function(data)
					{
						if(!data.result)
						{
							$( ".ctrl_1" ).addClass( "error" );
							$(".errorlogin").css('display','inline');
							$(".errorlogin").html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="icon-warning-sign"></i> Incorrect username (email) or password</div>');
						} else {
							location.reload();
						}
					}
				});

				// stop the form from submitting and refreshing
				event.preventDefault();
			});

			$('.dropdown  .dropdown-menu').click(function(event) {
				event.stopPropagation();	//off dropup
			});
			$(".control-group").click(function(){
				$( ".control-group" ).removeClass( "error" );
				$(".errorlogin").css('display','none');
			});

									//  ENDLOGIN
			fulltime();
			refreshCountCashout();
			refreshCountCancelBet();
			refreshCountMessages();
		});

		function fulltime()
		{
			var time=new Date();
			document.getElementById( "utcTime" ).innerHTML = time.toUTCString();
			setTimeout(function(){fulltime();}, 1000);
		}

		function refreshCountCashout(){

			var count = $('#countCashouts').html()

			$.ajax({
				type 		: 'POST',
				url 		: '/mroom/jx/checkCountCashout',
				data 		: "count=" + count,
				dataType 	: 'json',
				cache		: false,
				success 	: function(data)
				{
					if(data.result != count)
					{
						document.getElementById('countCashouts').innerHTML = data.result;
					}
				}
			});
			setTimeout(function(){refreshCountCashout();}, 5000);
	    	}

		function refreshCountCancelBet(){

			var count = $('#countCancelbets').html()

			$.ajax({
				type 		: 'POST',
				url 		: '/mroom/jx/checkCountCancelBet',
				data 		: "count=" + count,
				dataType 	: 'json',
				cache		: false,
				success 	: function(data)
				{
					if(data.result != count)
					{
						document.getElementById('countCancelbets').innerHTML = data.result;
					}
				}
			});
			setTimeout(function(){refreshCountCancelBet();}, 5000);
	    	}

		function refreshCountMessages(){

			var count = $('#countMessages').html()

			$.ajax({
				type 		: 'POST',
				url 		: '/mroom/jx/checkCountMessages',
				data 		: "count=" + count,
				dataType 	: 'json',
				cache		: false,
				success 	: function(data)
				{
					if(data.result != count)
					{
						document.getElementById('countMessages').innerHTML = data.result;
					}
				}
			});
			setTimeout(function(){refreshCountMessages();}, 5000);
	    	}

		function cancelbetYES(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/cancelbetYES",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						document.getElementById('xid-'+e).style.display = 'none';
						document.getElementById('cancel-'+e).className = "label cancelbetYES";
						document.getElementById('cancel-'+e).innerHTML = 'Cancel';
						document.getElementById('xidNo-'+e).style.display = 'none';
					} else {

					}
				}
			})
		}


		function cancelbetNO(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/cancelbetNO",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						document.getElementById('xidNo-'+e).style.display = 'none';
						document.getElementById('cancel-'+e).className = "label label-satgreen";
						document.getElementById('cancel-'+e).innerHTML = 'No (Active)';
					} else {

					}
				}
			})
		}

		function match_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/matchstartstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmatch").removeClass( "btn-green" );
						$("#redirectmatch").addClass( "btn-red" );
						$("#redirectmatch").html('Стоп (Сделать матч активным для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmatch").removeClass( "btn-red" );
						$("#redirectmatch").addClass( "btn-green" );
						$("#redirectmatch").html('Старт (Начать матч)');
					}
				}
			})
		}

		function map1_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map1startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap1").removeClass( "btn-green" );
						$("#redirectmap1").addClass( "btn-red" );
						$("#redirectmap1").html('Стоп Map #1 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap1").removeClass( "btn-red" );
						$("#redirectmap1").addClass( "btn-green" );
						$("#redirectmap1").html('Старт Map #1');
					}
				}
			})
		}

		function map2_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map2startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap2").removeClass( "btn-green" );
						$("#redirectmap2").addClass( "btn-red" );
						$("#redirectmap2").html('Стоп Map #2 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap2").removeClass( "btn-red" );
						$("#redirectmap2").addClass( "btn-green" );
						$("#redirectmap2").html('Старт Map #2');
					}
				}
			})
		}

		function map3_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map3startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap3").removeClass( "btn-green" );
						$("#redirectmap3").addClass( "btn-red" );
						$("#redirectmap3").html('Стоп Map #3 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap3").removeClass( "btn-red" );
						$("#redirectmap3").addClass( "btn-green" );
						$("#redirectmap3").html('Старт Map #3');
					}
				}
			})
		}

		function map4_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map4startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap4").removeClass( "btn-green" );
						$("#redirectmap4").addClass( "btn-red" );
						$("#redirectmap4").html('Стоп Map #4 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap4").removeClass( "btn-red" );
						$("#redirectmap4").addClass( "btn-green" );
						$("#redirectmap4").html('Старт Map #4');
					}
				}
			})
		}

		function map5_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map5startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap5").removeClass( "btn-green" );
						$("#redirectmap5").addClass( "btn-red" );
						$("#redirectmap5").html('Стоп Map #5 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap5").removeClass( "btn-red" );
						$("#redirectmap5").addClass( "btn-green" );
						$("#redirectmap5").html('Старт Map #5');
					}
				}
			})
		}

		function map6_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map6startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap6").removeClass( "btn-green" );
						$("#redirectmap6").addClass( "btn-red" );
						$("#redirectmap6").html('Стоп Map #6 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap6").removeClass( "btn-red" );
						$("#redirectmap6").addClass( "btn-green" );
						$("#redirectmap6").html('Старт Map #6');
					}
				}
			})
		}

		function map7_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map7startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap7").removeClass( "btn-green" );
						$("#redirectmap7").addClass( "btn-red" );
						$("#redirectmap7").html('Стоп Map #7 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap7").removeClass( "btn-red" );
						$("#redirectmap7").addClass( "btn-green" );
						$("#redirectmap7").html('Старт Map #7');
					}
				}
			})
		}

		function map8_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map8startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap8").removeClass( "btn-green" );
						$("#redirectmap8").addClass( "btn-red" );
						$("#redirectmap8").html('Стоп Map #8 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap8").removeClass( "btn-red" );
						$("#redirectmap8").addClass( "btn-green" );
						$("#redirectmap8").html('Старт Map #8');
					}
				}
			})
		}

		function map9_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map9startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap9").removeClass( "btn-green" );
						$("#redirectmap9").addClass( "btn-red" );
						$("#redirectmap9").html('Стоп Map #9 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap9").removeClass( "btn-red" );
						$("#redirectmap9").addClass( "btn-green" );
						$("#redirectmap9").html('Старт Map #9');
					}
				}
			})
		}

		function map10_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map10startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap10").removeClass( "btn-green" );
						$("#redirectmap10").addClass( "btn-red" );
						$("#redirectmap10").html('Стоп Map #10 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap10").removeClass( "btn-red" );
						$("#redirectmap10").addClass( "btn-green" );
						$("#redirectmap10").html('Старт Map #10');
					}
				}
			})
		}

		function map11_startstop(e)
		{
			$.ajax({
				type: "POST",
				data: {id: e},
				url: "/mroom/jx/map11startstop",
				dataType: "json",
				async: false,
				success: function(data)
				{
					if (data.result == 1) {
						$("#redirectmap11").removeClass( "btn-green" );
						$("#redirectmap11").addClass( "btn-red" );
						$("#redirectmap11").html('Стоп Map #11 (Открыть для ставок)');
					}
					else if (data.result == 2)
					{
						$("#redirectmap11").removeClass( "btn-red" );
						$("#redirectmap11").addClass( "btn-green" );
						$("#redirectmap11").html('Старт Map #11');
					}
				}
			})
		}

		function btnsendmessage(e)
		{
			  var mess = $("#usermessage").val();
			  var res = $.ajax({
			      type: "POST",
		      		data: {
					usermessage: mess,
					id: e
				},
			      url: "/mroom/jx/usermessage",
			      dataType: "json",
			      async: false,
			      success: function(data)
			      {
			          if(data.result == 1) {
			              $('#wallmess').load('/mroom/jx/wallmessadmin', {id: e});
			              $("#usermessage").val('');
			          } else if (data.result == 3) {
			              $("#messerror").html('<i class="fa fa-times fa-fw"></i>&nbsp;The maximum message length of 5000 characters');
			          } else if (data.result == 0) {
			              $("#messerror").html('<i class="fa fa-times fa-fw"></i>&nbsp;Error sending');
			          }
			      }
			  })
			  return res.responseText;
		}


		function refreshchat(e){
			$('#wallmess').load('/mroom/jx/wallmessadmin', {id: e});
			setTimeout(function(){refreshchat(e);}, 10000);
		}

	</script>

	<link rel="icon" href="/src/img/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/src/img/favicon.ico" type="image/x-icon">
</head>

<body data-layout="fixed" class='theme-grey'>
	<div id="navigation">
		<div class="container-fluid">
			<a href="/mroom/" id="brand">ADMIN</a>
			<ul class='main-nav'>
				<li <? if (Request::current()->controller() == "Main") {echo "class='active'";}?>>
					<a href="/mroom/">
						<span>Bets table</span>
					</a>
				</li>
				<li <? if (Request::current()->controller() == "Users") {echo "class='active'";}?>>
					<a href="/mroom/users">
						<span>User table</span>
					</a>
				</li>
			</ul>

								<!-- Authorization -->
			<div class="user">

				<ul class="icon-nav">
					<a href="/mroom/users/" title="Непрочитанные сообщения"><span id="countMessages" class="label countcheckout lmessages">0</span></a>
					<a href="/mroom/users/" title="Заявки на отмену ставок"><span id="countCancelbets" class="label countcheckout cancelbetYES">0</span></a>
					<a href="/mroom/users/cashoutlist" title="Заявки вывод денег"><span id="countCashouts" class="label countcheckout">0</span></a>
					<span id="utcTime" class="label timerlabel"></span>
				</ul>


				<div class="dropdown">
					<a href="#" class='dropdown-toggle _link_login' data-toggle="dropdown"><span><?=Auth::instance()->get_user()->username?></span> <i class="icon-user"></i></a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="/auth/logout">Sign out</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>


	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			<div class="container-fluid">
				<?=$content ?>
			</div>
		</div>

		<div id="footer">
			<span style='float:right; margin-right:20px;'>mailto: <span class="email"><a href="mailto:support@clanbets.com">support@clanbets.com</a></span></span>
			<span style='float:left; margin-left:20px;'><a href="http://caxakrylov.dlinkddns.com/clanbets.com" title="eSports betting Dota2, StarCraft2, Counter-Strike GO, World of Tanks etc.">Clanbets.com</a> &copy; 2014</span>
			<div style="clear:both;"></div>
		</div>
	</div>



</body>
</html>