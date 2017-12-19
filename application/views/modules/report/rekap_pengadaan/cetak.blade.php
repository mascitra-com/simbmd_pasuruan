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
						<th class="text-center small bold">KD. BARANG</th>
						<th class="text-center small bold">REG. INDUK</th>
						<th class="text-center small bold">NAMA BARANG</th>
						<th class="text-center small bold">MERK/TIPE</th>
						<th class="text-center small bold">JUMLAH</th>
						<th class="text-center small bold">NILAI(Rp.)</th>
						<th class="text-center small bold">NILAI SPK/KONTRAK(Rp.)</th>
						<th class="text-center small bold">SP2D/SPM/SPMU</th>
						<th class="text-center small bold">REK.BELANJA</th>
						<th class="text-center small bold">NILAI BELANJA(Rp.)</th>
					</tr>
					<tr>
						<tr>
						@for($i=1;$i <= 11;$i++)
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
					@foreach($rekap AS $spk)
					<tr>
						<td colspan="11" class="small">
							<span class="ml-3">No. SPK/SP/DOK: {{$spk->nomor}}</span>
							<span class="ml-3">Rekanan: {{$spk->nama_perusahaan}}</span>
						</td>
					</tr>
					<!-- ASET -->
					@foreach($spk->rincian->aset AS $aset)
					<tr class="small">
						<td class="text-center">{{$no++}}</td>
						<td class="text-center">{{$aset->kd_bidang.'.'.$aset->kd_golongan.'.'.$aset->kd_kelompok.'.'.$aset->kd_subkelompok.'.'.$aset->kd_subsubkelompok.'.'.zerofy($aset->reg_barang,4)}}</td>
						<td class="text-center">{{$aset->reg_induk}}</td>
						<td>{{$aset->nama}}</td>
						<td class="text-center">{{$aset->merk}}</td>
						<td class="text-center">{{$aset->jumlah}} unit</td>
						<td class="text-right">{{monefy($aset->nilai)}}</td>
						<td></td>
						<td class="text-center">{{($row < count($spk->sp2d)) ? $spk->sp2d[$row]->nomor : ''}}</td>
						<td class="text-center">{{($row < count($spk->sp2d)) ? $spk->sp2d[$row]->kode_rekening : ''}}</td>
						<td class="text-right">{{($row < count($spk->sp2d)) ? monefy($spk->sp2d[$row]->nilai) : ''}}</td>
						<?php 
							$sub_rincian += $aset->nilai;
							$sub_sp2d 	 += ($row < count($spk->sp2d)) ? $spk->sp2d[$row]->nilai : 0;
							$row++;
						?>
					</tr>
					@endforeach
					<!-- NON ASET -->
					@foreach($spk->rincian->non_aset AS $non_aset)
					<tr class="small">
						<td class="text-center">{{$no++}}</td>
						<td class="text-center">-</td>
						<td>-</td>
						<td>{{$non_aset->nama}}</td>
						<td class="text-center">{{$non_aset->merk}}</td>
						<td class="text-center">1 unit</td>
						<td class="text-right">{{monefy($non_aset->nilai)}}</td>
						<td></td>
						<td class="text-center">{{($row < count($spk->sp2d)) ? $spk->sp2d[$row]->nomor : ''}}</td>
						<td class="text-center">{{($row < count($spk->sp2d)) ? $spk->sp2d[$row]->kode_rekening : ''}}</td>
						<td class="text-right">{{($row < count($spk->sp2d)) ? monefy($spk->sp2d[$row]->nilai) : ''}}</td>
						<?php 
							$sub_rincian += $non_aset->nilai;
							$sub_sp2d 	 += ($row < count($spk->sp2d)) ? $spk->sp2d[$row]->nilai : 0;
							$row++;
						?>
					</tr>
					@endforeach
					<!-- KAPITALISASI -->
					@foreach($spk->rincian->kapitalisasi AS $kap)
					<tr class="small">
						<td class="text-center">{{$no++}}</td>
						<td class="text-center">{{$aset->kd_bidang.'.'.$aset->kd_golongan.'.'.$aset->kd_kelompok.'.'.$aset->kd_subkelompok.'.'.$aset->kd_subsubkelompok}}</td>
						<td class="text-center">{{$aset->reg_induk}}</td>
						<td>{{$kap->judul}}</td>
						<td class="text-center">{{$kap->merk}}</td>
						<td class="text-center">{{$kap->jumlah}} unit</td>
						<td class="text-right">{{monefy($kap->nilai)}}</td>
						<td></td>
						<td class="text-center">{{($row < count($spk->sp2d)) ? $spk->sp2d[$row]->nomor : ''}}</td>
						<td class="text-center">{{($row < count($spk->sp2d)) ? $spk->sp2d[$row]->kode_rekening : ''}}</td>
						<td class="text-right">{{($row < count($spk->sp2d)) ? monefy($spk->sp2d[$row]->nilai) : ''}}</td>
						<?php 
							$sub_rincian += $kap->nilai;
							$sub_sp2d 	 += ($row < count($spk->sp2d)) ? $spk->sp2d[$row]->nilai : 0;
							$row++;
						?>
					</tr>
					@endforeach
					<!-- SUBTOTAL -->
					<tr class="small bold">
						<td colspan="6" class="text-right">SUB TOTAL <span class="mr-3"></span></td>
						<td class="text-right">{{monefy($sub_rincian)}}</td>
						<td class="text-right">{{monefy($spk->nilai)}}</td>
						<td colspan="2"></td>
						<td class="text-right">{{monefy($sub_sp2d)}}</td>
					</tr>
					<?php
						$tot_rincian += $sub_rincian;
						$tot_sp2d 	 += $sub_sp2d;
						$sub_rincian  = $sub_sp2d = $row = 0;
					?>
					@endforeach
					<!-- TOTAL -->
					<tr class="small bold">
						<td colspan="6" class="text-right">TOTAL <span class="mr-3"></span></td>
						<td class="text-right">{{monefy($tot_rincian)}}</td>
						<td class="text-right"></td>
						<td colspan="2"></td>
						<td class="text-right">{{monefy($tot_sp2d)}}</td>
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