<?php  
	// login required
	require "admin_permission.php"; 
	//init awal
	$errors = array();
	include 'koneksi.php'; include 'function.php';	
	//untuk cek orang iseng ngubah-ngubah parameter get
	if (!isset($_GET['user'])){ //ini klo ga ada get
		include '../pesan_error.php';
	}else{ //ini kalo isi getnya tidak ada di list
		$statement = $dbc->prepare("SELECT * FROM customer WHERE `USERNAME`=:user");
		$statement->bindValue(":user", $_GET['user']);
		$statement->execute();
		if ($statement->rowCount() == 0){ 
			include '../pesan_error.php';
		}
	}
	//tombol kembali
	if (isset($_POST['back'])){
		header("Location: ./list_cust.php");
		exit();
	}
	//tombol done
	else if (isset($_POST['ganti'])){
		//validasi
		validateAlnum($errors, $_POST, 'passBaru');
		validateSame($errors, $_POST, 'passBaru', 'passConfirm');
		validateKosong($errors, $_POST, 'passBaru');
		validateKosong($errors, $_POST, 'passConfirm');
		if (empty($errors)){ //jika tidak eror
			//update database
			$statement = $dbc->prepare("UPDATE `customer` SET `PASSWORD`=SHA2(:pass,0) WHERE `USERNAME`=:user");
			$statement->bindValue(":pass", $_POST['passBaru']);
			$statement->bindValue(":user", $_GET['user']);
			$statement->execute();
		}
		//jika error, maka post['editpass'] masih diisi untuk tetap bentuk form
		else $_POST['editPass']=true;
	}
	else if (isset($_POST['done'])){
		//valdasi
		validateAlpha($errors, $_POST, 'Nama_Lengkap');
		validateLenTelp($errors, $_POST, 'No_Telpon');
		validateNum($errors, $_POST, 'No_Telpon');
		validateEmail($errors, $_POST, 'Email');
		validateKosong($errors, $_POST, 'Nama_Lengkap');
		validateKosong($errors, $_POST, 'alamat');
		validateKosong($errors, $_POST, 'No_Telpon');
		validateKosong($errors, $_POST, 'Email');
		if (empty($errors)){ //jika tidak eror
			//update database
			$statement = $dbc->prepare("UPDATE `customer` SET `NAMA_LENGKAP`=:nama,`NO_TELEPON`=:telp,`EMAIL`=:email, ALAMAT=:alamat, JENIS_KELAMIN=:jk WHERE `USERNAME`=:user");
			$statement->bindValue(":nama", $_POST['Nama_Lengkap']);
			$statement->bindValue(":telp", $_POST['No_Telpon']);
			$statement->bindValue(":email", $_POST['Email']);
			$statement->bindValue(":alamat", $_POST['alamat']);
			$statement->bindValue(":jk", $_POST['jk']);
			$statement->bindValue(":user", $_GET['user']);
			$statement->execute();
			$tmp = $statement->fetchAll();
			
			header("Location: ./list_cust.php");
		}
		//jika error, maka post['edit'] masih diisi untuk tetap bentuk form
		else $_POST['edit']=true;
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - Edit Customer
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
					<h1>Customer profil</h1>
					<form action="edit_customer.php?user=<?php echo $_GET['user']?>" method="POST">
						<!--Untuk ganti pass, maka nampil form edit pass-->
						<?php if (isset($_POST['editPass'])){?>
						<div class='field'>
							<div class='left'>
								<label>Password Baru :</label>
							</div>
							<div class='right'>
								<input type='password' name='passBaru'>
							</div>
						</div>
						<!--tampung pesan eror-->
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
						<!--tampung pesan eror-->
						<?php if (isset($errors['passConfirm'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['passConfirm'])."</div>
						</div>";?>
						
						<!--Untuk selain ganti pass -> view profil sama edit profil dipecah didalem else-->
						<?php 
						}else{
							//select semua item profil
							$statement = $dbc->prepare("SELECT * FROM `customer` WHERE customer.USERNAME=:user");
							$statement->bindValue(":user", $_GET['user']);
							$statement->execute();
							$tmp = $statement->fetchAll();
							$tmp = $tmp[0];
							
							//tampilkan text username -- tidak bisa diedit
							echo "<div class='field'>
								<div class='left'>
									<label>Username</label>
								</div>
								<div class='right'>
									<label>{$tmp[0]}</label>
								</div>
							</div>";
							
							// init parameter, untuk for biar mudah
							$parameter = array('Username', 'password', 'Nama_Lengkap', 'Jenis_Kelamin', 'alamat', 'No_Telpon', 'Email');
							for ($i=2; $i<7; $i++){
								//echo label sebelah kiri
								echo "<div class='field'>
									<div class='left'>
										<label>{$parameter[$i]}</label>
									</div>";
								//jika tidak edit, maka tampilkan text
								if (!isset($_POST['edit'])) 
									echo "<div class='right'>
											<label>{$tmp[$i]}</label>";
								//jika edit, tampilkan form input:
								else if (isset($_POST['edit'])){
									if ($i == 3){ //type radio
										if ($tmp[$i][3] == 'Laki-laki'){ //
											echo "<div>
												<input type='radio' name='jk' value='Laki-laki'checked /><label> Laki-laki</label> <input type='radio' name='jk' value='perempuan'/><label> Perempuan</label>";
										}else{
											echo "<div>
												<input type='radio' name='jk' value='Laki-laki' /><label > Laki-laki</label> <input type='radio' name='jk' value='perempuan' checked/><label> Perempuan</label>";
										}
									}else { //input text
										if (isset($_POST[$parameter[$i]])) 
											echo "<div class='right'>
													<input type='text' name='{$parameter[$i]}' value='{$_POST[$parameter[$i]]}'/>";
										else
											echo "<div class='right'>
													<input type='text' name='{$parameter[$i]}' value='{$tmp[$i]}'/>";
									}
								}
								//pesan eror
								echo "</div>";
								if (isset($errors[$parameter[$i]])) {
									echo "<div class='field'>
										<div class='left'>&nbsp;</div>
										<div class='right'>".htmlspecialchars($errors[$parameter[$i]])."</div>
									</div>";
								}
							echo "</div>";
							}
						}?>
						<div class='field'>
							<div class='left' style='float:right; width:300px;' >
								<?php if (!isset($_POST['edit']) && !isset($_POST['editPass'])) 
								echo "<input class='button' type='submit' name='edit' value='edit profil'/>
								<input class='button' type='submit' name='editPass' value='edit Password'/>";
							else if (isset($_POST['edit']))
								echo "<input class='button' type='submit' name='done' value='done'/>
								<input class='button' type='submit' name='cancel' value='cancel'/>"; 
							else if (isset($_POST['editPass']))
								echo "<input class='button' type='submit' name='ganti' value='Ganti'/>
								<input class='button' type='submit' name='cancel' value='cancel'/>"; ?>
								<input class='button' type='submit' name='back' value='Back'/>
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