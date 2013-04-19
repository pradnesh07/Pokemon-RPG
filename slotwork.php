<?php
	include('userinfo.php');
	$img[1] = '<img src="/images/slots/Charizard.png">';
	$img[2] = '<img src="/images/slots/Venusaur.png">';
	$img[3] = '<img src="/images/slots/Blastoise.png">';
	$ran1 = rand(1,3);
	$ran2 = rand(1,3);
	$ran3 = rand(1,3);
	if($ran1 == $ran2 && $ran1 == $ran3) {
		$cost = rand(1,20);
		$no = mysql_query("UPDATE users SET MGP = MGP + $cost WHERE id = $id");
		echo "<table align=center><tr><td>";
		echo $img[$ran1];
		echo "</td><td>";
		echo $img[$ran2];
		echo "</td><td>";
		echo $img[$ran3];
		echo "</td></tr></table>";
		echo "You Have Won, you gained $cost minigame point(s)!";
	} else {
		echo "<table align=center><tr><td>";
		echo $img[$ran1];
		echo "</td><td>";
		echo $img[$ran2];
		echo "</td><td>";
		echo $img[$ran3];
		echo "</td></tr></table>";
		echo "You Have Lost";
	}
?>