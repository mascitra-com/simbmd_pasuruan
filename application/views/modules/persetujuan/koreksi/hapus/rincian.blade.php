@layout('commons/index')
@section('title')Persetujuan Koreksi Hapus@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('persetujuan/koreksi_hapus')}}">Persetujuan Koreksi Hapus</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3 ml-auto">
        <button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header form-inline">
                <span class="mr-auto">Detail Kontrak</span>
            </div>
            <div class="card-body">
                <form action="{{site_url('koreksi/hapus/update')}}" method="POST" class="form-row">
                    <input type="hidden" name="id" value="{{$koreksi->id}}">
                    <div class="form-group col-6">
                        <label>No. Jurnal</label>
                        <input type="text" class="form-control" value="{{zerofy($koreksi->id, 4)}}" readonly/>
                    </div>
                    <div class="form-group col-6">
                        <label>Tanggal Jurnal</label>
                        <input type="date" class="form-control" name="tgl_jurnal" value="{{datify($koreksi->tgl_jurnal, 'Y-m-d')}}" placeholder="tanggal jurnal" />
                    </div>
                    <div class="form-group col-12">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" placeholder="keterangan">{{$koreksi->keterangan}}</textarea>
                    </div>
                    <div class="form-group">
                        @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        @endif
                        <button type="button" class="btn btn-waring" data-dismiss="modal">Batal</button>
                    </div>
                </form>
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
                        <a class="nav-link active" data-toggle="tab" href="#kiba" role="tab">
                            KIB-A {{!empty($rincian['kiba']) ? '<span class="badge badge-primary">'.(count($rincian['kiba'])).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibb" role="tab">
                            KIB-B {{!empty($rincian['kibb']) ? '<span class="badge badge-primary">'.(count($rincian['kibb'])).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibc" role="tab">
                            KIB-C {{!empty($rincian['kibc']) ? '<span class="badge badge-primary">'.(count($rincian['kibc'])).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibd" role="tab">
                            KIB-D {{!empty($rincian['kibd']) ? '<span class="badge badge-primary">'.(count($rincian['kibd'])).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibe" role="tab">
                            KIB-E {{!empty($rincian['kibe']) ? '<span class="badge badge-primary">'.(count($rincian['kibe'])).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibg" role="tab">
                            KIB-G {{!empty($rincian['kibg']) ? '<span class="badge badge-primary">'.(count($rincian['kibg'])).'</span>' : ''}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body tab-content table-scroll px-0 py-0">

                <!-- KIB-A -->
                <div class="tab-pane active" id="kiba" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
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
                            @if(empty($rincian) OR empty($rincian['kiba']))
                            <tr>
                                <td colspan="16" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kiba'] AS $item)
                            <tr>
                                <td class="text-nowrap text-center">
                                    {{zerofy($item->id_kategori->kd_golongan)}} .
                                    {{zerofy($item->id_kategori->kd_bidang)}} .
                                    {{zerofy($item->id_kategori->kd_kelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subkelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subsubkelompok)}} .
                                    {{zerofy($item->reg_barang,4)}}
                                </td>
                                <td class="text-nowrap">{{$item->luas}}</td>
                                <td class="text-nowrap">{{$item->alamat}}</td>
                                <td class="text-nowrap">{{datify($item->sertifikat_tgl, 'd/m/Y')}}</td>
                                <td class="text-nowrap">{{$item->sertifikat_no}}</td>
                                <td class="text-nowrap">{{$item->hak}}</td>
                                <td class="text-nowrap">{{$item->pengguna}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd/m/Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd/m/Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap">{{$item->keterangan}}</td>
                                <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- KIB-B -->
                <div class="tab-pane" id="kibb" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
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
                                <th class="text-nowrap">Tgl. Perolehan</th>
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
                            @if(empty($rincian) OR empty($rincian['kibb']))
                            <tr>
                                <td colspan="23" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibb'] AS $item)
                            <tr>
                                <td class="text-nowrap text-center">
                                    {{zerofy($item->id_kategori->kd_golongan)}} .
                                    {{zerofy($item->id_kategori->kd_bidang)}} .
                                    {{zerofy($item->id_kategori->kd_kelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subkelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subsubkelompok)}} .
                                    {{zerofy($item->reg_barang,4)}}
                                </td>
                                <td class="text-nowrap">{{$item->merk}}</td>
                                <td class="text-nowrap">{{$item->tipe}}</td>
                                <td class="text-nowrap">{{$item->ukuran}}</td>
                                <td class="text-nowrap">{{$item->bahan}}</td>
                                <td class="text-nowrap">{{$item->no_pabrik}}</td>
                                <td class="text-nowrap">{{$item->no_rangka}}</td>
                                <td class="text-nowrap">{{$item->no_mesin}}</td>
                                <td class="text-nowrap">{{$item->no_polisi}}</td>
                                <td class="text-nowrap">{{$item->no_bpkb}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
                                <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                <td class="text-nowrap">{{$item->keterangan}}</td>
                                <td class="text-nowrap">{{is_object($item->id_ruangan)?$item->id_ruangan->nama:$item->id_ruangan}}</td>
                                <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- KIB-C -->
                <div class="tab-pane" id="kibc" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Tingkat</th>
                                <th class="text-nowrap">Beton</th>
                                <th class="text-nowrap">Luas Lantai</th>
                                <th class="text-nowrap">Lokasi</th>
                                <th class="text-nowrap">Tgl.Dokumen</th>
                                <th class="text-nowrap">No.Dokumen</th>
                                <th class="text-nowrap">Status Tanah</th>
                                <th class="text-nowrap">Kode Tanah</th>
                                <th class="text-nowrap">Tgl. Perolehan</th>
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
                            @if(empty($rincian) OR empty($rincian['kibc']))
                            <tr>
                                <td colspan="21" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibc'] AS $item)
                            <tr>
                                <td class="text-nowrap text-center">
                                    {{zerofy($item->id_kategori->kd_golongan)}} .
                                    {{zerofy($item->id_kategori->kd_bidang)}} .
                                    {{zerofy($item->id_kategori->kd_kelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subkelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subsubkelompok)}} .
                                    {{zerofy($item->reg_barang,4)}}
                                </td>
                                <td class="text-nowrap">{{($item->tingkat > 0) ? "<span class='badge badge-success'>Ya</span>" : "<span class='badge badge-danger'>Tidak</span>"}}</td>
                                <td class="text-nowrap">{{($item->beton > 0) ? "<span class='badge badge-success'>Ya</span>" : "<span class='badge badge-danger'>Tidak</span>"}}</td>
                                <td class="text-nowrap">{{$item->luas_lantai}}</td>
                                <td class="text-nowrap">{{$item->lokasi}}</td>
                                <td class="text-nowrap">{{$item->dokumen_tgl}}</td>
                                <td class="text-nowrap">{{$item->dokumen_no}}</td>
                                <td class="text-nowrap">{{$item->status_tanah}}</td>
                                <td class="text-nowrap">{{$item->kode_tanah}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
                                <td class="text-nowrap">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                <td class="text-nowrap">{{$item->keterangan}}</td>
                                <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- KIB-D -->
                <div class="tab-pane" id="kibd" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
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
                                <th class="text-nowrap">Tgl. Perolehan</th>
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
                            @foreach($rincian['kibd'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kibd/delete_hapus/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
                                </td>
                                @endif
                                <td class="text-nowrap text-center">
                                    {{zerofy($item->id_kategori->kd_golongan)}} .
                                    {{zerofy($item->id_kategori->kd_bidang)}} .
                                    {{zerofy($item->id_kategori->kd_kelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subkelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subsubkelompok)}} .
                                    {{zerofy($item->reg_barang,4)}}
                                </td>
                                <td class="text-nowrap">{{$item->kontruksi}}</td>
                                <td class="text-nowrap">{{$item->panjang}}</td>
                                <td class="text-nowrap">{{$item->lebar}}</td>
                                <td class="text-nowrap">{{$item->luas}}</td>
                                <td class="text-nowrap">{{$item->lokasi}}</td>
                                <td class="text-nowrap">{{$item->dokumen_tgl}}</td>
                                <td class="text-nowrap">{{$item->dokumen_no}}</td>
                                <td class="text-nowrap">{{$item->status_tanah}}</td>
                                <td class="text-nowrap">{{$item->kode_tanah}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
                                <td class="text-nowrap">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                <td class="text-nowrap">{{$item->keterangan}}</td>
                                <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- KIB-E -->
                <div class="tab-pane" id="kibe" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Judul</th>
                                <th class="text-nowrap">Pecipta</th>
                                <th class="text-nowrap">Bahan</th>
                                <th class="text-nowrap">Ukuran</th>
                                <th class="text-nowrap">Tgl. Perolehan</th>
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
                            @if(empty($rincian) OR empty($rincian['kibe']))
                            <tr>
                                <td colspan="18" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibe'] AS $item)
                            <tr>
                                <td class="text-nowrap text-center">
                                    {{zerofy($item->id_kategori->kd_golongan)}} .
                                    {{zerofy($item->id_kategori->kd_bidang)}} .
                                    {{zerofy($item->id_kategori->kd_kelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subkelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subsubkelompok)}} .
                                    {{zerofy($item->reg_barang,4)}}
                                </td>
                                <td class="text-nowrap">{{$item->judul}}</td>
                                <td class="text-nowrap">{{$item->pencipta}}</td>
                                <td class="text-nowrap">{{$item->bahan}}</td>
                                <td class="text-nowrap">{{$item->ukuran}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
                                <td class="text-nowrap">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                <td class="text-nowrap">{{$item->keterangan}}</td>
                                <td class="text-nowrap">{{is_object($item->id_ruangan)?$item->id_ruangan->nama:$item->id_ruangan}}</td>
                                <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- KIB-G -->
                <div class="tab-pane" id="kibg" role="tabpanel">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap">Merk</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">Ukuran</th>
                                <th class="text-nowrap">Tgl. Perolehan</th>
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
                            @if(empty($rincian) OR empty($rincian['kibg']))
                            <tr>
                                <td colspan="18" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibg'] AS $item)
                            <tr>
                                <td class="text-nowrap text-center">
                                    {{zerofy($item->id_kategori->kd_golongan)}} .
                                    {{zerofy($item->id_kategori->kd_bidang)}} .
                                    {{zerofy($item->id_kategori->kd_kelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subkelompok)}} .
                                    {{zerofy($item->id_kategori->kd_subsubkelompok)}} .
                                    {{zerofy($item->reg_barang,4)}}
                                </td>
                                <td class="text-nowrap">{{$item->merk}}</td>
                                <td class="text-nowrap">{{$item->tipe}}</td>
                                <td class="text-nowrap">{{$item->ukuran}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
                                <td class="text-nowrap text-danger">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                <td class="text-nowrap">{{$item->keterangan}}</td>
                                <td class="text-nowrap">{{is_object($item->id_ruangan)?$item->id_ruangan->nama:$item->id_ruangan}}</td>
                                <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@end

@section('style')
<style>
th, td {
    font-size: smaller !important;
}
</style>
@end

@section('script')
<script>
    theme.activeMenu('.nav-koreksi-tambah');
</script>
@end