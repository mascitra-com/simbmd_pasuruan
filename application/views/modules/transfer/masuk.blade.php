@layout('commons/index')
@section('title')Transfer Masuk@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Transfer Masuk</li>
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
						<th>No. Jurnal</th>
						<th class="text-nowrap">Tanggal Jurnal</th>
						<th class="text-nowrap">No Serah Terima</th>
						<th class="text-nowrap">Tanggal Serah Terima</th>
						<th class="text-nowrap">Pengajuan</th>
                        <th class="text-nowrap">Tanggal Verifikasi</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-center"></th>
                    </tr>
				</thead>
				<tbody>
				<tr>
					<td>1</td>
					<td>Bagian Umum</td>
					<td>452434</td>
					<td>6-12-2017</td>
					<td>4534324</td>
					<td>12-12-2017</td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<a href="{{ site_url('transfer/detail/172') }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Rincian</a>
						<a href="#" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Verifikasi</a>
					</td>
				</tr>
                </tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer"></div>
</div>
@end

@section('style')
<style>
.text-sm {font-size: smaller;}
</style>
@endsection

@section('script')
<script>
	theme.activeMenu('.nav-transfer-masuk')
</script>
@end