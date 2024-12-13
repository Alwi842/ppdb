<?php 
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();
	
	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	$data=false;
	$kode_pendaftaran=@$_POST["kode_pendaftaran"];
	if ($_SESSION['daftar']==1) {
		$kode_pendaftaran=@$_GET["kode_pendaftaran"];
	}
	if ($kode_pendaftaran) $data=$control->cek_pendaftaran($conn, $kode_pendaftaran);	
	require("includes/header.php");
?>
 <header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">CEK PENDAFTARAN SISWA</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>
<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan(); ?>
</div>
<section class="py-5">
	<div class="bg-light">
		<div class="container mb-2">
			<div class="shadow">
				<div class="p-4 bg-light rounded-3">
					<form action="cek-pendaftaran" method="post">
						<div class="row">
							<div class="col-sm">
									<label class="col-form-label" for="kode_pendaftaran">Kode Siswa</label> 
							</div>
							<div class="col-7">
								<input class="form-control" id="kode_pendaftaran" type="text" name="kode_pendaftaran" placeholder="KODE PENDAFTARAN" required> 
							</div>
							<div class="col">
								<button type="submit" class="btn" style="background-color: #33cc33; color:white;">Cek</button> 
							</div>
						</div>
					</form>
					<hr></hr>
					<form action="print-pendaftaran" method="post">
						<h3 class="text-center">STATUS PENDAFTARAN SISWA</h3>
					<?php if ($data) { ?>
						
						<p>Nama : <?php echo $data[0]['nama_siswa']; ?></p>
						<p>Kode Pendaftar : <?php echo $data[0]['kode_pendaftaran']; ?></p>
						<p>Status : <?php $control->status($data[0]['status']);
							?></a>
						<div class="form-group">
							<a name="login"type="submit" class="btn btn-block" onclick="print_pendaftaran('<?php echo $data[0]['nama_siswa']; ?>', '<?php echo $data[0]['kode_pendaftaran']; ?>')" style="background-color: #33cc33; color:white; cursor: pointer;">print</a>
							<a name="login"type="submit" class="btn btn-block" style="background-color: #CF0A0A; color:white;" href='beranda'>Home</a>
						</div> 
						<?php } else { ?>
							<div class="alert alert-danger">
							  <strong>Harap isi kode pendaftaran!</strong>
							</div>
						<?php } ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include("includes/footer.php"); ?>