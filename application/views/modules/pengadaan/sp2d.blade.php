@layout('commons/index')
@section('title')Pengadaan - Rincian@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item active">SP2D</li>
@end

@section('content')
<div class="btn-group mb-3">
	<a href="{{site_url('pengadaan/detail/'.$spk->id)}}" class="btn btn-primary">01. Detail SPK</a>
	<a href="{{site_url('pengadaan/rincian/'.$spk->id)}}" class="btn btn-primary">02. Rincian Aset</a>
	<a href="{{site_url('pengadaan/sp2d/'.$spk->id)}}" class="btn btn-primary active">03. SP2D</a>
</div>
<div class="row mb-3">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Kontrak</div>
			<div class="card-body row">
				<div class="col">
					<div class="row">
						<div class="col">No. Kontrak</div><div class="col"> : {{$spk->nomor}}</div>
						<div class="w-100"></div>
						<div class="col">Tanggal Kontrak</div><div class="col"> : {{datify($spk->tanggal, 'd/m/Y')}}</div>
						<div class="w-100"></div>
						<div class="col">Jangka Waktu</div><div class="col"> : {{$spk->jangka_waktu}} Bulan</div>
					</div>
				</div>
				<div class="col">
					<div class="row">
						<?php $nilai_kontrak = (!empty($spk->addendum_nilai)) ? $spk->addendum_nilai : $spk->nilai ?>
						<div class="col">Nilai Kontrak</div><div class="col"> : {{monefy($nilai_kontrak)}},00</div>
						<div class="w-100"></div>
						<div class="col">Total Rincian</div><div class="col"> : </div>
						<div class="w-100"></div>
						<div class="col">Total SP2D</div><div class="col"> : {{monefy($sp2d['total'])}},00</div>
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
			<div class="card-header form-inline">
				<span class="mr-auto">SP2D</span>
				<button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah SP2D</button>
			</div>
			<div class="card-body table-responsive px-0 py-0">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center text-nowrap">No. SP2D</th>
							<th>Tanggal</th>
							<th>No. Rekening</th>
							<th class="text-right" width="20%">Nilai</th>
							<th>Keterangan</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($sp2d['data'] AS $data)
						<tr>
							<td class="text-center">{{$data->nomor}}</td>
							<td>{{datify($data->tanggal,'d/m/Y')}}</td>
							<td>{{$data->kode_rekening}}</td>
							<td class="text-right">{{monefy($data->nilai)}}</td>
							<td>{{$data->keterangan}}</td>
							<td class="text-center text-nowrap btn-group">
								<button class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></button>
								<a href="{{site_url('pengadaan/delete_sp2d/'.$data->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tambah">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Form SP2D</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<form action="{{site_url('pengadaan/insert_sp2d')}}" method="POST">
							<input type="hidden" name="id">
							<input type="hidden" name="id_spk" value="{{$spk->id}}">
							<div class="form-group">
								<label>Nomor SP2D</label>
								<input type="text" class="form-control form-control-sm" name="nomor" placeholder="Nomor" required/>
							</div>
							<div class="form-group">
								<label>Tanggal</label>
								<input type="date" class="form-control form-control-sm" name="tanggal" placeholder="Tanggal" />
							</div>
							<div class="form-group">
								<label>Kode Rekening Belanja</label>
								<input type="text" class="form-control form-control-sm" name="kode_rekening" placeholder="Kode Rekening Belanja" readonly />
							</div>
							<div class="form-group">
								<label>Nilai</label>
								<input type="number" class="form-control form-control-sm" name="nilai" placeholder="Nilai" required/>
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<textarea class="form-control form-control-sm" name="keterangan" placeholder="Keterangan"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Simpan</button>
								<button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
							</div>
						</form>
					</div>
					<div class="col-8 table-responsive col-scroll">
						<table class="table table-bordered table-sm" id="tbl-rekening">
							<thead>
								<tr>
									<th>No. Rek</th>
									<th>Deskripsi</th>
									<th></th>
								</tr>
								<tr>
									<th colspan="3">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Cari Rekening..." id="ip-search">
											<div class="input-group-btn">
												<button class="btn btn-primary" id="tb-search"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style type="text/css">
	.col-scroll {
		max-height: 450px!important;
		overflow-y: auto;!important;
	}
</style>
@endsection

@section('script')
<script>
	var sp2d = (function(){
		
		theme.activeMenu('.nav-pengadaan');

		$("#tb-search").on("click", fungsiTombolCari);
		$("#tbl-rekening").delegate("[data-rek]", "click", fungsiTombolRekening);

		function fungsiTombolRekening(e) {
			$('[name=kode_rekening]').val($(e.currentTarget).data('rek'));
		}

		function fungsiTombolCari(e) {
			var key = $("#ip-search").val();
			$.getJSON("{{site_url('rekening/get_data_search?key=')}}"+key, function(result){
				$("#tbl-rekening > tbody").empty();
				$.each(result, function(key, value){
					var html = "<tr>";
					html += "<td>"+value.kode+"</td>";
					html += "<td>"+value.uraian+"</td>";
					html += "<td><button class='btn btn-secondary btn-sm btn-block' data-rek='"+value.kode+"'>Pilih</button></td>";
					html += "</tr>";

					$("#tbl-rekening > tbody").append(html);
				});
			});
		}
	})();
	
</script>
@endsection

