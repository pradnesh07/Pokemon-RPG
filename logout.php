<?php 
	session_start();
	$past = time() - 100; 
	setcookie(save_user, gone, $past); 
	session_destroy();
	header("Location: index.php"); 
?>