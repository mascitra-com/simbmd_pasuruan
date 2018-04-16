@layout('commons/index')
@section('title')KIB-B@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="#">Aset</a></li>
<li class="breadcrumb-item"><a href="{{site_url('inventarisasi/kibb?id_organisasi='.$org->id)}}">KIB-B</a></li>
<li class="breadcrumb-item active">{{isset($kib)?'Sunting':'Tambah'}}</li>
@end

@section('content')
<?php
$status = isset($kib) && ($this->session->auth['is_superadmin'] != 1 OR !empty($kib->id_spk) OR !empty($kib->id_hibah));
$attr   = $status  ? 'disabled':'';
$attrInput = $status  ? 'readonly':'';
?>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kib)?'Sunting':'Tambah'}} Aset</div>
			<div class="card-body">
				<form action="{{isset($kib)?site_url('inventarisasi/kibb/update'):site_url('inventarisasi/kibb/insert')}}" method="POST">
					
					<input type="hidden" name="id" value="{{isset($kib)?$kib->id:''}}">
					<input type="hidden" name="id_organisasi" value="{{$org->id}}">
					
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kode Pemilik</label>
						<div class="col-md-4">
							<select name="kd_pemilik" class="form-control">
								<option value="">Pilih Kode Pemilik...</option>
								<option value="00"{{isset($kib)&&$kib->kd_pemilik==='00'?'selected':''}}>00 - Pemerintah Pusat</option>
								<option value="01"{{isset($kib)&&$kib->kd_pemilik==='01'?'selected':''}}>01 - Departemen Dalam Negeri</option>
								<option value="11"{{isset($kib)&&$kib->kd_pemilik==='11'?'selected':''}}>11 - Pemerintah Provinsi</option>
								<option value="12"{{isset($kib)&&$kib->kd_pemilik==='12'?'selected':''}}>12 - Pemerintah Kabupaten/Kota</option>
								<option value="22"{{isset($kib)&&$kib->kd_pemilik==='22'?'selected':''}}>22 - Desa</option>
								<option value="33"{{isset($kib)&&$kib->kd_pemilik==='33'?'selected':''}}>33 - BOT/BTO/BT</option>
								<option value="44"{{isset($kib)&&$kib->kd_pemilik==='44'?'selected':''}}>44 - Instansi Lainnya</option>
								<option value="98"{{isset($kib)&&$kib->kd_pemilik==='98'?'selected':''}}>98 - Extracomtable</option>
								<option value="99"{{isset($kib)&&$kib->kd_pemilik==='99'?'selected':''}}>99 - Lainnya</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">UPB</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$org->nama}}" disabled />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kode Barang</label>
						<div class="col-md-4">
							<div class="input-group">
								<select class="form-control" name="id_kategori" {{$attr}}>
									@if(isset($kib))
									<?php 
									$kt = $kib->id_kategori;
									$kd = $kt->kd_golongan.'.'.$kt->kd_bidang.'.'.$kt->kd_kelompok.'.'.$kt->kd_subkelompok.'.'.$kt->kd_subsubkelompok;
									?>
									<option value="{{$kt->id}}">{{$kd.' - '.$kt->nama}}</option>
									@endif
								</select>
								<span class="input-group-btn">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mod-kategori" {{$attr}}>pilih</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Ruangan</label>
						<div class="col-md-4">
							<select name="id_ruangan" class="form-control">
								<option value="">Pilih ruangan</option>
								@foreach($ruangan AS $ruang)
								<option value="{{$ruang->id}}" {{isset($kib) && $kib->id_ruangan === $ruang->id ? 'selected':''}}>{{$ruang->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Reg. Barang</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="reg_barang" placeholder="(otomatis)" value="{{isset($kib)?$kib->reg_barang:''}}" readonly/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Reg. Induk</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="reg_induk" placeholder="(otomatis)" value="{{isset($kib)?$kib->reg_induk:''}}" readonly/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Merk</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="merk" placeholder="merk" value="{{isset($kib)?$kib->merk:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tipe</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="tipe" placeholder="tipe" value="{{isset($kib)?$kib->tipe:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Ukuran/CC</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="ukuran" placeholder="ukuran" value="{{isset($kib)?$kib->ukuran:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Bahan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="bahan" placeholder="bahan" value="{{isset($kib)?$kib->bahan:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">No.Pabrik</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="no_pabrik" placeholder="nomor pabrik" value="{{isset($kib)?$kib->no_pabrik:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">No.Rangka</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="no_rangka" placeholder="nomor rangka" value="{{isset($kib)?$kib->no_rangka:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">No.Mesin</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="no_mesin" placeholder="nomor mesin" value="{{isset($kib)?$kib->no_mesin:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">No.Polisi</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="no_polisi" placeholder="nomor polisi" value="{{isset($kib)?$kib->no_polisi:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">No.BPKB</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="no_bpkb" placeholder="nomor bpkb" value="{{isset($kib)?$kib->no_bpkb:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Perolehan</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_perolehan" placeholder="Tanggal Perolehan" value="{{isset($kib)?datify($kib->tgl_perolehan, 'Y-m-d'):''}}" {{$attrInput}}/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Pembukuan</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_pembukuan" placeholder="Tanggal pembukuan" value="{{isset($kib)?datify($kib->tgl_pembukuan, 'Y-m-d'):date('Y-m-d')}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Asal Usul</label>
						<div class="col-md-4">
							<select class="form-control" name="asal_usul">
								<option value="Pembelian" {{isset($kib) && $kib->asal_usul == 'Pembelian'?'selected':''}}>Pembelian</option>
								<option value="Hibah" {{isset($kib) && $kib->asal_usul == 'Hibah'?'selected':''}}>Hibah</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kondisi</label>
						<div class="col-md-4">
							<select class="form-control" name="kondisi">
								<option value="1" {{isset($kib) && $kib->kondisi == 1?'selected':''}}>1. Baik</option>
								<option value="2" {{isset($kib) && $kib->kondisi == 2?'selected':''}}>2. Kurang Baik</option>
								<option value="3" {{isset($kib) && $kib->kondisi == 3?'selected':''}}>3. Rusak Berat</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nilai</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nilai" placeholder="Nilai" value="{{isset($kib)?monefy($kib->nilai):''}}" {{$attrInput}} required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nilai Sisa</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="nilai_sisa" placeholder="Nilai sisa" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Masa Manfaat</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="masa_manfaat" placeholder="masa manfaat" value="{{isset($kib)?$kib->masa_manfaat:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Keterangan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="{{isset($kib)?$kib->keterangan:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-secondary">Bersihkan</button>
							<a href="{{site_url('inventarisasi/kibb')}}" class="btn btn-warning">Kembali</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="mod-kategori">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pilih Kategori</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body px-0 py-0 scroll">
				<table id="tb-cari" class="table table-hover table-striped table-sm">
					<thead>
						<tr>
							<th class="text-center">No.</th>
							<th class="text-left">Kode</th>
							<th class="text-left">Nama</th>
							<th class="text-center">Aksi</th>
						</tr>
						<tr>
							<th colspan="4">
								<div class="input-group">
									<input type="text" id="in-cari" class="form-control" placeholder="Ketik nama barang...">
									<span class="input-group-btn">
										<button class="btn btn-primary" id="btn-cari"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-dismiss="modal">Pilih</button>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
	.small{font-size: .9em}
	.scroll{
		max-height: 450px!important;
		overflow-y: auto;!important;
	}
</style>
@end

@section('script')
<script type="text/javascript">
	var form = (function(){
		theme.activeMenu('.nav-invent');
		$("#btn-cari").on('click', fungsiCari);

		function fungsiCari(e) {
			var g = 2;
			var q = encodeURI($("#in-cari").val());
			var no = 1;
			var html = "";

			$.getJSON("{{site_url('kategori/get_json?q=')}}"+q+"&g="+g, function(result){
				html += "<tr><td class='text-center' colspan='4'>Menampilkan "+result.length+" data teratas</td></tr>";
				$.each(result, function(index, item){
					html += "<tr class='small'>";
					html += "<td class='text-center'>"+(no++)+"</td>";
					html += "<td class='text-center'>"+item.kode+"</td>";
					html += "<td class='text-left'>"+item.nama+"</td>";
					html += "<td class='text-center'><button class='btn btn-sm btn-primary' data-id="+item.id+" data-nama='"+item.nama+"'>pilih</button></td>";
					html += "</tr>";
				});
				$("#tb-cari tbody").empty().append(html);
			});
		}
		
		$("#tb-cari > tbody").delegate("button[data-id]", "click", function(e){
			var id   = $(e.currentTarget).data('id');
			var nama = $(e.currentTarget).data('nama');
			$("[name=id_kategori]").empty().append("<option value='"+id+"' selected>"+nama+"</option>");
			$(".modal").modal('hide');
		});

		$(".modal").on('hide.bs.modal', function(){
			$("#tb-cari tbody").empty();
			$("#tb-cari input").val("");
		});

	})();
</script>
@end