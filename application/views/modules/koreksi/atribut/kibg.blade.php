@layout('commons/index')
@section('title')Koreksi Atribut@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Atribut</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index/rincian/'.$koreksi->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Kibg</li>
@end

@section('content')
<div class="card">
	<div class="card-header">KIB-C (Aset Lainnya)</div>
	<div class="card-body">
		<table class="jq-table table-striped" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibg/get/'.$koreksi->id)}}">
			<thead>
					<tr>
						<th data-class='text-nowrap' data-field="aksi" data-switchable="false">Aksi</th>
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
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Sunting data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('koreksi/atribut/kibg/insert')}}" method="POST">
					<input type="hidden" name="id_koreksi" value="{{$koreksi->id}}">
					<input type="hidden" name="id">
					<div class="row">
						<div class="form-group col">
							<label for="">Merk</label>
							<input type="text" class="form-control" name="merk" placeholder="Merk">
						</div>
						<div class="form-group col">
							<label for="">Tipe</label>
							<input type="text" class="form-control" name="tipe" placeholder="Tipe">
						</div>
						<div class="form-group col">
							<label for="">Ukuran</label>
							<input type="text" class="form-control" name="ukuran" placeholder="Ukuran">
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">Tanggal Perolehan</label>
							<input type="date" class="form-control" name="tgl_perolehan" placeholder="Tgl. Perolehan">
						</div>
						<div class="form-group col">
							<label for="">Tanggal Pembukuan</label>
							<input type="date" class="form-control" name="tgl_pembukuan" placeholder="Tgl. Pembukuan">
						</div>
						<div class="form-group col">
							<label for="">Asal Usul</label>
							<input type="text" class="form-control" name="asal_usul" placeholder="Asal Usul">
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">Nilai</label>
							<input type="number" class="form-control" name="nilai" placeholder="Nilai">
						</div>
						<div class="form-group col">
							<label for="">Kondisi</label>
							<select class="form-control" name="kondisi">
								<option value="1">Sangat Baik</option>
								<option value="2">Baik</option>
								<option value="3">Rusak Berat</option>
							</select>
						</div>
						<div class="form-group col">
							<label for="">Keterangan</label>
							<input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col form-inline">
							<div class="btn-group">
								<button type="submit" class="btn btn-success"><i class="fa fa-save mr-2"></i>Simpan</button>
								<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Bersihkan</button>
							</div>
							<button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
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
	theme.activeMenu('.nav-invent');

	$("table > tbody").delegate('[data-id]', 'click', function(e){
		var id = $(e.currentTarget).data('id');
		$.getJSON("{{site_url('koreksi/atribut/kibg/get/'.$koreksi->id.'?id=')}}"+id, function(result){
			$("[name=id]").val(result.rows[0].id);
			$("[name=merk]").val(result.rows[0].merk);
			$("[name=tipe]").val(result.rows[0].tipe);
			$("[name=ukuran]").val(result.rows[0].ukuran);
			$("[name=tgl_perolehan]").val(convertDate(result.rows[0].tgl_perolehan));
			$("[name=tgl_pembukuan]").val(convertDate(result.rows[0].tgl_pembukuan));
			$("[name=asal_usul]").val(result.rows[0].asal_usul);
			$("[name=nilai]").val(result.rows[0].nilai);
			$("[name=kondisi]").val(result.rows[0].kondisi==='Sangat Baik'?1:result.rows[0].kondisi==='Baik'?2:3);
		});
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

	function convertDate(str)
	{
		str = str.split('-');
		return str[2]+'-'+str[1]+'-'+str[0];
	}
</script>
@end