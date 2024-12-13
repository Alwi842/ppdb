<?php
	session_start();
	require('../includes/control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	
	$admin_login=@$_SESSION["admin_login"];
	$data=$control->main($conn, $admin_login);
	$admin=$control->admin($conn);
	
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	$hari_ini = date('d');
	$second = date('s');
	$jabatan=@$admin[0]['jabatan'];
	if (@!$_POST['kode_pendaftaran']) {
		$sql = "SELECT * FROM form_pendaftaran";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$date = date("Ydm");
		$total=0;
		foreach ($data as $key => $value){
			$total++;
		}
		$total++;
		$kode_pendaftaran=$date."".$total;
	} else {
		$kode_pendaftaran=$_POST['kode_pendaftaran'];
	}
	//important
	//string
	$nama_siswa=@$_POST['nama_siswa'];
	$asal_sekolah=@$_POST['asal_sekolah'];
	$tmp_lahir=@$_POST['tmp_lahir'];
	$tgl_lahir=@$_POST['tgl_lahir'];
	$jenis_kelamin=@$_POST['jenis_kelamin'];
	$agama=@$_POST['agama'];
	$alamat_rumah=@$_POST['alamat_rumah'];
	$kelurahan=@$_POST['kelurahan'];
	$kecamatan=@$_POST['kecamatan'];
	$kab_kota=@$_POST['kab_kota'];
	$provinsi=@$_POST['provinsi'];
	$no_tlp=@$_POST['no_tlp'];
	$nama_ayah=@$_POST['nama_ayah'];
	$pekerjaan_ayah=@$_POST['pekerjaan_ayah'];
	$penghasilan_ayah=@$_POST['penghasilan_ayah'];
	$pendidikan_ayah=@$_POST['pendidikan_ayah'];
	$nama_ibu=@$_POST['nama_ibu'];
	$pekerjaan_ibu=@$_POST['pekerjaan_ibu'];
	$penghasilan_ibu=@$_POST['penghasilan_ibu'];
	$pendidikan_ibu=@$_POST['pendidikan_ibu'];
	
	//int
	$NISN=@$_POST['NISN'];
	$NIK=@$_POST['NIK'];
	$anak_ke=@$_POST['anak_ke'];
	$anak_dari=@$_POST['anak_dari'];
	$alamat_rt=@$_POST['alamat_rt'];
	$alamat_rw=@$_POST['alamat_rw'];
	$kode_pos=@$_POST['kode_pos'];
	$kelas=@$_POST['kelas'];
	$usia_ayah=@$_POST['usia_ayah'];
	$thn_lahir_ayah=@$_POST['thn_lahir_ayah'];
	$usia_ibu=@$_POST['usia_ibu'];
	$thn_lahir_ibu=@$_POST['thn_lahir_ibu'];
	
	//noimportant
    $nama_wali = @$_POST['nama_wali'];
    $pekerjaan_wali = @$_POST['pekerjaan_wali'];
    $usia_wali = @$_POST['usia_wali'];
    $thn_lahir_wali = @$_POST['thn_lahir_wali'];
    $penghasilan_wali = @$_POST['penghasilan_wali'];
    $pendidikan_wali = @$_POST['pendidikan_wali'];
    if ($usia_wali==""){
        $usia_wali=0;
    }
	
	//admin only
	$status=@$_POST['status'];
	
	
	if ($thn_lahir_ayah < 1000) {
        $thn_lahir_ayah = 1000;
    }
    
    if ($thn_lahir_ibu < 1000) {
        $thn_lahir_ibu = 1000;
    }
    
    if ($thn_lahir_wali < 1000) {
        $thn_lahir_wali = 1000;
    }
	
	$targetijazah = "ijazah/";
	$fileName = basename($_FILES["ijazah"]["name"]);
	$targetFilePath = $targetijazah . $fileName;
	$tipeijazah = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$namafileijazah = "ijazah_".$kode_pendaftaran.".".$tipeijazah;
	$folderijazah = $targetijazah . $namafileijazah;
	
	//files
	$targetijazah = "ijazah/";
	$fileName = basename($_FILES["ijazah"]["name"]);
	$targetFilePath = $targetijazah . $fileName;
	$tipeijazah = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$namafileijazah = "ijazah_".$kode_pendaftaran.".".$tipeijazah;
	$folderijazah = $targetijazah . $namafileijazah;
	
	$targetkk = "kk/";
	$fileName = basename($_FILES["kk"]["name"]);
	$targetFilePath = $targetijazah . $fileName;
	$tipekk = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$namafilekk = "kk_".$kode_pendaftaran.".".$tipekk;
	$folderkk = $targetkk . $namafilekk;
	
	/*$targetakta = "akta/";
	$fileName = basename($_FILES["akta"]["name"]);
	$targetFilePath = $targetijazah . $fileName;
	$tipeakta = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$namafileakta = "akta_".$kode_pendaftaran.".".$tipeakta;
	$folderakta = $targetakta . $namafilekk;*/
	
	
	$sql='SELECT * FROM `form_pendaftaran` WHERE kode_pendaftaran="'.$kode_pendaftaran.'"';
	$result = $conn -> query($sql);
	$data = $result -> fetch_all(MYSQLI_ASSOC);
	if (!$data) {
		$sql='INSERT INTO form_pendaftaran(kode_pendaftaran, nama_siswa, asal_sekolah, NISN, NIK, tmp_lahir, tgl_lahir, jenis_kelamin, agama, anak_ke, anak_dari, nama_ayah, pekerjaan_ayah, penghasilan_ayah, usia_ayah, thn_lahir_ayah, pendidikan_ayah, nama_ibu, pekerjaan_ibu, penghasilan_ibu, usia_ibu, thn_lahir_ibu, pendidikan_ibu, nama_wali, pekerjaan_wali, penghasilan_wali, usia_wali, thn_lahir_wali, pendidikan_wali, alamat_rumah, alamat_rt, alamat_rw, kelurahan, kecamatan, kab_kota, provinsi, kode_pos, no_tlp, ijazah, kk, status, kelas) VALUES ("'.$kode_pendaftaran .'","'.$nama_siswa.'","'.$asal_sekolah.'", "'.$NISN.'", "'.$NIK.'", "'.$tmp_lahir.'", "'.$tgl_lahir.'", "'.$jenis_kelamin.'","'.$agama.'","'.$anak_ke.'", "'.$anak_dari.'", "'.$nama_ayah.'", "'.$pekerjaan_ayah.'", "'.$penghasilan_ayah.'", "'.$usia_ayah.'", "'.$thn_lahir_ayah.'","'.$pendidikan_ayah.'","'.$nama_ibu.'", "'.$pekerjaan_ibu.'", "'.$penghasilan_ibu.'", "'.$usia_ibu.'", "'.$thn_lahir_ibu.'", "'.$pendidikan_ibu.'", "'.$nama_wali.'", "'.$pekerjaan_wali.'", "'.$penghasilan_wali.'", "'.$usia_wali.'", "'.$thn_lahir_wali.'", "'.$pendidikan_wali.'", "'.$alamat_rumah.'","'.$alamat_rt.'","'.$alamat_rw.'", "'.$kelurahan.'", "'.$kecamatan.'", "'.$kab_kota.'", "'.$provinsi.'", "'.$kode_pos.'", "'.$no_tlp.'", "'.$namafileijazah.'", "'.$namafilekk.'", 0, "'.$kelas.'")';
		
		$pesan = '<div class="alert alert-success">
			  <strong>Data berhasil disimpan, harap cek kembali!</strong>
			  </div>';
	} else {
		$oldnamekk = @$data[0]['kk'];
		$oldnameijazah = @$value[0]['ijazah'];
		if (!empty($oldnamekk) && file_exists("kk/" . $oldnamekk)) {
            unlink("kk/" . $oldnamekk);
        }
        
        if (!empty($oldnameijazah) && file_exists("ijazah/" . $oldnameijazah)) {
            unlink("ijazah/" . $oldnameijazah);
        }
		
		if (!$admin_login==1) {
			$status=0;
		}
		$sql='UPDATE `form_pendaftaran` SET nama_siswa="'.$nama_siswa.'", asal_sekolah="'.$asal_sekolah.'", kode_pendaftaran="'.$kode_pendaftaran.'", NISN="'.$NISN.'", NIK="'.$NIK.'", tmp_lahir="'.$tmp_lahir.'", tgl_lahir="'.$tgl_lahir.'", jenis_kelamin="'.$jenis_kelamin.'", agama="'.$agama.'", anak_ke="'.$anak_ke.'", anak_dari="'.$anak_dari.'", nama_ayah="'.$nama_ayah.'", pekerjaan_ayah="'.$pekerjaan_ayah.'", penghasilan_ayah="'.$penghasilan_ayah.'", usia_ayah="'.$usia_ayah.'", thn_lahir_ayah="'.$thn_lahir_ayah.'", pendidikan_ayah="'.$pendidikan_ayah.'", nama_ibu="'.$nama_ibu.'", pekerjaan_ibu="'.$pekerjaan_ibu.'", penghasilan_ibu="'.$penghasilan_ibu.'", usia_ibu="'.$usia_ibu.'", thn_lahir_ibu="'.$thn_lahir_ibu.'", pendidikan_ibu="'.$pendidikan_ibu.'", nama_wali="'.$nama_wali.'", pekerjaan_wali="'.$pekerjaan_wali.'", penghasilan_wali="'.$penghasilan_wali.'", usia_wali="'.$usia_wali.'", thn_lahir_wali="'.$thn_lahir_wali.'", pendidikan_wali="'.$pendidikan_wali.'", alamat_rumah="'.$alamat_rumah.'", alamat_rt="'.$alamat_rt.'", alamat_rw="'.$alamat_rw.'", kelurahan="'.$kelurahan.'", kecamatan="'.$kecamatan.'", kab_kota="'.$kab_kota.'", provinsi="'.$provinsi.'", kode_pos="'.$kode_pos.'", no_tlp="'.$no_tlp.'", ijazah="'.$namafileijazah.'", kk="'.$namafilekk.'", status="'.$status.'", kelas="'.$kelas.'" WHERE kode_pendaftaran="'.$kode_pendaftaran.'"';
		$pesan = '<div class="alert alert-success">
			  <strong>Data Berhasil Di Update!</strong>
			  </div>';
	}
	if(!empty($_FILES["ijazah"]["name"])) {
		move_uploaded_file($_FILES["ijazah"]["tmp_name"], $folderijazah);
	}
		
	if(!empty($_FILES["kk"]["name"])) {
		move_uploaded_file($_FILES["kk"]["tmp_name"], $folderkk);
	}
	$query = mysqli_query($conn, $sql);
	if (!$query) {
		$pesan = '<div class="alert alert-danger">
			  <strong>Data Gagal Di ubah!</strong>
			  </div>';
	}
	$_SESSION["pesan"] = $pesan;
	$_SESSION["kode_pendaftaran"]=$kode_pendaftaran;
	//echo $sql;
	if ($admin_login==1) { 
		//header("location: preview_form.php?kode_pendaftaran=".$kode_pendaftaran);
	} else {
		//header("location: preview_form.php");
	}
	
?>