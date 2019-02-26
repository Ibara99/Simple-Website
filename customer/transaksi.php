<?php 
	// login required
	require "login_permission.php";
	/*Kurang trigger, validasi password*/
	//init awal
	$errors = array();
	include 'koneksi.php'; include 'function.php';
	if(isset($_POST['kirim'])){
		//validasi
		validateRekening($errors, $_POST, 'tujuan');
		validateLenRek($errors, $_POST, 'tujuan');
		validateNum($errors, $_POST, 'tujuan');
		validateNum($errors, $_POST, 'jumlah');
		verifikasiPass($errors, $_POST, 'password', $_SESSION['isCustomer']);
		validateKosong($errors, $_POST, 'tujuan');
		validateKosong($errors, $_POST, 'jumlah');
		validateKosong($errors, $_POST, 'password');
		
		if (empty($errors)){
			//jika ga eror, ke bukti transfer -> pengurangan saldo dsb ada di sana
			include 'buktiTransfer.php';
			exit();
		}//else print_r ($errors);
	}
	//session di hapus, agar tidak ada transfer double
	unset($_SESSION['transfer']);
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Transaksi
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
						<li class="active"><a href="./transaksi.php">Transfer</a></li>
						<li><a href="./profil.php">Profil</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<h1>Transfer</h1>
					<form method="POST" action="./transaksi.php" style="width:50%;margin:auto;">
						<div class='field'>
							<div class='left'>
								<label>Rek Pengirim</label>
							</div>
							<div class='right'>
								<select name="asal" id="asal" style='width:72%'>
									<?php
									//select semua rekening yg dipunya
									$statement = $dbc->prepare("SELECT customer.NAMA_LENGKAP, rekening.NO_REKENING, rekening.SALDO 
									FROM `customer` 
									INNER JOIN rekening ON rekening.USERNAME=customer.USERNAME
									WHERE customer.USERNAME=:user");
									$statement->bindValue(":user", $_SESSION["isCustomer"]);
									$statement->execute();
									$data = $statement->fetchAll();						
									
									for ($i=0; $i<count($data); $i++){
										if (isset($_POST['asal']) && $data[$i]['NO_REKENING'] == $_POST['asal'])
											echo "<option value=".$data[$i]['NO_REKENING']." selected>".$data[$i]['NO_REKENING']."</option>";
										else
											echo "<option value=".$data[$i]['NO_REKENING'].">".$data[$i]['NO_REKENING']."</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class='field'>
							<div class='left'>
								<label>Rek Tujuan</label>
							</div>
							<div class='right'>
								<input type="text" name="tujuan"  value='<?php if (isset($_POST['tujuan'])) echo htmlspecialchars($_POST['tujuan'])?>'>
							</div>
						</div>
						<!--tampung pesan eror-->
						<?php if (isset($errors['tujuan'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['tujuan'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Nominal</label>
							</div>
							<div class='right'>
								<input type="text" name="jumlah" id="jumlah" value="<?php if (isset($_POST['jumlah'])) echo htmlspecialchars($_POST['jumlah'])?>">
							</div>
						</div>
						<!--tampung pesan eror-->
						<?php if (isset($errors['jumlah'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['jumlah'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Password</label>
							</div>
							<div class='right'>
								<input type="password" name="password" id="password">
							</div>
						</div>
						<!--tampung pesan eror-->
						<?php if (isset($errors['password'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['password'])."</div>
						</div>";?>
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
		<?php include './footer.php'?>