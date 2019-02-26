<?php 
	session_start();
	if (!isset($_SESSION['isCustomer'])){ //isAdmin is just a sample
		//if not authorized then redirect to login page
		header("Location: ../");
		exit();
	}
?>