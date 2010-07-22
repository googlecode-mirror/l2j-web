<?php
/**********************************************************************/
/* Project Name.: L2J-Web							*/
/* SVN .........: https://l2j-web.googlecode.com/svn/trunk/L2J-Web/	*/
/* File Name....: armor_details.php					*/
/* Author.......: Sebastien Gascon						*/
/* Author Email.: sebastien.gascon@gmail.com				*/
/* Created On...: 23/01/2007 10:25:41 PM					*/
/* Last Updated.: 22/07/2010 10:39:17 AM					*/
/**********************************************************************/
include('header.inc.php');
include('config.inc.php');
include('lib.inc.php');


include('menu.php');
include('member.php');

if (empty($_GET[itemid])){
	echo "nothing";
	exit;
}
dbconnect();
$sql = "SELECT COUNT(*) AS count FROM items WHERE item_id = '$_GET[itemid]'";
$result = mysql_query($sql, $conn) or die(mysql_error());
while ($newArray = mysql_fetch_array($result)) {
	$item_count = $newArray['count'];
}
$sql = "SELECT * FROM armor WHERE item_id = '$_GET[itemid]' LIMIT 0,1";
echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"587\">\n";
echo "<tr>";
if($accesslevel >= 100){
	echo "<td class=\"id\">ID</td>";
}
echo "<td class=\"id\">Icon</td>";
echo "<td class=\"name\">Name</td>";
echo "<td class=\"type\">Type</td>";
echo "<td class=\"weight\">Weight</td>";
echo "<td class=\"grade\">Grade</td>";
echo "<td class=\"pdef\">P.Def</td>";
echo "<td class=\"mdef\">M.Def</td>";
echo "<td class=\"mp\">MP</td>";
echo "</tr>";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while ($newArray = mysql_fetch_array($result)) {
	$armor_id = $newArray['item_id'];
	$armor_name = $newArray['name'];
	$armor_type = $newArray['armor_type'];
	$armor_weight = $newArray['weight'];
	$armor_grade = $newArray['crystal_type'];
	$armor_pdef = $newArray['p_def'];
	$armor_mdef = $newArray['m_def'];
	$armor_mpbonus = $newArray['mp_bonus'];
	$armor_price = $newArray['price'];

	if ($i %2){
			$linebg = 'line1';
		}else{
			$linebg = 'line2';
		}
	echo "<tr class=\"$linebg\">";
	if($accesslevel >= 100){
		echo "<td class=\"id\">$armor_id</td>";
	}
	echo "<td class=\"id\"><img src=\"images/items/$armor_id.gif\"></td>";
	echo "<td class=\"name\"><a href=\"armor_details.php?itemid=$armor_id\">$armor_name</a></td>";
	echo "<td class=\"type\">$armor_type</td>";
	echo "<td class=\"weight\">$armor_weight</td>";
	echo "<td class=\"grade\">$armor_grade</td>";
	echo "<td class=\"pdef\">$armor_pdef</td>";
	echo "<td class=\"mdef\">$armor_mdef</td>";
	echo "<td class=\"mp\">$armor_mpbonus</td>";
	echo "</tr>";
	$i ++;	
}
echo "</table>";
if($accesslevel >= 100){
	echo "Number of existing items in world: <a href=\"owners.php?itemid=$armor_id\">$item_count</a><br/></td>";
}
echo "<br/><b>Drops:</b><br/>";
echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"389\">\n";
echo "<tr>";
if($accesslevel >= 100){
	echo "<td class=\"id\">ID</td>";
}
echo "<td class=\"name\">Name</td>";
echo "<td class=\"level\">Level</td>";
echo "<td class=\"chance\">Chance</td>";
echo "</tr>";
$sql = "SELECT * FROM droplist WHERE itemId = '$_GET[itemid]' LIMIT 0,1000";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while ($newArray = mysql_fetch_array($result)) {
	$drop_mobid = $newArray['mobId'];
	$drop_chance = $newArray['chance'];


	$sql2 = "SELECT * FROM npc WHERE id = '$drop_mobid' LIMIT 0,1000";
	$result2 = mysql_query($sql2, $conn) or die(mysql_error());
	while ($newArray2 = mysql_fetch_array($result2)) {
		$mob_name = $newArray2['name'];
		$mob_level = $newArray2['level'];
	
	if ($i %2){
			$linebg = 'line1';
		}else{
			$linebg = 'line2';
		}
	echo "<tr class=\"$linebg\">";
	if($accesslevel >= 100){
		echo "<td class=\"id\">$drop_mobid</td>";
	}
	echo "<td class=\"name\"><a href=\"map.php?mobid=$drop_mobid\">$mob_name</a></td>";
	echo "<td class=\"level\">$mob_level</td>";
	if ($drop_spoil == 1){
		$drop_spoil_display = '<br/>Spoil';
	}
	$drop_chance_pct = $drop_chance / 1000;
	echo "<td class=\"chance\">$drop_chance_pct % $drop_spoil_display</td>";
	echo "</tr>";
	}
	$i ++;
	
}
echo "</table>";
echo "<br/><b>Shops:</b><br/>";
echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"344\">\n";
echo "<tr>";
if($accesslevel >= 100){
	echo "<td class=\"id\">ID</td>";
}
echo "<td class=\"name\">Name</td>";
echo "<td class=\"price\">Price</td>";
echo "</tr>";
$sql = "SELECT * FROM merchant_buylists WHERE item_id = '$_GET[itemid]' LIMIT 0,1000";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while ($newArray = mysql_fetch_array($result)) {
	$shop_id = $newArray['shop_id'];
	$shop_price = $newArray['price'];


	$sql2 = "SELECT * FROM merchant_shopids WHERE shop_id = '$shop_id' LIMIT 0,1000";
	$result2 = mysql_query($sql2, $conn) or die(mysql_error());
	while ($newArray2 = mysql_fetch_array($result2)) {
		$shop_npcid = $newArray2['npc_id'];
	
		$sql3 = "SELECT * FROM npc WHERE id = '$shop_npcid' LIMIT 0,1";
		$result3 = mysql_query($sql3, $conn) or die(mysql_error());
		while ($newArray3 = mysql_fetch_array($result3)) {
			$shop_npcname = $newArray3['name'];

	if ($i %2){
			$linebg = 'line1';
		}else{
			$linebg = 'line2';
		}
		echo "<tr class=\"$linebg\">";
		if($accesslevel >= 100){
			echo "<td class=\"id\">$shop_id</td>";
		}
		echo "<td class=\"name\">$shop_npcname</td>";
		echo "<td class=\"price\">$shop_price</td>";
		echo "</tr>";
		$i ++;	
	}
	}
	
}
echo "</table>";
dbclose();

include('footer.inc.php');
?>