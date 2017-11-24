@layout('commons/index')
@section('title')Kegiatan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Kegiatan</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<form class="mr-auto" action="{{site_url('kegiatan')}}" method="GET">
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
					<a href="{{site_url('kegiatan/add/'.$id)}}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body px-0 py-0">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="15%" class="text-center">Kode</th>
							<th>Nama kegiatan</th>
							<th>Tahun</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kegiatan))
						<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
						@endif

						@foreach($kegiatan AS $giat)
						<tr>
							<td width="15%" class="text-center">{{$giat->kode}}</td>
							<td>{{$giat->nama}}</td>
							<td>{{$giat->tahun}}</td>
							<td class="text-center">
								<div class="btn-group">
									<a href="{{site_url('kegiatan/edit/'.$giat->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
									<a href="{{site_url('kegiatan/delete/'.$giat->id)}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
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
	var kegiatan = (function(){
		theme.activeMenu('.nav-kegiatan');
	})();
</script>
@end