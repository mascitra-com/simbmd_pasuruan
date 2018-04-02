@layout('commons/index')
@section('title')Transfer Keluar@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{site_url('transfer/index/keluar?id_organisasi='.$org->id)}}">Transfer Keluar</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
    @end

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">{{isset($transfer)?'Sunting':'Tambah'}} Aset</div>
                <div class="card-body">
                    <form action="{{site_url('transfer/index/insert')}}" method="POST">
                        <input type="hidden" name="id_organisasi" value="{{$org->id}}">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Asal</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="{{$org->nama}}" disabled/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tujuan</label>
                            <div class="col-md-4">
                                <select name="id_tujuan" class="select-chosen form-control" data-placeholder="Pilih UPB...">
                                    <option></option>
                                    @foreach($organisasi AS $item)
                                        @if($item->id !== $org->id)
                                        <option value="{{$item->id}}" {{isset($filter['id_organisasi']) && $item->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$item->nama}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Dasar Pengeluaran</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jenis Surat</label>
                            <div class="col-md-4">
                                <input type="text" name="surat_jenis" value="SK Pengelola Barang" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor SK</label>
                            <div class="col-md-4">
                                <input type="text" name="surat_no" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal SK</label>
                            <div class="col-md-4">
                                <input type="date" name="surat_tgl" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Jurnal Pengeluaran</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor Jurnal</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="####" disabled="" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Jurnal</label>
                            <div class="col-md-4">
                                <input type="date" name="jurnal_tgl" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>BA Serah Terima</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor Serah Terima</label>
                            <div class="col-md-4">
                                <input type="text" name="serah_terima_no" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Serah Terima</label>
                            <div class="col-md-4">
                                <input type="date" name="serah_terima_tgl" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Yang Menerima</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nama Personil</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="penerima_nama" class="form-control" value="{{ $penerima_transfer->nama }}"/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-menerima">Pilih</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="penerima_jabatan" class="form-control" value="{{ $penerima_transfer->jabatan }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="penerima_nip" class="form-control" value="{{ $penerima_transfer->nip }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Pangkat Golongan</label>
                            <div class="col-md-4">
                                <input type="text" name="penerima_golongan" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Yang Menyerahkan</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nama Personil</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="penyerah_nama" class="form-control" value="{{ $penyerah_transfer->nama }}"/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-menyerahkan">Pilih</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="penyerah_jabatan" class="form-control" value="{{ $penyerah_transfer->jabatan }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="penyerah_nip" class="form-control" value="{{ $penyerah_transfer->nip }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Pangkat Golongan</label>
                            <div class="col-md-4">
                                <input type="text" name="penyerah_golongan" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Atasan Yang Menyerahkan</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nama Personil</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="atasan_nama" class="form-control" value="{{ $atasan_transfer->nama }}"/>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-atasan">Pilih</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="atasan_jabatan" class="form-control" value="{{ $atasan_transfer->jabatan }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="atasan_nip" class="form-control" value="{{ $atasan_transfer->nip }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Pangkat Golongan</label>
                            <div class="col-md-4">
                                <input type="text" name="atasan_golongan" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Bersihkan</button>
                                <a href="{{site_url('transfer/index/keluar?id_organisasi='.$org->id)}}" class="btn btn-warning">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-menerima">
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
                        <table class="table table-bordered table-sm" id="tbl-menerima">
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
                                               id="ip-search-menerima">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" id="tb-search-menerima"><i
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-menyerahkan">
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
                        <table class="table table-bordered table-sm" id="tbl-menyerahkan">
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
                                               id="ip-search-menyerahkan">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" id="tb-search-menyerahkan"><i
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-atasan">
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
                        <table class="table table-bordered table-sm" id="tbl-atasan">
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
                                               id="ip-search-atasan">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" id="tb-search-atasan"><i
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
        var form = (function () {
            theme.activeMenu('.nav-transfer-keluar');
            init();

            function init() {
                $('.form-control').addClass('form-control-sm').each(function () {
                    var label = $(this).closest('.form-group').find('label').text();
                    $(this).prop('placeholder', label);
                });
            }
        })();

        $("#tb-search-menerima").on("click", fungsiTombolCariMenerima);
        $("#ip-search-menerima").on("keyup", fungsiEnterCariMenerima);
        $("#tbl-menerima").delegate("[data-nip]", "click", fungsiTombolMenerima);

        $("#tb-search-menyerahkan").on("click", fungsiTombolCariMenyerahkan);
        $("#ip-search-menyerahkan").on("keyup", fungsiEnterCariMenyerahkan);
        $("#tbl-menyerahkan").delegate("[data-nip]", "click", fungsiTombolMenyerahkan);
        
        $("#tb-search-atasan").on("click", fungsiTombolCariAtasan);
        $("#ip-search-atasan").on("keyup", fungsiEnterCariAtasan);
        $("#tbl-atasan").delegate("[data-nip]", "click", fungsiTombolAtasan);

        function fungsiEnterCariMenerima(e) {
            var enterKey = 13;
            if (e.which === enterKey) {
                fungsiTombolCariMenerima();
            }
        }

        function fungsiTombolCariMenerima(e) {
            var key = $("#ip-search-menerima").val();
            $.getJSON("{{site_url('pegawai/get_data_search?key=')}}" + key, function (result) {
                $("#tbl-menerima > tbody").empty();
                $("#tbl-menerima > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan " + result.length + " data teratas</b></td></tr>");
                $.each(result, function (key, value) {
                    var html = "<tr>";
                    html += "<td>" + value.nip + "</td>";
                    html += "<td>" + value.nama + "</td>";
                    html += "<td>" + value.jabatan + "</td>";
                    html += "<td><button class='btn btn-secondary btn-sm btn-block' data-id='" + value.id + "' data-nip='" + value.nip + "' data-nama='" + value.nama + "' data-jabatan='" + value.jabatan + "'>Pilih</button></td>";
                    html += "</tr>";

                    $("#tbl-menerima > tbody").append(html);
                });
            });
        }

        function fungsiTombolMenerima(e) {
            $.getJSON("{{site_url('pegawai/save_cookie?name=penerima_transfer&id=')}}" + $(e.currentTarget).data('id'), function (result) {
                $('[name=penerima_nip]').val($(e.currentTarget).data('nip'));
                $('[name=penerima_nama]').val($(e.currentTarget).data('nama'));
                $('[name=penerima_jabatan]').val($(e.currentTarget).data('jabatan'));
                $("#modal-menerima").modal('hide');
            });
        }
        
        function fungsiEnterCariMenyerahkan(e) {
            var enterKey = 13;
            if (e.which === enterKey) {
                fungsiTombolCariMenyerahkan();
            }
        }

        function fungsiTombolCariMenyerahkan(e) {
            var key = $("#ip-search-menyerahkan").val();
            $.getJSON("{{site_url('pegawai/get_data_search?key=')}}" + key, function (result) {
                $("#tbl-menyerahkan > tbody").empty();
                $("#tbl-menyerahkan > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan " + result.length + " data teratas</b></td></tr>");
                $.each(result, function (key, value) {
                    var html = "<tr>";
                    html += "<td>" + value.nip + "</td>";
                    html += "<td>" + value.nama + "</td>";
                    html += "<td>" + value.jabatan + "</td>";
                    html += "<td><button class='btn btn-secondary btn-sm btn-block' data-id='" + value.id + "' data-nip='" + value.nip + "' data-nama='" + value.nama + "' data-jabatan='" + value.jabatan + "'>Pilih</button></td>";
                    html += "</tr>";

                    $("#tbl-menyerahkan > tbody").append(html);
                });
            });
        }

        function fungsiTombolMenyerahkan(e) {
            $.getJSON("{{site_url('pegawai/save_cookie?name=penyerah_transfer&id=')}}" + $(e.currentTarget).data('id'), function (result) {
                $('[name=penyerah_nip]').val($(e.currentTarget).data('nip'));
                $('[name=penyerah_nama]').val($(e.currentTarget).data('nama'));
                $('[name=penyerah_jabatan]').val($(e.currentTarget).data('jabatan'));
                $("#modal-menyerahkan").modal('hide');
            });
        }
        
        function fungsiEnterCariAtasan(e) {
            var enterKey = 13;
            if (e.which === enterKey) {
                fungsiTombolCariAtasan();
            }
        }

        function fungsiTombolCariAtasan(e) {
            var key = $("#ip-search-atasan").val();
            $.getJSON("{{site_url('pegawai/get_data_search?key=')}}" + key, function (result) {
                $("#tbl-atasan > tbody").empty();
                $("#tbl-atasan > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan " + result.length + " data teratas</b></td></tr>");
                $.each(result, function (key, value) {
                    var html = "<tr>";
                    html += "<td>" + value.nip + "</td>";
                    html += "<td>" + value.nama + "</td>";
                    html += "<td>" + value.jabatan + "</td>";
                    html += "<td><button class='btn btn-secondary btn-sm btn-block' data-id='" + value.id + "' data-nip='" + value.nip + "' data-nama='" + value.nama + "' data-jabatan='" + value.jabatan + "'>Pilih</button></td>";
                    html += "</tr>";

                    $("#tbl-atasan > tbody").append(html);
                });
            });
        }

        function fungsiTombolAtasan(e) {
            $.getJSON("{{site_url('pegawai/save_cookie?name=atasan_transfer&id=')}}" + $(e.currentTarget).data('id'), function (result) {
                $('[name=atasan_nip]').val($(e.currentTarget).data('nip'));
                $('[name=atasan_nama]').val($(e.currentTarget).data('nama'));
                $('[name=atasan_jabatan]').val($(e.currentTarget).data('jabatan'));
                $("#modal-atasan").modal('hide');
            });
        }
    </script>
    @end