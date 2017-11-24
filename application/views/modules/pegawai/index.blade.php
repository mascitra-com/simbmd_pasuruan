@layout('commons/index')
@section('title')Pegawai@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pegawai</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<div class="card-title"><h4>Pegawai</h4></div>
				<div class="btn-group ml-auto">
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<button class="btn btn-primary btn-filter"><i class="fa fa-filter mr-2"></i>Filter</button>
					<a href="{{site_url('pegawai/add')}}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body table-responsive px-0 py-0">
				<table class="table table-striped table-bodered table-hover">
					<thead>
						<tr>
							<th class="text-center">Organisasi</th>
							<th>Nama</th>
							<th>NIP</th>
							<th class="text-center">Jabatan</th>
							<th class="text-center">Admin</th>
							@if($this->session->auth['is_superadmin'])
							<th class="text-center">Super Admin</th>
							@endif
							<th class="text-center">Terakhir Masuk</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($pegawai))
						<tr><td colspan="8" class="text-center">tidak ada data</td></tr>
						@endif
						
						@foreach($pegawai AS $peg)
						<tr>
							<td class="text-center">{{$peg->id_organisasi}}</td>
							<td>{{$peg->nama}}</td>
							<td>{{$peg->nip}}</td>
							<td class="text-center">{{$peg->jabatan}}</td>
							<td class="text-center">{{!empty($peg->is_admin) ? '<i class="fa fa-2x fa-check text-success"></i>' : '<i class="fa fa-2x fa-ban text-danger"></i>'}}</td>
							
							<!-- IF SUPERADMIN -->
							@if($this->session->auth['is_superadmin'])
							<td class="text-center">{{!empty($peg->is_superadmin) ? '<i class="fa fa-2x fa-check text-success"></i>' : '<i class="fa fa-2x fa-ban text-danger"></i>'}}</td>
							@endif
							
							<td class="text-center">{{date('d/m/Y - H:i', strtotime($peg->last_login))}}</td>
							<td>
								<div class="btn-group btn-group-sm">
									<a href="{{site_url('pegawai/edit/'.$peg->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
									<a href="{{site_url('pegawai/delete/'.$peg->id)}}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">{{$pagination}}</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modalfilter">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Filter Data</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="" method="GET">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>NIP</label>
							<input type="text" class="form-control" name="nip" placeholder="nip pegawai" value="{{isset($filter['nip']) ? $filter['nip'] : ''}}" />
						</div>
						<div class="form-group col-md-6">
							<label>Nama</label>
							<input type="text" class="form-control" name="nama" placeholder="nama pegawai" value="{{isset($filter['nama']) ? $filter['nama'] : ''}}"/>
						</div>
					</div>
					@if($this->session->auth['is_superadmin'])
					<div class="form-group">
						<label>Organisasi</label>
						<select class="form-control" name="id_organisasi">
							<option value="">Semua. . .</option>
							@foreach($org_list AS $org)
							<option value="{{$org->id}}">{{$org->id.' - '.$org->nama}}</option>
							@endforeach
						</select>
					</div>
					@endif
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Urutkan Berdasar</label>
							<select class="form-control" name="ord_by">
								<option value="id" {{isset($filter['ord_by']) && $filter['ord_by'] === 'id' ? 'selected' : ''}}>ID</option>
								<option value="nip" {{isset($filter['ord_by']) && $filter['ord_by'] === 'nip' ? 'selected' : ''}}>NIP</option>
								<option value="nama" {{isset($filter['ord_by']) && $filter['ord_by'] === 'nama' ? 'selected' : ''}}>Nama</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Posisi Urutan</label>
							<select class="form-control" name="ord_pos">
								<option value="ASC" {{isset($filter['ord_pos']) && $filter['ord_pos'] === 'ASC' ? 'selected' : ''}}>Menaik</option>
								<option value="DESC" {{isset($filter['ord_pos']) && $filter['ord_pos'] === 'DESC' ? 'selected' : ''}}>Menurun</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label>Jumlah Data Tampilan</label>
						<select class="form-control" name="limit">
							<option value="20" {{isset($filter['limit']) && $filter['limit'] === '20' ? 'selected' : ''}}>20 data</option>
							<option value="50" {{isset($filter['limit']) && $filter['limit'] === '50' ? 'selected' : ''}}>50 data</option>
							<option value="100" {{isset($filter['limit']) && $filter['limit'] === '100' ? 'selected' : ''}}>100 data</option>
							<option value="300" {{isset($filter['limit']) && $filter['limit'] === '300' ? 'selected' : ''}}>300 data</option>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="fa fa-filter mr-2"></i>Filter</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var org = (function(){
		theme.activeMenu('.nav-pegawai');
		$(".btn-filter").on('click', eventFilter);

		function eventFilter(e) {
			$("#modalfilter").modal('show');
		}
	})();
</script>
@end