<h3>Добавить матч - выставление коэффициентов</h3>
<div>
	<form method="post" action="">
		<p><?=$discipline->name?></p>
		<table>
			<tr>
				<td><?=$team1->name?></td>
				<td><?=$team2->name?></td>
				<td>Draw</td>
			</tr>
			<tr>
				<? if (isset($player1)){  ?>
					<td><?=$player1->name?></td>
					<td><?=$player2->name?></td>
				<? } else {?>
					<td></td>
					<td></td>
				<? } ?>
					<td><input type="checkbox" name="checkdraw" value="1" id="checkdraw"></td>
			</tr>
			<tr>
				<td><input type="text" name="sum1" id="sum1"></td>
				<td><input type="text" name="sum2" id="sum2"></td>
				<td><input type="text" name="draw" id="draw" disabled="disabled" value="0"></td>
				<td></td>
			</tr>
			<tr>
				<td><input type="text" name="rate11" id="rate11"></td>
				<td><input type="text" name="rate22" id="rate22"></td>
				<td><input type="text" name="rate33" id="rate33" disabled="disabled"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align:right; padding-right:5px;">Максимальная ставка</td>
				<td><input type="text" name="maxbet" id="maxbet" value="100"></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td style="text-align:right; padding-right:5px;">Маржа на матч и карты</td>
				<td><input type="text" name="marge" id="marge" value="0.95"></td>
				<td><input type="text" name="marge_map" id="marge_map" value="0.92"></td>
				<td colspan="3"><span class="label countcheckout">Если есть аутсайдер(>=20), маржа на карты не должна быть меньше 0.91</span></td>
			</tr>
			<tr>
				<td>Best of </td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><input type="text" name="bestof" id="bestof" value="1"></td>
				<td style="padding-right:5px;">Игрок1 (если надо):</td>
				<td style="padding-right:5px;">% <?=$team1->name?>:</td>
				<td style="padding-right:5px;">rate1</td>
				<td style="padding-right:5px;">Игрок2 (если надо):</td>
				<td style="padding-right:5px;">rate2</td>
			</tr>

			<!-- players1 и players2 может и не быть, если для текущего матча были выбраны игроки. Проверяем существование players1 -->
			<? if (isset($players1)){  ?>
				<tr id = 'trdmap1'>
					<td style="text-align:right; padding-right:5px;">Map 1</td>
					<td>
						<select name="map1_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map1_proc" id="map1_proc"></td>
					<td><input type="text" name="map1_rate1" id="map1_rate1"></td>

					<td>
						<select name="map1_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map1_rate2" id="map1_rate2"></td>
				</tr>


				<tr id = 'trdmap2'>
					<td style="text-align:right; padding-right:5px;">Map 2</td>
					<td>
						<select name="map2_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map2_proc" id="map2_proc"></td>
					<td><input type="text" name="map2_rate1" id="map2_rate1"></td>

					<td>
						<select name="map2_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map2_rate2" id="map2_rate2"></td>
				</tr>


				<tr id = 'trdmap3'>
					<td style="text-align:right; padding-right:5px;">Map 3</td>
					<td>
						<select name="map3_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map3_proc" id="map3_proc"></td>
					<td><input type="text" name="map3_rate1" id="map3_rate1"></td>

					<td>
						<select name="map3_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map3_rate2" id="map3_rate2"></td>
				</tr>


				<tr id = 'trdmap4'>
					<td style="text-align:right; padding-right:5px;">Map 4</td>
					<td>
						<select name="map4_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map4_proc" id="map4_proc"></td>
					<td><input type="text" name="map4_rate1" id="map4_rate1"></td>

					<td>
						<select name="map4_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map4_rate2" id="map4_rate2"></td>
				</tr>


				<tr id = 'trdmap5'>
					<td style="text-align:right; padding-right:5px;">Map 5</td>
					<td>
						<select name="map5_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map5_proc" id="map5_proc"></td>
					<td><input type="text" name="map5_rate1" id="map5_rate1"></td>

					<td>
						<select name="map5_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map5_rate2" id="map5_rate2"></td>
				</tr>


				<tr id = 'trdmap6'>
					<td style="text-align:right; padding-right:5px;">Map 6</td>
					<td>
						<select name="map6_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map6_proc" id="map6_proc"></td>
					<td><input type="text" name="map6_rate1" id="map6_rate1"></td>

					<td>
						<select name="map6_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map6_rate2" id="map6_rate2"></td>
				</tr>


				<tr id = 'trdmap7'>
					<td style="text-align:right; padding-right:5px;">Map 7</td>
					<td>
						<select name="map7_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map7_proc" id="map7_proc"></td>
					<td><input type="text" name="map7_rate1" id="map7_rate1"></td>

					<td>
						<select name="map7_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map7_rate2" id="map7_rate2"></td>
				</tr>


				<tr id = 'trdmap8'>
					<td style="text-align:right; padding-right:5px;">Map 8</td>
					<td>
						<select name="map8_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map8_proc" id="map8_proc"></td>
					<td><input type="text" name="map8_rate1" id="map8_rate1"></td>

					<td>
						<select name="map8_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map8_rate2" id="map8_rate2"></td>
				</tr>


				<tr id = 'trdmap9'>
					<td style="text-align:right; padding-right:5px;">Map 9</td>
					<td>
						<select name="map9_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map9_proc" id="map9_proc"></td>
					<td><input type="text" name="map9_rate1" id="map9_rate1"></td>

					<td>
						<select name="map9_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map9_rate2" id="map9_rate2"></td>
				</tr>


				<tr id = 'trdmap10'>
					<td style="text-align:right; padding-right:5px;">Map 10</td>
					<td>
						<select name="map10_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map10_proc" id="map10_proc"></td>
					<td><input type="text" name="map10_rate1" id="map10_rate1"></td>

					<td>
						<select name="map10_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map10_rate2" id="map10_rate2"></td>
				</tr>


				<tr id = 'trdmap11'>
					<td style="text-align:right; padding-right:5px;">Map 11</td>
					<td>
						<select name="map11_playerID1">
							<option value=""></option>
							<?foreach($players1 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map11_proc" id="map11_proc"></td>
					<td><input type="text" name="map11_rate1" id="map11_rate1"></td>

					<td>
						<select name="map11_playerID2">
							<option value=""></option>
							<?foreach($players2 as $item) {?>
								<option value="<?=$item['id']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td><input type="text" name="map11_rate2" id="map11_rate2"></td>
				</tr>
			<? } ?>
			<tr>
				<td></td>
				<td style="float:right">Преим 1карта (1-ДА):</td>
				<td style="padding-right:5px;"><input type="text" name="preim1" id="preim1"></td>
				<td style="padding-right:5px;"></td>
				<td style="padding-right:5px;"><input type="text" name="preim2" id="preim2"></td>
				<td style="padding-right:5px;"></td>
			</tr>

		</table>

		<input type="submit" value="Продолжить" name="submit_step2">
	</form>
</div>


<script type="text/javascript">
	function Draw()
	{
		if (document.getElementById("checkdraw").checked)
		{
			document.getElementById('draw').disabled=false;
			document.getElementById('rate33').disabled=false;
			// Для БО2 Dota2
			<? if ($discipline->name == 'Dota 2' || $discipline->name == 'World of Tanks') {?>
				document.getElementById('draw').value="24";
				document.getElementById('marge').value="0.52"; //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
				document.getElementById('sum1').value="42";
				document.getElementById('sum2').value="34";
			<? } elseif ($discipline->name == 'Counter-Strike: GO') {?>
				document.getElementById('draw').value="09";
				document.getElementById('marge').value="0.90";
			<? } ?>

			var rate11 = $("#marge").val()/($("#sum1").val() * 0.01);
			$("#rate11").val(rate11.toFixed(3));

			var rate22 = $("#marge").val()/($("#sum2").val() * 0.01);
			$("#rate22").val(rate22.toFixed(3));

			var rate33 = $("#marge").val()/($("#draw").val() * 0.01);
			$("#rate33").val(rate33.toFixed(3));


		} else {
			document.getElementById('draw').disabled=true;
			document.getElementById('rate33').disabled=true;
			document.getElementById('draw').value="";
			document.getElementById('marge').value="0.95";
		}
	}

	$(document).ready(function(){
		$("#checkdraw").click(Draw);
		$("#sum1").mask("99");
		$("#sum2").mask("99");
		$("#draw").mask("99");
		$("#maxbet").mask("999");
		$("#map1_proc").mask("99");
		$("#map2_proc").mask("99");
		$("#map3_proc").mask("99");
		$("#map4_proc").mask("99");
		$("#map5_proc").mask("99");
		$("#map6_proc").mask("99");
		$("#map7_proc").mask("99");
		$("#map8_proc").mask("99");
		$("#map9_proc").mask("99");
		$("#map10_proc").mask("99");
		$("#map11_proc").mask("99");
		for (var i = 1; i <= 11; i++) {
  			$("#trdmap"+i).css('display','none');
		}

		$( "#bestof" ).keyup(function() {
			if ($( "#bestof" ).val() >= 2) {
				for (var i = 1; i <= 11; i++) {
		  			$("#trdmap"+i).css('display','none');
				}

				for (var i = 1; i <= $( "#bestof" ).val(); i++) {
		  			$("#trdmap"+i).css('display','table-row');
				}
			} else {
				for (var i = 1; i <= 11; i++) {
		  			$("#trdmap"+i).css('display','none');
				}
			}
		});


		$( "#sum1" ).keypress(function() {
			$("#sum2").val(100-$("#sum1").val()-$("#draw").val());

			var rate11 = $("#marge").val()/($("#sum1").val() * 0.01);
			$("#rate11").val(rate11.toFixed(3));

			var rate22 = $("#marge").val()/($("#sum2").val() * 0.01);
			$("#rate22").val(rate22.toFixed(3));

			if (document.getElementById("checkdraw").checked)
			{
				var rate33 = $("#marge").val()/($("#draw").val() * 0.01);
				$("#rate33").val(rate33.toFixed(3));
			}

			if ($("#sum1").val() <= 20) {
				$("#sum1").css( "border-color", "#B94A48" );
				$("#sum1").css( "color", "#B94A48" );
			} else {
				$("#sum1").css( "border-color", "#CCC" );
				$("#sum1").css( "color", "#555" );
			}

			if ($("#sum2").val() <= 20) {
				$("#sum2").css( "border-color", "#B94A48" );
				$("#sum2").css( "color", "#B94A48" );
			} else {
				$("#sum2").css( "border-color", "#CCC" );
				$("#sum2").css( "color", "#555" );
			}

		});

		$( "#sum2" ).keypress(function() {
			$("#sum1").val(100-$("#sum2").val()-$("#draw").val());

			var rate11 = $("#marge").val()/($("#sum1").val() * 0.01);
			$("#rate11").val(rate11.toFixed(3));

			var rate22 = $("#marge").val()/($("#sum2").val() * 0.01);
			$("#rate22").val(rate22.toFixed(3));

			if (document.getElementById("checkdraw").checked)
			{
				var rate33 = $("#marge").val()/($("#draw").val() * 0.01);
				$("#rate33").val(rate33.toFixed(3));
			}


			if ($("#sum1").val() <= 20) {
				$("#sum1").css( "border-color", "#B94A48" );
				$("#sum1").css( "color", "#B94A48" );
			} else {
				$("#sum1").css( "border-color", "#CCC" );
				$("#sum1").css( "color", "#555" );
			}


			if ($("#sum2").val() <= 20) {
				$("#sum2").css( "border-color", "#B94A48" );
				$("#sum2").css( "color", "#B94A48" );
			} else {
				$("#sum2").css( "border-color", "#CCC" );
				$("#sum2").css( "color", "#555" );
			}

		});


		$( "#draw" ).keypress(function() {
			$("#sum1").val('');
			$("#sum2").val('');

			var rate33 = $("#marge").val()/($("#draw").val() * 0.01);
			$("#rate33").val(rate33.toFixed(3));
		});


		$( "#marge" ).keyup(function() {
			var rate11 = $("#marge").val()/($("#sum1").val() * 0.01);
			$("#rate11").val(rate11.toFixed(3));

			var rate22 = $("#marge").val()/($("#sum2").val() * 0.01);
			$("#rate22").val(rate22.toFixed(3));

			if (document.getElementById("checkdraw").checked)
			{
				var rate33 = $("#marge").val()/($("#draw").val() * 0.01);
				$("#rate33").val(rate33.toFixed(3));
			}
		});



		//Коэффициенты для отдельных карт
		$( "#map1_proc" ).keypress(function() {
			$("#map1_rate2").val(100-$("#map1_proc").val());

			var rate1 = $("#marge_map").val()/($("#map1_proc").val() * 0.01);
			$("#map1_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map1_rate2").val() * 0.01);
			$("#map1_rate2").val(rate2.toFixed(3));
		});

		$( "#map2_proc" ).keypress(function() {
			$("#map2_rate2").val(100-$("#map2_proc").val());

			var rate1 = $("#marge_map").val()/($("#map2_proc").val() * 0.01);
			$("#map2_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map2_rate2").val() * 0.01);
			$("#map2_rate2").val(rate2.toFixed(3));
		});

		$( "#map3_proc" ).keypress(function() {
			$("#map3_rate2").val(100-$("#map3_proc").val());

			var rate1 = $("#marge_map").val()/($("#map3_proc").val() * 0.01);
			$("#map3_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map3_rate2").val() * 0.01);
			$("#map3_rate2").val(rate2.toFixed(3));
		});

		$( "#map4_proc" ).keypress(function() {
			$("#map4_rate2").val(100-$("#map4_proc").val());

			var rate1 = $("#marge_map").val()/($("#map4_proc").val() * 0.01);
			$("#map4_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map4_rate2").val() * 0.01);
			$("#map4_rate2").val(rate2.toFixed(3));
		});

		$( "#map5_proc" ).keypress(function() {
			$("#map5_rate2").val(100-$("#map5_proc").val());

			var rate1 = $("#marge_map").val()/($("#map5_proc").val() * 0.01);
			$("#map5_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map5_rate2").val() * 0.01);
			$("#map5_rate2").val(rate2.toFixed(3));
		});

		$( "#map6_proc" ).keypress(function() {
			$("#map6_rate2").val(100-$("#map6_proc").val());

			var rate1 = $("#marge_map").val()/($("#map6_proc").val() * 0.01);
			$("#map6_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map6_rate2").val() * 0.01);
			$("#map6_rate2").val(rate2.toFixed(3));
		});

		$( "#map7_proc" ).keypress(function() {
			$("#map7_rate2").val(100-$("#map7_proc").val());

			var rate1 = $("#marge_map").val()/($("#map7_proc").val() * 0.01);
			$("#map7_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map7_rate2").val() * 0.01);
			$("#map7_rate2").val(rate2.toFixed(3));
		});

		$( "#map8_proc" ).keypress(function() {
			$("#map8_rate2").val(100-$("#map8_proc").val());

			var rate1 = $("#marge_map").val()/($("#map8_proc").val() * 0.01);
			$("#map8_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map8_rate2").val() * 0.01);
			$("#map8_rate2").val(rate2.toFixed(3));
		});

		$( "#map9_proc" ).keypress(function() {
			$("#map9_rate2").val(100-$("#map9_proc").val());

			var rate1 = $("#marge_map").val()/($("#map9_proc").val() * 0.01);
			$("#map9_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map9_rate2").val() * 0.01);
			$("#map9_rate2").val(rate2.toFixed(3));
		});

		$( "#map10_proc" ).keypress(function() {
			$("#map10_rate2").val(100-$("#map10_proc").val());

			var rate1 = $("#marge_map").val()/($("#map10_proc").val() * 0.01);
			$("#map10_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map10_rate2").val() * 0.01);
			$("#map10_rate2").val(rate2.toFixed(3));
		});

		$( "#map11_proc" ).keypress(function() {
			$("#map11_rate2").val(100-$("#map11_proc").val());

			var rate1 = $("#marge_map").val()/($("#map11_proc").val() * 0.01);
			$("#map11_rate1").val(rate1.toFixed(3));

			var rate2 = $("#marge_map").val()/($("#map11_rate2").val() * 0.01);
			$("#map11_rate2").val(rate2.toFixed(3));
		});

	});


</script>