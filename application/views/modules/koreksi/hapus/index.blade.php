@layout('commons/index')
@section('title')Koreksi Hapus@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/hapus?id_organisasi='.$filter['id_organisasi'])}}">Koreksi</a></li>
<li class="breadcrumb-item active">Koreksi Hapus</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="" method="GET" class="mr-auto">
			<div class="input-group">
				<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $item)
						<option value="{{$item->id}}" {{isset($filter['id_organisasi']) && $item->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$item->nama}}</option>
					@endforeach
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary">Pilih</button>
				</span>
			</div>
		</form>
		<div class="btn-group">
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus mr-2"></i>Tambah</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th class="text-center">No. Jurnal</th>
						<th class="text-center">Tanggal Jurnal</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal Verifikasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
				</thead>
				<tbody>
					@if(empty($koreksi))
					<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
					@endif
					
					@foreach($koreksi AS $item)
					<tr class="small">
						<td class="text-center">{{zerofy($item->id, 4)}}</td>
						<td class="text-center">{{datify($item->tgl_jurnal, 'd/m/Y')}}</td>
						<td>{{$item->keterangan}}</td>
						<td class="text-center">
							@if($item->status_pengajuan === '0')
							<button class="btn btn-secondary btn-sm btn-block" id="btn-pesan">draf</button>
							@elseif($item->status_pengajuan === '1')
							<button class="btn btn-warning btn-sm btn-block" id="btn-pesan">menunggu</button>
							@elseif($item->status_pengajuan === '2')
							<div class="btn-group">
								<button class="btn btn-sm btn-success btn-sm" data-id-koreksi="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>disetujui</button>
								@if($this->session->auth['is_superadmin'] == 1)
								<button class="btn btn-sm btn-warning" data-id-batal="{{$item->id}}"><i class="fa fa-times"></i></button>
								@endif
							</div>
							@elseif($item->status_pengajuan === '3')
							<button class="btn btn-danger btn-sm btn-block" data-id-koreksi="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>ditolak</button>
							@else
							ERROR
							@endif
						</td>
						<td class="text-center">{{datify($item->tanggal_verifikasi, 'd/m/Y h:i')}}</td>
						<td class="text-center">
							<div class="btn-group">
								<div class="btn-group">
								<a href="{{ site_url('koreksi/hapus/rincian/'.$item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Rincian</a>
								@if($item->status_pengajuan === '0' OR $item->status_pengajuan === '3')
								<button class="btn btn-danger" data-id="{{$item->id}}"><i class="fa fa-trash"></i></button>
								@endif
							</div>
							</div>
						</td>
					</tr>
					@endforeach
                </tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer"></div>
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
				<form action="{{site_url('koreksi/hapus/insert')}}" class="form-row" method="POST">
					<input type="hidden" name="id_organisasi" value="{{$filter['id_organisasi']}}">
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
.text-sm {font-size: smaller;}
</style>
@end

@section('script')
<script>
	theme.activeMenu('.nav-koreksi-tambah');
	$("[data-id]").on('click', function(){
		var id = $(this).data('id');
		$("#btn-hapus-confirm").attr("href", "{{site_url('koreksi/hapus/delete/')}}"+id);
		$("#modal-hapus").modal('show');
	});

	$("[data-id-koreksi]").on('click', function(e){
		var id = $(e.currentTarget).data('id-koreksi');

		$.getJSON("{{site_url('persetujuan/api/get_persetujuan_koreksi_hapus/')}}"+id, function(result){
			$("#span-tanggal").html(result.log_time);
			$("#span-status").html(result.status);
			$("#span-pesan").html(result.pesan);
		});

		$("#modal-pesan").modal('show');
	});

	$("[data-id-batal]").on('click', function(e){
		$("#modal-batal .card-body").empty().html("<h4 class='mb-3'>Memeriksa ketersediaan pembatalan<br>Mohon menunggu</h4><h1 class='mb-4'><i class='fa fa-refresh fa-spin fa-2x'></i></h1>");
		$("#modal-batal .card-footer").empty();
		$("#modal-batal").modal('show');
		
		var id = $(this).data('id-batal');
		$.getJSON("{{site_url('koreksi/hapus/get_abort_status/')}}"+id, function(result){
			if (result.status === true) {
				html = "<div class='btn-group'>"
				html += "<a href='{{site_url()}}koreksi/hapus/abort_transaction/"+id+"' class='btn btn-warning'>Batalkan Persetujuan</a>";
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