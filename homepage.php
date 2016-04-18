<?php
	$result = mysql_query("SELECT * FROM pantheon_log WHERE status = 1 ORDER BY epoch DESC LIMIT 1");
	while($row = mysql_fetch_array($result)){ $epoch = $row{'epoch'}; }
	$result = mysql_query("SELECT * FROM pantheon WHERE epoch = '" . $epoch ."'");
	$data = array();
	$data['members'] = 0;
	$data['prestige'] = 0;
	$data['topPrestige'] = array( 0, 0 );
	$data['bottomPrestige'] = array( 100000000, 0 );
	$data['oldestMember'] = array( time(), 0 );
	$data['newestMember'] = array( 0, 0 );
	while($row = mysql_fetch_array($result))
	{
		$data['members'] = $data['members'] + 1;
		$data['prestige'] = $data['prestige'] + $row{'prestige'};
		if($row{'prestige'} > $data['topPrestige'][0]){$data['topPrestige'] = array( $row{'prestige'}, $row{'name'});}
                if($row{'prestige'} < $data['bottomPrestige'][0]){$data['bottomPrestige'] = array( $row{'prestige'}, $row{'name'});}
		$player_age = getPlayerAge($row{'member_id'});
		if($player_age < $data['oldestMember'][0]){$data['oldestMember'] = array($player_age, $row{'name'}); }
                if($player_age > $data['newestMember'][0]){$data['newestMember'] = array($player_age, $row{'name'}); }
	}
?>
<table border='0' align='center' id='currentTable' cellspacing='0' cellpadding='0'>
	<tr height='70px'>
                <td colspan='3' style='font-weight:bold;text-align:center;font-size:30px;'>Pantheon Information</td>
        </tr>
	<tr height='1px'>
		<td colspan='3' style='background-color:#ddd;'></td>
        </tr>
	<tr>
		<td id='homepageTable1Col1'>Pantheon Name:</td>
		<td id='homepageTable1Col2'>Essence</td>
		<td style='text-align: right; font-weight: bold;'>Additional Information: &nbsp;</td>
	</tr>
	<tr height='1px'>
		<td colspan='3' style='background-color:#ddd'></td>
	</tr>
	<tr>
		<td id='homepageTable1Col1'>Language:</td>
		<td id='homepageTable1Col2'>English</td>
		<td id='homepageTable1Col3' rowspan='19'>
<!-- Additional Information td --!>
<a href='https://eu.portal.sf.my.com/comments/56b36b79ac72b98096b30da7' style='text-decoration:none;font-weight:bold;;'> Pantheon Academy 101 </a><br /><br />
<a href='https://eu.portal.sf.my.com/comments/56aa809bac72a85dfa14901e' style='text-decoration:none;font-weight:bold;'> Pantheon buildings, resources </a><br /><br />
<a href='https://eu.portal.sf.my.com/comments/56af7407ac72dacca534f8ed' style='text-decoration:none;font-weight:bold;'> Pantheon Credits requirement / Activity </a><br /><br />
<!-- End --!>
		</td>
	</tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
	<tr>
		<td id='homepageTable1Col1'>TeamSpeak:</td>
		<td id='homepageTable1Col2'><a href='ts3server://essence.planetteamspeak.net' style='text-decoration:none;font-weight:bold;'>essence.planetteamspeak.net</a></td>
	</tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
	<tr>
		<td id='homepageTable1Col1'>Credit Requirement:</td>
		<td id='homepageTable1Col2'><?php if(isset($GLOBALS['credits'])){ echo number_format($GLOBALS['credits']); } ?></td>
	</tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
        <tr>
                <td id='homepageTable1Col1'>Commanders:</td>
                <td id='homepageTable1Col2'>
<!-- Commanders --!>
Dimo Vasilev <br />
Emma Sokolov <br />
Goddesss Maya <br />
Lillantha Aethar <br />
Xatt Uss
<!-- End --!>
		</td>
        </tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
	<tr>
		<td id='homepageTable1Col1'>Members:</td>
		<td id='homepageTable1Col2'><?php echo number_format($data['members']); ?></td>
	</tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
	<tr>
		<td id='homepageTable1Col1'>Average Prestige:</td>
		<td id='homepageTable1Col2'><?php echo number_format($data['prestige']/$data['members']); ?></td>
	</tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
	<tr>
		<td id='homepageTable1Col1'>Top Prestige:</td>
		<td id='homepageTable1Col2'><?php echo number_format($data['topPrestige'][0]) . " &nbsp; " . $data['topPrestige'][1]; ?></td>
	</tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
        <tr>
                <td id='homepageTable1Col1'>Bottom Prestige:</td>
                <td id='homepageTable1Col2'><?php echo number_format($data['bottomPrestige'][0]) . " &nbsp; " . $data['bottomPrestige'][1]; ?></td>
        </tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
        <tr>
                <td id='homepageTable1Col1'>Oldest Member:</td>
                <td id='homepageTable1Col2'><?php echo gmdate("Y-m-d", $data['oldestMember'][0]) . " &nbsp; " . $data['oldestMember'][1]; ?></td>
        </tr>
	<tr height='1px'>
		<td colspan='2' style='background-color:#ddd'></td>
	</tr>
        <tr>
                <td id='homepageTable1Col1'>Newest Member:</td>
                <td id='homepageTable1Col2'><?php echo gmdate("Y-m-d", $data['newestMember'][0]) . " &nbsp; " . $data['newestMember'][1]; ?></td>
        </tr>
        <tr height='1px'>
                <td colspan='3' style='background-color:#ddd'></td>
        </tr>
</table>
<br /><br /><br /><br />
<?php
	$pantheonUpgradesArray = array(
		array( 'Academy 1', '600000', '1000', '-', 'Done' ),
		array( 'Research Center 1', '1000000', '200', '-', 'Done' ),
		array( 'Pantheon Chambers 2', '25000', '45', '-', 'Done' ),
		array( 'Fort 1', '1000000', '200', '-', 'Done' ),
		array( 'Pantheon Chambers 3', '45000', '75', '-', 'Done' ),
		array( 'Improved Condenser 2', '400000', '660', '-', 'Done' ),
		array( 'Academy 2', '1800000', '3000', '-', 'Done' ),
		array( 'Research Center 2', '2000000', '300', '-', 'Done' ),
		array( 'Converter 1', '1500000', '2500', '-', 'Done' ),
		array( 'Research Center 3', '3000000', '400', '-', 'Done' ),
		array( 'Improved Condenser 3', '800000', '1340', '-', 'Done' ),
		array( 'Research Center 4', '4000000', '500', '-', 'Waiting for Credits' )
	);
?>
<table border='0' align='center' id='currentTable' cellspacing='2' cellpadding='0'>
	<tr height='70px'>
		<td colspan='6' style='font-weight:bold;text-align:center;font-size:30px;'>Pantheon Upgrades</td>
	</tr>
	<tr height='1px'>
                <td colspan='6' style='background-color:#ddd;'></td>
        </tr>
	<tr style="text-align:left;font-weight:bold;">
		<td>#</td>
		<td>Component</td>
		<td>Pantheon Credits</td>
		<td>Construction Resources</td>
		<td>Additional Cost</td>
		<td>Status</td>
	</tr> 
	<tr height='1px'>
		<td colspan='6' style='background-color:#ddd;'></td>
	</tr>
<?php
	$i = 0;
	$bold = "";
	foreach( $pantheonUpgradesArray as $update )
	{
		$i++;
		if(strlen($update[4]) > 5) $bold = "font-weight:bold;"; else $bold = "";
?>
	<tr style="text-align:left;<?php echo $bold; ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $update[0]; ?></td>
                <td><?php echo number_format($update[1]); ?></td>
                <td><?php echo number_format($update[2]); ?></td>
                <td><?php echo $update[3]; ?></td>
                <td><?php echo $update[4]; ?></td>
        </tr>
	<tr height='1px'>
                <td colspan='6' style='background-color:#ddd;'></td>
        </tr>
<?php
	}
?>
</table>
<br /><br /><br />
