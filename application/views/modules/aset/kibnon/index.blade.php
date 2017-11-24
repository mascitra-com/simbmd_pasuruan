@layout('commons/index')
@section('title')Tidak Diakui Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('aset')}}">Aset</a></li>
<li class="breadcrumb-item active">Tidak Diakui Aset</li>
@end

@section('widget')
<div class="row mb-4">
	@foreach($statistic AS $stat)
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">{{$stat['title']}}</h4>
				<p class="card-text">{{$stat['value']}}</p>
			</div>
		</div>
	</div>
	@endforeach
</div>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<form action="{{site_url('aset/kib_non')}}" method="GET" class="mr-auto">
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
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button>
					<a href="{{site_url('aset/kib_non/add/'.$filter['id_organisasi'])}}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body table-responsive table-scroll px-0 py-0">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-nowrap text-center">Aksi</th>
							<th class="text-nowrap">Nama</th>
							<th class="text-nowrap">Merk</th>
							<th class="text-nowrap">Tipe</th>
							<th class="text-nowrap text-right">Nilai</th>
							<th class="text-nowrap">Keterangan</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kib))
						<tr><td colspan="6" class="text-center"><b><i>Data kosong</i></b></td></tr>
						@endif

						@foreach($kib AS $item)
						<tr>
							<td class="text-nowrap text-center">
								<div class="btn-group">
									<a href="{{site_url('aset/kib_non/edit/'.$item->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
									<a href="{{site_url('aset/kib_non/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
								</div>
							</td>
							<td class="text-nowrap">{{$item->nama}}</td>
							<td class="text-nowrap">{{$item->merk}}</td>
							<td class="text-nowrap">{{$item->tipe}}</td>
							<td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
							<td class="text-nowrap">{{$item->keterangan}}</td>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-filter">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Filter data</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('aset/kib_non')}}" method="GET">
					<input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" class="form-control" name="nama" value="{{isset($filter['nama'])?$filter['nama']:''}}" />
							</div>
							<div class="form-group">
								<label>Merk</label>
								<input type="text" class="form-control" name="merk" value="{{isset($filter['merk'])?$filter['merk']:''}}" />
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<input type="text" class="form-control" name="keterangan" value="{{isset($filter['keterangan'])?$filter['keterangan']:''}}" />
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label>Nilai</label>
								<input type="text" class="form-control" name="nilai" value="{{isset($filter['nilai'])?$filter['nilai']:''}}" />
							</div>
							<div class="form-group">
								<label>Tipe</label>
								<input type="text" class="form-control" name="tipe" value="{{isset($filter['tipe'])?$filter['tipe']:''}}" />
							</div>
							<div class="form-group">
								<label>Jumlah Tampilan Data</label>
								<select name="limit" class="form-control">
									<option value="20">20</option>
									<option value="50">50</option>
									<option value="100">100</option>
									<option value="300">300</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Filter</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Kembali</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var kib = (function(){
		theme.activeMenu('.nav-invent');
	})();
</script>
@end