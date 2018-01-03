@layout('commons/index')
@section('title')Koreksi Hapus@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="#">Koreksi</a></li>
<li class="breadcrumb-item active">Koreksi Hapus</li>
@endsection

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="" method="GET" class="mr-auto">
			<div class="input-group">
				<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $item)
						<option value="{{$item->id}}" {{isset($filter['id_tujuan']) && $item->id === $filter['id_tujuan'] ? 'selected' : ''}}>{{$item->nama}}</option>
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
					<!-- @if(empty($transfer))
					<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
					@endif -->
					
					<tr class="small">
						<td class="text-center">10011</td>
						<td class="text-center">{{date('d-m-Y')}}</td>
						<td class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis, maiores.</td>
						<td class="text-center">menunggu</td>
						<td class="text-center">-</td>
						<td class="text-center">
							<div class="btn-group">
								<a href="{{ site_url('koreksi/koreksi_hapus/rincian') }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Rincian</a>
							</div>
						</td>
					</tr>
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
				<form action="#" class="form-row">
					<div class="form-group col-6">
						<label>No. Jurnal</label>
						<input type="text" class="form-control" placeholder="####" readonly/>
					</div>
					<div class="form-group col-6">
						<label>Tanggal Jurnal</label>
						<input type="date" class="form-control" value="{{date('Y-m-d')}}" placeholder="tanggal jurnal" />
					</div>
					<div class="form-group col-12">
						<label>Keterangan</label>
						<textarea class="form-control" placeholder="keterangan"></textarea>
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
@endsection

@section('style')
<style>
.text-sm {font-size: smaller;}
</style>
@endsection

@section('script')
<script>
	theme.activeMenu('.nav-koreksi');
</script>
@end