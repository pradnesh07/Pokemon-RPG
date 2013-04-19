<?php 
	include('top_header.php');
?>
<?php
	$profid = $_GET['id'];
	$failure = mysql_num_rows(mysql_query("SELECT * FROM users WHERE id = $profid"));
	if($failure == 1) {
		$javascript = "function getBox() {
			box = openPage('AJAX/get_box.php', 'user=".$_GET['id']."')
			customAlert(box, 'Hey')
		}";
		echo("<div class=special_content>");
		echo("<table align=center width='100%'>");
		$user_id = mysql_real_escape_string($_GET['id']);
		$user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = $user_id"));
		$slots = array();
		for($i = 1; $i <= 6; $i++) {
			$query = mysql_query("SELECT * FROM pokemon WHERE owner_id = $user_id AND slot = $i");
			$slots[$i] = mysql_fetch_assoc($query);
			if($slots[$i]) {
				$type = mysql_fetch_assoc(mysql_query("SELECT name FROM types WHERE id = ".$slots[$i]['type']));
				$slots[$i]["type"] = $type["name"];
				$name = mysql_fetch_assoc(mysql_query("SELECT name FROM pokedex WHERE id = ".$slots[$i]["pokedex_id"]));
				$slots[$i]["name"] = $name["name"];
			} else {
				$slots[$i] = "Empty";
			}
		}
		echo("<tr>");
		echo("<td class='header'>Viewing profile of: ".parse($user["Username"])."");
		echo("</td>");
		echo("</tr>");
		echo("</table>");
		echo("<table align=center width='100%'>");
		echo("<tr>");
		echo("<td class='header'>Avatar</a>");
		echo("<td class='header' width='100%'>Member info:</td>");
		echo("</tr>");
		echo("<div align='left'>");
		echo("<tr>");
		echo("<td class='into'>");
		echo("<img src=".(stripslashes(htmlentities($user['avatar'])))."/>");
		echo("</td>");
		echo("<td>");
		echo("Member Title: ".($user["title"])."<br />");
		echo("Money: ".($user["Money"])."<br />");
		echo("Explorations: ".($user["clicks"])."");
		echo("</td>");
		echo("</tr>");
		echo("</div>");
		echo("</table>");
		echo("<table align=center width='100%'>");
		echo("<tr>");
		echo("<td class='header'>Signature:</td>");
		echo("</tr>");
		echo("<tr>");
		echo("<td class='into'>");
		echo(stripslashes(parse($c['signature'])));
		echo("</td>");
		echo("</tr>");
		echo("</table>");
		echo("<table align=center width='100%'>");
		echo("<tr>");
		echo("<td class='header' width='33%'>Slot 1</td>");
		echo("<td class='header' width='33%'>Slot 2</td>");
		echo("<td class='header' width='33%'>Slot 3</td>");
		echo("</tr>");
		echo("<tr>");
		for($i = 1; $i <= 3; $i++) {
			if($slots[$i] != "Empty") {
				echo("<td class='into'>");
				echo($slots[$i]["nickname"]);
				echo("<br />");
				echo("<img src='images/sprites/".($slots[$i]["type"])."/".($slots[$i]["name"]).".png'/><br />");
				echo("[Level: ".$slots[$i]["level"]. "]");
				echo("</td>");
			} else {
				echo("<td class='into'>");
				echo("Empty Pok&#233;ball<br />");
				echo("<img src='images/pokeball.png' height='96' width='96'/><br />");
				echo("[Level: - ]");
				echo("</td>");
			}
		}
		echo("</tr>");
		echo("<tr>");
		echo("<td class='header' width='33%'>Slot 4</td>");
		echo("<td class='header' width='33%'>Slot 5</td>");
		echo("<td class='header' width='33%'>Slot 6</td>");
		echo("</tr>");
		for($i = 4; $i <= 6; $i++) {
			if($slots[$i] != "Empty") {
				echo("<td class='into'>");
				echo($slots[$i]["nickname"]);
				echo("<br />");
				echo("<img src='images/sprites/".($slots[$i]["type"])."/".($slots[$i]["name"]).".png'/><br />");
				echo("[Level:".$slots[$i]["level"]."]");
				echo("</td>");
			} else {
				echo("<td class='into'>");
				echo("Empty Pok&#233;ball<br />");
				echo("<img src='images/pokeball.png' height='96' width='96'/><br />");
				echo("[Level: - ]");
				echo("</td>");
			}
		}
		echo("</tr>");
		echo("</table>");
		echo("<table align=center width='100%'>");
		echo("<tr>");
		echo("<td class='header' colspan=4>Boxed Pok&#233;mon</td>");
//		echo("</tr>");
//		echo("<tr>");
		$get = "SELECT * FROM pokemon WHERE owner_id = {$_GET['id']} AND slot = '7'";
		$done = mysql_query($get);
		while($row = mysql_fetch_array($done)) {
			$poke_id = $row["pokedex_id"];
			if($row["pokedex_id"] < 100) $poke_id = "0".$poke_id;
			if($row["pokedex_id"] < 10) $poke_id = "0".$poke_id;
			echo("</tr>");
			echo("<tr>");
			echo("<td class='into'>");
			echo($row['pokemon_id']);
			echo("</td>");
			echo("<td class='into'>");
			echo("<img src='images/icons/".$poke_id.".gif' />");
			echo("</td>");
			echo("<td class='into'>");
			echo($row['nickname']);
			echo("</td>");
			echo("<td class='into'>");
			echo($row['level']);
			echo("</td>");
			echo("</tr>");
		}
		echo("</tr>");
		echo("</table>");
		echo("</div>");
		echo("</td>");
	} else {
		header("location: news.php");
	}
?>
<?php
	include('bottom_layout.php');
?>