@layout('commons/index')
@section('title')Inventarisasi@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Inventarisasi</li>
@end

@section('content')
<div class="card">
	<div class="card-header">Pengajuan Inventarisasi</div>
	<div class="card-body">
		<table class="jq-table table-striped" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('persetujuan/inventarisasi/get_inventarisasi')}}">
			<thead>
				<tr>
					<th data-field="no" data-switchable="false">No.</th>
					<th data-field="no_jurnal" data-switchable="false">Nomor Jurnal</th>
					<th data-field="tgl_jurnal" data-switchable="false" class="text-nowrap">Tanggal Jurnal</th>
					<th data-field="keterangan" data-switchable="false">Keterangan</th>
					<th data-field="aksi" data-switchable="false">Aksi</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-setuju">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="background-color: #28a745; color: #FFF">
			<div class="modal-header">
				<h4 class="modal-title">Setujui Pengajuan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('persetujuan/inventarisasi/verifikasi')}}" method="POST">
					<input type="hidden" name="status" value="2">
					<input type="hidden" name="id_inventarisasi">
					<div class="form-group">
						<label>Pesan/Alasan</label>
						<textarea type="text" name="pesan" class="form-control" placeholder="Pesan verifikasi"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-secondary">Setujui</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tolak">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="background-color: #dc3545; color: #FFF">
			<div class="modal-header">
				<h4 class="modal-title">Tolak Pengajuan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('persetujuan/inventarisasi/verifikasi')}}" method="POST">
					<input type="hidden" name="status" value="3">
					<input type="hidden" name="id_inventarisasi">
					<div class="form-group">
						<label>Pesan/Alasan</label>
						<textarea type="text" name="pesan" class="form-control" placeholder="Pesan verifikasi"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-secondary">Tolak</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
	theme.activeMenu('.nav-persetujuan-inventarisasi');
	
	$("table > tbody").delegate('.btn-setuju', 'click', setuju);
	$("table > tbody").delegate('.btn-tolak', 'click', tolak);

	function setuju(e) {
		var id = $(e.currentTarget).data('id');
		$("#modal-setuju [name='id_inventarisasi']").val(id);
		$("#modal-setuju").modal('show');
	}

	function tolak(e) {
		var id = $(e.currentTarget).data('id');
		$("#modal-tolak [name='id_inventarisasi']").val(id);
		$("#modal-tolak").modal('show');
	}

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