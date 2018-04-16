@layout('commons/index')
@section('title')Pengadaan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pengadaan</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered small">
			<thead>
				<thead>
					<tr>
						<th class="text-center">UPB</th>
						<th class="text-center">No. SPK/Perjanian/Kontrak</th>
						<th>Tanggal</th>
						<th class="text-right">Nilai</th>
						<th class="text-nowrap">Jangka Waktu</th>
						<th>Keterangan</th>
						<th class="text-center">Status Pengajuan</th>
						<th class="text-center">Tanggal Pengajuan</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@foreach($spks AS $item)
					<tr>
						<td class="text-center">{{$item->id_organisasi->nama}}</td>
						<td class="text-center">{{$item->nomor}}</td>
						<td>{{datify($item->tanggal, 'd/m/Y')}}</td>
						<td class="text-right">{{(!empty($item->nilai)) ? monefy($item->nilai) : 00,00}}</td>
						<td class="text-nowrap">{{$item->jangka_waktu}}</td>
						<td class="text-sm">{{$item->keterangan}}</td>
						<td class="text-center">
							@if($item->status_pengajuan === '0')
							<button class="btn btn-secondary btn-sm btn-block" id="btn-pesan">draf</button>
							@elseif($item->status_pengajuan === '1')
							<button class="btn btn-warning btn-sm btn-block" id="btn-pesan">menunggu</button>
							@elseif($item->status_pengajuan === '2')
							<button class="btn btn-success btn-sm btn-block" data-id-spk="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>disetujui</button>
							@elseif($item->status_pengajuan === '3')
							<button class="btn btn-danger btn-sm btn-block" data-id-spk="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>ditolak</button>
							@else
							ERROR
							@endif
						</td>
						<td class="text-center">{{datify($item->log_time, 'd-m-Y h:i')}}</td>
						<td class="text-center">
							<div class="btn-group">
								<a href="{{ site_url('persetujuan/Pengadaan/detail/'.$item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
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
				<form action="{{site_url('persetujuan/Pengadaan/verifikasi')}}" method="POST">
					<input type="hidden" name="status" value="2">
					<input type="hidden" name="id_spk">
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
				<form action="{{site_url('persetujuan/Pengadaan/verifikasi')}}" method="POST">
					<input type="hidden" name="status" value="3">
					<input type="hidden" name="id_spk">
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
@endsection

@section('script')
<script>
	theme.activeMenu('.nav-persetujuan-pengadaan');

	$(".btn-setuju").on('click', setuju);
	$(".btn-tolak").on('click', tolak);

	function setuju(e) {
		var id = $(e.currentTarget).data('id');
		$("#modal-setuju [name='id_spk']").val(id);
		$("#modal-setuju").modal('show');
	}

	function tolak(e) {
		var id = $(e.currentTarget).data('id');
		$("#modal-tolak [name='id_spk']").val(id);
		$("#modal-tolak").modal('show');
	}
</script>
@end