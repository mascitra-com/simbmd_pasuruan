@layout('commons/index')
@section('title')Pengadaan - SP2D@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('persetujuan/pengadaan/index?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item active">SP2D</li>
@end

@section('content')
<div class="form-inline">
	<div class="btn-group mb-3">
		<a href="{{site_url('persetujuan/pengadaan/detail/'.$spk->id)}}" class="btn btn-primary">01. Detail Pengadaan</a>
        <a href="{{site_url('persetujuan/pengadaan/sp2d/'.$spk->id)}}" class="btn btn-primary active">02. SP2D</a>
        <a href="{{site_url('persetujuan/pengadaan/rincian/'.$spk->id)}}" class="btn btn-primary">03. Rincian Aset</a>
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
						</tr>
						@endforeach
					</tbody>
				</table>
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
		theme.activeMenu('.nav-persetujuan-pengadaan');
	})();
	
</script>
@endsection