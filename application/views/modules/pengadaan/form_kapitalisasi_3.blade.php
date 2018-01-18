@layout('commons/index')
@section('title')Pengadaan - Tambah Nilai Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Nilai Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kpt) ? 'Sunting Penambahan Nilai' : 'Tambah Nilai Aset (Langkah Terakhir)'}}</div>
			<div class="card-body table-responsive">
				<form action="{{isset($kpt) ? site_url('pengadaan/kapitalisasi/update') : site_url('pengadaan/kapitalisasi/insert')}}" method="POST">
					
					<input type="hidden" name="id" value="{{isset($kpt) ? $kpt->id : ''}}">
					<input type="hidden" name="id_kategori" value="{{$kategori->id}}">
					<input type="hidden" name="id_spk" value="{{$spk->id}}">
					<input type="hidden" name="id_aset" value="{{$kib->id}}">
					<input type="hidden" name="golongan" value="{{$golongan}}">

					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Reg Induk Aset</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$kib->reg_induk}}" readonly/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih SP2D</label>
						<div class="col-md-4">
							<select name="id_sp2d" class="form-control">
								@foreach($sp2d AS $item)
								<option value="{{$item->id}}">{{$item->nomor}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Kategori</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$kategori->nama}}" readonly/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" placeholder="Nama Barang" value="{{isset($kpt) ? $kpt->nama : ''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Merk</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="merk" value="{{isset($kpt) ? $kpt->merk : ''}}" placeholder="Merk" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Alamat</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="alamat" value="{{isset($kpt) ? $kpt->alamat : ''}}" placeholder="Alamat" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Tipe</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="tipe" value="{{isset($kpt) ? $kpt->tipe : ''}}" placeholder="Tipe" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Jumlah</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="jumlah" min="1" value="1" placeholder="Jumlah" readonly required />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nilai Satuan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nilai" value="{{isset($kpt) ? monefy($kpt->nilai) : ''}}" placeholder="Nilai Satuan" required />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nilai Penunjang</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nilai_penunjang" value="{{isset($kpt) ? monefy($kpt->nilai_penunjang) : ''}}" placeholder="Nilai Penunjang" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right"></label>
						<div class="col-md-4">
							@if(isset($kpt))
							<a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}" class="btn btn-warning">Kembali</a>
							@else
							<a href="{{site_url('pengadaan/kapitalisasi/add/langkah_2/'.$spk->id.'?golongan='.$golongan.'&subsubkelompok='.$subsubkelompok)}}" class="btn btn-warning">Kembali</a>
							@endif
							<button class="btn btn-primary">Simpan</button>
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
	})();
</script>
@end