<table border='0' cellpadding='5' cellspacing='0' align='center' width='675px'>
	<tr>
		<td><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "homepage") echo("<u>"); if (!isset($_GET['p'])) echo ("<u>");?><a id="menuHref" href="index.php?p=homepage">Homepage</a><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "homepage") echo("</u>"); if (!isset($_GET['p'])) echo ("</u>");?></td>
		<td><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "current") echo("<u>"); ?><a id="menuHref" href="index.php?p=current">Current</a><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "current") echo("</u>"); ?></td>
		<td><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "daily") echo("<u>"); ?><a id="menuHref" href="index.php?p=daily">Daily</a><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "daily") echo("</u>"); ?></td>
		<td><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "weekly") echo("<u>"); ?><a id="menuHref" href="index.php?p=weekly">Weekly</a><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "weekly") echo("</u>"); ?></td>
		<td><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "statistics") echo("<u>"); ?><a id="menuHref" href="index.php?p=statistics">Statistics</a><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "statistics") echo("</u>"); ?></td>
		<td><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "lfg") echo("<u>"); ?><a id="menuHref" href="index.php?p=lfg">LFG</a><?php if (isset($_GET['p']) && isValidPage($_GET['p']) && $_GET['p'] == "lfg") echo("</u>"); ?></td>
	</tr>
</table>
