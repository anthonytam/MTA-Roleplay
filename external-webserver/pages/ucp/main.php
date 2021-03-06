<?php
if (!isset($_SESSION['ucp_loggedin']) or !$_SESSION['ucp_loggedin'])
{
	header("Location: /ucp/login/");
	die();
}

$MySQLConn = @mysql_connect($Config['database']['hostname'], $Config['database']['username'], $Config['database']['password']);
if (!$MySQLConn) 
{
	$_SESSION['ucp_loggedin'] = false;
	$_SESSION['errno'] = 2;
	header("Location: /ucp/login/");
	die();
}
$selectdb = @mysql_select_db($Config['database']['database'], $MySQLConn);

$userID = $_SESSION['ucp_userid'];
$mQuery1 = mysql_query("SELECT `username`, `admin`, `appstate`, `appreason`, `banned`, `email`, `credits`, `transfers`, `appdatetime` > NOW() as 'noapply', HOUR(TIMEDIFF(NOW(), `appdatetime`)) as 'timehour', MINUTE(TIMEDIFF(NOW(), `appdatetime`)) as 'timeminute', `banned_reason`, `adminreports` FROM `accounts` WHERE id='" . $userID . "' LIMIT 1", $MySQLConn);
if (mysql_num_rows($mQuery1) == 0)
{
	$_SESSION['ucp_loggedin'] = false;
	$_SESSION['errno'] = 2;
	header("Location: /ucp/login/");
	die();
}
$userRow = mysql_fetch_assoc($mQuery1);

// Application stuff
$applicationState = $userRow['appstate'];
$applicationReason = $userRow['appreason'];
$timeminute = $userRow['timeminute'];
$timehour = $userRow['timehour'];
$cantApply = $userRow['noapply'];


// Generall stuff
$bannedState = $userRow['banned'];
$emailAddress = $userRow['email'];
$adminLevel = $userRow['admin'];
$adminReports = $userRow['adminreports'];
if(empty($emailAddress)){
	$emailAddress = '<a href="/ucp/editdetails/" class="link">Add an Email to Account</a>';
} else {
	$emailAddress = $_SESSION['ucp_email'];
}
$vPoints = $userRow['credits'];
$statTransfers = $userRow['transfers'];
$sTc = "0";
$vPc = "0";
if (empty($statTransfers)){
		$sTc = $statTransfers;
	} elseif ($statTransfers==0){ //confirm stats are 0
		$sTc = $statTransfers;
	} else {
		$sTc = '<span class="colored">' . $statTransfers . '</span>'; }
if (empty($vPoints)){
		$vPc = $vPoints;
	} elseif ($vPoints==0) { //confirm stats are 0
		$vPc = $vPoints;
	} else {
		$vPc = '<span class="colored">' . $vPoints . '</span>'; }
?>	
        <!-- MAIN CONTENT -->
        <div class="one separator"></div>
        <!-- WELCOME BLOCK -->
        <div class="one notopmargin">
            <h3 class="welcome nobottommargin left">Account Overview</h3>
            <p class="left description "></p>
        </div>
        <!-- END WELCOME BLOCK -->
			<?php require_once("././includes/sidebar.php"); ?>
        <div class="three-fourth last">
        <div class="three-fourth last notopmargin">
        		<?php //security_updated(1); ?>
				<div class="three-fourth notopmargin last">
				<ul style="list-style-type:none;">
				<li><h4 class="sh4">Account Status: <?php echo getStandingFromIndex($bannedState); ?></h4></li>
				<?php /* *will not be using, donations are handled in a way that is inefficent!*<li><h4 class="sh4">Donator Title: <?php echo getDonatorTitleFromIndex($index); ?></h4></li>*/?>
			<?php if ($adminLevel >= 1){ //admin titles - no need to change..shows admins their level name?>
				<li><h4 class="sh4">Admin Level: 							
				<?php
				if ($adminLevel > 7){ ?>
					<span class="colored">Developer</span>
				<?php }
				if ($adminLevel == 7){ ?>
					<span class="level6">Owner</span><span> (<?php echo $adminReports;?> REPORTS)</span>
				<?php }
				if ($adminLevel == 6){ ?>
					<span class="level5">Head Admin</span><span> (<?php echo $adminReports;?> REPORTS)</span>
				<?php }
				if ($adminLevel == 5){ ?>
					<span class="level4">Lead Admin</span><span> (<?php echo $adminReports;?> REPORTS)</span>
				<?php }
				if ($adminLevel == 4){ ?>
					<span class="level3">Super Admin</span><span> (<?php echo $adminReports;?> REPORTS)</span>
				<?php }
				if ($adminLevel == 3){ ?>
					<span class="level2">Admin</span><span> (<?php echo $adminReports;?> REPORTS)</span>
				<?php }
				if ($adminLevel == 2){ ?>
					<span class="level1">Trail Admin</span><span> (<?php echo $adminReports;?> REPORTS)</span>
				<?php }
				if ($adminLevel == 1){ ?>
					<span class="level1">Suspended Admin</span><span> (<?php echo $adminReports;?> REPORTS)</span>  
				<?php } ?></h4>
				<?php } ?></li>
	
				<li><h4 class="sh4">Email: <span class="colored"><?php echo $emailAddress;?></span></h4></li>
				<li><h4 class="sh4">donPoints: <?php echo $vPc;?></h4></li>
				<li><h4 class="sh4">Transfers: <?php echo $sTc;?></h4></li>	
				</ul>
			</div>
			</div>

		 </div>
		 <div class="three-fourth notopmargin last">
<?php
//<li><b>Forum Signature:</b> <a href="/pages/create_sig.php?show=1&id=p echo $userID; " target="_blank">Click to view and get code</a><li>
$charQuery = mysql_query("SELECT `id`, `charactername`,`cked`,`skin` FROM `characters` WHERE `account`='".$userID."' AND `active`=1");
if (mysql_num_rows($charQuery) > 0)
{
?>		
		<br /><center>
		
		<h3 class="colored">Active Characters</h3>
		<table align="center" border="0">
			<tr>
<?php
	$rowpos = 1;
	while ($row = mysql_fetch_assoc($charQuery))
	{
		if ($rowpos == 6)
		{
			echo "</tr>\r\n";
			echo "<tr>\r\n";
			
			$rowpos = 1;
		}
		
		// workaround for the current image links
		$add = '';
		$addd = '';
		if (strlen($row['skin']) != 3)
			$add='0';
		if (strlen($row['skin'])+1 < 3)
			$addd='0';
		// end workaround
		
		if ($row["cked"] == 0)
			$status = '<span class="charStatusAe">Alive</span>';
		else
			$status = '<span class="charStatusDe">Dead</span>';
		echo "									<td style=\"padding-left:4px; padding-right:4px;\" align=\"center\"><a href=\"/ucp/character/".$row["id"]."/\" ><img class=\"UCPcharacterA\" src=\"/images/chars/".$add.$addd.$row['skin'].".png\"><BR /><span class=\"charNamee\">".str_replace("_", " ", $row["charactername"])."</span></a><BR />".$status."</td>\r\n"; // <BR /><a href='http://www.mta.vg/pages/create_sig.php?show=2&id=" . $row['id'] . "' target='_blank'>View Sig</a>
		$rowpos++;
	}					
?>
			</tr>
		</table>

<?php
}
$inactivecharQuery = mysql_query("SELECT `id`, `charactername`,`cked`,`skin` FROM `characters` WHERE `account`='".$userID."' AND `active`=0");
if (mysql_num_rows($charQuery) > 0)
{
?>
		<h3>Deactivated Characters</h3>
		<table align="center" border="0">
			<tr>
<?php
	$rowpos = 1;
	while ($row = mysql_fetch_assoc($inactivecharQuery))
	{
		if ($rowpos == 6)
		{
			echo "</tr>\r\n";
			echo "<tr>\r\n";
			
			$rowpos = 1;
		}
		
		// workaround for the current image links
		$add = '';
		$addd = '';
		if (strlen($row['skin']) != 3)
			$add='0';
		if (strlen($row['skin'])+1 < 3)
			$addd='0';
		// end workaround
		
		if ($row["cked"] == 0)
			$status = '<span class="charStatusAd">Alive</span>';
		else
			$status = '<span class="charStatusDd">Dead</span>';
		echo "									<td style=\"padding-left:4px; padding-right:4px;\"  align=\"center\"><a href=\"/ucp/character/".$row["id"]."/\"><img class=\"UCPcharacterA\" src=\"/images/chars/".$add.$addd.$row['skin'].".png\"><BR /><span class=\"charNamed\">".str_replace("_", " ", $row["charactername"])."</span></a><BR />".$status."</td>\r\n"; // <BR /><a href='/pages/create_sig.php?show=2&id=" . $row['id'] . "' target='_blank'>View Sig</a>
		$rowpos++;
	}
	}
?>
			</tr>
		</table>
		</center>
	</div>
		<!-- END MAIN CONTENT -->
