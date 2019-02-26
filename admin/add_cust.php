<?php 
	// login sebagai admin required
	require "admin_permission.php"; 
	// init tampung error
	$errors = array();
	include 'function.php'; //import semua function
	//jika tombol cancel ditekan, kembali ke list-customer
	if (isset($_POST['cancel'])){
		header("Location: ./list_cust.php");
		exit();
	}
	//jika tombol done ditekan
	else if (isset($_POST['done'])){
		//validasi isian
		validateUsername($errors, $_POST, 'user');
		validateLenTelp($errors, $_POST, 'telp');
		validateRekeningSama($errors, $_POST, 'rek');
		validateLenRek($errors, $_POST, 'rek');
		validateAlpha($errors, $_POST, 'nama');
		validateNum($errors, $_POST, 'telp');
		validateNum($errors, $_POST, 'rek');
		validateNum($errors, $_POST, 'saldo');
		validateEmail($errors, $_POST, 'email');
		validateAlnum($errors, $_POST, 'pass');
		validateSame($errors, $_POST, 'pass', 'cpass');
		validateKosong($errors, $_POST, 'rek');
		validateKosong($errors, $_POST, 'saldo');
		validateKosong($errors, $_POST, 'user');
		validateKosong($errors, $_POST, 'pass');
		validateKosong($errors, $_POST, 'cpass');
		validateKosong($errors, $_POST, 'nama');
		validateKosong($errors, $_POST, 'alamat');
		validateKosong($errors, $_POST, 'telp');
		validateKosong($errors, $_POST, 'email');
		if (empty($errors)){ //jika tidak eror:
			include 'koneksi.php'; //init database

			// Add data form ke dalam database, tabel customer
			$statement = $dbc->prepare("INSERT INTO `customer` VALUES (:user, SHA2(:pass,0), :nama, :jk, :alamat, :telp, :email)");
			$statement->bindValue(":user", $_POST['user']);
			$statement->bindValue(":pass", $_POST['pass']);
			$statement->bindValue(":nama", $_POST['nama']);
			$statement->bindValue(":jk", $_POST['jk']);
			$statement->bindValue(":alamat", $_POST['alamat']);
			$statement->bindValue(":telp", $_POST['telp']);
			$statement->bindValue(":email", $_POST['email']);
			$statement->execute();
			
			// Add data form ke dalam database, tabel rekening
			$statement = $dbc->prepare("INSERT INTO `rekening` VALUES (:rek, :user, :saldo)");
			$statement->bindValue(":rek", $_POST['rek']);
			$statement->bindValue(":user", $_POST['user']);
			$statement->bindValue(":saldo", $_POST['saldo']);
			$statement->execute();
			
			// kembali ke list customer
			header("Location: ./list_cust.php");
		}
	}
	?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - Add Customer
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
					<h1>Add Customer</h1>
					<form action="./add_cust.php" method="POST">
						<div class='field'>
							<div class='left'>
								<label>Username</label>
							</div>
							<div class='right'>
								<input type='text' name='user' value='<?php if (isset($_POST['user'])) echo htmlspecialchars($_POST['user'])?>' placeholder='Username' />
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['user'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['user'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Password</label>
							</div>
							<div class='right'>
								<input type='password' name='pass' placeholder='Password setidaknya berisi satu huruf besar, huruf kecil, dan numerik'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['pass'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['pass'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Confirm Password</label>
							</div>
							<div class='right'>
								<input type='password' name='cpass'  placeholder='Ketik password yang sama sekali lagi'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['cpass'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['cpass'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Nomor Rekening</label>
							</div>
							<div class='right'>
								<input type='text' name='rek' value='<?php if (isset($_POST['rek'])) echo htmlspecialchars($_POST['rek'])?>'  placeholder='Rekening memiliki panjang 10 digit'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
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
								<input type='text' name='saldo' value='<?php if (isset($_POST['saldo'])) echo htmlspecialchars($_POST['saldo'])?>'  placeholder='Saldo awal rekening'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['saldo'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['saldo'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>nama lengkap</label>
							</div>
							<div class='right'>
								<input type='text' name='nama' value='<?php if (isset($_POST['nama'])) echo htmlspecialchars($_POST['nama'])?>'  placeholder='Nama asli user'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['nama'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['nama'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>Jenis Kelamin</label>
							</div>
							<div >
								<input type='radio' name='jk' value='Laki-laki' checked /><label> Laki-laki</label>
								<input type='radio' name='jk' value='perempuan'/><label> Perempuan</label>
							</div>
						</div>
						<div class='field'>
							<div class='left'>
								<label>Alamat</label>
							</div>
							<div class='right'>
								<textarea name='alamat' style='width:70%'  placeholder='Tempat Tinggal User'><?php if (isset($_POST['alamat'])) echo htmlspecialchars($_POST['alamat'])?></textarea>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['alamat'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['alamat'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>no telp</label>
							</div>
							<div class='right'>
								<input type='text' name='telp' value='<?php if (isset($_POST['telp'])) echo htmlspecialchars($_POST['telp'])?>'  placeholder='Nomor telpon username'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['telp'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['telp'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left'>
								<label>e-mail</label>
							</div>
							<div class='right'>
								<input type='text' name='email' value='<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email'])?>'  placeholder='Email user'/>
							</div>
						</div>
						<!--Tampung pesan eror-->
						<?php if (isset($errors['email'])) echo "
						<div class='field'>
							<div class='left'>&nbsp;</div>
							<div class='right'>".htmlspecialchars($errors['email'])."</div>
						</div>";?>
						<div class='field'>
							<div class='left' style='float:right; width:220px;' >
								<input class='button' type='submit' name='done' value='done'/>
								<input class='button' type='submit' name='cancel' value='cancel' onclick="return  confirm('Batal Add User baru? Y/N')"/>
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