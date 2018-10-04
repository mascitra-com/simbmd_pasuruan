@layout('commons/index')
@section('title')Penghapusan Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Penghapusan Aset</li>
@end

@section('content')
<div class="card">
    <div class="card-header form-inline">
        <form action="" method="GET" class="mr-auto">
            <div class="input-group">
                <select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
                    <option></option>
                    @foreach($organisasi AS $org)
                    <option value="{{$org->id}}" {{isset($filter['id_organisasi']) && $org->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$org->nama}}</option>
                    @endforeach
                </select>
                <span class="input-group-btn">
                   <button class="btn btn-primary">Pilih</button>
               </span>
           </div>
       </form>
       <div class="btn-group">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add"><i class="fa fa-plus mr-2"></i>Baru</button>
        <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button> -->
        <button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
    </div>
</div>
<div class="card-body table-responsive px-0 py-0">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <thead>
                <tr>
                    <th class="text-center">No. Jurnal</th>
                    <th class="text-nowrap">Tanggal Jurnal</th>
                    <th class="text-nowrap">No. SK</th>
                    <th class="text-nowrap">Tanggal SK</th>
                    <th class="text-nowrap">Keterangan</th>
                    <th class="text-nowrap">Status</th>
                    <th class="">Tanggal Verifikasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($hapus)
                @foreach($hapus as $item)
                <tr class="small">
                    <td class="text-center">{{ zerofy($item->id, 5) }}</td>
                    <td class="text-nowrap">{{ datify($item->tgl_jurnal, 'd-m-Y') }}</td>
                    <td class="text-nowrap">{{ $item->no_sk }}</td>
                    <td class="text-nowrap">{{ datify($item->tgl_sk, 'd-m-Y') }}</td>
                    <td class="text-nowrap">{{ $item->keterangan }}</td>
                    <td class="text-center">
                        @if($item->status_pengajuan === '0')
                        <button class="btn btn-secondary btn-sm btn-block" id="btn-pesan">draf</button>
                        @elseif($item->status_pengajuan === '1')
                        <button class="btn btn-warning btn-sm btn-block" id="btn-pesan">menunggu</button>
                        @elseif($item->status_pengajuan === '2')
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm btn-block" data-id-hapus="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>disetujui</button>
                            @if($this->session->auth['is_superadmin'] == 1)
                            <button class="btn btn-warning" data-id-batal="{{$item->id}}"><i class="fa fa-times"></i></button>
                            @endif
                        </div>
                        @elseif($item->status_pengajuan === '3')
                        <button class="btn btn-danger btn-sm btn-block" data-id-hapus="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>ditolak</button>
                        @else
                        ERROR
                        @endif
                    </td>
                    <td class="text-nowrap">{{ $item->status_pengajuan > 1 ? datify($item->tanggal_verifikasi, 'd-m-Y') : "-" }}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ base_url('penghapusan/index/detail/'.$item->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i> rincian</a>
                            @if($item->status_pengajuan == '0' || $item->status_pengajuan == '3')
                            <button data-id="{{ $item->id }}" class="btn btn-danger "><i class="fa fa-trash"></i></button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="9">Tidak Ditemukan Data</td>
                </tr>
                @endif
            </tbody>
        </thead>
    </table>
</div>
<div class="card-footer"></div>
</div>
@end
@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{site_url('penghapusan/index/insert')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
                    <div class="row">
                        <div class="col">
                            <input type="hidden" class="form-control form-control-sm" name="id_organisasi" required value="{{ $filter['id_organisasi'] }}"/>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label>No. Jurnal</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="(Otomatis)" disabled />
                                </div>
                                <div class="form-group col">
                                    <label>Tgl. Jurnal</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_jurnal" placeholder="Tanggal Jurnal" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>No. SK</label>
                            <input type="text" class="form-control form-control-sm" name="no_sk" placeholder="No. SK" required />
                        </div>
                        <div class="form-group col">
                            <label>Tanggal SK</label>
                            <input type="date" class="form-control form-control-sm" name="tgl_sk" placeholder="Tanggal SK" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Keterangan</label>
                            <input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Keterangan" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Alasan</label>
                            <select name="alasan" id="alasan" class="form-control form-control-sm">
                                <option value="dijual">Dijual</option>
                                <option value="dihibahkan">Dihibahkan</option>
                                @if($this->config->item('mode')==='jember')
                                <option value="penyertaan modal">Penyertaan Modal</option>
                                <option value="tukar-menukar">Tukar-menukar</option>
                                @else
                                <option value="dimusnahkan">Dimusnahkan</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="">Unggah berkas penunjang</label><br>
                            <input type="file" name="berkas">
                            <p class="form-text text-small text-muted">Maksimal ukuran berkas adalah 1MB. Format yang diperbolehkan adalah PDF, DOC, DOCX, XLS, dan XLSX.</p>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="col text-right">
                            <button type="submit" class="btn btn-primary" {{empty($filter['id_organisasi'])?'disabled':''}}><i class="fa fa-save"></i> {{empty($filter['id_organisasi'])?'Pilih organisasi terlebih dahulu':'Simpan'}}</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-hapus">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Apakah anda yakin?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h3>Menghapus data Pengajuan juga akan menghapus semua rincian aset yang diajukan.</h3>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-warning" id="btn-hapus-confirm">Tetap hapus</a>
                <button class="btn btn-primary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-pesan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">Detail Persetujuan</div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="bold">Tanggal Verifikasi:</label>
                    <div id="span-tanggal"></div>
                </div>
                <div class="form-group">
                    <label class="bold">Status Verifikasi:</label>
                    <div id="span-status">Disetujui</div>
                </div>
                <div class="form-group">
                    <label class="bold">Pesan:</label>
                    <div id="span-pesan"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-batal">
    <div class="modal-dialog" role="document">
        <div class="modal-content card text-center">
            <div class="card-header">
                <b class="card-title">Pembatalan Persetujuan</b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="card-body"></div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
@end

@section('style')
<style>
.text-sm {font-size: smaller;}
.bold{font-weight: bold}
</style>
@end

@section('script')
<script>
    theme.activeMenu('.nav-penghapusan');
    $("[data-id]").on('click', function(){
        var id = $(this).data('id');
        $("#btn-hapus-confirm").attr("href", "{{site_url('penghapusan/index/delete/')}}"+id);
        $("#modal-hapus").modal('show');
    });

    $("[data-id-hapus]").on('click', function(e){
        var id = $(e.currentTarget).data('id-hapus');

        $.getJSON("{{site_url('persetujuan/api/get_persetujuan_hapus/')}}"+id, function(result){
            $("#span-tanggal").html(result.log_time);
            $("#span-status").html(result.status);
            $("#span-pesan").html(result.pesan);
        });

        $("#modal-pesan").modal('show');
    });

    $("[data-id-batal]").on('click', function(e){
        $("#modal-batal .card-body").empty().html("<h4 class='mb-3'>Memeriksa ketersediaan pembatalan<br>Mohon menunggu</h4><h1 class='mb-4'><i class='fa fa-refresh fa-spin fa-2x'></i></h1>");
        $("#modal-batal .card-footer").empty();
        $("#modal-batal").modal('show');
        
        var id = $(this).data('id-batal');
        $.getJSON("{{site_url('penghapusan/index/get_abort_status/')}}"+id, function(result){
            if (result.status === true) {
                html = "<div class='btn-group'>"
                html += "<a href='{{site_url()}}penghapusan/index/abort_transaction/"+id+"' class='btn btn-warning'>Batalkan Persetujuan</a>";
                html += "<button class='btn btn-secondary' data-dismiss='modal'>Urungkan</button>";
                html += "</div>";
                $("#modal-batal .card-body").empty().html("<h3 class='mb-3'>Pembatalan persetujuan dapat dilakukan.</h3>");
                $("#modal-batal .card-footer").empty().html(html);
            }else{
                $("#modal-batal .card-body").empty().html("<p>Pembatalan persetujuan <b>tidak dapat dilakukan</b>.<br>"+result.reason+"</p>");
                $("#modal-batal .card-footer").html("<button class='btn btn-secondary' data-dismiss='modal'>Urungkan</button>");
            }
        });
    });
</script>
@end