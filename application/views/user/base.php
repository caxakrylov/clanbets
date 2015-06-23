<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" lang="en" content="ставки, киберспорт, betting, bets, e sport, dota2, cs go, starcraft 2, танки, деньги"/>
		<meta name="description" lang="en" content="Welcome to Clanbets.com, an online platform for betting on eSports events - Dota2, Counter-Strike GO, StarCraft2, World of Tanks, League of Legends and more"/>
		<meta name="ROBOTS" content="ALL"/>
		<meta name="author" content="clanbets.com">
		<link rel="icon" href="/src/img/favicon.ico" type="image/x-icon">

		<title>Clanbets.com - eSports betting, ставки на киберспорт Dota 2, ставки CS GO, StarCraft2, WoT, танки, дота 2.</title>

		<?=$css ?>

		<!-- MetisMenu CSS -->
		<link href="/src/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

		<!-- DataTables CSS -->
		<link href="/src/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

		<!-- multiselect CSS -->
		<link href="/src/css/plugins/bootstrap-select.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="/src/css/other.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="/src/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- notify CSS -->
		<link href="/src/css/plugins/pnotify.custom.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="/src/css/plugins/html5shiv.js"></script>
			<script src="/src/css/plugins/respond.min.js"></script>
		<![endif]-->
	</head>


<body>

	<div id="wrapper">

	       <!-- Navigation -->
	       <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	            	<div class="navbar-header">

		            	<ul class="nav navbar-top-links navbar-right">

					<?
						$auth = Auth::instance();
						if($auth->logged_in()) { //Пользователь залогинен
					?>
			          				<li class="dropdown" id="winsupport">
									<a class='dropdown-toggle' data-toggle="dropdown" href="#" onclick='supportwindow();'><i class="fa fa-envelope fa-fw"></i></a>
								</li>
						<?	echo '
								<li class="dropdown"> <!-- usermenu -->
								    	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								        	<i class="fa fa-user fa-fw"></i> [ <span class="greentext">$<span id="headermoney">';
											$mres = new Model_Resources();
											echo $mres->get_usermoney($auth->get_user()).'</span> Balance</span> ]
										<i class="fa fa-caret-down"></i>
								    	</a>
								    	<ul class="dropdown-menu dropdown-user">
										<li><a href="/user/mybets"><i class="fa fa-tasks fa-fw"></i> My bets</a></li>
										<li><a href="/user/deposit"><i class="fa fa-usd fa-fw"></i> Make a deposit</a></li>
										<li><a href="/user/cashout"><i class="fa fa-smile-o fa-fw"></i> Cash out</a></li>
										<li><a href="/check/termsofuse"><i class="fa fa-file-text-o fa-fw"></i> Terms of Use</a></li>
										<li><a href="/user/edit"><i class="fa fa-cog  fa-fw"></i> User profile</a></li>
										<li class="divider"></li>
										<li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout [ '.$auth->get_user()->username.' ]</a></li>
								    	</ul>
								</li>
							';
						} else {		//Пользователь не залогинен
							echo '
								<li class="dropdown"> <!-- loginmenu -->
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
										<i class="fa fa-sign-in fa-fw"></i> Login / Signup &nbsp;<i class="fa fa-caret-down"></i>
									</a>
									<ul class="dropdown-menu dropdown-login">
										<form role="form" id="form_login">
											<div class="col-xs-12 show_err_login"></div>
											<li class="col-xs-12 first"><input type="text" class="form-control" id="UserEmail" placeholder="Username or email"></li>
											<li class="col-xs-12"><input type="password" class="form-control" id="Password" placeholder="Password"></li>
											<li class="col-xs-12">
												<button  type="submit" class="btn btn-default" id="btn_login_check">Log in &nbsp;<i class="fa fa-sign-in"></i></button>
												<span>or</span>
												<a class="pull-right" href="/signup">Sign up &nbsp;<i class="fa fa-edit"></i></a>
											</li>
											<li class="col-xs-12">
												<div class="dline_small"></div>
											</li>
											<li class="col-xs-12">
												<a href="/signup/recoverypassword"><i class="fa fa-life-ring fa-fw"></i> Recovery password</a>
											</li>
										</form>
									</ul>
								</li>';
						}
					?>
				</ul>

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<a class="navbar-brand" href="/"><span class="headlogoimg"></span><span class="headlogotext">CLANBETS</span></a>

	            	</div>
	            <!-- /.navbar-header -->


	            	<div class="navbar-default sidebar" role="navigation">
	                	<div class="sidebar-nav navbar-collapse">
	                    	<ul class="nav" id="side-menu">
		                        	<li>
		                            	<a <? if (Request::current()->controller() == "Maintable") {echo "class='active'";} ?> href="/"><i class="fa fa-table fa-fw"></i> Main table</a>
		                        	</li>
		                        	<li>
		                            	<a <? if (Request::current()->controller() == "Multiple") {echo "class='active'";} ?> href="/multiple"><i class="fa fa-cubes fa-fw"></i> Multiple bets</a>
		                        	</li>
		                        	<li>
		                            	<a <? if (Request::current()->controller() == "Champion") {echo "class='active'";} ?> href="/champion"><i class="fa fa-trophy fa-fw"></i> Winner of the event</a>
		                        	</li>
		                        	<li style="border-top:1px solid #808080;">
		                            	<a <? if (Request::current()->controller() == "Promotions") {echo "class='active'";} ?> href="/promotions"><i class="fa fa-bullhorn fa-fw"></i> Information and Bonuses</a>
		                        	</li>
		                        	<!--
			                   	<li>
			                          <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
			                   	       	<ul class="nav nav-second-level">
			                                		<li>
			                                    		<a href="blank.html">Blank Page</a>
			                                		</li>
			                                		<li>
			                                    		<a href="login.html">Login Page</a>
			                                		</li>
			                            	</ul>
			                   	</li>-->
	                    	</ul>
	                	</div>
	            	</div>
        	</nav>
            <!-- navigation ################################################################################ -->


	      	<div id="page-wrapper">
	      		<?=$content ?>
	      	</div>


	      	<div id="site-footer">

			<span style='float:right; margin-right:20px;'>
				<span class="email">

				</span>
			</span>

			<span style='float:right; margin-right:20px;'>
				<span class="email">
					mailto:
					<a href="mailto:support@clanbets.com" title="Как сделать ставку на киберспорт, dota 2, cs go, wot, танки">support@clanbets.com</a>
				</span>
			</span>


			<span style='float:left; margin-left:20px;'>
				Clanbets.com &copy; 2014
			</span>
	      	</div>

    	</div>
    	<!-- /#wrapper -->

	<!-- jQuery Version 1.11.0 -->
	<script src="/src/js/jquery-1.11.0.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="/src/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="/src/js/plugins/metisMenu/metisMenu.min.js"></script>

	<!-- DataTables JavaScript -->
	<script src="/src/js/plugins/dataTables/jquery.dataTables.js"></script>
	<script src="/src/js/plugins/dataTables/dataTables.bootstrap.js"></script>

	<!-- amount validation -->
	<script src="/src/js/plugins/autoNum/autoNumeric.js"></script>

	<!-- Multiselect -->
	<script src="/src/js/plugins/bootstrap-select.min.js"></script>

	<!-- Maskedinput -->
	<script src="/src/js/plugins/jquery.maskedinput.min.js"></script>

	<!-- Notify -->
	<script src="/src/js/plugins/pnotify.custom.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="/src/js/other.js"></script>


	<?
		if($auth->logged_in()) {
	?>
			<script type="text/javascript">
				$(document).ready(function(){
					refreshMoney();
				});
			</script>
	<?
		} else {
	?>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#PromoModal').modal({
						keyboard: false,
						backdrop: 'static'
					});
				});
			</script>
	<?
		}
	?>

	<?=$js ?>
</body>

</html>






































































