@layout('commons/index')
@section('title')Koreksi Nilai@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Nilai</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3 ml-auto">
        <button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
        @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
        <a href="{{site_url('koreksi/nilai/finish_transaction/'.$koreksi->id)}}" class="btn btn-success" onclick="return confirm('Anda yakin? Data tidak dapat disunting jika telah diajukan.')"><i class="fa fa-check mr-2"></i>Selesaikan Transaksi</a>
        @elseif($koreksi->status_pengajuan === '1')
        <a href="{{site_url('koreksi/nilai/cancel_transaction/'.$koreksi->id)}}" class="btn btn-warning" onclick="return confirm('Anda yakin?')"><i class="fa fa-check mr-2"></i>Batalkan Pengajuan</a>
        @endif
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header form-inline">
                <span class="mr-auto">Detail Kontrak</span>
            </div>
            <div class="card-body">
                <form action="{{site_url('koreksi/nilai/update')}}" method="POST" class="form-row">
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
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <th class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap text-right text-danger">Nilai Lama</th>
                                <th class="text-nowrap text-right text-success">Nilai Baru</th>
                                <th class="text-nowrap">Luas (m2)</th>
                                <th class="text-nowrap">Alamat</th>
                                <th class="text-nowrap">Tgl. Sertifikat</th>
                                <th class="text-nowrap">No. Sertifikat</th>
                                <th class="text-nowrap">Hak Pakai</th>
                                <th class="text-nowrap">Pengguna</th>
                                <th class="text-nowrap">Tgl. Perolehan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($rincian) OR empty($rincian['kiba']))
                            <tr>
                                <td colspan="15" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kiba'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kiba/delete_nilai/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
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
                                <td class="text-nowrap text-right text-danger">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right text-success">{{monefy($item->corrected_value)}}</td>
                                <td class="text-nowrap">{{$item->luas}}</td>
                                <td class="text-nowrap">{{$item->alamat}}</td>
                                <td class="text-nowrap">{{datify($item->sertifikat_tgl, 'd/m/Y')}}</td>
                                <td class="text-nowrap">{{$item->sertifikat_no}}</td>
                                <td class="text-nowrap">{{$item->hak}}</td>
                                <td class="text-nowrap">{{$item->pengguna}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd/m/Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd/m/Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
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
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <th class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap text-right text-danger">Nilai Lama</th>
                                <th class="text-nowrap text-right text-success">Nilai Baru</th>
                                <th class="text-nowrap">Merk</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">Ukuran/CC</th>
                                <th class="text-nowrap">Bahan</th>
                                <th class="text-nowrap">No.Pabrik</th>
                                <th class="text-nowrap">No.Rangka</th>
                                <th class="text-nowrap">No.Mesin</th>
                                <th class="text-nowrap">No.Polisi</th>
                                <th class="text-nowrap">No.BPKB</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
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
                                <td colspan="22" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibb'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kibb/delete_nilai/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
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
                                <td class="text-nowrap text-right text-danger">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right text-success">{{monefy($item->corrected_value)}}</td>
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
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <th class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap text-right text-danger">Nilai Lama</th>
                                <th class="text-nowrap text-right text-success">Nilai Baru</th>
                                <th class="text-nowrap">Tingkat</th>
                                <th class="text-nowrap">Beton</th>
                                <th class="text-nowrap">Luas Lantai</th>
                                <th class="text-nowrap">Lokasi</th>
                                <th class="text-nowrap">Tgl.Dokumen</th>
                                <th class="text-nowrap">No.Dokumen</th>
                                <th class="text-nowrap">Status Tanah</th>
                                <th class="text-nowrap">Kode Tanah</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($rincian) OR empty($rincian['kibc']))
                            <tr>
                                <td colspan="20" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibc'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kibc/delete_nilai/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
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
                                <td class="text-nowrap text-right text-danger">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                <td class="text-nowrap text-right text-success">{{monefy($item->corrected_value)}}</td>
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
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <th class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap text-right text-danger">Nilai Lama</th>
                                <th class="text-nowrap text-right text-success">Nilai Baru</th>
                                <th class="text-nowrap">Kontruksi</th>
                                <th class="text-nowrap">Panjang</th>
                                <th class="text-nowrap">Lebar</th>
                                <th class="text-nowrap">Luas</th>
                                <th class="text-nowrap">Lokasi</th>
                                <th class="text-nowrap">Tgl.Dokumen</th>
                                <th class="text-nowrap">No.Dokumen</th>
                                <th class="text-nowrap">Status Tanah</th>
                                <th class="text-nowrap">Kode Tanah</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($rincian) OR empty($rincian['kibd']))
                            <tr>
                                <td colspan="21" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibd'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kibd/delete_nilai/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
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
                                <td class="text-nowrap text-right text-danger">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                <td class="text-nowrap text-right text-success">{{monefy($item->corrected_value)}}</td>
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
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <th class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap text-right text-danger">Nilai Lama</th>
                                <th class="text-nowrap text-right text-success">Nilai Baru</th>
                                <th class="text-nowrap">Judul</th>
                                <th class="text-nowrap">Pecipta</th>
                                <th class="text-nowrap">Bahan</th>
                                <th class="text-nowrap">Ukuran</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
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
                                <td colspan="17" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibe'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kibe/delete_nilai/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
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
                                <td class="text-nowrap text-right text-danger">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right text-success">{{monefy($item->corrected_value)}}</td>
                                <td class="text-nowrap">{{$item->judul}}</td>
                                <td class="text-nowrap">{{$item->pencipta}}</td>
                                <td class="text-nowrap">{{$item->bahan}}</td>
                                <td class="text-nowrap">{{$item->ukuran}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
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
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <th class="text-nowrap text-center">Aksi</th>
                                @endif
                                <th class="text-nowrap text-center">Kode Barang</th>
                                <th class="text-nowrap text-right text-danger">Nilai Lama</th>
                                <th class="text-nowrap text-right text-success">Nilai Baru</th>
                                <th class="text-nowrap">Merk</th>
                                <th class="text-nowrap">Tipe</th>
                                <th class="text-nowrap">Ukuran</th>
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
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
                                <td colspan="17" class="text-center"><b><i>Data kosong</i></b></td>
                            </tr>
                            @endif
                            @foreach($rincian['kibg'] AS $item)
                            <tr>
                                @if($koreksi->status_pengajuan === '0' OR $koreksi->status_pengajuan === '3')
                                <td class="text-nowrap text-center">
                                    <a href="{{site_url('koreksi/aset/kibg/delete_nilai/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-times"></i></a>
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
                                <td class="text-nowrap text-right text-danger">{{monefy($item->nilai)}}</td>
                                <td class="text-nowrap text-right text-success">{{monefy($item->corrected_value)}}</td>
                                <td class="text-nowrap">{{$item->merk}}</td>
                                <td class="text-nowrap">{{$item->tipe}}</td>
                                <td class="text-nowrap">{{$item->ukuran}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
                                <td class="text-nowrap">{{$item->asal_usul}}</td>
                                <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
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

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Aset</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{site_url('koreksi/nilai/rincian_redirect')}}" method="POST">
                        <input type="hidden" name="id" value="{{$koreksi->id}}">
                        
                        <div class="modal-title"><b>Aset Tetap</b></div>
                        <ul style="list-style: none;">
                            <li><input type="radio" name="jenis" value="a"> A - Tanah</li>
                            <li><input type="radio" name="jenis" value="b"> B - Peralatan Dan Mesin</li>
                            <li><input type="radio" name="jenis" value="c"> C - Gedung Dan Bangunan</li>
                            <li><input type="radio" name="jenis" value="d"> D - Jalan, Irigasi &amp Jaringan</li>
                            <li><input type="radio" name="jenis" value="e"> E - Buku, Barang &amp Kebudayaan</li>
                            <li><input type="radio" name="jenis" value="g"> G - Aset Lainnya</li>
                        </ul>
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Pilih</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                class="fa fa-times"></i> Batal
                            </button>
                        </div>
                    </form>
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