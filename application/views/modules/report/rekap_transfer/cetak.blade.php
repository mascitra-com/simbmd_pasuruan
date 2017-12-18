<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Transfer Keluar</title>
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
						<th class="text-center small bold">NO.</th>
						<th class="text-center small bold">KD. BARANG/REG. INDUK</th>
						<th class="text-center small bold">NAMA/MERK/TIPE</th>
						<th class="text-center small bold">JUMLAH SATUAN</th>
						<th class="text-center small bold">HARGA SATUAN(Rp.)</th>
						<th class="text-center small bold">HARGA TOTAL(Rp.)</th>
						<th class="text-center small bold">KETERANGAN (UKURAN, NOPOL, NO. RANGKA, NO.MESIN)</th>
					</tr>
					<tr>
						<tr>
						@for($i=1;$i <= 7;$i++)
						<th class="text-center small bold">{{$i}}</th>
						@endfor
						</tr>
					</tr>
				</thead>
				<tbody>
					@foreach($rekap AS $no=>$data)
						<tr class="bold">
							<td>{{$no+1}}</td>
							<td colspan="6">{{$data->nama}}</td>
						</tr>
						@foreach($data->transfer AS $transfer)
							<tr class="small bold">
								<td colspan="7">
									<span class="mr-5 ml-5">No. BA Serah Terima: {{$transfer->serah_terima_no}}</span>
									<span class="mr-5">Tanggal: {{datify($transfer->serah_terima_tgl,'d/m/Y')}}</span>
									<span class="mr-5">Nomor Jurnal: {{$transfer->jurnal_no}}</span>
									<span>Tanggal: {{datify($transfer->jurnal_tgl,'d/m/Y')}}</span>
								</td>
							</tr>
							@foreach($transfer->rincian AS $index=>$rincian)
							<tr class="small">
								<td>{{$index+1}}</td>
								<td>{{$rincian->kd_barang.'.'.zerofy($rincian->reg_barang,4)}}<br>{{$rincian->reg_induk}}</td>
								<td>{{$rincian->nama}}</td>
								<td>1 Unit</td>
								<td>{{monefy($rincian->nilai)}}</td>
								<td>{{monefy($rincian->nilai)}}</td>
								<td>{{$rincian->keterangan}}</td>
							</tr>
							@endforeach
						@endforeach
					@endforeach
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
		// window.print();
	</script>
</body>
</html>