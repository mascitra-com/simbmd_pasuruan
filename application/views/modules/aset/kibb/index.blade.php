@layout('commons/index')
@section('title')KIB-B@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('aset')}}">Aset</a></li>
<li class="breadcrumb-item active">KIB-B</li>
@end

@section('widget')
<div class="row mb-4">
	@foreach($statistic AS $stat)
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">{{$stat['title']}}</h4>
				<p class="card-text">{{$stat['value']}}</p>
			</div>
		</div>
	</div>
	@endforeach
</div>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<form action="{{site_url('aset/kibb')}}" method="GET" class="mr-auto">
					<div class="input-group">
						<select name="id_organisasi" class="form-control select-chosen" data-placeholder="Pilih UPB...">
							<option></option>
							@foreach($organisasi AS $org)
							<option value="{{$org->id}}" {{isset($filter['id_organisasi']) && $org->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$org->nama}}</option>
							@endforeach
						</select>
						<span class="input-group-btn">
							<button class="btn btn-primary">Pilih</button>
						</span>
					</div>
				</form>
				<div class="btn-group">
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button>
					<a href="{{site_url('aset/kibb/add/'.$filter['id_organisasi'])}}" class="btn btn-primary"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body table-responsive table-scroll px-0 py-0">
				<table class="table table-hover table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-nowrap text-center">Aksi</th>
							<th class="text-nowrap text-center">Kode Barang</th>
							<th class="text-nowrap">Merk</th>
							<th class="text-nowrap">Tipe</th>
							<th class="text-nowrap">Ukuran/CC</th>
							<th class="text-nowrap">Bahan</th>
							<th class="text-nowrap">No.Pabrik</th>
							<th class="text-nowrap">No.Rangka</th>
							<th class="text-nowrap">No.Mesin</th>
							<th class="text-nowrap">No.Polisi</th>
							<th class="text-nowrap">No.BPKB</th>
							<th class="text-nowrap">Tgl. Pembuatan</th>
							<th class="text-nowrap">Tgl. Pembukuan</th>
							<th class="text-nowrap">Asal Usul</th>
							<th class="text-nowrap">Kondisi</th>
							<th class="text-nowrap text-right">Nilai</th>
							<th class="text-nowrap text-right">Nilai Sisa</th>
							<th class="text-nowrap">Masa Manfaat</th>
							<th class="text-nowrap">Keterangan</th>
							<th class="text-nowrap">Ruang</th>
							<th class="text-nowrap">Kategori</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($kib))
						<tr><td colspan="21" class="text-center"><b><i>Data kosong</i></b></td></tr>
						@endif

						@foreach($kib AS $item)
						<tr>
							<td class="text-nowrap text-center">
								<div class="btn-group">
									<a href="{{site_url('aset/kibb/edit/'.$item->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
									<a href="{{site_url('aset/kibb/delete/'.$item->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i></a>
								</div>
							</td>
							<td class="text-nowrap text-center">
								{{zerofy($item->id_kategori->kd_golongan)}} .
								{{zerofy($item->id_kategori->kd_bidang)}} .
								{{zerofy($item->id_kategori->kd_kelompok)}} .
								{{zerofy($item->id_kategori->kd_subkelompok)}} .
								{{zerofy($item->id_kategori->kd_subsubkelompok)}} .
								{{zerofy($item->reg_barang,4)}}
							</td>
							<td class="text-nowrap">{{$item->merk}}</td>
							<td class="text-nowrap">{{$item->tipe}}</td>
							<td class="text-nowrap">{{$item->ukuran}}</td>
							<td class="text-nowrap">{{$item->bahan}}</td>
							<td class="text-nowrap">{{$item->no_pabrik}}</td>
							<td class="text-nowrap">{{$item->no_rangka}}</td>
							<td class="text-nowrap">{{$item->no_mesin}}</td>
							<td class="text-nowrap">{{$item->no_polisi}}</td>
							<td class="text-nowrap">{{$item->no_bpkb}}</td>
							<td class="text-nowrap">{{datify($item->tgl_perolehan, 'd-m-Y')}}</td>
							<td class="text-nowrap">{{datify($item->tgl_pembukuan, 'd-m-Y')}}</td>
							<td class="text-nowrap">{{$item->asal_usul}}</td>
							<td class="text-nowrap">{{$item->kondisi}}</td>
							<!-- <td class="text-nowrap">{{($item->kondisi==1)?'Baik':(($item->kondisi==2)?'Kurang Baik':'Rusak Berat')}}</td> -->
							<td class="text-nowrap text-right">{{monefy($item->nilai)}}</td>
							<td class="text-nowrap text-right">{{!empty($item->nilai_sisa)?monefy($item->nilai_sisa):'0'}}</td>
							<td class="text-nowrap">{{$item->masa_manfaat}}</td>
							<td class="text-nowrap">{{$item->keterangan}}</td>
							<td class="text-nowrap">{{$item->id_ruangan}}</td>
							<td class="text-nowrap">{{$item->id_kategori->nama}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer">{{$pagination}}</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-filter">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Filter data</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('aset/kibb')}}" method="GET">
					<input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
					<div class="row">
						<div class="form-group col">
							<label>Reg Barang</label>
							<input type="text" class="form-control" name="reg_barang" value="{{isset($filter['reg_barang'])?$filter['reg_barang']:''}}" />
						</div>
						<div class="form-group col">
							<label>Merk</label>
							<input type="text" class="form-control" name="merk" value="{{isset($filter['merk'])?$filter['merk']:''}}" />
						</div>
						<div class="form-group col">
							<label>Tipe</label>
							<input type="text" class="form-control" name="tipe" value="{{isset($filter['tipe'])?$filter['tipe']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Ukuran</label>
							<input type="text" class="form-control" name="ukuran" value="{{isset($filter['ukuran'])?$filter['ukuran']:''}}" />
						</div>
						<div class="form-group col">
							<label>Bahan</label>
							<input type="text" class="form-control" name="bahan" value="{{isset($filter['bahan'])?$filter['bahan']:''}}" />
						</div>
						<div class="form-group col">
							<label>No. Pabrik</label>
							<input type="text" class="form-control" name="no_pabrik" value="{{isset($filter['no_pabrik'])?$filter['no_pabrik']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>No.Rangka</label>
							<input type="text" class="form-control" name="no_rangka" value="{{isset($filter['no_rangka'])?$filter['no_rangka']:''}}" />
						</div>
						<div class="form-group col">
							<label>No.Mesin</label>
							<input type="text" class="form-control" name="no_mesin" value="{{isset($filter['no_mesin'])?$filter['no_mesin']:''}}" />
						</div>
						<div class="form-group col">
							<label>No.Polisi</label>
							<input type="text" class="form-control" name="no_polisi" value="{{isset($filter['no_polisi'])?$filter['no_polisi']:''}}" />
						</div>
						<div class="form-group col">
							<label>No.BPKB</label>
							<input type="text" class="form-control" name="no_bpkb" value="{{isset($filter['no_bpkb'])?$filter['no_bpkb']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Asal Usul</label>
							<input type="text" class="form-control" name="asal_usul" value="{{isset($filter['asal_usul'])?$filter['asal_usul']:''}}" />
						</div>
						<div class="form-group col">
							<label>Kondisi</label>
							<input type="text" class="form-control" name="kondisi" value="{{isset($filter['kondisi'])?$filter['kondisi']:''}}" />
						</div>
						<div class="form-group col">
							<label>Keterangan</label>
							<input type="text" class="form-control" name="keterangan" value="{{isset($filter['keterangan'])?$filter['keterangan']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Nilai</label>
							<input type="text" class="form-control" name="nilai" value="{{isset($filter['nilai'])?$filter['nilai']:''}}" />
						</div>
						<div class="form-group col">
							<label>Nilai Sisa</label>
							<input type="text" class="form-control" name="nilai_sisa" value="{{isset($filter['nilai_sisa'])?$filter['nilai_sisa']:''}}" />
						</div>
						<div class="form-group col">
							<label>Masa Manfaat</label>
							<input type="text" class="form-control" name="masa_manfaat" value="{{isset($filter['masa_manfaat'])?$filter['masa_manfaat']:''}}" />
						</div>
					</div>
					<div class="row">
						<div class="form-group col">
							<label>Tanggal Pembuatan</label>
							<input type="text" class="form-control" name="tgl_perolehan" value="{{isset($filter['tgl_perolehan'])?$filter['tgl_perolehan']:''}}" />
						</div>
						<div class="form-group col">
							<label>Jumlah Tampilan Data</label>
							<select name="limit" class="form-control">
								<option value="20">20</option>
								<option value="50">50</option>
								<option value="100">100</option>
								<option value="300">300</option>
							</select>
						</div>
						<div class="form-group col">
							<label>Urutkan Berdasar</label>
							<select name="ord_by" class="form-control">
								<option value="reg_barang">Reg Barang</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Filter</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Kembali</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var kib = (function(){
		theme.activeMenu('.nav-invent');
	})();
</script>
@end
