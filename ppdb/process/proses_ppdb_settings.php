<?php
	session_start();
	require('../includes/control.php');
	require('../includes/login.php');
	$conn=$connection->getConnection();

	$admin_login=@$_SESSION["admin_login"];
	$admin=$login->validate_login($conn, $admin_login);
	$jabatan=$admin[0]['jabatan'];
	$login->verivy_privilege($_SESSION["admin_login"], 'admin', $jabatan);
	
    $tahun_ajar = $control->filder_sanitize_int($_POST['tahun_ajar']);
    $gel1 = $control->filder_sanitize_int($_POST['gel1']);
    $gel1_end = $control->filder_sanitize_int($_POST['gel1_end']);
    $gel2 = $control->filder_sanitize_int($_POST['gel2']);
    $gel2_end = $control->filder_sanitize_int($_POST['gel2_end']);
    $gel3 = $control->filder_sanitize_int(@$_POST['gel3']);
    $gel3_end = $control->filder_sanitize_int(@$_POST['gel3_end']);
    $kode_bayar_reg= $control->filder_sanitize_string($conn, @$_POST['kode_bayar_reg']);
    $kode_bayar_plus= $control->filder_sanitize_string($conn, @$_POST['kode_bayar_plus']);
    $min_gel1 = $control->filder_sanitize_int(@$_POST['min_gel1']);
    $min_gel1_plus = $control->filder_sanitize_int(@$_POST['min_gel1_plus']);
    $min_gel2 = $control->filder_sanitize_int(@$_POST['min_gel2']);
    $min_gel2_plus = $control->filder_sanitize_int(@$_POST['min_gel2_plus']);
    $min_gel3 = $control->filder_sanitize_int(@$_POST['min_gel3']);
    $min_gel3_plus = $control->filder_sanitize_int(@$_POST['min_gel3_plus']);
    $pengumuman = $control->filder_sanitize_string($conn, @$_POST['pengumuman']);
    $status_pengumuman = @$_POST['status_pengumuman'];
    $update_button = $control->filder_sanitize_int(@$_POST['update_button']);
    if ($update_button=="simpan & terapkan") {
    	$sql='UPDATE `ppdb_settings` SET status_settings=0 WHERE status_settings=1';
    	$query = mysqli_query($conn, $sql);
    	$status_settings=1;
		
    } else $status_settings=0;
    $sql='SELECT * FROM `ppdb_settings` WHERE tahun_ajar="'.$tahun_ajar.'"';
    $result = $conn -> query($sql);
    $data = $result -> fetch_all(MYSQLI_ASSOC);
    if (!$data) {
    	$sql='INSERT INTO ppdb_settings VALUES ("'.$tahun_ajar.'", "'.$gel1.'", "'.$gel1_end.'", "'.$gel2.'", "'.$gel2_end.'", "'.$gel3.'", "'.$gel3_end.'", "'.$kode_bayar_reg.'", "'.$kode_bayar_plus.'", "'.$min_gel1.'", "'.$min_gel1_plus.'", "'.$min_gel2.'", "'.$min_gel2_plus.'", "'.$min_gel3.'", "'.$min_gel3_plus.'", "'.$pengumuman.'", "'.$status_pengumuman.'","'.$status_settings.'")';
    } else {
    	if ($data[0]['status_settings']==1) $status_settings=1;
    	$sql='UPDATE `ppdb_settings` SET tahun_ajar="'.$tahun_ajar.'", gel1="'.$gel1.'", gel1_end="'.$gel1_end.'", gel2="'.$gel2.'", gel2_end="'.$gel2_end.'", gel3="'.$gel3.'", gel3_end="'.$gel3_end.'", kode_bayar_reg="'.$kode_bayar_reg.'",  kode_bayar_plus="'.$kode_bayar_plus.'", min_gel1="'.$min_gel1.'", min_gel1_plus="'.$min_gel1_plus.'", min_gel2="'.$min_gel2.'", min_gel2_plus="'.$min_gel2_plus.'", min_gel3="'.$min_gel3.'", min_gel3_plus="'.$min_gel3_plus.'", pengumuman="'.$pengumuman.'", status_pengumuman="'.$status_pengumuman.'", status_settings="'.$status_settings.'" WHERE tahun_ajar="'.$tahun_ajar.'"';
    }
	$query = mysqli_query($conn, $sql);
	$pesan = '<div class="alert alert-success">
			  <strong>Pengaturan berhasil disimpan!</strong>
			  </div>';
	if (!$query) {
		$pesan = '<div class="alert alert-danger">
			  <strong>Data Gagal Di ubah!</strong>
			  </div>';
	}
	$_SESSION["pesan"]=$pesan;
	header("location: pengaturan-ppdb");
?>