<?php $kepemilikan = array(
	"00"=>"Pemerintah Pusat",
	"01"=>"Departemen Dalam Negeri",
	"11"=>"Pemerintah Provinsi",
	"12"=>"Pemerintah Kabupaten/Kota",
	"22"=>"Desa",
	"33"=>"BOT/BTO/BT",
	"44"=>"Instansi Lainnya",
	"98"=>"Extracomtable",
	"99"=>"Lainnya" ); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rekapitulasi Kartu Inventaris Barang</title>
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
			KARTU INVENTARIS BARANG KIB - {{strtoupper($detail['kib'])}}<br>
			TANAH
			<br>
			{{$detail['header']}}
		</div>
		<div class="header">
			<table style="width:50%">
				<tr class="small"><td class="bold" width="15%">Provinsi</td><td width="5%">:</td><td>JAWA TIMUR</td></tr>
				<tr class="small"><td class="bold" width="15%">Kabupaten</td><td width="5%">:</td><td>{{strtoupper($detail['nama_kota'])}}</td></tr>
				<tr class="small"><td class="bold" width="15%">UPB</td><td width="5%">:</td><td>{{$detail['upb']}}</td></tr>
				<tr class="small"><td class="bold" width="15%">Kepemilikan</td><td width="5%">:</td><td>{{$kepemilikan[$detail['kd_pemilik']]}}</td></tr>
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
						<th rowspan="2" class="text-center">Ukuran/CC</th>
						<th rowspan="2" class="text-center">Bahan</th>
						<th rowspan="2" class="text-center">Tahun Pengadaan</th>
						<th rowspan="2" class="text-center">No. Rangka</th>
						<th rowspan="2" class="text-center">No. Mesin</th>
						<th rowspan="2" class="text-center">No. Polisi</th>
						<th rowspan="2" class="text-center">No. BPKB</th>
						<th colspan="3" class="text-center">Kondisi</th>
						<th rowspan="2" class="text-center">Jumlah</th>
						<th rowspan="2" class="text-center">Asal-Usul</th>
						<th rowspan="2" class="text-center">Nilai (Rp.)</th>
						<th rowspan="2" class="text-center">Keterangan</th>
					</tr>
					<tr class="small">
						<th class="text-center">Baik</th>
						<th class="text-center">Kurang Baik</th>
						<th class="text-center">Rusak Berat</th>
					</tr>
					<tr>
						@for($i=1;$i <= 18; $i++)<td class="text-center small bold">{{$i}}</td>@endfor
					</tr>
				</thead>
				<tbody>
					<?php 
						$no = $jumlah = $sub_jumlah = 0;
						$tahun_now = !empty($rekap) ? datify($rekap[0]->tgl_perolehan, 'Y') : 0; 
					?>
					@foreach($rekap AS $index=>$aset)
					
					<!-- CETAK SUB TOTAL-->
					@if($detail['urut']==='2')
						@if($tahun_now !== datify($aset->tgl_perolehan, 'Y'))
						<tr class="small bold">
							<td class="text-right pr-3" colspan="16">SUB TOTAL TAHUN {{$tahun_now}}</td>
							<td class="text-right">{{monefy($sub_jumlah)}}</td>
							<td></td>
						</tr>
						<?php 
							$tahun_now  =  datify($aset->tgl_perolehan, 'Y');
							$sub_jumlah = 0;
						?>
						@endif
					@endif

					<tr class="small">
						<td class="text-center">{{++$no}}</td>
						<td class="text-center">
							{{$aset->kd_bidang.'.'.$aset->kd_golongan.'.'.$aset->kd_kelompok.'.'.$aset->kd_subkelompok.'.'.$aset->kd_subsubkelompok.'.'.zerofy($aset->reg_barang,4)}}
							<br>
							{{$aset->reg_induk}}
						</td>
						<td>{{$aset->nama}}</td>
						<td class="text-center">{{$aset->merk.' '.$aset->tipe}}</td>
						<td class="text-center">{{$aset->ukuran}}</td>
						<td class="text-center">{{$aset->bahan}}</td>
						<td class="text-center">{{datify($aset->tgl_perolehan, 'Y')}}</td>
						<td class="text-center">{{$aset->no_rangka}}</td>
						<td class="text-center">{{$aset->no_mesin}}</td>
						<td class="text-center">{{$aset->no_polisi}}</td>
						<td class="text-center">{{$aset->no_bpkb}}</td>
						<td class="text-center">{{$aset->kb}}</td>
						<td class="text-center">{{$aset->kkb}}</td>
						<td class="text-center">{{$aset->krb}}</td>
						<td class="text-center">{{$aset->jumlah}}</td>
						<td class="text-center">{{$aset->asal_usul}}</td>
						<td class="text-right">{{monefy($aset->nilai_total)}}</td>
						<td>{{$aset->keterangan}}</td>
					</tr>
					<?php
						$jumlah += $aset->nilai_total;
						$sub_jumlah += $aset->nilai_total;
					?>
					@endforeach

					<!-- CETAK SUB TOTAL-->
					@if($index > 0 && $detail['urut']==='2')
						@if(@tahun !== datify($aset->tgl_perolehan, 'Y'))
						<tr class="small bold">
							<td class="text-right pr-3" colspan="16">SUB TOTAL TAHUN {{$tahun_now}}</td>
							<td class="text-right">{{monefy($sub_jumlah)}}</td>
							<td></td>
						</tr>
						<?php 
							$tahun_now  =  datify($aset->tgl_perolehan, 'Y');
							$sub_jumlah = 0;
						?>
						@endif
					@endif

					<!-- CETAK TOTAL -->
					<tr class="small bold">
						<td class="text-right pr-3" colspan="16">TOTAL</td>
						<td class="text-right">{{monefy($jumlah)}}</td>
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