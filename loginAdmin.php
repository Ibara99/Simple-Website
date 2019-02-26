<?php 
	require './admin/function.php';
	if (isset($_POST['login'])){
		verifikasiUsernameAdmin($errors, $_POST, 'user');
		verifikasiPassAdmin($errors, $_POST, 'pass', $_POST['user']);
		validateKosong($errors, $_POST, 'user');
		validateKosong($errors, $_POST, 'pass');
		//validasi username
		//if (loginAdmin($_POST["user"], $_POST["pass"])){
		if (empty($errors)){
			session_start();
			$_SESSION['isAdmin'] = $_POST["user"];
			header ('Location: ./admin/list_cust.php');
			exit();
		}else $gagal_login=true;
	}
	
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Tugas Aplikasi
		</title>
		<link rel=stylesheet href="./style.css" type="text/css">
	</head>
	<body>
		<div class="header">
			<ul>
				<li><img alt="logo" src="./gambar/logo_.png" style="padding:10px; padding-left:20px; width:200px;"></li>
				
				<li style='float:right;'><a href='./aboutus.php' style="padding:0"><img alt="logo" src="./gambar/aboutus.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<li style='float:right;'><a href='./' style="padding:0"><img alt="logo" src="./gambar/home.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
			</ul>
		</div>
		<div class="container">
			<div class="sidebox">
				<div class="box">
					<img alt='info' src='./gambar/sarana.png' style='width:100%'>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<h1>Admin Login</h1>
					<?php if (isset($gagal_login)){
						//echo "<div style='text-align:center;color:red'>Username atau password salah!</div>";
						}?>
					<form method="POST" action="./loginAdmin.php" style="width:50%;margin:auto;">
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
					</form>
				</div>
			</div>
		</div>
		<?php include 'footer.php'?>