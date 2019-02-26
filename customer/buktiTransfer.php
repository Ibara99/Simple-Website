<!--Hanya untuk include-->
<?php
	//just in case ada orang ga jelas nge refresh page hanya untuk transfer berkali-kali
	if (isset($_SESSION['transfer'])){
		header ("Location: ./transaksi.php");
		exit();
	}
	else //jika ini transger pertama, dicatat di session
		$_SESSION['transfer']=1;
	//just in case ada orang ga jelas mengakses file ini secara langsung
	if (empty($_POST)){
		include '../pesan_error.php';
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Transaksi
		</title>
		<link rel=stylesheet href="../style.css" type="text/css">
		<!--style>
			@media print {
			  body * {
				visibility: hidden;
			  }
				.print{
					visibility: visible;
				}
					#section-to-print {
					position: absolute;
					left: 0;
					top: 0;
				}
			}
		</style-->
	</head>
	<body>
		<div class="header">
			<ul>
				<li><a href='../bank.php' style="padding:0"><img alt="logo" src="../gambar/logo_.png" style="padding:10px; padding-left:20px; width:200px;"></a></li>
				<li style='float:right;'><a href='../logout.php' style="padding:0"><img alt="logo" src="../gambar/logout.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<li style='float:right;'><a href='../aboutus.php' style="padding:0"><img alt="logo" src="../gambar/aboutus.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<?php if (isset($_SESSION['isCustomer'])){?>
				<li style='float:right;'><a href='../' style="padding:0"><img alt="logo" src="../gambar/home.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<?php } else if (isset($_SESSION['isAdmin'])) {?>
				<li style='float:right;'><a href='../' style="padding:0"><img alt="logo" src="../gambar/home.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
				<?php }?>
			</ul>
		</div>
		<div class="container">
			<div class="sidebox">
				<div class="box">
					<h2>Customer</h2>
				</div>
				<div class="box">
					<ul>
						<!--li><a href="../index.php">Home</a></li-->
						<li><a href="./cekRekening.php">Cek Rekening</a></li>
						<li><a href="./browse.php">Cek Transaksi</a></li>
						<li class="active"><a href="./transaksi.php">Transfer</a></li>
						<li><a href="./profil.php">Profil</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<div class='print_area'>
						<?php
							//init saldo awal dan nominal transfer
							$saldo = getSaldo($_POST['asal']);
							$transfer = intval($_POST['jumlah']);
							
							// jika saldo mencukupi untuk transfer (500 itu fee admin btw)
							if ($saldo > $transfer+500){//maka tampilkan bukti transfer
						?>
						<h1 style='text-align:center;'>Bukti Transfer</h1>
						<div style='padding-left:30%'>
							<div class='field'>
								<div class='left'>
									<label>Nama Pengirim</label>
								</div>
								<div class='right'>
									<label><?php echo getNamaCust($_POST['asal']); $_SESSION['namaPengirim']=getNamaCust($_POST['asal'])?></label>
								</div>
							</div>
							<div class='field'>
								<div class='left'>
									<label>Rekening Pengirim</label>
								</div>
								<div class='right'>
									<label><?php echo htmlspecialchars($_POST['asal']); $_SESSION['rekPengirim']=$_POST['asal']?></label>
								</div>
							</div>
							<div class='field'>
								<div class='left'>
									<label>Nama Penerima</label>
								</div>
								<div class='right'>
									<label><?php echo getNamaCust($_POST['tujuan']); $_SESSION['namaPenerima']=getNamaCust($_POST['tujuan']);?></label>
								</div>
							</div>
							<div class='field'>
								<div class='left'>
									<label>Rekening Penerima</label>
								</div>
								<div class='right'>
									<label><?php echo htmlspecialchars($_POST['tujuan']); $_SESSION['rekPenerima']=$_POST['tujuan']?></label>
								</div>
							</div>
							<div class='field'>
								<div class='left'>
									<label>Saldo Awal</label>
								</div>
								<div class='right'>
									<label><?php echo rupiah(getSaldo($_POST['asal'])); $_SESSION['saldoAwal']=rupiah(getSaldo($_POST['asal']));?></label>
								</div>
							</div>
							<div class='field'>
								<div class='left'>
									<label>Nominal Transfer</label>
								</div>
								<div class='right'>
									<label><?php echo htmlspecialchars(rupiah($_POST['jumlah'])); $_SESSION['nominal']=rupiah($_POST['jumlah']);?></label>
								</div>
							</div>
							<?php 
								//saldo rek pengirim dikurangi
								$saldo = $saldo - $transfer - 500;
								//update saldo rek pengirim
								setSaldo($saldo, $_POST['asal']);
								
								//transaksi dicatat 
								$statement = $dbc->prepare("INSERT INTO `transaksi` VALUES (null, :asal, :tujuan, :nominal, null)");
								$statement->bindValue(':asal', $_POST['asal']);
								$statement->bindValue(':tujuan', $_POST['tujuan']);
								$statement->bindValue(':nominal', $_POST['jumlah']);
								$statement->execute();
								
								//init saldo rek penerima dan ditambah dengan nominal transaksi
								$saldo = getSaldo($_POST['tujuan']);
								$saldo = $saldo + $transfer;
								//update saldo rek penerima
								setSaldo($saldo, $_POST['tujuan']);
								
							?>
							<div class='field'>
								<div class='left'>
									<label>Biaya Admin</label>
								</div>
								<div class='right'>
									<label>Rp. 500,00</label>
								</div>
							</div>
							<div class='field'>
								<div class='left'>
									<label>Sisa saldo</label>
								</div>
								<div class='right'>
									<label><?php echo rupiah(getSaldo($_POST['asal'])); $_SESSION['saldoSisa']=rupiah(getSaldo($_POST['asal']));?></label>
								</div>
							</div>
							<div class='field'>
								<div>
									<form method='POST' action='./transaksi.php'>
										<input class='button' type='submit' name='back' value='back'/>
										<a class='button' href='printfile.php'>Cetak bukti Transfer</a>
									</form>
								</div>
								
							</div>
						</div>
						<?php } else {// jika saldo tidak mencukupi echo:?>
						<h1>Transfer Gagal</h1>
						
						<h3 style='text-align:center;'>Saldo Anda tidak mencukupi untuk melakukan transaksi ini.</h3>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
		<?php include './footer.php'?>