function fileName(file){
	if (file==1) {
		filename_ijazah=document.getElementById("ijazah").files[0].name;
		document.getElementById("ijazah_btn").innerHTML=filename_ijazah;
	} else {
		filename_kk=document.getElementById("kk").files[0].name;
		document.getElementById("kk_btn").innerHTML=filename_kk;
	}
}

function print_pendaftaran(nama, kode_pendaftaran){
	window.jsPDF = window.jspdf.jsPDF;
	var doc = new jsPDF('l', 'mm', [123, 69]);
	doc.addImage("img/logo-iscen.png", "JPEG", 2, 2, 20, 20);
	doc.text(24, 10, 'PPDB SMP Islamic Centre Tangerang');
	doc.text(24, 17, 'Kartu Pendaftaran Siswa.');
	doc.line(1, 24, 120, 24);
	doc.text(5, 35, 'Nama : '+nama);
	doc.text(5, 45, 'Kode Pendaftaran : '+kode_pendaftaran);
	// Save the PDF
	doc.save(''+nama+kode_pendaftaran+'PPDB.pdf');
}
function show_list() {
	var nilai=document.getElementById("show").value;
	window.location.replace("list?page=1&showtotal="+nilai);
}

function getWidth() {
  return Math.max(
    document.body.scrollWidth,
    document.documentElement.scrollWidth,
    document.body.offsetWidth,
    document.documentElement.offsetWidth,
    document.documentElement.clientWidth
  );
}
function alert_close(){
	var element = document.getElementById("alert");
	element.remove();
	console.log("asd");
}
function diskon(){
	var diskon=0;
	var plus=0;
	var sisa=document.getElementById('sisa').value;
	for (var i=1;i<=5;i++) {
		var id=document.getElementById("diskon"+i);
		if (id.checked==true) {
			plus=id.placeholder;
			diskon=parseInt(diskon)+parseInt(plus);
		}
		document.getElementById('jml_bayar').max=parseInt(sisa)-parseInt(diskon);
	}
	document.getElementById("total_diskon").innerHTML="Rp. "+diskon;
}

function tambah_rincian(){
	for (var i=1;i<99;i++) {
		if (document.getElementById('rincian_nama_bayar'+i)==null) {
			var number=i;
			break;
		}
	}
	const tr1 = document.createElement("tr");
	const td1 = document.createElement("td");
	const txt1 = document.createTextNode("Nama Rincian");
	td1.appendChild(txt1);
	const td2 = document.createElement("td");
	const txt2 = document.createTextNode(":");
	td2.appendChild(txt2);
	const td3 = document.createElement("td");
	const input = document.createElement("input");
	input.id="rincian_nama_bayar"+i;
	input.name="rincian_nama_bayar"+i;
	input.placeholder="Nama Rincian";
	input.type="text";
	input.required=true;
	input.style="width: 100%";
	td3.appendChild(input);
	tr1.appendChild(td1);
	tr1.appendChild(td2);
	tr1.appendChild(td3);

	const tr2 = document.createElement("tr");
	const td4 = document.createElement("td");
	const txt3 = document.createTextNode("Jumlah");
	td4.appendChild(txt3);
	const td5 = document.createElement("td");
	const input2 = document.createElement("input");
	const td6 = document.createElement("td");
	const txt4 = document.createTextNode(":");
	td6.appendChild(txt4);
	input2.id="jumlah_bayar"+i;
	input2.name="jumlah_bayar"+i;
	input2.placeholder="Jumlah Bayar";
	input2.type="number";
	input2.required=true;
	input2.oninput=rincian_total;
	input2.style="width: 100%";
	td5.appendChild(input2);
	tr2.appendChild(td4);
	tr2.appendChild(td6);
	tr2.appendChild(td5);
	document.getElementById("mytable").appendChild(tr1);
	document.getElementById("mytable").appendChild(tr2);
}
function hapus_rincian() {
	for (var i=1;i<99;i++) {
		if (document.getElementById('rincian_nama_bayar'+i)==null) {
			if (i>2) {
				var select = document.getElementById('mytable');
				select.removeChild(select.lastChild);
				select.removeChild(select.lastChild);
				if (document.getElementById('rincian_nama_bayar'+(i-1))!=null && i>2) {
					select.removeChild(select.lastChild);
					select.removeChild(select.lastChild);
				}
			}
			this.rincian_total();
			break;
		}
	}
}
function rincian_total(){ 
	var calculate=0;
	var jumlah_bayar=document.getElementById('jumlah_bayar');
	var sisa_bayar=document.getElementById('sisa_bayar');
	var preview_bayar=document.getElementById('preview_bayar');
	var temp=document.getElementById('temp').value;
	for (var i=1;i<4;i++) {
		var nilai=document.getElementById("jml_bayar"+i).value;
		calculate=parseInt(nilai)+parseInt(calculate);
	}
	if (isNaN(calculate)) {
		jumlah_bayar.innerHTML="Input tidak falid";
		sisa_bayar.innerHTML="Input tidak falid";
		preview_bayar.innerHTML="Input tidak falid";
	} else {
		jumlah_bayar.innerHTML="Rp. "+calculate;
		sisa2=parseInt(temp)-parseInt(calculate);
		sisa_bayar.innerHTML="Rp. "+sisa2;
		preview_bayar.innerHTML="Rp. "+calculate;
	}
	
}
function jumlahbayar() {
	var jml_bayar=document.getElementById('jml_bayar').value;
	document.getElementById('jumlah_bayar').innerHTML= "Rp. "+jml_bayar;
}

