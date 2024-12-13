<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0" id="nav">
	  <nav class="navbar navbar-expand-lg bg-green text-white font-weight-bold">
		<div class="container px-5">
		<a href="beranda"><img src="img/logo-iscen.png" alt="Logo" style="width:40px;" href="beranda"></a>
		<a class="navbar-brand text-white" href="beranda">PPDB ADMIN</a>
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
					<a class="dropdown-item" href="buat-user">Buat Admin</a>
				  </div>
				</li>
			  <li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">LOG OUT</a></li>
			</ul>
		</div>
		</div>
	  </nav>
	  
	</main>
	<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Log out</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        apakah kamu yakin ingin keluar??
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <a href="logout" class="btn btn-primary">Ya</a>
      </div>
    </div>
  </div>
</div>
</body>