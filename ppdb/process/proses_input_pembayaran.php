<?php
	session_start();
	require('control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn);
	@$tahun_ajar=$setting[0]['tahun_ajar'];
	$tahun_ini = date('Y');
	$bulan_ini = date('m');

	$admin_login=@$_SESSION["admin_login"];
	$data=$control->main($conn, $admin_login);
	$admin=$control->admin($conn);
    $jabatan=$admin[0]['jabatan'];
    $control->admin_login($_SESSION["admin_login"], 'admin', $jabatan);
    $value=array();
    $post=array();
    $number=0;
    if (@$_GET['action']=="hapus") {
    	$sql="DELETE FROM bayar WHERE `bayar`.`kode_bayar` ='".@$_GET['kode_bayar']."'";
    	$query = mysqli_query($conn, $sql);
    	header("location: input_pembayaran.php");
    }
    foreach (@$_POST as $key => $value) {
        $post[$number++]= htmlspecialchars($value);
    	echo "<p>".$post[$number-1];
    }
    
    if ($post[0]=="tambah") {
    	$sql='SELECT * FROM bayar';
    	$result = $conn -> query($sql);
    	$data = $result -> fetch_all(MYSQLI_ASSOC);
    	$lap=0;
    	if ($data) foreach ($data as $key => $value) {
    		$lap++;
    	}
    	$tahun=$tahun_ini-2000;
    	$post[0]="PPDB".$tahun.$bulan_ini.$hari_ini.$lap;
    }
    
    $sql='SELECT * FROM `bayar` WHERE kode_bayar="'.$post[0].'"';
    $result = $conn -> query($sql);
    $data = $result -> fetch_all(MYSQLI_ASSOC);
    if($data) {
    	$sql='UPDATE `bayar` SET kode_bayar="'.$post[0].'", nama_bayar="'.$post[1].'", jumlah_bayar="'.$post[2].'", target="'.$post[3].'" WHERE kode_bayar="'.$post[0].'"';
    } else {
    	$sql='INSERT INTO bayar VALUES ("'.$post[0].'", "'.$post[1].'", "'.$post[2].'", "'.$post[3].'")';
    }
    $query = mysqli_query($conn, $sql);
    if (!$query) {
    	$pesan = '<div class="alert alert-danger">
    			  <strong>Data Gagal Di ubah!</strong>
    			  </div>';
    	$_SESSION["pesan"] = $pesan;
    			  header("location: input_pembayaran.php?kode_bayar=".$post[0]);
    }
    $sql='DELETE FROM `rincian` WHERE kode_bayar="'.$post[0].'"';
    $query = mysqli_query($conn, $sql);
    for ($i=4;$i<count($post);$i++) {
    	$sql='INSERT INTO rincian VALUES ("'.$post[0].'", "'.$post[$i++].'", "'.$post[$i].'")';
    	$query = mysqli_query($conn, $sql);
    	if (!$query) {
    	$pesan = '<div class="alert alert-danger">
    			  <strong>Data Gagal Di ubah!</strong>
    			  </div>';
    	$_SESSION["pesan"] = $pesan;
    			  header("location: input_pembayaran.php?kode_bayar=".$post[0]);
    	}
    }
    $pesan = '<div class="alert alert-success">
    			  <strong>Data Berhasil Di Update!</strong>
    			  </div>';
    $_SESSION["pesan"] = $pesan;  
    header("location: input_pembayaran.php?kode_bayar=".$post[0]);
?>