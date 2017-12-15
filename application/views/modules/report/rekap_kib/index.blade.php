@layout('commons/index')
@section('title')Rekapitulasi Kartu Inventaris Barang@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="#">Laporan</a></li>
<li class="breadcrumb-item active">Rekapitulasi Kartu Inventaris Barang</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Rekapitulasi Kartu Inventaris Barang</div>
			<div class="card-body">
				<form action="{{site_url('report/rekap_kib/cetak')}}" method="POST">
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Pilih UPB</label>
						<div class="col-md-4">
							<select name="id_organisasi" class="select-chosen form-control" data-placeholder="Pilih UPB...">
								<option></option>
								@foreach($organisasi AS $org)
								<option value="{{$org->id}}" class="text-small">{{$org->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kode Kepemilikan</label>
						<div class="col-md-4">
							<select name="kd_pemilik" class="form-control form-control-sm">
								<option value="">Pilih Kode Pemilik...</option>
								<option value="00">00 - Pemerintah Pusat</option>
								<option value="01">01 - Departemen Dalam Negeri</option>
								<option value="11">11 - Pemerintah Provinsi</option>
								<option value="12">12 - Pemerintah Kabupaten/Kota</option>
								<option value="22">22 - Desa</option>
								<option value="33">33 - BOT/BTO/BT</option>
								<option value="44">44 - Instansi Lainnya</option>
								<option value="98">98 - Extracomtable</option>
								<option value="99">99 - Lainnya</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jenis KIB</label>
						<div class="col-md-4">
							<select name="kib" class="form-control form-control-sm">
								<option value="">Pilih Jenis KIB...</option>
								<option value="a">A - Tanah</option>
								<option value="b">B - Peralatan &amp Mesin</option>
								<option value="c">C - Gedung &amp Bangunan</option>
								<option value="d">D - Jalan, Irigasi dan Jaringan</option>
								<option value="e">E - Aset Tetap Lainya</option>
								<option value="f">F - Konstruksi Dalam Pengerjaan</option>
								<!-- <option value="g">G - Aset Tidak Berwujud</option> -->
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Cetak Berdasar</label>
						<div class="col-md-4">
							<select name="urut" class="form-control form-control-sm">
								<option value="1">Urut Kode Barang</option>
								<option value="2">Urut Tahun Perolehan</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Header</label>
						<div class="col-md-4">
							<input type="text" name="header" class="form-control form-control-sm" value="TAHUN {{date('Y')}}" placeholder="Header laporan" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Laporan</label>
						<div class="col-md-4">
							<input type="date" name="tanggal" class="form-control form-control-sm" value="{{date('Y-m-d')}}" placeholder="Tanggal Laporan" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nama Kota</label>
						<div class="col-md-4">
							<input type="text" name="nama_kota" class="form-control form-control-sm" value="Pasuruan" placeholder="Nama kota" />
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<h5>Yang melaporkan</h5>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" name="lapor_nama" class="form-control form-control-sm" placeholder="Nama" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" name="lapor_nip" class="form-control form-control-sm" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="lapor_jabatan" class="form-control form-control-sm" placeholder="Jabatan" />
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<h5>Yang mengetahui</h5>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_nama" class="form-control form-control-sm" placeholder="Nama" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_nip" class="form-control form-control-sm" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_jabatan" class="form-control form-control-sm" placeholder="Jabatan" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
							<button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Bersihkan</button>
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
		theme.activeMenu('.nav-rekap-kib');
	})();
</script>
@end