<?php 
require("connect.php");
class control{
	public function pesan(){
		if(!empty($_SESSION["pesan"])) {
			echo $_SESSION["pesan"];
			unset($_SESSION["pesan"]);	
		}
	}
	
	public function status($a){
		if ($a==0) {
			echo "<a class='alert alert-danger'>
					<strong>BELUM DITERIMA</strong><a>
					<div class='horizontal'>
					<p><a>harap ke TU SMP islamic centre untuk pembayaran pendaftaran
					<p><a>atau
					<p><a>Transfer ke rekening BTN Nomor : 0051001550000054 AN SMP Yayasan Islamic Centre(Bukti Transfer Dikirim ke WA : 0812 1934 6366)";
		} else if ($a==1) {
			echo "<a class='alert alert-success'>
					<strong>DITERIMA</strong>";
		} else if ($a==2) {
			echo "<a class='alert alert-success'>
					<strong>DITERIMA DAN LUNAS</strong>";
		}
	}
	
public function edit_form($conn, $kode_pendaftaran) {
    $stmt = $conn->prepare("SELECT * FROM form_pendaftaran WHERE kode_pendaftaran = ?");
    $stmt->bind_param("s", $kode_pendaftaran);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    return $data;
}

public function input($id, $name_output, $length, $type, $value) {
    $add = "";
    if ($type === "number") {
        $add = 'style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"';
    } else if ($type === "radio") {
        if ($value === $length) {
            $add = "checked";
        }
        $value = $length;
    } else if ($type === "file") {
        $add = 'accept="image/png, image/jpeg" style="visibility:hidden;" onchange="fileName(1)"';
    } else if ($type === "file2") {
        $add = 'accept="image/png, image/jpeg" style="visibility:hidden;" onchange="fileName(2)"';
        $type = 'file';
    } else {
        $add = 'style="width: 100%"';
    }
    if ($id === "NIS") {
        $add .= " readonly";
    }
    echo '<input id="'.$id.'" name="'.$id.'" type="'.$type.'" maxlength="'.$length.'" value="'.$value.'" placeholder="'.$name_output.'" '.$add.'></input>';
}
	
	public function list_pendaftaran($conn, $type){
		if ($type=='filter') {
			$sql = "SELECT * FROM form_pendaftaran";
			if ($_SESSION['kelas']!='semua' || $_SESSION['status']!='semua') $sql=$sql.' WHERE ';
			
			if ($_SESSION['kelas']=='reguler') {
				$sql=$sql."kelas=0";
			} else if ($_SESSION['kelas']=='plus') {
				$sql=$sql."kelas=1";
			}
			if ($_SESSION['kelas']!='semua' && $_SESSION['status']!='semua') $sql=$sql." AND ";
			if ($_SESSION['status']=='belum_diterima') {
				$sql=$sql."status=0";
			} else if ($_SESSION['status']=='belum_lunas') {
				$sql=$sql."status=1";
			} else if ($_SESSION['status']=='diterima') {
				$sql=$sql."status=2";
			}
		} else if ($type=='cari') {
			$sql = "SELECT * FROM form_pendaftaran WHERE ";
			if ($_SESSION['tipe_cari']==1) {
				$sql=$sql." nama_siswa LIKE '%".$_SESSION['input_cari']."%'";
			} else if ($_SESSION['tipe_cari']==2) {
				$sql=$sql." kode_pendaftaran LIKE '%".$_SESSION['input_cari']."%'";
			}
		} else if ($type=='clear') {
			$sql = "SELECT * FROM form_pendaftaran ORDER BY tgl_pengisian DESC";
			unset($_SESSION['cari_btn']);
			unset($_SESSION['cari']);
			unset($_SESSION['filter']);
		} else {
			$sql = "SELECT * FROM form_pendaftaran ORDER BY tgl_pengisian DESC";
		}
		$result = $conn -> query($sql);
			$data = $result -> fetch_all(MYSQLI_ASSOC);
			if(!$data) {
				$pesan = '<div class="alert alert-danger">
						  <strong>Data kosong!</strong>
						  </div>';
					$_SESSION["pesan"]=$pesan;
				return $data;
			}
		return $data;
	}
	public function delete($conn, $kode_pendaftaran){
		$sql = "DELETE FROM form_pendaftaran WHERE kode_pendaftaran=$kode_pendaftaran";
		$result = $conn -> query($sql);
		if(!$result) {
			$pesan = '<div class="alert alert-danger">
					  <strong>Data masih kosong!</strong>
					  </div>';
			echo $pesan;
			header("location: preview_form.php");
		}
		$pesan = '<div class="alert alert-danger">
					  <strong>Data sudah di hapus, silakan isi form kembali!</strong>
					  </div>';
		session_start();
		$_SESSION["pesan"]=$pesan;
		header("location: form_pendaftaran.php");
	}
	public function delete_list($conn, $kode_pendaftaran){
		session_start();
		$sql = "DELETE FROM form_pendaftaran WHERE kode_pendaftaran=$kode_pendaftaran";
		$result = $conn -> query($sql);
		if(!$result) {
			$pesan = '<div class="alert alert-danger">
					  <strong>Data $kode_pendaftaran, masih kosong!</strong>
					  </div>';
			$_SESSION["pesan"]=$pesan;
			header("location: list");
			exit;
		}
		$pesan = '<div class="alert alert-danger">
					  <strong>Data sudah di hapus, silakan isi form kembali!</strong>
					  </div>';
		
		$_SESSION["pesan"]=$pesan;
		header("location: list");
	}
	public function cek_pendaftaran($conn, $kode_pendaftaran){
		if ($kode_pendaftaran) {
			$stmt = $conn->prepare("SELECT kode_pendaftaran, nama_siswa, status, tgl_diterima FROM form_pendaftaran WHERE kode_pendaftaran = ?");
			$stmt->bind_param("i", $value1);
			$value1 = $kode_pendaftaran;
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result -> fetch_all(MYSQLI_ASSOC);
			if(!$data) {
				$pesan = '<div class="alert alert-danger">
						  <strong>Kode Pendaftaran tidak dapat ditemukan!</strong>
						  </div>';
				$_SESSION["pesan"]=$pesan;
			}
		return $data;
		} else {
			$pesan = '<div class="alert alert-danger">
						  <strong>Masukan kode pendaftaran!</strong>
						  </div>';
			$_SESSION["pesan"]=$pesan;
		}
	}
	public function terima_siswa($conn, $kode_pendaftaran){
		if ($kode_pendaftaran) {
			$sql = "SELECT * FROM form_pendaftaran WHERE kode_pendaftaran = '$kode_pendaftaran'";
			$result = $conn -> query($sql);
			$data = $result -> fetch_all(MYSQLI_ASSOC);
			if(!$data) {
				$pesan = '<div class="alert alert-danger">
						  <strong>Kode Pendaftaran tidak dapat ditemukan!</strong>
						  </div>';
				$_SESSION["pesan"]=$pesan;
			}
		return $data;
		} else {
			$pesan = '<div class="alert alert-danger">
						  <strong>Masukan kode pendaftaran!</strong>
						  </div>';
			$_SESSION["pesan"]=$pesan;
			
		}
	}
	public function cek_ppdb_settings($conn, $param){
		$sql = "SELECT ".$param." FROM ppdb_settings WHERE status_settings = 1";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		if(!$data) {
			$pesan = '<div class="alert alert-danger">
					  <strong>PPDB Belum Di Atur!</strong>
					  </div>';
			$_SESSION["pesan"]=$pesan;
		} else {
			return $data;
		}
	}
	public function settings_ppdb($conn, $tahun_ajar){
		$sql = "SELECT * FROM ppdb_settings WHERE tahun_ajar = ".$tahun_ajar;
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		$tahun_ajar2=$tahun_ajar+1;
		if(!$data) {
			$pesan = '<div class="alert alert-danger">
					  <strong>PPDB '.$tahun_ajar.'/'.$tahun_ajar2.' Belum Di Atur!</strong>
					  </div>';
			$_SESSION["pesan"]=$pesan;
		} else {
			return $data;
		}
	}
	public function cek_bayar($conn, $kode_bayar){
		$sql = "SELECT * FROM bayar WHERE kode_bayar='".$kode_bayar."'";
		if ($kode_bayar == "all") { 
		   $sql = "SELECT * FROM bayar ORDER BY kode_bayar DESC";
		}
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		if(!$data) {
			$pesan = '<div class="alert alert-danger">
					  <strong>Pembayaran Belum Di Atur!</strong>
					  </div>';
			$_SESSION["pesan"]=$pesan;
		} else {
			return $data;
		}
	}
	
	public function cek_bayar_setting($conn, $target){
		$sql = "SELECT * FROM bayar WHERE target='".$target."'";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		if(!$data) {
			$pesan = '<div class="alert alert-danger">
					  <strong>Pembayaran Belum Di Atur!</strong>
					  </div>';
			$_SESSION["pesan"]=$pesan;
		} else {
			return $data;
		}
	}
	public function cek_rincian($conn, $kode_bayar){
		$sql = "SELECT * FROM rincian WHERE kode_bayar='".$kode_bayar."'";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		if(!$data) {
			$pesan = '<div class="alert alert-danger">
					  <strong>Pembayaran Belum Di Atur!</strong>
					  </div>';
			$_SESSION["pesan"]=$pesan;
		} else {
			return $data;
		}
	}
	public function cek_riwayat_pembayaran($conn, $kode_pendaftaran){
		$sql = "SELECT * FROM riwayat_pembayaran_ppdb WHERE kode_pendaftaran='".$kode_pendaftaran."'";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		if(!$data) {
			return 0;
		} else {
			return $data;
		}
	}
	public function ambil_kode_pembayaran($conn, $kode_pendaftaran){
		$sql = "SELECT * FROM `riwayat_pembayaran_ppdb` WHERE kode_pendaftaran='".$kode_pendaftaran."'";
		$result = $conn -> query($sql);
		$data = $result -> fetch_all(MYSQLI_ASSOC);
		return $data[0]['kode_bayar'];
	}

	function sanitize_string($conn, $data_string, $important){
		foreach ($data_string as $key => $value) {
			if (empty($value) && $important==1) {
				$pesan = '<div class="alert alert-danger">
                      <strong>Pastikan data terinput dengan benar!</strong>
                      </div>';
				$_SESSION["pesan"] = $pesan;
				return 0;
			} else if ($important==0){
				$value="None";
			}
			$sanitized_string = mysqli_real_escape_string($conn, $value);
			$sanitized_string = htmlspecialchars($sanitized_string);
			if (strlen($sanitized_string) > 100) {
				$pesan = '<div class="alert alert-danger">
                      <strong>Data terlalu panjang!</strong>
                      </div>';
				$_SESSION["pesan"] = $pesan;
				return 0;
			}
			$data_string[$key]=$sanitized_string;
		}
		return $data_string;
	}
	
	function sanitize_int($data_int, $important){
		foreach ($data_int as $key => $value) {
			if (empty($value) && $important==1 && $value!=0) {
				$pesan = '<div class="alert alert-danger">
                      <strong>Pastikan data terinput dengan benar!</strong>
                      </div>';
				$_SESSION["pesan"] = $pesan;
				echo "Pastikan data terinput dengan benar";
				exit;
			} else if ($important==0){
				$value=0;
			}
		    $sanitized_integer = intval($value);
		    $data_int[$key]=$sanitized_integer;
		}
		return $data_int;
	}
	
	function filder_sanitize_string($conn, $data_string){
		$data_string = filter_var($data_string, FILTER_SANITIZE_STRING);
		$data_string = mysqli_real_escape_string($conn, $data_string);
		return $data_string;
	}
	function filder_sanitize_int($data_int){
		$data_int =  intval($data_int);
		return $data_int;
	}
	function bulan($bln){
		if ($bln==1) {
			return "Januari";
		} else if ($bln==2) {
			return "Februari";
		} else if ($bln==3) {
			return "Maret";
		} else if ($bln==4) {
			return "April";
		} else if ($bln==5) {
			return "Mei";
		} else if ($bln==6) {
			return "Juni";
		} else if ($bln==7) {
			return "Juli";
		} else if ($bln==8) {
			return "Agustus";
		} else if ($bln==9) {
			return "September";
		} else if ($bln==10) {
			return "Oktober";
		} else if ($bln==11) {
			return "November";
		} else if ($bln==12) {
			return "Desember";
		}
		return false;
	}
}

$control= new control();
/*
$action=@$_GET['action'];
if (@$action==1){
	$control->cek_login($connection);
}
if (@$action==2){
	$kode_pendaftaran=$_GET['kode_pendaftaran'];
	$conn=$connection->getConnection();
	$control->delete($conn, $kode_pendaftaran);
}*/

?>