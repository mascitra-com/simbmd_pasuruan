@layout('commons/index')
@section('title')Koreksi Nilai@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai?id_organisasi='.$koreksi->id_organisasi)}}">Koreksi Nilai</a></li>
<li class="breadcrumb-item"><a href="{{site_url('koreksi/nilai/rincian/'.$koreksi->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">KIB-A</li>
@end

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
							<th class="text-nowrap">Luas (m3)</th>
							<th class="text-nowrap">Alamat</th>
							<th class="text-nowrap">Tgl. Sertifikat</th>
							<th class="text-nowrap">No. Sertifikat</th>
							<th class="text-nowrap">Hak Pakai</th>
							<th class="text-nowrap">Pengguna</th>
							<th class="text-nowrap">Tgl. Perolehan</th>
							<th class="text-nowrap">Tgl. Pembukuan</th>
							<th class="text-nowrap">Asal Usul</th>
							<th class="text-nowrap">Keterangan</th>
							<th class="text-nowrap">Kategori</th>
						</tr>
					</thead>
					<tbody>
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
							<td class="text-nowrap text-right text-danger">{{monefy($item->nilai)}}</td>
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
			<div class="card-footer"></div>
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
				<form action="{{site_url('koreksi/aset/kiba/insert_nilai')}}" method="POST">
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
				<form action="{{site_url('koreksi/aset/kiba/koreksi_nilai/'.$koreksi->id)}}" method="GET">
					<input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Reg Barang</label>
								<input type="text" class="form-control form-control-sm" name="reg_barang" value="{{isset($filter['reg_barang'])?$filter['reg_barang']:''}}" />
							</div>
							<div class="form-group">
								<label>Tgl. Sertifikat</label>
								<input type="text" class="form-control form-control-sm" name="sertifikat_tgl" value="{{isset($filter['sertifikat_tgl'])?$filter['sertifikat_tgl']:''}}" />
							</div>
							<div class="form-group">
								<label>Pengguna</label>
								<input type="text" class="form-control form-control-sm" name="pengguna" value="{{isset($filter['pengguna'])?$filter['pengguna']:''}}" />
							</div>
							<div class="form-group">
								<label>Tahun</label>
								<input type="date" class="form-control form-control-sm" name="tahun" value="{{isset($filter['tahun'])?$filter['tahun']:''}}" />
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<input type="text" class="form-control form-control-sm" name="keterangan" value="{{isset($filter['keterangan'])?$filter['keterangan']:''}}" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Alamat</label>
								<input type="text" class="form-control form-control-sm" name="alamat" value="{{isset($filter['alamat'])?$filter['alamat']:''}}" />
							</div>
							<div class="form-group">
								<label>Hak</label>
								<input type="text" class="form-control form-control-sm" name="hak" value="{{isset($filter['hak'])?$filter['hak']:''}}" />
							</div>
							<div class="form-group">
								<label>Tgl. Pembukuan</label>
								<input type="text" class="form-control form-control-sm" name="tgl_pembukuan" value="{{isset($filter['tgl_pembukuan'])?$filter['tgl_pembukuan']:''}}" />
							</div>
							<div class="form-group">
								<label>Nilai</label>
								<input type="text" class="form-control form-control-sm" name="nilai" value="{{isset($filter['nilai'])?$filter['nilai']:''}}" />
							</div>
							<div class="form-group">
								<label>Urutkan Berdasar</label>
								<select name="ord_by" class="form-control form-control-sm">
									<option value="reg_barang">Reg Barang</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Luas</label>
								<input type="text" class="form-control form-control-sm" name="luas" value="{{isset($filter['luas'])?$filter['luas']:''}}" />
							</div>
							<div class="form-group">
								<label>No. Sertifikat</label>
								<input type="text" class="form-control form-control-sm" name="sertifikat_no" value="{{isset($filter['sertifikat_no'])?$filter['sertifikat_no']:''}}" />
							</div>
							<div class="form-group">
								<label>Tgl. Perolehan</label>
								<input type="text" class="form-control form-control-sm" name="tgl_perolehan" value="{{isset($filter['tgl_perolehan'])?$filter['tgl_perolehan']:''}}" />
							</div>
							<div class="form-group">
								<label>Asal Usul</label>
								<input type="text" class="form-control form-control-sm" name="asal_usul" value="{{isset($filter['asal_usul'])?$filter['asal_usul']:''}}" />
							</div>
							<div class="form-group">
								<label>Jumlah Tampilan Data</label>
								<select name="limit" class="form-control form-control-sm">
									<option value="20">20</option>
									<option value="50">50</option>
									<option value="100">100</option>
									<option value="300">300</option>
								</select>
							</div>
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
