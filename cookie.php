<?php
        if(isset($_COOKIE['member_id']) && isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "logout")
        {
                setcookie( "member_id", "", time() - 3600, "/");
		unset($_SESSION['member_id']);
		unset($_SESSION['auth']);
		unset($_COOKIE['member_id']);
		session_destroy();
                $_GET['p'] = "homepage";
        }

	if(!isset($_COOKIE['member_id']) && isset($_SESSION['member_id']))
	{
		$date_of_expiry = time() + 60*60*24*30;
		setcookie( "member_id", $_SESSION['member_id'], $date_of_expiry, "/");
	}
	if(isset($_COOKIE['member_id']) && !isset($_SESSION['member_id'])){
		$_SESSION['member_id'] = $_COOKIE['member_id'];
		$_SESSION['auth'] = "ja";
	}
?>
