<?php
	require 'login_permission.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Bukti Transfer</title>
		<link rel=stylesheet href="../style.css" type="text/css">
	</head>
	<body onload='window.print()'>
		<div>
			<img src='../gambar/logo_.png' alt='logo' style='width:25%'>
			<h1>Bukti Transfer</h1>
			<div class='field'>
				<div class='left'>
					<label>Nama Pengirim</label>
				</div>
				<div class='right'>
					<label><?php echo $_SESSION['namaPengirim']?></label>
				</div>
			</div>
			<div class='field'>
				<div class='left'>
					<label>Rekening Pengirim</label>
				</div>
				<div class='right'>
					<label><?php echo $_SESSION['rekPengirim']?></label>
				</div>
			</div>
			<div class='field'>
				<div class='left'>
					<label>Nama Penerima</label>
				</div>
				<div class='right'>
					<label><?php echo $_SESSION['namaPenerima']?></label>
				</div>
			</div>
			<div class='field'>
				<div class='left'>
					<label>Rekening Penerima</label>
				</div>
				<div class='right'>
					<label><?php echo $_SESSION['rekPenerima']?></label>
				</div>
			</div>
			<div class='field'>
				<div class='left'>
					<label>Saldo Awal</label>
				</div>
				<div class='right'>
					<label><?php echo $_SESSION['saldoAwal']?></label>
				</div>
			</div>
			<div class='field'>
				<div class='left'>
					<label>Nominal Transfer</label>
				</div>
				<div class='right'>
					<label><?php echo $_SESSION['nominal']?></label>
				</div>
			</div>
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
					<label><?php echo $_SESSION['saldoSisa']?></label>
				</div>
			</div>
		</div>
	</body>
</html>