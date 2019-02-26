<?php  
	// login required
	require "login_permission.php";
	// init awal
	$errors = array();
	include 'koneksi.php'; include 'function.php';
	
	//tombol cancel kembali ke view profil
	if (isset($_POST['cancel'])){
		header("Location: ./profil.php");
		exit();
	}
	else if (isset($_POST['done'])){
		//validasi
		verifikasiPass($errors, $_POST, 'passLama', $_SESSION['isCustomer']);
		validateAlnum($errors, $_POST, 'passBaru');
		validateSame($errors, $_POST, 'passBaru', 'passConfirm');
		validateKosong($errors, $_POST, 'passLama');
		validateKosong($errors, $_POST, 'passBaru');
		validateKosong($errors, $_POST, 'passConfirm');
		if (empty($errors)){ //klo ga error
			//update database
			$statement = $dbc->prepare("UPDATE `customer` SET `PASSWORD`=SHA2(:pass,0) WHERE `USERNAME`=:user");
			$statement->bindValue(":pass", $_POST['passBaru']);
			$statement->bindValue(":user", $_SESSION['isCustomer']);
			$statement->execute();
			//kembali ke view profil
			header("Location: ./profil.php");
			exit();
		}//else {print_r ($errors); 
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
			<div class="content" style='height:350px'>
				<div class="box" style='height:325px'>
					<h1>My profil</h1>
					<form action="./editPass.php" method="POST" style='padding-top:2%'>
						<div class='field'>
							<div class='left'>
								<label>Password Lama :</label>
							</div>
							<div class='right'>
								<input type='password' name='passLama'>
							</div>
						</div>
						<?php if (isset($errors['passLama'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['passLama'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Password Baru :</label>
							</div>
							<div class='right'>
								<input type='password' name='passBaru'>
							</div>
						</div>
						<?php if (isset($errors['passBaru'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['passBaru'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Konfirmasi Password :</label>
							</div>
							<div class='right'>
								<input type='password' name='passConfirm'>
							</div>
						</div>
						<?php if (isset($errors['passConfirm'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['passConfirm'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left' style='float:right; width:230px;' >
								<input class='button' type='submit' name='done' value='done'/>
								<input class='button' type='submit' name='cancel' value='cancel'/>
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