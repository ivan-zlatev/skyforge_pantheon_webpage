<?php
	if(isset($_POST['loginuser']) && isset($_POST['loginpass']) && checkFormEntry($_POST['loginuser']) && checkFormEntry($_POST['loginpass']))
	{
		$user = $_POST['loginuser'];
		$passwd = $_POST['loginpass'];

		$result = mysql_query("SELECT * FROM pantheon_register WHERE username = '" . $user . "'");
		while($row = mysql_fetch_array($result))
		{
			if(password_verify($passwd . $user, $row{'password'}))
			{
				$_SESSION['auth'] = "ja";
				$_SESSION['member_id'] = $row{'member_id'};
			}
		}
	}
	if(isset($_SESSION['auth']) && $_SESSION['auth'] != "ja")
	{
?>

<table border='0' cellpadding='0' cellspacing='0' align='center' width='200px' height='75px'>
	<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
		<tr align='center' height='25px'>
			<td colspan='2'><input id="loginInputs" type="text" name="loginuser" /></td>
		</tr>
		<tr align='center' height='25px'>
			<td colspan='2'><input id="loginInputs" type="password" name="loginpass" /></td>
		</tr>
		<tr align='center'>
			<td><input id="loginButtons" type="submit" value="Log in" /></td>
	</form>
	<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
			<td><input id="loginButtons" type="submit" name="p" value="Register" /></td>
	</form>
		</tr>
</table>
<?php
	}
	else
	{
?>
<table border='0' cellpadding='0' cellspacing='0' align='center' width='200px' height='75px'>
	<tr align="right" height='25px'>
		<td><?php $result=mysql_query("SELECT * FROM pantheon_register WHERE member_id = '" . $_SESSION['member_id'] . "' LIMIT 1"); while($row=mysql_fetch_array($result)){ echo $row{'username'} . "&nbsp;"; } ?></td>
	</tr>
	<tr align="right">
		<td>
<?php
	$epoch = "0";
	$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 ORDER BY epoch DESC LIMIT 1");
	while($row = mysql_fetch_array($result)){$epoch = $row{'epoch'};}
	$result = mysql_query("SELECT * FROM pantheon WHERE epoch = '" . $epoch . "' AND member_id = '" . $_SESSION['member_id'] . "' LIMIT 1");
	while($row = mysql_fetch_array($result)){echo $row{'name'} . "&nbsp;";}
?>
		</td>
	</tr>
	<tr align='right' height='25px'>
		<td>
			<form action="index.php" method="get">
				<input type="hidden" name="p" value="logout" />
				<input type="submit" value=" &nbsp; Log&nbsp;&nbsp;Out &nbsp; " />
			</form>
		</td>
	</tr>
</table>
<?php
	}
?>
