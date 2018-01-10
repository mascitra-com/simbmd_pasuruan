@layout('commons/index')
@section('title')Transfer Masuk@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('transfer/index/masuk?id_tujuan='.$transfer->id_tujuan->id)}}">Transfer Masuk</a></li>
<li class="breadcrumb-item active">Detail</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="#" class="btn btn-primary active">01. Detail Transfer Masuk</a>
        <a href="{{site_url('transfer/index/masuk_rincian/'.$transfer->id)}}" class="btn btn-primary">02. Rincian Aset</a>
    </div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Transfer Keluar</div>
			<div class="card-body">
				<form action="#" method="POST">
                    <input type="hidden" name="id" value="{{$transfer->id}}">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Asal</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="{{$transfer->id_organisasi->nama}}" disabled/>
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
                            <input type="text" name="surat_jenis" value="{{$transfer->surat_jenis}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Nomor Surat</label>
                        <div class="col-md-4">
                            <input type="text" name="surat_no" value="{{$transfer->surat_no}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Tanggal Surat</label>
                        <div class="col-md-4">
                            <input type="date" name="surat_tgl" value="{{datify($transfer->surat_tgl, 'Y-m-d')}}" class="form-control"/>
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
                            <input type="text" name="jurnal_no" value="{{$transfer->jurnal_no}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Tanggal Jurnal</label>
                        <div class="col-md-4">
                            <input type="date" name="jurnal_tgl" value="{{datify($transfer->jurnal_tgl,'Y-m-d')}}" class="form-control"/>
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
                            <input type="text" name="serah_terima_no" value="{{$transfer->serah_terima_no}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Tanggal Serah Terima</label>
                        <div class="col-md-4">
                            <input type="text" name="serah_terima_tgl" value="{{datify($transfer->serah_terima_tgl, 'Y-m-d')}}" class="form-control"/>
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
                            <input type="text" name="penerima_nama" value="{{$transfer->penerima_nama}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Jabatan</label>
                        <div class="col-md-4">
                            <input type="text" name="penerima_jabatan" value="{{$transfer->penerima_jabatan}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">NIP</label>
                        <div class="col-md-4">
                            <input type="text" name="penerima_nip" value="{{$transfer->penerima_nip}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Pangkat Golongan</label>
                        <div class="col-md-4">
                            <input type="text" name="penerima_golongan" value="{{$transfer->penerima_golongan}}" class="form-control"/>
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
                            <input type="text" name="penyerah_nama" value="{{$transfer->penyerah_nama}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Jabatan</label>
                        <div class="col-md-4">
                            <input type="text" name="penyerah_jabatan" value="{{$transfer->penyerah_jabatan}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">NIP</label>
                        <div class="col-md-4">
                            <input type="text" name="penyerah_nip" value="{{$transfer->penyerah_nip}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Pangkat Golongan</label>
                        <div class="col-md-4">
                            <input type="text" name="penyerah_golongan" value="{{$transfer->penyerah_golongan}}" class="form-control"/>
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
                            <input type="text" name="atasan_nama" value="{{$transfer->atasan_nama}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Jabatan</label>
                        <div class="col-md-4">
                            <input type="text" name="atasan_jabatan" value="{{$transfer->atasan_jabatan}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">NIP</label>
                        <div class="col-md-4">
                            <input type="text" name="atasan_nip" value="{{$transfer->atasan_nip}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Pangkat Golongan</label>
                        <div class="col-md-4">
                            <input type="text" name="atasan_golongan" value="{{$transfer->atasan_golongan}}" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right"></label>
                        <div class="col-md-4">
                            <a href="{{site_url('pengadaan/keluar?id_organisasi='.$transfer->id_organisasi->id)}}" class="btn btn-warning">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@end

@section('script')
<script>
	theme.activeMenu('.nav-transfer-masuk');
    $("input,select").prop('readonly', true);
</script>
@end