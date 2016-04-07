<?php
	error_reporting(-1); // display all faires
	ini_set('display_errors', 1);  // ensure that faires will be seen
	ini_set('display_startup_errors', 1); // display faires that didn't born

	$mysql_host = "<host>";
	$mysql_user = "<user>";
	$mysql_pass = "<password>";
	$mysql_conn = @mysql_connect( $mysql_host, $mysql_user, $mysql_pass )
	or die ( "Not Connected to MySQL" );
	$mysql_db = mysql_select_db("<database>")
	or die ( "NOt Connected to MySQL" );
	mysql_query("SET NAMES utf8");
?>
