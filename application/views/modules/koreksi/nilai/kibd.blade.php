@layout('commons/index')
@section('title')Koreksi Nilai@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Nilai</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai/rincian/'.$koreksi->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">KIB-D</li>
@endsection

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
                <div class="btn-group">
                    <button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button>
                    <button class="btn btn-primary">Terpilih <span class="badge badge-warning" id="terpilih_count">{{$terpilih_count}}</span></button>
                </div>
            </div>
			<div class="card-body table-responsive table-scroll px-0 py-0">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-nowrap text-center">Aksi</th>
							<th class="text-nowrap text-center">Kode Barang</th>
							<th class="text-nowrap text-right text-danger">Nilai</th>
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
							<th class="text-nowrap">Keterangan</th>
							<th class="text-nowrap">Kategori</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kib))
						<tr><td colspan="20" class="text-center"><b><i>Data kosong</i></b></td></tr>
						@endif

						@foreach($kib AS $item)
						<tr>
							<td class="text-nowrap text-center">
                                <button class="btn btn-primary" data-id="{{$item->id}}" data-nilai="{{monefy($item->nilai)}}"><i class="fa fa-plus"></i></button>
                            </td>
							<td class="text-nowrap text-center">
								{{zerofy($item->id_kategori->kd_golongan)}} .
								{{zerofy($item->id_kategori->kd_bidang)}} .
								{{zerofy($item->id_kategori->kd_kelompok)}} .
								{{zerofy($item->id_kategori->kd_subkelompok)}} .
								{{zerofy($item->id_kategori->kd_subsubkelompok)}} .
								{{zerofy($item->reg_barang,4)}}
							</td>
							<td class="text-nowrap text-right text-danger">{{monefy($item->nilai+$item->nilai_tambah)}}</td>
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
			<div class="card-footer">{{$pagination}}</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Koreksi Nilai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{site_url('koreksi/aset/kibd/insert_nilai')}}" method="POST">
                    <input type="hidden" name="id_aset">
                    <input type="hidden" name="id_koreksi" value="{{$koreksi->id}}">
                    <div class="form-group">
                        <label>Nilai Lama</label>
                        <input type="text" name="original_value" class="form-control" readonly />
                    </div>
                    <div class="form-group">
                        <label>Nilai baru</label>
                        <input type="number" name="corrected_value" class="form-control" placeholder="nilai baru" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal-filter">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Filter data</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('koreksi/aset/kibd/koreksi_nilai/'.$koreksi->id)}}" method="GET">
					<input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
					<div class="row">
						<div class="form-group col">
							<label>Reg Barang</label>
							<input type="text" class="form-control" name="reg_barang" value="{{isset($filter['reg_barang'])?$filter['reg_barang']:''}}" />
						</div>
						<div class="form-group col">
							<label>Panjang</label>
							<input type="text" class="form-control" name="panjang" value="{{isset($filter['panjang'])?$filter['panjang']:''}}" />
						</div>
						<div class="form-group col">
							<label>Lebar</label>
							<input type="text" class="form-control" name="lebar" value="{{isset($filter['lebar'])?$filter['lebar']:''}}" />
						</div>
						<div class="form-group col">
							<label>Luas</label>
							<input type="text" class="form-control" name="luas" value="{{isset($filter['luas'])?$filter['luas']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Kontruksi</label>
							<input type="text" class="form-control" name="kontruksi" value="{{isset($filter['kontruksi'])?$filter['kontruksi']:''}}" />
						</div>
						<div class="form-group col">
							<label>Lokasi</label>
							<input type="text" class="form-control" name="lokasi" value="{{isset($filter['lokasi'])?$filter['lokasi']:''}}" />
						</div>
						<div class="form-group col">
							<label>Tgl.Dokumen</label>
							<input type="text" class="form-control" name="dokumen_tgl" value="{{isset($filter['dokumen_tgl'])?$filter['dokumen_tgl']:''}}" />
						</div>
						<div class="form-group col">
							<label>No.Dokumen</label>
							<input type="text" class="form-control" name="dokumen_no" value="{{isset($filter['dokumen_no'])?$filter['dokumen_no']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Status Tanah</label>
							<input type="text" class="form-control" name="status_tanah" value="{{isset($filter['status_tanah'])?$filter['status_tanah']:''}}" />
						</div>
						<div class="form-group col">
							<label>Kode Tanah</label>
							<input type="text" class="form-control" name="kode_tanah" value="{{isset($filter['kode_tanah'])?$filter['kode_tanah']:''}}" />
						</div>
						<div class="form-group col">
							<label>Kondisi</label>
							<input type="text" class="form-control" name="kondisi" value="{{isset($filter['kondisi'])?$filter['kondisi']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Asal Usul</label>
							<input type="text" class="form-control" name="asal_usul" value="{{isset($filter['asal_usul'])?$filter['asal_usul']:''}}" />
						</div>
						<div class="form-group col">
							<label>Keterangan</label>
							<input type="text" class="form-control" name="keterangan" value="{{isset($filter['keterangan'])?$filter['keterangan']:''}}" />
						</div>
						<div class="form-group col">
							<label>Nilai</label>
							<input type="text" class="form-control" name="nilai" value="{{isset($filter['nilai'])?$filter['nilai']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Jumlah Tampilan Data</label>
							<select name="limit" class="form-control">
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option value="300">300</option>
							</select>
						</div>
						<div class="form-group col">
							<label>Urutkan Berdasar</label>
							<select name="ord_by" class="form-control">
								<option value="reg_barang">Reg Barang</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Filter</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Kembali</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var kib = (function(){
		theme.activeMenu('.nav-koreksi-tambah');

        $("[data-id]").on('click', function(e){
            var id = $(e.currentTarget).data('id');
            var nilai = $(e.currentTarget).data('nilai');

            $("[name=id_aset]").val(id);
            $("[name=original_value]").val(nilai);

            $("#modal-tambah").modal('show');
        });
	})();
</script>
@end
