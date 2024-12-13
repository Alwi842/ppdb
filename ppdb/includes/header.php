<?php
$admin_login=@$_SESSION["admin_login"];
$jabatan=@$_SESSION["jabatan"];
?>
<html lang="id">
<head>
  <title>SMP ISLAMIC CENTRE</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="pendaftaran smp islamic centre kota tangerang" />
  <meta name="author" content="Alwi abdullah royyan" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css"></link>
  <script src="js/main.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <link rel="icon" type="image/x-icon" href="img/logo-iscen.png" />
  <link href="font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/styles.css" rel="stylesheet" />
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jspdf.umd.min.js"></script>
  <!-- Bootstrap core JS-->
  <script src="js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/scripts.js"></script>
</head>
<?php if ($setting[0]['status_pengumuman']==1 && @$location!="process") { ?>
	<div style="background-color:Tomato;">
		<marquee scrolldelay="100">
			<span style="color:white;"><b>
			<?php echo $setting[0]['pengumuman']; ?>
			</b></span>
		</marquee>
	</div>
<?php } 
if($admin_login==1 && @$jabatan=='panitia') {
	include("header-panitia.php");
} else if($admin_login==1 && @$jabatan=='admin') {
	include("header-admin.php");
} else include("header-user.php");
?>