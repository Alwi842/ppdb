<?php 
//$location='print_form';
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
	
	
	$kode_pendaftaran=$_GET["kode_pendaftaran"];
	$sql = "SELECT * FROM form_pendaftaran WHERE kode_pendaftaran = '$kode_pendaftaran'";
	$result = $conn -> query($sql);
	$data = $result -> fetch_all(MYSQLI_ASSOC);
	if(!$data) {
		$pesan = '<div class="alert alert-danger">
				  <strong>NIS tidak terdaftar!</strong>
				  </div>';
		$_SESSION["pesan"]=$pesan;
		header("location: beranda");
	}
	$orgDate = @$data[0]['tgl_lahir'];  
    $newDate = date("d-m-Y", strtotime($orgDate));
    
?>
<div hidden>
    <?php require("includes/header.php"); ?>
</div>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="container" id="main">
	<div id="alert" onclick="alert_close()">
		<?php echo $control->pesan();?>
	</div>
	<h3 align=center style="font-size: 100%;"><b>PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
	<h3 align=center style="font-size: 100%;"><b>TAHUN PELAJARAN <?php echo $tahun_ini."/".$tahun_ini+1 ?></h3>
	<?php
	if (!@$_GET['kode_pendaftaran']) {
	?>
	<form action="print_form.php" method="get" style="padding-bottom: 30px">
			<a class="text-center">kode siswa</a>	
				<input id="kode_pendaftaran" type="text" name="kode_pendaftaran" placeholder="KODE PENDAFTARAN">
				<button type="submit" style="background-color: #33cc33; color:white;">Cek</button>  
	</form>
	<?php } ?>
	<table>
		<?php
			if (@$_GET['kode_pendaftaran'] && $data) {
		?>
		<tbody>
		<tr><td style="width: 20%">Nama Peserta Didik</td><td style="width: 1%">:</td><td><?php echo $data[0]['nama_siswa'] ?></td></tr>
		<tr><td>Asal Sekolah</td><td>:</td><td><?php echo $data[0]['asal_sekolah']; ?></td></tr>
		<tr><td>NISN</td><td>:</td><td><?php echo $data[0]['NISN']; ?></td></tr>
		<tr><td>NIK</td><td>:</td><td><?php echo $data[0]['NIK']; ?></td></tr>
		<tr><td>Tmpt/Tgl Lahir</td><td>:</td><td><?php echo $data[0]['tmp_lahir'].", ".$newDate; ?></td></tr>
		<tr><td>Jenis Kelamin</td><td>:</td><td><?php if ($data[0]['jenis_kelamin']=="L") { echo "Laki-laki"; } else echo "Perempuan"; ?></td></tr>
		<tr><td>Agama</td><td>:</td><td><?php echo $data[0]['agama']; ?></td></tr>
		<tr><td>Anak Ke</td><td>:</td><td><?php echo $data[0]['anak_ke']; ?> | Dari - <?php echo $data[0]['anak_dari']; ?></td></tr>
		<tr><td>Nama Ayah Kandung</td><td>:</td><td><?php echo $data[0]['nama_ayah']; ?></td></tr>
		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $data[0]['pekerjaan_ayah'];; ?></td></tr>
		<tr><td>Penghasilan/Bulan</td><td>:</td><td><?php 
		echo $data[0]['penghasilan_ayah']; ?></td></tr>
		<tr><td>Usia</td><td>:</td><td><?php echo $data[0]['usia_ayah']; ?> Tahun | Tahun Lahir : <?php echo $data[0]['thn_lahir_ayah']; ?></td></tr>	
		<tr><td>Pendidikan</td><td>:</td><td><?php echo $data[0]['pendidikan_ayah']; ?></td></tr>
		<tr><td>Nama Ibu Kandung</td><td>:</td><td><?php echo $data[0]['nama_ibu']; ?></td></tr>
		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $data[0]['pekerjaan_ibu'];; ?></td></tr>
		<tr><td>Penghasilan/Bulan</td><td>:</td><td><?php 
		echo $data[0]['penghasilan_ibu']; ?></td></tr>
		<tr><td>Usia</td><td>:</td><td><?php echo $data[0]['usia_ibu']; ?> Tahun | Tahun Lahir : <?php echo $data[0]['thn_lahir_ibu']; ?></td></tr>
		<tr><td>Pendidikan</td><td>:</td><td><?php echo $data[0]['pendidikan_ibu']; ?></td></tr>
		<tr><td>Nama Wali</td><td>:</td><td><?php echo $data[0]['nama_wali']; ?></td></tr>
		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $data[0]['pekerjaan_wali'];; ?></td></tr>
		<tr><td>Penghasilan/Bulan</td><td>:</td><td><?php 
		echo $data[0]['penghasilan_wali']; ?></td></tr>
		<tr><td>Usia</td><td>:</td><td><?php echo $data[0]['usia_wali']; ?> Tahun | Tahun Lahir : <?php echo $data[0]['thn_lahir_wali']; ?></td></tr>	
		<tr><td>Pendidikan</td><td>:</td><td><?php echo $data[0]['pendidikan_wali']; ?></td></tr>
		<tr><td>Alamat</td><td>:</td><td><?php echo $data[0]['alamat_rumah']; ?></td></tr>
		<tr><td></td><td>:</td><td>RT : <?php echo $data[0]['alamat_rt']; ?> | RW : <?php echo $data[0]['alamat_rw'];; ?></td></tr>
		<tr><td>Kelurahan</td><td>:</td><td><?php echo $data[0]['kelurahan']; ?></td></tr>
		<tr><td>Kecamatan</td><td>:</td><td><?php echo $data[0]['kecamatan']; ?></td></tr>
		<tr><td>Kab/Kota</td><td>:</td><td><?php echo $data[0]['kab_kota']; ?></td></tr>
		<tr><td>Provinsi</td><td>:</td><td><?php echo $data[0]['provinsi']; ?></td></tr>
		<tr><td>Kode Pos</td><td>:</td><td><?php echo $data[0]['kode_pos']; ?></td></tr>
		<tr><td>No. Telp/HP</td><td>:</td><td><?php echo $data[0]['no_tlp']; ?></td></tr>
	</tbody>
	<?php } ?>
	</table>
</div>

</body>
</html>
<script>
window.print();
</script>