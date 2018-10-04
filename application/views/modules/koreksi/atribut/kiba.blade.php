@layout('commons/index')
@section('title')Koreksi Atribut@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Atribut</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index/rincian/'.$koreksi->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Kiba</li>
@end

@section('content')
<div class="card">
	<div class="card-header">KIB-A (Tanah)</div>
	<div class="card-body">
		<table class="jq-table table-striped" id="tb-kiba" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kiba/get/'.$koreksi->id)}}">
			<thead>
				<tr>
					<th data-field="aksi" data-switchable="false">Aksi</th>
					<th data-field="kode_barang" data-switchable="false">Kode Barang</th>
					<th data-field="id_kategori" data-switchable="false">Kategori</th>
					<th data-field="nilai" data-switchable="false">Nilai</th>
					<th data-field="luas">Luas (m2)</th>
					<th data-field="alamat">Alamat</th>
					<th data-field="sertifikat_tgl">Tgl. Sertifikat</th>
					<th data-field="sertifikat_no">No. Sertifikat</th>
					<th data-field="hak">Hak Pakai</th>
					<th data-field="pengguna">Pengguna</th>
					<th data-field="tgl_perolehan">Tgl. Perolehan</th>
					<th data-field="tgl_pembukuan">Tgl. Pembukuan</th>
					<th data-field="asal_usul">Asal Usul</th>
					<th data-field="kondisi">Kondisi</th>
					<th data-field="keterangan">Keterangan</th>
				</tr>
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
				<form action="{{site_url('koreksi/atribut/kiba/insert')}}" method="POST">
					<input type="hidden" name="id_koreksi" value="{{$koreksi->id}}">
					<input type="hidden" name="id">
					<div class="row">
						<div class="form-group col">
							<label for="">Luas</label>
							<input type="number" class="form-control" name="luas" placeholder="Luas">
						</div>
						<div class="form-group col">
							<label for="">Alamat</label>
							<input type="text" class="form-control" name="alamat" placeholder="Alamat">
						</div>
						<div class="form-group col">
							<label for="">Tgl Sertifikat</label>
							<input type="date" class="form-control" name="sertifikat_tgl" placeholder="Tanggal Sertifikat">
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">No. Sertifikat</label>
							<input type="text" class="form-control" name="sertifikat_no" placeholder="No. Sertifikat">
						</div>
						<div class="form-group col">
							<label for="">Hak Pakai</label>
							<input type="text" class="form-control" name="hak" placeholder="Hak Pakai">
						</div>
						<div class="form-group col">
							<label for="">Pengguna</label>
							<input type="text" class="form-control" name="pengguna" placeholder="Pengguna">
						</div>
					</div>
					<div class="row">
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
							<select class="form-control" name="kondisi" disabled="">
								<option value="1">Baik</option>
								<option value="2">Kurang Baik</option>
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
		$.getJSON("{{site_url('koreksi/atribut/kiba/get/'.$koreksi->id.'?id=')}}"+id, function(result){
			$("[name=id]").val(result.rows[0].id);
			$("[name=luas]").val(result.rows[0].luas);
			$("[name=alamat]").val(result.rows[0].alamat);
			$("[name=sertifikat_tgl]").val(convertDate(result.rows[0].sertifikat_tgl));
			$("[name=sertifikat_no]").val(result.rows[0].sertifikat_no);
			$("[name=hak]").val(result.rows[0].hak);
			$("[name=pengguna]").val(result.rows[0].pengguna);
			$("[name=tgl_perolehan]").val(convertDate(result.rows[0].tgl_perolehan));
			$("[name=tgl_pembukuan]").val(convertDate(result.rows[0].tgl_pembukuan));
			$("[name=asal_usul]").val(result.rows[0].asal_usul);
			$("[name=nilai]").val(result.rows[0].nilai);
			$("[name=kondisi]").val(result.rows[0].kondisi==='Baik'?1:result.rows[0].kondisi==='Baik'?2:3);
			$("[name=keterangan]").val(result.rows[0].keterangan);
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