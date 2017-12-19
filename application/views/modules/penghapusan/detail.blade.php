@layout('commons/index')
@section('title')Penghapusan Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('penghapusan?id_organisasi='.$hapus->id_organisasi->id)}}">Penghapusan Aset</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="#" class="btn btn-primary active">01. Detail Penghapusan Aset</a>
        <a href="{{ site_url('penghapusan/rincian/'.$hapus->id) }}" class="btn btn-primary">02. Rincian Aset</a>
    </div>
    <div class="btn-group mb-3 ml-auto">
        @if($hapus->status_pengajuan === '0')
        <a href="{{ site_url('penghapusan/finish_transaction/'.$hapus->id) }}" class="btn btn-success" onclick="return confirm('Anda Yakin? Data tidak dapat di sunting jika telah diajukan.')">
            <i class="fa fa-check mr-2"></i>
            Selesaikan Transaksi
        </a>
        @elseif($hapus->status_pengajuan === '1')
        <a href="{{ site_url('penghapusan/cancel_transaction/'.$hapus->id) }}" class="btn btn-warning" onclick="return confirm('Anda Yakin? Data tidak dapat di sunting jika telah diajukan.')">
            <i class="fa fa-check mr-2"></i>
            Batalkan Transaksi
        </a>
        @endif
    </div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Transfer Keluar</div>
			<div class="card-body">
				<form action="{{site_url('penghapusan/update')}}"
                          method="POST">
                    <input type="hidden" name="id" value="{{isset($hapus)?$hapus->id:''}}">
                    <input type="hidden" name="id_organisasi" value="{{$hapus->id_organisasi->id}}">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">UPB</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" value="{{$hapus->id_organisasi->nama}}" disabled/>
                        </div>
                    </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>Jurnal Penghapusan</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor Jurnal</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" value="{{ $hapus->no_jurnal }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Jurnal</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control form-control-sm" value="{{ datify($hapus->tgl_jurnal, 'Y-m-d')}}"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <h5>SK Penghapusan</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">SK Penghapusan</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" value="{{ $hapus->no_sk }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tgl Penghapusan</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control form-control-sm" value="{{datify($hapus->tgl_sk, 'Y-m-d')}}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Keterangan</label>
                            <div class="col-md-4">
                                <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" rows="3">{{ $hapus->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Alasan</label>
                            <div class="col-md-4">
                                <textarea name="alasan" id="alasan" class="form-control form-control-sm" rows="3">{{ $hapus->alasan }}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                @endif
                                <button type="reset" class="btn btn-secondary">Bersihkan</button>
                                <a href="{{site_url('penghapusan?id_organisasi='.$hapus->id_organisasi->id)}}" class="btn btn-warning">Kembali</a>
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
	theme.activeMenu('.nav-penghapusan')
</script>
@end