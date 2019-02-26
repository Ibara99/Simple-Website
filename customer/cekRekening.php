<?php  
	// login required
	require "login_permission.php";
	//init koneksi database
	include 'koneksi.php';include 'function.php';
	
	//select data customer
	$statement = $dbc->prepare("SELECT customer.NAMA_LENGKAP, rekening.NO_REKENING, rekening.SALDO 
	FROM `customer` 
	INNER JOIN rekening ON rekening.USERNAME=customer.USERNAME
	WHERE customer.USERNAME=:user");
	$statement->bindValue(":user", $_SESSION["isCustomer"]);
	$statement->execute();
	$data = $statement->fetchAll();
	
	$_SESSION['nama'] = $data[0][0];
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Cek Rekening
		</title>
		<link rel=stylesheet href="../style.css" type="text/css">
		<script>
			function showSaldo(){
				document.getElementById('saldo').innerHTML = '<?php 
						//jika tombol ditekan, baru keluar saldonya
						if(isset($_POST["rek"])){
						    $idx=$_POST["rek"];
							if ($idx != -1)
								echo "<p>Saldo Anda sekarang : ".rupiah($data[$idx]['SALDO'])."</p>"; 
						}else echo'anu';
						?>';
			}
		</script>
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
						<li class="active"><a href="./cekRekening.php">Cek Rekening</a></li>
						<li><a href="./browse.php">Cek Transaksi</a></li>
						<li><a href="./transaksi.php">Transfer</a></li>
						<li><a href="./profil.php">Profil</a></li>
					</ul>
				</div>
			</div>
			<div class="content" style='height:350px'>
			<div class="box" style='height:330px'>
				<div>
					<?php echo "<h1>Selamat Datang, {$data[0][0]}</h1>";?>
				</div>
				<div style="text-align:center; padding:10px;">
					<form action='./cekRekening.php' method='POST'  style='padding-top:7%'>
						<div>
							<label>Pilih Rekening Anda</label>
							<select name="rek" id="rek" style='width:15%' onchange=this.form.submit()>
							<?php
							// list semua rekening yang dimiliki
							if(!isset($_POST['rek'])){
								echo "<option value='-1' selected>--Pilih Rekening--</option>";
							}else 
								echo "<option value='-1'>--pilih rekening--</option>";
							for ($i=0; $i<count($data); $i++){
								if(isset($_POST['rek']) && $i == $_POST['rek'])
									echo "<option value=".$i." selected>".$data[$i]['NO_REKENING']."</option>";
								else
									echo "<option value=".$i.">".$data[$i]['NO_REKENING']."</option>";
							}
							?>
							</select>
						</div>
						<div id='saldo'>
						<?php 
						//jika tombol ditekan, baru keluar saldonya
						if(isset($_POST["rek"])){
						    $idx=$_POST["rek"];
							if ($idx != -1)
								echo "<p>Saldo Anda sekarang : ".rupiah($data[$idx]['SALDO'])."</p>"; 
						}
						?>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div>
		
		<?php include 'footer.php'?>