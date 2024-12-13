<?php 
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
	
	if (@$_GET['kode_bayar']=="tambah" || @!$_GET['kode_bayar']) $data=$control->cek_bayar($conn, "all");
	if (@$_GET['kode_bayar']!="tambah" && @$_GET['kode_bayar']) {
		$data=$control->cek_bayar($conn, "all");
		$data2=$control->cek_bayar($conn, $_GET['kode_bayar']);
	} else if (@$_GET['kode_bayar']!="tambah") {
		$data2=$data;
	} 
		if (@$data2[0]['kode_bayar']) $rincian=$control->cek_rincian($conn, $data2[0]['kode_bayar']);
	if ($data && @$_GET['setting']!=1) $tahun_ajar=@$data[0]['tahun_ajar'];
	if (!@$rincian) $rincian=array();
	require("includes/header.php");
?>
<script>
function get_bayar(){
	var kode_bayar = document.getElementById("kode_bayar").value;
	window.location.replace("input_pembayaran.php?kode_bayar="+kode_bayar);
}
</script>
<body <?php if (@$_GET['setting']==1) ?> onload="rincian_total()">
<header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">PENGATURAN PEMBAYARAN PPDB</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>
<section>
	<div class="container px-4 my-5">
		<div class="shadow p-4 bg-light rounded-3">
			<form method="GET">
		<table style="width: 100%">
			<thead>
			<tr>
				<td>kode bayar</td>
				<td>
				<?php
				if (@$_GET['setting']!=1) {
				?>
				<input class="form-control" id="setting" name="setting" value=1 hidden>
				<select class="form-select" id="kode_bayar" name="kode_bayar" style="width: 100%" onchange="get_bayar()"required>
						<?php
						foreach ($data as $var) {
							if (@$_GET['kode_bayar']==$var['kode_bayar']) {
								echo '<option value="'.$var['kode_bayar'].'" selected>'.$var['kode_bayar'].'</option>';
							} else echo '<option value="'.$var['kode_bayar'].'">'.$var['kode_bayar'].'</option>';
						}
						if (@$_GET['kode_bayar']=="tambah") {
							echo '<option value="tambah" selected>+ Tambah</option>';
						} else echo '<option value="tambah" >+ Tambah</option>';
						?>
				</select>
				</td>
				<td style="width: 15%">
				<a class="btn btn-danger text-white" id="hapus" 
				<?php echo "href='proses_input_pembayaran.php?";
				if (!@$_GET['kode_bayar']) {
					echo "action=hapus&kode_bayar=".$data[0]['kode_bayar'];
				} else {
					echo "action=hapus&kode_bayar=".$_GET['kode_bayar'];
				}
				echo "'";
				?>">Hapus</a>
				<button class="btn btn-info text-white" >Atur</button>
				<?php
				} else if (@$_GET['kode_bayar']!="tambah") {
					echo @$_GET['kode_bayar'];
				} else echo "tambah bayar";
				?>
				</td>
			</tr>
			</thead>
		</table>
		</form>
		</div>
	</div>
</section>

<section>
	<div class="container px-4 my-5">
		<div class="shadow p-4 bg-light rounded-3">
			<?php if((@$_GET['setting']==1 || $data) && !(@$_GET['setting']!=1 && @$_GET['kode_bayar']=="tambah")) { ?>
			<form method="POST" action="proses_input_pembayaran.php" style="width: 100%">
			<table style="width: 100%">
			<tbody>
			<tr>
				<?php echo '<input class="form-control" id="kode_bayar" name="kode_bayar" value="'.@$_GET['kode_bayar'].'" hidden>'; ?>
				<td style="height: 50px; width: 150px;">Nama Pembayaran</td>
				<td width=10>:</td>
				<td colspan="2"> 
					<?php if (@$_GET['setting']==1) { ?>
					<input class="form-control" id="nama_bayar" name="nama_bayar" type="text"  placeholder="Nama Pembayaran" style="width: 100%" value="<?php echo @$data2[0]['nama_bayar']; ?>" required>
					<?php } else echo @$data2[0]['nama_bayar']; ?>
				</td>
			</tr>
			<tr>
				<td>Jumlah Bayar</td>
				<td>:</td>
				<td colspan="2" > 
				<?php if (@$_GET['setting']==1) { ?>
					<input class="form-control" id="jumlah_bayar" name="jumlah_bayar" type="Number"  placeholder="Jumlah Bayar" style="width: 95%" value="<?php echo @$data2[0]['jumlah_bayar']; ?>" required>
					<?php } else echo @$data2[0]['jumlah_bayar']; ?>
				</td>
			</tr>
			<tr>
				<td>Untuk Kelas</td>
				<td> : </td>
				<?php if (@$_GET['setting']==1) { ?>
				<td>
					<?php if (@$data2[0]['target']=="reguler") { ?>
						<input class="form-check-input" id="target1" name="target" type="radio" value="reguler" checked>
					<?php } else echo '<input class="form-check-input" id="target" name="target" type="radio" value="reguler">';?>
					<label class="form-check-label" for="target2" >
						Reguler
					 </label>
					</td>
					<td>
					
					<?php if (@$data2[0]['target']=="plus") { ?>
						<input class="form-check-input" id="target2" name="target" type="radio" value="plus" checked>
					<?php } else echo '<input class="form-check-input" id="target" name="target" type="radio" value="plus">'; 
					?><label class="form-check-label" for="target2" >
						Plus
					 </label><?php
				} else { ?>
					<td colspan=2>
					<?php
					if (@$data[0]['target']=="reguler") {
						echo "Reguler";
					} else echo "Plus";
				}
				?>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		</div>
	</div>
</section>
<div class="row gx-5 justify-content-center">
			<div class="col-lg-8 col-xl-6">
				<div class="text-center">
					<h2 class="fw-bolder">Rincian Pembayaran</h2>
				</div>
			</div>
		</div>
<section>
	<div class="container px-4 my-5">
		<div class="shadow p-4 bg-light rounded-3">
		<table style="width: 100%">
		<tbody id="mytable">
		<?php
		if (@$rincian || @$_GET['setting']==1) {
			for ($i=0;$i<count(@$rincian);$i++) {
		?>
		<tr>
			<td style="height: 50px; width: 120px;">Nama Rincian</td>
			<td >:</td>
			<td>
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="rincian_nama_bayar<?php echo $i+1?>" name="rincian_nama_bayar<?php echo $i+1?>" type="text"  placeholder="Jumlah Bayar" style="width: 100%" value="<?php echo @$rincian[$i]['nama_bayar']; ?>" required>
			<?php } else echo @$rincian[$i]['nama_bayar']; ?>
			</td>
		</tr>
		<tr>
			<td>Harga</td>
			<td>:</td>
			<td>
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="jumlah_bayar<?php echo $i+1?>" name="jumlah_bayar<?php echo $i+1?>" type="Number"  placeholder="Jumlah Bayar" style="width: 100%" oninput="rincian_total()" value="<?php echo @$rincian[$i]['jumlah_bayar']; ?>" required>
			<?php } else echo @$rincian[$i]['jumlah_bayar']; ?>
			</td>
		</tr>
			<?php } } else echo "Tidak ada rincian";?>
		</tbody>
	</table>
	<?php if (@$_GET['setting']==1) { ?>
		<div class="pb2" align=center >
			<a class="btn btn-warning text-white" onclick="hapus_rincian()">-</a>
			<a class="btn btn-info text-white" onclick="tambah_rincian()">+</a>
			<div id="total">Total : Rp. 0</div>
		</div>
			<div class="pt2 pb2 horizontal-thin"></div>
			<div align=center >
			<a class="btn btn-danger text-white" type="submit" href="input_pembayaran.php" value="kembali">kembali</a>
			<input class="btn btn-success text-white" type="submit" value="simpan"/>
		</div>
	<?php } ?>
	</form>
	<?php 
	}
	?>
		</div>
	</div>
</section>
<?php require "includes/footer.php"; ?>
</body>
</html>