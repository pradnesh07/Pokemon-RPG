<?php
	ini_set('display_errors',0); 
	error_reporting(E_NONE);
	date_default_timezone_set("America/New_York");
	session_start();
	require("db.php");
	require("function.php");
	if(isset($_SESSION["user"])) {
		$user = mysql_real_escape_string($_SESSION["user"]);
		setcookie("save_user", mysql_real_escape_string($_COOKIE['save_user']), time()+30*24*3600); 
		if(!isset($_SESSION["user_info"])) {
			$_SESSION["user_info"] = mysql_fetch_assoc(mysql_query("SELECT id, rank FROM users WHERE username = '$user'"));
		}
		($_SESSION["rank"] == 3 ? header("location: /banned.php") : Null);
		(mysql_fetch_assoc(mysql_query("SELECT * FROM banned WHERE user_ip = '".$_SERVER["REMOTE_ADDR"]."' OR user_id = ".$id." OR user_name = '".$user."'")) != Null ? header("location: banned.php") : Null);
		$id = $_SESSION["user_info"]["id"];
		$rank = sha1(md5($_SESSION["user_info"]["rank"]));
		if(basename($_SERVER["PHP_SELF"], ".php") != "inbox") {
			$messages_query = mysql_query("SELECT * FROM private_messages WHERE receiver_id = $id AND `read` = 0 AND `alert` = 1");
				$number_of_messages = mysql_num_rows($messages_query);
				($number_of_messages >= 1 ? $new_message = true : $new_messages = false);
				$message_info = mysql_fetch_assoc(mysql_query("SELECT id FROM private_messages WHERE receiver_id = $id AND `read` = 0 AND `alert` = 1 LIMIT 1"));
		}
		if(basename($_SERVER["PHP_SELF"], ".php") != "_beta" && isset($_SESSION["battle_info"])) {
			unset($_SESSION["battle_info"]);
		}
	} elseif(isset($_COOKIE["save_user"])) {
		$_COOKIE["save_user"] = mysql_real_escape_string($_COOKIE["save_user"]);
		$query = mysql_query("SELECT username FROM users WHERE username = '".$_COOKIE["save_user"]."'");
		if(mysql_num_rows($query) == 1) {
			$_SESSION["user"] = $_COOKIE["save_user"];
			$user = $_SESSION["user"];
			if(!isset($_SESSION["user_info"])) {
				$_SESSION["user_info"] = mysql_fetch_assoc(mysql_query("SELECT id, rank FROM users password WHERE username = '$user'"));
			}
			$id = $_SESSION["user_info"]["id"];
			$rank = sha1(md5($_SESSION["user_info"]["rank"]));
		} else {
			header("location: login.php");
		}
	} else {
		header("location: login.php");
	}
	$rawr = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id = $id"));
	$money = $rawr['Money'];
	if($money <= 0) {
		$upit = mysql_query("UPDATE users SET money = 0 WHERE id = $id");
	}
?>