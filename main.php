<?php
	if($_SESSION['authentication'] == "ja")
	{
		if(isset($_GET['p']) && isValidPage($_GET['p']))
		{
			switch ($_GET['p'])
			{
				case "homepage":
					include("homepage.php");
					break;
				case "current":
					include("current.php");
					break;
				case "daily":
					include("daily.php");
					break;
				case "weekly":
					include("weekly.php");
					break;
				case "statistics";
					include("statistics.php");
					break;
				case "lfg":
					include("lfg.php");
					break;
				default:
					include("homepage.php");
			}
		}else{
			include("homepage.php");
		}
	}
?>
