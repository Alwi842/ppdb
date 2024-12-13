<?php 
	session_start();
	require('includes/control.php');
	require('includes/login.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "*");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	
	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	
	unset($_SESSION['kode_pendaftaran']);
	unset($_SESSION['kode_pembayaran']);
	$kode_pendaftaran=@$_POST["kode_pendaftaran"];
	if ($kode_pendaftaran) { 
		$siswa=$control->terima_siswa($conn, $kode_pendaftaran);
		if ($siswa) {
			if ($siswa[0]['kelas']==1) {
				$kode_bayar=@$setting[0]['kode_bayar_plus'];
			} else {
				$kode_bayar=@$setting[0]['kode_bayar_reg'];
			}
			$riwayat=$control->cek_riwayat_pembayaran($conn, $kode_pendaftaran);
			if ($riwayat!=0){
				$kode_bayar=$riwayat[0]['kode_bayar'];
			}
			$bayar=$control->cek_bayar($conn, $kode_bayar);
		}
	}
	$min_bayar=0;
	if (@$riwayat==0) { 
		if ($bulan_ini>=@$setting[0]['gel1'] && $bulan_ini<=@$setting[0]['gel1']) {
			$gelombang=1;
		} else if ($bulan_ini>=@$setting[0]['gel2'] && $bulan_ini<=@$setting[0]['gel2']) {
			$gelombang=2;
		} else if ($bulan_ini>=@$setting[0]['gel2'] && $bulan_ini<=@$setting[0]['gel2']) {
			$gelombang=3;
		} else {
			$gelombang=4;
		}
	}  else if (@$riwayat!=0) {
		$gelombang=$riwayat[0]['gelombang'];
	}
	if ($gelombang==1) {
		$min_bayar=@$setting[0]['min_gel1'];
	} else if ($gelombang==2) {
		$min_bayar=@$setting[0]['min_gel2'];
	} else if ($gelombang==3) {
		$min_bayar=@$setting[0]['min_gel3'];
	} else if ($gelombang==4) {
		$min_bayar=100;
	}
	require("includes/header.php");
?>

<header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">TERIMA SISWA</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>
<section>
	<div class="container px-4 my-5">
		<div class="shadow p-4 bg-light rounded-3">
			<form action="terima-siswa" method="post">
				<div class="row">
					<div class="col-sm">
							<label class="col-form-label" for="kode_pendaftaran" >Kode Pendaftaran</label> 
					</div>
					<div class="col-6">
						<input  class="form-control flex" id="kode_pendaftaran" type="number" name="kode_pendaftaran" placeholder="KODE PENDAFTARAN" style="width: 100%">
					</div>
					<div class="col">
						<button type="submit" class="btn text-white bg-green">Cek</button> 
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php if(@$siswa) { ?>
<section>
	<div class="container px-4 my-5">
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-8 col-xl-6">
				<div class="text-center">
					<h2 class="fw-bolder">STATUS PENDAFTAR</h2>
				</div>
			</div>
		</div>
		<div class="shadow p-4 bg-light rounded-3 ">
			<table style="width: 100%;">
				<tbody>
					<tr>
						<td style="width: 16%">Nama</td>
						<td>:</td>
						<td ><?php echo @$siswa[0]['nama_siswa']; ?></td>
					</tr>
					<tr>
						<td>Kode Pendaftaran</td>
						<td>:</td>
						<td><?php echo @$siswa[0]['kode_pendaftaran']; ?></td>
					</tr>
					<tr>
						<td>Kelas</td>
						<td>:</td>
						<td><?php if (@$siswa[0]['kelas']==0) {
							echo "reguler";
						} else echo "plus"; ?></td>
					</tr>
					<tr>
						<td>Gelombang</td>
						<td>:</td>
						<td><?php echo $gelombang ?></td>
					</tr>
					<tr>
						<td>Status</td>
						<td>:</td>
						<td><?php 
							if (@$siswa[0]['status']==0) {
								?><strong style="color:red;">Belum Diterima</strong><?php
							} else if (@$siswa[0]['status']==1) {
								?><strong style="color:green;">Diterima</strong><?php
							} else if (@$siswa[0]['status']==2) {
								?><strong style="color:green;">Diterima dan Lunas</strong><?php
							}
						?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</section>
			
<?php } else { ?>
	<div class="pt2 pb3" align=center>
		<a class='alert alert-danger'>
		<strong>Masukkan Kode Pendaftaran</strong>
		</a>
	</div>
<?php  } ?>
	<?php if(@$siswa) { ?>
<section>
	<div class="container px-4 my-5">
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-8 col-xl-6">
				<div class="text-center">
					<h2 class="fw-bolder">INPUT PEMBAYARAN</h2>
				</div>
			</div>
		</div>
		<div class="shadow p-4 bg-light rounded-3 ">
		<form action="proses-terima-siswa" method="post">
			<input name="kode_pendaftaran" value="<?php echo $kode_pendaftaran?>" hidden></input>
				<input name="kode_bayar" value="<?php echo $bayar[0]['kode_bayar']?>" hidden></input>
				<input name="gelombang" value="<?php echo $gelombang ?>" hidden></input>
				<table style="width: 100%;">
				<tr>
					<td style="width: 13%;">Uang Pendaftaran</td>
					<td>:</td>
					<td>Rp. <?php 
					echo $bayar[0]['jumlah_bayar']; 
					?></td>
				</tr>
				<tr>
					<td>Min Bayaran</td>
					<td>:</td>
					<td>Rp. <?php echo @$min_bayar; ?></td>
				</tr>
				
				<tr>
					<td>Bayar 1</td>
					<td>:</td>
					<td><input class="form-control" id="jml_bayar1" type="number" name="jml_bayar1" <?php 
					if ($riwayat==0) { 
						echo"value='".$bayar[0]['jumlah_bayar']."'";
					}	else if ($riwayat!=0)
						echo "value='".$riwayat[0]['bayar1']."'";
					?> placeholder="Rp." oninput="rincian_total()"></td>
				</tr>
				<tr>
					<td>Bayar 2</td>
					<td>:</td>
					<td><input class="form-control" id="jml_bayar2" type="number" name="jml_bayar2" <?php 
					if ($riwayat==0) { 
						echo"value='0'";
					}	else if ($riwayat!=0)
						echo "value='".$riwayat[0]['bayar2']."'";
					?> placeholder="Rp." oninput="rincian_total()"></td>
				</tr>
				<tr>
					<td>Bayar 3</td>
					<td>:</td>
					<td><input class="form-control" id="jml_bayar3" type="number" name="jml_bayar3" <?php 
					if ($riwayat==0) { 
						echo"value='0'";
					}	else if ($riwayat!=0)
						echo "value='".$riwayat[0]['bayar3']."'";
					?> placeholder="Rp." oninput="rincian_total()"></td>
				</tr>
				<tr>
					<td>Bayar 4</td>
					<td>:</td>
					<td><input class="form-control" id="jml_bayar4" type="number" name="jml_bayar4" <?php 
					if ($riwayat==0) { 
						echo"value='0'";
					}	else if ($riwayat!=0)
						echo "value='".$riwayat[0]['bayar4']."'";
					?>  placeholder="Rp." oninput="rincian_total()"></td>
				</tr>
				<tr>
					<td>Jumlah bayar</td>
					<td>:</td>
					<td id="jumlah_bayar">Rp. <?php 
					$tmp=$bayar[0]['jumlah_bayar'];
					if ($riwayat==0) {
						echo $tmp;
					} else {
						$tmp=0;
						for ($i=0;$i<4;$i++) @$tmp=@$tmp+@$riwayat[0]['bayar'.$i];
						echo @$tmp;
					}?> </td>
				</tr>
				<tr>
					<td>Sisa</td>
					<td>:</td>
					<td id="sisa_bayar">Rp. <?php echo $bayar[0]['jumlah_bayar']-$tmp; ?></td>
				</tr>
				</table>
				
				<input name="ID" value="1" hidden>
				<a type="button" class="btn bg-green text-white" data-toggle="modal" data-target="#exampleModal" onclick="jumlahbayar()">
				  Input
				</a>
				
				<!-- Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Jumlah pembayaran</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body" id='preview_bayar'>
						Rp. <?php 
						$tmp=$bayar[0]['jumlah_bayar'];
						if ($riwayat==0) {
							echo $tmp;
							} else {
								$tmp=0;
								for ($i=0;$i<4;$i++) @$tmp=@$tmp+@$riwayat[0]['bayar'.$i];
								echo @$tmp;
							}?>
					  </div>
					  <div class="modal-footer">
						<a type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</a>
						<button type="Submit" style="background-color: #33cc33; color:white;" class="btn btn-primary">Input</button>
					  </div>
					</div>
				  </div>
				</div>
			</form>
			<input id="temp" value='<?php echo $bayar[0]['jumlah_bayar']; ?>' hidden>
		</div>
	</div>
</section>
	<?php } require "includes/footer.php"; ?>