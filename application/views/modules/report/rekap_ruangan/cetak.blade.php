<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Kartu Inventaris Ruangan</title>
	<link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
	<style type="text/css">
	.container{
		margin: 0;
	}
	.header{font-size: .9em}
	.bold{font-weight: bold;}
	.small{font-size: .8em;}
	.title{
		width: 100%;
		text-align: center;
	}
	@media print{@page {size:landscape;}}
</style>
</head>
<body>
	<div class="container-fluid">
		<div class="title bold mt-4">
			KARTU INVENTARIS RUANGAN
			<br>
			{{$detail['header']}}
		</div>
		<div class="header">
			<table style="width:50%">
				<tr class="small"><td class="bold" width="15%">Provinsi</td><td width="5%">:</td><td>JAWA TIMUR</td></tr>
				<tr class="small"><td class="bold" width="15%">Kabupaten</td><td width="5%">:</td><td>{{strtoupper($detail['nama_kota'])}}</td></tr>
				<tr class="small"><td class="bold" width="15%">UPB</td><td width="5%">:</td><td>{{$upb['nama']}}</td></tr>
				<tr class="small"><td class="bold" width="15%">Ruangan</td><td width="5%">:</td><td>{{strtoupper($ruangan['nama'])}}</td></tr>
			</table>
		</div>
		<div class="mt-3">
			<table class="table table-bordered table-sm">
				<thead>
					<tr class="small">
						<th rowspan="2" class="text-center">No.</th>
						<th rowspan="2" class="text-center">Kode Barang/Reg Induk</th>
						<th rowspan="2" class="text-center">Jenis/Nama</th>
						<th rowspan="2" class="text-center">Merk/Tipe</th>
						<th rowspan="2" class="text-center">Ukuran</th>
						<th rowspan="2" class="text-center">Tahun Perolehan</th>
						<th colspan="3" class="text-center">Kondisi</th>
						<th rowspan="2" class="text-center">Jumlah</th>
						<th rowspan="2" class="text-center">Keterangan</th>
					</tr>
					<tr class="small">
						<th class="text-center">Baik</th>
						<th class="text-center">Kurang Baik</th>
						<th class="text-center">Rusak Berat</th>
					</tr>
					<tr>
						@for($i=1;$i <= 11; $i++)<td class="text-center small bold">{{$i}}</td>@endfor
					</tr>
				</thead>
				<tbody>
					<?php 
						$no = $jumlah = $sub_jumlah = 0;
						$tahun_now = !empty($rekap) ? datify($rekap[0]->tgl_perolehan, 'Y') : 0; 
					?>
					@foreach($rekap AS $index=>$aset)
					
					<!-- CETAK SUB TOTAL-->
					<tr class="small">
						<td class="text-center">{{++$no}}</td>
						<td class="text-center">{{$aset->kd_bidang.'.'.$aset->kd_golongan.'.'.$aset->kd_kelompok.'.'.$aset->kd_subkelompok.'.'.$aset->kd_subsubkelompok.'.'.zerofy($aset->reg_barang,4)}}</td>
						<td>{{$aset->nama}}</td>
						<td class="text-center">{{$aset->merk.' '.$aset->tipe}}</td>
						<td class="text-center">{{$aset->ukuran}}</td>
						<td class="text-center">{{$aset->tgl_perolehan == '0000-00-00 00:00:00' ? '-' : datify($aset->tgl_perolehan, 'Y')}}</td>
						<td class="text-center">{{$aset->kb}}</td>
						<td class="text-center">{{$aset->kkb}}</td>
						<td class="text-center">{{$aset->krb}}</td>
						<td class="text-center">{{$aset->jumlah}}</td>
						<td>{{$aset->keterangan}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="mt-3">
			<table style="width: 100%">
				<tr>
					<td width="50%"></td>
					<td class="text-center small" width="50%">{{$detail['nama_kota']}}, {{datify($detail['tanggal'],'d/m/Y')}}</td>
				</tr>
				<tr>
					<td></td>
					<td class="text-center small">Penanggung Jawab</td>
				</tr>
				<tr>
					<td></td>
					<td class="text-center small">{{strtoupper($detail['penanggung_jabatan'])}}</td>
				</tr>
				<tr>
					<td></td>
					<td class="py-4"></td>
				</tr>
				<tr>
					<td></td>
					<td class="text-center small">{{strtoupper($detail['penanggung_nama'])}}</td>
				</tr>
				<tr>
					<td></td>
					<td class="text-center small">{{strtoupper($detail['penanggung_nip'])}}</td>
				</tr>
			</table>
		</div>
	</div>
	<script>
		window.print();
	</script>
</body>
</html>