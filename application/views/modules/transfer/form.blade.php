@layout('commons/index')
@section('title')Transfer Keluar@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{site_url('transfer/keluar?id_organisasi='.$org->id)}}">Transfer Keluar</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
    @end

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">{{isset($transfer)?'Sunting':'Tambah'}} Aset</div>
                <div class="card-body">
                    <form action="{{site_url('transfer/insert')}}" method="POST">
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
                                        <option value="{{$item->id}}" {{isset($filter['id_organisasi']) && $item->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$item->nama}}</option>
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
                                <input type="text" name="surat_jenis" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor Surat</label>
                            <div class="col-md-4">
                                <input type="text" name="surat_no" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Surat</label>
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
                                <input type="text" name="jurnal_no" class="form-control"/>
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
                                <input type="text" name="penerima_nama" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="penerima_jabatan" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="penerima_nip" class="form-control"/>
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
                                <input type="text" name="penyerah_nama" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="penyerah_jabatan" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="penyerah_nip" class="form-control"/>
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
                                <input type="text" name="atasan_nama" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Jabatan</label>
                            <div class="col-md-4">
                                <input type="text" name="atasan_jabatan" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">NIP</label>
                            <div class="col-md-4">
                                <input type="text" name="atasan_nip" class="form-control"/>
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
                                <a href="{{site_url('transfer/keluar?id_organisasi='.$org->id)}}" class="btn btn-warning">Kembali</a>
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
    </script>
    @end