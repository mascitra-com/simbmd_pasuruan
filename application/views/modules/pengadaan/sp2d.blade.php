@layout('commons/index')
@section('title')Pengadaan - Rincian@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item active">SP2D</li>
@end

@section('content')
<div class="form-inline">
	<div class="btn-group mb-3">
		<a href="{{site_url('pengadaan/index/detail/'.$spk->id)}}" class="btn btn-primary">01. Detail Pengadaan</a>
		<a href="{{site_url('pengadaan/sp2d/index/'.$spk->id)}}" class="btn btn-primary active">02. SP2D</a>
		<a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}" class="btn btn-primary">03. Rincian Aset</a>
	</div>
	<div class="btn-group mb-3 ml-auto">
        @if($spk->status_pengajuan === '0' OR $spk->status_pengajuan === '3')
        <a href="{{site_url('pengadaan/index/finish_transaction/'.$spk->id)}}" class="btn btn-success" onclick="return confirm('Anda yakin? Data tidak dapat disunting jika telah diajukan.')"><i class="fa fa-check mr-2"></i>Selesaikan Transaksi</a>
        @elseif($spk->status_pengajuan === '1')
        <a href="{{site_url('pengadaan/index/cancel_transaction/'.$spk->id)}}" class="btn btn-warning" onclick="return confirm('Anda yakin?')"><i class="fa fa-check mr-2"></i>Batalkan Pengajuan</a>
        @endif
    </div>
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
						<?php $nilai_kontrak = ($spk->addendum_nilai != 0) ? $spk->addendum_nilai : $spk->nilai ?>
						<div class="col">Nilai Kontrak</div><div class="col"> : {{monefy($nilai_kontrak)}}</div>
						<div class="w-100"></div>
						<div class="col">Total SP2D</div><div class="col"> : {{monefy($sp2d['total'])}}</div>
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
				@if($spk->status_pengajuan === '0' OR $spk->status_pengajuan === '3')
				<button class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="fa fa-plus"></i> Tambah SP2D</button>
				@endif
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
							@if($spk->status_pengajuan === '0' OR $spk->status_pengajuan === '3')
							<th class="text-center">Aksi</th>
							@endif
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
							@if($spk->status_pengajuan === '0' OR $spk->status_pengajuan === '3')
							<td class="text-center text-nowrap btn-group">
								<button class="btn btn-warning btn-sm" data-id="{{$data->id}}"><i class="fa fa-pencil"></i></button>
								<a href="{{site_url('pengadaan/sp2d/delete/'.$data->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
							</td>
							@endif
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
						<form action="{{site_url('pengadaan/sp2d/insert')}}" method="POST">
							<input type="hidden" name="id">
							<input type="hidden" name="id_spk" value="{{$spk->id}}">
							<div class="form-group">
								<label>Nomor SP2D</label>
								<input type="text" class="form-control form-control-sm" name="nomor" placeholder="Nomor" required/>
							</div>
							<div class="form-group">
								<label>Tanggal</label>
								<input type="date" class="form-control form-control-sm" name="tanggal" value="{{date('Y-m-d')}}" placeholder="Tanggal"/>
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
@end

@section('script')
<script>
	var sp2d = (function(){
		
		theme.activeMenu('.nav-pengadaan');

		$("[data-id]").on("click", fungsiTombolEdit);
		$("#tb-search").on("click", fungsiTombolCari);
		$("#tbl-rekening").delegate("[data-rek]", "click", fungsiTombolRekening);
		$("#modal-tambah").on('hidden.bs.modal', reset);

		function fungsiTombolRekening(e) {
			$('[name=kode_rekening]').val($(e.currentTarget).data('rek'));
		}

		function fungsiTombolCari(e) {
			var key = $("#ip-search").val();
			$.getJSON("{{site_url('rekening/get_data_search?key=')}}"+key, function(result){
				$("#tbl-rekening > tbody").empty();
				$("#tbl-rekening > tbody").append("<tr><td colspan='2' class='text-center'><b>menampilkan "+result.length+" data teratas</b></td></tr>");
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

		function fungsiTombolEdit(e) {
			var id = $(e.currentTarget).data('id');
			$("#modal-tambah form").attr('action', "{{site_url('pengadaan/sp2d/update')}}");
			$("#modal-tambah form input[name=id]").val(id);
			$.getJSON("{{site_url('pengadaan/sp2d/get/')}}"+id, function(result){
				if (result) {
					$("[name=nomor]").val(result.nomor);
					$("[name=tanggal]").val(result.tanggal);
					$("[name=kode_rekening]").val(result.kode_rekening);
					$("[name=nilai]").val(result.nilai);
					$("[name=keterangan]").val(result.keterangan);
				}
			});
			$("#modal-tambah").modal('show');
			
		}

		function reset() {
			$("#modal-tambah form").attr('action', "{{site_url('pengadaan/sp2d/insert')}}");
			$("#modal-tambah form").trigger('reset');
			$("#tbl-rekening > tbody").empty();
		}
	})();
	
</script>
@end

