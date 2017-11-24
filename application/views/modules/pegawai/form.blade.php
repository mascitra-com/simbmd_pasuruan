@layout('commons/index')
@section('title')Profil@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pegawai')}}">Pegawai</a></li>
<li class="breadcrumb-item active">{{isset($peg) ? 'Sunting' : 'Tambah'}}</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Data Diri</div>
			<div class="card-body">
				<form action="{{isset($peg) ? site_url('pegawai/update') : site_url('pegawai/insert')}}" method="POST">
					<input type="hidden" name="id" value="{{isset($peg) ? $peg->id : ''}}">
					@if($this->session->auth['is_superadmin'])
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Organisasi</label>
						<div class="col-md-4">
							<select name="id_organisasi" class="form-control">
								@foreach($org_list AS $org)
								<option value="{{$org->id}}" {{isset($peg) && $org->id === $peg->id_organisasi ? 'selected' : ''}}>{{$org->id.' - '.$org->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					@else
					<input type="hidden" name="id_organisasi" value="{{$this->session->auth['id_organisasi']}}">
					@endif
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nip" value="{{isset($peg) ? $peg->nip : ''}}" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" value="{{isset($peg) ? $peg->nama : ''}}" placeholder="Nama" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="jabatan" value="{{isset($peg) ? $peg->jabatan : ''}}" placeholder="Jabatan" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Username</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="username" value="{{isset($peg) ? $peg->username : ''}}" placeholder="Username" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Password</label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="password" placeholder="Password" {{isset($peg) ? '' : 'required'}}/>
							<input type="password" class="form-control" name="password_re" placeholder="Tulis Ulang" {{isset($peg) ? '' : 'required'}}/>
						</div>
					</div>
					@if($this->session->auth['is_superadmin'])
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Otoritas</label>
						<div class="col-md-4">
							<div class="form-check form-check-inline">
								<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="is_admin" value="1" {{isset($peg) && $peg->is_admin === '1' ? 'checked' : ''}}> Admin
								</label>
							</div>
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" name="is_superadmin" value="1" {{isset($peg) && $peg->is_superadmin === '1' ? 'checked' : ''}}> Super Admin
								</label>
							</div>
						</div>
					</div>
					@endif
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
</div>
@end