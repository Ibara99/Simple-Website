<?php  
	// login admin required
	require "admin_permission.php"; 
	/*Kurang trigger*/
	//init tampung eror
	$errors = array();
	//init koneksi database dan import semua function
	include 'koneksi.php'; include 'function.php';
	// jika tombol kirim ditekan:
	if(isset($_POST['kirim'])){
		//validasi form
		validateNum($errors, $_POST, 'jumlah');
		validateKosong($errors, $_POST, 'jumlah');
		
		if (empty($errors)){ //jika tidak eror:
			// init saldo awal dan nominal transfer
			$saldo = getSaldo($_POST['asal']);
			$transfer = intval($_POST['jumlah']);
			
			// jika saldo mencukupi:
			if ($saldo > $transfer){
				//mengurasi saldo rek pengirim
				$saldo = $saldo - $transfer;
				
				//update saldo rek pengirim
				setSaldo($saldo, $_POST['asal']);
				
				// mencatat transaksi
				$statement = $dbc->prepare("INSERT INTO `transaksi` VALUES (null, :asal, :tujuan, :nominal, null)");
				$statement->bindValue(':asal', $_POST['asal']);
				$statement->bindValue(':tujuan', $_POST['tujuan']);
				$statement->bindValue(':nominal', $_POST['jumlah']);
				$statement->execute();
				
				// init saldo rek penerima dan menambahnya dengan nominal transfer
				$saldo = getSaldo($_POST['tujuan']);
				$saldo = $saldo + $transfer;
				
				// update saldo rek penerima
				setSaldo($saldo, $_POST['tujuan']);
				
				//kembali ke list transaksi
				header ("Location: ./list_trans.php");
				//echo "berhasil";
			}
		}
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - add transaksi
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
					<h1>Add Transaksi</h1>
					<form action="./add_trans.php" method="POST">
						<div class='field'>
							<div class='left'>
								<label for="asal">Rek Pengirim</label>
							</div>
							<div class='right'>
								<select name="asal" id="asal" style='width:70%'>
								<?php 
								//membuat list semua rekening dengan cara select rekening di database
								$statement = $dbc->prepare("SELECT * FROM rekening");
								$statement->execute();
								foreach ($statement as $row){
									echo "<option value=".$row['NO_REKENING'].">".$row['NO_REKENING']."</option>";
								}
								?>
								</select>
							</div>
						</div>
						<div class='field'>
							<div class='left'>
								<label for="tujuan">Rek Tujuan</label>
							</div>
							<div class='right'>
								<select name="tujuan" id="tujuan" style='width:70%'>
								<?php 
								//membuat list semua rekening dengan cara select rekening di database
								$statement = $dbc->prepare("SELECT * FROM rekening");
								$statement->execute();
								foreach ($statement as $row){
									echo "<option value=".$row['NO_REKENING'].">".$row['NO_REKENING']."</option>";
								}
								?>
								</select>
							</div>
						</div>
						<div class='field'>
							<div class='left'>
								<label for="jumlah">Nominal</label>
							</div>
							<div class='right'>
								<input type="text" name="jumlah" id="jumlah" value="<?php if (isset($_POST['jumlah'])) echo htmlspecialchars($_POST['jumlah'])?>">
							</div>
						</div>
						<!--tampung pesan eror-->
						<?php if (isset($errors['jumlah'])) 
							echo "<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>
								{$errors['jumlah']}
							</div>
						</div>"; ?>
						<div>
							<div class='left'>
								<label>&nbsp;</label>
							</div>
							<div class='right'>
								<input class="button" type="submit" name="kirim" value="kirim">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include 'footer.php'?>