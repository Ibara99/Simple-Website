<?php 
	// link Tombol
	if(isset($_POST['back'])) {
		header("Location: ./");
	}
	else if(isset($_POST['a'])) {
		header("Location: ./");
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Tugas Aplikasi
		</title>
		<link rel="stylesheet" href="./style.css" type="text/css">
	</head>
	<body>
		<div class="header">
			<ul>
				<li><a class='btn_img_kiri' href='bank.php' style="padding:0"><img alt="logo" src="./gambar/bank.png" style="padding:10px; padding-left:20px; width:200px;"></a></li>
				<li style='float:right;'><a class='btn_img_kanan' href='./' style="padding:0"><img alt="logo" src="./gambar/back.png" style="padding:10px; padding-left:20px; width:50px;"></a></li>
			</ul>
		<div class="container">
			<div style='background-color:gray; padding:25px;'>
				<div class="box"  style="text-align:center;">
						<table style='margin:auto; text-align:center;'>
						<tr>
							<td style='width:30%'>
								<table style='text-align:center;vertical-align:top'>
									<tr>
										<td colspan='3'><img alt='banner' src='./gambar/husna.png' style="padding:10px; padding-left:20px; width:200px;"/> </td>
									</tr>
									<tr>
										<td style='text-align:left'>Nama</td>
										<td>:</td>
										<td style='text-align:left'>Husna</td>
									</tr>
									<tr>
										<td style='text-align:left'>NIM</td>
										<td>:</td>
										<td style='text-align:left'>160411100018</td>
									</tr>
									<tr>
										<td style='text-align:left'>Mata Kuliah</td>
										<td>:</td>
										<td style='text-align:left'>Pengembangan<br>Aplikasi Web - C</td>
									</tr>
									<tr>
										<td style='text-align:left'>Job Description</td>
										<td>:</td>
										<td style='text-align:left'>
											CDM - PDM<br/>
											Login<br/>
											Admin - Add Customer<br/>
											Admin - Add Rekening<br/>
											Validasi Kosong<br/>
											Validasi Alphabet<br/>
										</td>
									</tr>
								</table>
							</td>
							<td style='width:30%'>
								<table style='text-align:center'>
									<tr>
										<td colspan='3'><img alt='banner' src='./gambar/ibnu.png' style="padding:10px; padding-left:20px; width:200px;"/> </td>
									</tr>
									<tr>
										<td style='text-align:left'>Nama</td>
										<td>:</td>
										<td style='text-align:left'>Ibnu Asro Putra</td>
									</tr>
									<tr>
										<td style='text-align:left'>NIM</td>
										<td>:</td>
										<td style='text-align:left'>160411100023</td>
									</tr>
									<tr>
										<td style='text-align:left'>Mata Kuliah</td>
										<td>:</td>
										<td style='text-align:left'>Pengembangan<br>Aplikasi Web - C</td>
									</tr>
									<tr>
										<td style='text-align:left'>Job Description</td>
										<td>:</td>
										<td style='text-align:left'>
											Layout<br/>
											Customer - Transfer<br/>
											Customer - Browse Transaksi<br/>
											Admin - Transfer<br/>
											Konfirmasi Password<br/>
											Validasi email<br/>
										</td>
									</tr>
								</table>
							</td>
							<td style='width:30%'>
								<table style='text-align:center'>
									<tr>
										<td colspan='3'><img alt='banner' src='./gambar/kiki.png' style="padding:10px; padding-left:20px; width:200px;"/> </td>
									</tr>
									<tr>
										<td style='text-align:left'>Nama</td>
										<td>:</td>
										<td style='text-align:left'>Rizkyta Ayu Nafiah</td>
									</tr>
									<tr>
										<td style='text-align:left'>NIM</td>
										<td>:</td>
										<td style='text-align:left'>160411100029</td>
									</tr>
									<tr>
										<td style='text-align:left'>Mata Kuliah</td>
										<td>:</td>
										<td style='text-align:left'>Pengembangan<br>Aplikasi Web - C</td>
									</tr>
									<tr>
										<td style='text-align:left'>Job Description</td>
										<td>:</td>
										<td style='text-align:left'>
											Use Case - Activity Diagram<br/>
											Logout<br/>
											Admin - Edit Profil<br/>
											Customer - Edit Password<br/>
											Validasi Numerik<br/>
											Validasi Alfanumerik<br/>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>					
				</div>
			</div>
		</div>
	</div>
	
	<?php include 'footer.php'?>