<?php
session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];

	require("includes/header.php");
?>
<section class="mb-4">
    <h2 class="h1-responsive font-weight-bold text-center my-4">Kontak Kami</h2>
    <p class="text-center w-responsive mx-auto mb-5">Punya pertanyaan? Tolong jangan ragu untuk menanyakan kami. Staff kami akan membalas dalam hitungan jam untuk membantu anda.</p>
	<div class="container">
		<ul class="list-unstyled mb-0">
			<li><i class="bi bi-geo-alt-fill"></i>
				Jl. Ciujung Raya No 4 Perumnas I Kota Tangerang
			</li>
			<li><i class="bi bi-telephone"></i>
				(021) 55727644 / 55794069
			</li>

			<li><i class="bi bi-phone"></i>
				081219346366
			</li>
			<li><i class="bi bi-globe"></i>
				www.smpiscen.sch.id
			</li>
			<li><i class="bi bi-youtube"></i>
				ISCENTA NEWS
			</li>
			<li><i class="bi bi-envelope"></i>
				admin@smpiscen.sch.id
			</li>
		</ul>
	</div>
</section>
<?php require("includes/footer.php"); ?>