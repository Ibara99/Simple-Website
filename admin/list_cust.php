<?php  
	// login required
	require "admin_permission.php";
	//init database
	include 'koneksi.php';include 'function.php';
	//action tombol
	if (isset($_GET['addRek'])){
		header("Location: ./add_rek.php");
		exit();
	}
	else if (isset($_GET['addCust'])){
		header("Location: ./add_cust.php");
		exit();
	}
	else if (isset($_GET['edit'])){
		header("Location: ./edit_cust.php");
		exit();
	}
	else if (isset($_GET['del'])){
		//hapus di tabel transaksi
		$statement = $dbc->prepare("DELETE FROM `transaksi` WHERE NO_REKENING_PENGIRIM=:rek OR NO_REKENING_TUJUAN=:rek");
		$statement->bindValue(":rek", $_GET['del']);
		$statement->execute();
		
		//get username untuk dilakukan pengecekan norek
		$statement = $dbc->prepare("SELECT USERNAME FROM `rekening` WHERE NO_REKENING=:rek");
		$statement->bindValue(":rek", $_GET['del']);
		$statement->execute();
		$data = $statement->fetchAll();
		$username = $data[0][0];
		
		//hapus di tabel rekening
		$statement = $dbc->prepare("DELETE FROM `rekening` WHERE NO_REKENING=:rek");
		$statement->bindValue(":rek", $_GET['del']);
		$statement->execute();
		
		//cek sisa norek
		$statement = $dbc->prepare("SELECT NO_REKENING FROM `rekening` WHERE USERNAME=:user");
		$statement->bindValue(":user", $username);
		$statement->execute();
		$data = $statement->fetchAll();
		//jika username tidak punya norek, hapus di tabel customer
		if (count($data) == 0 ){
			$statement = $dbc->prepare("DELETE FROM `customer` WHERE USERNAME=:user");
			$statement->bindValue(":user", $username);
			$statement->execute();
		}
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - List Customer
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
						<li class='active'><a href="./list_cust.php">Customer</a></li>
						<li><a href="./list_trans.php">Transaksi</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<h1>List Customer</h1>
					<form action="./list_cust.php"  method="GET">
					<?php
						//select semua customer
						$statement = $dbc->prepare("SELECT rekening.NO_REKENING, customer.USERNAME, rekening.SALDO FROM `rekening` INNER JOIN customer on customer.USERNAME=rekening.USERNAME ");
						$statement->execute();
						$tmp = $statement->fetchAll();
						
						//init tabel
						echo '<table class="tabel" style="margin:auto;">';
						echo '<tr><td>NO_REKENING</td><td>USERNAME</td><td>Saldo</td><td colspan="2">Menu</td></tr>';
						
						//echo isinya, jika kosong:
						if (count($tmp)==0)
							echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
						//jika ada:
						foreach($tmp as $row){
							echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>".rupiah($row[2])."</td><td><a class='button' href='./edit_customer.php?user={$row[1]}'>edit</a> </td><td><a class='button' href='?del={$row[0]}' onclick=\"return  confirm('do you want to delete Y/N')\">delete</a></td></tr>";
						}
						echo "</table>";
					?>
						<div class='field' style="padding-left:36.5%">
							<input class='button' type='submit' name='addRek' value='add Rekening' />
							<input class='button' type='submit' name='addCust' value='add Customer'/>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include 'footer.php'?>