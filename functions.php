<?php

/////////////////////////////////////////////////////////////////////////////
function epochTimeDiff($epoch_1, $epoch_2, $res)
{
	$diff_seconds  = abs($epoch_1 - $epoch_2);
	$diff_weeks    = floor($diff_seconds/604800);
	$diff_seconds -= $diff_weeks   * 604800;
	$diff_days     = floor($diff_seconds/86400);
	$diff_seconds -= $diff_days    * 86400;
	$diff_hours    = floor($diff_seconds/3600);
	$diff_seconds -= $diff_hours   * 3600;
	$diff_minutes  = floor($diff_seconds/60);
	$diff_seconds -= $diff_minutes * 60;
	switch ($res) {
		case "seconds":
			return $diff_seconds;
			break;
		case "minutes":
			return $diff_minutes;
			break;
		case "hours":
			return $diff_hours;
			break;
		case "days":
			return $diff_days;
			break;
		case "weeks":
			return $diff_weeks;
			break;
		default:
			return 0;
	}
}

/////////////////////////////////////////////////////////////////////////////
function deltaChangeColorWhenBelowOne($delta)
{
	$val1 = "1.0";
	$val2 = "0.75";
	$val3 = "0.50";
	if($delta != "N/A" && $delta < $val1 && $delta >= $val2)
	{
		return "background:yellow;";
	}
	elseif($delta != "N/A" && $delta < $val2 && $delta >= $val3)
	{
		return "background:#F75D59;";
	}
	elseif($delta != "N/A" && $delta < $val3)
	{
		return "background:#FE0000;font-weight:bold;";
	}
}

/////////////////////////////////////////////////////////////////////////////
function deltaTitleWhenBelowOne($delta, $column, $age)
{
	$val1 = "1.0";
	if($delta != "N/A" && $delta < $val1)
	{
		return "PAY YOUR DEBTS :D";
	}
}
/////////////////////////////////////////////////////////////////////////////
function validateDate($date)
{
	$d = DateTime::createFromFormat('Y-m-d', $date);
	return $d && $d->format('Y-m-d') === $date;
}

/////////////////////////////////////////////////////////////////////////////
function gainPercentage($num1, $num2)
{
	if( $num1 == $num2 )
	{
		return 0;
	}
	else
	{
		return number_format((float)((($num1-$num2)/$num1)*100), 2, '.', '');
	}
}

/////////////////////////////////////////////////////////////////////////////
function getDateForSpecificDayBetweenDates($startDate,$endDate,$day_number)
{
	$days=array('1'=>'Monday','2' => 'Tuesday','3' => 'Wednesday','4'=>'Thursday','5' =>'Friday','6' => 'Saturday','7'=>'Sunday');
	for($i = strtotime($days[$day_number], $startDate); $i <= $endDate; $i = strtotime('+1 week', $i))
	{
		$date_array[]= array(date('Y-m-d',$i), date('Y-m-d', strtotime("+6 days" ,$i)) );
	}
	return $date_array;
}

/////////////////////////////////////////////////////////////////////////////
function isValidOrderBy($ORDER_BY)
{
	switch ($ORDER_BY){
		case "epoch":
			return True;
			break;
		case "member_id":
			return True;
			break;
		case "name":
			return True;
			break;
		case "prestige":
			return True;
			break;
		case "credits":
			return True;
			break;
		case "resources":
			return True;
			break;
		case "colaboration":
			return True;
			break;
		case "memberType":
			return True;
			break;
		case "prestigeValue":
			return True;
			break;
		case "prestigePercent":
			return True;
			break;
		case "creditsValue":
			return True;
			break;
		case "creditsPercent":
			return True;
			break;
		case "resourcesValue":
			return True;
			break;
		case "resourcesPercent":
			return True;
			break;
		default:
			return False;
	}
}

/////////////////////////////////////////////////////////////////////////////
function isValidOrderType($ORDER_TYPE)
{
	switch ($ORDER_TYPE){
		case "ASC":
			return True;
			break;
		case "DESC":
			return True;
			break;
		default:
			return False;
	}
}

/////////////////////////////////////////////////////////////////////////////
function isValidPage($p)
{
	switch ($p){
		case "homepage":
			return True;
			break;
		case "current":
			return True;
			break;
		case "daily":
			return True;
			break;
		case "weekly":
			return True;
			break;
		case "statistics":
			return True;
			break;
		case "lfg":
			return True;
			break;
		case "Register":
			return True;
			break;
		case "logout":
			return True;
			break;
		default:
			return False;
	}
}

/////////////////////////////////////////////////////////////////////////////
function isValidWeek($week)
{
	$week = explode("===",$week);
	if (validateDate($week["0"]) && validateDate($week["1"])){ return True; } else { return False; }
}

/////////////////////////////////////////////////////////////////////////////
function setDataArraysForStatistics()
{
	$array[] = array();
	foreach ( array(
		"epoch",
		"members",
		"prestige",
		"credits",
		"resources",
		"colaboration",
		"member",
		"academy") as $key )
	{
		$array[$key] = 0;
	}
	return $array;
}

/////////////////////////////////////////////////////////////////////////////
function checkFormEntry($data)
{
	$max    = 20;
	$string = $data;
	$_SESSION['checkFormEntry'] = "";
	
	// RegEx 
	if (preg_match('/[^a-zA-Z0-9]/', $string)){
		$_SESSION['checkFormEntry'] = 'only letters and numbers are allowed, no spaces or special characters';
		return False;
	} 
	
	// Check a value i provided
	$len = strlen($string);
	if ($len == 0) {
		$_SESSION['checkFormEntry'] = 'you must provide a value';
		return False;
	}
	
	// Check the string length
	if ($len > $max) {
		$_SESSION['checkFormEntry'] = 'the value cannot be longer than ' . $max;
		return False;
	}
	return True;
}

/////////////////////////////////////////////////////////////////////////////
function getPlayerAge($member_id)
{
	$result = mysql_query("SELECT * FROM pantheon_age WHERE member_id = '" . $member_id . "' ORDER BY age DESC LIMIT 1") or die(mysql_error());
	while($row = mysql_fetch_array($result)){ return $row{'age'}; }
}
?>
