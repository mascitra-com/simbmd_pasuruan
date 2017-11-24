@layout('commons/index')
@section('title')Kategori@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Kategori</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<div class="card-title mr-auto">Kategori</div>
				<div class="btn-group">
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<a href="{{site_url('kategori/add/1')}}" class="btn btn-primary btn-tambah"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body table-responsive py-0">
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th colspan="5">Kode</th>
							<th rowspan="2" class="text-left">Nama</th>
							<th rowspan="2">Umur Ekonomis</th>
							<th rowspan="2">Aksi</th>
						</tr>
						<tr>
							<th>KD1</th>
							<th>KD2</th>
							<th>KD3</th>
							<th>KD4</th>
							<th>KD5</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kategori))
						<tr><td colspan="8">tidak ada data</td></tr>
						@endif

						@foreach($kategori AS $kat)
						<tr>
							<td>{{!empty($kat->kd_golongan) ? zerofy($kat->kd_golongan) : '-'}}</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td class="text-left">{{$kat->nama}}</td>
							<td>{{$kat->umur_ekonomis}}</td>
							<td>
								<div class="btn-group btn-group-sm">
									<a href="{{site_url('kategori/bidang/'.$kat->id)}}" class="btn btn-success"><i class="fa fa-eye"></i> Lihat Sub</a>
									<a href="{{site_url('kategori/edit/'.$kat->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i> Sunting</a>
									<a href="{{site_url('kategori/delete/'.$kat->id)}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?\nAksi ini tidak dapat diurungkan')"><i class="fa fa-trash"></i> Hapus</a>
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
	var kategori = (function(){
		theme.activeMenu('.nav-kategori');
	})();
</script>
@end