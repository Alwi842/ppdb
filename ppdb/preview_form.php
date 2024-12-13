<?php 
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();
	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	
	$kode_pendaftaran=$_SESSION["kode_pendaftaran"];
	if (@$_POST['tombol']=='hapus') {
		$control->delete($conn, $kode_pendaftaran);
	} else if (@$_POST['tombol']=='ubah') {
		header("location: edit-formulir?kode_pendaftaran=$kode_pendaftaran");
	} else if (@$_POST['tombol']=='selesai') {
		header("location: cek-pendaftaran?kode_pendaftaran=$kode_pendaftaran");
	}
	$sql = "SELECT * FROM form_pendaftaran WHERE kode_pendaftaran = '$kode_pendaftaran'";
	$result = $conn -> query($sql);
	$data = $result -> fetch_all(MYSQLI_ASSOC);
	if(!$data) {
		$pesan = '<div class="alert alert-danger">
				  <strong>NIS tidak terdaftar!</strong>
				  </div>';
		$_SESSION["pesan"]=$pesan;
		header("location: beranda");
	}
	$_SESSION['daftar']=1;
	$orgDate = $data[0]['tgl_lahir'];  
    $newDate = date("d-m-Y", strtotime($orgDate));
    require("includes/header.php");
?>
<head>
</head>
<body>
 <header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">PETINJAU FORMULIR</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>
<div class="container px-4 my-5">
	<div id="alert" onclick="alert_close()">
		<?php echo $control->pesan();
		
		?>
	</div>
	<table class="table bg-white">
		<tbody>
		<tr><td style="width: 16%">Nama Peserta Didik</td><td style="width: 1%">:</td><td><?php echo $data[0]['nama_siswa'] ?></td></tr>
		<tr><td>Asal Sekolah</td><td>:</td><td><?php echo $data[0]['asal_sekolah']; ?></td></tr>
		<tr><td>NISN</td><td>:</td><td><?php echo $data[0]['NISN']; ?></td></tr>
		<tr><td>NIK</td><td>:</td><td><?php echo $data[0]['NIK']; ?></td></tr>
		<tr><td>Tmpt/Tgl Lahir</td><td>:</td><td><?php echo $data[0]['tmp_lahir'].", ".$newDate; ?></td></tr>
		<tr><td>Jenis Kelamin</td><td>:</td><td><?php if ($data[0]['jenis_kelamin']=="L") { echo "Laki-laki"; } else echo "Perempuan"; ?></td></tr>
		<tr><td>Agama</td><td>:</td><td><?php echo $data[0]['agama']; ?></td></tr>
		<tr><td>Anak Ke</td><td>:</td><td><?php echo $data[0]['anak_ke']; ?> | Dari - <?php echo $data[0]['anak_dari']; ?></td></tr>
		<tr><td>Nama Ayah Kandung</td><td>:</td><td><?php echo $data[0]['nama_ayah']; ?></td></tr>
		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $data[0]['pekerjaan_ayah'];; ?></td></tr>
		<tr><td>Penghasilan/Bulan</td><td>:</td><td><?php 
		echo $data[0]['penghasilan_ayah']; ?></td></tr>
		<tr><td>Usia</td><td>:</td><td><?php echo $data[0]['usia_ayah']; ?> Tahun | Tahun Lahir : <?php echo $data[0]['thn_lahir_ayah']; ?></td></tr>	
		<tr><td>Pendidikan</td><td>:</td><td><?php echo $data[0]['pendidikan_ayah']; ?></td></tr>
		<tr><td>Nama Ibu Kandung</td><td>:</td><td><?php echo $data[0]['nama_ibu']; ?></td></tr>
		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $data[0]['pekerjaan_ibu'];; ?></td></tr>
		<tr><td>Penghasilan/Bulan</td><td>:</td><td><?php 
		echo $data[0]['penghasilan_ibu']; ?></td></tr>
		<tr><td>Usia</td><td>:</td><td><?php echo $data[0]['usia_ibu']; ?> Tahun | Tahun Lahir : <?php echo $data[0]['thn_lahir_ibu']; ?></td></tr>
		<tr><td>Pendidikan</td><td>:</td><td><?php echo $data[0]['pendidikan_ibu']; ?></td></tr>
		<tr><td>Nama Wali</td><td>:</td><td><?php echo $data[0]['nama_wali']; ?></td></tr>
		<tr><td>Pekerjaan</td><td>:</td><td><?php echo $data[0]['pekerjaan_wali'];; ?></td></tr>
		<tr><td>Penghasilan/Bulan</td><td>:</td><td><?php 
		echo $data[0]['penghasilan_wali']; ?></td></tr>
		<tr><td>Usia</td><td>:</td><td><?php echo $data[0]['usia_wali']; ?> Tahun | Tahun Lahir : <?php echo $data[0]['thn_lahir_wali']; ?></td></tr>	
		<tr><td>Pendidikan</td><td>:</td><td><?php echo $data[0]['pendidikan_wali']; ?></td></tr>
		<tr><td>Alamat</td><td>:</td><td><?php echo $data[0]['alamat_rumah']; ?></td></tr>
		<tr><td></td><td>:</td><td>RT : <?php echo $data[0]['alamat_rt']; ?> | RW : <?php echo $data[0]['alamat_rw'];; ?></td></tr>
		<tr><td>Kelurahan</td><td>:</td><td><?php echo $data[0]['kelurahan']; ?></td></tr>
		<tr><td>Kecamatan</td><td>:</td><td><?php echo $data[0]['kecamatan']; ?></td></tr>
		<tr><td>Kab/Kota</td><td>:</td><td><?php echo $data[0]['kab_kota']; ?></td></tr>
		<tr><td>Provinsi</td><td>:</td><td><?php echo $data[0]['provinsi']; ?></td></tr>
		<tr><td>Kode Pos</td><td>:</td><td><?php echo $data[0]['kode_pos']; ?></td></tr>
		<tr><td>No. Telp/HP</td><td>:</td><td><?php echo $data[0]['no_tlp']; ?></td></tr>
		<tr><td>Pil kelas</td><td>:</td><td><?php 
		if ($data[0]['kelas']==1){
		    echo 'Plus';
		} else echo 'Reguler';
		
		?></td></tr>
		
		
		<tr><td>Ijazah</td><td>:</td>
			<td>
			<form action="pratinjau-gambar" method="post" target="_blank">
		  <input type="text" name="code" value="qTfo4m8ttouXtzA" hidden>
		  <input type="text" name="ijazah" value="<?php echo $data[0]["ijazah"]; ?>" hidden>
		  <input class="btn btn-info text-white" type="submit" name="submit" value="ijazah">
			</td></tr>
		<tr><td>kk</td><td>:</td>
			<td>
			<input type="text" name="kk" value="<?php echo $data[0]["kk"]; ?>" hidden>
			<input class="btn btn-info text-white"  type="submit" name="submit" value="kk">
			</form>
		</td></tr>
		<tr>
			<td colspan="3"  align=center class="bg-white">
				PASTIKAN DATA TELAH TERISI DENGAN BENAR
			</td>
		</tr>
		
		<tr>
		<form action="pratinjau-formulir" method="post">
			<td colspan="3"  align=center class="bg-white">
			<input id="kode_pendaftaran" type="text" name="kode_pendaftaran" value="<?php echo $kode_pendaftaran; ?>"  hidden> 
			<a class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#hapusModal">Hapus</a>
			<button class="btn btn-warning text-white" name="tombol" value="ubah" >Ubah</button>
			<button class="btn btn-info text-white" name="tombol" value="selesai">Kirim</button>
			</td>
		</tr>
	</tbody>
	</table>
	</form>
	
</div>
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Log out</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        apakah kamu yakin ingin menghapus?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
		<form action="pratinjau-formulir" method="post">
			<button class="btn btn-danger text-white" name="tombol" value="hapus">hapus</button>
		</form>
      </div>
    </div>
  </div>
</div>
<?php include("includes/footer.php"); ?>
</body>
</html>