@layout('commons/index')
@section('title')Koreksi Atribut@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Atribut</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index/rincian/'.$koreksi->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Kibc</li>
@end

@section('content')
<div class="card">
	<div class="card-header">KIB-C (Gedung &amp Bangunan)</div>
	<div class="card-body">
		<table class="jq-table table-striped" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/kibc/get/'.$koreksi->id)}}">
				<thead>
					<tr>
						<th data-class='text-nowrap' data-field="aksi" data-switchable="false">Aksi</th>
						<th data-class='text-nowrap' data-field="kode_barang" data-switchable="false">Kode Barang</th>
						<th data-class='text-nowrap' data-field="id_kategori" data-switchable="false">Kategori</th>
						<th data-class='text-nowrap' data-field="nilai" data-switchable="false">Nilai</th>
						<th data-class='text-nowrap' data-field="nilai_tambah">Nilai Tambah</th>
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
				<form action="{{site_url('koreksi/atribut/kibc/insert')}}" method="POST">
					<input type="hidden" name="id_koreksi" value="{{$koreksi->id}}">
					<input type="hidden" name="id">
					<div class="row">
						<div class="form-group col">
							<label for="">Luas Lantai</label>
							<input type="number" class="form-control" name="luas_lantai" placeholder="Luas Lantai">
						</div>
						<div class="form-group col">
							<label for="">Tingkat</label>
							<select class="form-control" name="tingkat">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>
							</select>
						</div>
						<div class="form-group col">
							<label for="">Beton</label>
							<select class="form-control" name="beton">
								<option value="1">Ya</option>
								<option value="0">Tidak</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">Lokasi</label>
							<input type="text" class="form-control" name="lokasi" placeholder="Lokasi">
						</div>
						<div class="form-group col">
							<label for="">No. Dokumen</label>
							<input type="text" class="form-control" name="dokumen_no" placeholder="No. Dokumen">
						</div>
						<div class="form-group col">
							<label for="">Tanggal Dokumen</label>
							<input type="date" class="form-control" name="dokumen_tgl" placeholder="Tanggal Dokumen">
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">Status Tanah</label>
							<input type="text" class="form-control" name="status_tanah" placeholder="Status Tanah">
						</div>
						<div class="form-group col">
							<label for="">Kode Tanah</label>
							<input type="text" class="form-control" name="kode_tanah" placeholder="Kode Tanah">
						</div>
						<div class="form-group col">
							<label for="">Tanggal Perolehan</label>
							<input type="date" class="form-control" name="tgl_perolehan" placeholder="Tgl. Perolehan" disabled="">
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">Tanggal Pembukuan</label>
							<input type="date" class="form-control" name="tgl_pembukuan" placeholder="Tgl. Pembukuan" disabled="">
						</div>
						<div class="form-group col">
							<label for="">Asal Usul</label>
							<input type="text" class="form-control" name="asal_usul" placeholder="Asal Usul">
						</div>
						<div class="form-group col">
							<label for="">Nilai</label>
							<input type="number" class="form-control" name="nilai" placeholder="Nilai">
						</div>
					</div>
					<div class="row">
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
		$.getJSON("{{site_url('koreksi/atribut/kibc/get/'.$koreksi->id.'?id=')}}"+id, function(result){
			$("[name=id]").val(result.rows[0].id);
			$("[name=luas_lantai]").val(result.rows[0].luas_lantai);
			$("[name=tingkat]").val(result.rows[0].tingkat=='iya'?1:0);
			$("[name=beton]").val(result.rows[0].beton=='iya'?1:0);
			$("[name=lokasi]").val(result.rows[0].lokasi);
			$("[name=dokumen_no]").val(result.rows[0].dokumen_no);
			$("[name=dokumen_tgl]").val(convertDate(result.rows[0].dokumen_tgl));
			$("[name=status_tanah]").val(result.rows[0].status_tanah);
			$("[name=kode_tanah]").val(result.rows[0].kode_tanah);
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