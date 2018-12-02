@layout('commons/index')
@section('title')Rekapitulasi Ekstrakomtabel@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="#">Laporan</a></li>
<li class="breadcrumb-item active">Rekapitulasi Ekstrakomtabel</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Rekapitulasi Ekstrakomtabel</div>
			<div class="card-body">
				<form action="{{site_url('report/rekap_ekstrakomtabel/cetak')}}" method="POST">
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Pilih UPB</label>
						<div class="col-md-4">
							<select name="id_organisasi" class="select-chosen form-control" data-placeholder="Pilih UPB...">
								<option></option>
								@if($this->session->auth['is_superadmin'] == 1)
								<option value="all" class="text-small">KABUPATEN</option>
								@endif
								@if($this->session->auth['is_superadmin'] == 1 || $id_organisasi == 195)
								<option value="7.1">DINAS KESEHATAN (SEMUA)</option>
								@endif
								@if($this->session->auth['is_superadmin'] == 1 || $id_organisasi == 233)
								<option value="8.1">DINAS PENDIDIKAN DAERAH (SEMUA)</option>
								@endif
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
								@if($this->config->item('mode')==='jember')
								<option value="101">101 - Aset Lainnya</option>
								<option value="102">102 - Aset Rusak</option>
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jenis KIB</label>
						<div class="col-md-4">
							<select name="kib" class="form-control form-control-sm" id="kib">
								<option value="">Pilih Jenis KIB...</option>
								<option value="b">B - Peralatan &amp Mesin</option>
								<option value="c">C - Gedung &amp Bangunan</option>
								<option value="e">E - Aset Tetap Lainya</option>
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
					<div class="form-group row" id="kondisi">
						<label class="col-md-3 col-form-label text-right">Kondisi</label>
						<div class="col-md-4">
							<select name="kondisi" class="form-control form-control-sm">
								<option value="">Semua</option>
								<option value="1">Baik</option>
								<option value="2">Kurang Baik</option>
								<option value="0">Rusak Berat</option>
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
							<input type="text" name="nama_kota" class="form-control form-control-sm" value="PASURUAN" placeholder="Nama kota" />
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
							<div class="input-group">
								<input type="text" name="lapor_nama" class="form-control form-control-sm" value="" placeholder="Nama" />
								<span class="input-group-btn">
									<button type="button" class="btn btn-primary" data-target-cari='lapor'>Pilih</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" name="lapor_nip" class="form-control form-control-sm" value="" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="lapor_jabatan" class="form-control form-control-sm" value="" placeholder="Jabatan" />
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
							<div class="input-group">
								<input type="text" name="mengetahui_nama" value="" class="form-control form-control-sm" placeholder="Nama" />
								<span class="input-group-btn">
									<button type="button" class="btn btn-primary" data-target-cari='mengetahui'>Pilih</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_nip" value="" class="form-control form-control-sm" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_jabatan" value="" class="form-control form-control-sm" placeholder="Jabatan" />
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

@section('modal')
<div class="modal fade" id="modal-cari-pegawai" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Pilih Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" name="target">
				<table class="jq-table table-striped" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('pegawai/get?id_organisasi=')}}">
					<thead>
						<tr>
							<th data-field="nip">NIP</th>
							<th data-field="nama" data-class="text-nowrap">Nama</th>
							<th data-field="jabatan" data-class="text-nowrap">Jabatan</th>
							<th data-field="aksi" data-formatter='aksi' data-class='text-center'>Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<link rel="stylesheet" href="{{base_url('res/plugins/bttable/bttable.css')}}">
@end

@section('script')
<script src="{{base_url('res/plugins/bttable/bttable.js')}}"></script>
<script type="text/javascript">
	
	var url = "{{site_url('pegawai/get')}}";
	
	theme.activeMenu('.nav-rekap-lainnya');
	
	$(".jq-table").bootstrapTable({
		formatRecordsPerPage: function () {
			return ''
		},
		formatShowingRows: function () {
			return ''
		}
	});

	$("[data-target-cari]").on('click', function(){
		var idOrganisasi = $('.select-chosen').val();
		var urls = url+'?id_organisasi='+idOrganisasi;

		if(idOrganisasi === '5.2' || idOrganisasi === '7.1' || idOrganisasi === '8.1'){
			idOrganisasi = idOrganisasi.split('.');
			urls = url+'?kd_bidang='+idOrganisasi[0]+'&kd_unit='+idOrganisasi[1];
		}

		$("[name=target]").val( $(this).data('target-cari') );
		$(".jq-table").bootstrapTable('refresh', {'url':urls});
		$("#modal-cari-pegawai").modal('show');
	});

	function aksi(value, row, index, field){
		return "<button class='btn btn-sm btn-primary' data-nama='"+row.nama+"' data-nip='"+row.nip+"' data-jabatan='"+row.jabatan+"'>pilih</button>"
	}

	$("table tbody").delegate('[data-nama]', 'click', function(e){
		var target = $('[name=target]').val();
		$('[name='+target+'_nama]').val($(e.currentTarget).data('nama'));
		$('[name='+target+'_nip]').val($(e.currentTarget).data('nip'));
		$('[name='+target+'_jabatan]').val($(e.currentTarget).data('jabatan'));
		$('#modal-cari-pegawai').modal('hide');
	});
</script>
@end