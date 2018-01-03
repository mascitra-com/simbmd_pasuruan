@layout('commons/index')
@section('title')Ruangan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Hapus Data</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Hapus Data</div>
			<div class="card-body row">
				<form action="{{site_url('peralatan/do_hapus')}}" class="col-6" method="POST">
					<div class="form-group">
						<label>Pilih Organisasi</label>
						<select name="id_organisasi" class="form-control form-chosen" data-placeholder="Pilih Organisasi...">
							@foreach($organisasi AS $item)
							<option value="{{$item->id}}">{{$item->nama}}</option>
							@endforeach
						</select>
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