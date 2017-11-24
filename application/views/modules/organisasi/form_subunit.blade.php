@layout('commons/index')
@section('title')Organisasi@end

@section('breadcrump')
<?php $id = isset($organisasi) ? $organisasi->sub_dari : $induk->id; ?>
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('organisasi')}}">Bidang</a></li>
<li class="breadcrumb-item"><a href="#">Unit</a></li>
<li class="breadcrumb-item"><a href="{{site_url('organisasi/subunit/'.$id)}}">Sub-Unit</a></li>
<li class="breadcrumb-item active">{{isset($organisasi)?'Sunting':'Tambah'}}</li>
@end

@section('content')
<div class="card">
	<div class="card-header">{{isset($organisasi)?'Sunting':'Tambah'}} organisasi</div>
	<div class="card-body">
		<form action="{{isset($organisasi)?site_url('organisasi/update?ref=organisasi/subunit/'.$id):site_url('organisasi/insert?ref=organisasi/subunit/'.$id)}}" method="POST">
			<input type="hidden" name="id" value="{{isset($organisasi)?$organisasi->id :''}}">
			<input type="hidden" name="jenis" value="3">
			<input type="hidden" name="sub_dari" value="{{$id}}">
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Kode</label>
				<div class="col-md-4 form-row">
					<input type="text" name="kd_bidang" value="{{isset($organisasi)?$organisasi->kd_bidang : $induk->kd_bidang}}" class="form-control text-center col" readonly />
					<input type="text" name="kd_unit" value="{{isset($organisasi)?$organisasi->kd_unit : $induk->kd_unit}}" class="form-control text-center col" readonly />
					<input type="text" name="kd_subunit" value="{{isset($organisasi)?$organisasi->kd_subunit : ''}}" class="form-control text-center col" required />
					<input type="text" name="kd_upb" class="form-control text-center col" disabled />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Nama</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="nama" value="{{isset($organisasi)?$organisasi->nama :''}}" placeholder="nama organisasi" required />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Nama Kepala</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="kepala_nama" value="{{isset($organisasi)?$organisasi->kepala_nama:''}}" placeholder="nama kepala" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">NIP Kepala</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="kepala_nip" value="{{isset($organisasi)?$organisasi->kepala_nip:''}}" placeholder="NIP kepala" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">Nama Pengurus Barang</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="pengurus_nama" value="{{isset($organisasi)?$organisasi->pengurus_nama:''}}" placeholder="nama pengurus" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right">NIP Pengurus Barang</label>
				<div class="col-md-4">
					<input type="text" class="form-control" name="pengurus_nip" value="{{isset($organisasi)?$organisasi->pengurus_nip:''}}" placeholder="NIP pengurus" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-2 col-form-label text-right"></label>
				<div class="col-md-4">
					<button class="btn btn-primary">Simpan</button>
					<a href="{{site_url('organisasi/subunit/'.$id)}}" class="btn btn-warning">Kembali</a>
				</div>
			</div>
		</form>
	</div>
</div>
@end