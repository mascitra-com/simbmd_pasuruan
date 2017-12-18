@layout('commons/index')
@section('title')Transfer Keluar@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Transfer Keluar</li>
@endsection

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="" method="GET" class="mr-auto">
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
            <a href="{{ site_url('transfer/add/'.$filter['id_organisasi']) }}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Baru</a>
			<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button> -->
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th class="text-center">No. Transfer</th>
						<th>Tujuan</th>
						<th class="text-nowrap">No. Jurnal</th>
						<th class="text-center">Tanggal Jurnal</th>
						<th class="text-center">No Serah Terima</th>
						<th class="text-center">Tanggal Serah Terima</th>
						<th class="text-nowrap">Pengajuan</th>
                        <th class="text-center">Tanggal Verifikasi</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
				</thead>
				<tbody>
					@if(empty($transfer))
					<tr><td colspan="10" class="text-center">Tidak ada data</td></tr>
					@endif
					
					@foreach($transfer AS $item)
					<tr class="small">
						<td>{{$item->id}}</td>
						<td>{{$item->id_tujuan->nama}}</td>
						<td>{{$item->surat_no}}</td>
						<td>{{datify($item->surat_tgl)}}</td>
						<td>{{$item->serah_terima_no}}</td>
						<td>{{datify($item->serah_terima_tgl)}}</td>
						<td></td>
						<td>{{($item->status_pengajuan !== '0') ? datify($item->tanggal_verifikasi) : '-'}}</td>
						<td>
							@if($item->status_pengajuan === '0')
							<span class="badge badge-secondary">draf</span>
							@elseif($item->status_pengajuan === '1')
							<span class="badge badge-warning">menunggu</span>
							@elseif($item->status_pengajuan === '2')
							<span class="badge badge-success">disetujui</span>
							@elseif($item->status_pengajuan === '3')
							<span class="badge badge-danger">ditolak</span>
							@else
							ERROR
							@endif
						</td>
						<td>
							<div class="btn-group">
								<a href="{{ site_url('transfer/keluar_detail/'.$item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Rincian</a>
								@if($item->status_pengajuan === '0' OR $item->status_pengajuan === '3')
								<button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
								@endif
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

@section('style')
<style>
.text-sm {font-size: smaller;}
</style>
@endsection

@section('script')
<script>
	theme.activeMenu('.nav-transfer-keluar')
</script>
@end