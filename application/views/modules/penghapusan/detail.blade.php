@layout('commons/index')
@section('title')Penghapusan Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('penghapusan')}}">Penghapusan Aset</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="btn-group mb-3">
	<a href="#" class="btn btn-primary active">01. Detail Penghapusan Aset</a>
	<a href="{{ site_url('penghapusan/rincian/'.$id_organisasi) }}" class="btn btn-primary">02. Rincian Aset</a>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Transfer Keluar</div>
			<div class="card-body">
				<form action="{{isset($transfer)?site_url('aset/kiba/update'):site_url('aset/kiba/insert')}}"
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
                                <h5>Jurnal Penghapusan</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Nomor Jurnal</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="12345"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">Tanggal Jurnal</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="{{ date('m/d/Y') }}"/>
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
                                <input type="text" class="form-control" value="98766"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right">SK Penghapusan</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="{{date('m/d/Y')}}"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-right"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Bersihkan</button>
                                <a href="{{site_url('aset/kiba')}}" class="btn btn-warning">Kembali</a>
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