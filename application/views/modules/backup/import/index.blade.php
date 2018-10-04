@layout('commons/index')
@section('title')Beranda@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('backup')}}">Backup</a></li>
<li class="breadcrumb-item active">Import Saldo Awal</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#upload" role="tab">Import Saldo</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#kamus-kategori" role="tab">Kamus Kategori</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#kamus-organisasi" role="tab">Kamus Organisasi</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#kamus-ruangan" role="tab">Kamus Ruangan</a>
					</li>
				</ul>
			</div>
			<div class="card-body tab-content">
				<div class="tab-pane active" id="upload">
					<h4 class="card-title">Import Saldo Awal</h4>
					<p class="card-text">Import saldo awal ke SIMBMD Pasuruan.<br>Format data harus sesuai dengan format export excel yang dapat diunduh
						dibawah.<br>Untuk mencegah terjadinya kegagalan proses import akibat data yang terlalu banyak, maka jumlah data yang dapat
					diunggah dibatasi {{$this->config->item('import_max_rows')}} baris.</p>
					<div class="mb-5"></div>
					<form action="{{site_url('backup/import/upload')}}" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-md-2 col-form-label text-right">Jenis Aset</label>
							<div class="col-md-6">
								<select name="kib" class="form-control">
									<option value="">Pilih Jenis KIB...</option>
									<option value="a">KIB-A</option>
									<option value="b">KIB-B</option>
									<option value="c">KIB-C</option>
									<option value="d">KIB-D</option>
									<option value="e">KIB-E</option>
									<option value="g">KIB-G</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label text-right">Pilih Berkas</label>
							<div class="col-md-6">
								<input type="file" class="form-control" name="berkas" accept=".xls, .xlsx" required/>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label text-right"></label>
							<div class="col-md-6">
								<p class="help-text">* Maksimal ukuran file adalah 1,5MB</p>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-2 col-form-label text-right"></label>
							<div class="col-md-6">
								<button type="submit" class="btn btn-primary"><i class="fa fa-upload mr-2"></i> Unggah</button>
								<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i> Batal</button>
							</div>
						</div>
					</form>
					<hr>
					<h5>Unduh Format Berkas.</h5>
					<div class="form-inline mt-3">
						<a href="{{site_url('res/docs/format/saldo_aset_a.xls')}}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-cubes mr-2"></i>KIB-A</a>
						<a href="{{site_url('res/docs/format/saldo_aset_b.xls')}}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-car mr-2"></i>KIB-B</a>
						<a href="{{site_url('res/docs/format/saldo_aset_c.xls')}}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-home mr-2"></i>KIB-C</a>
						<a href="{{site_url('res/docs/format/saldo_aset_d.xls')}}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-road mr-2"></i>KIB-D</a>
						<a href="{{site_url('res/docs/format/saldo_aset_e.xls')}}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-book mr-2"></i>KIB-E</a>
						<a href="{{site_url('res/docs/format/saldo_aset_g.xls')}}" class="btn btn-secondary btn-sm mr-2"><i class="fa fa-window-restore mr-2"></i>KIB-G</a>
					</div>
				</div>

				<!-- KAMUS KATEGORI -->
				<div id="toolbar-a">
					<p>1. Apabila ingin melakukan pencarian berdasarkan kode, awali kata kunci dengan simbol $. Misal $1.2.3.5.6<br>
					2. pencarian kode tidak harus 5 digit. Bisa melakukan pencarian 1 hingga 5 digit. Misal $2 atau $1.1.2</p>
				</div>
				<div class="tab-pane" id="kamus-kategori">
					<table class="jq-table" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('backup/api/get_kategori')}}" data-toolbar='#toolbar-a'>
						<thead>
							<tr>
								<th data-class='text-nowrap text-center' data-field='kd_golongan'>KD1</th>
								<th data-class='text-nowrap text-center' data-field='kd_bidang'>KD2</th>
								<th data-class='text-nowrap text-center' data-field='kd_kelompok'>KD3</th>
								<th data-class='text-nowrap text-center' data-field='kd_subkelompok'>KD4</th>
								<th data-class='text-nowrap text-center' data-field='kd_subsubkelompok'>KD5</th>
								<th data-class='text-nowrap text-left' data-field='nama' data-width='60%'>NAMA</th>
								<th data-class='text-nowrap text-center' data-field='id'>ID (id_kategori)</th>
							</tr>
						</thead>
					</table>
				</div>

				<!-- KAMUS ORGANISASI -->
				<div id="toolbar-b">
					<p>1. Apabila ingin melakukan pencarian berdasarkan kode, awali kata kunci dengan simbol $. Misal $1.2.3.5<br>
					2. pencarian kode tidak harus 4 digit. Bisa melakukan pencarian 1 hingga 4 digit. Misal $2 atau $1.1.2</p>
				</div>
				<div class="tab-pane" id="kamus-organisasi">
					<table class="jq-table" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('backup/api/get_organisasi')}}" data-toolbar='#toolbar-b'>
						<thead>
							<tr>
								<th data-class='text-nowrap text-center' data-field='kd_bidang'>KD1</th>
								<th data-class='text-nowrap text-center' data-field='kd_unit'>KD2</th>
								<th data-class='text-nowrap text-center' data-field='kd_subunit'>KD3</th>
								<th data-class='text-nowrap text-center' data-field='kd_upb'>KD4</th>
								<th data-class='text-nowrap text-left' data-field='nama' data-width='60%'>NAMA</th>
								<th data-class='text-nowrap text-center' data-field='id'>ID (id_organisasi)</th>
							</tr>
						</thead>
					</table>
				</div>

				<!-- KAMUS RUANGAN -->
				<div class="tab-pane" id="kamus-ruangan">
					<table class="jq-table" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('backup/api/get_ruangan')}}">
						<thead>
							<tr>
								<th data-class='text-nowrap text-center' data-field='id'>ID (id_ruangan)</th>
								<th data-class='text-nowrap text-left' data-field='organisasi'>UPB</th>
								<th data-class='text-nowrap text-center' data-field='kode'>Kode Ruangan</th>
								<th data-class='text-nowrap text-left' data-field='nama'>Nama Ruangan</th>
								<th data-class='text-nowrap text-left' data-field='penanggung_nama'>Penanggung Jawab</th>
								<th data-class='text-nowrap text-left' data-field='penanggung_nip'>NIP</th>
								<th data-class='text-nowrap text-left' data-field='penanggung_jabatan'>Jabatan</th>
							</tr>
						</thead>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="row mt-3">
	<div class="col">
		<div class="card">
			<div class="card-header">Tata Cara Pengisian Data Import</div>
			<div class="card-body">
				<p>Ada beberapa hal yang perlu diperhatikan ketika mengisi data import.<br>Dimohon untuk mengikuti petunjuk berikut untuk meminimalisir
				terjadinya error dalam proses import data.</p>
				<p>
					1. Format Excel harus menggunakan format yang telah disediakan.<br>
					2. Unggah file sesuai dengan jenis KIB yang dipilih. Mengunggah file yang tidak sesuai dengan jenis
					kib menyebabkan data tidak match.<br>
					3. Kolom yang berwarna merah adalah kolom yang tidak boleh dikosongi.<br>
					4. Kolom <b>kondisi</b> diisi dengan indikator angka. Berikut indikatornya: <b>1 = Baik, 2 = Kurang Baik, 3 = Rusak Berat.</b><br>
					5. Kolom <b>Nilai</b> tidak boleh diisi dengan format <i>currency</i> dan harus diisi dengan angka tanpa titik. Misal 2000000<br>
					6. Apabila nilai memiliki angka desimal, maka desimal dipisahkan dengan <b>tanda titik (.)</b> bukan koma (,). Misal 2000000.56<br>
					7. Kolom <b>kd_pemilik</b> diisi dengan indikator angka, daftar indikasinya bisa dilihat dibawah.<br>
					8. Kolom <b>id_kategori</b>, <b>id_organisasi</b> dan <b>id_ruangan</b> diisi dengan kode yang sudah disediakan oleh sistem. Kode dapat dilihat di tab <b>Kamus kategori</b>, <b>Kamus Organisasi</b> dan <b>Kamus Ruangan</b> dihalaman ini.<br>
					9. Nama kolom pada format excel tidak boleh diganti karena nama tersebut berkaitan dengan nama kolom di database.<br>
					10. Untuk KDP / KIB-F, diimport sesuai dengan jenis KDP. Misal KDP gedung maka diimport pada KIB-C namun kolom <b>id_kategori</b> tetap disini dengan kode KDP (cari dikamus kategori untuk nomor id KDP).<br>
					11. Untuk kolom <b>beton</b>, <b>tingkat</b>, dan <b>kontruksi</b> merupakan isian Ya/Tidak. Gunakan indikator nomor dengan nilai <b>1 = Ya</b> dan <b>0 = Tidak.</b>
				</p>
				<hr>
				<h5>Indikator KD_PEMILIK</h5><br>
				<b>00</b> - Pemerintah Pusat<br>
				<b>01</b> - Departemen Dalam Negeri<br>
				<b>11</b> - Pemerintah Provinsi<br>
				<b>12</b> - Pemerintah Kabupaten/Kota<br>
				<b>22</b> - Desa<br>
				<b>33</b> - BOT/BTO/BT<br>
				<b>44</b> - Instansi Lainnya<br>
				<b>98</b> - Extracomtable
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
.hidden{display: none;}
</style>
<link rel="stylesheet" href="{{base_url('res/plugins/bttable/bttable.css')}}">
@end

@section('script')
<script src="{{base_url('res/plugins/bttable/bttable.js')}}"></script>
<script>
	theme.activeMenu('.nav-backup');
	// INIT Datatables
	$(".jq-table").bootstrapTable({
		formatRecordsPerPage: function () {
			return ''
		},
		formatShowingRows: function () {
			return ''
		}
	});
</script>
@end