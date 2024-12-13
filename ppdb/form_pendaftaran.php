<?php 
	session_start();
	require('includes/control.php');
	$conn=$connection->getConnection();

	@$setting=$control->cek_ppdb_settings($conn, "tahun_ajar, status_pengumuman, pengumuman");
	@$tahun_ajar=$setting[0]['tahun_ajar'];

	require("includes/header.php");
?>
 <header class="bg-green">
	<div class="container px-5">
		<h3 class="fw-bolder text-white mb-2 text-center">FORMULIR PENDAFTARAN SMP ISLAMIC CENTRE KOTA TANGERANG</h3>
		<h3 class="fw-bolder text-white mb-2 text-center">TAHUN PELAJARAN <?php echo $tahun_ajar++."/".$tahun_ajar ?></h3>
	</div>
</header>

<div id="alert" onclick="alert_close()">
	<?php echo $control->pesan();?>
</div>

<section class="testing">
	<form action="process-input-form" method="post" enctype="multipart/form-data">
	<div class="container px-4 my-5">
		<div class="collapse multi-collapse show" id="satu">
			<div class="row gx-5 justify-content-center">
				<div class="col-lg-8 col-xl-6">
					<div class="text-center">
						<h2 class="fw-bolder">Data Diri Siswa</h2>
					</div>
				</div>
			</div>
			<div class="shadow">
				<div class="p-4 bg-light rounded-3">
					<table class="" style="width: 100%" id="input1">
						<tbody>
							<tr><td style="width: 16%">Nama<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="nama_siswa" name="nama_siswa" type="text" maxlength="50" value="" placeholder="Nama Siswa" style="width: 100%"></td></tr>
							
							<tr><td>Asal Sekolah<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="asal_sekolah" name="asal_sekolah" type="text" maxlength="50" value="" placeholder="Asal Sekolah" style="width: 100%"></td></tr>
							
							<tr><td>NISN<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="NISN" name="NISN" type="number" maxlength="11" value="" placeholder="NISN" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></td></tr>
							
							<tr><td>NIK<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="NIK" name="NIK" type="number" maxlength="17" value="" placeholder="NIK" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></td></tr>
							
							<tr><td>Tempat / Tgl Lahir<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="tmp_lahir" name="tmp_lahir" type="text" maxlength="25" value="" placeholder="tempat" style="width: 100%"></td></tr>
							<tr><td></td>
							<td>
							<input class="form-control" required id="tgl_lahir" name="tgl_lahir" type="date" maxlength="25" value="" placeholder=""></td></tr>
							<tr><td>Jenis Kelamin<a style="color:red;" >*</a></td>
							<td>
							<input required id="jenis_kelamin1" class="form-check-input" name="jenis_kelamin" type="radio" value="L" placeholder="" required><label class="form-check-label" for="jenis_kelamin1">
								Laki-laki
							 </label> </td></tr>
							<tr><td></td>
							<td>
							<input required id="jenis_kelamin2" class="form-check-input" name="jenis_kelamin" type="radio"  value="P" placeholder=""><label class="form-check-label" for="jenis_kelamin2">
								Perempuan
							 </label> </td></tr>
							
							<tr><td>Agama<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="agama" name="agama" type="text" maxlength="12" value="" placeholder="Agama" style="width: 100%">
							</td></tr>
							
							<tr><td>Anak Ke<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="anak_ke" name="anak_ke" type="number" maxlength="1" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></td></tr>
							<tr><td>Saudara Kandung<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="anak_dari" name="anak_dari" type="number" maxlength="1" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></td></tr>
							
							<tr><td>Alamat Rumah<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="alamat_rumah" name="alamat_rumah" type="text" maxlength="50" value="" placeholder="Alamat rumah" style="width: 100%"></td></tr>
							<tr>
							<td>RT<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="alamat_rt" name="alamat_rt" type="number" maxlength="3" value="" placeholder="RT" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></td>
							</tr>		
							<tr><td>RW<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="alamat_rw" name="alamat_rw" type="number" maxlength="3" value="" placeholder="RW" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">		</td>
							</tr>
							
							<tr><td>Kelurahan<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="kelurahan" name="kelurahan" type="text" maxlength="50" value="" placeholder="Kelurahan" style="width: 100%"></td></tr>
							
							<tr><td>Kecamatan<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="kecamatan" name="kecamatan" type="text" maxlength="50" value="" placeholder="Kecamatan" style="width: 100%">		</td></tr>
							
							<tr><td>Kab / Kota<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="kab_kota" name="kab_kota" type="text" maxlength="50" value="" placeholder="Kab/Kota" style="width: 100%"></td></tr>
							
							<tr><td>Provinsi<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="provinsi" name="provinsi" type="text" maxlength="50" value="" placeholder="Provinsi" style="width: 100%"></td></tr>
							
							<tr><td>Kode Pos<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="kode_pos" name="kode_pos" type="text" maxlength="6" value="" placeholder="Kode Pos" style="width: 100%"></td></tr>
							
							<tr><td>No. Telp / HP<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="no_tlp" name="no_tlp" type="text" maxlength="14" value="" placeholder="No. Telp/HP" style="width: 100%"></td></tr>
							<tr><td>Ijazah asli</td>
							<td>
								<label class="btn btn-info text-white" id="ijazah_btn" for="ijazah" onchange="fileName(1)">Pilih</label>
								<input class="form-control" id="ijazah" name="ijazah" type="file" maxlength="0" value="" placeholder="ijazah" accept="image/png, image/jpeg"  onchange="fileName(1)" hidden>	</td>
							</tr>
							
							<tr><td>KK asli</td>
							<td>
								<label class="btn btn-info text-white" id="kk_btn" for="kk" onchange="fileName(2)">Pilih</label>
								<input class="form-control" id="kk" name="kk" type="file" maxlength="0" value="" placeholder="kk" accept="image/png, image/jpeg" onchange="fileName(2)" hidden></td>
							</tr>
							<tr><td>Kelas<a style="color:red;" >*</a></td>
							<td>
							<input id="kelas1" class="form-check-input" name="kelas" type="radio" value="0" placeholder="" required>
							<label class="form-check-label" for="kelas1">
								Reguler
							</label>
							</td></tr>
							<tr><td></td>
							<td>
							<input id="kelas2" class="form-check-input" name="kelas" type="radio" value="1" placeholder="" required>
							<label class="form-check-label" for="kelas2" >
								Plus
							 </label>
							</td></tr>
						</tbody>
					</table>
				</div>
			</div>
			<p><a style="color:red;" >*</a> Wajib diisi</p>
			<div class="d-flex justify-content-between mt-3">
			  <div>
				 
			  </div>
			  <div>
				 <a class="btn btn-primary text-white" role="button" id="next">Selanjutnya</a>
			  </div>
			</div>
		</div>
		
		<div class="collapse multi-collapse" id="dua">
			<div class="row gx-5 justify-content-center">
				<div class="col-lg-8 col-xl-6">
					<div class="text-center">
						<h2 class="fw-bolder">Data Diri Orang Tua / Wali</h2>
					</div>
				</div>
			</div>
			<div class="shadow">
				<div class="p-4 bg-light rounded-3">
					<table class="" style="width: 100%">
						<tbody>
							<tr><td colspan=2 class="fw-bolder text-center"><u>Data Diri Ayah kandung</td></tr>
							<tr><td style="width: 16%">Nama<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="nama_ayah" name="nama_ayah" type="text" maxlength="50" value="" placeholder="Nama Ayah Kandung" style="width: 100%"></td></tr>
							
							<tr><td>Pekerjaan<a style="color:red;">*</a></td>
							<td>
								<input class="form-control" required id="pekerjaan_ayah" name="pekerjaan_ayah" type="text" maxlength="50" value="" placeholder="Pekerjaan ayah" style="width: 100%"></td></tr>
								
							<tr><td>Penghasilan / Bulan<a style="color:red;" >*</a></td>
							<td>
							<select class="form-select" required id="penghasilan_ayah" name="penghasilan_ayah" style="width: 100%">
								<option value="" selected="" hidden="">NONE</option>
								<option value="Tidak Berpenghasilan">Tidak Berpenghasilan</option>
								<option value="Kurang dari Rp. 500,000">&lt; Rp. 500 rb</option>
								<option value="Rp. 500,000 - Rp. 999,999">Rp. 500 rb - Rp. 1jt</option>
								<option value="Rp. 1,000,000 - Rp. 1,999,999">Rp. 1 jt</option>
								<option value="Rp. 2,000,000 - Rp. 4,999,999">Rp. 2 Jt - Rp. 4 jt</option>
								<option value="Rp. 5,000,000 - Rp. 20,000,000">Rp. 5 jt - Rp. 20jt</option>
							</select>
							</td></tr>
							
							<tr><td>Usia<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="usia_ayah" name="usia_ayah" type="number" maxlength="3" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"> 
							</td></tr>
							<tr><td>Tahun Lahir<a style="color:red;" >*</a></td>
							<td> 
							<input class="form-control" required id="thn_lahir_ayah" name="thn_lahir_ayah" type="number" maxlength="4" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">		</td></tr>
							<tr><td>Pendidikan<a style="color:red;" >*</a></td>
							<td>
							<select class="form-select" required id="pendidikan_ayah" name="pendidikan_ayah" style="width: 100%">
								<option value="" selected="" hidden="">NONE</option>
								<option value="Tidak sekolah">Tidak sekolah</option>
								<option value="SD / sederajat">SD / sederajat</option>
								<option value="SMP / sederajat">SMP / sederajat</option>
								<option value="SMA / sederajat">SMA / sederajat</option>
								<option value="D1">D1</option>
								<option value="D2">D2</option>
								<option value="D3">D3</option>
								<option value="S1">S1</option>
								<option value="S2">S2</option>
								<option value="S3">S3</option>
							</select>
							</td></tr>
							<tr><td colspan=2><hr/></td></tr>
							<tr><td colspan=2 class="fw-bolder text-center"><u>Data Diri Ibu kandung</td></tr>
							<tr><td>Nama<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="nama_ibu" name="nama_ibu" type="text" maxlength="50" value="" placeholder="Nama Ibu Kandung" style="width: 100%"></td></tr>
							
							<tr><td>Pekerjaan<a style="color:red;" >*</a></td>
							<td>
								<input class="form-control" required id="pekerjaan_ibu" name="pekerjaan_ibu" type="text" maxlength="50" value="" placeholder="Pekerjaan" style="width: 100%"></td></tr>
							
							<tr><td>Penghasilan / Bulan<a style="color:red;" >*</a></td>
							<td>
							<select class="form-select" required id="penghasilan_ibu" name="penghasilan_ibu" style="width: 100%">
								<option value="" selected="" hidden="">NONE</option>
								<option value="Tidak Berpenghasilan">Tidak Berpenghasilan</option>
								<option value="Kurang dari Rp. 500,000">&lt; Rp. 500 rb</option>
								<option value="Rp. 500,000 - Rp. 999,999">Rp. 500 rb - Rp. 1jt</option>
								<option value="Rp. 1,000,000 - Rp. 1,999,999">Rp. 1 jt</option>
								<option value="Rp. 2,000,000 - Rp. 4,999,999">Rp. 2 Jt - Rp. 4 jt</option>
								<option value="Rp. 5,000,000 - Rp. 20,000,000">Rp. 5 jt - Rp. 20jt</option>
							</select>
							</td></tr>
							
							<tr><td>Usia<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="usia_ibu" name="usia_ibu" type="number" maxlength="3" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">		</td></tr>
							<tr><td>Tahun Lahir<a style="color:red;" >*</a></td>
							<td>
							<input class="form-control" required id="thn_lahir_ibu" name="thn_lahir_ibu" type="number" maxlength="4" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">		</td></tr>
							
							<tr><td>Pendidikan<a style="color:red;" >*</a></td>
							<td>
							<select class="form-select" required id="pendidikan_ibu" name="pendidikan_ibu" style="width: 100%">
								<option value="" hidden="">NONE</option>
								<option value="Tidak sekolah">Tidak sekolah</option>
								<option value="SD / sederajat">SD / sederajat</option>
								<option value="SMP / sederajat">SMP / sederajat</option>
								<option value="SMA / sederajat">SMA / sederajat</option>
								<option value="D1">D1</option>
								<option value="D2">D2</option>
								<option value="D3">D3</option>
								<option value="S1">S1</option>
								<option value="S2">S2</option>
								<option value="S3">S3</option>
							</select>
							</td></tr>
							
							<tr><td colspan=2><hr/></td></tr>
							<tr><td colspan=2 class="fw-bolder text-center"><u>Data Diri Wali</td></tr>
							<tr><td>Nama Wali</td>
							<td>
								<input class="form-control" id="nama_wali" name="nama_wali" type="text" maxlength="50" value="" placeholder="Nama Wali" style="width: 100%"></td></tr>
							
							<tr><td>Pekerjaan</td>
							<td>
								<input class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" type="text" maxlength="50" value="" placeholder="Pekerjaan" style="width: 100%"></td></tr>
							
							<tr><td>Penghasilan / Bulan</td>
							<td>
							<select class="form-select" id="penghasilan_wali" name="penghasilan_wali" style="width: 100%" >
								<option value="" hidden="">NONE</option>
								<option value="Tidak Berpenghasilan">Tidak Berpenghasilan</option>
								<option value="Kurang dari Rp. 500,000">&lt; Rp. 500 rb</option>
								<option value="Rp. 500,000 - Rp. 999,999">Rp. 500 rb - Rp. 1jt</option>
								<option value="Rp. 1,000,000 - Rp. 1,999,999">Rp. 1 jt</option>
								<option value="Rp. 2,000,000 - Rp. 4,999,999">Rp. 2 Jt - Rp. 4 jt</option>
								<option value="Rp. 5,000,000 - Rp. 20,000,000">Rp. 5 jt - Rp. 20jt</option>
							</select>
							</td></tr>
							
							<tr><td>Usia</td>
							<td>
								<input class="form-control" id="usia_wali" name="usia_wali" type="number" maxlength="3" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"> 
							</td></tr>		
							<tr><td>Tahun Lahir</td>
							<td>
								<input class="form-control" id="thn_lahir_wali" name="thn_lahir_wali" type="number" maxlength="4" value="" placeholder="" style="width: 100%" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">		</td></tr>
							
							<tr><td>Pendidikan</td>
							<td>
							<select class="form-select" id="pendidikan_wali" name="pendidikan_wali" style="width: 100%"><a style="color:red;" >*</a>
								<option value="" hidden="">NONE</option>
								<option value="Tidak sekolah">Tidak sekolah</option>
								<option value="SD / sederajat">SD / sederajat</option>
								<option value="SMP / sederajat">SMP / sederajat</option>
								<option value="SMA / sederajat">SMA / sederajat</option>
								<option value="D1">D1</option>
								<option value="D2">D2</option>
								<option value="D3">D3</option>
								<option value="S1">S1</option>
								<option value="S2">S2</option>
								<option value="S3">S3</option>
							</select>
							</td></tr>
						</tbody>
					</table>
				</div>
			</div>
			<p><a style="color:red;" >*</a> Wajib diisi</p>
			<div class="d-flex justify-content-between mt-3">
			  <div>
				 <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="satu dua" onclick="scrol()">Kembali</button>
			  </div>
			  <div>
				<button class="btn btn-info text-white" onclick="scrol()">submit</button>
			  </div>
			</div>
			<div class="d-flex justify-content-between mt-3 fw-bolder">
			  <div>
			  </div>
			  <div>
				Pastikan data sudah dimasukan
			  </div>
			</div>
		</div>
		 
	</div>
	</form>
</section>
</body>
<script>
function scrol(){
	scrollTo(0,0);
}

document.addEventListener('change', function() {
	var target = event.target;
  if (target.value === '') {
    target.setCustomValidity('This field is required.');
	target.style.borderColor = 'red';
  } else {
    target.setCustomValidity('');
	target.style.borderColor = '';
  }
});

var input1 = document.getElementById('input1');
var multiCollapseElements = document.querySelectorAll('.multi-collapse');
var inputs1 = input1.querySelectorAll('input[required]');
document.addEventListener('click', function() {
	var pass=1;
	var radio=0;
	var target = event.target;
	if (target.id === 'next') {
		for (const input of inputs1) {
			if (input.value === '' && input.type!=="radio") {
			  input.style.borderColor = 'red';
			  pass=0;
			  radio=0;
			} else if (input.type=="radio") {
				if (input.checked===false) {
					radio++;
					input.style.borderColor = 'red';
				}
			} else {
				radio=0;
			}
			//console.log(radio);
			if (radio>=2) {
			    pass=0;
			}
		}
		if (pass===1) {
			$('.testing .collapse').collapse('toggle');
			scrol();
		}
	}
});
</script>
<?php require("includes/footer.php"); ?>

