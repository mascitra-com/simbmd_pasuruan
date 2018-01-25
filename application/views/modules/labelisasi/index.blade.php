@layout('commons/index')
@section('title')Rekapitulasi Kartu Inventaris Ruangan@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="#">Laporan</a></li>
    <li class="breadcrumb-item active">Labelisasi Barang</li>
    @end

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Labelisasi Barang</div>
                <div class="card-body">
                    <form action="{{site_url('label/cetak')}}" method="POST">
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

@section('script')
    <script type="text/javascript">
        var org = (function () {
            theme.activeMenu('.nav-rekap-lainnya');
        })();
        $("#organisasi").on("change", fungsiUpb);
        function fungsiUpb(e) {
            var id = $("#organisasi option:selected").val();
            $.getJSON("{{site_url('ruangan/get_by?')}}"+"id_org="+id, function(result){
                $("#ruangan").empty().append("<option value=''>Pilih Ruangan...</option>");
                $.each(result, function(key, value){
                    $("#ruangan").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
                });
            });
        }
    </script>
    @end