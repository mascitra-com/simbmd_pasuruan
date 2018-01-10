@layout('commons/index')
@section('title')Ruangan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Kosongkan Data</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Kosongkan Data SALDO AWAL</div>
			<div class="card-body row">
				<form action="{{site_url('peralatan/do_hapus')}}" class="col-6" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data?');">
					<div class="form-group">
						<label>Pilih Organisasi</label>
						<select name="id_organisasi" class="form-control select-chosen" data-placeholder="Pilih Organisasi...">
							<option></option>
							@foreach($organisasi AS $item)
							<option value="{{$item->id}}">{{$item->nama}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>PILIH KIB</label>
						<select name="kib" class="form-control">
							<option value="kiba">KIB-A</option>
							<option value="kibb">KIB-B</option>
							<option value="kibc">KIB-C</option>
							<option value="kibd">KIB-D</option>
							<option value="kibe">KIB-E</option>
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="fa fa-trash mr-2"></i> Proses</button>
						<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i> Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var ruangan = (function(){
		theme.activeMenu('.nav-backup');
})();
</script>
@end