<?php
        if(isset($_POST['authuser']) && isset($_POST['authpass']) && $_POST['member_id'] != "0")
        {
		$hash = password_hash($_POST['authpass'] . $_POST['authuser'], PASSWORD_BCRYPT);
		$result = mysql_query("SELECT * FROM pantheon_register WHERE member_id = '" . $_POST['member_id'] . "' OR username = '" . $_POST['authuser'] . "'");
		$exists = False;
		while($row = mysql_fetch_array($result))
		{
			echo "User already registered";
			$exists = True;
		}
		if(!$exists)
		{
			$result = mysql_query("INSERT INTO pantheon_register (member_id, username, password) VALUES ('" . $_POST['member_id'] . "', '" . $_POST['authuser'] . "', '" . $hash . "') ");
			echo "Username " . $_POST['authuser'] . " assigned to " . $_POST['member_id'] ;
			$_SESSION['auth'] = "ja";
			$_SESSION['member_id'] = $_POST['member_id'];

		}
        }
	else
	{
?><table border='1' cellpadding='0' cellspacing='0' align='center' width='800px'> 
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <tr align='center' height='25px'>
                        <td> Username: </td>
                        <td><input type="text" name="authuser" /></td>
                </tr>
                <tr align='center' height='25px'>
                        <td> Password: </td>
                        <td><input type="password" name="authpass" /></td>
                </tr>
		<tr>
			<td> Avatar Name: </td>
			<td>
				<input type="hidden" name="p" value="homepage" />
				<select name="member_id">
					<option value='0'>Select Avatar Name</option>
<?php
		$time = "0";
		$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 ORDER BY epoch DESC LIMIT 1");
		while($row = mysql_fetch_array($result)){$time=$row{"epoch"};}
		if($time != "0")
		{
			$result = mysql_query("SELECT * FROM pantheon WHERE epoch = " . $time . " ORDER BY name");
			while($row = mysql_fetch_array($result))
			{
				$result2 = mysql_query("SELECT * FROM pantheon_age WHERE member_id = '" . $row{'member_id'} . "' ORDER BY member_id ASC LIMIT 1");
				while($row2 = mysql_fetch_array($result2))
				{
					$user_exist = False;
					$result3 = mysql_query("SELECT * FROM pantheon_register WHERE member_id = '" . $row{'member_id'} . "'");
					while($row3 = mysql_fetch_array($result3))
					{
						$user_exist = True;
					}
					if(!$user_exist)
					{
?>
					<option value="<?php echo $row{'member_id'}; ?>"><?php echo $row{'name'}; ?></option>
<?php
					}
				}
			}
?>
				</select>
			</td>
		</tr>
                <tr align='center'>
                        <td colspan='2'><input id="loginButtons" type="submit" value="Register" /></td>
                </tr>
	</form>
</table>
<?php
		}
		else
		{
			echo "time not found";
		}
	}
?>
