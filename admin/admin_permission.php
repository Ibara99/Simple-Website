<?php 
	//memulai session
	session_start();
	//jika bukan admin, di re-direct ke halaman login admin
	if (!isset($_SESSION['isAdmin'])){ //isAdmin is just a sample
		//if not authorized then redirect to login page
		header("Location: ../loginAdmin.php");
		exit();
	}
?>
