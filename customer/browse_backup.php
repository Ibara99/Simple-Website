<?php  
	// login customer required
	require "login_permission.php";
	// init database
	include 'koneksi.php'; include 'function.php';
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Cek Transaksi
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
						<li class="active"><a href="./browse.php">Cek Transaksi</a></li>
						<li><a href="./transaksi.php">Transfer</a></li>
						<li><a href="./profil.php">Profil</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
			<div class="box">
				<h1>daftar transaksi</h1>
				<form action='./browse' method='POST'>
					<div class='field'>
						<div class='left'>
							<label>No Rekening:</label>
						</div>
						<div class='right'>
							<select name='noRek'>
								<?php
									//membuat daftar norek yg dimiliki dengan cara select database 
									$statement = $dbc->prepare("SELECT rekening.NO_REKENING 
									FROM `customer` 
									INNER JOIN rekening ON rekening.USERNAME=customer.USERNAME
									WHERE customer.USERNAME=:user");
									$statement->bindValue(":user", $_SESSION["isCustomer"]);
									$statement->execute();
									$data = $statement->fetchAll();
									
									for ($i=0; $i<count($data); $i++){
										if ($data[$i][0] == $_POST['noRek'])
											echo "<option value='{$data[$i][0]}' selected>{$data[$i][0]}</option>";
										else
											echo "<option value='{$data[$i][0]}'>{$data[$i][0]}</option>";
									}
									if (!isset($_POST['noRek'])) $_POST['noRek']=$data[0][0];
								?>
							</select>
						</div>
					</div>
					<div class='field'>
						<div class='left'>
							<label>Cari berdasarkan:</label>
						</div>
						<div class='right'>
							<select name='categori'>
								<?php
									//membuat daftar keyword
									$values = array("ID_TRANSAKSI", "NO_REKENING_PENGIRIM", "NO_REKENING_TUJUAN");
									$text = array("ID Transaksi", "No Rekening Pengirim", "No Rekening Tujuan");
									for ($i=0; $i<count($values); $i++){
										if ($values[$i] == $_POST['categori'])
											echo "<option value='{$values[$i]}' selected>{$text[$i]}</option>";
										else
											echo "<option value='{$values[$i]}'>{$text[$i]}</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class='field'>
						<div class='left'>
							<label>Kata Kunci :</label>
						</div>
						<div class='right'>
							<input type='text' name='isian' value='<?php if (isset($_POST['isian'])) echo htmlspecialchars($_POST['isian'])?>'  placeholder='Masukkan kata kunci pencarian transaksi'>
						</div>
					</div>
					<div class='field'>
						<div class='left'>
							<label>&nbsp;</label>
						</div>
						<div>
							<input class='button' type='submit' name='cek' value='Cek Transaksi'>
							<input class='button' type='submit' name='clear' value='Lihat Semua Transaksi'>
						</div>
					</div>
				</form>
				<?php 
					//init tabel
					echo "<table class='tabel'>";
						echo "<tr>";
							echo "<td>no</td><td>No Rekening Pengirim</td><td>No Rekening Tujuan</td><td>Nominal</td><td>waktu</td>";
							
					$cekKosong = True;
					$counter =1;
					//kondisi select daftar transaksi
					if (isset($_POST['cek'])){
						$statement = $dbc->prepare("SELECT transaksi.* FROM `transaksi` 
						WHERE (transaksi.NO_REKENING_PENGIRIM=:rek OR transaksi.NO_REKENING_TUJUAN=:rek) AND {$_POST['categori']}=:key");
						$statement->bindValue(':key', $_POST['isian']);
					}else{
						$statement = $dbc->prepare("SELECT transaksi.* FROM `transaksi` 
						WHERE transaksi.NO_REKENING_PENGIRIM=:rek OR transaksi.NO_REKENING_TUJUAN=:rek");
					}
					$statement->bindValue(':rek', $_POST['noRek']);
					$statement->execute();
					$tmp = $statement->fetchAll();
					
						echo "</tr>";
					//tampilkan hasil query
					for ($row=0; $row<count($tmp);$row++){
						$cekKosong = False;
						echo "<tr><td>{$counter}</td>
								<td>{$tmp[$row][1]}</td>
								<td>{$tmp[$row][2]}</td>
								<td>".rupiah($tmp[$row][3])."</td>
								<td>{$tmp[$row][4]}</td></tr>";
						$counter++;
					}
					
					if ($cekKosong){
						echo "<tr><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
					}
					echo "</table><br/>";
				?>
				
			</div>
			</div>
		</div>
		
		<?php include 'footer.php'?>