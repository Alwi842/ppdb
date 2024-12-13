<?php 
	session_start();
	require('includes/control.php');
	require('includes/login.php');
	require('includes/fetch-beranda.php');
	$conn=$connection->getConnection();
	//validate login
	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	
	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');

	$fetchBeranda= new fetchBeranda();
	$values=array();
	$values=$fetchBeranda->fetchAll($conn);
	require("includes/header.php");
?>
<script>
/* chart.js chart examples */

$(document).ready(function() {
	// chart colors
var colors = ['#007bff','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];

/* 3 donut charts */
var donutOptions = {
  cutoutPercentage: 85, 
  legend: {position:'bottom', padding:5, labels: {pointStyle:'circle', usePointStyle:true}}
};

// donut 1
var chDonutData1 = {
    labels: ['REGULER <?php echo $values[0]?>', 'PLUS <?php echo $values[1]?>',],
    datasets: [
      {
        backgroundColor: colors.slice(0,3),
        borderWidth: 0,
        data: [<?php echo $values[0]?>, <?php echo $values[1]?>]
      }
    ]
};

var chDonut1 = document.getElementById("chDonut1");
if (chDonut1) {
  new Chart(chDonut1, {
      type: 'pie',
      data: chDonutData1,
      options: donutOptions
  });
}

// donut 2
var chDonutData2 = {
    labels: ['DIterima', 'Diterima dan Lunas', 'Belum Diterima'],
    datasets: [
      {
        backgroundColor: colors.slice(0,3),
        borderWidth: 0,
        data: [<?php echo  $values[11]?>, <?php echo  $values[10]?>, <?php echo $values[9]?>]
      }
    ]
};
var chDonut2 = document.getElementById("chDonut2");
if (chDonut2) {
  new Chart(chDonut2, {
      type: 'pie',
      data: chDonutData2,
      options: donutOptions
  });
}
});
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
<header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">LAPORAN</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();
	?>
</div>
	
<section class="py-5 ">
	<div class="bg-light">
		<div class="container mb-2">
			<div class="row gx-5 justify-content-center">
				<div class="col-md-4 py-1">
					<div class="card h-100 shadow border-0">
					<a ALIGN=CENTER>Pemilihan Kelas</a>
						<div class="card-body">
							<canvas id="chDonut1"></canvas>
							<a>Total Pendaftar : <?php echo $values[2]?></a>
						</div>
					</div>
				</div>
				<div class="col-md-4 py-1">
					<div class="card h-100 shadow border-0">
					<a ALIGN=CENTER>Penerimaan siswa</a>
						<div class="card-body">
							<canvas id="chDonut2"></canvas>
						</div>
					</div>
				</div>
				<div class="col-md-4 py-1">
					<div class="card h-100 shadow border-0">
					<a ALIGN=CENTER>Detail penerimaan siswa</a>
						<div class="card-body">
							<p class="lead">Reguler :</p>
							<ul>
								<li>Diterima dan Lunas : <?php echo $values[5] ?> </li>
								<li>Diterima : <?php echo $values[4] ?></li>
								<li>Belum diterima : <?php echo $values[3] ?></li>
							</ul>
							<p class="lead">Plus :</p>
							<ul>
								<li>Diterima dan Lunas : <?php echo $values[8] ?></li>
								<li>Diterima : <?php echo $values[7] ?></li>
								<li>Belum diterima : <?php echo $values[6] ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="row gx-5 justify-content-center pt-3">
				<div class="col-md-4 py-1">
					<div class="card h-100 shadow border-0">
					<a ALIGN=CENTER>Pemasukan kelas reguler</a>
						<div class="card-body">
						<p class="lead">Reguler :</p>
							<ul>
								<li>Lunas : <?php echo "Rp. ".number_format($values[15], 0, '', '.'); ?> </li>
								<li>Setengah : <?php echo "Rp. ".number_format($values[13], 0, '', '.'); ?></li>
								<div class='horizontal'></div>
								<li>Total bayar : <?php echo "Rp. ".number_format($values[15]+$values[13], 0, '', '.'); ?></li>
								<li>Belum bayar : <?php echo "Rp. ".number_format($values[12]+($values[14]-$values[13]), 0, '', '.'); ?></li>
								<div class='horizontal'></div>
								<li>Total : <?php echo "Rp. ".number_format($values[15]+$values[12]+($values[14]-$values[13]), 0, '', '.'); ?></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-4 py-1">
					<div class="card h-100 shadow border-0">
					<a ALIGN=CENTER>Pemasukan kelas plus</a>
						<div class="card-body">
						<p class="lead">Plus :</p>
						<ul>
							<li>Lunas : <?php echo "Rp. ".number_format($values[15+4], 0, '', '.'); ?> </li>
							<li>Setengah : <?php echo "Rp. ".number_format($values[13+4], 0, '', '.'); ?></li>
							<div class='horizontal'></div>
							<li>Total bayar : <?php echo "Rp. ".number_format($values[15+4]+$values[13+4], 0, '', '.')  ?></li>
							<li>Belum bayar : <?php echo "Rp. ".number_format($values[12+4]+($values[14+4]-$values[13+4]), 0, '', '.')  ?></li>
							<div class='horizontal'></div>
							<li>Total : <?php echo "Rp. ".number_format($values[15+4]+$values[12+4]+($values[14+4]-$values[13+4]), 0, '', '.')  ?></li>
						</ul>
						</div>
					</div>
				</div>
				<div class="col-md-4 py-1">
					<div class="card h-100 shadow border-0">
					<a ALIGN=CENTER>Keseluruhan Pemasukan</a>
						<div class="card-body">
						<p class="lead">Keseluruhan :</p>
						<ul>
							<li>Lunas : <?php echo "Rp. ".number_format($values[15+4]+$values[15], 0, '', '.')  ?> </li>
							<li>Setengah : <?php echo "Rp. ".number_format($values[13+4]+$values[13], 0, '', '.')  ?></li>
							<div class='horizontal'></div>
							<li>Total bayar : <?php echo "Rp. ".number_format($values[15+4]+$values[13+4]+$values[15]+$values[13], 0, '', '.')  ?></li>
							<li>Belum bayar : <?php echo "Rp. ".number_format($values[12+4]+($values[14+4]-$values[13+4])+$values[12]+($values[14]-$values[13]), 0, '', '.')  ?></li>
							<div class='horizontal'></div>
							<li>Total : <?php echo "Rp. ".number_format($values[15+4]+$values[13+4]+$values[15]+$values[13]+$values[12+4]+($values[14+4]-$values[13+4])+$values[12]+($values[14]-$values[13]), 0, '', '.')  ?></li>
						</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
<?php require "includes/footer.php"; ?>