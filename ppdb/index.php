<?php
session_start();
require('includes/control.php');
$connection=new Connection();
$conn=$connection->getConnection();

@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
@$tahun_ajar=$setting[0]['tahun_ajar'];
require("includes/header.php");
?>
            <header class="bg-green py-5">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center justify-content-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <div class="my-5 text-center text-xl-start">
                                <h1 class="display-5 fw-bolder text-white mb-2">PENDAFTARAN SEKARANG DIBUKA</h1>
                                <p class="lead fw-normal text-white mb-4">SMP Islamic Centre Tangerang Menerima Peserta Didik baru! </p>
                                <p class="lead fw-normal text-white mb-4">TAHUN PENDIDIKAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <a class="btn btn-primary btn-lg px-4 me-sm-3" href="alur">Daftar Sekarang!</a>
                                    <a class="btn btn-outline-light btn-lg px-4" href="cek-pendaftaran">Cek Pendaftaran</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-6 d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="img/logo-iscen.png" alt="..." />
						</div>
                    </div>
                </div>
            </header>
            <div id="alert" onclick="alert_close()">
            	<?php echo $control->pesan(); ?>
            </div>
			
            <!-- Features section-->
            <section class="py-5" id="features">
                <div class="container px-5 my-5">
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">Awal yang bagus untuk sukses di masa depan.</h2></div>
                        <div class="col-lg-8">
                            <div class="row gx-5 row-cols-1 row-cols-md-2">
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                    <h2 class="h5">EKSTRA KURIKULER</h2>
                                    <p class="mb-0">SMP Islamic Centre memiliki beraneka ragam ekstra kurikuler.</p>
                                </div>
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i></div>
                                    <h2 class="h5">FASILITAS</h2>
                                    <p class="mb-0">SMP Islamic Centre memiliki fasilitas yang lengkap untuk menopang proses pembelajaran.</p>
                                </div>
                                <div class="col mb-5 mb-md-0 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                                    <h2 class="h5">STAF PENGAJAR</h2>
                                    <p class="mb-0">Tenaga Pendidik kami merupakan hasil seleksi yang ketat dari sisi profesionalisme mengajar dan mendidik. Disiplin Pendidikannya sesuai dengan materi pembelajaran serta memiliki dukungan pengabdian tinggi terhadap keberlangsungan kegiatan Belajar dan Mengajar.</p>
                                </div>
                                <div class="col h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-card-checklist"></i></div>
                                    <h2 class="h5">PROGRAM SEKOLAH</h2>
                                    <p class="mb-0">SMP Islamic Centre sudah ter-Akreditasi A serta kami menerapkan Kurikulum K13 dengan 2 (dua) program kelas :
									</p>
									<ul style="list-style-type:lower-alpha">
										<li>Reguler adalah Kelas Kualitas SMP Islamic Centre dengan biaya pendidikan yang lebih terjangkau.</li>
										<li>Plus/Unggulan adalah kelas yang menggunakan fasilitas terbaik di SMP Islamic Centre Ditambah tahfidz.</li>
									</ul>
                                </div>
                            </div>
							<p>yang disinergikan dengan kurikulum keagamaan untuk membentuk pribadi berkarakter dan memiliki penguasaan IPTEK dan IMTAQ sehingga bisa bersaing dan menghadapi Era Global dengan tetap mengedepankan Akhlak sesuai Dengan Visi SMP Islamic Centre</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Testimonial section-->
            <div class="py-5 bg-light">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-10 col-xl-7">
                            <div class="text-center">
                                <div class="fs-4 mb-4 fst-italic">"Banyak pengalaman yang tak terduga yang saya dapatkan dari sekolah yang saya cintai ini, mulai dari pengalamana akademik sampai dengan pengalaman sosial. Dengan lingkungan ketarunaan membuat saya mengerti arti displin dan kekompakan, dengan teman-teman seperjuangan. Sungguh pengalaman yang luar biasa yang bisa saya dapatkan bersama dengan bapak dan ibu guru yang luar biasa serta senior dan teman-teman yang luar biasa juga!"</div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img class="rounded-circle me-3" src="img/EZAR.jpeg" alt="..." />
                                    <div class="fw-bold">
                                        Ezar Ardiyantoro
                                        <span class="fw-bold text-primary mx-1">/</span>
                                        alumni SMP Islamic Centre, 2006
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog preview section-->
            <section class="py-5">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">Galeri Iscen</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                               <div class="img-container cropped">
								<div id="carouselExampleIndicators" class="carousel slide img-container" data-ride="carousel">
								  <div class="carousel-inner">
									<div class="carousel-item active">
									  <img class="d-block w-100" src="img/4.jpg" alt="First slide">
									</div>
									<div class="carousel-item">
									  <img class="d-block w-100" src="img/5.jpg" alt="Second slide">
									</div>
									<div class="carousel-item">
									  <img class="d-block w-100" src="img/6.jpg" alt="Third slide">
									</div>
								  </div>
								</div>
							</div>
                                <div class="card-body p-4">
                                    <a class="text-decoration-none link-dark stretched-link"><h5 class="card-title mb-3">FASILITAS</h5></a>
                                    <p class="card-text mb-0">
									<p>Sekolah SMP Islamic Centre Sudah dilengkapi fasilitas :</p>
									<ul>
										<li>Gedung Permanen Milik Sendiri</li>
										<li>Ruangan ber-AC (nyaman dan kondusif)</li>
										<li>Laboratorium Bahasa</li>
										<li>Laboratorium Komputer</li>
										<li>Laboratorium IPA</li>
										<li>Sarjana Ibadah</li>
										<li>Ruang Multimedia</li>
										<li>Ruang Musik</li>
										<li>Perpustakaan</li>
										<li>Taman Wawasan Lingkungan</li>
									</ul>
									</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                <div class="img-container cropped">
									<div id="carouselExampleIndicators" class="carousel slide img-container" data-ride="carousel">
									  <div class="carousel-inner shadow">
										<div class="carousel-item active">
										  <img class="d-block w-100" src="img/7.jpg" alt="First slide">
										</div>
										<div class="carousel-item">
										  <img class="d-block w-100" src="img/8.jpg" alt="Second slide">
										</div>
										<div class="carousel-item">
										  <img class="d-block w-100" src="img/9.jpg" alt="Third slide">
										</div>
									  </div>
									</div>
								</div>
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2"></div>
                                    <a class="text-decoration-none link-dark stretched-link"><h5 class="card-title mb-3">EKSTRA KURIKULER</h5></a>
                                    <p class="card-text mb-0">Sekolah SMP Islamic Centre Memiliki kegiatan Ekstra kulikuler :
										<ul>
											<li>Kesenian Daerah</li>
											<li>Karate</li>
											<li>Pencak Silat</li>
											<li>Pramuka</li>
											<li>PMR</li>
											<li>Rohis</li>
											<li>Futsal</li>
											<li>Marawis</li>
											<li>Band</li>
											<li>Broadcasting</li>
											<li>Komputer</li>
											<li>Paskibra</li>
											<li>Basket</li>
											<li>Pencinta Lingkungan</li>
										</ul>
									</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 shadow border-0">
                                	<div class="img-container cropped">
									<div id="carouselExampleIndicators" class="carousel slide img-container" data-ride="carousel">
									  <div class="carousel-inner">
										<div class="carousel-item active">
										  <img class="d-block w-100" src="img/10.jpg" alt="First slide">
										</div>
										<div class="carousel-item">
										  <img class="d-block w-100" src="img/11.jpg" alt="Second slide">
										</div>
										<div class="carousel-item">
										  <img class="d-block w-100" src="img/12.jpg" alt="Third slide">
										</div>
									  </div>
									</div>
								</div>
                                <div class="card-body p-4">
                                    <div class="badge bg-primary bg-gradient rounded-pill mb-2"></div>
                                    <a class="text-decoration-none link-dark stretched-link"><h5 class="card-title mb-3">STAF PENGAJAR</h5></a>
                                     <p class="card-text mb-0">
									Tenaga Pendidik kami merupakan hasil seleksi yang ketat dari sisi profesionalisme mengajar dan mendidik.
									</p>
									<p class="card-text mb-0">
									Disiplin Pendidikannya sesuai dengan materi pembelajaran serta memiliki dukungan pengabdian tinggi terhadap keberlangsungan kegiatan Belajar dan Mengajar
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Call to action-->
                    <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                        <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                            <div class="mb-4 mb-xl-0">
                                <div class="fs-3 fw-bold text-white">Ayo! Daftar sekarang!</div>
                                <div class="text-white-50">Daftar sekarang untuk masa depan yang lebih baik!</div>
                            </div>
                            <div class="ms-xl-4">
                                <div class="input-group mb-2">
									<a class="btn btn-outline-light" href="alur">Daftar</a>
                                </div>
                                <div class="small text-white-50">We care about privacy, and will never share your data.</div>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
<?php require("includes/footer.php"); ?>