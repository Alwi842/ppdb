<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0" id="nav">
		<?php if ($setting[0]['status_pengumuman']==1 && @$location!="process") { ?>
			<div style="background-color:Tomato;">
				<marquee scrolldelay="100">
					<span style="color:white;"><b>
					<?php echo $setting[0]['pengumuman']; ?>
					</b></span>
				</marquee>
			</div>
		<?php } ?>
            <!-- Navigation-->
          <nav class="navbar navbar-expand-lg bg-green text-white font-weight-bold">
                <div class="container px-5">
                    <a href="beranda"><img src="img/logo-iscen.png" alt="Logo" style="width:40px;" href="beranda"></a>
		<a class="navbar-brand" href="beranda">PPDB <?php 
		if($admin_login==1 && @$jabatan=='admin') echo "Admin";
		if($admin_login==1 && @$jabatan=='panitia') echo "Panitia"; ?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="beranda">Beranda</a></li>
							 <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Daftar</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="form-pendaftaran">Daftar</a></li>
                                    <li><a class="dropdown-item" href="cek-pendaftaran">Cek Pendaftaran</a></li>
									 <li><a class="dropdown-item" href="alur">Alur Pendaftaran</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="rincian">Rincian</a></li>
                            <?php if($admin_login==1 && @$jabatan=='panitia') { ?>
							
			  <li class="nav-item active">
				<a class="nav-link" href="list?showtotal=10">Laporan</a>
			  </li>
			  <?php } ?>
			  <?php if($admin_login==1 && @$jabatan=='admin') { ?>
			  <li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" id="dropdownMenuButton" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Alat Admin
				  </a>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="dashboard">Beranda Admin</a>
					<a class="dropdown-item" href="terima-siswa">Bayar Pendaftaran</a>
					<a class="dropdown-item" href="ubah-form">Ubah data siswa</a>
					<a class="dropdown-item" href="list?showtotal=10">Laporan</a>
					<a class="dropdown-item" href="input-pembayaran">Pengaturan Pembayaran</a>
					<a class="dropdown-item" href="pengaturan-ppdb">Pengaturan</a>
				  </div>
			  </li>
			  
			  <?php } 
			  if ($admin_login==1) { ?>
			  <li class="nav-item">
			    <a id="logout" class="nav-link" onclick="logout()"  style=" cursor: pointer;">LOG OUT</a>
			  </li>
			  <?php } else { ?>
			  <li class="nav-item <?php if($location=="login") echo "active";?>">
				<a class="nav-link" href="login">Login</a>
			  </li>
			  <?php }?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
	</main>
</body>