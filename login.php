<?php
	if(isset($_POST['loginuser']) && isset($_POST['loginpass']))
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
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<tr align='center' height='25px'>
			<td colspan='2'><input id="loginInputs" type="text" name="loginuser" /></td>
		</tr>
		<tr align='center' height='25px'>
			<td colspan='2'><input id="loginInputs" type="password" name="loginpass" /></td>
		</tr>
		<tr align='center'>
			<td><input id="loginButtons" type="submit" value="Log in" /></td>
		</form>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
			<td><input id="loginButtons" type="submit" name="p" value="Register" /></td>
		</form>
		</tr>
</table>
<?php
	}
	else
	{
?>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
		<input type="hidden" name="p" value="logout" />
		<input type="submit" value="log out" />
	</form>
<?php
	}
?>
