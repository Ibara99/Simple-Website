<?php
	$servername = 'localhost';
	$dbname = 'banking';
	$user = 'root';
	$pass = '';
	$dbc = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
?>