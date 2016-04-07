<table border='0' align='center' id='statisticsTable'>

	<form action="<?php $_SERVER['PHP_SELF']; ?>" id="statisticsDateForm" method='GET'>
		<tr>
			<td align="left" colspan='3'>
				<input type="hidden" name="p" value="statistics" />
				<select name="week" onchange="this.form.submit()">
					<option value="0">Select Week</option>
<?php
	$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 ORDER BY epoch ASC LIMIT 1");
	while($row = mysql_fetch_array($result)){$startTime = $row{"epoch"};}
	$selectDateArray = getDateForSpecificDayBetweenDates($startTime, time(), "3");
	foreach ($selectDateArray as $date)
	{
		unset($selected);
		if(isset($_GET['week']) && isValidWeek($_GET['week']) && $date[0] . "===" . $date[1] == $_GET['week']){
			$selected = " selected='selected' ";
		}
		elseif(!isset($_GET['week']) && $date == end($selectDateArray))
		{
			$_GET['week'] = $date[0] . "===" . $date[1];
			$selected = " selected='selected' ";
		}
		else
		{
			$selected = "";
		}
		echo "
					<option value='" . $date[0] . "===" . $date[1] . "' " . $selected . ">" . $date[0] . " - " . $date[1] . "</option>";
	}
?>

				</select>
			</td>
		</tr>
		<tr>
			<td width="200px">&nbsp;</td>
			<td width="70px">&nbsp;</td> 
			<td>&nbsp;</td>
		</tr>
<?php
if(isset($_GET['week']) && isValidWeek($_GET['week']) && $_GET['week'] != "0")
{
	unset($time1);
	unset($time2);
	unset($time3);
	$tmp = explode("===",$_GET['week']);
	$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 AND epoch < ". (strtotime($tmp["1"]) + 23*60*60 )  ." ORDER BY epoch DESC LIMIT 1");
	while($row = mysql_fetch_array($result)){$time1 = $row{"epoch"};}
	$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 AND epoch < ". strtotime($tmp["0"]) ." ORDER BY epoch DESC LIMIT 1");
	while($row = mysql_fetch_array($result)){$time2 = $row{"epoch"};}
	
	if(!isset($time1) || !isset($time2))
	{
		return;
	}
	unset($dataArray1);
	unset($dataArray2);
	$dataArray1 = setDataArraysForStatistics();
	$dataArray1["epoch"] = $time1;
	$dataArray2 = setDataArraysForStatistics();
	$dataArray2["epoch"] = $time2;
	$result = mysql_query("SELECT * FROM pantheon WHERE epoch = " . $time1 . " ORDER BY name ASC");
	while($row = mysql_fetch_array($result))
	{
		$dataArray1["members"] = ($dataArray1["members"] + 1);
		$dataArray1["prestige"] = ($dataArray1["prestige"] + $row{"prestige"});
		$dataArray1["credits"] = ($dataArray1["credits"] + $row{"credits"});
		$dataArray1["resources"] = ($dataArray1["resources"] + $row{"resources"});
		$dataArray1["colaboration"] = ($dataArray1["colaboration"] + $row{"colaboration"});
		if($row{"memberType"} == "pantheon")
		{
			$dataArray1["member"] = ($dataArray1["member"] + 1);
		}
		else
		{
			$dataArray1["academy"] = ($dataArray1["academy"] + 1);
		}
	}
	$result = mysql_query("SELECT * FROM pantheon WHERE epoch = " . $time2 . " ORDER BY name ASC");
	while($row = mysql_fetch_array($result))
	{
		$dataArray2["members"] = ($dataArray2["members"] + 1);
		$dataArray2["prestige"] = ($dataArray2["prestige"] + $row{"prestige"});
		$dataArray2["credits"] = ($dataArray2["credits"] + $row{"credits"});
		$dataArray2["resources"] = ($dataArray2["resources"] + $row{"resources"});
		$dataArray2["colaboration"] = ($dataArray2["colaboration"] + $row{"colaboration"});
		if($row{"memberType"} == "pantheon")
		{
			$dataArray2["member"] = ($dataArray2["member"] + 1);
		}
		else
		{
			$dataArray2["academy"] = ($dataArray2["academy"] + 1);
		}
	}
}
?>
		<tr>
			<td style="text-align: left;" >Total Members:</td><?php $key = 'members'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;" >Prestige:</td><?php $key = 'prestige'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;" >Credits:</td><?php $key = 'credits'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;" >Construction Resources:</td><?php $key = 'resources'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;" >Colaboration Points:</td><?php $key = 'colaboration'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;" >Members:</td><?php $key = 'member'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
		<tr>
			<td style="text-align: left;" >Academy:</td><?php $key = 'academy'; $key = ((($dataArray1[$key] - $dataArray2[$key])/$dataArray1[$key]) * 100 ); ?>
			<td style="text-align: left;"><?php echo number_format((float)$key, 2, '.', '') . "%"; ?></td>
			<td>
				<div class="bar">
					<div class="percentage" style="width:<?php echo $key; ?>%; color:#FFFFFF">&nbsp;</div>
				</div>
			</td>
		</tr>
	</form>
</table>

















