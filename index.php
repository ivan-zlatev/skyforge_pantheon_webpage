<?php
	session_start();
	include("functions.php");
	include("connect.php");
	include("cookie.php");
	if(!isset($_SESSION['auth'])){ $_SESSION['auth'] = "nein"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="description" content="Skyforge Pantheon Data">
	<meta name="keywords" content="Skyforge,Pantheon">
	<meta name="author" content="gadman">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title></title>
</head>
<body>
	<table align='center' border='0' id='mainTable'>
		<tr id='tr1'>
			<td id='leftBorder'>&nbsp;</td>
			<td id='topMenu'><?php include("menu.php"); ?></td>
			<td id='topLogin'><?php include("login.php"); ?></td>
			<td id='rightBorder'>&nbsp;</td>
		</tr>
		<tr id='separator'>
			<td id='leftBorder'></td>
			<td colspan='2' bgcolor="#DCDCDC"></td>
			<td id='rightBorder'></td>
		</tr>
		<tr id='tr2'>
			<td id='leftBorder'>&nbsp;</td>
			<td id='main' colspan='2' style="vertical-align:top;"><?php include("main.php"); ?></td>
			<td id='rightBorder'>&nbsp;</td>
		</tr>
		<tr id='separator'>
			<td id='leftBorder'></td>
			<td colspan='2' bgcolor="#DCDCDC"></td>
			<td id='rightBorder'></td>
		</tr>
		<tr id='tr3'>
			<td id='leftBorder'>&nbsp;</td>
			<?php include("credits.php"); ?>
			<td id='rightBorder'>&nbsp;</td>
		</tr>
	</table>
</body>
</html>
<?php
	include("logs.php");
?>
