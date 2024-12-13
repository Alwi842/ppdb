<?php
class login{
	public function validate_login($conn, $admin_login) {
        if ($admin_login == 1) {
			$username = @$_SESSION["username"];
			$stmt = $conn->prepare("SELECT password, jabatan, nama FROM admin WHERE username=?");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_all(MYSQLI_ASSOC);
			if (!$data) {
				session_destroy();
				$pesan = '<div class="alert alert-danger">
						  <strong>Username/Password admin salah!</strong>
						  </div>';

				$_SESSION["pesan"] = $pesan;
				header("location: beranda");
			} else {
				$password = @$_SESSION["password"];
				$isPasswordCorrect = password_verify($password, $data[0]['password']);
				if ($isPasswordCorrect) {
					$_SESSION["password"] = $password;
					$_SESSION["username"] = $username;
					$_SESSION["admin_login"] = 1;
					$_SESSION["jabatan"]=$data[0]['jabatan'];
					
					return $data;
				} else {
				  $pesan = '<div class="alert alert-danger">
						  <strong>Username/Password admin salah!</strong>
						  </div>';

					$_SESSION["pesan"] = $pesan;
					header("location: beranda");
				}
			}
            
        } else {
			session_destroy();
			$pesan = '<div class="alert alert-danger"> <strong>Session telah berahir!</strong></div>';
			$_SESSION["pesan"] = $pesan;
			header("location: beranda");
		}
    }
	public function verivy_privilege($admin_login, $require, $curr) {
        if ($admin_login != 1 || !($require == $curr || $curr == 'admin')) {
            $pesan = '<div class="alert alert-danger">
                      <strong>akses dilarang!</strong>
                      </div>';

            $_SESSION["pesan"] = $pesan;
            header("location: index.php");
        }
    }
	
	public function verification($verifikasi){
		//*CreateUser#Password123
		$isVerifiedCorrect = password_verify($verifikasi, '$2y$12$S1wDNJFSNuHoJrLcCIMt/On1kOQ75wmIEEmauif9W7RHhN4CvSUmq');
		if (!$isVerifiedCorrect) {
		  $pesan = '<div class="alert alert-danger">
					  <strong>Kode verifikasi salah!</strong>
					  </div>';
			$_SESSION["pesan"] = $pesan;
			return true;
		}
		return false;
	}
	
	function checkUsernameExists($conn, $username) {
	  $sql = 'SELECT COUNT(*) FROM admin WHERE username = ?';
	  $stmt = $conn->prepare($sql);
	  $stmt->bind_param('s', $username);
	  $stmt->execute();

	  $result = $stmt->get_result();
	  $num_rows = $result->fetch_row()[0];

	  return $num_rows > 0;
	}
}
$login=new login();
?>