<?php 
	// login admin required
	require "admin_permission.php"; 
	//init database dan import semua function
	include 'koneksi.php';
	include 'function.php';
	// init tampung error
	$errors = array();
	
	//tombol cancel kembali ke list customer
	if (isset($_POST['cancel'])){
		header("Location: ./list_cust.php");
		exit();
	}
	// jika tombol done ditekan :
	else if (isset($_POST['done'])){
		// validasi form
		validateLenRek($errors, $_POST, 'rek');
		validateNum($errors, $_POST, 'rek');
		validateNum($errors, $_POST, 'saldo');
		validateKosong($errors, $_POST, 'rek');
		validateKosong($errors, $_POST, 'saldo');
		if (empty($errors)){ //jika tidak eror:
			// Add data form ke dalam database, tabel rekening
			$statement = $dbc->prepare("INSERT INTO `rekening` VALUES (:rek, :user, :saldo)");
			$statement->bindValue(":rek", $_POST['rek']);
			$statement->bindValue(":user", $_POST['user']);
			$statement->bindValue(":saldo", $_POST['saldo']);
			$statement->execute();
			
			//kembali ke list customer
			header("Location: ./list_cust.php");
		}
	}
	?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - Add Rekening
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
					<h2 style='text-align:center;'>Admin</h2>
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
					<h1>My profil</h1>
					<form action="./add_rek.php" method="POST">
						<div class='field'>
							<div class='left'>
								<label>Username</label>
							</div>
							<div class='right'>
								<select name="user" id="user" style='width:70%'>
								<?php						
								$statement = $dbc->prepare("SELECT * FROM customer");
								$statement->execute();
								foreach ($statement as $row){
									echo "<option value=".$row['USERNAME'].">".$row['USERNAME']."</option>";
								}
								?>
								</select>
							</div>
						</div>
						<div class='field'>
							<div class='left'>
								<label>Nomor Rekening</label>
							</div>
							<div class='right'>
								<input type='text' name='rek' value='<?php if (isset($_POST['rek'])) echo htmlspecialchars($_POST['rek'])?>'  placeholder='rekening memiliki panjang 10 digit numerik'/>
							</div>
						</div>
						<?php if (isset($errors['rek'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['rek'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Saldo</label>
							</div>
							<div class='right'>
								<input type='text' name='saldo' value='<?php if (isset($_POST['saldo'])) echo htmlspecialchars($_POST['saldo'])?>'  placeholder='saldo awal rekening'/>
							</div>
						</div>
						<?php if (isset($errors['saldo'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['saldo'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left' style='float:right; width:220px;' >
								<input class='button' type='submit' name='done' value='done'/>
								<input class='button' type='submit' name='cancel' value='cancel' onclick='return  confirm("Batal add rekening baru? Y/N")'/>
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