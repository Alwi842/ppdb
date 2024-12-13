<?php 
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');

	if(@$_SESSION["admin_login"]==1) {
		header("location: dashboard.php");
	}
	require("includes/header.php");
?>
<head>
</head>
<body>

<div class="container">
	<div class="login-form">
		<div id="alert" onclick="alert_close()">
			<?php echo $control->pesan();?>
		</div>
		<form action="login-process" method="post">
			<h2 class="text-center">LOGIN ADMIN</h2>
			<div class="form-group">
				<input id="username" type="text" class="form-control" name="username" placeholder="USERNAME" required>
			</div>
			<div class="form-group">
				<input id="password" type="password" class="form-control" name="password" placeholder="password" required>
			</div>
			<div class="form-group">
				<button name="login"type="submit" class="btn btn-block bg-green" style="background-color: #33cc33; color:white;">LOG IN</button>
			</div>       
		</form>
	</div>
</div>

<?php require("includes/footer.php"); ?>
</body>
</html>