@layout('commons/index')
@section('title')Ruangan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('ruangan')}}">Ruangan</a></li>
<li class="breadcrumb-item active">{{isset($ruangan) ? 'Sunting' : 'Tambah'}}</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($ruangan) ? 'Sunting' : 'Tambah'}} Ruangan</div>
			<div class="card-body">
				<form action="{{isset($ruangan) ? site_url('ruangan/update') : site_url('ruangan/insert')}}" method="POST">
					<input type="hidden" name="id" value="{{isset($ruangan) ? $ruangan->id : ''}}">
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
							<input type="text" class="form-control" name="kode" placeholder="Kode" value="{{isset($ruangan) ? $ruangan->kode : ''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama Ruangan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" placeholder="Nama ruangan" value="{{isset($ruangan) ? $ruangan->nama : ''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Penganggung Jawab</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="penanggung_nama" placeholder="Penanggung Jawab" value="{{isset($ruangan) ? $ruangan->penanggung_nama : ''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="penanggung_nip" placeholder="Penanggung Jawab" value="{{isset($ruangan) ? $ruangan->penanggung_nip : ''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="penanggung_jabatan" placeholder="Penanggung Jawab" value="{{isset($ruangan) ? $ruangan->penanggung_jabatan : ''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label"></label>
						<div class="col-md-4">
							<button class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
							<a href="{{site_url('ruangan')}}" class="btn btn-warning"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
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
	var ruangan = (function(){
		theme.activeMenu('.nav-ruangan');
	})();
</script>
@end