<?php  
	// login required
	require "login_permission.php";
	//init awal
	$errors = array();
	include 'koneksi.php'; include 'function.php';
	//action tombol
	if (isset($_POST['editPass'])){
		header("Location: ./editPass.php");
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Profil
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
					<h2 style='text-align:center'>Customer</h2>
					<h4 style='text-align:center'><?php echo $_SESSION['nama']?></h4>
				</div>
				<div class="box">
					<ul>
						<!--li><a href="./index.php">Home</a></li-->
						<li><a href="./cekRekening.php">Cek Rekening</a></li>
						<li><a href="./browse.php">Cek Transaksi</a></li>
						<li><a href="./transaksi.php">Transfer</a></li>
						<li class="active"><a href="./profil.php">Profil</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<h1>My profil</h1>
					<form action="./profil.php" method="POST" style='padding-left:35%'>
						<?php 
						//select semua data di tabel database
						$statement = $dbc->prepare("SELECT * FROM `customer` WHERE customer.USERNAME=:user");
						$statement->bindValue(":user", $_SESSION['isCustomer']);
						$statement->execute();
						$tmp = $statement->fetchAll();
						$tmp = $tmp[0];
						
						//echo username
						echo "<div class='field'>
							<div class='left'>
								<label>Username</label>
							</div>
							<div class='right'>
								<label>{$tmp[0]}</label>
							</div>
						</div>";
						
						//echo semua isinya (karena password ngga perlu di echo :))
						$parameter = array('Username', 'password', 'Nama_Lengkap', 'Jenis_Kelamin', 'alamat', 'No_Telpon', 'Email');
						for ($i=2; $i<7; $i++){
							echo "<div class='field'>
								<div class='left'>
									<label>{$parameter[$i]}</label>
								</div>
								<div class='right'>
									<label>{$tmp[$i]}</label>
								</div>
							</div>";
						}
						?>
						<div class='field'>
							<div class='left' style='float:right; width:230px;' >
								<input class='button' type='submit' name='editPass' value='edit Password'/>
							</div>
							<div class='right'>
								&nbsp;
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include './footer.php'?>