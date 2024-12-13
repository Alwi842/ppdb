<?php
	session_start();
	session_destroy();
	session_start();
	$pesan = '<div class="alert alert-danger"> <strong>Anda telah logout!</strong></div>';
	$_SESSION["pesan"] = $pesan;
	header("location: beranda");
?>