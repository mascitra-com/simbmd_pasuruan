@layout('commons/index')
@section('title')Ruangan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Ruangan</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<form class="mr-auto" action="{{site_url('ruangan')}}" method="GET">
					<div class="input-group">
						<select name="id_organisasi" class="form-control select-chosen" data-placeholder="Pilih UPB">
							<option></option>
							@foreach($organisasi AS $org)
							<option value="{{$org->id}}" {{isset($id) && $org->id === $id ? 'selected' : ''}}>{{$org->nama}}</option>
							@endforeach
						</select>
						<div class="input-group-btn">
							<button class="btn btn-primary"><i class="fa fa-check mr-2"></i>Pilih</button>
						</div>
					</div>
				</form>
				<div class="btn-group">
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<a href="{{site_url('ruangan/add/'.$id)}}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body px-0 py-0">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="text-center">Kode</th>
							<th>Nama Ruangan</th>
							<th>Penganggung Jawab</th>
							<th>NIP</th>
							<th>Jabatan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($ruangan))
						<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
						@endif

						@foreach($ruangan AS $ruang)
						<tr>
							<td class="text-center">{{$ruang->kode}}</td>
							<td>{{$ruang->nama}}</td>
							<td>{{$ruang->penanggung_nama}}</td>
							<td>{{$ruang->penanggung_nip}}</td>
							<td>{{$ruang->penanggung_jabatan}}</td>
							<td>
								<div class="btn-group">
									<a href="{{site_url('ruangan/edit/'.$ruang->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
									<a href="{{site_url('ruangan/delete/'.$ruang->id)}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
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

@section('script')
<script type="text/javascript">
	var ruangan = (function(){
		theme.activeMenu('.nav-ruangan');
	})();
</script>
@end