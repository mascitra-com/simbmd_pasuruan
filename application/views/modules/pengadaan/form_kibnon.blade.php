@layout('commons/index')
@section('title')Pengadaan - Tambah Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/rincian/'.$spk->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kib)?'Sunting':'Tambah'}} Aset</div>
			<div class="card-body">
				<form action="{{isset($kib)?site_url('aset/kib_non/update_pengadaan'):site_url('aset/kib_non/insert_pengadaan')}}" method="POST">
					<input type="hidden" name="id" value="{{isset($kib)?$kib->id:''}}">
					<input type="hidden" name="id_organisasi" value="{{$spk->id_organisasi}}">
					<input type="hidden" name="id_spk" value="{{$spk->id}}">
					
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nomor SPK/Kontrak</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$spk->nomor}}" disabled />
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
					@if(!isset($kib))
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kuantitas*</label>
						<div class="col-md-4">
							<input type="number" min="1" class="form-control" name="kuantitas" value="1" placeholder="Kuantitas"/>
							<p class="form-text text-muted">* Banyak data yang diinputkan akan sesuai dengan jumlah kuantitas</p>
						</div>
					</div>
					@endif
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-secondary">Bersihkan</button>
							<a href="{{site_url('pengadaan/rincian/'.$spk->id)}}" class="btn btn-warning">Kembali</a>
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
		theme.activeMenu('.nav-pengadaan');

		$("[name=nilai]").on("change", fungsiNilai);
		$("[name=kuantitas]").on("change", fungsiNilai);

		function fungsiNilai(e)
		{
			var max = $("[name=nilai]").attr('max');
			var val = $("[name=nilai]").val();
			var qwt	= $("[name=kuantitas]").val();

			if (val * qwt > max) {
				alert('Nilai lebih banyak dari nilai sisa kontrak');
				$(e.currentTarget).val(0);
			}
		}
	})();
</script>
@end