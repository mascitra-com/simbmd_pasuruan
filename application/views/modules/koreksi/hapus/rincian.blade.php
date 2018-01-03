@layout('commons/index')
@section('title')Koreksi Hapus@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="#">Koreksi</a></li>
<li class="breadcrumb-item"><a href="#">Koreksi Hapus</a></li>
<li class="breadcrumb-item active">Rincian</li>
@endsection

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3 ml-auto">
        <button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
        <a href="{{site_url()}}" class="btn btn-success" onclick="return confirm('Anda yakin? Data tidak dapat disunting jika telah diajukan.')"><i class="fa fa-check mr-2"></i>Selesaikan Transaksi</a>
        <!-- <a href="{{site_url()}}" class="btn btn-warning" onclick="return confirm('Anda yakin?')"><i class="fa fa-check mr-2"></i>Batalkan Pengajuan</a> -->
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header form-inline">
                <span class="mr-auto">Detail Kontrak</span>
            </div>
            <div class="card-body">
                
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
                        <a class="nav-link active" data-toggle="tab" href="#kiba" role="tab">KIB-A</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibb" role="tab">KIB-B</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibc" role="tab">KIB-C</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibd" role="tab">KIB-D</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibe" role="tab">KIB-E</a>
                    </li>
                </ul>
            </div>
            <div class="card-body tab-content table-scroll px-0 py-0">

                <!-- KIB-A -->
                <div class="tab-pane active" id="kiba" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Aksi</th>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Luas (m2)</th>
                                <th class="text-nowrap">Alamat</th>
                                <th class="text-nowrap">Tgl. Sertifikat</th>
                                <th class="text-nowrap">No. Sertifikat</th>
                                <th class="text-nowrap">Hak Pakai</th>
                                <th class="text-nowrap">Pengguna</th>
                                <th class="text-nowrap">Tgl. Perolehan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="14" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- KIB-B -->
                <div class="tab-pane" id="kibb" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Aksi</th>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Merk</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">Ukuran/CC</th>
                                <th class="text-nowrap">Bahan</th>
                                <th class="text-nowrap">No.Pabrik</th>
                                <th class="text-nowrap">No.Rangka</th>
                                <th class="text-nowrap">No.Mesin</th>
                                <th class="text-nowrap">No.Polisi</th>
                                <th class="text-nowrap">No.BPKB</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Ruang</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="21" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- KIB-C -->
                <div class="tab-pane" id="kibc" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Aksi</th>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Tingkat</th>
                                <th class="text-nowrap">Beton</th>
                                <th class="text-nowrap">Luas Lantai</th>
                                <th class="text-nowrap">Lokasi</th>
                                <th class="text-nowrap">Tgl.Dokumen</th>
                                <th class="text-nowrap">No.Dokumen</th>
                                <th class="text-nowrap">Status Tanah</th>
                                <th class="text-nowrap">Kode Tanah</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="19" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- KIB-D -->
                <div class="tab-pane" id="kibd" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Aksi</th>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Kontruksi</th>
                                <th class="text-nowrap">Panjang</th>
                                <th class="text-nowrap">Lebar</th>
                                <th class="text-nowrap">Luas</th>
                                <th class="text-nowrap">Lokasi</th>
                                <th class="text-nowrap">Tgl.Dokumen</th>
                                <th class="text-nowrap">No.Dokumen</th>
                                <th class="text-nowrap">Status Tanah</th>
                                <th class="text-nowrap">Kode Tanah</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="20" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- KIB-E -->
                <div class="tab-pane" id="kibe" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Aksi</th>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Judul</th>
                                <th class="text-nowrap">Pecipta</th>
                                <th class="text-nowrap">Bahan</th>
                                <th class="text-nowrap">Ukuran</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Ruang</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="16" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Aset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{site_url('koreksi/koreksi_hapus/rincian_redirect')}}" method="POST">
                        <input type="hidden" name="id" value="1">
                        
                        <div class="modal-title"><b>Aset Tetap</b></div>
                        <ul style="list-style: none;">
                            <li><input type="radio" name="jenis" value="a"> A - Tanah</li>
                            <li><input type="radio" name="jenis" value="b"> B - Peralatan Dan Mesin</li>
                            <li><input type="radio" name="jenis" value="c"> C - Gedung Dan Bangunan</li>
                            <li><input type="radio" name="jenis" value="d"> D - Jalan, Irigasi &amp Jaringan</li>
                            <li><input type="radio" name="jenis" value="e"> E - Buku, Barang &amp Kebudayaan</li>
                        </ul>
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Pilih</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                class="fa fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('style')
    <style>
    th, td {
        font-size: smaller !important;
    }
</style>
@endsection

@section('script')
<script>
    theme.activeMenu('.nav-transfer-keluar');
</script>
@end