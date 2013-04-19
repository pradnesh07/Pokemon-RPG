<?php
	include('userinfo.php');
?>
<html>
	<head>
		<title>Your RPG Name</title>
		<link rel="stylesheet" type="text/css" href="loggedin.css" />
	</head>
	<script type="text/javascript" src="ajax.js" />
	<script type="text/javascript">
		alertObject = null
		function customAlert(message, type) {
			if(alertObject != null) {
				closeAlert()
			}
			alertObject = document.createElement('div');
			alertObject.setAttribute('class', 'alert');
			alertTitle = document.createElement('div');
			alertTitle.setAttribute('class', 'alert_title');
			alertTitle.appendChild(document.createTextNode(type));
			alertExit = document.createElement('button');
			alertExit.setAttribute('onClick', 'closeAlert()');
			alertExit.appendChild(document.createTextNode('Exit'));
			alertObject.appendChild(alertTitle);
			alertObject.innerHTML += message;
			alertObject.appendChild(document.createElement('br'));
			alertObject.appendChild(alertExit);
			document.body.appendChild(alertObject);
			alertExit.focus();
		}
		function closeAlert() {
			document.body.removeChild(alertObject);
			alertObject = null;
		}
		function ignoreMessage(id) {
			closeAlert();
			openPage('AJAX/ignore_message.php','id='+id, true);
		}
		<?php
			echo (isset($javascript) ? str_replace("[PHP_SET_USER_ID]", $id, $javascript)."\n" : null);
			echo("\n");
		?>
	</script>
	<body>
		<ul>
			<li class="header">
				<?php
					echo (isset($new_message) ? " onLoad=\"customAlert('You have a new private message.<br /><a href=\'inbox.php\'>Inbox.</a><br /><a onClick=\'ignoreMessage({$message_info["id"]})\'>Ignore</a>', 'New Private Message!')\"" : Null );
					echo (isset($unload) ? " onUnload=\"$unload\"" : Null);
					echo("\n");
				?>
			</li>
				<table align=center cellspacing="0" width="100%">
					<?php
						for($i = 1; $i <= 6; $i++) {
							$find = mysql_query("SELECT * FROM pokemon WHERE owner_id = $id AND slot = $i");
							$row = mysql_fetch_assoc($find);
							echo("<td class='pokedisplay'>");
							echo("\n\t\t\t\t\t\t"); //New Line and Tabs for clean formatting!
							echo("<b>Slot ".($i)."</b><br />");
							echo("\n\t\t\t\t\t\t");
							if($row != false) {
								($row["pokedex_id"] < 10 ? $row["pokedex_id"] = "00".$row["pokedex_id"] : ($row["pokedex_id"] < 100 && $row["pokedex_id"] > 9 ? $row["pokedex_id"] = "0".$row["pokedex_id"] : Null));
								echo((parse($row["nickname"]))." - Level ".(parse($row["level"]))."<br /><img class='box_ico' src='images/icons/".(parse($row["pokedex_id"])).".gif' height='32' width='32'/>");
								echo("\n\t\t\t\t\t");
								echo("</td>");
								echo("\n\t\t\t\t\t");
							} elseif($row == false) {
								echo("Empty Pok&#233ball<br />");
								echo("\n\t\t\t\t\t\t");
								echo("<img src='images/icons/pokeball.gif' height='32' width='32'/>");
								echo("\n\t\t\t\t\t");
								echo("</td>");
								echo("\n\t\t\t\t\t");
							}
						}
						echo("\n");
					?>
				</table>
			</li>
		</ul>
		<div class="leftmenu">
			<ul>
				<li class="header">
					<b>&#9668Promo&#9658</b>
				</li>
				<?php
					$get = "SELECT * FROM promos ORDER BY promo_id DESC";
					$row = mysql_fetch_array(mysql_query($get));
					$name = $row["name"];
					$type = $row["type_name"];
					$type_id = $row["type_id"];
					($type == "Normal" ? $type = "" : Null);
					echo("<a href='promo.php'>");
					echo("\n\t\t\t\t\t");
					echo("<img src='images/sprites/".($type)."/".($name).".png' />");
					echo("\n\t\t\t\t");
					echo("</a>");
					echo("\n\t\t\t\t");
					echo("<a href='promo.php'>");
					echo("\n\t\t\t\t\t");
					echo("<li>Get Promo</li>");
					echo("\n\t\t\t\t");
					echo("</a>");
					echo("\n\t\t\t");
					echo("</ul>");
					echo("\n\t\t\t");
					echo("<ul>");
					echo("\n\t\t\t\t");
					echo("<li class='noborders'>");
					echo("\n\t\t\t\t\t");
					echo("<br />");
					echo("\n\t\t\t\t");
					echo("</li>");
					echo("\n\t\t\t");
					echo("</ul>");
					echo("\n\t\t\t");
					echo("<ul>");
					echo("\n\t\t\t\t");
					echo("<li class='header'>");
					echo("\n\t\t\t\t\t");
					echo("<b>&#9668General Options&#9658</b>");
					echo("\n\t\t\t\t");
					echo("</li>");
					echo("\n\t\t\t\t");
					echo("<a href='view_profile.php?id=".($id)."'>");
					echo("\n\t\t\t\t\t");
					echo("<li>Your Account</li>");
					echo("\n\t\t\t\t");
					echo("</a>");
					echo("\n");
				?>
				<a href="my_stats.php">
					<li>Your Stats</li>
				</a>
				<a href="mod_profile.php">
					<li>Modify Profile</li>
				</a>
				<a href="nickname.php">
					<li>Nickname Pokemon</li>
				</a>
				<a href="my_box.php">
					<li>Change Roster</li>
				</a>
				<a href="news.php">
					<li>News</li>
				</a>
				<a href="rules.php">
					<li>Rules</li>
				</a>
				<a href="staff.php">
					<li>Staff List</li>
				</a>
				<a href="referral.php">
					<li>Referral</li>
				</a>
			</ul>
			<ul>
				<li class="noborders">
					<br />
				</li>
			</ul>
			<ul>
				<li class="header">
					<b>&#9668Pokemon Center&#9658</b>
				</li>
				<a href="sell.php">
					<li>Sell Pokemon</li>
				</a>
				<a href="buypokemon.php">
					<li>Buy Pokemon</li>
				</a>
				<a href="fix_party.php">
					<li>Reset your Roster</li>
				</a>
				<a href="evolve.php">
					<li>Evolve</li>
				</a>
			</ul>
			<ul>
				<li class="noborders">
					<br />
				</li>
			</ul>
			<ul>
				<li class="header">
					<b>&#9668Shops&#9658</b>
				</li>
				<li>
					Under Construction
				</li>
			</ul>
		</div>
		<div class="rightmenu">
			<ul>
				<li class="header">
					<b>&#9668Maps&#9658</b>
				</li>
				<a href="betamap.php">
					<li>Test Map #1</li>
				</a>
			</ul>
			<ul>
				<li class="noborders">
					<br />
				</li>
			</ul>
			<ul>
				<li class="header">
					<b>&#9668Battle&#9658</b>
				</li>
				<a href="battleapokemon.php">
					<li>Battle a Pokemon</li>
				</a>
			</ul>
			<ul>
				<li class="noborders">
					<br />
				</li>
			</ul>
			<ul>
				<li class="header">
					<b>&#9668Rankings&#9658</b>
				</li>
				<a href="trainer_rank.php">
					<li>Top Trainers</li>
				</a>
				<a href="pokemonranks.php">
					<li>Individual Pokemon</li>
				</a>
				<a href="richnubs.php">
					<li>Richest Trainer List</li>
				</a>
				<a href="minigamepoints.php">
					<li>Mini Game Points</li>
				</a>
				<a href="map_clicks.php">
					<li>Best Explorers</li>
				</a>
				<a href="referral_ranks.php">
					<li>Referral Ranks</li>
				</a>
			</ul>
			<ul>
				<li class="noborders">
					<br />
				</li>
			</ul>
			<ul>
				<li class="header">
					<b>&#9668Misc.&#9658</b>
				</li>
				<a href="logout.php">
					<li>Logout</li>
				</a>
			</ul>
		</div>
		<div class="center_box">
			<ul>
				<li class="header">
					<b>&#9668Your RPG Name&#9658</b>
				</li>
			</ul>
			<ul>
				<li class="body">