.@layout('commons/index')
@section('title')Transfer Keluar - Rincian@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('transfer/index/keluar?id_organisasi='.$transfer->id_organisasi->id)}}">Transfer Keluar</a></li>
<li class="breadcrumb-item active">Rincian Aset</li>
@end

@section('content')
<div class="form-inline">
    <div class="btn-group mb-3">
        <a href="{{site_url('transfer/index/keluar_detail/'.$transfer->id)}}" class="btn btn-primary">01. Detail Transfer Keluar</a>
        <a href="#" class="btn btn-primary active">02. Rincian Aset</a>
    </div>
    <div class="btn-group mb-3 ml-auto">
        <button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus"></i> Tambah</button>
        <a href="{{site_url('transfer/index/finish_transaction/'.$transfer->id)}}" class="btn btn-success" onclick="return confirm('Anda yakin? Data tidak dapat disunting jika telah diajukan.')"><i class="fa fa-check mr-2"></i>Selesaikan Transaksi</a>
        @elseif($transfer->status_pengajuan === '1')
        <a href="{{site_url('transfer/index/cancel_transaction/'.$transfer->id)}}" class="btn btn-warning" onclick="return confirm('Anda yakin?')"><i class="fa fa-check mr-2"></i>Batalkan Pengajuan</a>
        @endif
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <div class="card">
            <div class="card-header form-inline">
                <span class="mr-auto">Detail Kontrak</span>
            </div>
            <div class="card-body row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-4">Asal</div>
                        <div class="col"> : {{$transfer->id_organisasi->nama}}</div>
                        <div class="w-100"></div>
                        <div class="col-4">Tujuan</div>
                        <div class="col"> : {{$transfer->id_tujuan->nama}}</div>
                        <div class="w-100"></div>
                        <div class="col-4">No. Surat</div>
                        <div class="col"> : {{$transfer->surat_no}}</div>
                        <div class="w-100"></div>
                        <div class="col-4">No. Jurnal</div>
                        <div class="col"> : {{$transfer->id}}</div>
                        <div class="w-100"></div>
                        <div class="col-4">No. Serah Terima</div>
                        <div class="col"> : {{$transfer->serah_terima_no}}</div>
                        <div class="w-100"></div>
                        <div class="col-4">Total Rincian</div>
                        <div class="col"> : Rp {{monefy($total_rincian)}}</div>
                    </div>
                </div>
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
                            KIB-A {{!empty($kiba) ? '<span class="badge badge-primary">'.(count($kiba)).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibb" role="tab">
                            KIB-B {{!empty($kibb) ? '<span class="badge badge-primary">'.(count($kibb)).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibc" role="tab">
                            KIB-C {{!empty($kibc) ? '<span class="badge badge-primary">'.(count($kibc)).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibd" role="tab">
                            KIB-D {{!empty($kibd) ? '<span class="badge badge-primary">'.(count($kibd)).'</span>' : ''}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kibe" role="tab">
                            KIB-E {{!empty($kibe) ? '<span class="badge badge-primary">'.(count($kibe)).'</span>' : ''}}
                        </a>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kibg" role="tab">
                                KIB-G {{!empty($kibg) ? '<span class="badge badge-primary">'.(count($kibg)).'</span>' : ''}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kdpc" role="tab">
                                KDP-C {{!empty($kdpc) ? '<span class="badge badge-primary">'.(count($kdpc)).'</span>' : ''}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kdpd" role="tab">
                                KDP-D {{!empty($kdpd) ? '<span class="badge badge-primary">'.(count($kdpd)).'</span>' : ''}}
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
                                    <th class="text-nowrap text-center">Aksi</th>
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
                                @if(empty($kiba))
                                <tr>
                                    <td colspan="14" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kiba)
                                @foreach($kiba AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kiba/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- KIB-B -->
                    <div class="tab-pane" id="kibb" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
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
                                @if(empty($kibb))
                                <tr>
                                    <td colspan="21" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kibb)
                                @foreach($kibb AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibb/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                    <!-- <td class="text-nowrap">{{$item->kondisi}}</td> -->
                                    <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
                                    <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                    <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                    <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                    <td class="text-nowrap">{{$item->keterangan}}</td>
                                    <td class="text-nowrap">{{is_object($item->id_ruangan)?$item->id_ruangan->nama:$item->id_ruangan}}</td>
                                    <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- KIB-C -->
                    <div class="tab-pane" id="kibc" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
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
                                @if(empty($kibc))
                                <tr>
                                    <td colspan="19" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kibc)
                                @foreach($kibc AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibc/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                    <td class="text-nowrap text-right">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                    <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                    <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                    <td class="text-nowrap">{{$item->keterangan}}</td>
                                    <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- KIB-D -->
                    <div class="tab-pane" id="kibd" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
                                    <th class="text-nowrap text-center">Kode Barang</th>
                                    <th class="text-nowrap text-right">Nilai</th>
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
                                    <th class="text-nowrap text-right">Nilai Sisa</th>
                                    <th class="text-nowrap">Masa Manfaat</th>
                                    <th>Keterangan</th>
                                    <th class="text-nowrap">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($kibd))
                                <tr>
                                    <td colspan="20" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kibd)
                                @foreach($kibd AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibd/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                    <td class="text-nowrap text-right">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                    <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                    <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                    <td class="text-nowrap">{{$item->keterangan}}</td>
                                    <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- KIB-E -->
                    <div class="tab-pane" id="kibe" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
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
                                @if(empty($kibe))
                                <tr>
                                    <td colspan="16" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kibe)
                                @foreach($kibe AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibe/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                    <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                    <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                    <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                    <td class="text-nowrap">{{$item->keterangan}}</td>
                                    <td class="text-nowrap">{{is_object($item->id_ruangan)?$item->id_ruangan->nama:$item->id_ruangan}}</td>
                                    <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- KIB-G -->
                    <div class="tab-pane" id="kibg" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
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
                                @if(empty($kibg))
                                <tr><td colspan="16" class="text-center"><b><i>Data kosong</i></b></td></tr>
                                @endif

                                @foreach($kibg AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibg/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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

                    <!-- KDP-C -->
                    <div class="tab-pane" id="kdpc" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
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
                                @if(empty($kdpc))
                                <tr>
                                    <td colspan="19" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kdpc)
                                @foreach($kdpc AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibc/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                    <td class="text-nowrap text-right">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                    <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                    <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                    <td class="text-nowrap">{{$item->keterangan}}</td>
                                    <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- KDP-D -->
                    <div class="tab-pane" id="kdpd" role="tabpanel">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">Aksi</th>
                                    <th class="text-nowrap text-center">Kode Barang</th>
                                    <th class="text-nowrap text-right">Nilai</th>
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
                                    <th class="text-nowrap text-right">Nilai Sisa</th>
                                    <th class="text-nowrap">Masa Manfaat</th>
                                    <th>Keterangan</th>
                                    <th class="text-nowrap">Kategori</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($kdpd))
                                <tr>
                                    <td colspan="20" class="text-center"><b><i>Data kosong</i></b></td>
                                </tr>
                                @endif
                                @if($kdpd)
                                @foreach($kdpd AS $item)
                                <tr>
                                    <td class="text-nowrap text-center">
                                        @if($transfer->status_pengajuan === '0' OR $transfer->status_pengajuan === '3')
                                        <a href="{{site_url('transfer/kibd/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
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
                                    <td class="text-nowrap text-right">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
                                    <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                    <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                    <td class="text-nowrap">{{$item->keterangan}}</td>
                                    <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                </tr>
                                @endforeach
                                @endif
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
                        <form action="{{site_url('transfer/index/rincian_redirect/'.$transfer->id)}}" method="POST">
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
                            <div class="modal-title"><b>Konstruksi Dalam Pengerjaan</b></div>
                            <ul style="list-style: none;">
                                <li><input type="radio" name="jenis" value="kdpc"> C - Gedung Dan Bangunan</li>
                                <li><input type="radio" name="jenis" value="kdpd"> D - Jalan, Irigasi &amp Jaringan</li>
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
        @endsection

        @section('style')
        <style>
        th, td {
            font-size: smaller !important;
        }
    </style>
    @endsection

    @section('script')
    <script>
        theme.activeMenu('.nav-transfer-keluar');
    </script>
    @end