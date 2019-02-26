<?php  
	//masih prototipe
	include 'pesan_error.php';
	// login required
	require "admin_permission.php"; 
	//init databse
	include 'koneksi.php';
	if (isset($_POST['done'])){
		//update transaksi
		$statement = $dbc->prepare("UPDATE `transfer` SET `NOREK_ASAL`=:dari,`NOREK_TUJUAN`=:ke,`NOMINAL`=:jumlah  WHERE `ID_TRANSFER`=:no");
		$statement->bindValue(":dari", $_POST['dari']);
		$statement->bindValue(":ke", $_POST['ke']);
		$statement->bindValue(":jumlah", $_POST['jumlah']);
		$statement->bindValue(":no", $_GET['transaksi']);
		$statement->execute();
		
		header("Location: ./list_trans.php");
	}
	$statement = $dbc->prepare("SELECT NOREK_ASAL, NOREK_TUJUAN, NOMINAL FROM transfer WHERE transfer.ID_TRANSFER=:no");
	$statement->bindValue(":no", $_GET['transaksi']);
	$statement->execute();
	$tmp = $statement->fetchAll();
	$tmp = $tmp[0];
	?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - Edit Transaksi
		</title>
		<link rel=stylesheet href="../style.css" type="text/css">
	</head>
	<body>
		<div class="header">
			<ul>
				<li><a href='../bank.php' style="padding:0"><img alt="logo" src="../gambar/logo_.png" style="padding:10px; padding-left:20px; width:200px;"></a></li>
				<li style='float:right;'><a href='../logout.php' style="padding:0"><img alt="logo" src="../gambar/logout.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<li style='float:right;'><a href='../aboutus.php' style="padding:0"><img alt="logo" src="../gambar/aboutus.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<li style='float:right;'><a href='../' style="padding:0"><img alt="logo" src="../gambar/home.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
			</ul>
		</div>

		<div class="container">
			<div class="sidebox">
				<div class="box">
					<h2>Admin</h2>
				</div>
				<div class="box">
					<ul>
						<li><a href="./list_cust.php">Customer</a></li>
						<li class='active'><a href="./list_trans.php">Transaksi</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<h1>My profil</h1>
					<form action="edit_trans.php" method="POST">
						<?php
							$parameter = array("dari", "ke", "jumlah");
							for ($i=0; $i<3; $i++){
						echo "<div class='field'>
								<div class='left'>";
								echo "<label>{$parameter[$i]}</label>";
							echo "</div>
							<div class='right'>
								<input type='text' name='{$parameter[$i]}' value='{$tmp[$i]}'/>
							</div>
						</div>";
							}
						?>
						<div class='field'>
							<div class='left' style='float:right; width:100px;' >
								<input class='button' type='submit' name='done' value='done'/>
							</div>
							<div class='right'>
								&nbsp;
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
		<?php include 'footer.php'?>