<?php 
	function getNamaCust($noRek){
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT customer.NAMA_LENGKAP FROM `rekening` 
		INNER JOIN customer ON rekening.USERNAME=customer.USERNAME
		WHERE NO_REKENING=:rek");
		$statement->bindValue(':rek', $noRek);
		$statement->execute();
		$tmp=$statement->fetchAll();
		return $tmp[0][0];
	}
	function getSaldo($noRek){
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT SALDO FROM `rekening` 
		WHERE NO_REKENING=:rek");
		$statement->bindValue(':rek', $noRek);
		$statement->execute();
		$tmp=$statement->fetchAll();
		return $tmp[0][0];
	}
	function setSaldo($saldo, $noRek){
		include 'koneksi.php';
		$statement = $dbc->prepare("UPDATE `rekening` SET `SALDO`=:saldoBaru 
		WHERE NO_REKENING=:rek");
		$statement->bindValue(':saldoBaru', $saldo);
		$statement->bindValue(':rek', $noRek);
		$statement->execute();
	}
	
	
	
	
	
	
	
	
	function verifikasiPass(&$errors, $field_list, $field_name, $username){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM customer where USERNAME = :username and PASSWORD = SHA2(:password, 0)");
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $field_list[$field_name]);
		$statement->execute();
		
		if ($statement->rowCount() == 0) $errors[$field_name] = 'Password salah';
	}
	function verifikasiUsername(&$errors, $field_list, $field_name){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM customer where USERNAME = :username");
		$statement->bindValue(':username', $field_list[$field_name]);
		$statement->execute();
		
		if ($statement->rowCount() == 0) $errors[$field_name] = 'Username Tidak Ditemukan';
	}
	
	function verifikasiPassAdmin(&$errors, $field_list, $field_name, $username){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM admin where NAMA_ADMIN = :username and KATA_SANDI = SHA2(:password, 0)");
		$statement->bindValue(':username', $username);
		$statement->bindValue(':password', $field_list[$field_name]);
		$statement->execute();
		
		if ($statement->rowCount() == 0) $errors[$field_name] = 'Password salah';
	}
	function verifikasiUsernameAdmin(&$errors, $field_list, $field_name){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM admin where NAMA_ADMIN = :username");
		$statement->bindValue(':username', $field_list[$field_name]);
		$statement->execute();
		
		if ($statement->rowCount() == 0) $errors[$field_name] = 'Username Tidak Ditemukan';
	}
	
	function validateUsername(&$errors, $field_list, $field_name){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM `customer` 
		WHERE USERNAME=:user");
		$statement->bindValue(':user', $field_list[$field_name]);
		$statement->execute();
		if ($statement->rowCount() > 0) $errors[$field_name] = 'Username sudah digunakan';
	}
	function validateRekening(&$errors, $field_list, $field_name){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM `rekening` 
		WHERE NO_REKENING=:rek");
		$statement->bindValue(':rek', $field_list[$field_name]);
		$statement->execute();
		if ($statement->rowCount() == 0) $errors[$field_name] = 'Nomor rekening tidak ditemukan';
	}
	function validateRekeningSama(&$errors, $field_list, $field_name){ 
		include 'koneksi.php';
		$statement = $dbc->prepare("SELECT * FROM `rekening` 
		WHERE NO_REKENING=:rek");
		$statement->bindValue(':rek', $field_list[$field_name]);
		$statement->execute();
		if ($statement->rowCount() > 0) $errors[$field_name] = 'Nomor rekening sudah terdaftar';
	}
	function validateKosong(&$errors, $field_list, $field_name){ 
		if (empty($field_list[$field_name])) $errors[$field_name] = 'Form harus diisi';
	}
	function validateAlpha(&$errors, $field_list, $field_name){ 
		$pattern = "/^[a-zA-Z' -]+$/";
		if (!preg_match($pattern, $field_list[$field_name])) $errors[$field_name] = 'Hanya menggunakan alfabet';
	}
	function validateNum(&$errors, $field_list, $field_name){ 
		$pattern = "/^[0-9]+$/";
		if (!preg_match($pattern, $field_list[$field_name])) $errors[$field_name] = 'Hanya menggunakan numerik';
	}
	function validateEmail(&$errors, $field_list, $field_name){ 
		$pattern = "/^[a-zA-Z0-9]+([\._][a-zA-Z0-9]+)?@[a-zA-Z0-9]+(\.[a-zA-Z0-9]+)+$/";
		if (!preg_match($pattern, $field_list[$field_name])) $errors[$field_name] = 'Format Email salah';
	}
	function validateAlnum(&$errors, $field_list, $field_name){ 
		$pattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/";
		if (!preg_match($pattern, $field_list[$field_name])) $errors[$field_name] = 'Password setidaknya memiliki satu huruf kapital (A-Z), huruf kecil (a-z), dan numerik (0-9)';
	}
	function validateLenRek(&$errors, $field_list, $field_name){ 
		$pattern = "/^\d{10,10}$/";
		if (!preg_match($pattern, $field_list[$field_name])) $errors[$field_name] = 'Nomor Rekening berupa 10 digit';
	}
	function validateLenTelp(&$errors, $field_list, $field_name){ 
		$pattern = "/^\d{10,13}$/";
		if (!preg_match($pattern, $field_list[$field_name])) $errors[$field_name] = 'Nomor Telepon berupa 10-13 digit';
	}
	function validateSame(&$errors, $field_list, $field_name_a, $field_name_b){ 
		$pattern = "/^$field_list[$field_name_a]$/";
		if (!preg_match($pattern, $field_list[$field_name_b])) $errors[$field_name_b] = 'Password salah';
	}
	
	function rupiah($nominal){
		$tmp='';$c=0;
		for ($i=strlen($nominal)-1; $i>=0; $i--){
			$c++;
			$tmp = $nominal[$i].$tmp;
			if ($c%3==0 & $i>0)
				$tmp = '.'.$tmp;
			
		}
		return "Rp. ".$tmp.",00";
	}
?>