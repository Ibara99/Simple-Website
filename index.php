<?php
	//init awal
	require './customer/function.php';
	session_start();
	$errors=array();
	if (isset($_POST['login'])){
		verifikasiUsername($errors, $_POST, 'user');
		verifikasiPass($errors, $_POST, 'pass', $_POST['user']);
		validateKosong($errors, $_POST, 'user');
		validateKosong($errors, $_POST, 'pass');
		if (empty($errors)){
			//kita butuh no rekening untuk mengenali setiap user. norek sangat bermanfaat :)
			include './customer/koneksi.php';
			$statement = $dbc->prepare("SELECT USERNAME FROM `customer` WHERE USERNAME=:user");
			$statement->bindValue(":user", $_POST["user"]);
			$statement->execute();
			$tmp = $statement->fetchAll();
			
			$_SESSION['isCustomer'] = $tmp[0][0];
			header ('Location: ./customer/cekRekening.php');
			exit();
		}else
			$gagal_login = true;
	}
	
?>
<!DOCTYPE HTML>
<html lang="en"><head>
		<title>
			Tugas Aplikasi
		</title>
		<link rel="stylesheet" href="./style.css" type="text/css">
	</head>
	<body>
		<div class="header">
			<ul>
				<li><a href='./bank.php' style="padding:0"><img alt="logo" src="./gambar/logo_.png" style="padding:10px; padding-left:20px; width:200px;"></a></li>
				<?php
					if (isset($_SESSION['isAdmin']) || isset($_SESSION['isCustomer'])){
				?>
				<li style='float:right;'><a href='./logout.php' style="padding:0"><img alt="logo" src="./gambar/logout.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<?php }?>
				<li style='float:right;'><a href='./aboutus.php' style="padding:0"><img alt="logo" src="./gambar/aboutus.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<?php 
					if (isset($_SESSION['isAdmin'])){?>
				
				<li style='float:right;'><a href='./admin/list_cust.php' style="padding:0"><img alt="logo" src="./gambar/manajement.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
					<?php } 
					else if (isset($_SESSION['isCustomer'])){?>
				<li style='float:right;'><a href='./customer/cekRekening.php' style="padding:0"><img alt="logo" src="./gambar/transaksi.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
					<?php }
				?>
				
			</ul>
		</div>
		<div class="container">
			<div class="sidebox">
				<div class="box">
					<?php if (isset($_SESSION['isAdmin']) || isset($_SESSION['isCustomer'])){?>
					<img alt='info' src='./gambar/sarana.png' style='width:100%'>
					<?php } else {
						if (isset($gagal_login)){
							//echo "<div style='text-align:center;color:red'>Username atau password salah!</div>";
						}?>
					<form method="POST" action="./">
						<div class="field">
							<div class='left'>
								<label for="user">User</label>
							</div>
							<div class='right'>
								<input name="user" id="user" type="text" value='<?php if (isset($_POST['user'])) echo htmlspecialchars($_POST['user'])?>'>
							</div>
						</div>
						<?php if (isset($errors['user'])) echo "
						<div class='field'>
							<div style='text-align:center;color:red'>".htmlspecialchars($errors['user'])."</div>
						</div>";?>
						<div class="field">
							<div class='left'>
								<label for="pass">Pass</label>
							</div>
							<div class='right'>
								<input name="pass" id="pass" type="password" value='<?php if (isset($_POST['pass'])) echo htmlspecialchars($_POST['pass'])?>'>
							</div>
						</div>
						<?php if (isset($errors['pass'])) echo "
						<div class='field'>
							<div style='text-align:center;color:red'>".htmlspecialchars($errors['pass'])."</div>
						</div>";?>
						<div class="field">
							<div class='left'>
								<label>&nbsp;</label>
							</div>
							<div class='right'>
								<input class="button" name="login" value="login" type="submit">
							</div>
						</div>
						<div class="field">
							<div class='left'> <a href='./loginAdmin.php'>Admin</a></div>
							<div class='right'>
								&nbsp;
							</div>
						</div>
					</form>
					<?php }?>
				</div>
			</div>
			<div class="content" style="text-align:center;">
				<div style='width:100%; margin:auto;'>
					<img alt='banner' src='./gambar/new.png' style="padding:5px;  width:100%;"/>
				</div>
			</div>
		</div>
		<?php include './footer.php'?>