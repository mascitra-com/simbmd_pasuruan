@layout('commons/index')
@section('title')Profil@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Profil</li>
@end

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">Data Diri</div>
			<div class="card-body">
				<form action="{{site_url('profil/update')}}" method="POST">
					<input type="hidden" name="id" value="{{$profil->id}}">
					<div class="form-group">
						<label>NIP</label>
						<input type="text" class="form-control" name="nip" value="{{$profil->nip}}" placeholder="NIP" />
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" class="form-control" name="nama" value="{{$profil->nama}}" placeholder="Nama" required/>
					</div>
					<div class="form-group">
						<label>Jabatan</label>
						<input type="text" class="form-control" name="jabatan" value="{{$profil->jabatan}}" placeholder="Jabatan" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
						<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Batal</button>
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
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="username" value="{{$profil->username}}" placeholder="Username" disabled/>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" placeholder="Password" />
						<input type="password" class="form-control" name="password_re" placeholder="Tulis Ulang" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
						<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i>Batal</button>
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