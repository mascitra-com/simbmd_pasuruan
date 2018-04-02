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
			KONSTRUKSI DALAM PENGERJAAN
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
						<th class="text-center">No.</th>
						<th class="text-center">Kode Barang &amp Reg Induk</th>
						<th class="text-center">Jenis/Nama</th>
						<th class="text-center">Kondisi</th>
						<th class="text-center">Tingkat</th>
						<th class="text-center">Beton</th>
						<th class="text-center">Panjang (M)</th>
						<th class="text-center">Lebar (M)</th>
						<th class="text-center">Luas (M2)</th>
						<th class="text-center">Lokasi</th>
						<th class="text-center">No. Dokumen</th>
						<th class="text-center">Tgl. Dokumen</th>
						<th class="text-center">Status Tanah</th>
						<th class="text-center">Reg. Tanah</th>
						<th class="text-center">Asal-Usul/Tahun Pengadaan</th>
						<th class="text-center">Nilai (Rp.)</th>
						<th class="text-center">Keterangan</th>
					</tr>
					<tr>
						@for($i=1;$i <= 17; $i++)<td class="text-center small bold">{{$i}}</td>@endfor
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
							<td class="text-right pr-3" colspan="15">SUB TOTAL TAHUN {{$tahun_now}}</td>
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
							{{zerofy($aset->kd_golongan).'.'.zerofy($aset->kd_bidang).'.'.zerofy($aset->kd_kelompok).'.'.zerofy($aset->kd_subkelompok).'.'.zerofy($aset->kd_subsubkelompok).'.'.zerofy($aset->reg_barang,4)}}
							<br>
							{{$aset->reg_induk}}
						</td>
						<td class="text-center">{{$aset->nama}}</td>
						<td class="text-center">{{$aset->kondisi==='1'?'B':($aset->kondisi==='2'?'KB':'RB')}}</td>
						<td class="text-center">{{$aset->tingkat==='1'?'Iya':($aset->tingkat==='0'?'Tidak':'-')}}</td>
						<td class="text-center">{{$aset->beton==='1'?'Iya':($aset->beton==='0'?'Tidak':'-')}}</td>
						<td class="text-center">{{$aset->panjang}}</td>
						<td class="text-center">{{$aset->lebar}}</td>
						<td class="text-center">{{$aset->luas}}</td>
						<td class="text-center">{{$aset->lokasi}}</td>
						<td class="text-center">{{$aset->dokumen_no}}</td>
						<td class="text-center text-nowrap">{{datify($aset->dokumen_tgl,'d-m-Y')}}</td>
						<td class="text-center">{{$aset->status_tanah}}</td>
						<td class="text-center">{{$aset->kode_tanah}}</td>
						<td class="text-center">{{$aset->asal_usul}}<br>{{datify($aset->tgl_perolehan, 'Y')}}</td>
						<td class="text-right">{{monefy($aset->nilai + $aset->nilai_tambah)}}</td>
						<td>{{$aset->keterangan}}</td>
					</tr>
					<?php
						$jumlah += $aset->nilai + $aset->nilai_tambah;
						$sub_jumlah += $aset->nilai + $aset->nilai_tambah;
					?>
					@endforeach

					<!-- CETAK SUB TOTAL-->
					@if(!empty($rekap) && $detail['urut']==='2')
						@if(@tahun !== datify($aset->tgl_perolehan, 'Y'))
						<tr class="small bold">
							<td class="text-right pr-3" colspan="15">SUB TOTAL TAHUN {{$tahun_now}}</td>
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
						<td class="text-right pr-3" colspan="15">TOTAL</td>
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