<?php 
    $location='print_pembayaran';
	session_start();
	require('includes/control.php');
	require('includes/login.php');
	$conn=$connection->getConnection();
	
	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	
	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');

	$kode_pendaftaran=$_SESSION["kode_pendaftaran"];
	$kode_pembayaran=$_SESSION["kode_pembayaran"];
	$riwayat=$control->cek_riwayat_pembayaran($conn, $kode_pendaftaran);
	$bayar=$control->cek_bayar($conn, $kode_pembayaran);
	$total=$riwayat[0]['bayar1']+$riwayat[0]['bayar2']+$riwayat[0]['bayar3']+$riwayat[0]['bayar4'];
	$sisa=$bayar[0]['jumlah_bayar']-$total;
	$siswa=$control->terima_siswa($conn, $kode_pendaftaran);
?>
<div hidden><?php require("includes/header.php"); ?></div>
<section class="py-5">
<div class="container">
	<div align=center>
		<div id="alert" onclick="alert_close()">
			<?php echo $control->pesan();?>
		</div>
		<a href="index.php" ><img src="img/logo-iscen.png" alt="Logo" width="100" href="index.php"></a>
			<h3 style="color: green; font-size: 18px;">SMP ISLAMIC CENTRE</h3>
			<h3 style="color: green; font-size: 18px;" >PENERIMAAN PESERTA DIDIK BARU</h3>
			<h3 style="color: green; font-size: 18px;" >TAHUN PENDIDIKAN 2023/2024</h3>
	</div>
<table>
	<tr>
		<td style='width: 15%;'>Nama </td>
		<td style='width: 1%;'> : </td>
		<td colspan=2><?php echo $siswa[0]['nama_siswa'];
		?></td>
	</tr>
	<tr>
		<td>Kode Pendaftaran</td>
		<td >:</td>
		<td><?php echo $siswa[0]['kode_pendaftaran']?></td>
		<td align="right" style="width: 100%;">Tanggal Pembayaran : <?php echo $riwayat[0]['tgl_bayar']?></td>
	</tr>
</table>
<div class='pb3'></div>
<div align=center>
	<table style='width: 100%;'>
	<tr>
		<td style='width: 90%;'>Uang Pendaftaran</td>
		<td>Rp. <?php echo $bayar[0]['jumlah_bayar']?></td>
	</tr>
	<tr>
		<td>Bayar</td>
		<td>Rp. <?php echo $total?></td>
	</tr>
	<tr class='horizontal'>
		<td>Sisa</td>
		<td>Rp. <?php echo $sisa?></td>
	</tr>
	</table>
</div>
<div align="right">
	<div class='pb3'></div>
	<div class='pb3'></div>
	<table>
	<tr>
		<td width=130>Hj. Lili Khoiriyah</td>
	</tr>
	</table>
	<div class='pb3'></div>
	<div class='pb3'></div>
	<div class='pb3'></div>
	<table >
	<tr class='horizontal-thin' style='width: 10%;'>
		<td width=130>Bendahara TU</td>
	</tr>
	</table>
</div>
<a id="back_btn" role="button" class="btn btn-secondary text-white" href="terima_siswa.php">kembali</a>
<a id="prin_btn" role="button" class="btn btn-info text-white" onclick="prin()">Print</a>
</div>
<script>
function prin(){
	document.getElementById("nav").hidden=true;
	document.getElementById("back_btn").hidden=true;
	document.getElementById("prin_btn").hidden=true;
	window.print();
	var x = setInterval(function() {
		clearInterval(x);
		document.getElementById("prin_btn").hidden=false;
		document.getElementById("back_btn").hidden=false;
		document.getElementById("nav").hidden=false;
	}, 1000);
}
</script>
</section>