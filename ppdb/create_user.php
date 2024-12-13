<?php 
	session_start();
	require('includes/control.php');
	require('includes/login.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');

	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	
	require("includes/header.php");
?>
<body>
<header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">CREATE USER</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>
<div class="container">
<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>

<section class="testing">
	<form action="process-create-user" method="post" enctype="multipart/form-data">
	<input id="kode_pendaftaran" name="kode_pendaftaran" type="text" value="<?php echo $kode_pendaftaran?>" hidden></input>
	<div class="container px-4 my-5">
		<div class="collapse multi-collapse show" id="satu">
			<div class="shadow">
				<div class="p-4 bg-light rounded-3">
					<table class="" style="width: 100%" id="input1">
						<tbody>
							<tr><td style="width: 16%">Username</td>
							<td><input class="form-control" required id="username" name="username" type="text" maxlength="50" placeholder="Username" style="width: 100%"></td></tr>
							
							<tr><td>Password</td>
							<td> <input class="form-control" required id="password" name="password" type="password" maxlength="50" placeholder="Password" style="width: 100%"></td></tr>
							
							<tr><td>Nama</td>
							<td> <input class="form-control" required id="nama" name="nama" type="text" maxlength="50" placeholder="Nama" style="width: 100%"></td></tr>
							
							<tr><td>Jabatan</td>
							<td>
								<select class="form-select" required id="jabatan" name="jabatan" style="width: 100%">
									<option value="" selected="" hidden="">-</option>
									<option value="panitia">panitia</option>
									<option value="admin">admin</option>
							</select>
							</td></tr>
							
							<tr><td>Verifikasi</td>
							<td> <input class="form-control" required id="verifikasi" name="verifikasi" type="text" maxlength="50" placeholder="Kode ferifikasi" style="width: 100%"></td></tr>
						</tbody>
					</table>
				</div>
			</div>
			<button name="login"type="submit" class="btn btn-block" style="background-color: #33cc33; color:white;">Create</button>
		</div>
		 
	</div>
	</form>
</section>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>

