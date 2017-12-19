@layout('commons/index')
@section('title')Penghapusan Aset- Rincian@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{site_url('penghapusan?id_organisasi='.$hapus->id_organisasi->id)}}">Penghapusan
            Aset</a></li>
    <li class="breadcrumb-item active">Rincian Aset</li>
    @end4

@section('content')
    <div class="form-inline">
        <div class="btn-group mb-3">
            <a href="{{site_url('penghapusan/detail/'.$hapus->id)}}" class="btn btn-primary">01. Penghapusan Aset</a>
            <a href="#" class="btn btn-primary active">02. Rincian Aset</a>
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
    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-header form-inline">
                    <span class="mr-auto">Detail Kontrak</span>
                    <div class="btn-group btn-group-sm">
                        @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                        <button class="btn btn-primary" data-toggle="modal"
                                data-target="#modal-add"><i
                                    class="fa fa-plus"></i> Tambah
                        </button>
                        @endif
                        <button class="btn btn-primary"><i class="fa fa-refresh"></i> Segarkan</button>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">UPB</div>
                            <div class="col"> : {{ $hapus->id_organisasi->nama }}</div>
                            <div class="w-100"></div>
                            <div class="col-4">No. Jurnal</div>
                            <div class="col"> : {{ $hapus->no_jurnal }}</div>
                            <div class="w-100"></div>
                            <div class="col-4">SK. Penghapusan</div>
                            <div class="col"> : {{ $hapus->no_sk }}</div>
                            <div class="w-100"></div>
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
                            <a class="nav-link active" data-toggle="tab" href="#kiba" role="tab">KIB-A</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kibb" role="tab">KIB-B</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kibc" role="tab">KIB-C</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kibd" role="tab">KIB-D</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kibe" role="tab">KIB-E</a>
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
                                <th class="text-nowrap">Luas (m3)</th>
                                <th class="text-nowrap">Alamat</th>
                                <th class="text-nowrap">Tgl. Sertifikat</th>
                                <th class="text-nowrap">No. Sertifikat</th>
                                <th class="text-nowrap">Hak Pakai</th>
                                <th class="text-nowrap">Pengguna</th>
                                <th class="text-nowrap">Tgl. Perolehan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap">Keterangan</th>
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
                                            @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                                            <div class="btn-group">
                                                <a href="{{site_url('aset/kiba/delete_penghapusan/'.$item->id)}}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin?')"><i
                                                            class="fa fa-trash"></i></a>
                                            </div>
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
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th class="text-nowrap">Keterangan</th>
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
                                            @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                                            <div class="btn-group">
                                                <a href="{{site_url('aset/kibb/delete_penghapusan/'.$item->id)}}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin?')"><i
                                                            class="fa fa-trash"></i></a>
                                            </div>
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
                                        <td class="text-nowrap">{{$item->kondisi}}</td>
                                    <!-- <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td> -->
                                        <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                        <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
                                        <td class="text-nowrap">{{$item->masa_manfaat}}</td>
                                        <td class="text-nowrap">{{$item->keterangan}}</td>
                                        <td class="text-nowrap">{{$item->id_ruangan}}</td>
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
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th class="text-nowrap">Keterangan</th>
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
                                            @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                                            <div class="btn-group">
                                                <a href="{{site_url('aset/kibc/delete_penghapusan/'.$item->id)}}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin?')"><i
                                                            class="fa fa-trash"></i></a>
                                            </div>
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
                                        <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                        <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai + $item->nilai_sisa):'0'}}</td>
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
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th class="text-nowrap">Keterangan</th>
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
                                            @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                                            <div class="btn-group">
                                                <a href="{{site_url('aset/kibd/delete_penghapusan/'.$item->id)}}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin?')"><i
                                                            class="fa fa-trash"></i></a>
                                            </div>
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
                                        <td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
                                        <td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai + $item->nilai_sisa):'0'}}</td>
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
                                <th class="text-nowrap">Tgl. Pembuatan</th>
                                <th class="text-nowrap">Tgl. Pembukuan</th>
                                <th class="text-nowrap">Asal Usul</th>
                                <th class="text-nowrap">Kondisi</th>
                                <th class="text-nowrap text-right">Nilai</th>
                                <th class="text-nowrap text-right">Nilai Sisa</th>
                                <th class="text-nowrap">Masa Manfaat</th>
                                <th class="text-nowrap">Keterangan</th>
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
                                            @if($hapus->status_pengajuan === '0' || $hapus->status_pengajuan === '3')
                                            <div class="btn-group">
                                                <a href="{{site_url('aset/kibe/delete_penghapusan/'.$item->id)}}"
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Apakah anda yakin?')"><i
                                                            class="fa fa-trash"></i></a>
                                            </div>
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
                                        <td class="text-nowrap">{{$item->id_ruangan}}</td>
                                        <td class="text-nowrap">{{$item->id_kategori->nama}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="tambah_nilai" role="tabpanel">
                        <!-- TAMBAH NILAI -->
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
                    <form action="{{ site_url('penghapusan/rincian_redirect/'.$hapus->id) }}" method="POST">
                        <div class="modal-title"><b>Aset Tetap</b></div>
                        <ul style="list-style: none;">
                            <li><input type="radio" name="jenis" value="a"> A - Tanah</li>
                            <li><input type="radio" name="jenis" value="b"> B - Peralatan Dan Mesin</li>
                            <li><input type="radio" name="jenis" value="c"> C - Gedung Dan Bangunan</li>
                            <li><input type="radio" name="jenis" value="d"> D - Jalan, Irigasi &amp Jaringan</li>
                            <li><input type="radio" name="jenis" value="e"> E - Buku, Barang &amp Kebudayaan</li>
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
        theme.activeMenu('.nav-penghapusan');
    </script>
    @end