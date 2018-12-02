@layout('commons/index')
@section('title')KIB-E@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item">Aset Saldo {{$source==='saldo'?'Awal':$source}}</li>
<li class="breadcrumb-item active">KIB-E</li>
@end

@section('widget')
@if(!empty($id_organisasi))
<div class="row mb-4">
	<div class="col">
		<div class="card text-white bg-info" id="wg-nilai">
			<div class="card-body">
				<div class="card-title mb-0">NILAI ASET KESELURUHAN</div>
				<div class="card-text font-weight-bold" style="font-size: 1.5em"><div class="fa fa-spinner fa-spin"></div> Mengambil nilai...</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card text-white bg-dark" id="wg-total">
			<div class="card-body">
				<div class="card-title mb-0">JUMLAH ASET KESELURUHAN</div>
				<div class="card-text font-weight-bold" style="font-size: 1.5em"><div class="fa fa-spinner fa-spin"></div> Mengambil nilai...</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card bg-warning" id="wg-nilai-rusak">
			<div class="card-body">
				<div class="card-title mb-0">TOTAL NILAI ASET RUSAK</div>
				<div class="card-text font-weight-bold" style="font-size: 1.5em"><div class="fa fa-spinner fa-spin"></div> Mengambil nilai...</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card text-white bg-danger" id="wg-total-rusak">
			<div class="card-body">
				<div class="card-title mb-0">JUMLAH ASET RUSAK</div>
				<div class="card-text font-weight-bold" style="font-size: 1.5em"><div class="fa fa-spinner fa-spin"></div> Mengambil nilai...</div>
			</div>
		</div>
	</div>
</div>
@endif
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<span>KIB-E (Buku, Barang &amp Kebudayaan)</span>
		<form action="{{site_url('aset/kibe')}}" method="GET" class="ml-auto">
			<input type="hidden" name="source" value="{{$source}}">
			<div class="input-group">
				<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $org)
					<option value="{{$org->id}}" {{$org->id === $id_organisasi ? 'selected' : ''}}>{{$org->nama}}</option>
					@endforeach
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary">Pilih</button>
				</span>
			</div>
		</form>
	</div>
	<div class="card-body">
		<table class="jq-table table-striped" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('aset/kibe/get/'.$id_organisasi.'/'.$source)}}">
			<thead>
				<tr>
					@if($source === 'berjalan')
					<th data-field="aksi" data-switchable="false">Aksi</th>
					@endif
					<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
					<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
					<th data-class='text-nowrap' data-field="nilai" data-switchable="false" class="text-nowrap text-right" data-sortable="true">Nilai</th>
					<th data-class='text-nowrap' data-field="judul">Judul</th>
					<th data-class='text-nowrap' data-field="pencipta">Pecipta</th>
					<th data-class='text-nowrap' data-field="bahan">Bahan</th>
					<th data-class='text-nowrap' data-field="ukuran">Ukuran</th>
					<th data-class='text-nowrap' data-field="tgl_perolehan" data-sortable="true">Tgl. Perolehan</th>
					<th data-class='text-nowrap' data-field="tgl_pembukuan" data-sortable="true">Tgl. Pembukuan</th>
					<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
					<th data-class='text-nowrap' data-field="Kondisi" data-sortable="true">Kondisi</th>
					<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
					<th data-class='text-nowrap' data-field="id_ruangan">Ruang</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
@end

@section('modal')
@if($source === 'berjalan')
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sunting Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('aset/kibe/update')}}" method="POST">
					<input type="hidden" name="id">
					<div class="form-group">
						<label for="">Pilih Ruangan</label>
						<select name="id_ruangan" class="form-control">
							<option>Pilih Ruangan Baru</option>
							@foreach($ruangan AS $data)
							<option value="{{$data->id}}">{{$data->nama}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
<script type="text/javascript">
	var kib = (function(){
		theme.activeMenu('.nav-saldo-{{$source==='saldo'?'awal':strtolower($source)}}');

		// GET RINCIAN
		$.getJSON("{{site_url('aset/kibe/get_rincian_widget/'.$id_organisasi.'/'.$source)}}", function(result){
			$("#wg-total .card-text").empty().html(result.total);
			$("#wg-nilai .card-text").empty().html("Rp "+result.nilai);
			$("#wg-total-rusak .card-text").empty().html(result.total_rusak);
			$("#wg-nilai-rusak .card-text").empty().html("Rp "+result.nilai_rusak);
		});

		// SUNTING
		$("table > tbody").delegate('[data-id]', 'click', function(e){
			var id = $(e.currentTarget).data('id');
			$("[name=id]").val(id);
			$("#modal-edit").modal('show');
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
	})();
</script>
@end