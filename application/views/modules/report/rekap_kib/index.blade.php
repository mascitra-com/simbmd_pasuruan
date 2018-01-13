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
							<div class="input-group">
							    <input type="text" name="lapor_nama" class="form-control form-control-sm" value="{{ $melaporkan_kib->nama }}" placeholder="Nama" />
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-melaporkan">Pilih</button>
                                </span>
                            </div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" name="lapor_nip" class="form-control form-control-sm" value="{{ $melaporkan_kib->nip }}" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="lapor_jabatan" class="form-control form-control-sm" value="{{ $melaporkan_kib->jabatan }}" placeholder="Jabatan" />
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
                                <input type="text" name="mengetahui_nama" value="{{ $mengetahui_kib->nama }}" class="form-control form-control-sm" placeholder="Nama" />
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-mengetahui">Pilih</button>
                                </span>
                            </div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">NIP</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_nip" value="{{ $mengetahui_kib->nip }}" class="form-control form-control-sm" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_jabatan" value="{{ $mengetahui_kib->jabatan }}" class="form-control form-control-sm" placeholder="Jabatan" />
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
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-melaporkan">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Pegawai</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12 table-responsive col-scroll">
							<table class="table table-bordered table-sm" id="tbl-melaporkan">
								<thead>
								<tr>
									<th>NIP</th>
									<th>Nama</th>
									<th>Jabatan</th>
									<th></th>
								</tr>
								<tr>
									<th colspan="4">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Cari Pegawai..."
												   id="ip-search-melaporkan">
											<div class="input-group-btn">
												<button class="btn btn-primary" id="tb-search-melaporkan"><i
															class="fa fa-search"></i></button>
											</div>
										</div>
									</th>
								</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="modal-mengetahui">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Pegawai</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12 table-responsive col-scroll">
							<table class="table table-bordered table-sm" id="tbl-mengetahui">
								<thead>
								<tr>
									<th>NIP</th>
									<th>Nama</th>
									<th>Jabatan</th>
									<th></th>
								</tr>
								<tr>
									<th colspan="4">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Cari Pegawai..."
												   id="ip-search-mengetahui">
											<div class="input-group-btn">
												<button class="btn btn-primary" id="tb-search-mengetahui"><i
															class="fa fa-search"></i></button>
											</div>
										</div>
									</th>
								</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
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
    $("#tb-search-mengetahui").on("click", fungsiTombolCariMengetahui);
    $("#ip-search-mengetahui").on("keyup", fungsiEnterCariMengetahui);
    $("#tbl-mengetahui").delegate("[data-nip]", "click", fungsiTombolMengetahui);

    $("#tb-search-melaporkan").on("click", fungsiTombolCariMelaporkan);
    $("#ip-search-melaporkan").on("keyup", fungsiEnterCariMelaporkan);
    $("#tbl-melaporkan").delegate("[data-nip]", "click", fungsiTombolMelaporkan);

    function fungsiEnterCariMengetahui(e) {
        var enterKey = 13;
        if (e.which === enterKey) {
            fungsiTombolCariMengetahui();
        }
    }

    function fungsiTombolCariMengetahui(e) {
        var key = $("#ip-search-mengetahui").val();
        $.getJSON("{{site_url('pegawai/get_data_search?key=')}}" + key, function (result) {
            $("#tbl-mengetahui > tbody").empty();
            $("#tbl-mengetahui > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan " + result.length + " data teratas</b></td></tr>");
            $.each(result, function (key, value) {
                var html = "<tr>";
                html += "<td>" + value.nip + "</td>";
                html += "<td>" + value.nama + "</td>";
                html += "<td>" + value.jabatan + "</td>";
                html += "<td><button class='btn btn-secondary btn-sm btn-block' data-id='" + value.id + "' data-nip='" + value.nip + "' data-nama='" + value.nama + "' data-jabatan='" + value.jabatan + "'>Pilih</button></td>";
                html += "</tr>";

                $("#tbl-mengetahui > tbody").append(html);
            });
        });
    }

    function fungsiTombolMengetahui(e) {
        $.getJSON("{{site_url('pegawai/save_cookie?name=mengetahui_kib&id=')}}" + $(e.currentTarget).data('id'), function (result) {
            $('[name=mengetahui_nip]').val($(e.currentTarget).data('nip'));
            $('[name=mengetahui_nama]').val($(e.currentTarget).data('nama'));
            $('[name=mengetahui_jabatan]').val($(e.currentTarget).data('jabatan'));
            $("#modal-mengetahui").modal('hide');
        });
    }

    function fungsiEnterCariMelaporkan(e) {
        var enterKey = 13;
        if (e.which === enterKey) {
            fungsiTombolCariMelaporkan();
        }
    }

    function fungsiTombolCariMelaporkan(e) {
        var key = $("#ip-search-mengetahui").val();
        $.getJSON("{{site_url('pegawai/get_data_search?key=')}}" + key, function (result) {
            $("#tbl-melaporkan > tbody").empty();
            $("#tbl-melaporkan > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan " + result.length + " data teratas</b></td></tr>");
            $.each(result, function (key, value) {
                var html = "<tr>";
                html += "<td>" + value.nip + "</td>";
                html += "<td>" + value.nama + "</td>";
                html += "<td>" + value.jabatan + "</td>";
                html += "<td><button class='btn btn-secondary btn-sm btn-block' data-id='" + value.id + "' data-nip='" + value.nip + "' data-nama='" + value.nama + "' data-jabatan='" + value.jabatan + "'>Pilih</button></td>";
                html += "</tr>";

                $("#tbl-melaporkan > tbody").append(html);
            });
        });
    }

    function fungsiTombolMelaporkan(e) {
        $.getJSON("{{site_url('pegawai/save_cookie?name=melaporkan_kib&id=')}}" + $(e.currentTarget).data('id'), function (result) {
            $('[name=lapor_nip]').val($(e.currentTarget).data('nip'));
            $('[name=lapor_nama]').val($(e.currentTarget).data('nama'));
            $('[name=lapor_jabatan]').val($(e.currentTarget).data('jabatan'));
            $("#modal-melaporkan").modal('hide');
        });
    }
</script>
@end