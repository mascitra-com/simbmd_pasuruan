@layout('commons/index')
@section('title')Pengadaan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pengadaan</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="{{site_url('pengadaan/index')}}" method="GET" class="mr-auto">
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
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-spk"><i class="fa fa-plus mr-2"></i>Baru</button>
			<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button> -->
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th class="text-center">No. SPK/Perjanian/Kontrak</th>
						<th>Tanggal</th>
						<th class="text-right">Nilai</th>
						<th class="text-nowrap">Jangka Waktu</th>
						<th>Keterangan</th>
						<th class="text-center">Status Pengajuan</th>
						<th class="text-center">Tanggal Verifikasi</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@foreach($spks AS $item)
					<tr>
						<td class="text-center">{{$item->nomor}}</td>
						<td>{{datify($item->tanggal, 'd/m/Y')}}</td>
						<td class="text-right">{{(!empty($item->nilai)) ? monefy($item->nilai) : 00,00}}</td>
						<td class="text-nowrap">{{$item->jangka_waktu}}</td>
						<td class="text-sm">{{$item->keterangan}}</td>
						<td class="text-center">
							@if($item->status_pengajuan === '0')
							<button class="btn btn-secondary btn-sm btn-block" id="btn-pesan">draf</button>
							@elseif($item->status_pengajuan === '1')
							<button class="btn btn-warning btn-sm btn-block" id="btn-pesan">menunggu</button>
							@elseif($item->status_pengajuan === '2')
							<button class="btn btn-success btn-sm btn-block" data-id-transfer="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>disetujui</button>
							@elseif($item->status_pengajuan === '3')
							<button class="btn btn-danger btn-sm btn-block" data-id-transfer="{{$item->id}}"><i class="fa fa-comment-o mr-2"></i>ditolak</button>
							@else
							ERROR
							@endif
						</td>
						<td class="text-center">{{($item->status_pengajuan !== '0') ? datify($item->tanggal_verifikasi) : '-'}}</td>
						<td class="text-center">
							<div class="btn-group btn-group-sm">
								<a href="{{site_url('pengadaan/index/detail/'.$item->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i> rincian</a>
								<button class="btn btn-danger" data-id="{{$item->id}}"><i class="fa fa-trash"></i></button>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer">{{$pagination}}</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-spk">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Pengadaan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('pengadaan/index/insert')}}" method="POST">
					<input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
					<div class="row">
						<div class="col">
							<div class="form-row">
								<div class="form-group col">
									<label>No. Kontrak</label>
									<input type="text" class="form-control form-control-sm" name="nomor" placeholder="No. SPK/Kontrak/Perjanjian" required/>
								</div>
								<div class="form-group col">
									<label>Tgl. Kontrak</label>
									<input type="date" class="form-control form-control-sm" name="tanggal" placeholder="Tanggal kontrak" required/>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>No. BA Serah Terima</label>
									<input type="text" class="form-control form-control-sm" name="no_serah_terima" placeholder="No. Berita Acara Serah Terima" required />
								</div>
								<div class="form-group col">
									<label>Tgl. BA Serah Terima</label>
									<input type="date" class="form-control form-control-sm" name="tgl_serah_terima" placeholder="Tanggal Berita Acara Serah Terima" required />
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>Jangka Waktu</label>
									<input type="number" class="form-control form-control-sm" name="jangka_waktu" placeholder="Jangka waktu" />
								</div>
								<div class="form-group col">
									<label>Nilai</label>
									<input type="number" class="form-control form-control-sm" name="nilai" placeholder="Nilai" required/>
								</div>
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<textarea class="form-control form-control-sm" rows="5" name="keterangan" placeholder="Keterangan"></textarea>
							</div>
						</div>
						<div class="col">
							<div class="form-row">
								<div class="form-group col">
									<label>Nama Perusahaan</label>
									<input type="text" class="form-control form-control-sm" name="nama_perusahaan" placeholder="Nama perusahaan" />
								</div>
								<div class="form-group col">
									<label>Bentuk</label>
									<input type="text" class="form-control form-control-sm" name="bentuk" placeholder="Bentuk" />
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>Alamat</label>
									<input type="text" class="form-control form-control-sm" name="alamat" placeholder="Alamat" />
								</div>
								<div class="form-group col">
									<label>Pimpinan</label>
									<input type="text" class="form-control form-control-sm" name="pimpinan" placeholder="Pimpinan" />
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>NPWP</label>
									<input type="text" class="form-control form-control-sm" name="npwp" placeholder="NPWP" />
								</div>
								<div class="form-group col">
									<label>Bank</label>
									<input type="text" class="form-control form-control-sm" name="bank" placeholder="Bank" />
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>Atas Nama</label>
									<input type="text" class="form-control form-control-sm" name="atas_nama" placeholder="Atas Nama" />
								</div>
								<div class="form-group col">
									<label>No. Rekening</label>
									<input type="text" class="form-control form-control-sm" name="no_rek" placeholder="No. Rekening" />
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>Addendum Nilai</label>
							<input type="number" class="form-control form-control-sm" name="addendum_nilai" placeholder="Addendum Nilai" />
						</div>
						<div class="form-group col">
							<label>Kegiatan</label>
							<select name="id_kegiatan" class="form-control form-control-sm">
								<option>Pilih Kegiatan....</option>
								@foreach($kegiatan AS $data)
								<option value="{{$data->id}}">{{$data->kode.' - '.$data->nama}}</option>
								@endforeach
							</select>
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
				<h3>Menghapus data SPK juga akan menghapus semua rincian pengadaan dan SP2D.</h3>
			</div>
			<div class="modal-footer">
				<a href="" class="btn btn-warning" id="btn-hapus-confirm">Tetap hapus</a>
				<button class="btn btn-primary" data-dismiss="modal">Batal</button>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
.text-sm {font-size: smaller;}
</style>
@endsection

@section('script')
<script>
	theme.activeMenu('.nav-pengadaan');
	$("[data-id]").on('click', function(){
		var id = $(this).data('id');
		$("#btn-hapus-confirm").attr("href", "{{site_url('pengadaan/index/delete/')}}"+id);
		$("#modal-hapus").modal('show');
	});
</script>
@end