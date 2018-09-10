@layout('commons/index')
@section('title')Koreksi Atribut@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{$ref?site_url('persetujuan/koreksi_atribut'):site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{$ref?site_url('persetujuan/koreksi_atribut'):site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Hapus</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
@if(!$ref)
<div class="form-inline">
	<div class="btn-group mb-3 ml-auto">
		<button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
		@if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
		<button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
		<a href="{{site_url('koreksi/atribut/index/finish_transaction/'.$koreksi->id)}}" class="btn btn-success" onclick="return confirm('Anda yakin? Data tidak dapat disunting jika telah diajukan.')"><i class="fa fa-check mr-2"></i>Selesaikan Transaksi</a>
		@elseif($koreksi->status_pengajuan === '1')
		<a href="{{site_url('koreksi/atribut/index/cancel_transaction/'.$koreksi->id)}}" class="btn btn-warning" onclick="return confirm('Anda yakin?')"><i class="fa fa-check mr-2"></i>Batalkan Pengajuan</a>
		@endif
	</div>
</div>
@endif
<div class="card">
	<div class="card-header">Detail Koreksi</div>
	<div class="card-body">
		<form action="{{site_url('koreksi/atribut/index/update')}}" method="POST">
			<input type="hidden" name="id" value="{{$koreksi->id}}">
			<div class="row">
				<div class="form-group col">
					<label for="">No. Jurnal</label>
					<input type="text" class="form-control" value="{{zerofy($koreksi->id, 4)}}" disabled="">
				</div>
				<div class="form-group col">
					<label for="">Tanggal Jurnal</label>
					<input type="date" class="form-control" name="tgl_jurnal" value="{{datify($koreksi->tgl_jurnal, 'Y-m-d')}}" placeholder="Tanggal Jurnal">
				</div>
			</div>
			<div class="row">
				<div class="form-group col">
					<label for="">Keterangan</label>
					<textarea name="keterangan" class="form-control" placeholder="Keterangan">{{$koreksi->keterangan}}</textarea>
				</div>
			</div>
			@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
			<div class="row">
				<div class="btn-group col">
					<button type="submit" class="btn btn-success"><i class="fa fa-save mr-2"></i>Simpan</button>
					<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Batal</button>
				</div>
			</div>
			@endif
		</form>
	</div>
</div>

<div class="card mt-4">
	<div class="card-header">
		<ul class="nav nav-tabs card-header-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#kiba" role="tab">
					KIB-A {{!empty($kiba['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#kibb" role="tab">
					KIB-B {{!empty($kibb['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#kibc" role="tab">
					KIB-C {{!empty($kibc['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#kibd" role="tab">
					KIB-D {{!empty($kibd['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#kibe" role="tab">
					KIB-E {{!empty($kibe['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#kibg" role="tab">
					KIB-G {{!empty($kibg['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
				</a>
			</li>
		</ul>
	</div>
	<div class="card-body tab-content tab-scroll">
		<!-- KIB-A -->
		<div class="tab-pane active" id="kiba" role="tabpanel">
			<div id="toolbar-a">
				<div class="input-group">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" value="{{!empty($kiba['count'])?$kiba['count']:'kosong'}}" readonly="">
					<span class="input-group-addon">Rp</span>
					<input type="text" class="form-control" value="{{!empty($kiba['count'])?monefy($kiba['sum']):'kosong'}}" readonly="">
				</div>
			</div>
			<table class="jq-table table-striped" id="tb-kiba" data-toggle="#tb-kiba" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-a" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kiba/get_rincian/'.$koreksi->id)}}">
				<thead>
					<tr>
						@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
						<th data-field="aksi" data-switchable="false">Aksi</th>
						@endif
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false">Nilai</th>
						<th data-class='text-nowrap' data-field="luas">Luas (m2)</th>
						<th data-class='text-nowrap' data-field="alamat">Alamat</th>
						<th data-class='text-nowrap' data-field="sertifikat_tgl">Tgl. Sertifikat</th>
						<th data-class='text-nowrap' data-field="sertifikat_no">No. Sertifikat</th>
						<th data-class='text-nowrap' data-field="hak">Hak Pakai</th>
						<th data-class='text-nowrap' data-field="pengguna">Pengguna</th>
						<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
						<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
						<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
						<th data-class='text-nowrap' data-field="kondisi"'>Kondisi</th>
						<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

		<!-- KIB-B -->
		<div class="tab-pane" id="kibb" role="tabpanel">
			<div id="toolbar-b">
				<div class="input-group">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" value="{{!empty($kibb['count'])?$kibb['count']:'kosong'}}" readonly="">
					<span class="input-group-addon">Rp</span>
					<input type="text" class="form-control" value="{{!empty($kibb['count'])?monefy($kibb['sum']):'kosong'}}" readonly="">
				</div>
			</div>
			<table class="jq-table table-striped" id="tb-kibb" data-toggle="#tb-kibb" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-b" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibb/get_rincian/'.$koreksi->id)}}">
				<thead>
					<tr>
						@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
						<th data-class='text-nowrap' data-field="aksi" data-switchable="false">Aksi</th>
						@endif
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false">Nilai</th>
						<th data-class='text-nowrap' data-field="merk">Merk</th>
						<th data-class='text-nowrap' data-field="tipe">Tipe</th>
						<th data-class='text-nowrap' data-field="ukuran">Ukuran/CC</th>
						<th data-class='text-nowrap' data-field="bahan">Bahan</th>
						<th data-class='text-nowrap' data-field="no_pabrik">No.Pabrik</th>
						<th data-class='text-nowrap' data-field="no_rangka">No.Rangka</th>
						<th data-class='text-nowrap' data-field="no_mesin">No.Mesin</th>
						<th data-class='text-nowrap' data-field="no_polisi">No.Polisi</th>
						<th data-class='text-nowrap' data-field="no_bpkb">No.BPKB</th>
						<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
						<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
						<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
						<th data-class='text-nowrap' data-field="kondisi"'>Kondisi</th>
						<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
						<th data-class='text-nowrap' data-field="id_ruangan">Ruang</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

		<!-- KIB-C -->
		<div class="tab-pane" id="kibc" role="tabpanel">
			<div id="toolbar-c">
				<div class="input-group">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" value="{{!empty($kibc['count'])?$kibc['count']:'kosong'}}" readonly="">
					<span class="input-group-addon">Rp</span>
					<input type="text" class="form-control" value="{{!empty($kibc['count'])?monefy($kibc['sum']):'kosong'}}" readonly="">
				</div>
			</div>
			<table class="jq-table table-striped" id="tb-kibc" data-toggle="#tb-kibc" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-c" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibc/get_rincian/'.$koreksi->id)}}">
				<thead>
					<tr>
						@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
						<th data-field="aksi" data-switchable="false">Aksi</th>
						@endif
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false">Nilai</th>
						<th data-class='text-nowrap' data-field="tingkat">Tingkat</th>
						<th data-class='text-nowrap' data-field="beton">Beton</th>
						<th data-class='text-nowrap' data-field="luas_lantai">Luas Lantai</th>
						<th data-class='text-nowrap' data-field="lokasi">Lokasi</th>
						<th data-class='text-nowrap' data-field="dokumen_tgl">Tgl.Dokumen</th>
						<th data-class='text-nowrap' data-field="dokumen_no">No.Dokumen</th>
						<th data-class='text-nowrap' data-field="status_tanah">Status Tanah</th>
						<th data-class='text-nowrap' data-field="kode_tanah">Kode Tanah</th>
						<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
						<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
						<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
						<th data-class='text-nowrap' data-field="kondisi">Kondisi</th>
						<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

		<!-- KIB-D -->
		<div class="tab-pane" id="kibd" role="tabpanel">
			<div id="toolbar-d">
				<div class="input-group">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" value="{{!empty($kibd['count'])?$kibd['count']:'kosong'}}" readonly="">
					<span class="input-group-addon">Rp</span>
					<input type="text" class="form-control" value="{{!empty($kibd['count'])?monefy($kibd['sum']):'kosong'}}" readonly="">
				</div>
			</div>
			<table class="jq-table table-striped" id="tb-kibd" data-toggle="#tb-kibd" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-d" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibd/get_rincian/'.$koreksi->id)}}">
				<thead>
					<tr>
						@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
						<th data-field="aksi" data-switchable="false">Aksi</th>
						@endif
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false">Nilai</th>
						<th data-class='text-nowrap' data-field="kontruksi">Kontruksi</th>
						<th data-class='text-nowrap' data-field="panjang">Panjang</th>
						<th data-class='text-nowrap' data-field="lebar">Lebar</th>
						<th data-class='text-nowrap' data-field="luas">Luas</th>
						<th data-class='text-nowrap' data-field="lokasi">Lokasi</th>
						<th data-class='text-nowrap' data-field="dokumen_tgl">Tgl.Dokumen</th>
						<th data-class='text-nowrap' data-field="dokumen_no">No.Dokumen</th>
						<th data-class='text-nowrap' data-field="status_tanah">Status Tanah</th>
						<th data-class='text-nowrap' data-field="kode_tanah">Kode Tanah</th>
						<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
						<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
						<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
						<th data-class='text-nowrap' data-field="kondisi">Kondisi</th>
						<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

		<!-- KIB-E -->
		<div class="tab-pane" id="kibe" role="tabpanel">
			<div id="toolbar-e">
				<div class="input-group">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" value="{{!empty($kibe['count'])?$kibe['count']:'kosong'}}" readonly="">
					<span class="input-group-addon">Rp</span>
					<input type="text" class="form-control" value="{{!empty($kibe['count'])?monefy($kibe['sum']):'kosong'}}" readonly="">
				</div>
			</div>
			<table class="jq-table table-striped" id="tb-kibe" data-toggle="#tb-kibe" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-e" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibe/get_rincian/'.$koreksi->id)}}">
				<thead>
					<tr>
						@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
						<th data-class='text-nowrap' data-field="aksi" data-switchable="false">Aksi</th>
						@endif
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false" class="text-nowrap text-right">Nilai</th>
						<th data-class='text-nowrap' data-field="judul">Judul</th>
						<th data-class='text-nowrap' data-field="pencipta">Pecipta</th>
						<th data-class='text-nowrap' data-field="bahan">Bahan</th>
						<th data-class='text-nowrap' data-field="ukuran">Ukuran</th>
						<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
						<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
						<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
						<th data-class='text-nowrap' data-field="kondisi">Kondisi</th>
						<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
						<th data-class='text-nowrap' data-field="id_ruangan">Ruang</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

		<!-- KIB-G -->
		<div class="tab-pane" id="kibg" role="tabpanel">
			<div id="toolbar-g">
				<div class="input-group">
					<span class="input-group-addon">Total</span>
					<input type="text" class="form-control" value="{{!empty($kibg['count'])?$kibg['count']:'kosong'}}" readonly="">
					<span class="input-group-addon">Rp</span>
					<input type="text" class="form-control" value="{{!empty($kibg['count'])?monefy($kibg['sum']):'kosong'}}" readonly="">
				</div>
			</div>
			<table class="jq-table table-striped" id="tb-kibg" data-toggle="#tb-kibg" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-g" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibg/get_rincian/'.$koreksi->id)}}">
				<thead>
					<tr>
						@if(!$ref && ($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3'))
						<th data-field="aksi" data-switchable="false">Aksi</th>
						@endif
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false">Nilai</th>
						<th data-class='text-nowrap' data-field="merk">Merk</th>
						<th data-class='text-nowrap' data-field="tipe">Tipe</th>
						<th data-class='text-nowrap' data-field="ukuran">Ukuran</th>
						<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
						<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
						<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
						<th data-class='text-nowrap' data-field="kondisi">Kondisi</th>
						<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
						<th data-class='text-nowrap' data-field="id_ruangan">Ruang</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	<div class="card-footer">
		<span class="badge badge-danger">-</span> dihapus
		<span class="badge badge-success ml-2">+</span> ditambah
		<span class="badge badge-danger ml-2">-</span><span class="badge badge-success">+</span> diganti
	</div>
</div>
@end

@section('modal')
@if(!$ref)
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Aset</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('koreksi/atribut/index/rincian_redirect/'.$koreksi->id)}}" method="POST">
					<input type="hidden" name="id" value="{{$koreksi->id}}">
					<div class="modal-title"><b>Aset Tetap</b></div>
					<ul style="list-style: none;">
						<li><input type="radio" name="jenis" value="a"> A - Tanah</li>
						<li><input type="radio" name="jenis" value="b"> B - Peralatan Dan Mesin</li>
						<li><input type="radio" name="jenis" value="c"> C - Gedung Dan Bangunan</li>
						<li><input type="radio" name="jenis" value="d"> D - Jalan, Irigasi &amp Jaringan</li>
						<li><input type="radio" name="jenis" value="e"> E - Buku, Barang &amp Kebudayaan</li>
						<li><input type="radio" name="jenis" value="g"> G - Aset Lainnya</li>
					</ul>
					<hr>
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Pilih</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endif
@end

@section('style')
<style>
th, td {
	font-size: smaller !important;
}
</style>
<link rel="stylesheet" href="{{base_url('res/plugins/bttable/bttable.css')}}">
@end

@section('script')
<script src="{{base_url('res/plugins/bttable/bttable.js')}}"></script>
<script>
	theme.activeMenu('.nav-koreksi-atribut');
	@if($koreksi->status_pengajuan === '1' OR $koreksi->status_pengajuan === '2' OR $ref)
	$('form :input').prop('disabled', true);
	@endif
	// FIX TAB ERROR
	$(".nav-link").on('click', function(e){
		var dom = $(e.currentTarget).attr('href');
		$(".tab-pane:not("+dom+")").removeClass('active');
	});

	// INIT Datatables
	$(".jq-table").bootstrapTable({
		formatRecordsPerPage: function () {
			return ''
		},
		formatShowingRows: function () {
			return ''
		}
	});

	function indexing(value, row, index)
	{
		return index + 1;
	}
 </script>
 @end