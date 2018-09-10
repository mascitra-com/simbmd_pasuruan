@layout('commons/index')
@section('title')Koreksi Atribut@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/atribut/index?id_organisasi='.$id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item active">Koreksi Atribut</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="{{site_url('koreksi/atribut/index')}}" method="GET" class="mr-auto">
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
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah" {{$id_organisasi?:'disabled'}}><i class="fa fa-plus mr-2"></i>Baru</button>
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body">
		<table class="jq-table table-striped" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('koreksi/atribut/index/get/'.$id_organisasi)}}">
			<thead>
				<tr>
					<th data-field="id" data-switchable="false">No. Jurnal</th>
					<th data-field="tgl_jurnal" data-switchable="false" data-class="text-nowrap">Tanggal Berita Acara</th>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Tambah Koreksi Hapus</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('koreksi/atribut/index/insert')}}" class="form-row" method="POST">
					<input type="hidden" name="id_organisasi" value="{{$id_organisasi}}">
					<div class="form-group col-6">
						<label>No. Jurnal</label>
						<input type="text" class="form-control" placeholder="####" readonly/>
					</div>
					<div class="form-group col-6">
						<label>Tanggal Jurnal</label>
						<input type="date" name="tgl_jurnal" class="form-control" value="{{date('Y-m-d')}}" placeholder="tanggal jurnal" />
					</div>
					<div class="form-group col-12">
						<label>Keterangan</label>
						<textarea class="form-control" name="keterangan" placeholder="keterangan"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="button" class="btn btn-waring" data-dismiss="modal">Batal</button>
					</div>
				</form>
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
				<h3>Menghapus data pengajuan juga akan menghapus semua rincian yang diajukan.</h3>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-warning" id="btn-hapus-confirm">Tetap hapus</a>
				<button class="btn btn-primary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-pesan">
	<div class="modal-dialog modal-sm" role="document">
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
	theme.activeMenu('.nav-koreksi-atribut');

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

	$("table > tbody").delegate('[data-id]', 'click', function(){
		var id = $(this).data('id');
		$("#btn-hapus-confirm").attr("href", "{{site_url('koreksi/atribut/index/delete/')}}"+id);
		$("#modal-hapus").modal('show');
	});

	$("table > tbody").delegate('[data-id-koreksi]', 'click', function(e){
		var id = $(e.currentTarget).data('id-koreksi');

		$.getJSON("{{site_url('persetujuan/api/get_persetujuan_koreksi_hapus/')}}"+id, function(result){
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
		$.getJSON("{{site_url('koreksi/atribut/index/get_abort_status/')}}"+id, function(result){
			if (result.status === true) {
				html = "<div class='btn-group'>"
				html += "<a href='{{site_url()}}koreksi/atribut/index/abort_transaction/"+id+"' class='btn btn-warning'>Batalkan Persetujuan</a>";
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
</script>
@end