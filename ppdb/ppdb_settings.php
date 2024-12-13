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
	
	$bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli" , "Agustus", "September", "Oktober", "November", "Desember");
	$tahun_ajar=@$_GET['tahun_ajar'];
	if (@$_GET['setting']!=1) {
		$data=$control->cek_ppdb_settings($conn, "*");
		$reguler=$control->cek_bayar($conn, @$data[0]['kode_bayar_reg']);
		$plus=$control->cek_bayar($conn, @$data[0]['kode_bayar_plus']);
	} else {
		$data=$control->settings_ppdb($conn, $tahun_ajar);
		$list_reg=$control->cek_bayar_setting($conn, "reguler");
		$list_plus=$control->cek_bayar_setting($conn, "plus");
	}
	if ($data && @$_GET['setting']!=1) $tahun_ajar=@$data[0]['tahun_ajar'];
	require("includes/header.php");
?>
<script>
function ppdb_settings(){
	var tahun = document.getElementById("tahun_ajar").value
	window.location.replace("pengaturan-ppdb?setting=1&tahun_ajar="+tahun);
}
</script>

<body>
<header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">PENGATURAN PPDB</h3>
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
			<input id="setting" name="setting" value=1 hidden>
				<div class="row">
					<div class="col-sm">
						<label class="col-form-label" for="tahun_ajar" >Tahun Ajar</label> 
					</div>
					<div class="col-6">
						<select class="form-select flex" id="tahun_ajar" name="tahun_ajar" <?php if (@$_GET['setting']==1) echo "onchange='ppdb_settings()'" ?> required>
								<?php
									for ($i=2022;$i<=2040;$i++) {
										if (@$tahun_ajar==$i) {
											echo '<option value="'.$i.'" selected>'.$i.'/'.($i+1).'</option>';
										} else {
											echo '<option value="'.$i.'">'.$i.'/'.($i+1).'</option>';
										}
									}
								?>
						</select>
					</div>
					<div class="col">
						<button class="btn btn-info text-white" >Atur</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<div class="container">

	<?php if(@$_GET['setting']==1 || $data) { ?>
		<form method="POST" action="process-settings">
		<input id="tahun_ajar" name="tahun_ajar" value=<?php echo $tahun_ajar; ?> hidden>
		<table class="table">
		<tbody>
		<tr>
			<td width=1>Gelombang 1</td>
			<td width=1>:</td>
			<td >Dari 
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex"id="gel1" name="gel1" style="width: 100%" required>
					<?php
						for ($i=1;$i<=12;$i++) {
							if ($data[0]['gel1']==$i){
								echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
							} else echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
						}
					?>
				</select>
				<?php } else echo $bulan[$data[0]['gel1']-1]; ?>
			</td>
			<td>Sampai
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex" id="gel1_end" name="gel1_end" style="width: 100%" required>
					<?php
						for ($i=1;$i<=12;$i++) {
							if ($data[0]['gel1_end']==$i){
								echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
							} else echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
						}
					?>
				</select>
				<?php } else echo $bulan[$data[0]['gel1_end']-1];?>
			</td>
		</tr>
		<tr>
			<td>Gelombang 2</td>
			<td>:</td>
			<td >Dari
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex" id="gel2" name="gel2" style="width: 100%" required>
					<?php
						for ($i=1;$i<=12;$i++) {
							if ($data[0]['gel2']==$i){
								echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
							} else echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
						}
					?>
				
				</select>
				<?php } else echo $bulan[$data[0]['gel2']-1]; ?>
			</td>	
			<td>Sampai
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex" id="gel2_end" name="gel2_end" style="width: 100%" required>
					<?php
						for ($i=1;$i<=12;$i++) {
							if ($data[0]['gel2_end']==$i){
								echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
							} else echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
						}
					?>
				</select>
				<?php } else echo $bulan[$data[0]['gel2_end']-1]; ?>
			</td>
		</tr>
		<tr>
			<td>Gelombang 3</td>
			<td>:</td>
			<td >Dari
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex" id="gel3" name="gel3" style="width: 100%" required>
					<?php
						for ($i=1;$i<=12;$i++) {
							if ($data[0]['gel3']==$i){
								echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
							} else echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
						}
					?>
				</select>
				<?php } else echo $bulan[$data[0]['gel3']-1]; ?>
			</td>
			<td>Sampai
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex" id="gel3_end" name="gel3_end" style="width: 100%" required>
					<?php
						for ($i=1;$i<=12;$i++) {
							if ($data[0]['gel3_end']==$i){
								echo '<option value="'.$i.'" selected>'.$bulan[$i-1].'</option>';
							} else echo '<option value="'.$i.'">'.$bulan[$i-1].'</option>';
						}
					?>
				</select>
				<?php } else echo $bulan[$data[0]['gel3_end']-1]; ?>
			</td>
		</tr>
		<tr>
		<td>Pembayaran Kelas Reguler</td>
			<td>:</td>
			<td colspan=2 >
				<?php if (@$_GET['setting']==1) {?>
				<select class="form-select flex" id="kode_bayar_reg" name="kode_bayar_reg" style="width: 100%"  required>
						<?php
							for ($i=0;$i<count(@$list_reg);$i++) {
								if (@$list_reg[$i]['kode_bayar']==$data[0]['kode_bayar_reg']) {
									echo '<option value="'.@$list_reg[$i]['kode_bayar'].'" selected>'.@$list_reg[$i]['kode_bayar'].': Rp. '.@$list_reg[$i]['jumlah_bayar'].'</option>';
								} else {
									echo '<option value="'.@$list_reg[$i]['kode_bayar'].'">'.@$list_reg[$i]['kode_bayar'].' : Rp. '.@$list_reg[$i]['jumlah_bayar'].'</option>';
								}
							}
						?>
				</select>
				<?php } else echo $reguler[0]['kode_bayar']." - Rp. ".$reguler[0]['jumlah_bayar']?>
			</td>
		</tr>
		<td>Pembayaran Kelas Plus</td>
			<td>:</td>
			<td colspan=2>
				<?php if (@$_GET['setting']==1) { ?>
				<select class="form-select flex" id="kode_bayar_plus" name="kode_bayar_plus" style="width: 100%"  required>
						<?php
							for ($i=0;$i<count(@$list_plus);$i++) {
								if (@$list_plus[$i]['kode_bayar']==$data[0]['kode_bayar_plus']) {
									echo '<option value="'.@$list_plus[$i]['kode_bayar'].'" selected>'.@$list_plus[$i]['kode_bayar'].': Rp. '.@$list_plus[$i]['jumlah_bayar'].'</option>';
								} else {
									echo '<option value="'.@$list_plus[$i]['kode_bayar'].'">'.@$list_plus[$i]['kode_bayar'].': Rp. '.@$list_plus[$i]['jumlah_bayar'].'</option>';
								}
							}
						?>
				</select>
				<?php } else echo $plus[0]['kode_bayar']." - Rp. ".$plus[0]['jumlah_bayar']?>
			</td>
		</tr>
		<tr>
			<td>Min Pembayaran Gel 1</td>
			<td>:</td>
			<td>Reguler 
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="min_gel1" name="min_gel1" type="number"  placeholder="Nilai" style="width: 100%" value="<?php echo $data[0]['min_gel1']; ?>" required>
			<?php } else echo $data[0]['min_gel1']; ?>
			</td>
			<td>Plus
				<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="min_gel1_plus" name="min_gel1_plus" type="number" step="1"  placeholder="Nilai" style="width: 100%" value="<?php echo $data[0]['min_gel1_plus']; ?>" required>
				<?php } else echo $data[0]['min_gel1_plus']; ?>
			
			</td>
		</tr>
		<tr>
			<td>Min Pembayaran Gel 2</td>
			<td>:</td>
			<td>Reguler 
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="min_gel2" name="min_gel2" type="number" step="1"  placeholder="Nilai" style="width: 100%" value="<?php echo $data[0]['min_gel2']; ?>" required>
			<?php } else echo $data[0]['min_gel2']; ?>
			</td>
			<td>Plus
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control"id="min_gel2_plus" name="min_gel2_plus" type="number" step="1"  placeholder="Nilai" style="width: 100%" value="<?php echo $data[0]['min_gel2_plus']; ?>" required>
			<?php } else echo $data[0]['min_gel2_plus']; ?>
			
			</td>
		</tr>
		<tr>
			<td>Min Pembayaran Gel 3</td>
			<td>:</td>
			<td>Reguler 
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="min_gel3" name="min_gel3" type="number" step="1"  placeholder="Nilai" style="width: 100%" value="<?php echo $data[0]['min_gel3']; ?>" required>
			<?php } else echo $data[0]['min_gel3']; ?>
			</td>
			<td>Plus
			<?php if (@$_GET['setting']==1) { ?>
				<input class="form-control" id="min_gel3_plus" name="min_gel3_plus" type="number" step="1"  placeholder="Nilai" style="width: 100%" value="<?php echo $data[0]['min_gel3_plus']; ?>" required>
			<?php } else echo $data[0]['min_gel3_plus']; ?>
			</td>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	
	<div class="pt2 pb2 horizontal-thin" ></div>
		<h3 align=center >Pengaturan Pengumuman</h3>
		<table class="table">
		<thead>
		<tr>
			<td width=1>Text Pengumuman</td>
			<td width=1>:</td>
			<td colspan="2">
			<?php 
			if (@$_GET['setting']==1) { ?>
				<textarea class="form-control" id="pengumuman" name="pengumuman" type="Text" placeholder="Text" style="width: 100%"> <?php echo @$data[0]['pengumuman']; ?> </textarea ></td>
			<?php } else echo $data[0]['pengumuman']; ?>
			
		</tr>
		<tr>
			<td>Status</td>
			<td>:</td>
			<td>
			<?php if (@$_GET['setting']==1) { ?>
				<?php if (@$data[0]['status_pengumuman']!=1) { ?>
					<input class="form-check-input" id="status_pengumuman1" name="status_pengumuman" type="radio" value="0" checked>
				<?php } else echo '<input class="form-check-input" id="status_pengumuman1" name="status_pengumuman" type="radio" value="0">';?>
				<p>Non-aktif
				</td>
				<td>
				<?php if (@$data[0]['status_pengumuman']==1) { ?>
					<input class="form-check-input" id="status_pengumuman2" name="status_pengumuman" type="radio" value="1" checked>
				<?php } else echo '<input class="form-check-input" id="status_pengumuman2" name="status_pengumuman" type="radio" value="1" >'; ?><p>Aktif
			<?php } else {
				if (@$data[0]['status_pengumuman']==1) {
					echo "Aktif";
				} else echo "Non-aktif";
			}
			?>
			</td>
		</tr>
		</tbody>
	</table>
	<?php if (@$_GET['setting']==1) { ?>
	<div class="pt2 pb2 horizontal-thin"></div>
	<div align=center >
		<a class="btn btn-danger text-white" type="submit" name="update_button" href="ppdb_settings.php" value="kembali">kembali</a>
		<input class="btn btn-success text-white" type="submit" name="update_button" value="simpan"/>
		<input class="btn btn-info text-white" type="submit" name="update_button" value="simpan & terapkan"/>
	</div>
	<?php } ?>
	</form>
	<?php 
	}
	?>
</div>
<?php require "includes/footer.php"; ?>
</body>
</html>