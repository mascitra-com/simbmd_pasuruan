@layout('commons/index')
@section('title')Penghapusan Aset- Rincian@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{$ref?site_url('persetujuan/penghapusan'):site_url('penghapusan/index/index?id_organisasi='.$hapus->id_organisasi->id)}}">Penghapusan Aset</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end4

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="{{site_url('penghapusan/index/detail/'.$hapus->id)}}" class="btn btn-primary">01. Penghapusan Aset</a>
        <a href="#" class="btn btn-primary active">02. Rincian Aset</a>
    </div>
    @if(!$ref)
    <div class="btn-group mb-3 ml-auto">
        @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
        <a href="{{ site_url('penghapusan/index/finish_transaction/'.$hapus->id) }}" class="btn btn-success" onclick="return confirm('Anda Yakin? Data tidak dapat di sunting jika telah diajukan.')">
            <i class="fa fa-check mr-2"></i> Selesaikan Transaksi
        </a>
        @elseif($hapus->status_pengajuan === '1')
        <a href="{{ site_url('penghapusan/index/cancel_transaction/'.$hapus->id) }}" class="btn btn-warning" onclick="return confirm('Anda Yakin? Data tidak dapat di sunting jika telah diajukan.')">
            <i class="fa fa-check mr-2"></i> Batalkan Transaksi
        </a>
        @endif
        @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
        @endif
        <button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
    </div>
    @endif
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header form-inline">
                <span class="mr-auto">Detail Kontrak</span>
            </div>
            <div class="card-body row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-4">UPB</div>
                        <div class="col"> : {{ $hapus->id_organisasi->nama }}</div>
                        <div class="w-100"></div>
                        <div class="col-4">No. Jurnal</div>
                        <div class="col"> : {{ zerofy($hapus->id, 5) }}</div>
                        <div class="w-100"></div>
                        <div class="col-4">SK. Penghapusan</div>
                        <div class="col"> : {{ $hapus->no_sk }}</div>
                        <div class="w-100"></div>
                        <div class="col-4">Total Rincian</div>
                        <div class="col"> : {{monefy($kiba['sum']+$kibb['sum']+$kibc['sum']+$kibd['sum']+$kibe['sum']+$kibg['sum'])}}</div>
                        <div class="w-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kiba" role="tab">
                            KIB-A {{!empty($kiba['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibb" role="tab">
                            KIB-B {{!empty($kibb['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibc" role="tab">
                            KIB-C {{!empty($kibc['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibd" role="tab">
                            KIB-D {{!empty($kibd['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibe" role="tab">
                            KIB-E {{!empty($kibe['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibg" role="tab">
                            KIB-G {{!empty($kibg['count']) ? '<i class="fa fa-asterisk text-danger ml-2"></i>' : ''}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body tab-content">
                <!-- KIB-A -->
                <div class="tab-pane active" id="kiba" role="tabpanel">
                    <div id="toolbar-a">
                        <div class="input-group">
                            <span class="input-group-addon">Total</span>
                            <input type="text" class="form-control" value="{{!empty($kiba['count'])?$kiba['count']:'kosong'}}" readonly="">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" value="{{!empty($kiba['count'])?monefy($kiba['sum']):'kosong'}}" readonly="">
                        </div>
                    </div>
                    <table class="jq-table table-striped" id="tb-kiba" data-toggle="#tb-kiba" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-a" data-pagination="true" data-side-pagination="server" data-url="{{site_url('penghapusan/api/get_kiba/'.$hapus->id)}}">
                        <thead>
                            <tr>
                                <th data-field="no" data-switchable="false">No.</th>
                                @if(!$ref)
                                <th data-field="aksi" data-switchable="false">Aksi</th>
                                @endif
                                <th data-field="kode_barang" data-switchable="false">Kode Barang</th>
                                <th data-field="id_kategori" data-switchable="false" class="text-nowrap">Kategori</th>
                                <th data-field="nilai" data-switchable="false">Nilai</th>
                                <th data-field="luas">Luas (m2)</th>
                                <th data-field="alamat">Alamat</th>
                                <th data-field="sertifikat_tgl">Tgl. Sertifikat</th>
                                <th data-field="sertifikat_no">No. Sertifikat</th>
                                <th data-field="hak">Hak Pakai</th>
                                <th data-field="pengguna">Pengguna</th>
                                <th data-field="tgl_perolehan">Tgl. Perolehan</th>
                                <th data-field="tgl_pembukuan">Tgl. Pembukuan</th>
                                <th data-field="asal_usul">Asal Usul</th>
                                <th data-field="keterangan">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- KIB-B -->
                <div class="tab-pane" id="kibb" role="tabpanel">
                    <div id="toolbar-b">
                        <div class="input-group">
                            <span class="input-group-addon">Total</span>
                            <input type="text" class="form-control" value="{{!empty($kibb['count'])?$kibb['count']:'kosong'}}" readonly="">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" value="{{!empty($kibb['count'])?monefy($kibb['sum']):'kosong'}}" readonly="">
                        </div>
                    </div>
                    <table class="jq-table table-striped" id="tb-kibb" data-toggle="#tb-kibb" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-b" data-pagination="true" data-side-pagination="server" data-url="{{site_url('penghapusan/api/get_kibb/'.$hapus->id)}}">
                        <thead>
                            <tr>
                                <th data-field="no" data-switchable="false">No.</th>
                                @if(!$ref)
                                <th data-field="aksi" data-switchable="false">Aksi</th>
                                @endif
                                <th data-field="kode_barang" data-switchable="false">Kode Barang</th>
                                <th data-field="id_kategori" data-switchable="false" class="text-nowrap">Kategori</th>
                                <th data-field="nilai" data-switchable="false">Nilai</th>
                                <th data-field="merk">Merk</th>
                                <th data-field="tipe">Tipe</th>
                                <th data-field="ukuran">Ukuran/CC</th>
                                <th data-field="bahan">Bahan</th>
                                <th data-field="no_pabrik">No.Pabrik</th>
                                <th data-field="no_rangka">No.Rangka</th>
                                <th data-field="no_mesin">No.Mesin</th>
                                <th data-field="no_polisi">No.Polisi</th>
                                <th data-field="no_bpkb">No.BPKB</th>
                                <th data-field="tgl_perolehan">Tgl. Perolehan</th>
                                <th data-field="tgl_pembukuan">Tgl. Pembukuan</th>
                                <th data-field="asal_usul">Asal Usul</th>
                                <th data-field="kondisi">Kondisi</th>
                                <th data-field="keterangan">Keterangan</th>
                                <th data-field="id_ruangan">Ruang</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- KIB-C -->
                <div class="tab-pane" id="kibc" role="tabpanel">
                    <div id="toolbar-c">
                        <div class="input-group">
                            <span class="input-group-addon">Total</span>
                            <input type="text" class="form-control" value="{{!empty($kibc['count'])?$kibc['count']:'kosong'}}" readonly="">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" value="{{!empty($kibc['count'])?monefy($kibc['sum']):'kosong'}}" readonly="">
                        </div>
                    </div>
                    <table class="jq-table table-striped" id="tb-kibc" data-toggle="#tb-kibc" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-c" data-pagination="true" data-side-pagination="server" data-url="{{site_url('penghapusan/api/get_kibc/'.$hapus->id)}}">
                        <thead>
                            <tr>
                                <th data-field="no" data-switchable="false">No.</th>
                                @if(!$ref)
                                <th data-field="aksi" data-switchable="false">Aksi</th>
                                @endif
                                <th data-field="kode_barang" data-switchable="false">Kode Barang</th>
                                <th data-field="id_kategori" data-switchable="false" class="text-nowrap">Kategori</th>
                                <th data-field="nilai" data-switchable="false">Nilai</th>
                                <th data-field="tingkat">Tingkat</th>
                                <th data-field="beton">Beton</th>
                                <th data-field="luas_lantai">Luas Lantai</th>
                                <th data-field="lokasi">Lokasi</th>
                                <th data-field="dokumen_tgl">Tgl.Dokumen</th>
                                <th data-field="dokumen_no">No.Dokumen</th>
                                <th data-field="status_tanah">Status Tanah</th>
                                <th data-field="kode_tanah">Kode Tanah</th>
                                <th data-field="tgl_perolehan">Tgl. Perolehan</th>
                                <th data-field="tgl_pembukuan">Tgl. Pembukuan</th>
                                <th data-field="asal_usul">Asal Usul</th>
                                <th data-field="kondisi">Kondisi</th>
                                <th data-field="keterangan">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- KIB-D -->
                <div class="tab-pane" id="kibd" role="tabpanel">
                    <div id="toolbar-d">
                        <div class="input-group">
                            <span class="input-group-addon">Total</span>
                            <input type="text" class="form-control" value="{{!empty($kibd['count'])?$kibd['count']:'kosong'}}" readonly="">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" value="{{!empty($kibd['count'])?monefy($kibd['sum']):'kosong'}}" readonly="">
                        </div>
                    </div>
                    <table class="jq-table table-striped" id="tb-kibd" data-toggle="#tb-kibd" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-d" data-pagination="true" data-side-pagination="server" data-url="{{site_url('penghapusan/api/get_kibd/'.$hapus->id)}}">
                        <thead>
                            <tr>
                                <th data-field="no" data-switchable="false">No.</th>
                                @if(!$ref)
                                <th data-field="aksi" data-switchable="false">Aksi</th>
                                @endif
                                <th data-field="kode_barang" data-switchable="false">Kode Barang</th>
                                <th data-field="id_kategori" data-switchable="false" class="text-nowrap">Kategori</th>
                                <th data-field="nilai" data-switchable="false">Nilai</th>
                                <th data-field="kontruksi">Kontruksi</th>
                                <th data-field="panjang">Panjang</th>
                                <th data-field="lebar">Lebar</th>
                                <th data-field="luas">Luas</th>
                                <th data-field="lokasi">Lokasi</th>
                                <th data-field="dokumen_tgl">Tgl.Dokumen</th>
                                <th data-field="dokumen_no">No.Dokumen</th>
                                <th data-field="status_tanah">Status Tanah</th>
                                <th data-field="kode_barang">Kode Tanah</th>
                                <th data-field="tgl_perolehan">Tgl. Perolehan</th>
                                <th data-field="tgl_pembukuan">Tgl. Pembukuan</th>
                                <th data-field="asal_usul">Asal Usul</th>
                                <th data-field="kondisi">Kondisi</th>
                                <th data-field="keterangan">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- KIB-E -->
                <div class="tab-pane" id="kibe" role="tabpanel">
                    <div id="toolbar-e">
                        <div class="input-group">
                            <span class="input-group-addon">Total</span>
                            <input type="text" class="form-control" value="{{!empty($kibe['count'])?$kibe['count']:'kosong'}}" readonly="">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" value="{{!empty($kibe['count'])?monefy($kibe['sum']):'kosong'}}" readonly="">
                        </div>
                    </div>
                    <table class="jq-table table-striped" id="tb-kibe" data-toggle="#tb-kibe" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-e" data-pagination="true" data-side-pagination="server" data-url="{{site_url('penghapusan/api/get_kibe/'.$hapus->id)}}">
                        <thead>
                            <tr>
                                <th data-field="no" data-switchable="false" class="text-center">No.</th>
                                <th data-field="aksi" data-switchable="false" class="text-nowrap text-center">Aksi</th>
                                <th data-field="kode_barang" data-switchable="false" class="text-nowrap text-center">Kode Barang</th>
                                <th data-field="id_kategori" data-switchable="false" class="text-nowrap">Kategori</th>
                                <th data-field="nilai" data-switchable="false" class="text-nowrap text-right">Nilai</th>
                                <th data-field="judul" class="text-nowrap">Judul</th>
                                <th data-field="pencipta" class="text-nowrap">Pecipta</th>
                                <th data-field="bahan" class="text-nowrap">Bahan</th>
                                <th data-field="ukuran" class="text-nowrap">Ukuran</th>
                                <th data-field="tgl_perolehan" class="text-nowrap">Tgl. Perolehan</th>
                                <th data-field="tgl_pembukuan" class="text-nowrap">Tgl. Pembukuan</th>
                                <th data-field="asal_usul" class="text-nowrap">Asal Usul</th>
                                <th data-field="Kondisi" class="text-nowrap">Kondisi</th>
                                <th data-field="keterangan" class="text-nowrap">Keterangan</th>
                                <th data-field="id_ruang" class="text-nowrap">Ruang</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- KIB-G -->
                <div class="tab-pane" id="kibg" role="tabpanel">
                    <div id="toolbar-g">
                        <div class="input-group">
                            <span class="input-group-addon">Total</span>
                            <input type="text" class="form-control" value="{{!empty($kibg['count'])?$kibg['count']:'kosong'}}" readonly="">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" value="{{!empty($kibg['count'])?monefy($kibg['sum']):'kosong'}}" readonly="">
                        </div>
                    </div>
                    <table class="jq-table table-striped" id="tb-kibg" data-toggle="#tb-kibg" data-search="true" data-show-columns="true" data-search-on-enter-key="true" data-toolbar="#toolbar-g" data-pagination="true" data-side-pagination="server" data-url="{{site_url('penghapusan/api/get_kibg/'.$hapus->id)}}">
                        <thead>
                            <tr>
                                <th data-field="no" data-switchable="false" class="text-center">No.</th>
                                @if(!$ref)
                                <th data-field="aksi" data-switchable="false" class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th data-field="kode_barang" data-switchable="false" class="text-nowrap text-center">Kode Barang</th>
                                <th data-field="id_kategori" data-switchable="false" class="text-nowrap">Kategori</th>
                                <th data-field="nilai" data-switchable="false" class="text-nowrap text-right">Nilai</th>
                                <th data-field="merk" class="text-nowrap">Merk</th>
                                <th data-field="tipe" class="text-nowrap">Tipe</th>
                                <th data-field="ukuran" class="text-nowrap">Ukuran</th>
                                <th data-field="tgl_perolehan" class="text-nowrap">Tgl. Perolehan</th>
                                <th data-field="tgl_pembukuan" class="text-nowrap">Tgl. Pembukuan</th>
                                <th data-field="asal_usul" class="text-nowrap">Asal Usul</th>
                                <th data-field="kondisi" class="text-nowrap">Kondisi</th>
                                <th data-field="keterangan" class="text-nowrap">Keterangan</th>
                                <th data-field="id_ruangan" class="text-nowrap">Ruang</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@end

@section('modal')
@if(!$ref)
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Aset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ site_url('penghapusan/index/rincian_redirect/'.$hapus->id) }}" method="POST">
                    <div class="modal-title"><b>Aset Tetap</b></div>
                    <ul style="list-style: none;">
                        <li><input type="radio" name="jenis" value="a"> A - Tanah</li>
                        <li><input type="radio" name="jenis" value="b"> B - Peralatan Dan Mesin</li>
                        <li><input type="radio" name="jenis" value="c"> C - Gedung Dan Bangunan</li>
                        <li><input type="radio" name="jenis" value="d"> D - Jalan, Irigasi &amp Jaringan</li>
                        <li><input type="radio" name="jenis" value="e"> E - Buku, Barang &amp Kebudayaan</li>
                        <li><input type="radio" name="jenis" value="g"> G - Aset Lainnya</li>
                    </ul>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Pilih</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@end

@section('style')
<style>
th, td {
    font-size: smaller !important;
}
</style>
<link rel="stylesheet" href="{{base_url('res/plugins/bttable/bttable.css')}}">
@end

@section('script')
<script src="{{base_url('res/plugins/bttable/bttable.js')}}"></script>
<script>
    theme.activeMenu('.nav-penghapusan');
    // FIX TAB ERROR
    $(".nav-link").on('click', function(e){
        var dom = $(e.currentTarget).attr('href');
        $(".tab-pane:not("+dom+")").removeClass('active');
    });

    // INIT Datatables
    $(".jq-table").bootstrapTable({
        formatRecordsPerPage: function () {
            return ''
        },
        formatShowingRows: function () {
            return ''
        }
    });

    function indexing(value, row, index)
    {
        return index + 1;
    }
</script>
@end