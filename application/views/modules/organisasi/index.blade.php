@layout('commons/index')
@section('title')Organisasi@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Organisasi</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<div class="card-title mr-auto">Organisasi</div>
				<div class="btn-group">
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
				</div>
			</div>
			<div class="card-body table-responsive py-0 px-0">
				<table class="table table-striped table-hover table-bordered table-sm">
					<thead>
						<tr>
							<th colspan="4">KODE</th>
							<th rowspan="2" class="text-left">NAMA</th>
							<th rowspan="2">KEPALA</th>
							<th rowspan="2">PENYIMPAN BARANG</th>
							<th rowspan="2">AKSI</th>
						</tr>
						<tr>
							<th width="5%">BIDANG</th>
							<th width="5%">ORGANISASI</th>
							<th width="5%">SUB</th>
							<th width="5%">UPB</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($organisasi))
						<tr><td colspan="8">tidak ada data</td></tr>
						@endif

						@foreach($organisasi AS $org)
						<tr>
							<td>{{zerofy($org->kd_bidang)}}</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td class="text-left">{{$org->nama}}</td>
							<td>-</td>
							<td>-</td>
							<td>
								<div class="btn-group btn-group-sm">
									<a href="{{site_url('organisasi/unit/'.$org->id)}}" class="btn btn-success"><i class="fa fa-eye"></i> Lihat Sub</a>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
	td,th{text-align: center}
</style>
@end

@section('script')
<script type="text/javascript">
	var organisasi = (function(){
		theme.activeMenu('.nav-organisasi');
	})();
</script>
@end