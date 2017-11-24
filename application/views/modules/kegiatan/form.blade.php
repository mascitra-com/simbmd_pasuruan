@layout('commons/index')
@section('title')Kegiatan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('kegiatan')}}">Kegiatan</a></li>
<li class="breadcrumb-item active">{{isset($kegiatan) ? 'Sunting' : 'Tambah'}}</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kegiatan) ? 'Sunting' : 'Tambah'}} kegiatan</div>
			<div class="card-body">
				<form action="{{isset($kegiatan) ? site_url('kegiatan/update') : site_url('kegiatan/insert')}}" method="POST">
					
					<input type="hidden" name="id" value="{{isset($kegiatan) ? $kegiatan->id : ''}}">
					<input type="hidden" name="id_organisasi" value="{{$organisasi->id}}">
					
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Organisasi</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$organisasi->nama}}" readonly/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Kode</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="kode" placeholder="Kode" value="{{isset($kegiatan) ? $kegiatan->kode : ''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama kegiatan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" placeholder="Nama kegiatan" value="{{isset($kegiatan) ? $kegiatan->nama : ''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Tahun</label>
						<div class="col-md-4">
							<select name="tahun" class="form-control">
								@for($i=date('Y'); $i>=1945; $i--)
								<option value="{{$i}}" {{isset($kegiatan) && $i === $kegiatan->tahun ? 'selected' : ''}}>{{$i}}</option>
								@endfor
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"></label>
						<div class="col-md-4">
							<button class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
							<a href="{{site_url('kegiatan')}}" class="btn btn-warning"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
						</div>
					</div>
				</form>
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