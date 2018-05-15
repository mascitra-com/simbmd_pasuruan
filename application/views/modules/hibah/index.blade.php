@layout('commons/index')
@section('title')Hibah@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Hibah</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="{{site_url('hibah/index')}}" method="GET" class="mr-auto">
			<div class="input-group">
				<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $org)
					<option value="{{$org->id}}" {{isset($filter['id_organisasi']) && $org->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$org->nama}}</option>
					@endforeach
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary">Pilih</button>
				</span>
			</div>
		</form>
		<div class="btn-group">
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-spk"><i class="fa fa-plus mr-2"></i>Baru</button>
			<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button> -->
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th>No. Jurnal</th>
						<th class="text-nowrap">Tanggal Jurnal</th>
						<th>Asal Penerimaan</th>
						<th class="text-nowrap">No Serah Terima</th>
						<th class="text-nowrap">Tanggal Serah Terima</th>
						<th class="text-center">Status Pengajuan</th>
						<th class="text-center">Tanggal Verifikasi</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody>
					@if($hibah)
					@foreach($hibah as $item)
					<tr>
						<td class="text-center">{{ zerofy($item->id) }}</td>
						<td class="text-nowrap">{{ datify($item->tgl_jurnal, 'd-m-Y') }}</td>
						<td class="text-sm">
							@if($item->asal_penerimaan == 0)
							Pemerintah Pusat
							@elseif($item->asal_penerimaan == 1)
							Pemerintah Provinsi
							@elseif($item->asal_penerimaan == 2)
							Pemerintah Daerah
							@elseif($item->asal_penerimaan == 3)
							Pemerintah Daerah Lainnya
							@elseif($item->asal_penerimaan == 4)
							Penerimaan Lainnya
							@else
							-
							@endif
						</td>
						<td class="text-nowrap">{{ $item->no_serah_terima }}</td>
						<td class="text-nowrap">{{ datify($item->tgl_serah_terima, 'd-m-Y') }}</td>
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
						<td class="text-center">{{($item->status_pengajuan !== '0') ? datify($item->tanggal_verifikasi) : '-'}}</td>
						<td class="text-center">
							<div class="btn-group btn-group-sm">
								<a href="{{site_url('hibah/index/detail/'.$item->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i> rincian</a>
								@if($item->status_pengajuan === '0' OR $item->status_pengajuan === '3')
								<button class="btn btn-danger" data-id="{{$item->id}}"><i class="fa fa-trash"></i></button>
								@endif
							</div>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td class="text-center" colspan="9">Tidak Ditemukan Data</td>
					</tr>
					@endif
				</tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer"></div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-spk">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hibah</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{ site_url('hibah/index/insert') }}" method="POST">
					<input type="hidden" type="id_organisasi" value="{{$filter['id_organisasi']}}">
					<div class="row">
						<div class="col">
							<input type="hidden" class="form-control form-control-sm" name="id_organisasi" required value="{{ $filter['id_organisasi'] }}"/>
							<div class="form-row">
								<div class="form-group col">
									<label>No. Jurnal</label>
									<input type="number" class="form-control form-control-sm" placeholder="(Otomatis)" required disabled/>
								</div>
								<div class="form-group col">
									<label>Tgl. Jurnal</label>
									<input type="date" class="form-control form-control-sm" name="tgl_jurnal" value="{{date('Y-m-d')}}" placeholder="Tanggal Jurnal" required />
								</div>
							</div>
							<div class="form-group">
								<label>Asal Penerimaan</label>
								<select name="asal_penerimaan" id="asal_penerimaan" class="form-control" required >
									<option value="">Pilih Salah Satu</option>
									<option value="0">Pemerintah Pusat</option>
									<option value="1">Pemerintah Provinsi</option>
									<option value="2">Pemerintah Daerah</option>
									<option value="3">Pemerintah Daerah Lainnya</option>
									<option value="4">Penerimaan Lainnya</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>No. Serah Terima</label>
							<input type="text" class="form-control form-control-sm" name="no_serah_terima" placeholder="No. Serah Terima" required />
						</div>
						<div class="form-group col">
							<label>Tanggal Serah Terima</label>
							<input type="date" class="form-control form-control-sm" name="tgl_serah_terima" placeholder="Tanggal Serah Terima" required />
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>Keterangan</label>
							<input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Keterangan" required/>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="col text-right">
							<button type="submit" class="btn btn-primary" {{empty($filter['id_organisasi'])?'disabled':''}}><i class="fa fa-save"></i> {{empty($filter['id_organisasi'])?'Pilih organisasi terlebih dahulu':'Simpan'}}</button>
							<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
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
				<h3>Menghapus data Hibah juga akan menghapus semua rincian hibah.</h3>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-warning" id="btn-hapus-confirm">Tetap hapus</a>
				<button class="btn btn-primary" data-dismiss="modal">Batal</button>
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
	theme.activeMenu('.nav-hibah');
	$("[data-id]").on('click', function(){
		var id = $(this).data('id');
		$("#btn-hapus-confirm").attr("href", "{{site_url('hibah/index/delete/')}}"+id);
		$("#modal-hapus").modal('show');
	});

	$("[data-id-spk]").on('click', function(e){
		var id = $(e.currentTarget).data('id-spk');

		$.getJSON("{{site_url('persetujuan/api/get_persetujuan_hibah/')}}"+id, function(result){
			$("#span-tanggal").html(result.log_time);
			$("#span-status").html(result.status);
			$("#span-pesan").html(result.pesan);
		});

		$("#modal-pesan").modal('show');
	});
</script>
@end