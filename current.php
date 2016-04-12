<table border='0' align='center' id='currentTable'>
<?php
	include("pantheon_requirements.php");
?>
<?php
//execute the SQL query and return records
$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 ORDER BY epoch DESC LIMIT 1");
while($row = mysql_fetch_array($result)){ $tmp = $row{"epoch"};}
if(isset($_GET['ORDER_BY']) && isValidOrderBy($_GET['ORDER_BY']))
{
	$ORDER_BY = $_GET['ORDER_BY'];
}
else
{
	$ORDER_BY = "name";
}
if(isset($_GET['ORDER_TYPE']) && isValidOrderType($_GET['ORDER_TYPE']))
{
	$ORDER_TYPE = $_GET['ORDER_TYPE'];
	if($ORDER_TYPE=="ASC")
	{
		$ORDER_TYPE_NEXT = "DESC";
	}
	else
	{
		$ORDER_TYPE_NEXT = "ASC";
	}
}
else
{
	$ORDER_TYPE = "ASC";
	$ORDER_TYPE_NEXT = "DESC";
}
if( isset($tmp))
{
?>
	<tr>
		<td colspan='7'>&nbsp;</td>
	</tr>
	<tr id='currentTableTop'>
		<td width='30px' id='tableColumnSelector' rowspan='2'>#</td>
		<td rowspan='2'><a href='?p=current&ORDER_BY=name&ORDER_TYPE=<?php echo $ORDER_TYPE_NEXT; ?>' id='tableColumnSelector'>Name</a></td>
		<td width='100px' colspan='2'><a href='?p=current&ORDER_BY=memberType&ORDER_TYPE=<?php echo $ORDER_TYPE_NEXT; ?>' id='tableColumnSelector'>Member</a></td>
		<td width='120px' colspan='2'><a href='?p=current&ORDER_BY=prestige&ORDER_TYPE=<?php echo $ORDER_TYPE_NEXT; ?>' id='tableColumnSelector'>Current Prestige</a></td>
		<td width='120px' colspan='2'><a href='?p=current&ORDER_BY=credits&ORDER_TYPE=<?php echo $ORDER_TYPE_NEXT; ?>' id='tableColumnSelector'>Credits Donated</a></td>
		<td width='120px' colspan='2'><a href='?p=current&ORDER_BY=resources&ORDER_TYPE=<?php echo $ORDER_TYPE_NEXT; ?>' id='tableColumnSelector'>Construction Resources</a></td>
	</tr>
	<tr>
		<td style="text-align:Left; font-weight:bold; background:#DDD;">Type</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Age</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Value</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Delta</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Value</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Delta</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Value</td>
		<td style="text-align:Right; font-weight:bold; background:#DDD;">Delta</td>
	</tr>
<?php
$result = mysql_query("SELECT * FROM pantheon WHERE epoch = ". $tmp ." ORDER BY ". $ORDER_BY ." ". $ORDER_TYPE ."");
//fetch tha data from the database
$i=1;
while ($row = mysql_fetch_array($result))
{
	if(isset($_SESSION['member_id']) && $_SESSION['member_id']==$row{'member_id'})
	{
		$background = "currentTableBottom2";
	}
	else
	{
		$background = "currentTableBottom". $i%2;
	}
	$memberAge = "";
	$ageResult = mysql_query("SELECT * FROM pantheon_age WHERE member_id = '" . $row{'member_id'} . "' ");
	while ($ageRow = mysql_fetch_array($ageResult))
	{
		$memberAge = epochTimeDiff($ageRow{"age"}, $tmp, "weeks");
		if ($memberAge == 0){$memberAge=1;}
	}
	if(isset($GLOBALS['prestige']))
	{
		$prestigeDelta = number_format((float)($row{'prestige'} / ($GLOBALS['prestige'] * $memberAge)) , 2, '.', '');
		}else{$prestigeDelta = "N/A";}
	if(isset($GLOBALS['credits']))
	{
		$creditsDelta = number_format((float)($row{'credits'} / ($GLOBALS['credits'] * $memberAge)) , 2, '.', '');
	}else{$creditsDelta = "N/A";}
	if(isset($GLOBALS['resources']))
	{
		$resourcesDelta = number_format((float)($row{'resources'} / ($GLOBALS['resources'] * $memberAge)) , 2, '.', '');
	}else{$resourcesDelta = "N/A";}
	echo "
	<tr id='". $background ."'>
		<td style='text-align:right'>". $i .".</td>
		<td style='text-align:left'><a href='https://eu.portal.sf.my.com/wall/". $row{'member_id'} ."' style='text-decoration:none;color:#000;'>". $row{'name'} ."</a></td>
		<td style='text-align:left'>". $row{'memberType'} ."</td>
		<td style='text-align:right'>[" . $memberAge . "]</td>
		<td style='text-align:right'>". number_format($row{'prestige'}) ."</td>
		<td style='text-align:right; width:50px;" . deltaChangeColorWhenBelowOne($prestigeDelta) . "' title=''>" . $prestigeDelta . "</td>
		<td style='text-align:right'>". number_format($row{'credits'}) ."</td>
		<td style='text-align:right; width:50px;" . deltaChangeColorWhenBelowOne($creditsDelta) . "' title='" . deltaTitleWhenBelowOne($creditsDelta, number_format($row{'credits'}), $memberAge) . "'>" . $creditsDelta . "</td>
		<td style='text-align:right'>". number_format($row{'resources'}) ."</td>
		<td style='text-align:right; width:50px;" . deltaChangeColorWhenBelowOne($resourcesDelta) . "' title=''>" . $resourcesDelta . "</td>
	</tr>
	";
	$i+=1;
}
?>
	<tr>
		<td colspan='7'>&nbsp;</td>
	</tr>
	<tr>
		<td colspan='7' style='text-align:left'>The data is from <?php echo gmdate('Y-m-d H:i:s', $tmp ); ?> GMT, <?php echo number_format((float)(time() - $tmp)/3600, 1, '.', '') . " hours ago"; ?></td>
	</tr>
<?php
}
else
{
?>
	<tr>
		<td> No data found. </td>
	</tr>
<?php
}
?>
</table>
