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
                            <select name="id_ruangan" class="form-control"></select>
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
                            value="PASURUAN" placeholder="Nama kota"/>
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
                                <input type="text" name="penanggung_nama" value="" class="form-control form-control-sm" placeholder="Nama" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" data-target-cari='penanggung'>Pilih</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">NIP</label>
                        <div class="col-md-4">
                            <input type="text" name="penanggung_nip" value="" class="form-control form-control-sm" placeholder="NIP" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Jabatan</label>
                        <div class="col-md-4">
                            <input type="text" name="penanggung_jabatan" value="" class="form-control form-control-sm" placeholder="Jabatan" />
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

    $('.select-chosen').bootstrapTable().change(function(){
        $.getJSON("{{site_url('ruangan/get_by?id_org=')}}"+$(this).val(), function(result){
            $("[name=id_ruangan]").empty().append("<option>Pilih ruangan...</option>");

            $.each(result, function(index, value){
                $("[name=id_ruangan]").append("<option value='"+value.id+"'>"+value.nama+"</option>");
            });
        });
    });
    
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