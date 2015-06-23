<div class="page-header">
	<div class="pull-left">
		<h1>Close matches</h1>
	</div>
	<div class="pull-right">

	</div>
</div>

<div class="box box-bordered box-color lightgrey">
	<div class="box-content nopadding">
		<ul class="tabs tabs-inline tabs-top">
			<li class='active'>
				<a href="#maintable" data-toggle='tab'><i class="icon-reorder"></i> Main table </a>
			</li>
			<li>
				<a href="#express" data-toggle='tab'><i class=" icon-check"></i> Multiple bets </a>
			</li>
			<li>
				<a href="#events" data-toggle='tab'><i class="icon-trophy"></i> Champion </a>
			</li>
		</ul>
		<div class="tab-content padding tab-content-inline tab-content-bottom">
			<div class="tab-pane active" id="maintable">
				<div class="box-content nopadding">
					<p><? echo date('d.m.Y H:i',time()); ?></p>
					<p><a href="/mroom/matches">&raquo; Добавить матч</a></p>
					<table class="table table-hover table-nomargin table-condensed">
						<thead>
							<tr>
								<th>
				<select name="UTC" size="1" id="setUTC" onchange="mroomUTC(this)">
					<?foreach($UTC as $item){
						if (isset($_SESSION['utc_user']) && $_SESSION['utc_user'] == $item->value) {?>
							<option selected value="<?=$item->value?>"><?=$item->name?></option>	
						<?} else {?>
							<option value="<?=$item->value?>"><?=$item->name?></option>
						<?}}?>
				</select>
								</th>	
								<th style='border-right:1px dotted #bbb;'>IDmatch</th>
								<th>Best of</th>
								<th colspan='2' style='border-left:1px dotted #bbb;'>Player #1</th>
								<th colspan='2' style='border-left:1px dotted #bbb;'>Player #2</th>
								<th style='border-left:1px dotted #ccc; border-right:1px dotted #ccc;'>Draw</th>

								<th>Max, mrg</th>
								<th>Event</th>

								<th>State</th>
							</tr>
						</thead>


						<tbody id="tableHolder">
						</tbody>


					</table>


				</div>
			</div>
			<div class="tab-pane" id="express">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto vel labore sed odio laudantium in eum aliquid reiciendis blanditiis consequatur excepturi dicta quisquam soluta quis neque nostrum expedita temporibus illum aliquam voluptatibus a cumque sit nulla et consectetur ex maiores sequi culpa suscipit. Voluptate quae id consequatur consequuntur exercitationem cumque beatae obcaecati 
			</div>
			<div class="tab-pane" id="events">
				bo ut ad accusamus neque. Commodi ipsam quia aperiam nisi id unde sapiente 
			</div>
		</div>
	</div>
</div>


<a href="/mroom/matches">&raquo; Добавить матч</a><br/><br/>

<script type="text/javascript">
	$(document).ready(function(){
		refreshTable();
		refresh5min();
	 });

    	function refreshTable(){
		$.ajax({
			type 		: 'POST',
			url 		: '/ajax/checknewevents',
			dataType 	: 'json',
			cache		: false,
			success 	: function(data) 
			{
				if(data.result)
				{
					$('#tableHolder').load('/mroom/jx/oldmatchtable');
					
				} 
			}
		});
		setTimeout(function(){refreshTable();}, 5000);
    	}

	function refresh5min(){
	   	$('#tableHolder').load('/mroom/jx/oldmatchtable');
	    	setTimeout(function(){refresh5min();}, 5 * 60 * 1000);    	
	}


	function mroomUTC(i) {

		selNum = i.value;

		$.ajax({
			type 		: 'POST',
			data 		: "selNum=" + selNum,
			url 		: '/ajax/setUTC',
			dataType 	: 'json',
			cache		: false,
			success 	: function(data) 
			{
				if(data.result)
				{
					$('#tableHolder').load('/mroom/jx/oldmatchtable');
				} 
			}
		});
	}


	function goedit(e)
	{
		document.location.href = '/mroom/matches/edit/'+e;
	}	


</script>