<?php
	mysql_connect("mysql-subdomain.provider.tld", "mysql_username", "mysql_password") or die(mysql_error()); 
	mysql_select_db("mysql_database") or die(mysql_error()); 
?>