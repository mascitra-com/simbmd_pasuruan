@layout('commons/index')
@section('title')Inventarisasi@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Inventarisasi</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="{{site_url('inventarisasi/index')}}" method="GET" class="mr-auto">
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
		<div class="btn-group">
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus mr-2"></i>Baru</button>
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body">
		<table class="jq-table table-striped" data-toggle="#tb-kiba" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('inventarisasi/index/get_inventarisasi/'.$id_organisasi)}}">
			<thead>
				<tr>
					<th data-field="no" data-switchable="false">No.</th>
					<th data-field="no_ba" data-switchable="false">Nomor Berita Acara</th>
					<th data-field="tgl_ba" data-switchable="false" data-class="text-nowrap">Tanggal Berita Acara</th>
					<th data-field="keterangan" data-switchable="false">Keterangan</th>
					<th data-field="status_pengajuan" data-switchable="false" data-class="text-center">Status</th>
					<th data-field="aksi" data-switchable="false" data-class='text-center'>Aksi</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Inventarisasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('inventarisasi/index/insert')}}" method="POST">
					<input type="hidden" name="id_organisasi" value="{{$id_organisasi}}">
					<div class="row">
						<div class="form-group col">
							<label>No. Berita Acara</label>
							<input type="text" name="no_ba" class="form-control" placeholder="No Berita Acara">
						</div>
						<div class="form-group col">
							<label for="">Tanggal Berita Acara</label>
							<input type="date" name="tgl_ba" class="form-control" placeholder="Tanggal Berita Acara" value="{{date('Y-m-d')}}">
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label for="">Keterangan</label>
							<textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
							<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Bersihkan</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-pesan">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">Detail Persetujuan</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="bold">Tanggal Verifikasi:</label>
					<div id="span-tanggal"></div>
				</div>
				<div class="form-group">
					<label class="bold">Status Verifikasi:</label>
					<div id="span-status">Disetujui</div>
				</div>
				<div class="form-group">
					<label class="bold">Pesan:</label>
					<div id="span-pesan"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal">Batal</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Apakah anda yakin?</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h3>Menghapus pengajuan Inventarisasi juga akan menghapus semua rincian inventarisasi.</h3>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-warning" id="btn-hapus-confirm">Tetap hapus</a>
				<button class="btn btn-primary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-batal">
	<div class="modal-dialog" role="document">
		<div class="modal-content card text-center">
			<div class="card-header">
				<b class="card-title">Pembatalan Persetujuan</b>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="card-body"></div>
			<div class="card-footer"></div>
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

	$("table > tbody").delegate('[data-id]', 'click', function(){
		var id = $(this).data('id');
		$("#btn-hapus-confirm").attr("href", "{{site_url('inventarisasi/index/delete/')}}"+id);
		$("#modal-hapus").modal('show');
	});

	$("table > tbody").delegate('[data-id-inventarisasi]', 'click', function(e){
		var id = $(e.currentTarget).data('id-inventarisasi');

		$.getJSON("{{site_url('persetujuan/api/get_persetujuan_inventarisasi/')}}"+id, function(result){
			$("#span-tanggal").html(result.log_time);
			$("#span-status").html(result.status);
			$("#span-pesan").html(result.pesan);
		});

		$("#modal-pesan").modal('show');
	});

	$("table > tbody").delegate('[data-id-batal]', 'click', function(e){
		$("#modal-batal .card-body").empty().html("<h4 class='mb-3'>Memeriksa ketersediaan pembatalan<br>Mohon menunggu</h4><h1 class='mb-4'><i class='fa fa-refresh fa-spin fa-2x'></i></h1>");
		$("#modal-batal .card-footer").empty();
		$("#modal-batal").modal('show');

		var id = $(this).data('id-batal');
		$.getJSON("{{site_url('inventarisasi/index/get_abort_status/')}}"+id, function(result){
			if (result.status === true) {
				html = "<div class='btn-group'>"
				html += "<a href='{{site_url()}}inventarisasi/index/abort_transaction/"+id+"' class='btn btn-warning'>Batalkan Persetujuan</a>";
				html += "<button class='btn btn-secondary' data-dismiss='modal'>Urungkan</button>";
				html += "</div>";
				$("#modal-batal .card-body").empty().html("<h3 class='mb-3'>Pembatalan persetujuan dapat dilakukan.</h3>");
				$("#modal-batal .card-footer").empty().html(html);
			}else{
				$("#modal-batal .card-body").empty().html("<p>Pembatalan persetujuan <b>tidak dapat dilakukan</b>.<br>"+result.reason+"</p>");
				$("#modal-batal .card-footer").html("<button class='btn btn-secondary' data-dismiss='modal'>Urungkan</button>");
			}
		});
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