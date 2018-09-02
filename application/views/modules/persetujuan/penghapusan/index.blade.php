@layout('commons/index')
@section('title')Persetujuan Penghapusan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Persetujuan Penghapusan</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<div class="btn-group">
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th class="text-center">No. Transfer</th>
						<th>Asal</th>
						<th class="text-nowrap">No. Jurnal</th>
						<th class="text-center">Tanggal Jurnal</th>
						<th class="text-center">No SK</th>
						<th class="text-center">Tanggal SK</th>
						<th class="text-center">Waktu Pengajuan</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@if(empty($hapus))
					<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
					@endif

					@foreach($hapus AS $item)
					<tr class="small">
						<td class="text-center">{{$item->id}}</td>
						<td>{{$item->id_organisasi->nama}}</td>
						<td class="text-center">{{zerofy($item->id, 5)}}</td>
						<td class="text-center">{{datify($item->tgl_jurnal)}}</td>
						<td class="text-center">{{$item->no_sk}}</td>
						<td class="text-center">{{datify($item->tgl_sk)}}</td>
						<td class="text-center">{{datify($item->log_time, 'd-m-Y h:i')}}</td>
						<td class="text-center">
							<div class="btn-group">
								<a href="{{ site_url('penghapusan/index/detail/'.$item->id.'?ref=true')}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
								<button class="btn btn-sm btn-success btn-setuju" data-id="{{$item->id}}"><i class="fa fa-check mr-2"></i>Setuju</button>
								<button class="btn btn-sm btn-danger btn-tolak" data-id="{{$item->id}}"><i class="fa fa-times mr-2"></i>Tolak</button>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer">{{$pagination}}</div>
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
				<form action="{{site_url('persetujuan/penghapusan/verifikasi')}}" method="POST">
					<input type="hidden" name="status" value="2">
					<input type="hidden" name="id_hapus">
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
				<form action="{{site_url('persetujuan/penghapusan/verifikasi')}}" method="POST">
					<input type="hidden" name="status" value="3">
					<input type="hidden" name="id_hapus">
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
.text-sm {font-size: smaller;}
</style>
@end

@section('script')
<script>
	theme.activeMenu('.nav-persetujuan-transfer');
	
	$(".btn-setuju").on('click', setuju);
	$(".btn-tolak").on('click', tolak);

	function setuju(e) {
		var id = $(e.currentTarget).data('id');
		$("#modal-setuju [name='id_hapus']").val(id);
		$("#modal-setuju").modal('show');
	}

	function tolak(e) {
		var id = $(e.currentTarget).data('id');
		$("#modal-tolak [name='id_hapus']").val(id);
		$("#modal-tolak").modal('show');
	}
</script>
@end