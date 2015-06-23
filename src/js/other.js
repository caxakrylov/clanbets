$(function() {

    	$('#side-menu').metisMenu();

    	//  LOGIN
    	$('#form_login').submit(function(event) {

	       // get the form data
	       var formData = {
	            	'login': $("#UserEmail").val(),
	            	'password': $("#Password").val()
	       };

	       $.ajax({
	            	type        : 'POST',
	            	url             : '/ajax/login',
	            	data        : formData,
	            	dataType    : 'json',
	            	success     : function(data)
	            	{
		             if(!data.result)
	             	{
	                   	 	$( "#form_login" ).addClass( "has-error" );
	                    	$( ".navbar-top-links .dropdown-login li.first" ).addClass( "nomargintop" );
	                    	$(".show_err_login").css('display','inline');
	                    	$(".show_err_login").html('<div class="alert alert-danger">Incorrect username (email) or password</div>');
	                	}
	                		else
	                	{
	                    	// location.reload();
	                    	location.assign("/");
	                	}
	            	}
	      	});

        	// stop the form from submitting and refreshing
        	event.preventDefault();
    	});


	$("#form_login").click(function(){
		$( "#form_login" ).removeClass( "has-error" );
		$(".show_err_login").css('display','none');
	});


	if (document.getElementById('setUTC')) {
		document.getElementById('setUTC').disabled = false;
	}


	$( ".selectpicker" ).change(function () {
		var values = "";
		$( ".selectpicker option:selected" ).each(function() {
			values += $(this).val()+',';
		});

		$.ajax({
			type 		: 'POST',
			data 		: "id=" + values,
			url 			: '/ajax/setDisciplines',
			dataType 	: 'json',
			cache		: false,
			success 	: function(data)
			{
				if(data.result)
				{
					$('#tableHolder').load('/ajax/usertable');
				}
			}
		});
	})

	setTimeout(function(){loadfooter();}, 3000);

})

function loadfooter(){
	$("#site-footer").css('display','inline');
}


function sUTC(i) {

	selNum = i.value;

	$.ajax({
		type 		: 'POST',
		data 		: "selNum=" + selNum,
		url 			: '/ajax/setUTC',
		dataType 	: 'json',
		cache		: false,
		success 	: function(data)
		{
			if(data.result)
			{
				$('#tableHolder').load('/ajax/usertable');
			}
		}
	});
}


function refreshMoney() {

	var t = document.getElementById('headermoney').innerHTML;

	$.ajax({
		type 		: 'POST',
		url 		: '/ajax/checkusermoney',
		data 		: "money=" + t,
		dataType 	: 'json',
		cache		: false,
		success 	: function(data)
		{
			if(data.result != t)
			{
				document.getElementById('headermoney').innerHTML = data.result;
			}
		}
	});

	setTimeout(function(){refreshMoney();}, 5000);
}


function betswindow(e)
{
	if (!document.getElementById('setUTC').disabled)
	{
		document.getElementById('setUTC').disabled = true;
		$.get("/ajax/betswindow", {id : e},
			function(data) {
				$(data).modal({
					keyboard: false,
					backdrop: 'static'
				});
			}
		)
	}
}

function supportwindow()
{
	if (!document.getElementById('winsupport').disabled)
	{
		document.getElementById('winsupport').disabled = true;
		$.get("/ajax/supportwindow",
			function(data) {
				$(data).modal({
					keyboard: false,
					backdrop: 'static'
				});
			}
		)
	}
}

function btnsendmessage()
{
	var mess = $("#usermessage").val();
	var res = $.ajax({
		type: "POST",
		data: "usermessage=" + mess,
		url: "/ajax/usermessage",
		dataType: "json",
		async: false,
		success: function(data)
		{
			if(data.result == 1) {
				$('#wallmess').load('/ajax/wallmess');
				$("#usermessage").val('');
				$("#usermessage").focus();
			} else if (data.result == 3) {
				$("#messerror").html('<i class="fa fa-times fa-fw"></i>&nbsp;The maximum message length of 5000 characters');
			} else if (data.result == 0) {
				$("#messerror").html('<i class="fa fa-times fa-fw"></i>&nbsp;Error sending');
			}
		}
	})
	return res.responseText;
}


function setfocusarea()
{
	$("#usermessage").focus();
}


function betsinit(UTCmatch, id)
{
   	$('#tablemadebets').load('/ajax/madebets', {id: id});

	var maxbet = document.getElementById( "maxbet1" ).textContent;

	$('#sum-r11').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r21').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-d1').autoNumeric('init', {aSep: '', vMax: maxbet});

	for ( var z = 101; z <= 111; z++ ) {
		$('#sum-r1'+z).autoNumeric('init', {aSep: '', vMax: maxbet});
		$('#sum-r2'+z).autoNumeric('init', {aSep: '', vMax: maxbet});
	}

	$('#sum-r13').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r23').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r15').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r25').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r17').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r27').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r19').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r29').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r111').autoNumeric('init', {aSep: '', vMax: maxbet});
	$('#sum-r211').autoNumeric('init', {aSep: '', vMax: maxbet});
	bettimer(UTCmatch);
}


function bettimer(UTCmatch)
{
	var match = UTCmatch * 1000;
	var today = new Date().getTime();

	var totalRemains = match-today;

	if (totalRemains>1)
	{
		var RemainsSec=(parseInt(totalRemains/1000));
		var RemainsFullDays=(parseInt(RemainsSec/(24*60*60)));
		var secInLastDay=RemainsSec-RemainsFullDays*24*3600;
		var RemainsFullHours=(parseInt(secInLastDay/3600));
		if (RemainsFullHours<10){RemainsFullHours="0"+RemainsFullHours};
		var secInLastHour=secInLastDay-RemainsFullHours*3600;
		var RemainsMinutes=(parseInt(secInLastHour/60));
		if (RemainsMinutes<10){RemainsMinutes="0"+RemainsMinutes};
		var lastSec=secInLastHour-RemainsMinutes*60;
		if (lastSec<10){lastSec="0"+lastSec};
		if (RemainsFullDays == 1) {RemainsFullDays = RemainsFullDays+' day ';} else if (RemainsFullDays == 0) {RemainsFullDays = '';} else {RemainsFullDays = RemainsFullDays+' days ';}

		document.getElementById('btimer').innerHTML = RemainsFullDays+RemainsFullHours+":"+RemainsMinutes+":"+lastSec;
		setTimeout(function(){bettimer(UTCmatch);}, 1000);
	}
	else {document.getElementById("btimer").innerHTML = "";}
}


function closebet()
{
	$('#Modalbet').on('hidden.bs.modal', function(){
		$(this).remove();
	});
	document.getElementById('setUTC').disabled = false;
}

function closesupport()
{
	$('#Modalsupport').on('hidden.bs.modal', function(){
		$(this).remove();
	});
	document.getElementById('winsupport').disabled = false;
}

function clearAccord(e)
{
	var accordion = document.getElementById( 'accordion2' );
	var input = accordion.getElementsByTagName( 'input' );
	for ( var z = 0; z < input.length; z++ ) {
		input[z].value = '';
		input[z].style.border = "1px solid #ccc"
		input[z].style.color = "#555";
	}
	document.getElementById('infomessage'+e).innerHTML = '';
	document.getElementById('infomessage'+e).className = "";
}


function btngobets(e)
{

	var draw = 0;

	if (document.getElementById("collapse1")) {
		if (document.getElementById("collapse1").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r11" ).value;
			var sum2 = document.getElementById( "sum-r21" ).value;
			if (document.getElementById( "sum-d1" )) {
				draw = document.getElementById( "sum-d1" ).value;
			}
			var rate1 = document.getElementById("r011").textContent;
			var rate2 = document.getElementById("r021").textContent;
			var typebet = 1;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse101")) {
		if (document.getElementById("collapse101").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1101" ).value;
			var sum2 = document.getElementById( "sum-r2101" ).value;
			var rate1 = document.getElementById("r01101").textContent;
			var rate2 = document.getElementById("r02101").textContent;
			var typebet = 101;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse102")) {
		 if (document.getElementById("collapse102").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1102" ).value;
			var sum2 = document.getElementById( "sum-r2102" ).value;
			var rate1 = document.getElementById("r01102").textContent;
			var rate2 = document.getElementById("r02102").textContent;
			var typebet = 102;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse103")) {
		if (document.getElementById("collapse103").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1103" ).value;
			var sum2 = document.getElementById( "sum-r2103" ).value;
			var rate1 = document.getElementById("r01103").textContent;
			var rate2 = document.getElementById("r02103").textContent;
			var typebet = 103;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse104")) {
		if (document.getElementById("collapse104").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1104" ).value;
			var sum2 = document.getElementById( "sum-r2104" ).value;
			var rate1 = document.getElementById("r01104").textContent;
			var rate2 = document.getElementById("r02104").textContent;
			var typebet = 104;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse105")) {
		if (document.getElementById("collapse105").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1105" ).value;
			var sum2 = document.getElementById( "sum-r2105" ).value;
			var rate1 = document.getElementById("r01105").textContent;
			var rate2 = document.getElementById("r02105").textContent;
			var typebet = 105;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse106")) {
		if (document.getElementById("collapse106").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1106" ).value;
			var sum2 = document.getElementById( "sum-r2106" ).value;
			var rate1 = document.getElementById("r01106").textContent;
			var rate2 = document.getElementById("r02106").textContent;
			var typebet = 106;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse107")) {
		if (document.getElementById("collapse107").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1107" ).value;
			var sum2 = document.getElementById( "sum-r2107" ).value;
			var rate1 = document.getElementById("r01107").textContent;
			var rate2 = document.getElementById("r02107").textContent;
			var typebet = 107;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse108")) {
		if (document.getElementById("collapse108").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1108" ).value;
			var sum2 = document.getElementById( "sum-r2108" ).value;
			var rate1 = document.getElementById("r01108").textContent;
			var rate2 = document.getElementById("r02108").textContent;
			var typebet = 108;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse109")) {
		if (document.getElementById("collapse109").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1109" ).value;
			var sum2 = document.getElementById( "sum-r2109" ).value;
			var rate1 = document.getElementById("r01109").textContent;
			var rate2 = document.getElementById("r02109").textContent;
			var typebet = 109;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse110")) {
		if (document.getElementById("collapse110").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1110" ).value;
			var sum2 = document.getElementById( "sum-r2110" ).value;
			var rate1 = document.getElementById("r01110").textContent;
			var rate2 = document.getElementById("r02110").textContent;
			var typebet = 110;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse111")) {
		if (document.getElementById("collapse111").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r1111" ).value;
			var sum2 = document.getElementById( "sum-r2111" ).value;
			var rate1 = document.getElementById("r01111").textContent;
			var rate2 = document.getElementById("r02111").textContent;
			var typebet = 111;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse3")) {
		if (document.getElementById("collapse3").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r13" ).value;
			var sum2 = document.getElementById( "sum-r23" ).value;
			var rate1 = document.getElementById("r013").textContent;
			var rate2 = document.getElementById("r023").textContent;
			var typebet = 3;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse5")) {
		if (document.getElementById("collapse5").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r15" ).value;
			var sum2 = document.getElementById( "sum-r25" ).value;
			var rate1 = document.getElementById("r015").textContent;
			var rate2 = document.getElementById("r025").textContent;
			var typebet = 5;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse7")) {
		if (document.getElementById("collapse7").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r17" ).value;
			var sum2 = document.getElementById( "sum-r27" ).value;
			var rate1 = document.getElementById("r017").textContent;
			var rate2 = document.getElementById("r027").textContent;
			var typebet = 7;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse9")) {
		if (document.getElementById("collapse9").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r19" ).value;
			var sum2 = document.getElementById( "sum-r29" ).value;
			var rate1 = document.getElementById("r019").textContent;
			var rate2 = document.getElementById("r029").textContent;
			var typebet = 9;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
	if (document.getElementById("collapse11")) {
		if (document.getElementById("collapse11").className == 'panel-collapse collapse in') {
			var sum1 = document.getElementById( "sum-r111" ).value;
			var sum2 = document.getElementById( "sum-r211" ).value;
			var rate1 = document.getElementById("r0111").textContent;
			var rate2 = document.getElementById("r0211").textContent;
			var typebet = 11;
			ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet);
			return;
		}
	}
}


function ajaxgobets(e, sum1, sum2, draw, rate1, rate2, typebet) {
	$.ajax({
		type: "POST",
		data: {
			id: e,
			sum1: sum1,
			sum2: sum2,
			draw: draw,
			rate1: rate1,
			rate2: rate2,
			typebet: typebet
		},
		url: "/ajax/gobets",
		dataType: "json",
		async: false,
		success: function(data)
		{
			if (typebet == 1) {
				document.getElementById('infomessage1').innerHTML = '';
				document.getElementById('infomessage1').className = "";
				if (data.result == 0) {
					document.getElementById('infomessage1').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage1').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage1').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage1').className = "betsinfo";
					document.getElementById('r011').innerHTML = data.data_rate['rate1'];
					document.getElementById('r021').innerHTML = data.data_rate['rate2'];
					if (data.data_rate['draw'] != undefined) {
						document.getElementById('d011').innerHTML = data.data_rate['draw'];
					}
				} else if (data.result == 1) {
					document.getElementById('infomessage1').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage1').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage1').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage1').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage1').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage1').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage1').innerHTML = 'Sorry, the match has already started';
					document.getElementById('infomessage1').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage1').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage1').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r011').innerHTML = data.new_rate['rate1'];
					document.getElementById('r021').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r11" ).value = '';
					document.getElementById( "sum-r21" ).value = '';
					if (data.new_rate['ratedraw'] != 0.000) {
						document.getElementById('d011').innerHTML = data.new_rate['ratedraw'];
						document.getElementById( "sum-d1" ).value = '';
					}
				}

			} else if (typebet == 3) {
				document.getElementById('infomessage3').innerHTML = '';
				document.getElementById('infomessage3').className = "";
				if (data.result == 0) {
					document.getElementById('infomessage3').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage3').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage3').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage3').className = "betsinfo";
					document.getElementById('r013').innerHTML = data.data_rate['rate13'];
					document.getElementById('r023').innerHTML = data.data_rate['rate23'];
				} else if (data.result == 1) {
					document.getElementById('infomessage3').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage3').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage3').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage3').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage3').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage3').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage3').innerHTML = 'Sorry, the match has already started';
					document.getElementById('infomessage3').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage3').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage3').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r013').innerHTML = data.new_rate['rate1'];
					document.getElementById('r023').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r13" ).value = '';
					document.getElementById( "sum-r23" ).value = '';
				}

			} else if (typebet == 5) {

				if (data.result == 0) {
					document.getElementById('infomessage5').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage5').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage5').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage5').className = "betsinfo";
					document.getElementById('r015').innerHTML = data.data_rate['rate15'];
					document.getElementById('r025').innerHTML = data.data_rate['rate25'];
				} else if (data.result == 1) {
					document.getElementById('infomessage5').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage5').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage5').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage5').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage5').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage5').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage5').innerHTML = 'Sorry, the match has already started';
					document.getElementById('infomessage5').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage5').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage5').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r015').innerHTML = data.new_rate['rate1'];
					document.getElementById('r025').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r15" ).value = '';
					document.getElementById( "sum-r25" ).value = '';
				}

			} else if (typebet == 7) {

				if (data.result == 0) {
					document.getElementById('infomessage7').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage7').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage7').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage7').className = "betsinfo";
					document.getElementById('r017').innerHTML = data.data_rate['rate17'];
					document.getElementById('r027').innerHTML = data.data_rate['rate27'];
				} else if (data.result == 1) {
					document.getElementById('infomessage7').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage7').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage7').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage7').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage7').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage7').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage7').innerHTML = 'Sorry, the match has already started';
					document.getElementById('infomessage7').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage7').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage7').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r017').innerHTML = data.new_rate['rate1'];
					document.getElementById('r027').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r17" ).value = '';
					document.getElementById( "sum-r27" ).value = '';
				}

			} else if (typebet == 9) {

				if (data.result == 0) {
					document.getElementById('infomessage9').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage9').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage9').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage9').className = "betsinfo";
					document.getElementById('r019').innerHTML = data.data_rate['rate19'];
					document.getElementById('r029').innerHTML = data.data_rate['rate29'];
				} else if (data.result == 1) {
					document.getElementById('infomessage9').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage9').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage9').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage9').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage9').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage9').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage9').innerHTML = 'Sorry, the match has already started';
					document.getElementById('infomessage9').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage9').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage9').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r019').innerHTML = data.new_rate['rate1'];
					document.getElementById('r029').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r19" ).value = '';
					document.getElementById( "sum-r29" ).value = '';
				}

			} else if (typebet == 11) {

				if (data.result == 0) {
					document.getElementById('infomessage11').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage11').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage11').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage11').className = "betsinfo";
					document.getElementById('r0111').innerHTML = data.data_rate['rate111'];
					document.getElementById('r0211').innerHTML = data.data_rate['rate211'];
				} else if (data.result == 1) {
					document.getElementById('infomessage11').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage11').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage11').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage11').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage11').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage11').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage11').innerHTML = 'Sorry, the match has already started';
					document.getElementById('infomessage11').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage11').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage11').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r0111').innerHTML = data.new_rate['rate1'];
					document.getElementById('r0211').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r111" ).value = '';
					document.getElementById( "sum-r211" ).value = '';
				}

			} else if (typebet == 101) {

				if (data.result == 0) {
					document.getElementById('infomessage101').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage101').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage101').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage101').className = "betsinfo";
					document.getElementById('r01101').innerHTML = data.data_rate['rate1101'];
					document.getElementById('r02101').innerHTML = data.data_rate['rate2101'];
				} else if (data.result == 1) {
					document.getElementById('infomessage101').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage101').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage101').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage101').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage101').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage101').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage101').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage101').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage101').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage101').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01101').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02101').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1101" ).value = '';
					document.getElementById( "sum-r2101" ).value = '';
				}

			} else if (typebet == 102) {

				if (data.result == 0) {
					document.getElementById('infomessage102').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage102').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage102').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage102').className = "betsinfo";
					document.getElementById('r01102').innerHTML = data.data_rate['rate1102'];
					document.getElementById('r02102').innerHTML = data.data_rate['rate2102'];
				} else if (data.result == 1) {
					document.getElementById('infomessage102').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage102').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage102').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage102').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage102').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage102').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage102').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage102').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage102').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage102').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01102').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02102').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1102" ).value = '';
					document.getElementById( "sum-r2102" ).value = '';
				}

			} else if (typebet == 103) {

				if (data.result == 0) {
					document.getElementById('infomessage103').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage103').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage103').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage103').className = "betsinfo";
					document.getElementById('r01103').innerHTML = data.data_rate['rate1103'];
					document.getElementById('r02103').innerHTML = data.data_rate['rate2103'];
				} else if (data.result == 1) {
					document.getElementById('infomessage103').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage103').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage103').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage103').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage103').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage103').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage103').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage103').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage103').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage103').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01103').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02103').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1103" ).value = '';
					document.getElementById( "sum-r2103" ).value = '';
				}

			} else if (typebet == 104) {

				if (data.result == 0) {
					document.getElementById('infomessage104').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage104').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage104').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage104').className = "betsinfo";
					document.getElementById('r01104').innerHTML = data.data_rate['rate1104'];
					document.getElementById('r02104').innerHTML = data.data_rate['rate2104'];
				} else if (data.result == 1) {
					document.getElementById('infomessage104').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage104').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage104').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage104').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage104').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage104').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage104').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage104').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage104').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage104').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01104').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02104').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1104" ).value = '';
					document.getElementById( "sum-r2104" ).value = '';
				}

			} else if (typebet == 105) {

				if (data.result == 0) {
					document.getElementById('infomessage105').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage105').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage105').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage105').className = "betsinfo";
					document.getElementById('r01105').innerHTML = data.data_rate['rate1105'];
					document.getElementById('r02105').innerHTML = data.data_rate['rate2105'];
				} else if (data.result == 1) {
					document.getElementById('infomessage105').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage105').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage105').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage105').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage105').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage105').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage105').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage105').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage105').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage105').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01105').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02105').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1105" ).value = '';
					document.getElementById( "sum-r2105" ).value = '';
				}

			} else if (typebet == 106) {

				if (data.result == 0) {
					document.getElementById('infomessage106').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage106').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage106').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage106').className = "betsinfo";
					document.getElementById('r01106').innerHTML = data.data_rate['rate1106'];
					document.getElementById('r02106').innerHTML = data.data_rate['rate2106'];
				} else if (data.result == 1) {
					document.getElementById('infomessage106').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage106').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage106').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage106').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage106').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage106').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage106').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage106').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage106').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage106').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01106').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02106').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1106" ).value = '';
					document.getElementById( "sum-r2106" ).value = '';
				}

			} else if (typebet == 107) {

				if (data.result == 0) {
					document.getElementById('infomessage107').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage107').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage107').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage107').className = "betsinfo";
					document.getElementById('r01107').innerHTML = data.data_rate['rate1107'];
					document.getElementById('r02107').innerHTML = data.data_rate['rate2107'];
				} else if (data.result == 1) {
					document.getElementById('infomessage107').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage107').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage107').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage107').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage107').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage107').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage107').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage107').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage107').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage107').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01107').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02107').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1107" ).value = '';
					document.getElementById( "sum-r2107" ).value = '';
				}

			} else if (typebet == 108) {

				if (data.result == 0) {
					document.getElementById('infomessage108').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage108').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage108').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage108').className = "betsinfo";
					document.getElementById('r01108').innerHTML = data.data_rate['rate1108'];
					document.getElementById('r02108').innerHTML = data.data_rate['rate2108'];
				} else if (data.result == 1) {
					document.getElementById('infomessage108').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage108').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage108').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage108').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage108').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage108').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage108').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage108').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage108').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage108').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01108').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02108').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1108" ).value = '';
					document.getElementById( "sum-r2108" ).value = '';
				}

			} else if (typebet == 109) {

				if (data.result == 0) {
					document.getElementById('infomessage109').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage109').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage109').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage109').className = "betsinfo";
					document.getElementById('r01109').innerHTML = data.data_rate['rate1109'];
					document.getElementById('r02109').innerHTML = data.data_rate['rate2109'];
				} else if (data.result == 1) {
					document.getElementById('infomessage109').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage109').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage109').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage109').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage109').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage109').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage109').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage109').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage109').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage109').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01109').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02109').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1109" ).value = '';
					document.getElementById( "sum-r2109" ).value = '';
				}

			} else if (typebet == 110) {

				if (data.result == 0) {
					document.getElementById('infomessage110').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage110').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage110').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage110').className = "betsinfo";
					document.getElementById('r01110').innerHTML = data.data_rate['rate1110'];
					document.getElementById('r02110').innerHTML = data.data_rate['rate2110'];
				} else if (data.result == 1) {
					document.getElementById('infomessage110').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage110').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage110').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage110').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage110').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage110').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage110').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage110').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage110').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage110').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01110').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02110').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1110" ).value = '';
					document.getElementById( "sum-r2110" ).value = '';
				}

			} else if (typebet == 111) {

				if (data.result == 0) {
					document.getElementById('infomessage111').innerHTML = 'Error! Incorrect values';
					document.getElementById('infomessage111').className = "betsinfo";
				} else if (data.data_rate != undefined) {
					document.getElementById('infomessage111').innerHTML = 'Attention! Changed coefficients match';
					document.getElementById('infomessage111').className = "betsinfo";
					document.getElementById('r01111').innerHTML = data.data_rate['rate1111'];
					document.getElementById('r02111').innerHTML = data.data_rate['rate2111'];
				} else if (data.result == 1) {
					document.getElementById('infomessage111').innerHTML = 'Error! Not enough money';
					document.getElementById('infomessage111').className = "betsinfo";
				} else if (data.result == 3) {
					document.getElementById('infomessage111').innerHTML = 'Error! Exceeded the maximum bet';
					document.getElementById('infomessage111').className = "betsinfo";
				} else if (data.result == 4) {
					document.getElementById('infomessage111').innerHTML = 'Attention! Register or log in to place a bet on this match';
					document.getElementById('infomessage111').className = "betsinfo";
				} else if (data.result == 5) {
					document.getElementById('infomessage111').innerHTML = 'Sorry, the map is already started or completed';
					document.getElementById('infomessage111').className = "betsinfo";
				} else if (data.result == 2) {
					$('#tablemadebets').load('/ajax/madebets', {id: e});
					document.getElementById('infomessage111').innerHTML = 'Bet is accepted!';
					document.getElementById('infomessage111').className = "betsinfo";
					document.getElementById('maxbet1').innerHTML = data.new_rate['maxbet'];
					document.getElementById('r01111').innerHTML = data.new_rate['rate1'];
					document.getElementById('r02111').innerHTML = data.new_rate['rate2'];
					document.getElementById( "sum-r1111" ).value = '';
					document.getElementById( "sum-r2111" ).value = '';
				}


			}


		}
	})

}

function sumr1(e)
{
	$('#sum-r1'+e).bind("change keyup input click", function() {

		if (this.value > 0) {
			var rate1 = document.getElementById( "r01"+e ).textContent;
			document.getElementById('prize-r1'+e).innerHTML = (rate1*this.value).toFixed(2);

			$("#sum-r1"+e).css( "border-color", "#0cc431" );
			$("#sum-r1"+e).css( "color", "#0cc431" );
		} else {
			$("#sum-r1"+e).css( "border-color", "#ccc" );
			$("#sum-r1"+e).css( "color", "#555" );
			document.getElementById('prize-r1'+e).innerHTML = 0;
			this.value = '';
		}
	});
}


function sumr2(e)
{
	$('#sum-r2'+e).bind("change keyup input click", function() {

		if (this.value > 0) {
			var rate2 = document.getElementById( "r02"+e ).textContent;
			document.getElementById('prize-r2'+e).innerHTML = (rate2*this.value).toFixed(2);

			$("#sum-r2"+e).css( "border-color", "#0cc431" );
			$("#sum-r2"+e).css( "color", "#0cc431" );
		} else {
			$("#sum-r2"+e).css( "border-color", "#ccc" );
			$("#sum-r2"+e).css( "color", "#555" );
			document.getElementById('prize-r2'+e).innerHTML = 0;
			this.value = '';
		}
	});
}


function sumrdraw(e)
{
	$('#sum-d'+e).bind("change keyup input click", function() {
		if (this.value > 0) {
			var ratedraw = document.getElementById( "d01"+e ).textContent;
			document.getElementById('prize-d1'+e).innerHTML = (ratedraw*this.value).toFixed(2);

			$("#sum-d"+e).css( "border-color", "#0cc431" );
			$("#sum-d"+e).css( "color", "#0cc431" );
		} else {
			$("#sum-d"+e).css( "border-color", "#ccc" );
			$("#sum-d"+e).css( "color", "#555" );
			document.getElementById('prize-d1'+e).innerHTML = 0;
			this.value = '';
		}
	});
}


function request_cancelbetwin(e, idmatch)
{
	$.ajax({
		type: "POST",
		data: {id: e},
		url: "/ajax/requestcancelbet",
		dataType: "json",
		async: false,
		success: function(data)
		{
			if (data.result == 1) {
				$('#tablemadebets').load('/ajax/madebets', {id: idmatch});
			}
		}
	})
}

function request_cancelbet(e)
{
	$.ajax({
		type: "POST",
		data: {id: e},
		url: "/ajax/requestcancelbet",
		dataType: "json",
		async: false,
		success: function(data)
		{
			if (data.result == 1) {
				document.getElementById('x-'+e).className = "sentX label";
				document.getElementById('x-'+e).innerHTML = 'Sent';
				document.getElementById('x-'+e).removeAttribute('data-original-title');
			}
		}
	})
}

function blur_check_sum()
{
	var sum = $("#sum_deposit").val();
	var max = '999999999.99';

	if (sum > 0 && sum <= max) {
		$(".label_amount").css( "color", "#0cc431" );
		$("#sum_deposit").css( "border-color", "#0cc431" );
		$("#sum_deposit").css( "color", "#0cc431" );
		return true;
	} else if (sum == '') {
		return false;
	} else {
		$(".label_amount").css( "color", "#BBB" );
		$("#sum_deposit").css( "border-color", "#CCC" );
		$("#sum_deposit").css( "color", "#555" );
		return false;
	}
}

function check_sum()
{
	$('#sum_deposit').bind("change keyup input click", function() {

		if (this.value > 0) {
			$(".label_amount").css( "color", "#0cc431" );
			$("#sum_deposit").css( "border-color", "#0cc431" );
			$("#sum_deposit").css( "color", "#0cc431" );
		} else {
			$(".label_amount").css( "color", "#BBB" );
			$("#sum_deposit").css( "border-color", "#CCC" );
			$("#sum_deposit").css( "color", "#555" );
		}

	});
}


function check_amount(money, statecomm)
{
	$('#sum_withdraw').bind("change keyup input click", function() {
		var sum = parseFloat(this.value);

		if (statecomm == 1) {
			sum += sum*0.04;
			sum = sum.toFixed(2);
		}

		if (sum >= 15 && sum <= money && statecomm == 1) {
			$(".label_withdraw").css( "color", "#0cc431" );
			$("#sum_withdraw").css( "border-color", "#0cc431" );
			$("#sum_withdraw").css( "color", "#0cc431" );
			$("#msg_sum_withdraw").removeClass( "alert alert-danger" );
			$("#msg_sum_withdraw").addClass( "alert alert-success" );
			$("#msg_sum_withdraw").html('<i class="fa fa-check fa-fw"></i>&nbsp;OK. Total amount (+4%) - $'+sum);
		} else if (sum >= 15 && sum <= money && statecomm == 0) {
			$(".label_withdraw").css( "color", "#0cc431" );
			$("#sum_withdraw").css( "border-color", "#0cc431" );
			$("#sum_withdraw").css( "color", "#0cc431" );
			$("#msg_sum_withdraw").removeClass( "alert alert-danger" );
			$("#msg_sum_withdraw").addClass( "alert alert-success" );
			$("#msg_sum_withdraw").html('<i class="fa fa-check fa-fw"></i>&nbsp;OK');
		} else if (sum == 0 || isNaN(sum)) {
			$(".label_withdraw").css( "color", "#BBB" );
			$("#sum_withdraw").css( "border-color", "#ccc" );
			$("#sum_withdraw").css( "color", "#555" );
			$("#msg_sum_withdraw").removeClass( "alert alert-danger" );
			$("#msg_sum_withdraw").removeClass( "alert alert-success" );
			$("#msg_sum_withdraw").html('');
		} else if (statecomm == 1) {
			$(".label_withdraw").css( "color", "#BBB" );
			$("#sum_withdraw").css( "border-color", "#ccc" );
			$("#sum_withdraw").css( "color", "#555" );
			$("#msg_sum_withdraw").removeClass( "alert alert-success" );
			$("#msg_sum_withdraw").addClass( "alert alert-danger" );
			$("#msg_sum_withdraw").html('Total amount (+4%) - $'+sum);
		} else {
			$(".label_withdraw").css( "color", "#BBB" );
			$("#sum_withdraw").css( "border-color", "#ccc" );
			$("#sum_withdraw").css( "color", "#555" );
			$("#msg_sum_withdraw").removeClass( "alert alert-danger" );
			$("#msg_sum_withdraw").removeClass( "alert alert-success" );
			$("#msg_sum_withdraw").html('');
		}

	});
}


function check_psystem(i)
{
	selValue = i.value;
	$("#ewallet_number").val = '';
	if (selValue == 'webmoney') {
		$("#ewallet_number").attr("placeholder", "Z000000000000");
		$.mask.definitions['h'] = "[A-Z]";
		$("#ewallet_number").mask("h999999999999",{placeholder:""});
	} else if (selValue == 'yandexmoney') {
		$("#ewallet_number").attr("placeholder", "00000000000000");
		$("#ewallet_number").mask("99999999999999",{placeholder:""});
	} else if (selValue == 'visamastercard') {
		$("#ewallet_number").attr("placeholder", "000000000000000000");
		$("#ewallet_number").mask("9999999999999999?99",{placeholder:""});
	} else if (selValue == 'paypal') {
		$("#ewallet_number").attr("placeholder", "example@domain.com");
		$("#ewallet_number").unmask();;
	} else if (selValue == 'walletone') {
		$("#ewallet_number").attr("placeholder", "example@domain.com");
		$("#ewallet_number").unmask();;
	}
}


function blur_check_number()
{
	var selValue = $("select#psystem").val();
	var number = $("#ewallet_number").val();

	var state = 0;

	if (selValue == 'webmoney') {
		if (number.length == 13) {
			state = 1;
		}
	} else if (selValue == 'yandexmoney') {
		if (number.length == 14) {
			state = 1;
		}
	} else if (selValue == 'visamastercard') {
		if (number.length == 16 || number.length == 18) {
			state = 1;
		}
	} else if (selValue == 'paypal') {
		if (number.length <= 100 && validateEmail(number)) {
			state = 1;
		}
	} else if (selValue == 'walletone') {
		if (number.length <= 100 && validateEmail(number)) {
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
}


function blur_check_submit(money, statecomm, freemoney)
{
	var selValue = $("select#psystem").val();
	var number = $("#ewallet_number").val();
	var state = 0;

	var sum = parseFloat($("#sum_withdraw").val());
	var max = '999999999999.99';

	if (selValue == 'webmoney') {
		if (number.length == 13) {
			state = 1;
		}
	} else if (selValue == 'yandexmoney') {
		if (number.length == 14) {
			state = 1;
		}
	} else if (selValue == 'visamastercard') {
		if (number.length == 16 || number.length == 18) {
			state = 1;
		}
	} else if (selValue == 'paypal') {
		if (number.length <= 100 && validateEmail(number)) {
			state = 1;
		}
	} else if (selValue == 'walletone') {
		if (number.length <= 100 && validateEmail(number)) {
			state = 1;
		}
	}

	if (statecomm == 1) {
		sum += sum*0.04;
		sum = sum.toFixed(2);
	}

	if (state == 1 && sum >= 15 && sum <= max && sum <= money && freemoney == 0) {
		return true;
	} else {
		return false;
	}

}

function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}


function check_edit_currentpassword()
{
	var current_password = $("#current_password").val();
	var res = $.ajax({
		type: "POST",
		data: "current_password=" + current_password,
		url: "/ajax/currentpassword",
		dataType: "json",
		async: false,
		success: function(data)
		{
			if(data.result == 1)
			{
				$(".label_currentpassword").css( "color", "#0cc431" );
				$("#current_password").css( "border-color", "#0cc431" );
				$("#current_password").css( "color", "#0cc431" );
				$("#msg_change_current").removeClass( "alert alert-danger" );
				$("#msg_change_current").html('');
			} else {
				$(".label_currentpassword").css( "color", "#B94A48" );
				$("#current_password").css( "border-color", "#B94A48" );
				$("#current_password").css( "color", "#B94A48" );
				$("#msg_change_current").addClass( "alert alert-danger" );
				$("#msg_change_current").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Please enter your current password');
			}
		}
	})
	return res.responseText;
}


function check_signup_password()
{
	var signup_password = $("#signup_password").val();
	var res = $.ajax({
		type: "POST",
		data: "signup_password=" + signup_password,
		url: "/ajax/signuppassword",
		dataType: "json",
		async: false,
		success: function(data)
		{

			$(".label_password").css( "color", "#B94A48" );
			$("#signup_password").css( "border-color", "#B94A48" );
			$("#signup_password").css( "color", "#B94A48" );

			if(data.result == 1) {
				$("#msg_signup_password").addClass( "alert alert-danger" );
				$("#msg_signup_password").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Please enter a password of at least five characters');
			} else if (data.result == 2) {
				$("#msg_signup_password").addClass( "alert alert-danger" );
				$("#msg_signup_password").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Maximum length of the password 245 characters');
			} else if (data.result == 3) {
				$(".label_password").css( "color", "#0cc431" );
				$("#signup_password").css( "border-color", "#0cc431" );
				$("#signup_password").css( "color", "#0cc431" );
				$("#msg_signup_password").removeClass( "alert alert-danger" );
				$("#msg_signup_password").html('');
			}
		}
	})
	check_signup_password2();
	return res.responseText;
}

function check_signup_password2()
{
	var signup_password2 = $("#signup_password2").val();
	var signup_password = $("#signup_password").val();

	if (signup_password2 != signup_password) {
		$(".label_password2").css( "color", "#B94A48" );
		$("#signup_password2").css( "border-color", "#B94A48" );
		$("#signup_password2").css( "color", "#B94A48" );
		$("#msg_signup_password2").addClass( "alert alert-danger" );
		$("#msg_signup_password2").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Password do not match');
		return 0;
	} else {
		$(".label_password2").css( "color", "#0cc431" );
		$("#signup_password2").css( "border-color", "#0cc431" );
		$("#signup_password2").css( "color", "#0cc431" );
		$("#msg_signup_password2").removeClass( "alert alert-danger" );
		$("#msg_signup_password2").html('');
		return 1;
	}
}


function check_signup_login()
{
	var signup_login = $("#signup_login").val();
	var res = $.ajax({
		type: "POST",
		data: "signup_login=" + signup_login,
		url: "/ajax/signuplogin",
		dataType: "json",
		async: false,
		success: function(data)
		{
			$("#signup_login").css( "border-color", "#B94A48" );
			$("#signup_login").css( "color", "#B94A48" );
			$(".label_login").css( "color", "#B94A48" );

			if(data.result == 1) {
				$("#msg_signup_login").addClass( "alert alert-danger" );
				$("#msg_signup_login").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Please enter your username at least three characters');

			} else if (data.result == 2) {
				$("#msg_signup_login").addClass( "alert alert-danger" );
				$("#msg_signup_login").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Maximum length of the username 245 characters');

			} else if (data.result == 3) {
				$("#msg_signup_login").addClass( "alert alert-danger" );
				$("#msg_signup_login").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Username can only consist of letters of the alphabet, numbers, and the hyphen and underscore');

			} else if (data.result == 4) {
				$("#msg_signup_login").addClass( "alert alert-danger" );
				$("#msg_signup_login").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;This username already exists. Please enter a different username');

			} else if (data.result == 5) {
				$(".label_login").css( "color", "#0cc431" );
				$("#signup_login").css( "border-color", "#0cc431" );
				$("#signup_login").css( "color", "#0cc431" );
				$("#msg_signup_login").removeClass( "alert alert-danger" );
				$("#msg_signup_login").html('');
			}
		}
	})
	return res.responseText;
}


function check_signup_email()
{
	var signup_email = $("#signup_email").val();
	var res = $.ajax({
		type: "POST",
		data: "signup_email=" + signup_email,
		url: "/ajax/signupemail",
		dataType: "json",
		async: false,
		success: function(data)
		{
			$("#signup_email").css( "border-color", "#B94A48" );
			$("#signup_email").css( "color", "#B94A48" );
			$(".label_email").css( "color", "#B94A48" );

			if(data.result == 1) {
				$("#msg_signup_email").addClass( "alert alert-danger" );
				$("#msg_signup_email").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Maximum length of the email 245 characters');
			} else if (data.result == 2) {
				$("#msg_signup_email").addClass( "alert alert-danger" );
				$("#msg_signup_email").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;Please enter a valid email address');
			} else if (data.result == 3) {
				$("#msg_signup_email").addClass( "alert alert-danger" );
				$("#msg_signup_email").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;This email is already registered. Please enter a different email');
			} else if (data.result == 4) {
				$(".label_email").css( "color", "#0cc431" );
				$("#signup_email").css( "border-color", "#0cc431" );
				$("#signup_email").css( "color", "#0cc431" );
				$("#msg_signup_email").removeClass( "alert alert-danger" );
				$("#msg_signup_email").html('');
			}
		}
	})
	return res.responseText;
}


function check_signup_terms()
{
	if ( document.getElementById('signup_terms').checked === true ) {
		$(".label_terms").css( "color", "#0cc431" );
		$(".terms_of_use span").css( "color", "#0cc431" );

		$("#msg_signup_terms").removeClass( "alert alert-danger" );
		$("#msg_signup_terms").html('');
		return 1;
	} else {
		$(".label_terms").css( "color", "#B94A48" );
		$(".terms_of_use span").css( "color", "#B94A48" );
		$("#msg_signup_terms").addClass( "alert alert-danger" );
		$("#msg_signup_terms").html('<i class="fa fa-exclamation-triangle fa-fw"></i>&nbsp;You need to accept our Terms of Use');
		return 0;
	}
}

function refreshchat(){
	$('#wallmess').load('/ajax/wallmess');
	setTimeout(function(){refreshchat();}, 10000);
}