@layout('commons/index')
@section('title')Kategori@end

@section('breadcrump')
<?php $id = isset($kategori) ? $kategori->sub_dari : $induk->id; ?>
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('kategori')}}">Kategori</a></li>
<li class="breadcrumb-item"><a href="#">Bidang</a></li>
<li class="breadcrumb-item"><a href="{{site_url('kategori/kelompok/'.$id)}}">Kelompok</a></li>
<li class="breadcrumb-item active">{{isset($kategori)?'Sunting':'Tambah'}}</li>
@end

@section('content')
<div class="card">
	<div class="card-header">{{isset($kategori)?'Sunting':'Tambah'}} Kategori</div>
	<div class="card-body">
		<form action="{{isset($kategori)?site_url('kategori/update?ref=kategori/kelompok/'.$id):site_url('kategori/insert?ref=kategori/kelompok/'.$id)}}" method="POST">
			<input type="hidden" name="id" value="{{isset($kategori)?$kategori->id :''}}">
			<input type="hidden" name="jenis" value="3">
			<input type="hidden" name="sub_dari" value="{{$id}}">
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Kode</label>
				<div class="col-md-4 form-row">
					<input type="text" name="kd_golongan" value="{{isset($kategori)?$kategori->kd_golongan : $induk->kd_golongan}}" class="form-control text-center col" readonly />
					<input type="text" name="kd_bidang" value="{{isset($kategori)?$kategori->kd_bidang : $induk->kd_bidang}}" class="form-control text-center col" readonly />
					<input type="text" name="kd_kelompok" value="{{isset($kategori)?$kategori->kd_kelompok : ''}}" class="form-control text-center col" required />
					<input type="text" name="kd_subkelompok" class="form-control text-center col" disabled />
					<input type="text" name="kd_subsubkelompok" class="form-control text-center col" disabled />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Nama</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="nama" value="{{isset($kategori)?$kategori->nama :''}}" placeholder="nama kategori" required />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Umur Ekonomis</label>
				<div class="col-md-4">
					<input type="number" min="0.00" step="0.01" class="form-control" name="umur_ekonomis" value="{{isset($kategori)?$kategori->umur_ekonomis :''}}" placeholder="umur ekonomis" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right"></label>
				<div class="col-md-4">
					<button class="btn btn-primary">Simpan</button>
					<a href="{{site_url('kategori/kelompok/'.$id)}}" class="btn btn-warning">Kembali</a>
				</div>
			</div>
		</form>
	</div>
</div>
@end