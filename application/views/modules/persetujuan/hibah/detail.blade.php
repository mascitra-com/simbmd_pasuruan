@layout('commons/index')
@section('title')Persetujuan Hibah@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('persetujuan_hibah?id_organisasi='.$hibah->id_organisasi->id)}}">Persetujuan Hibah</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
    <div class="form-inline">
        <div class="btn-group mb-3">
            <a href="#" class="btn btn-primary active">01. Detail Hibah</a>
            <a href="{{site_url('persetujuan/hibah/rincian/'.$hibah->id)}}" class="btn btn-primary">02. Rincian Aset</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">Detail Hibah</div>
                <div class="card-body">
                    <form action="{{ site_url('hibah/update_hibah') }}" method="POST">
                        <input type="hidden" name="id" value="{{ $hibah->id }}">
                        <div class="row">
                            <div class="col">
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>No. Jurnal</label>
                                        <input type="number" class="form-control form-control-sm" value="{{ zerofy($hibah->id, 5) }}" name="no_jurnal" placeholder="Nomor Jurnal" disabled/>
                                    </div>
                                    <div class="form-group col">
                                        <label>Tgl. Jurnal</label>
                                        <input type="date" class="form-control form-control-sm" value="{{ datify($hibah->tgl_jurnal, 'Y-m-d') }}" name="tgl_jurnal" placeholder="Tanggal Jurnal" disabled/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Asal Penerimaan</label>
                                    <select name="asal_penerimaan" id="asal_penerimaan" class="form-control" disabled>
                                        <option value="">Pilih Salah Satu</option>
                                        <option value="0" {{ $hibah->asal_penerimaan == 0 ? 'selected' : ''}}>Pusat</option>
                                        <option value="1" {{ $hibah->asal_penerimaan == 1 ? 'selected' : ''}}>Provinsi</option>
                                        <option value="2" {{ $hibah->asal_penerimaan == 2 ? 'selected' : ''}}>Pemerintah Daerah</option>
                                        <option value="2" {{ $hibah->asal_penerimaan == 3 ? 'selected' : ''}}>Pemerintah Daerah Lainnya</option>
                                        <option value="3" {{ $hibah->asal_penerimaan == 4 ? 'selected' : ''}}>Penerimaan Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>No. BA Serah Terima</label>
                                <input type="number" class="form-control form-control-sm" value="{{ $hibah->no_serah_terima }}" name="no_serah_terima" placeholder="No. BA Serah Terima" disabled/>
                            </div>
                            <div class="form-group col">
                                <label>Tanggal BA Serah Terima</label>
                                <input type="date" class="form-control form-control-sm" value="{{ datify($hibah->tgl_serah_terima, 'Y-m-d') }}" name="tgl_serah_terima" placeholder="Tanggal BA Serah Terima" disabled/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>Keterangan</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $hibah->keterangan }}" name="keterangan" placeholder="Keterangan" disabled/>
                            </div>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
    </div>
@end

@section('script')
<script>
    theme.activeMenu('.nav-persetujuan-hibah');
</script>
@end