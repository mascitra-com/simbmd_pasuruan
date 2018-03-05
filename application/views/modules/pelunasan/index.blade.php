@layout('commons/index')
@section('title')Pelunasan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pelunasan</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<form action="{{site_url('pelunasan')}}" method="GET" class="mr-auto">
					<div class="input-group">
						<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB..." >
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
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<a href="{{site_url('pelunasan/add/'.$filter['id_organisasi'])}}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-header">
				<ul class="nav nav-tabs card-header-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#kiba" role="tab">Tanah</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#kibc" role="tab">Gedung &amp Bangunan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#kibd" role="tab">Jalan, Irigasi &amp Jaringan</a>
					</li>
				</ul>
			</div>
			<div class="card-body tab-content table-scroll px-0 py-0">
				<!-- KIB-A -->
				<div class="tab-pane" id="kiba" role="tabpanel">
					<table class="table table-hover table-striped table-bordered table-sm">
						<thead>
							<tr class="small">
								<th class="text-center" rowspan="2">No.</th>
								<th class="text-center" colspan="2">Aset</th>
								<th class="text-center" colspan="2">KDP</th>
								<th class="text-center" rowspan="2">Tanggal Pelunasan</th>
								<th class="text-center" rowspan="2">Aksi</th>
							</tr>
							<tr class="small">
								<th class="text-center">Kode</th>
								<th class="text-center">Nilai</th>
								<th class="text-center">Kode</th>
								<th class="text-center">Nilai</th>
							</tr>
						</thead>
						<tbody>
							@if(empty($pelunasan['kiba']))
							<tr><td class="text-center" colspan="7">Data Kosong</td></tr>
							@endif

							@foreach($pelunasan['kiba'] AS $index=>$item)
							<tr>
								<td class="text-center">{{$index + 1}}</td>
								<td class="text-center">
									{{zerofy($item->id_aset->kd_golongan, 2)}}.
									{{zerofy($item->id_aset->kd_bidang)}}.
									{{zerofy($item->id_aset->kd_kelompok, 2)}}.
									{{zerofy($item->id_aset->kd_subkelompok, 2)}}.
									{{zerofy($item->id_aset->kd_subsubkelompok, 2)}}.
									{{$item->id_aset->reg_barang}}
								</td>
								<td class="text-center">{{monefy($item->id_aset->nilai)}}</td>
								<td class="text-center">
									{{zerofy($item->id_kdp->kd_golongan, 2)}}.
									{{zerofy($item->id_kdp->kd_bidang)}}.
									{{zerofy($item->id_kdp->kd_kelompok, 2)}}.
									{{zerofy($item->id_kdp->kd_subkelompok, 2)}}.
									{{zerofy($item->id_kdp->kd_subsubkelompok, 2)}}.
									{{$item->id_kdp->reg_barang}}
								</td>
								<td class="text-center">{{monefy($item->id_kdp->nilai)}}</td>
								<td class="text-center">{{datify($item->tgl_pelunasan, 'd/m/Y')}}</td>
								<td class="text-center"><button class="btn btn-danger" data-id="{{$item->id}}">Batalkan</button></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- KIB-C -->
				<div class="tab-pane" id="kibc" role="tabpanel">
					<table class="table table-hover table-striped table-bordered table-sm">
						<thead>
							<tr class="small">
								<th class="text-center" rowspan="2">No.</th>
								<th class="text-center" colspan="2">Aset</th>
								<th class="text-center" colspan="2">KDP</th>
								<th class="text-center" rowspan="2">Tanggal Pelunasan</th>
								<th class="text-center" rowspan="2">Aksi</th>
							</tr>
							<tr class="small">
								<th class="text-center">Kode</th>
								<th class="text-center">Nilai</th>
								<th class="text-center">Kode</th>
								<th class="text-center">Nilai</th>
							</tr>
						</thead>
						<tbody>
							@if(empty($pelunasan['kibc']))
							<tr><td class="text-center" colspan="7">Data Kosong</td></tr>
							@endif

							@foreach($pelunasan['kibc'] AS $index=>$item)
							<tr>
								<td class="text-center">{{$index + 1}}</td>
								<td class="text-center">
									{{zerofy($item->id_aset->kd_golongan, 2)}}.
									{{zerofy($item->id_aset->kd_bidang)}}.
									{{zerofy($item->id_aset->kd_kelompok, 2)}}.
									{{zerofy($item->id_aset->kd_subkelompok, 2)}}.
									{{zerofy($item->id_aset->kd_subsubkelompok, 2)}}.
									{{$item->id_aset->reg_barang}}
								</td>
								<td class="text-center">{{monefy($item->id_aset->nilai)}}</td>
								<td class="text-center">
									{{zerofy($item->id_kdp->kd_golongan, 2)}}.
									{{zerofy($item->id_kdp->kd_bidang)}}.
									{{zerofy($item->id_kdp->kd_kelompok, 2)}}.
									{{zerofy($item->id_kdp->kd_subkelompok, 2)}}.
									{{zerofy($item->id_kdp->kd_subsubkelompok, 2)}}.
									{{$item->id_kdp->reg_barang}}
								</td>
								<td class="text-center">{{monefy($item->id_kdp->nilai)}}</td>
								<td class="text-center">{{datify($item->tgl_pelunasan, 'd/m/Y')}}</td>
								<td class="text-center"><button class="btn btn-danger" data-id="{{$item->id}}">Batalkan</button></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- KIB-D -->
				<div class="tab-pane active" id="kibd" role="tabpanel">
					<table class="table table-hover table-striped table-bordered table-sm">
						<thead>
							<tr class="small">
								<th class="text-center" rowspan="2">No.</th>
								<th class="text-center" colspan="2">Aset</th>
								<th class="text-center" colspan="2">KDP</th>
								<th class="text-center" rowspan="2">Tanggal Pelunasan</th>
								<th class="text-center" rowspan="2">Aksi</th>
							</tr>
							<tr class="small">
								<th class="text-center">Kode</th>
								<th class="text-center">Nilai</th>
								<th class="text-center">Kode</th>
								<th class="text-center">Nilai</th>
							</tr>
						</thead>
						<tbody>
							@if(empty($pelunasan['kibd']))
							<tr><td class="text-center" colspan="7">Data Kosong</td></tr>
							@endif

							@foreach($pelunasan['kibd'] AS $index=>$item)
							<tr>
								<td class="text-center">{{$index + 1}}</td>
								<td class="text-center">
									{{zerofy($item->id_aset->kd_golongan, 2)}}.
									{{zerofy($item->id_aset->kd_bidang)}}.
									{{zerofy($item->id_aset->kd_kelompok, 2)}}.
									{{zerofy($item->id_aset->kd_subkelompok, 2)}}.
									{{zerofy($item->id_aset->kd_subsubkelompok, 2)}}.
									{{$item->id_aset->reg_barang}}
								</td>
								<td class="text-center">{{monefy($item->id_aset->nilai)}}</td>
								<td class="text-center">
									{{zerofy($item->id_kdp->kd_golongan, 2)}}.
									{{zerofy($item->id_kdp->kd_bidang)}}.
									{{zerofy($item->id_kdp->kd_kelompok, 2)}}.
									{{zerofy($item->id_kdp->kd_subkelompok, 2)}}.
									{{zerofy($item->id_kdp->kd_subsubkelompok, 2)}}.
									{{$item->id_kdp->reg_barang}}
								</td>
								<td class="text-center">{{monefy($item->id_kdp->nilai)}}</td>
								<td class="text-center">{{datify($item->tgl_pelunasan, 'd/m/Y')}}</td>
								<td class="text-center"><button class="btn btn-danger" data-id="{{$item->id}}">Batalkan</button></td>
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
<div class="modal fade" tabindex="-1" role="dialog" id="modal-warning">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Perhatian!</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				Membatalkan transaski sama dengan menghapus data pelunasan (data aset dan KDP tidak hilang).
				Apakah anda yakin untuk melanjutkan?
			</div>
			<div class="modal-footer">
				<button class="btn btn-warning" data-dismiss="modal">Batal</button>
				<a href="#" id="btn-batal" class="btn btn-danger">Lanjutkan</a>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
	.small *{font-size: small!important;}
	th,td{vertical-align: middle!important;}
</style>
@end

@section('script')
<script type="text/javascript">
	theme.activeMenu('.nav-pelunasan');

	var site_url = "{{site_url()}}";
	var id_organisasi = {{$filter['id_organisasi']}};
	$("[data-id]").on("click", function(e){
		var id = $(e.currentTarget).data('id');
		$("#btn-batal").attr('href', site_url+'pelunasan/cancel?id='+id+"&id_organisasi="+id_organisasi);
		$("#modal-warning").modal('show');
	});

</script>
@end