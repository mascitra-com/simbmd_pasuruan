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
		@media print{@page {size:landscape;}}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="title bold mb-4">
			LAPORAN PENGHAPUSAN<br>
			{{datify($detail['periode_start'])}} s.d. {{datify($detail['periode_end'])}}
		</div>
		<div class="header">
			<table>
				<tr><td class="bold">PROVINSI</td><td>:</td><td>JAWA TIMUR</td></tr>
				<tr><td class="bold">KABUPATEN</td><td>:</td><td>{{strtoupper($detail['nama_kota'])}}</td></tr>
				<tr><td class="bold">UPB</td><td>:</td><td>{{$detail['upb']}}</td></tr>
				<tr><td class="bold">KETERANGAN</td><td>:</td><td>{{isset($detail['keterangan']) ? $detail['keterangan'] : '-'}}</td></tr>
			</table>
		</div>
		<div class="mt-3">
			<table class="table table-bordered table-sm">
				<thead>
					<tr>
						<th class="text-center small bold">NO.</th>
						<th class="text-center small bold">KD. BARANG</th>
						<th class="text-center small boldz">REG. INDUK</th>
						<th class="text-center small bold">NAMA BARANG</th>
						<th class="text-center small bold">MERK/TIPE</th>
						<th class="text-center small bold">KONDISI</th>
						<th class="text-center small bold">JUMLAH</th>
						<th class="text-center small bold">NILAI(Rp.)</th>
					</tr>
					<tr>
						<tr>
						@for($i=1;$i <= 8;$i++)
						<th class="text-center small bold">{{$i}}</th>
						@endfor
						</tr>
					</tr>
				</thead>
				<tbody>
					<?php 
						$no  = 1; 
						$row = $sub_rincian = $sub_sp2d = $tot_rincian = $tot_sp2d = 0;
					?>
					@foreach($rekap AS $penghapusan)
					<tr>
						<td colspan="8" class="small">
							<span class="ml-3">No. Jurnal: {{$penghapusan->no_jurnal}}</span>
							<span class="ml-3">Tgl. Jurnal: {{datify($penghapusan->tgl_jurnal)}}</span>
							<span class="ml-3">No. SK: {{$penghapusan->no_sk}}</span>
							<span class="ml-3">Tgl. SK: {{datify($penghapusan->tgl_sk)}}</span>
							<span class="ml-3">Keterangan: {{$penghapusan->keterangan}}</span>
							<span class="ml-3">Alasan: {{$penghapusan->alasan}}</span>
						</td>
					</tr>
					<!-- ASET -->
					@foreach($penghapusan->rincian->aset AS $aset)
					<tr class="small">
						<td class="text-center">{{$no++}}</td>
						<td class="text-center">{{$aset->kd_bidang.'.'.$aset->kd_golongan.'.'.$aset->kd_kelompok.'.'.$aset->kd_subkelompok.'.'.$aset->kd_subsubkelompok.'.'.zerofy($aset->reg_barang,4)}}</td>
						<td class="text-center">{{$aset->reg_induk}}</td>
						<td>{{$aset->nama}}</td>
						<td class="text-center">{{$aset->merk}}</td>
                        <td class="text-center">{{($aset->kondisi==1)?'B':(($aset->kondisi==2)?'KB':'RB')}}</td>
                        <td class="text-center">{{$aset->jumlah}} unit</td>
						<td class="text-right">{{monefy($aset->nilai)}}</td>
						<?php
							$sub_rincian += $aset->nilai;
							$row++;
						?>
					</tr>
					@endforeach
					<!-- SUBTOTAL -->
					<tr class="small bold">
						<td colspan="7" class="text-right">SUB TOTAL <span class="mr-3"></span></td>
						<td class="text-right">{{monefy($sub_rincian)}}</td>
					</tr>
					<?php
						$tot_rincian += $sub_rincian;
						$tot_sp2d 	 += $sub_sp2d;
						$sub_rincian  = $sub_sp2d = $row = 0;
					?>
					@endforeach
					<!-- TOTAL -->
					<tr class="small bold">
						<td colspan="7" class="text-right">TOTAL <span class="mr-3"></span></td>
						<td class="text-right">{{monefy($tot_rincian)}}</td>
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