<!doctype html>
<html>
	<head>
		<title>Your RPG Name</title>
		<link href="index.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="banner" />
		<div class="leftmenu">
			<ul>
				<li class="header">Navigation</li>
				<a href="index.php">
					<li>Home</li>
				</a>
				<a href="login.php">
					<li>Login</li>
				</a>
				<a href="register.php">
					<li>Register</li>
				</a>
				<a href="about.php">
					<li>About</li>
				</a>
			</ul>
		</div>
		<div class="rightmenu">
			<ul>
				<li class="header">Navigation</li>
				<a href="index.php">
					<li>Home</li>
				</a>
				<a href="login.php">
					<li>Login</li>
				</a>
				<a href="register.php">
					<li>Register</li>
				</a>
				<a href="about.php">
					<li>About</li>
				</a>
			</ul>
		</div>
		<div class="content">
			<script type="text/javascript">
				function swapStarter() {
					var image = document.getElementById("starterSwap");
					var dropd = document.getElementById("starter");
					image.src = 'images/sprites/normal/'+dropd.value+'.png';
				} ;
					function swapAvatar() {
					var image = document.getElementById("avatarSwap");
					var dropd = document.getElementById("avatar");
					image.src = 'images/avatar/'+dropd.value+'.png';
				} ;
			</script>
			<ul>
				<li class="top">..::Registration::..</li>
				<li>
					<p style='text-align:center'>
						<?php
							include ('db.php'); 
							if (isset($_POST['username'])) {	//This code runs if the form has been submitted
								$_POST['pass'] = mysql_real_escape_string($_POST['pass']);	//Preventing Injections
								$_POST['cpass'] = mysql_real_escape_string($_POST['cpass']);	//Preventing Injections
								$_POST['email'] = mysql_real_escape_string($_POST['email']);	//Preventing Injections
								$_POST['starter'] = mysql_real_escape_string($_POST['starter']);	//Preventing Injections
								$_POST['username'] = mysql_real_escape_string($_POST['username']);	//Preventing Injections
								$valid = array("Bulbasaur", "Charmander", "Squirtle", "Chikorita", "Cyndaquil", "Totodile", "Treecko", "Torchic", "Mudkip", "Turtwig", "Chimchar", "Piplup", "Snivy", "Tepig", "Oshawott");
								if (!in_array($_POST['starter'], $valid)) {
									die("Sorry, '".$_POST['starter']."' is not a valid starter!");
									$_POST['starter'] = "Bulbasaur";
								}
								if (!$_POST['username'] | !$_POST['pass'] | !$_POST['cpass'] | !$_POST['email']) {	//This makes sure they did not leave any fields blank
									die('You did not complete all of the required fields'); 
								} else {
									$usercheck = $_POST['username']; 
									$check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'")  
										or die(mysql_error()); 
									$check2 = mysql_num_rows($check); 
									if ($check2 != 0) {	//if the name exists it gives an error
										die('Sorry, the username '.$_POST['username'].' is already in use.');
									} elseif(mysql_num_rows(mysql_query("SELECT id FROM users WHERE IP = '".$_SERVER["REMOTE_ADDR"]."'")) != 0) { 
										die("Sorry, but there's already an account registered under this IP. If you wish to reclaim this account or delete it, please contact one our administrators.");
									} elseif ($_POST['pass'] != $_POST['cpass']) {	// this makes sure both passwords entered match 
										die('Your passwords did not match.'); 
									} else {
										$_POST['pass'] = sha1(md5($_POST['pass'])); 
										$insert = "INSERT INTO users (Username, Password, IP, Email, Money, Coins, Rank) VALUES ('".$_POST['username']."', '".$_POST['pass']."', '".$_SERVER['REMOTE_ADDR']."', '".$_POST['email']."', '20000', '1000', '1')"; 
										$add_member = mysql_query($insert); 
										$now = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE username = '".$_POST['username']."'"));
										$insert2 = "INSERT INTO pokemon (owner_id, nickname, slot, type, level, experience) VALUES ('".$now['id']."', '".$_POST['starter']."', '1', '1', '5', '125')";
										$add_pokemon = mysql_query($insert2);
										$now2 = mysql_fetch_array(mysql_query("SELECT pokemon_id FROM pokemon WHERE owner_id = '".$now['id']."'"));
										$update = "UPDATE users SET Poke1 = '".$now2['pokemon_id']."' WHERE id = '".$now['id']."'";
										$add_user_poke = mysql_query($update);
										echo "You have successfully signed up";
										sleep(5);
										$month = time() + 3600*24*30; 
										$_SESSION['user'] = $_POST['username'];
										setcookie("save_user", $_POST['username'], $month); 
										$login = "INSERT INTO logins (account, ip, success) VALUES ('"$_POST['username']."', '".$_SERVER["REMOTE_ADDR"]."', 'Yes')";
										$add_login = mysql_query($login);
										header("location: news.php");
									}
								}
							} else {
								echo("\n");
							}
						?>
						<table align='center'>
							<tr>
								<td>Start your journey!</td>
							</tr>
						</table>
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'> 
							<table align='center'>
								<tr>
									<td>Username:</td>
									<td>
										<input type='text' name='username' value="" maxlength='15'>
									</td>
								</tr>
								<tr>
									<td>Email:</td>
										<td>
											<input type='test' name='email' maxlength='50'>
										</td>
								</tr>
								<tr>
									<td>Password:</td>
									<td>
										<input type='password' name='pass' maxlength='15'>
									</td>
								</tr>
								<tr>
									<td>Confirm Password:</td>
									<td>
										<input type='password' name='cpass' maxlength='15'>
									</td>
								</tr>
								<tr>
									<td>Starter:</td>
									<td>
										<select name="starter" id="starter" onChange="swapStarter()">
											<optgroup label="Generation 1">
												<option value="Bulbasaur">Bulbasaur</option>
												<option value="Charmander">Charmander</option>
												<option value="Squirtle">Squirtle</option>
											<optgroup label="Generation 2">
												<option value="Chikorita">Chikorita</option>
												<option value="Cyndaquil">Cyndaquil</option>
												<option value="Totodile">Totodile</option>
											<optgroup label="Generation 3">
												<option value="Treecko">Treecko</option>
												<option value="Torchic">Torchic</option>
												<option value="Mudkip">Mudkip</option>
											<optgroup label="Generation 4">
												<option value="Turtwig">Turtwig</option>
												<option value="Chimchar">Chimchar</option>
												<option value="Piplup">Piplup</option>
											<optgroup label="Generation 5">
												<option value="Snivy">Snivy</option>
												<option value="Tepig">Tepig</option>
												<option value="Oshawott">Oshawott</option>
										</select>
										<br />
										<img id="starterSwap" src="images/sprites/normal/Bulbasaur.png">
									</td>
								</tr>
							</table>
							<br />
							<input type=submit value=Register>
						</form>
						<br />
					</p>
				</li>
				<li class="footer" style="border-bottom:none;">..::Copyright::..</li>
				<li class="footer_cr">
					<br />
					= Legal Copyright If Any Here =<br />
					= This site is not affiliated with Nintendo, The Pok&#233mon Company, Creatures, or GameFreak. =<br />
					<br />
				</li>
			</ul>
		</div>
	</body>
</html>