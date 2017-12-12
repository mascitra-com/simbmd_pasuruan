@layout('commons/index')
@section('title')Penghapusan Aset@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{site_url('penghapusan')}}">Penghapusan Aset</a></li>
    <li class="breadcrumb-item active">{{isset($hapus)?'Sunting':'Tambah'}}</li>
    @end

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">{{isset($hapus)?'Sunting':'Tambah'}} Penghapusan Aset</div>
                <div class="card-body">
                    <form action="#"
                          method="POST">
                        <input type="hidden" name="id" value="{{isset($hapus)?$hapus->id:''}}">
                        <input type="hidden" name="id_organisasi" value="{{$org->id}}">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">UPB</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="{{$org->nama}}" disabled/>
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
                                <input type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Jurnal</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>BA Penghapusan</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor Penghapusan</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Penghapusan</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Keterangan</label>
                            <div class="col-md-4">
                                <textarea name="" id="" class="form-control"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <a href="{{ site_url('penghapusan/detail/172') }}" type="submit" class="btn btn-primary">Simpan</a>
                                <button type="reset" class="btn btn-secondary">Bersihkan</button>
                                <a href="{{site_url('penghapusan')}}" class="btn btn-warning">Kembali</a>
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
            theme.activeMenu('.nav-penghapusan');
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