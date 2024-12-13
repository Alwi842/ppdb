<?php
session_start();
require("../includes/connect.php");
$conn = $connection->getConnection();

$username = @$_POST['username'];
$stmt = $conn->prepare("SELECT password, jabatan, nama FROM admin WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

if (!$data) {
	$pesan = '<div class="alert alert-danger">
			  <strong>Username/Password admin salah!</strong>
			  </div>';

	$_SESSION["pesan"] = $pesan;
	echo "gagal";
	header("location: login");
} else {
	$password = @$_POST['password'];
	$isPasswordCorrect = password_verify($password, $data[0]['password']);
	if ($isPasswordCorrect) {
		$_SESSION["password"] = $password;
		$_SESSION["username"] = $username;
		$_SESSION["admin_login"] = 1;
		$_SESSION["jabatan"]=$data[0]['jabatan'];
		$pesan = '<div class="alert alert-success">
			  <strong>Selamat datang, ' . $data[0]["nama"] . '!</strong>
			  </div>';
		$_SESSION["pesan"] = $pesan;
		echo "Berhasil";
		header("location: dashboard");
	} else {
	  $pesan = '<div class="alert alert-danger">
			  <strong>Username/Password admin salah!</strong>
			  </div>';
		echo "gagal";
		$_SESSION["pesan"] = $pesan;
		header("location: login");
	}
}
?>