<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Non Aset</title>
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
			REKAPITULASI NON ASET<br>{{$detail['header']}}
		</div>
		<div class="header">
			<table style="width:50%">
				<tr class="small"><td class="bold" width="15%">Provinsi</td><td width="5%">:</td><td>JAWA TIMUR</td></tr>
				<tr class="small"><td class="bold" width="15%">Kabupaten</td><td width="5%">:</td><td>{{strtoupper($detail['nama_kota'])}}</td></tr>
				<tr class="small"><td class="bold" width="15%">UPB</td><td width="5%">:</td><td>{{$detail['upb']}}</td></tr>
			</table>
		</div>
		<div class="mt-3">
			<table class="table table-bordered table-sm">
				<thead>
					<tr class="small">
						<th class="text-center">No.</th>
						<th class="text-center">Nama Barang</th>
						<th class="text-center">Merk</th>
						<th class="text-center">Tipe</th>
						<th class="text-center">Thn. Pengadaan</th>
						<th class="text-center">Jumlah</th>
						<th class="text-right text-nowrap">Nilai Satuan (Rp.)</th>
						<th class="text-right">Nilai (Rp.)</th>
						<th class="text-center">Keterangan</th>
					</tr>
					<tr>
						@for($i=1;$i <= 9; $i++)<td class="text-center small bold">{{$i}}</td>@endfor
					</tr>
				</thead>
				<tbody>
					<?php $total  = $sum = 0; ?>
					@foreach($rekap AS $index=>$item)
					<tr class="small">
						<td class="text-center">{{$index+1}}</td>
						<td class="text-center">{{$item->nama}}</td>
						<td class="text-center">{{$item->merk}}</td>
						<td class="text-center">{{$item->tipe}}</td>
						<td class="text-center">{{datify($item->tgl_serah_terima, 'Y')}}</td>
						<td class="text-center">{{monefy($item->jumlah_barang)}}</td>
						<td class="text-right">{{monefy($item->nilai)}}</td>
						<td class="text-right">{{monefy($item->jumlah_nilai)}}</td>
						<td class="text-center">{{$item->keterangan}}</td>
					</tr>
					<?php 
					$total += $item->jumlah_barang;
					$sum += $item->jumlah_nilai;
					?>
					@endforeach
					<!-- CETAK TOTAL -->
					<tr class="small bold">
						<td class="text-right pr-3" colspan="5">TOTAL</td>
						<td class="text-center">{{monefy($total)}}</td>
						<td></td>
						<td class="text-right">{{monefy($sum)}}</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="mt-3">
			<table style="width: 100%">
				<tr>
					<td class="text-center small" width="50%"></td>
					<td class="text-center small" width="50%">{{$detail['nama_kota']}}, {{datify($detail['tanggal'],'d/m/Y')}}</td>
				</tr>
				<tr>
					<td class="text-center small">Mengetahui</td>
					<td class="text-center small">Yang Melaporkan</td>
				</tr>
				<tr>
					<td class="text-center small">{{strtoupper($detail['mengetahui_jabatan'])}}</td>
					<td class="text-center small">{{strtoupper($detail['lapor_jabatan'])}}</td>
				</tr>
				<tr>
					<td class="py-4"></td>
					<td class="py-4"></td>
				</tr>
				<tr>
					<td class="text-center small">{{strtoupper($detail['mengetahui_nama'])}}</td>
					<td class="text-center small">{{strtoupper($detail['lapor_nama'])}}</td>
				</tr>
				<tr>
					<td class="text-center small">{{strtoupper($detail['mengetahui_nip'])}}</td>
					<td class="text-center small">{{strtoupper($detail['lapor_nip'])}}</td>
				</tr>
			</table>
		</div>
	</div>
	<script>
		window.print();
	</script>
</body>
</html>