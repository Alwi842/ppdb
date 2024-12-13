<?php
	session_start();
	require('../includes/control.php');
	require('../includes/login.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	
	$admin_login=@$_SESSION["admin_login"];
	if ($admin_login==1) {
		$admin=$login->validate_login($conn, $admin_login);
		$jabatan=$admin[0]['jabatan'];
	}
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
	$hari_ini = date('d');
	$second = date('s');
	$jabatan=@$admin[0]['jabatan'];
	if (@!$_POST['kode_pendaftaran'] || @!$_SESSION['kode_pendaftaran']) {
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
		if ($admin_login==1) { 
			$kode_pendaftaran=$_POST['kode_pendaftaran'];
		} else if ($_SESSION['kode_pendaftaran']) {
			$kode_pendaftaran=$_SESSION['kode_pendaftaran'];
		} else {
			$pesan = '<div class="alert alert-danger">
				  <strong>Access forbidden!</strong>
				  </div>';
				  
			$_SESSION["pesan"]=$pesan;
			header("location: index.php");
		}
		$sanitized_string = mysqli_real_escape_string($conn, $kode_pendaftaran);
		$sanitized_string = htmlspecialchars($sanitized_string);
			if (strlen($sanitized_string) > 100) {
				$pesan = '<div class="alert alert-danger">
                      <strong>Data terlalu panjang!</strong>
                      </div>';
				$_SESSION["pesan"] = $pesan;
				echo $sanitized_string;
				header("location: form-pendaftaran.php");
				exit;
			}
		$kode_pendaftaran=$sanitized_string;
		
	}
	echo $kode_pendaftaran;
	//important
	//string
	$data_string = [
	  'nama_siswa' => $_POST['nama_siswa'],
	  'NISN' => @$_POST['NISN'],
	  'asal_sekolah' => $_POST['asal_sekolah'],
	  'tmp_lahir' => $_POST['tmp_lahir'],
	  'tgl_lahir' => $_POST['tgl_lahir'],
	  'jenis_kelamin' => $_POST['jenis_kelamin'],
	  'agama' => $_POST['agama'],
	  'alamat_rumah' => $_POST['alamat_rumah'],
	  'kelurahan' => $_POST['kelurahan'],
	  'kecamatan' => $_POST['kecamatan'],
	  'kab_kota' => $_POST['kab_kota'],
	  'provinsi' => $_POST['provinsi'],
	  'no_tlp' => $_POST['no_tlp'],
	  'nama_ayah' => $_POST['nama_ayah'],
	  'pekerjaan_ayah' => $_POST['pekerjaan_ayah'],
	  'penghasilan_ayah' => $_POST['penghasilan_ayah'],
	  'pendidikan_ayah' => $_POST['pendidikan_ayah'],
	  'nama_ibu' => $_POST['nama_ibu'],
	  'pekerjaan_ibu' => $_POST['pekerjaan_ibu'],
	  'penghasilan_ibu' => $_POST['penghasilan_ibu'],
	  'pendidikan_ibu' => $_POST['pendidikan_ibu'],
	  'thn_lahir_ayah' => @$_POST['thn_lahir_ayah'],
	  'thn_lahir_ibu' => @$_POST['thn_lahir_ibu'],
	];
	
	$data_string = $control->sanitize_string($conn, $data_string, 1);

	//int
	$data_int = [
	  'NIK' => @$_POST['NIK'],
	  'anak_ke' => @$_POST['anak_ke'],
	  'anak_dari' => @$_POST['anak_dari'],
	  'alamat_rt' => @$_POST['alamat_rt'],
	  'alamat_rw' => @$_POST['alamat_rw'],
	  'kode_pos' => @$_POST['kode_pos'],
	  'kelas' => @$_POST['kelas'],
	  'usia_ayah' => @$_POST['usia_ayah'],
	  'usia_ibu' => @$_POST['usia_ibu'],
	];
	
	$data_int = $control->sanitize_int($data_int, 1);
	
	//noimportant
	//string
   $data_string_no = [
	  'nama_wali' => @$_POST['nama_wali'],
	  'pekerjaan_wali' => @$_POST['pekerjaan_wali'],
	  'thn_lahir_wali' => @$_POST['thn_lahir_wali'],
	  'penghasilan_wali' => @$_POST['penghasilan_wali'],
	  'pendidikan_wali' => @$_POST['pendidikan_wali'],
	];
	$data_string_no = $control->sanitize_string($conn, $data_string_no, 0);
	//int
	$usia_wali = ['usia_wali' => @$_POST['usia_wali']];
	$usia_wali['usia_wali'] = intval($usia_wali['usia_wali']);
    if (empty($usia_wali['usia_wali'])){
        $usia_wali['usia_wali']=0;
    }
	
	//admin only
	$status=@$_POST['status'];
	if (empty($$status)){
		$status=0;
	}
	
	//files
	if ($_FILES["ijazah"]["size"] == 0) {
		$namafileijazah="notfound.jpg";
	} else {
		$targetijazah = "../ijazah/";
		$fileName = basename($_FILES["ijazah"]["name"]);
		$targetFilePath = $targetijazah . $fileName;
		$tipeijazah = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		$namafileijazah = "ijazah_".$kode_pendaftaran.".".$tipeijazah;
		$folderijazah = $targetijazah . $namafileijazah;
	}
	
	if ($_FILES["kk"]["size"] == 0) {
		$namafilekk="notfound.jpg";
	} else {
		$targetkk = "../kk/";
		$fileName = basename($_FILES["kk"]["name"]);
		$targetFilePath = $targetijazah . $fileName;
		$tipekk = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		$namafilekk = "kk_".$kode_pendaftaran.".".$tipekk;
		$folderkk = $targetkk . $namafilekk;
	}
	
	/*$targetakta = "akta/";
	$fileName = basename($_FILES["akta"]["name"]);
	$targetFilePath = $targetijazah . $fileName;
	$tipeakta = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	$namafileakta = "akta_".$kode_pendaftaran.".".$tipeakta;
	$folderakta = $targetakta . $namafilekk;*/
	
	
	$sql='SELECT * FROM `form_pendaftaran` WHERE kode_pendaftaran= ?';
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $kode_pendaftaran);
	$stmt->execute();
	$result = $stmt->get_result();
	$data = $result->fetch_all(MYSQLI_ASSOC);
	$stmt->close();
	if (!$data) {
		$status=0;
		$sql = "INSERT INTO form_pendaftaran(kode_pendaftaran, nama_siswa, asal_sekolah, NISN, NIK, tmp_lahir, tgl_lahir, jenis_kelamin, agama, anak_ke, anak_dari, nama_ayah, pekerjaan_ayah, penghasilan_ayah, usia_ayah, thn_lahir_ayah, pendidikan_ayah, nama_ibu, pekerjaan_ibu, penghasilan_ibu, usia_ibu, thn_lahir_ibu, pendidikan_ibu, nama_wali, pekerjaan_wali, penghasilan_wali, usia_wali, thn_lahir_wali, pendidikan_wali, alamat_rumah, alamat_rt, alamat_rw, kelurahan, kecamatan, kab_kota, provinsi, kode_pos, no_tlp, ijazah, kk, status, kelas ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

		$stmt = $conn->prepare($sql);

		$stmt->bind_param("ssssssssssssssssssssssssssssssssssssssssss", $kode_pendaftaran, $data_string['nama_siswa'], $data_string['asal_sekolah'], $data_string['NISN'], $data_int['NIK'], $data_string['tmp_lahir'], $data_string['tgl_lahir'], $data_string['jenis_kelamin'], $data_string['agama'], $data_int['anak_ke'], $data_int['anak_dari'], $data_string['nama_ayah'], $data_string['pekerjaan_ayah'], $data_string['penghasilan_ayah'], $data_int['usia_ayah'], $data_string['thn_lahir_ayah'], $data_string['pendidikan_ayah'], $data_string['nama_ibu'], $data_string['pekerjaan_ibu'], $data_string['penghasilan_ibu'], $data_int['usia_ibu'], $data_string['thn_lahir_ibu'], $data_string['pendidikan_ibu'], $data_string_no['nama_wali'], $data_string_no['pekerjaan_wali'], $data_string_no['penghasilan_wali'], $usia_wali['usia_wali'], $data_string_no['thn_lahir_wali'], $data_string_no['pendidikan_wali'], $data_string['alamat_rumah'], $data_int['alamat_rt'], $data_int['alamat_rw'], $data_string['kelurahan'], $data_string['kecamatan'], $data_string['kab_kota'], $data_string['provinsi'], $data_int['kode_pos'], $data_string['no_tlp'], $namafileijazah, $namafilekk, $status, $data_int['kelas']);
		echo "insert";

		$pesan = '<div class="alert alert-success">
			  <strong>Data berhasil disimpan, harap cek kembali!</strong>
			  </div>';
	} else {
		$oldnamekk = @$data[0]['kk'];
		$oldnameijazah = @$value[0]['ijazah'];
		if (!empty($oldnamekk) && file_exists("../kk/" . $oldnamekk)) {
            unlink("kk/" . $oldnamekk);
        }
        
        if (!empty($oldnameijazah) && file_exists("../ijazah/" . $oldnameijazah)) {
            unlink("../ijazah/" . $oldnameijazah);
        }
		
		if (!$admin_login==1) {
			$status=0;
		}
		$sql = "UPDATE `form_pendaftaran` SET nama_siswa = ?, asal_sekolah = ?, kode_pendaftaran = ?, NISN = ?, NIK = ?, tmp_lahir = ?, tgl_lahir = ?, jenis_kelamin = ?, agama = ?, anak_ke = ?, anak_dari = ?, nama_ayah = ?, pekerjaan_ayah = ?, penghasilan_ayah = ?, usia_ayah = ?, thn_lahir_ayah = ?, pendidikan_ayah = ?, nama_ibu = ?, pekerjaan_ibu = ?, penghasilan_ibu = ?, usia_ibu = ?, thn_lahir_ibu = ?, pendidikan_ibu = ?, nama_wali = ?, pekerjaan_wali = ?, penghasilan_wali = ?, usia_wali = ?, thn_lahir_wali = ?, pendidikan_wali = ?, alamat_rumah = ?, alamat_rt = ?, alamat_rw = ?, kelurahan = ?, kecamatan = ?, kab_kota = ?, provinsi = ?, kode_pos = ?, no_tlp = ?, ijazah = ?, kk = ?, status = ?, kelas = ? WHERE kode_pendaftaran = ?";
		
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssss", $data_string['nama_siswa'], $data_string['asal_sekolah'], $kode_pendaftaran, $data_string['NISN'], $data_int['NIK'], $data_string['tmp_lahir'], $data_string['tgl_lahir'], $data_string['jenis_kelamin'], $data_string['agama'], $data_int['anak_ke'], $data_int['anak_dari'], $data_string['nama_ayah'], $data_string['pekerjaan_ayah'], $data_string['penghasilan_ayah'], $data_int['usia_ayah'], $data_string['thn_lahir_ayah'], $data_string['pendidikan_ayah'], $data_string['nama_ibu'], $data_string['pekerjaan_ibu'], $data_string['penghasilan_ibu'], $data_int['usia_ibu'], $data_string['thn_lahir_ibu'], $data_string['pendidikan_ibu'], $data_string_no['nama_wali'], $data_string_no['pekerjaan_wali'], $data_string_no['penghasilan_wali'], $usia_wali['usia_wali'], $data_string_no['thn_lahir_wali'], $data_string_no['pendidikan_wali'], $data_string['alamat_rumah'], $data_int['alamat_rt'], $data_int['alamat_rw'], $data_string['kelurahan'], $data_string['kecamatan'], $data_string['kab_kota'], $data_string['provinsi'], $data_int['kode_pos'], $data_string['no_tlp'], $namafileijazah, $namafilekk, $status, $data_int['kelas'], $kode_pendaftaran);
		echo "update";

		$pesan = '<div class="alert alert-success">
			  <strong>Data Berhasil Di Update!</strong>
			  </div>';
	}
	$stmt->execute();
	if ($stmt->error) {
		$pesan = '<div class="alert alert-danger">
			  <strong>Data Gagal diperoses!</strong>
			  </div>';
		header("location: form-pendaftaran.php");
		echo "gagal";
		exit;
	}
	if($namafileijazah!="notfound.jpg") {
		move_uploaded_file($_FILES["ijazah"]["tmp_name"], $folderijazah);
	}
	if($namafilekk!="notfound.jpg") {
		move_uploaded_file($_FILES["kk"]["tmp_name"], $folderkk);
	}
	
	$_SESSION["pesan"] = $pesan;
	$_SESSION["kode_pendaftaran"]=$kode_pendaftaran;
	if ($admin_login==1) { 
		header("location: pratinjau-formulir?kode_pendaftaran=".$kode_pendaftaran);
	} else {
		header("location: pratinjau-formulir");
	}
?>