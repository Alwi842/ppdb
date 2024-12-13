<?php 
	session_start();
	require('../includes/control.php');
	require('../includes/login.php');
	$conn=$connection->getConnection();
	
	//verify
	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	if ($login->verification($_POST['verifikasi'])) {
		echo "salah";
		$pesan = '<div class="alert alert-danger">
				  <strong>Kode verifikasi salah!</strong>
				  </div>';
		$_SESSION["pesan"] = $pesan;
		header("location: buat-user");
		exit;
	}
	
	//init
	//salting
	$password=$_POST['password'];
	$costFactor = 12;
	$hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => $costFactor]);

	$username = $control->filder_sanitize_string($conn, $_POST['username']);	
	if ($login->checkUsernameExists($conn, $username)) {
		$_SESSION["pesan"] =  '<div class="alert alert-danger">The username "' . $username . '" is already taken.</div>';
		header("location: buat-user");
		echo "dua";
	}
	$nama = $control->filder_sanitize_string($conn, $_POST['nama']);
	$jabatan = $control->filder_sanitize_string($conn, $_POST['jabatan']);
	
	$stmt = $conn->prepare('INSERT INTO admin (nama, username, password, jabatan) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('ssss', $nama, $username, $hashedPassword, $jabatan);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($stmt->error) {
		$pesan = '<div class="alert alert-danger">
				  <strong>User gagal ditambah!</strong>
				  </div>';
		$_SESSION["pesan"] = $pesan;
		header("location: buat-user");
		exit;
	}
		$pesan = '<div class="alert alert-success">
				  <strong>User berhasil Ditambah!</strong>
				  </div>';
		$_SESSION["pesan"] = $pesan;
		header("location: buat-user");
		exit;
	

/*

	$enteredPassword = 'mypassword';
	$hashedPassword = '...'; // This is the hashed password that is stored in the database.

	$isPasswordCorrect = password_verify($enteredPassword, $hashedPassword);

	if ($isPasswordCorrect) {
	  // The password is correct.
	} else {
	  // The password is incorrect.
	}
*/