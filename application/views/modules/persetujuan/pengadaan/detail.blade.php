@layout('commons/index')
@section('title')Pengadaan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('persetujuan/pengadaan?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="{{site_url('persetujuan/pengadaan/detail/'.$spk->id)}}" class="btn btn-primary active">01. Detail Pengadaan</a>
        <a href="{{site_url('persetujuan/pengadaan/sp2d/'.$spk->id)}}" class="btn btn-primary">02. SP2D</a>
        <a href="{{site_url('persetujuan/pengadaan/rincian/'.$spk->id)}}" class="btn btn-primary">03. Rincian Aset</a>
    </div>
</div>
<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">Detail Kontrak</div>
            <div class="card-body row">
                <div class="col-6">
                    <div class="row">
                        <?php $nilai_kontrak = (!empty($spk->addendum_nilai) AND round($spk->addendum_nilai) != 0) ? $spk->addendum_nilai : $spk->nilai ?>
                        <div class="col">Nilai Kontrak</div><div class="col"> : {{monefy($nilai_kontrak)}}</div>
                        <div class="w-100"></div>
                        <div class="col">Total SP2D</div><div class="col"> : {{monefy($sp2d['total'])}}</div>
                        <div class="w-100"></div>
                        <div class="col">Total Rincian</div><div class="col"> : {{monefy($total_rincian)}}</div>
                        <div class="w-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header">Detail Pengadaan</div>
            <div class="card-body">
                <form action="{{site_url('persetujuan/pengadaan/update')}}" method="POST">
                    <input type="hidden" name="id" value="{{$spk->id}}">
                    <input type="hidden" name="id_organisasi" value="{{$spk->id_organisasi}}">
                    <div class="row">
                        <div class="col">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>No. Kontrak</label>
                                    <input type="text" class="form-control form-control-sm" name="nomor" value="{{$spk->nomor}}" placeholder="No. SPK/Kontrak/Perjanjian" required {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>Tgl. Kontrak</label>
                                    <input type="date" class="form-control form-control-sm" name="tanggal" value="{{datify($spk->tanggal, 'Y-m-d')}}" placeholder="Tanggal kontrak" required {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>No. BA Serah Terima</label>
                                    <input type="text" class="form-control form-control-sm" name="no_serah_terima" value="{{isset($spk->no_serah_terima) ? $spk->no_serah_terima : ''}}" placeholder="No. Berita Acara Serah Terima" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>Tgl. BA Serah Terima</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_serah_terima" value="{{isset($spk->tgl_serah_terima) ? datify($spk->tgl_serah_terima, 'Y-m-d') : ''}}" placeholder="Tanggal Berita Acara Serah Terima"  {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Jangka Waktu</label>
                                    <input type="number" class="form-control form-control-sm" name="jangka_waktu" value="{{$spk->jangka_waktu}}" placeholder="Jangka waktu" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>Nilai</label>
                                    <input type="number" class="form-control form-control-sm" name="nilai" placeholder="Nilai" value="{{ $spk->nilai }}" required {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea class="form-control form-control-sm" rows="5" name="keterangan" value="{{$spk->keterangan}}" placeholder="Keterangan" {{(!empty($sp2d['total']))?'readonly':''}}></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Nama Perusahaan</label>
                                    <input type="text" class="form-control form-control-sm" name="nama_perusahaan" value="{{$spk->nama_perusahaan}}" placeholder="Nama perusahaan" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>Bentuk</label>
                                    <input type="text" class="form-control form-control-sm" name="bentuk" value="{{$spk->bentuk}}" placeholder="Bentuk" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control form-control-sm" name="alamat" value="{{$spk->alamat}}" placeholder="Alamat" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>Pimpinan</label>
                                    <input type="text" class="form-control form-control-sm" name="pimpinan" value="{{$spk->pimpinan}}" placeholder="Pimpinan" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control form-control-sm" name="npwp" value="{{$spk->npwp}}" placeholder="NPWP" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>Bank</label>
                                    <input type="text" class="form-control form-control-sm" name="bank" value="{{$spk->bank}}" placeholder="Bank" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>Atas Nama</label>
                                    <input type="text" class="form-control form-control-sm" name="atas_nama" value="{{$spk->atas_nama}}" placeholder="Atas Nama" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                                <div class="form-group col">
                                    <label>No. Rekening</label>
                                    <input type="text" class="form-control form-control-sm" name="no_rek" value="{{$spk->no_rek}}" placeholder="No. Rekening" {{(!empty($sp2d['total']))?'readonly':''}}/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Addendum Nilai</label>
                            <input type="number" class="form-control form-control-sm" name="addendum_nilai" placeholder="Addendum Nilai" {{(!empty($sp2d['total']))?'readonly':''}}/>
                        </div>
                        <div class="form-group col">
                            <label>Kegiatan</label>
                            <select name="id_kegiatan" class="form-control form-control-sm" {{(!empty($sp2d['total']))?'disabled':''}}>
                                <option>Pilih Kegiatan....</option>
                                @foreach($kegiatan AS $data)
                                <option value="{{$data->id}}" {{$spk->id_kegiatan===$data->id?'selected':''}}>{{$data->kode.' - '.$data->nama}}</option>
                                @endforeach
                            </select>
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
    theme.activeMenu('.nav-persetujuan-pengadaan');
</script>
@end