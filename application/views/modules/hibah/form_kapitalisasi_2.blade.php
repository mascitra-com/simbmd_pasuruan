@layout('commons/index')
@section('title')Hibah - Tambah Nilai Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('hibah?id_organisasi='.$hibah->id_organisasi)}}">Hibah</a></li>
<li class="breadcrumb-item"><a href="{{site_url('hibah/rincian/'.$hibah->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Nilai Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Tambah Nilai Aset (Langkah 2)</div>
			<div class="card-body table-responsive table-scroll px-0 py-0">
				@if($golongan === '3')
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-nowrap text-center">Aksi</th>
							<th class="text-nowrap text-center">Kode Barang</th>
							<th class="text-nowrap">Tingkat</th>
							<th class="text-nowrap">Beton</th>
							<th class="text-nowrap">Luas Lantai</th>
							<th class="text-nowrap">Lokasi</th>
							<th class="text-nowrap">Tgl.Dokumen</th>
							<th class="text-nowrap">No.Dokumen</th>
							<th class="text-nowrap">Status Tanah</th>
							<th class="text-nowrap">Kode Tanah</th>
							<th class="text-nowrap">Tgl. Pembuatan</th>
							<th class="text-nowrap">Tgl. Pembukuan</th>
							<th class="text-nowrap">Asal Usul</th>
							<th class="text-nowrap">Kondisi</th>
							<th class="text-nowrap text-right">Nilai</th>
							<th class="text-nowrap text-right">Nilai Sisa</th>
							<th class="text-nowrap">Masa Manfaat</th>
							<th class="text-nowrap">Keterangan</th>
							<th class="text-nowrap">Kategori</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kib))
						<tr><td colspan="19" class="text-center"><b><i>Data kosong</i></b></td></tr>
						@endif

						@foreach($kib AS $item)
						<tr>
							<td class="text-nowrap text-center">
								<a href="{{site_url('kapitalisasi/add_hibah/langkah_3/'.$hibah->id.'?id_aset='.$item->id.'&golongan=3&subsubkelompok='.$subsubkelompok)}}" class="btn btn-primary btn-sm">Pilih</a>
							</td>
							<td class="text-nowrap text-center">
								{{zerofy($item->id_kategori->kd_golongan)}} .
								{{zerofy($item->id_kategori->kd_bidang)}} .
								{{zerofy($item->id_kategori->kd_kelompok)}} .
								{{zerofy($item->id_kategori->kd_subkelompok)}} .
								{{zerofy($item->id_kategori->kd_subsubkelompok)}} .
								{{zerofy($item->reg_barang,4)}}
							</td>
							<td class="text-nowrap">{{($item->tingkat > 0) ? '<span class="badge badge-success">Ya</span>' : '<span class="badge badge-danger">Tidak</span>'}}</td>
							<td class="text-nowrap">{{($item->beton > 0) ? "<span class='badge badge-success'>Ya</span>" : "<span class='badge badge-danger'>Tidak</span>"}}</td>
							<td class="text-nowrap">{{$item->luas_lantai}}</td>
							<td class="text-nowrap">{{$item->lokasi}}</td>
							<td class="text-nowrap">{{$item->dokumen_tgl}}</td>
							<td class="text-nowrap">{{$item->dokumen_no}}</td>
							<td class="text-nowrap">{{$item->status_tanah}}</td>
							<td class="text-nowrap">{{$item->kode_tanah}}</td>
							<td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
							<td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
							<td class="text-nowrap">{{$item->asal_usul}}</td>
							<td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
							<td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
							<td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
							<td class="text-nowrap">{{$item->masa_manfaat}}</td>
							<td class="text-nowrap">{{$item->keterangan}}</td>
							<td class="text-nowrap">{{$item->id_kategori->nama}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-nowrap text-center">Aksi</th>
							<th class="text-nowrap text-center">Kode Barang</th>
							<th class="text-nowrap">Kontruksi</th>
							<th class="text-nowrap">Panjang</th>
							<th class="text-nowrap">Lebar</th>
							<th class="text-nowrap">Luas</th>
							<th class="text-nowrap">Lokasi</th>
							<th class="text-nowrap">Tgl.Dokumen</th>
							<th class="text-nowrap">No.Dokumen</th>
							<th class="text-nowrap">Status Tanah</th>
							<th class="text-nowrap">Kode Tanah</th>
							<th class="text-nowrap">Tgl. Pembuatan</th>
							<th class="text-nowrap">Tgl. Pembukuan</th>
							<th class="text-nowrap">Asal Usul</th>
							<th class="text-nowrap">Kondisi</th>
							<th class="text-nowrap text-right">Nilai</th>
							<th class="text-nowrap text-right">Nilai Sisa</th>
							<th class="text-nowrap">Masa Manfaat</th>
							<th class="text-nowrap">Keterangan</th>
							<th class="text-nowrap">Kategori</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kib))
						<tr><td colspan="20" class="text-center"><b><i>Data kosong</i></b></td></tr>
						@endif

						@foreach($kib AS $item)
						<tr>
							<td class="text-nowrap text-center">
								<a href="{{site_url('kapitalisasi/add_hibah/langkah_3/'.$hibah->id.'?id_aset='.$item->id.'&golongan=4&subsubkelompok='.$subsubkelompok)}}" class="btn btn-primary btn-sm">Pilih</a>
							</td>
							<td class="text-nowrap text-center">
								{{zerofy($item->id_kategori->kd_golongan)}} .
								{{zerofy($item->id_kategori->kd_bidang)}} .
								{{zerofy($item->id_kategori->kd_kelompok)}} .
								{{zerofy($item->id_kategori->kd_subkelompok)}} .
								{{zerofy($item->id_kategori->kd_subsubkelompok)}} .
								{{zerofy($item->reg_barang,4)}}
							</td>
							<td class="text-nowrap">{{$item->kontruksi}}</td>
							<td class="text-nowrap">{{$item->panjang}}</td>
							<td class="text-nowrap">{{$item->lebar}}</td>
							<td class="text-nowrap">{{monefy($item->luas)}}</td>
							<td class="text-nowrap">{{$item->lokasi}}</td>
							<td class="text-nowrap">{{$item->dokumen_tgl}}</td>
							<td class="text-nowrap">{{$item->dokumen_no}}</td>
							<td class="text-nowrap">{{$item->status_tanah}}</td>
							<td class="text-nowrap">{{$item->kode_tanah}}</td>
							<td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
							<td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
							<td class="text-nowrap">{{$item->asal_usul}}</td>
							<td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td>
							<td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
							<td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
							<td class="text-nowrap">{{$item->masa_manfaat}}</td>
							<td class="text-nowrap">{{$item->keterangan}}</td>
							<td class="text-nowrap">{{$item->id_kategori->nama}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@endif
			</div>
		</div>
		<a href="{{site_url('kapitalisasi/add_hibah/langkah_1/'.$hibah->id)}}" class="btn btn-warning mt-3">Kembali</a>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var form = (function(){
		theme.activeMenu('.nav-hibah');
	})();
</script>
@end