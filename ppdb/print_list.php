<!DOCTYPE html>
<html>
<?php 
	session_start();
	require 'control.php';
	$conn=$conn->connection();
	$jabatan=$admin[0]['jabatan'];
	$control->admin_login($_SESSION["admin_login"], 'panitia', $jabatan);
	$data=$control->main($conn, $admin_login);
	$setting=$control->cek_ppdb_settings($conn);

	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	$hari_ini = date('d');
	$tahun_ini = date('Y');
	$data=$control->list_pendaftaran($conn);
	$orgDate = $data[0]['tgl_lahir'];  
    $newDate = date("d-m-Y", strtotime($orgDate));
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Pegawai.xls");
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<div id="main" class="container">
<?php $control->pesan(); ?>
	<h3 align=center style="font-size: 100%;"><b>PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
	<h3 align=center style="font-size: 100%;"><b>TAHUN PELAJARAN <?php echo $tahun_ini."/".$tahun_ini+1 ?></h3>
	<div>
	<table border="1">
		<thead>
		<tr>
			<td >no</td><td>Kode</td><td>Nama Siswa</td><td>Asal Sekolah</td><td>NISN</td><td>NIK</td><td>Tempat Lahir</td><td>Tgl Lahir</td><td>Jenis Kelamin</td>
			<td>Agama</td><td>Anak Ke</td><td>Dari</td><td>Nama Ayah Kandung</td><td>Pekerjaan</td><td>Penghasilan/Bulan</td><td>Usia</td><td>Tahun Lahir</td><td>Pendidikan</td><td>Nama Ibu Kandung</td><td>Pekerjaan</td><td>Penghasilan/Bulan</td><td>Usia</td><td>Tahun Lahir</td><td>Pendidikan</td><td>Nama Wali</td><td>Pekerjaan</td><td>Penghasilan/Bulan</td><td>Usia</td><td>Tahun Lahir</td><td>Pendidikan</td><td>Alamat</td><td>RT</td><td>RW</td><td>Kelurahan</td><td>Kecamatan</td><td>Kab/Kota</td><td>Provinsi</td><td>Kode Pos</td><td>No. Telp/HP</td><td>Ijazah</td><td>kk</td><td>Status</td>
		</tr>
		</thead>
		<tbody>
		<?php
		$page=@$_GET["page"];
		if ($page<1) $page=1;
		$showtotal=10;
		$showtotal=@$_GET["showtotal"];
		if ($showtotal<10) $showtotal=10;
		$showmax=$showtotal*$page;
		$showmin=$showmax-$showtotal;
		$curr=1;
		$count=1;
		$show=0;
			foreach ($data as $key => $value){
				if ($curr>$showmin&&$curr<=$showmax) {
					
		?>
		<td scope="row"><?php echo $curr; ?></td>
		<td><?php echo $value['kode_pendaftaran']; ?></td>
		<td><?php echo $value['nama_siswa']; ?></td>
			<td><?php echo $value['asal_sekolah']; ?></td>
			<td><?php echo $value['NISN']; ?></td>
			<td><?php echo $value['NIK']; ?></td>
			<td><?php echo $value['tmp_lahir']; ?></td>
			<td><?php echo $newDate; ?></td>
			<td><?php echo $value['jenis_kelamin'];?></td>
			<td><?php echo $value['agama']; ?></td>
			<td><?php echo $value['anak_ke']; ?></td>
			<td><?php echo $value['anak_dari']; ?></td>
			<td><?php echo $value['nama_ayah']; ?></td>
			<td><?php echo $value['pekerjaan_ayah'];?></td>
			<td><?php echo $value['penghasilan_ayah']; ?></td>
			<td><?php echo $value['usia_ayah']; ?></td>
			<td><?php echo $value['thn_lahir_ayah']; ?></td>
			<td><?php echo $value['pendidikan_ayah']; ?></td>
			<td><?php echo $value['nama_ibu']; ?></td>
			<td><?php echo $value['pekerjaan_ibu']; ?></td>
			<td><?php echo $value['penghasilan_ibu']; ?></td>
			<td><?php echo $value['usia_ibu']; ?></td>
			<td><?php echo $value['thn_lahir_ibu']; ?></td>
			<td><?php echo $value['pendidikan_ibu']; ?></td>
			<td><?php echo $value['nama_wali']; ?></td>
			<td><?php echo $value['pekerjaan_wali'];; ?></td>
			<td><?php echo $value['penghasilan_wali']; ?></td>
			<td><?php echo $value['usia_wali']; ?></td>
			<td><?php echo $value['thn_lahir_wali']; ?></td>
			<td><?php echo $value['pendidikan_wali']; ?></td>
			<td><?php echo $value['alamat_rumah']; ?></td>
			<td><?php echo $value['alamat_rt']; ?></td>
			<td><?php echo $value['alamat_rw']; ?></td>
			<td><?php echo $value['kelurahan']; ?></td>
			<td><?php echo $value['kecamatan']; ?></td>
			<td><?php echo $value['kab_kota']; ?></td>
			<td><?php echo $value['provinsi']; ?></td>
			<td><?php echo $value['kode_pos']; ?></td>
			<td><?php echo $value['no_tlp']; ?></td>
			<td><?php 
				if (!empty($value['ijazah'])) {
					echo '<a href="ijazah/'.$value["ijazah"].'" target="_blank">Lihat Ijazah</a>';
				} else {
					echo "kosong";
				}
				?>
			</td>
			<td><?php 
				if (!empty($value['ijazah'])) {
					echo '<a href="kk/'.$value["kk"].'" target="_blank">Lihat KK</a>';
				} else {
					echo "kosong";
				}
				?>
			</td>
			<?php
			if ($value['status']==0) {
				echo "<td class='alert alert-danger'>
						<strong>Belum Diterima</strong>";
			} else if ($value['status']==1) {
				echo "<td class='alert alert-success'>
						<strong>Aktif</strong>";
			} else if ($value['status']==2) {
				echo "<td class='alert alert-success'>
						<strong>lulus</strong>";
			} else if ($value['status']==3) {
				echo "<td class='alert alert-danger'>
						<strong>Dikeluarkan</strong>";
			}
			?>
				</td>
			</tr>
			<?php 
			}
			if ($curr==$showmax) {
				$show=1;
				break;
			}
			$curr++; }?>
		</tbody>
	</table>
	</div>
</div>
<script type="text/javascript">
function show(){
	var page = <?php echo $page; ?>;
	var showtotal=document.getElementById("show").value;
	document.getElementById("showok").href="http://localhost/aplikasi_pendaftaran/list.php?page="+page+"&showtotal="+showtotal;
}
</script>
</body>
</html>