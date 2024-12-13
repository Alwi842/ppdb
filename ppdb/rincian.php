<?php 
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();
	
	@$setting=$control->cek_ppdb_settings($conn, "*");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	
	require("includes/header.php");
	$kode_bayar_plus=@$setting[0]['kode_bayar_plus'];
	$kode_bayar_reg=@$setting[0]['kode_bayar_reg'];
	$bayar_plus=$control->cek_bayar($conn, $kode_bayar_plus);
	$rincian_plus=$control->cek_rincian($conn, $kode_bayar_plus);
	$bayar_reg=$control->cek_bayar($conn, $kode_bayar_reg);
	$rincian_reg=$control->cek_rincian($conn, $kode_bayar_reg);
	
?>
<header class="bg-green ">
	<div class="container">
		<h3 class=" text-white text-center"><b>PERINCIAN BIAYA PPDB (PENERIMAAN PESERTA DIDIK BARU)</b></h3>
	    <h3 class=" text-white text-center"><b>SMP ISLAMIC CENTRE TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></b></h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>

<section class="py-5">
	<div class="bg-light">
		<div class="container mb-2">
			<p >I. UANG PANGKAL KELAS REGULER</p>
			<table class="table">
			  <thead>
				<tr>
				  <th scope="col">No</th>
				  <th scope="col" class="table-small">Kelas VII Reguler</th>
				  <th scope="col">Biaya</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$no=1;
					foreach ($rincian_reg as $key => $value){
				?>
				<tr>
				  <th scope="row"><?php echo $no++; ?></th>
				  <td><?php echo $value['nama_bayar']; ?></td>
				  <td><?php echo "Rp. ".number_format($value['jumlah_bayar'] , 0, ',', '.');?></td>
				</tr>
				<?php
					}
				?>
				<tr>
				  <th scope="row" colspan="2" style="text-align: center;">Total</th>
				  <td><b><?php echo "Rp. ".number_format($bayar_reg[0]['jumlah_bayar'] , 0, ',', '.');?></b></td>
				</tr>
			  </tbody>
			</table>

			<p >Catatan :</p>
			<ul>
				<li>Belum Termasuk Biaya Ujian Tengah Semester/Semester Setahun 4 Kali @Rp. 125.000/Ujian</li>
				<li>Biaya Ujian dibayar pada saat pelaksanaan ujian</li>
			</ul>
			<p >II. UANG PANGKAL KELAS PLUS</p>
			<table class="table">
			  <thead>
				<tr>
				  <th scope="col">No</th>
				  <th scope="col" class="table-small">Kelas VII Reguler</th>
				  <th scope="col">Biaya</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
					$no=1;
					foreach ($rincian_plus as $key => $value){
				?>
				<tr>
				  <th scope="row"><?php echo $no++; ?></th>
				  <td><?php echo $value['nama_bayar']; ?></td>
				  <td><?php echo "Rp. ".number_format($value['jumlah_bayar'] , 0, ',', '.');?></td>
				</tr>
				<?php
					}
				?>
				<tr>
				  <th scope="row" colspan="2" style="text-align: center;">Total</th>
				  <td><b><?php echo "Rp. ".number_format($bayar_plus[0]['jumlah_bayar'] , 0, ',', '.');?></b></td>
				</tr>
			  </tbody>
			</table>

			<p >Catatan : Sudah termasuk biaya Ujian-ujian</p>
			<p >TEKNIS PEMBAYARAN</p>
			<ol type="1" start="1">
				<li>PEMBAYARAN PERTAMA SEKURANG KURANGNYA</li>
			</ol>

			<table class="table">
			  <thead>
				<tr>
				  <th scope="col">GEL</th>
				  <th scope="col">PERIODE</th>
				  <th scope="col">KELAS REGULER</th>
				  <th scope="col">KELAS PLUS</th>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <th scope="row">I</th>
				  <td><?php echo $control->bulan($setting[0]['gel1']); ?> - <?php echo $control->bulan($setting[0]['gel1_end']); ?></td>
				  <td><?php echo "Rp. ".number_format($setting[0]['min_gel1'] , 0, ',', '.');?></td>
				  <td><?php echo "Rp. ".number_format($setting[0]['min_gel1_plus'] , 0, ',', '.');?></td>
				</tr>
				<tr>
				  <th scope="row">II</th>
				  <td><?php echo $control->bulan($setting[0]['gel2']); ?> - <?php echo $control->bulan($setting[0]['gel2_end']); ?></td>
				  <td><?php echo "Rp. ".number_format($setting[0]['min_gel2'] , 0, ',', '.');?></td>
				  <td><?php echo "Rp. ".number_format($setting[0]['min_gel2_plus'] , 0, ',', '.');?></td>
				</tr>
				<tr>
				  <th scope="row">III</th>
				  <td><?php echo $control->bulan($setting[0]['gel3']); ?> - <?php echo $control->bulan($setting[0]['gel3_end']); ?></td>
				  <td><?php echo "Rp. ".number_format($setting[0]['min_gel3'] , 0, ',', '.');?></td>
				  <td><?php echo "Rp. ".number_format($setting[0]['min_gel3_plus'] , 0, ',', '.');?></td>
				</tr>
			  </tbody>
			</table>

			<ol type="1" start="2">
				<li>Bagi yang membayar LUNAS dikenakan potongan Biaya Sebesar Rp. 500.000</li>
				<li>Bagi siswa yang kakaknya masih di SMP Islamic Centre dikenakan potongan Rp. 500.000</li>
				<li>Bagi Anak Yatim/Kurang Mampu dikenakan potongan DSP 50% (Khusus Kelas Reguler)</li>
				<li>Bagi Anak Pendidik/tenaga Kependidikan dikenakan potongan Rp. 500.000</li>
				<li>Bagi Siswa Berprestasi O2SN/FLS2N dikenakan Potongan Rp. 500.000</li>
			</ol>
		</div>
	</div>
</section>
<?php require "includes/footer.php"; ?>