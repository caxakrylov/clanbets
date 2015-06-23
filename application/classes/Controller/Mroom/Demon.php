<? //valid, -, id
	date_default_timezone_set('UTC');

	$link = mysql_connect("localhost", "h20csrzV", "RihNZFO6");
	mysql_select_db("clanbets");

	$datetime = date(time());

	$query2 = "UPDATE matches SET state='2', map1_state='2', map2_state='2', map3_state='2', map4_state='2', map5_state='2', map6_state='2', map7_state='2', map8_state='2', map9_state='2', map10_state='2', map11_state='2', auto_start='1', new='0' WHERE state='1' AND auto_start='0' AND cancel_state='0' AND fullstart='1' AND datetime <= $datetime";
	$result2 = mysql_query($query2);
	$count2 = mysql_affected_rows();


	$query = "UPDATE matches SET state='2', map1_state='2', auto_start='1', new='0' WHERE state='1' AND auto_start='0' AND cancel_state='0' AND datetime <= $datetime";
	$result = mysql_query($query);
	$count = mysql_affected_rows();

	if (($result and $count != 0) || ($result2 and $count2 != 0)) {
		$query = "INSERT INTO logs (state,createdate) VALUES('2','".time()."')";
		$result = mysql_query($query);
	}

	if(is_resource($query)) {
		mysql_free_result($result);
	}

	if(is_resource($query2)) {
		mysql_free_result($result2);
	}

	mysql_close($link);
?>