@layout('commons/index')
@section('title')Rekapitulasi Aset Tetap@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="#">Laporan</a></li>
<li class="breadcrumb-item active">Rekapitulasi Aset Tetap</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Rekapitulasi Aset Tetap (Permendagri No.17)</div>
			<div class="card-body">
				<form action="{{site_url('report/rekap_aset/cetak/17')}}" method="POST">
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Pilih UPB</label>
						<div class="col-md-4">
							<select name="id_organisasi" class="select-chosen form-control" data-placeholder="Pilih UPB...">
								<option></option>
                                @if($this->session->auth['is_superadmin'] == 1)
                                    <option value="all">KABUPATEN</option>
                                @endif
                                @if($this->session->auth['is_superadmin'] == 1 || $id_organisasi == 195)
                                    <option value="7.1">DINAS KESEHATAN (SEMUA)</option>
                                @endif
                                @if($this->session->auth['is_superadmin'] == 1 || $id_organisasi == 233)
                                    <option value="8.1">DINAS PENDIDIKAN DAERAH (SEMUA)</option>
                                @endif
								@foreach($organisasi AS $org)
									<option value="{{$org->id}}" class="text-small" {{ $org->id === $id_organisasi ? 'selected' : '' }}>{{$org->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jenis Rekap</label>
						<div class="col-md-4">
							<select name="jenis" class="form-control form-control-sm">
								<option value="1">1. Bidang</option>
								<option value="2">2. Kelompok</option>
								<option value="3">3. Sub-Kelompok</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Sumber Data</label>
						<div class="col-md-4">
							<select name="sumber_data" class="form-control form-control-sm">
								<option value="1">Saldo Berjalan</option>
								<option value="2">Saldo Awal (Tahun {{date('Y') - 1}})</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Header Laporan</label>
						<div class="col-md-4">
							<input type="text" name="header" class="form-control form-control-sm" placeholder="Header laporan" value="Laporan"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Laporan</label>
						<div class="col-md-4">
							<input type="date" name="tanggal" class="form-control form-control-sm" placeholder="Tanggal Laporan" value="{{ date('Y-m-d') }}" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nama Kota</label>
						<div class="col-md-4">
							<input type="text" name="nama_kota" class="form-control form-control-sm" placeholder="Nama kota" value="Pasuruan"/>
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
								<input type="text" name="lapor_nama" class="form-control form-control-sm" value="{{ $melaporkan_aset17->nama }}" placeholder="Nama" />
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
							<input type="text" name="lapor_nip" class="form-control form-control-sm" value="{{ $melaporkan_aset17->nip }}" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="lapor_jabatan" class="form-control form-control-sm" value="{{ $melaporkan_aset17->jabatan }}" placeholder="Jabatan" />
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
								<input type="text" name="mengetahui_nama" value="{{ $mengetahui_aset17->nama }}" class="form-control form-control-sm" placeholder="Nama" />
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
							<input type="text" name="mengetahui_nip" value="{{ $mengetahui_aset17->nip }}" class="form-control form-control-sm" placeholder="NIP" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jabatan</label>
						<div class="col-md-4">
							<input type="text" name="mengetahui_jabatan" value="{{ $mengetahui_aset17->jabatan }}" class="form-control form-control-sm" placeholder="Jabatan" />
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
		theme.activeMenu('.nav-rekap-aset');
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
        $.getJSON("{{site_url('pegawai/save_cookie?name=mengetahui_aset17&id=')}}" + $(e.currentTarget).data('id'), function (result) {
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
        $.getJSON("{{site_url('pegawai/save_cookie?name=melaporkan_aset17&id=')}}" + $(e.currentTarget).data('id'), function (result) {
            $('[name=lapor_nip]').val($(e.currentTarget).data('nip'));
            $('[name=lapor_nama]').val($(e.currentTarget).data('nama'));
            $('[name=lapor_jabatan]').val($(e.currentTarget).data('jabatan'));
            $("#modal-melaporkan").modal('hide');
        });
    }
</script>
@end