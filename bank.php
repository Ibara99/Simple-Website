<?php 
	// mengarahkan tombol
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
		
					<img alt='banner' src='./gambar/bank.png' style="padding:10px; padding-left:20px; width:50%;"/>
					<h1>Kenapa Ada Bank PINK ?</h1>
					<h3>
						Bank PINK kini hadir untuk Anda!  <br>
						Butuh transfer yang aman, mudah, cepat, dan di mana saja? <br>
						Hanya Bank PINK yang BISA 
					</h3>
					<hr/>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'?>