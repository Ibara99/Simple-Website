<?php  
	// login required
	require "admin_permission.php";
	//init database
	include 'koneksi.php'; include 'function.php';
	//action tombol
	if (isset($_POST['add'])){
		header("Location: ./add_trans.php");
		exit();
	}
	else if (isset($_GET['transaksi'])){
		//delete di tabel transaksi
		$statement = $dbc->prepare("DELETE FROM `transaksi` WHERE ID_TRANSAKSI=:no");
		$statement->bindValue(":no", $_GET["transaksi"]);
		$statement->execute();
	}
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			Admin - List Transaksi
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
					<h2>Admin</h2>
				</div>
				<div class="box">
					<ul>
						<li><a href="./list_cust.php">Customer</a></li>
						<li class='active'><a href="./list_trans.php">Transaksi</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="box">
					<h1>List Transaksi</h1>
					<form action='./list_trans.php' method='POST'>
						<div class='field'>
							<div class='left'>
								<label>Cari berdasarkan:</label>
							</div>
							<div class='right'>
								<select name='categori'>
									<?php
										//declare semua keyword
										$values = array("ID_TRANSAKSI", "NO_REKENING_PENGIRIM", "NO_REKENING_TUJUAN");
										$text = array("ID Transaksi", "No Rekening Pengirim", "No Rekening Tujuan");
										for ($i=0; $i<count($values); $i++){
											if (isset($_POST['categori']) && $values[$i] == $_POST['categori'])
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
								<input type='text' name='isian' value='<?php if (isset($_POST['isian'])) echo htmlspecialchars($_POST['isian'])?>'>
							</div>
						</div>
						<div class='field'>
							<div class='left'>
								<label>&nbsp;</label>
							</div>
							<div>
								<input class='button' type='submit' name='cek' value='Cek Transaksi'>
								<input class='button' type='submit' name='clear' value='Lihat Semua Transaksi'>
								<input class='button' type='submit' name='add' value='Add Transaksi'/>
							</div>
						</div>
					</form>
					<?php
					//query select. jika cek dipencet, maka nambah keyword
						if (isset($_POST['cek'])){
							$statement = $dbc->prepare("SELECT * FROM `transaksi` WHERE {$_POST['categori']}=:key");
							$statement->bindValue(':key', $_POST['isian']);
						}else{
							$statement = $dbc->prepare("SELECT * FROM `transaksi` ");
						}
						$statement->execute();
						$tmp = $statement->fetchAll();
						echo "<table class='tabel'>";
						echo "<tr>";
							echo "<td>no</td><td>ID Transfer</td><td>No Rekening Pengirim</td><td>No Rekening Tujuan</td><td>Nominal</td><td>Waktu pengiriman</td><td>Menu</td>";
						echo "</tr>";
					//tampilkan hasil query
					$counter =1;
					if (count($tmp)==0)
						echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
					for ($row=0; $row<count($tmp);$row++){
						echo "<tr><td>{$counter}</td>
								<td>{$tmp[$row][0]}</td>
								<td>{$tmp[$row][1]}</td>
								<td>{$tmp[$row][2]}</td>
								<td>".rupiah($tmp[$row][3])."</td>
								<td>{$tmp[$row][4]}</td>
								<td><a class='button' href='?transaksi={$tmp[$row][0]}' onclick=\"return  confirm('do you want to delete Y/N')\">delete</a></td></tr>";
						$counter++;
						//<a class='button' href='./edit_trans.php?transaksi={$tmp[$row][0]}'>edit</a>
					}
						echo '</table>';
					?>
				</div>
			</div>
		</div>
		<?php include 'footer.php'?>