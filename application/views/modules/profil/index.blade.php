@layout('commons/index')
@section('title')Profil@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Profil</li>
@end

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">Data Diri</div>
			<div class="card-body">
				<form action="{{site_url('profil/update')}}" method="POST">
					<input type="hidden" name="id" value="{{$profil->id}}">
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nip" value="{{$profil->nip}}" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" value="{{$profil->nama}}" placeholder="Nama" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="jabatan" value="{{$profil->jabatan}}" placeholder="Jabatan" />
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-2"></div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
							<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card">
			<div class="card-header">Data Akun</div>
			<div class="card-body">
				<form action="{{site_url('profil/update_akun')}}" method="post">
					<input type="hidden" name="id" value="{{$profil->id}}">
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-right">Username</label>
						<div class="col-md-8">
							<input type="text" class="form-control" name="username" value="{{$profil->username}}" placeholder="Username" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-4 col-form-label text-right">Password</label>
						<div class="col-md-8">
							<input type="password" class="form-control" name="password" placeholder="Password" />
							<input type="password" class="form-control" name="password_re" placeholder="Tulis Ulang" />
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-4"></div>
						<div class="col-md-8">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
							<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Batal</button>
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
	var org = (function(){
		theme.activeMenu('.nav-profil');
	})();
</script>
@end