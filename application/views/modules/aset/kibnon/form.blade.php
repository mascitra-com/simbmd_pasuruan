@layout('commons/index')
@section('title')Tidak Diakui Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('aset/kib_non?id_organisasi='.$org->id)}}">Aset</a></li>
<li class="breadcrumb-item"><a href="{{site_url('aset/kib_non?id_organisasi='.$org->id)}}">Tidak Diakui Aset</a></li>
<li class="breadcrumb-item active">{{isset($kib)?'Sunting':'Tambah'}}</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kib)?'Sunting':'Tambah'}} Aset</div>
			<div class="card-body">
				<form action="{{isset($kib)?site_url('aset/kib_non/update'):site_url('aset/kib_non/insert')}}" method="POST">
					<input type="hidden" name="id" value="{{isset($kib)?$kib->id:''}}">
					<input type="hidden" name="id_organisasi" value="{{$org->id}}">
					
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">UPB</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$org->nama}}" disabled />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" placeholder="nama" value="{{isset($kib)?$kib->nama:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Merk</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="merk" placeholder="merk" value="{{isset($kib)?$kib->merk:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">tipe</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="tipe" placeholder="tipe" value="{{isset($kib)?$kib->tipe:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nilai</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="nilai" placeholder="Nilai" value="{{isset($kib)?$kib->nilai:''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Keterangan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="{{isset($kib)?$kib->keterangan:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-secondary">Bersihkan</button>
							<a href="{{site_url('aset/kib_non?id_organisasi='.$org->id)}}" class="btn btn-warning">Kembali</a>
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
	var form = (function(){
		theme.activeMenu('.nav-invent');
	})();
</script>
@end