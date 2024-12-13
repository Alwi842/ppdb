<?php
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');

	$admin_login=@$_SESSION["admin_login"];
	require("includes/header.php");
	$folder=$_POST['submit'];
?>
 <header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">PETINJAU <?php echo strtoupper($folder); ?></h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>
            <section class="py-5" id="features">
                <div class="container px-5 my-5">
					<div class="preview">
					
<?php
	if (@$_POST['code']=="qTfo4m8ttouXtzA") {
		if ($folder=="ijazah"){
			$nama_file = $_POST['ijazah'];
		} else {
			$nama_file = $_POST['kk'];
		}
		if (!file_exists($folder . "/" . $nama_file)){
			$folder="ijazah";
			$nama_file="notfound.jpg";
		}
		// Dapatkan isi file gambar
		$isi_file = file_get_contents($folder . "/" . $nama_file);

		// Ubah isi file gambar menjadi format base64
		$base64 = base64_encode($isi_file);

		// Tampilkan gambar dalam format base64
		echo "<img src='data:image/jpg;base64," . $base64 . "'>";
	} else {
		$folder="ijazah";
		$nama_file="notfound.jpg";
		$isi_file = file_get_contents($folder . "/" . $nama_file);
		$base64 = base64_encode($isi_file);
		echo "<img src='data:image/jpg;base64," . $base64 . "'>";
		
	}
	if ($nama_file==="notfound.jpg") {
			echo "<p class='preview-caption h1'> Yah, data tidak ada... </p>";
		}
?>
		</div>
	</div>
	</section>
<?php require("includes/footer.php"); ?>