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
		<h3 class="fw-bolder text-white mb-2 text-center">SYARAT DAN KETENTUAN</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PENERIMAAN PESERTA DIDIK BARU SMP ISLAMICCENTRE</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>

<section class="py-5">
	<div class="bg-light">
		<div class="container mb-2">
			<p class="fw-bolder">1. KETENTUAN UMUM</p>
			<ol type="A" start="A">
				<li>Calon Peserta Didik Baru SMP Islamic Centre adalah lulusan SD/MI/Kejar PAKET baik dalam maupun luar Negri yang telah diizinkan oleh Dinas Pendidikan Kota Tangerang</li>
				<li>Calon Peserta Didik Baru SMP Islamic Centre sanggup mematuhi segala peraturan/Tata Tertib yang telah ditetapkan oleh SMP Islamic Centre</li>
				<li>Calon Peserta Didik Baru SMP Islamic Centre sanggup membayar segala Biaya Administrasi yang telah ditetapkan oleh SMP Islamic Centre</li>
			</ol>
			<p class="fw-bolder" >2. DAYA TAMPUNG SMP ISLAMIC CENTRE</p>
			<ol type="A" start="A">
				<li>Kelas Reguler 2 Kelas Masing masing kelas sebanyak 32-36 Siswa</li>
				<li>Kelas Plus/Unggulan 3 Kelas Masing masing kelas sebanyak 27-30</li>
			</ol>
			<p class="fw-bolder" >3. PERSYARATAN PENDAFTARAN</p>
			<ol type="A" start="A">
				<li>Mengisi Formulir Pendaftaran (biaya Formulir Rp. 150.000)</li>
				<li>Menyerahkan Fotocopy Ijazah (atau surat kelulusan asli jika ijazah belum terbit)</li>
				<li>Menyerahkan Fotocopy Akta Kelahiran</li>
				<li>Menyerahkan Fotocopy Kartu Keluarga (KK)</li>
				<li>Menyerahkan Fotocopy Ijazah (atau surat kelulusan asli jika ijazah belum terbit)</li>
			</ol>
			<p class="fw-bolder" >4. SELEKSI MASUK</p>
			<ol type="A" start="A">
				<li>Tidak ada seleksi masuk, hanya test pengetahuan umum dan keagamaan</li>
				<li>Pengelompokan Rombel akan ditentukan dari hasil wawancara dan test baca Al-Qur'an (Jadwal Wawancara dan Test baca Al-Qur'an Terlampir)</li>
			</ol>
			<p class="fw-bolder" >5. KETENTUAN LAIN-LAIN</p>
			<ol type="A" start="A">
				<li>Menarik Berkas adalah dimana kondisi Calon Peserta Didik Baru, telah melunasi biaya administrasi atau sesuai ketentuan gelombang pendaftaran, ternyata diterima di SMP Negri. Maka Calon Peserta Didik Baru bisa mengambil pembayaran administrasi tersebut dengan potongan sebesar Rp. 1.000.000. (Syarat menunjukan Surat tanda diterima masuk SMP Negri)</li>
				<li>Menarik Berkas hanya berlaku selambat-lambatnya 7 Hari setelah pengumuman PPDB SMP Negri. (Sesuai Jadwal PPDB Online Kota Tangerang).</li>
				<li>Membatalkan Pendaftaran setelah 8 Hari atau lebih setelah Pengumuman PPDB Online SMP Negri, maka dianggap mengundurkan diri, Tanpa pengembalian Pembayaran yang telah dilakukan.</li>
				<li>Demi terlaksananya Program pembelajaran peserta didik tidak diperkenankan pindah dari SMP Islamic Centre sekurang-kurangnya 1 Tahun Pelajaran.</li>
			</ol>
		</div>
	</div>
</section>

<?php require "includes/footer.php"; ?>