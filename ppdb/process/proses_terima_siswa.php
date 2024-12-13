<?php
	session_start();
	require('../includes/control.php');
	require('../includes/login.php');
	$conn=$connection->getConnection();
	
	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	
	@$setting=$control->cek_ppdb_settings($conn, "*");
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');
    $hari_ini = date('d');
    $second = date('s');
	
	if ($bulan_ini>=@$setting[0]['gel1'] && $bulan_ini<=@$setting[0]['gel1']) {
		$gelombang=1;
	} else if ($bulan_ini>=@$setting[0]['gel2'] && $bulan_ini<=@$setting[0]['gel2']) {
		$gelombang=2;
	} else if ($bulan_ini>=@$setting[0]['gel3'] && $bulan_ini<=@$setting[0]['gel2']) {
		$gelombang=3;
	} else {
		$gelombang=4;
	}
	
    $value=array();
    $diskon=array();
    $number=0;
    foreach ($_POST as $key => $value) {
        $post[$number]= htmlspecialchars($value);
        $number++;
    }
	for ($i=3; $i<=6;$i++){
		$post[$i] = $control->filder_sanitize_int($post[$i]);
	}
	$post[3];
     $_SESSION['kode_pendaftaran']=$post[0];
     $_SESSION['kode_pembayaran']=$post[1];
    $sql = "SELECT * FROM riwayat_pembayaran_ppdb WHERE kode_pendaftaran='".$post[0]."' AND kode_bayar='".$post[1]."'";
    $result = $conn -> query($sql);
    $data = $result -> fetch_all(MYSQLI_ASSOC);
    if(!$data) {
    	$sql='INSERT INTO riwayat_pembayaran_ppdb (kode_pendaftaran, kode_bayar, gelombang, bayar1, bayar2, bayar3, bayar4, ID)VALUES ("'.$post[0].'", "'.$post[1].'", "'.$post[2].'", "'.$post[3].'","'.$post[4].'","'.$post[5].'","'.$post[6].'","'.$post[7].'")';
    } else {
    	$sql='UPDATE `riwayat_pembayaran_ppdb` SET bayar1="'.$post[3].'", bayar2="'.$post[4].'", bayar3="'.$post[5].'", bayar4="'.$post[6].'" WHERE kode_pendaftaran="'.$post[0].'"';
    }
    $query = mysqli_query($conn, $sql);
    if (!$query) {
    	$pesan = '<div class="alert alert-danger">
    			  <strong>Data Gagal Di ubah!</strong>
    			  </div>';
    	$_SESSION["pesan"] = $pesan;
    	header("location: terima-siswa");
    }
    $sql='INSERT INTO log_pembayaran_ppdb (kode_pendaftaran, kode_bayar, gelombang, bayar1, bayar2, bayar3, bayar4, ID)VALUES ("'.$post[0].'", "'.$post[1].'", "'.$post[2].'", "'.$post[3].'","'.$post[4].'","'.$post[5].'","'.$post[6].'","'.$post[7].'")';
    $query = mysqli_query($conn, $sql);
    
    $timestamp = date("Y-m-d H:i:s");
    $total=$post[3]+$post[4]+$post[5]+$post[6];
    $siswa=$control->cek_pendaftaran($conn, $post[0]);
    $bayar=$control->cek_bayar($conn, $post[1]);
    if ($total>=$bayar[0]['jumlah_bayar'] && $siswa[0]['status']!=2) {
    	$sql='UPDATE `form_pendaftaran` SET status=2 WHERE kode_pendaftaran="'.$post[0].'"';
    	$query = mysqli_query($conn, $sql);
    } else if ($siswa[0]['status']!=1) {
    	$sql='UPDATE `form_pendaftaran` SET status=1 WHERE kode_pendaftaran="'.$post[0].'"';
    	$query = mysqli_query($conn, $sql);
    }
    if (!$siswa[0]['tgl_diterima']) {
    	$sql='UPDATE `form_pendaftaran` SET tgl_diterima="'.$timestamp.'" WHERE kode_pendaftaran="'.$post[0].'"';
    	$query = mysqli_query($conn, $sql);
    }
    header("location: petinjau-pembayaran");
?>