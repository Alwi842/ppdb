<?php 
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];

	require("includes/header.php");
?>
 <header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">Alur Pendaftaran</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>

<section class="py-5">
	<div class="bg-light">
		<div class="container mb-2">
			<div class="row bg-white">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/cop.png" ></img>
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					<p class="fw-bolder h3">PENERIMAAN PESERTA DIDIK BARU (PPDB)</p>
					<p class="fw-bolder h3">SMP ISLAMIC CENTRE TANGERANG</p>
					<p class="text-danger fw-bolder h3">Alur Pendaftaran</p>
				</div>
			</div>
			<div class="row bg-orange">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step1.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  01
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Calon Peserta didik baru <u>menyiapkan berkas </u>persyaratan
				</div>
			</div>
			
			<div class="row bg-blue">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step2.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  02
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Calon Peserta didik baru mengakses laman situs PPDB Online <a href="beranda">ppdb.smpiscen.sch.id</a>
				</div>
			</div>
			
			<div class="row bg-orange">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step3.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  03
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Calon peserta didik baru melakukan <u> pengajuan pendaftaran</u> dengan mengisi formulir secara online.
				</div>
			</div>
			
			<div class="row bg-blue">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step4.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  04
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Calon peserta didik baru  <u> mengunggah / upload </u> dokumen persyaratan.
				</div>
			</div>
			
			<div class="row bg-orange">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step5.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  05
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Calon peserta mendapatkan kode pendaftaran.
				</div>
			</div>
			
			<div class="row bg-blue">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step6.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  06
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					<p>Calon peserta melakukan pembayaran di TU (Tata Usaha) SMP Islamic Centre Tangerang</p>
					<p>ATAU</p>
					<p>Transfer ke rekening BTN Nomor : 0051001550000054 AN SMP Yayasan Islamic Centre(Bukti Transfer Dikirim ke WA : 0812 1934 6366)</p>
				</div>
			</div>
			
			<div class="row bg-orange">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step7.png"></img>
						</div>
						<div class="fw-bolder display-4">
						  07
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Operator Sekolah melakukan penerimaan pendaftaran
				</div>
			</div>
			
			<div class="row bg-blue">
				<div class="col-4">
					<div class="d-inline-flex flex-row ">
						<div class="">
						  <img alt="..." src="img/step8.png"></img>
						  <p class="text-center fw-bolder">ppdb.smpiscen.sch.id</p>
						</div>
						<div class="fw-bolder display-4">
						  08
						</div>
					</div>
				</div>
				<div class="col-sm h5">
					Calon Peserta dadapatpat melakukan pengecekan di <a href="cek-pendaftaran">ppdb.smpiscen.sch.id<a/>
				</div>
			</div>
			<div class="py-2">
				<a class="btn btn-success text-white center" href="form-pendaftaran">Mulai Mengisi Formulir</a>
			</div>
		</div>
	</div>
</section>
<?php require "includes/footer.php"; ?>