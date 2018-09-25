<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Aset Tetap</title>
	<link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
	<style type="text/css">
		.container{
			margin: 0;
		}
		.header{font-size: .8em}
		.bold{font-weight: bold;}
		.small{font-size: .8em;}
		.title{
			width: 100%;
			text-align: center;
		}
		td.text-left{padding-left: 20px!important;}
		@media print{@page {size:landscape;}}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="title bold mb-4">
			LAPORAN PENGADAAN<br>
			{{datify($detail['periode_start'])}} s.d. {{datify($detail['periode_end'])}}
		</div>
		<div class="header">
			<table>
				<tr><td class="bold">PROVINSI</td><td>:</td><td>JAWA TIMUR</td></tr>
				<tr><td class="bold">KABUPATEN</td><td>:</td><td>{{strtoupper($detail['nama_kota'])}}</td></tr>
				<tr><td class="bold">UPB</td><td>:</td><td>{{$detail['upb']}}</td></tr>
			</table>
		</div>
		<div class="mt-3">
			<table class="table table-bordered table-sm">
				<thead>
					<tr>
						<th class="text-center small bold">KD. BARANG</th>
						<th class="text-center small bold">NAMA BARANG</th>
						<th class="text-center small bold">NILAI(Rp.)</th>
					</tr>
					<tr>
						<tr>
						@for($i=1;$i <= 3;$i++)
						<th class="text-center small bold">{{$i}}</th>
						@endfor
						</tr>
					</tr>
				</thead>
				<tbody>
					<?php 
						$total = 0;
					?>
					@foreach($rekap AS $r)
					<tr>
						<td class="text-center">{{zerofy($r['kd1'], 2).'.'.zerofy($r['kd2'], 2).'.'.zerofy($r['kd3'], 2)}}</td>
						<td class="text-left">{{$r['nama']}}</td>
						<td class="text-right">{{monefy($r['jumlah'])}}</td>
						<?php $total += $r['jumlah']; ?>
					</tr>
					@endforeach
					<tr class="bold">
						<td colspan="2" class="text-right">TOTAL</td>
						<td class="text-right">{{monefy($total)}}</td>
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