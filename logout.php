<?php 
	session_start();
	//if not authorized then redirect to login page
	unset($_SESSION["isAdmin"]);
	unset($_SESSION["isCustomer"]);
	header("Location: ./");
	exit();
?>