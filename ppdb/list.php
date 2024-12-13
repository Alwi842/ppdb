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
	if (@$_POST['tombol']=='hapus') {
		$control->delete_list($conn, $_POST['kode_pendaftaran']);
	}
	if ($_POST) $_SESSION['cari_btn']=$_POST['cari_btn'];
	if (@$_SESSION['cari_btn']=='filter'){
		if ($_POST) {
			$_SESSION['filter']=1;
			$_SESSION['cari']=0;
			$_SESSION['kelas']=@$_POST['kelas'];
			$_SESSION['status']=@$_POST['status'];
		}
		$data=$control->list_pendaftaran($conn, 'filter');
	} else if (@$_SESSION['cari_btn']=='cari') {
		if ($_POST) {
			$_SESSION['cari']=1;
			$_SESSION['filter']=0;
			$_SESSION['tipe_cari']=@$_POST['cari'];
			$_SESSION['input_cari']=@$_POST['cari_input'];
		}
		$data=$control->list_pendaftaran($conn, 'cari');
	} else if (@$_SESSION['cari_btn']=='clear') {
		$data=$control->list_pendaftaran($conn, 'clear');
	} else {
		$data=$control->list_pendaftaran($conn, '');
	}
	$orgDate = @$data[0]['tgl_lahir'];  
    $newDate = date("d-m-Y", strtotime($orgDate));
	require("includes/header.php");
?>
<header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">LAPORAN SISWA</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">PPDB SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>
<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>

<section>

	<div class="container px-4 my-5">
	<button type="button" id="toggle_cari" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#myContent">
	  Cari &#128269;
	</button>
		<div class="collapse" id="myContent">
		<div class="shadow p-4 bg-light rounded-3 ">
			<form method="post">
				<table class="mb-4"style="width: 100%;">
					<tbody>
						<tr>
							<td colspan=6 align=center class="fw-bolder">FILTER</td>
						</tr>
						<tr>
							<td style="width: 1%">Kelas</td>
							<td>
								<select class="form-select" name="kelas" id="kelas">
								  <option value="semua">Semua</option>
								  <option value="plus">Plus</option>
								  <option value="reguler">Reguler</option>
								</select>
							</td>
							<td style="width: 1%">Status</td>
							<td>
								<select class="form-select" name="status" id="status" >
								  <option value="semua">Semua</option>
								  <option value="belum_diterima">Belum Diterima</option>
								  <option value="diterima">Diterima</option>
								  <?php if ($jabatan=="admin" || $jabatan=="panitia") echo "<option value='belum_lunas'>Belum lunas</option>";?>
								</select>
							</td>
							<td style="width: 1%"><button type="submit" class="btn bg-green text-white" name="cari_btn" value="filter">Filter</button></td>
							<td style="width: 1%"><?php if (@$_SESSION['filter']) { ?><button type="submit" class="btn btn-warning text-white" name="cari_btn" value="clear">Clear</button> <?php } ?></td>
					</tbody>
				</table>
			</form>
			<table class="mb-4">
				<tbody>
				<tr>
					<td colspan=4 align=center class="fw-bolder">Cari</td>
					</tr>
					<tr>
						<form method="post">
							<td>
								<select class="form-select" name="cari" id="cari" >
								  <option value="1">Nama</option>
								  <option value="2">Kode Pendaftaran</option>
								</select></td>
							<td>
								<input class="form-control" id="kode_pendaftaran" type="search" name="cari_input" placeholder=""></input>
							</td>
							<td style="width: 1%">
								<button type="submit" class="btn bg-green text-white" name='cari_btn' value="cari">Cari</button>
							</td>
							<td style="width: 1%"><?php if (@$_SESSION['cari']) { ?><button type="submit" class="btn btn-warning text-white" name="cari_btn" value="clear">Clear</button> <?php } ?></td>
						</form>
					</tr>
				</tbody>
			</table>
			
			<table class="mb-1">
				<tbody>
					<tr><td class="fw-bolder">Show</td></tr>
					<tr>
					<td>
						<select class="form-select" onchange="show_list()" id="show">
						  <option value="10" <?php if (@$_GET["showtotal"]==10) echo "selected";?>>10</option>
						  <option value="20" <?php if (@$_GET["showtotal"]==20) echo "selected";?>>20</option>
						  <option value="30" <?php if (@$_GET["showtotal"]==30) echo "selected";?>>30</option>
						  <option value="50" <?php if (@$_GET["showtotal"]==50) echo "selected";?>>50</option>
						  <option value="100" <?php if (@$_GET["showtotal"]==100) echo "selected";?>>100</option>
						</select>
					</td>
					</td>
					</tr>
				</tbody>
			</table>
		</div>
		</div>
	</div>

</section>

<section>			
<div class="container px-4 my-5">
	<div style="overflow-x:auto;">
	<table class="table" style="width:6000px">
		<thead>
		<tr>
			<td>no</td><td>Action</td><td>Status</td><td>Kode</td><td>SKL</td><td>kk</td><td>Kelas</td><td>Nama Siswa</td><td>Asal Sekolah</td><td>Tempat Lahir</td><td>Tgl Lahir</td><td>NISN</td><td>NIK</td><td>Jenis Kelamin</td>
			<td>Agama</td><td>Anak Ke</td><td>Dari</td><td>Nama Ayah Kandung</td><td>Pekerjaan</td><td>Penghasilan/Bulan</td><td>Usia</td><td>Tahun Lahir</td><td>Pendidikan</td><td>Nama Ibu Kandung</td><td>Pekerjaan</td><td>Penghasilan/Bulan</td><td>Usia</td><td>Tahun Lahir</td><td>Pendidikan</td><td>Nama Wali</td><td>Pekerjaan</td><td>Penghasilan/Bulan</td><td>Usia</td><td>Tahun Lahir</td><td>Pendidikan</td><td>Alamat</td><td>RT</td><td>RW</td><td>Kelurahan</td><td>Kecamatan</td><td>Kab/Kota</td><td>Provinsi</td><td>Kode Pos</td><td>No. Telp/HP</td>
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
		<td>
			<a class="btn btn-warning text-white" target="_blank" href="edit-formulir?kode_pendaftaran=<?php echo $value['kode_pendaftaran'] ?>">Ubah</a>
			<a class="btn btn-info text-white" target="_blank" href="print-form?kode_pendaftaran=<?php echo $value['kode_pendaftaran'] ?>">Print</a>
			<a class="btn btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $curr; ?>">Hapus</a>
			<div class="modal fade" id="deleteModal<?php echo $curr; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel<?php echo $curr; ?>">Log out</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div class="modal-body">
					apakah kamu yakin ingin menghapus data (<?php echo $value['nama_siswa']; ?>)?
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
					<form method="post">
						<input value="<?php echo $value['kode_pendaftaran']; ?>" name="kode_pendaftaran" hidden>
						<button class="btn btn-danger text-white" name="tombol" value="hapus">hapus</button>
					</form>
				  </div>
				</div>
			  </div>
			</div>
		</td>
		<?php
			if ($value['status']==0) {
				echo "<td class='alert alert-danger'>
						<strong>Belum Diterima</strong>";
			} else if ($value['status']==1) {
				echo "<td class='alert alert-success'>
						<strong>Diterima</strong>";
			} else if ($value['status']==2) {
				if ($jabatan=="admin" || $jabatan=="panitia" ){ 
					echo "<td class='alert alert-success'>
						<strong>Diterima dan lunas</strong>";
				} else {
					echo "<td class='alert alert-success'>
						<strong>Diterima</strong>";
				}
			}
			?>
				</td>
		<td><?php echo $value['kode_pendaftaran']; ?></td>
		<td>
			<form method="post" action="pratinjau-gambar" target="_blank">
			<input value="qTfo4m8ttouXtzA" name="code" hidden>
			<input value="<?php echo $value["kk"]; ?>" name="kk" hidden>
			<input value="<?php echo $value["ijazah"]; ?>" name="ijazah" hidden>
			<?php 
				if (file_exists("ijazah/".$value['ijazah'])) {
					echo '<button type="submit" class="btn bg-green text-white" name="submit" value="ijazah">Lihat</button>';
				} else {
					echo "kosong";
				}
				?>
			</td>
			<td><?php 
				if (file_exists("kk/".$value['kk'])) {
					echo '<button type="submit" class="btn bg-green text-white" name="submit" value="kk">Lihat</button>';
				} else {
					echo "kosong";
				}
				?>
			</form>
			</td>
		<td><?php 
		if ($value['kelas']==1){
		    echo 'Plus';
		} else echo 'Reguler'; ?>
		
		</td>
		<td><?php echo $value['nama_siswa']; ?></td>
			<td><?php echo $value['asal_sekolah']; ?></td>
			<td><?php echo $value['tmp_lahir']; ?></td>
			<td><?php echo $newDate; ?></td>
			<td><?php echo $value['NISN']; ?></td>
			<td><?php echo $value['NIK']; ?></td>
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
	<div>
		
	<?php 
	$prev=1;
	$next=$page;
	if ($page>1) $prev=$page-1;
	if ($show==1) $next=$page+1;
	echo "<a href='list?page=".$prev."&showtotal=".$showtotal."' class='previous btn  btn-success text-white' disabled>&laquo;</a>
	<a href='list?page=".$next."&showtotal=".$showtotal."' class='next btn  btn-success text-white'>&raquo;</a>";
	if ($show==0 && $_GET['page']!=1) {
	?> 
		<script>
			window.location.replace("list?page=1&showtotal=10");
		</script>
	<?php  } ?>
	</div>	
</div>

</section>
<?php include("includes/footer.php"); ?>
<script type="text/javascript">
function show(){
	var page = <?php echo $page; ?>;
	var showtotal=document.getElementById("show").value;
	document.getElementById("showok").href="list?page="+page+"&showtotal="+showtotal;
}
 const button = document.getElementById('toggle_cari');
  const collapseElement = document.getElementById('myContent');

  button.addEventListener('click', () => {
    if (collapseElement.classList.contains('show')) {
      button.textContent = 'Cari';
    } else {
      button.textContent 	= 'Tutup';
    }
  });
</script>
</body>
</html>