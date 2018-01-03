@layout('commons/index')
@section('title')Persetujuan Penghapusan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('persetujuan_penghapusan')}}">Persetujuan Penghapusan</a></li>
<li class="breadcrumb-item active">Detail</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="#" class="btn btn-primary active">01. Detail Transfer Masuk</a>
        <a href="{{site_url('persetujuan_penghapusan/rincian/'.$hapus->id)}}" class="btn btn-primary">02. Rincian Aset</a>
    </div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Transfer Keluar</div>
			<div class="card-body">
				<form action="#" method="POST">
                    <input type="hidden" name="id" value="{{$hapus->id}}">

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
                            <input type="text" class="form-control form-control-sm" name="no_jurnal" value="{{ $hapus->no_jurnal }}"/>
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
                                <option value="Dijual">Dijual</option>
                                <option value="Dimusnahkan">Dimusnahkan</option>
                                <option value="Dihibahkan">Dihibahkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-right"></label>
                        <div class="col-md-4">
                            <a href="{{site_url('persetujuan_transfer')}}" class="btn btn-warning">Kembali</a>
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
	theme.activeMenu('.nav-transfer-hapus');
    $("input,select,textarea").prop('disabled', true);
</script>
@end