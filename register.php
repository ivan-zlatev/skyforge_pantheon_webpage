<?php
        if(isset($_POST['authuser']) && isset($_POST['authpass']) && $_POST['member_id'] != "0") 
        {
		if( checkFormEntry($_POST['authuser']) && checkFormEntry($_POST['authpass']))
		{
			$hash = password_hash($_POST['authpass'] . $_POST['authuser'], PASSWORD_BCRYPT);
			$result = mysql_query("SELECT * FROM pantheon_register WHERE member_id = '" . htmlspecialchars($_POST['member_id']) . "' OR username = '" . htmlspecialchars($_POST['authuser']) . "'");
			$exists = False;
			while($row = mysql_fetch_array($result))
			{
				echo "User already registered";
				$exists = True;
			}
			if(!$exists)
			{
				$result = mysql_query("INSERT INTO pantheon_register (member_id, username, password) VALUES ('" . htmlspecialchars($_POST['member_id']) . "', '" . htmlspecialchars($_POST['authuser']) . "', '" . $hash . "') ");
				echo "Username " . htmlspecialchars($_POST['authuser']) . " assigned to " . htmlspecialchars($_POST['member_id']) ;
				$_SESSION['auth'] = "ja";
				$_SESSION['member_id'] = htmlspecialchars($_POST['member_id']);

			}
		}
		else
		{
			print $_SESSION['checkFormEntry'];
		}
        }
	else
	{
?>
<table border='0' cellpadding='0' cellspacing='5' align='center' width='700px'> 
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
		<tr height='25px'>
			<td colspan='2'>&nbsp;</td>
		</tr>
                <tr align='center' height='25px'>
                        <td style="text-align:right;width:280px"> Username: </td>
                        <td style="color:red;text-align:left;"><input type="text" name="authuser" />* Required</td>
                </tr>
                <tr align='center' height='25px'>
                        <td style="text-align:right;"> Password: </td>
                        <td style="color:red;text-align:left;"><input type="password" name="authpass" />* Required</td>
                </tr>
		<tr>
			<td style="text-align:right;"> Avatar Name: </td>
			<td style="color:red;text-align:left;">
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
				* Required
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
