<?php
class fetchBeranda {
	public function fetchAll($conn) {
		$values=array();
		$sql = "SELECT * FROM `form_pendaftaran` WHERE kelas=0";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[0]=$total;
		$sql = "SELECT * FROM `form_pendaftaran` WHERE kelas=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[1]=$total;
		$values[2]=$values[0]+$values[1];
		
		$sql = "SELECT * FROM `form_pendaftaran` WHERE status=0 AND kelas=0";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[3]=$total;
		
		$sql = "SELECT * FROM `form_pendaftaran` WHERE status=1 AND kelas=0";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[4]=$total;
		
		$sql = "SELECT * FROM `form_pendaftaran` WHERE status=2 AND kelas=0";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[5]=$total;
		
		$sql = "SELECT * FROM `form_pendaftaran` WHERE status=0 AND kelas=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[6]=$total;
		
		$sql = "SELECT * FROM `form_pendaftaran` WHERE status=1 AND kelas=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[7]=$total;
		
		$sql = "SELECT * FROM `form_pendaftaran` WHERE status=2 AND kelas=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total++;
		}
		$values[8]=$total;
		$values[9]=$values[3]+$values[6];
		$values[10]=$values[4]+$values[7];
		$values[11]=$values[5]+$values[8];
		
		$sql = "SELECT * FROM `ppdb_settings` where status_settings=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		@$kode_bayar_reg=$data[0]['kode_bayar_reg'];
		@$kode_bayar_plus=$data[0]['kode_bayar_plus'];
		
		$sql = "SELECT * FROM `bayar` where kode_bayar='".$kode_bayar_reg."'";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		@$bayar_reg=$data[0]['jumlah_bayar'];
		
		$sql = "SELECT * FROM `bayar` where kode_bayar='".$kode_bayar_plus."'";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		@$bayar_plus=$data[0]['jumlah_bayar'];
		
		$sql = "SELECT kode_pendaftaran FROM `form_pendaftaran` WHERE kelas=0 AND status=0";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total=$total+$bayar_reg;
		}
		$values[12]=$total;
		
		$sql = "SELECT kode_pendaftaran FROM `form_pendaftaran` WHERE kelas=0 AND status=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		$lap=0;
		foreach ($data as $key => $value) {
			$sql = "SELECT * FROM `riwayat_pembayaran_ppdb` WHERE kode_pendaftaran='".$value['kode_pendaftaran']."'";
			$result = $conn -> query($sql);
			$data2 = $result -> fetch_all(MYSQLI_ASSOC);
			if ($data2) $total=$total+$data2[0]['bayar1']+@$data2[0]['bayar2']+@$data2[0]['bayar3']+@$data2[0]['bayar4'];
			$lap++;
		}
		$values[13]=$total;
		$values[14]=$lap*$bayar_plus;
		
		$sql = "SELECT kode_pendaftaran FROM `form_pendaftaran` WHERE kelas=0 AND status=2";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		$lap=0;
		foreach ($data as $key => $value) {
			$sql = "SELECT * FROM `riwayat_pembayaran_ppdb` WHERE kode_pendaftaran='".$value['kode_pendaftaran']."'";
			$result = $conn -> query($sql);
			$data2 = $result -> fetch_all(MYSQLI_ASSOC);
			if ($data2) $total=$total+$data2[0]['bayar1']+@$data2[0]['bayar2']+@$data2[0]['bayar3']+@$data2[0]['bayar4'];
			$lap++;
		}
		$values[15]=$total;
		
		$sql = "SELECT kode_pendaftaran FROM `form_pendaftaran` WHERE kelas=1 AND status=0";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		foreach ($data as $key => $value) {
			$total=$total+$bayar_plus;
		}
		$values[16]=$total;
		
		$sql = "SELECT kode_pendaftaran FROM `form_pendaftaran` WHERE kelas=1 AND status=1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		$lap=0;
		foreach ($data as $key => $value) {
			$sql = "SELECT * FROM `riwayat_pembayaran_ppdb` WHERE kode_pendaftaran='".$value['kode_pendaftaran']."'";
			$result = $conn -> query($sql);
			$data2 = $result -> fetch_all(MYSQLI_ASSOC);
			if ($data2) $total=$total+$data2[0]['bayar1']+@$data2[0]['bayar2']+@$data2[0]['bayar3']+@$data2[0]['bayar4'];
			$lap++;
		}
		$values[17]=$total;
		$values[18]=$lap*$bayar_plus;
		
		$sql = "SELECT kode_pendaftaran FROM `form_pendaftaran` WHERE kelas=1 AND status=2";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$total=0;
		$lap=0;
		foreach ($data as $key => $value) {
			$sql = "SELECT * FROM `riwayat_pembayaran_ppdb` WHERE kode_pendaftaran='".$value['kode_pendaftaran']."'";
			$result = $conn -> query($sql);
			$data2 = $result -> fetch_all(MYSQLI_ASSOC);
			if ($data2) $total=$total+$data2[0]['bayar1']+@$data2[0]['bayar2']+@$data2[0]['bayar3']+@$data2[0]['bayar4'];
			$lap++;
		}
		$values[19]=$total;
		return $values;
	}
}
?>