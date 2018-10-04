@layout('commons/index')
@section('title')Penghapusan Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{$ref?site_url('persetujuan/penghapusan'):site_url('penghapusan/index/index?id_organisasi='.$hapus->id_organisasi->id)}}">Penghapusan Aset</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="" class="btn btn-primary active">01. Detail Penghapusan Aset</a>
        <a href="{{ site_url('penghapusan/index/rincian/'.$hapus->id)}}{{$ref?'?ref=true':''}}" class="btn btn-primary">02. Rincian Aset</a>
    </div>
    @if(!$ref)
    <div class="btn-group mb-3 ml-auto">
        @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
        <a href="{{ site_url('penghapusan/index/finish_transaction/'.$hapus->id) }}" class="btn btn-success" onclick="return confirm('Anda Yakin? Data tidak dapat di sunting jika telah diajukan.')">
            <i class="fa fa-check mr-2"></i>
            Selesaikan Transaksi
        </a>
        @elseif($hapus->status_pengajuan === '1')
        <a href="{{ site_url('penghapusan/index/cancel_transaction/'.$hapus->id) }}" class="btn btn-warning" onclick="return confirm('Anda Yakin? Data tidak dapat di sunting jika telah diajukan.')">
            <i class="fa fa-check mr-2"></i>
            Batalkan Transaksi
        </a>
        @endif
    </div>
    @endif
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Penghapusan</div>
			<div class="card-body">
				<form action="{{site_url('penghapusan/index/update')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$hapus->id}}">
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
                            <input type="text" class="form-control form-control-sm" value="{{ zerofy($hapus->id, 5) }}" readonly/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Tanggal Jurnal</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control form-control-sm" name="tgl_jurnal" value="{{ datify($hapus->tgl_jurnal, 'Y-m-d')}}"/>
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
                            <input type="text" class="form-control form-control-sm" name="no_sk" value="{{ $hapus->no_sk }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right">Tgl Penghapusan</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control form-control-sm" name="tgl_sk" value="{{datify($hapus->tgl_sk, 'Y-m-d')}}"/>
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
                            <select name="alasan" id="alasan" class="form-control form-control-sm">
                                <option value="Dijual" {{$hapus->alasan == 'dijual'?'selected':''}}>Dijual</option>
                                <option value="Dihibahkan" {{$hapus->alasan == 'dihibahkan'?'selected':''}}>Dihibahkan</option>
                                @if($this->config->item('mode')==='jember')
                                <option value="penyertaan modal" {{$hapus->alasan == 'penyertaan modal'?'selected':''}}>Penyertaan Modal</option>
                                <option value="tukar-menukar" {{$hapus->alasan == 'tukar-menukar'?'selected':''}}>Tukar-menukar</option>
                                @else
                                <option value="Dimusnahkan" {{$hapus->alasan == 'dimusnahkan'?'selected':''}}>Dimusnahkan</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col">
                            <label for="">Dokumen Penunjang</label><br>
                            @if(!empty($hapus->dokumen))
                            <a href="{{site_url('res/docs/temp/'.$hapus->dokumen)}}" class="btn btn-sm btn-success"><i class="fa fa-file-o mr-2"></i> unduh</a>
                            @endif
                            <input type="file" name="berkas">
                            <p class="form-text text-small text-muted">Maksimal ukuran berkas adalah 1MB. Format yang diperbolehkan adalah PDF, DOC, DOCX, XLS, dan XLSX.</p>
                        </div>
                    </div>
                    @if(!$ref)
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right"></label>
                        <div class="col-md-4">
                            @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            @endif
                            <button type="reset" class="btn btn-secondary">Bersihkan</button>
                            <a href="{{site_url('penghapusan/index/index?id_organisasi='.$hapus->id_organisasi->id)}}" class="btn btn-warning">Kembali</a>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@end

@section('script')
<script>
	theme.activeMenu('.nav-penghapusan');
    @if($hapus->status_pengajuan === '1' OR $hapus->status_pengajuan === '2' OR $ref)
    $(':input').prop('disabled', true);
    @endif
</script>
@end