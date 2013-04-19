<!doctype html>
<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	session_start();
	require("db.php");
	if(isset($_SESSION["user"])) {
		header("location: news.php");
	} else {
		if(isset($_COOKIE["save_user"])) {
			$query = mysql_query("SELECT username FROM users WHERE username = '".mysql_real_escape_string($_COOKIE["save_user"])."'");
			if($query != False) {
				$_SESSION["user"] = $_COOKIE["save_user"];
				header("location: news.php");
			}
		}
	}
?>
<html>
	<head>
		<title>Your RPG Name</title>
		<link href="index.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="banner"></div>
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
			<ul>
				<li class="top">Login</li>
				<li>
					<?php
						include ('db.php'); 
						if (isset($_POST['action'])) {
							if ($_POST['action'] == "Login") {
								if(!$_POST['username'] | !$_POST['password']) {
									die('You did not fill in a required field.');
								} else {
									$_POST['username'] = mysql_real_escape_string($_POST['username']);
									$_POST['password'] = mysql_real_escape_string($_POST['password']);
									$getuser = mysql_query("SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysql_error());
									$checkuser = mysql_num_rows($getuser);
									$getiplog = mysql_query("SELECT * FROM `logins` WHERE `ip` = '".$_SERVER["REMOTE_ADDR"]."' AND `success` = 'No'")or die(mysql_error());
									$checkip = mysql_num_rows($getiplog);
									if ($checkuser == 0) {
										die('That user does not exist in our database. <a href=register.php>Click Here to Register</a>');
									} elseif ($checkip >= 10) {
										die('This IP has too many failed login attempts, please contact an administrator to get your IP unblocked');
									} else {
										$info = mysql_fetch_array($getuser); 
										if (sha1(md5($_POST['password'])) != $info['password']) {
											$login = "INSERT INTO logins (account, ip, success) VALUES ('".$_POST['username']."', '".$_SERVER["REMOTE_ADDR"]."', 'No')";
											$add_login = mysql_query($login);
											echo("<br />");											echo('Incorrect password, please try again.');
											echo("<br />");
											goto login;										} else { 
											$month = time() + 3600*24*30; 											$_SESSION['user'] = $_POST['username'];											setcookie("save_user", htmlentities($_POST['username']), $month); 											$login = "INSERT INTO logins (account, ip, success) VALUES ('".mysql_real_escape_string($_POST['username'])."', '".$_SERVER["REMOTE_ADDR"]."', 'Yes')";
											$add_login = mysql_query($login);
											header("location: news.php");
										}									}								}							} elseif($_POST['action'] == "Logout") {
								setcookie("usrid", "", time()+3600);
							}
						} else {
							echo("<p style='text-align:center'>");
							echo("\n\t\t\t\t\t\t"); //New Line and Tabs for clean formatting!
							echo("Please Login To Continue!");
							login:
							echo("\n\t\t\t\t\t");
							echo("</p>");
							echo("\n\t\t\t\t\t");
							echo("<form action='login.php' method='POST'>");
							echo("\n\t\t\t\t\t\t");
							echo("<input type=hidden name=action value='Login'>");
							echo("\n\t\t\t\t\t\t");
							echo("<table align='center'>");
							echo("\n\t\t\t\t\t\t\t");
							echo("<tr>");
							echo("\n\t\t\t\t\t\t\t\t");
							echo("<td>Username:</td>");
							echo("\n\t\t\t\t\t\t\t\t");
							echo("<td>");
							echo("\n\t\t\t\t\t\t\t\t\t");
							echo("<input type='text' name='username'>");
							echo("\n\t\t\t\t\t\t\t\t");
							echo("</td>");
							echo("\n\t\t\t\t\t\t\t");
							echo("</tr>");
							echo("\n\t\t\t\t\t\t\t");
							echo("<tr>");
							echo("\n\t\t\t\t\t\t\t\t");
							echo("<td>Password:</td>");
							echo("\n\t\t\t\t\t\t\t\t");
							echo("<td>");
							echo("\n\t\t\t\t\t\t\t\t\t");
							echo("<input type='password' name='password'>");
							echo("\n\t\t\t\t\t\t\t\t");
							echo("</td>");
							echo("\n\t\t\t\t\t\t\t");
							echo("</tr>");
							echo("\n\t\t\t\t\t\t");
							echo("</table>");
							echo("\n\t\t\t\t\t\t");
							echo("<br />");
							echo("\n\t\t\t\t\t\t");
							echo("<input type='submit' value='Login'>");
							echo("\n\t\t\t\t\t\t");
							echo("<input type='button' onclick=window.location='register.php' target='main' value='Register'>");
							echo("\n\t\t\t\t\t");
							echo("</form>");
							echo("\n");
						}
					?>
					<br />
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