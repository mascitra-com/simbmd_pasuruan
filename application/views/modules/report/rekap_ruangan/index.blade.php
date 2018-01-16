@layout('commons/index')
@section('title')Rekapitulasi Kartu Inventaris Ruangan@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
    <li class="breadcrumb-item active">Rekapitulasi Kartu Inventaris Ruangan</li>
    @end

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Rekapitulasi Kartu Inventaris Ruangan</div>
                <div class="card-body">
                    <form action="{{site_url('report/rekap_ruangan/cetak')}}" method="POST">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Pilih UPB</label>
                            <div class="col-md-4">
                                <select name="id_organisasi" id="organisasi" class="select-chosen form-control" data-placeholder="Pilih UPB...">
                                    <option></option>
                                    @foreach($organisasi AS $org)
                                        <option value="{{$org->id}}" class="text-small">{{$org->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Pilih Ruangan</label>
                            <div class="col-md-4">
                                <select name="id_ruangan" id="ruangan" class="form-control"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Header</label>
                            <div class="col-md-4">
                                <input type="text" name="header" class="form-control form-control-sm"
                                       value="TAHUN {{date('Y')}}" placeholder="Header laporan"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Laporan</label>
                            <div class="col-md-4">
                                <input type="date" name="tanggal" class="form-control form-control-sm"
                                       value="{{date('Y-m-d')}}" placeholder="Tanggal Laporan"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nama Kota</label>
                            <div class="col-md-4">
                                <input type="text" name="nama_kota" class="form-control form-control-sm"
                                       value="Pasuruan" placeholder="Nama kota"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Penanggung Jawab</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nama</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="penanggung_nama" class="form-control form-control-sm"
                                           value="{{ $mengetahui_ruangan->nama }}" placeholder="Nama"/>
                                    <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-tambah">Pilih</button>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="penanggung_nip" class="form-control form-control-sm"
                                       value="{{ $mengetahui_ruangan->nip }}" placeholder="NIP"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="penanggung_jabatan" class="form-control form-control-sm"
                                       value="{{ $mengetahui_ruangan->jabatan }}" placeholder="Jabatan"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</button>
                                <button type="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> Bersihkan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @end

@section('modal')
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
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
                            <table class="table table-bordered table-sm" id="tbl-pegawai">
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
                                                   id="ip-search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" id="tb-search"><i
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
        var org = (function () {
            theme.activeMenu('.nav-rekap-ruangan');
        })();
        $("#tb-search").on("click", fungsiTombolCari);
        $("#ip-search").on("keyup", fungsiEnterCari);
        $("#organisasi").on("change", fungsiUpb);
        $("#tbl-pegawai").delegate("[data-nip]", "click", fungsiTombolPegawai);

        function fungsiUpb(e) {
            var id = $("#organisasi option:selected").val();
            $.getJSON("{{site_url('ruangan/get_by?')}}"+"id_org="+id, function(result){
                $("#ruangan").empty().append("<option value=''>Pilih Ruangan...</option>");
                $.each(result, function(key, value){
                    $("#ruangan").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
                });
            });
        }

        function fungsiEnterCari(e) {
            var enterKey = 13;
            if (e.which === enterKey) {
                fungsiTombolCari();
            }
        }

        function fungsiTombolCari(e) {
            var key = $("#ip-search").val();
            $.getJSON("{{site_url('pegawai/get_data_search?key=')}}" + key, function (result) {
                $("#tbl-pegawai > tbody").empty();
                $("#tbl-pegawai > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan " + result.length + " data teratas</b></td></tr>");
                $.each(result, function (key, value) {
                    var html = "<tr>";
                    html += "<td>" + value.nip + "</td>";
                    html += "<td>" + value.nama + "</td>";
                    html += "<td>" + value.jabatan + "</td>";
                    html += "<td><button class='btn btn-secondary btn-sm btn-block' data-id='" + value.id + "' data-nip='" + value.nip + "' data-nama='" + value.nama + "' data-jabatan='" + value.jabatan + "'>Pilih</button></td>";
                    html += "</tr>";

                    $("#tbl-pegawai > tbody").append(html);
                });
            });
        }

        function fungsiTombolPegawai(e) {
            $.getJSON("{{site_url('pegawai/save_cookie?name=mengetahui_ruangan&id=')}}" + $(e.currentTarget).data('id'), function (result) {
                $('[name=penanggung_nip]').val($(e.currentTarget).data('nip'));
                $('[name=penanggung_nama]').val($(e.currentTarget).data('nama'));
                $('[name=penanggung_jabatan]').val($(e.currentTarget).data('jabatan'));
                $("#modal-tambah").modal('hide');
            });
        }
    </script>
    @end