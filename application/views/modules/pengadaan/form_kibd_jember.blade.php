@layout('commons/index')
@section('title')Pengadaan - Tambah Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kib)?'Sunting':'Tambah'}} Aset</div>
			<div class="card-body">
				<form action="{{isset($kib)?site_url('pengadaan/kibd/update'):site_url('pengadaan/kibd/insert')}}" method="POST">
					
					<input type="hidden" name="id" value="{{isset($kib)?$kib->id:''}}">
					<input type="hidden" name="id_organisasi" value="{{$spk->id_organisasi}}">
					<input type="hidden" name="id_spk" value="{{$spk->id}}">
					
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nomor SPK/Kontrak</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$spk->nomor}}" disabled />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Pilih SP2D</label>
						<div class="col-md-4">
							<select name="id_sp2d" class="form-control">
								@foreach($sp2d AS $item)
								<option value="{{$item->id}}">{{$item->nomor}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kode Pemilik</label>
						<div class="col-md-4">
							<select name="kd_pemilik" class="form-control">
								<option value="">Pilih Kode Pemilik...</option>
								<option value="00" {{isset($kib)&&$kib->kd_pemilik==='00'?'selected':''}}>00 - Pemerintah Pusat</option>
								<option value="01" {{isset($kib)&&$kib->kd_pemilik==='01'?'selected':''}}>01 - Departemen Dalam Negeri</option>
								<option value="11" {{isset($kib)&&$kib->kd_pemilik==='11'?'selected':''}}>11 - Pemerintah Provinsi</option>
								<option value="12" {{isset($kib)&&$kib->kd_pemilik==='12'?'selected':''}}>12 - Pemerintah Kabupaten/Kota</option>
								<option value="22" {{isset($kib)&&$kib->kd_pemilik==='22'?'selected':''}}>22 - Desa</option>
								<option value="33" {{isset($kib)&&$kib->kd_pemilik==='33'?'selected':''}}>33 - BOT/BTO/BT</option>
								<option value="44" {{isset($kib)&&$kib->kd_pemilik==='44'?'selected':''}}>44 - Instansi Lainnya</option>
								<option value="98" {{isset($kib)&&$kib->kd_pemilik==='98'?'selected':''}}>98 - Extracomtable</option>
								<option value="99" {{isset($kib)&&$kib->kd_pemilik==='99'?'selected':''}}>99 - Lainnya</option>
								@if($this->config->item('mode')==='jember')
								<option value="101" {{isset($kib)&&$kib->kd_pemilik==='101'?'selected':''}}>101 - Aset Lainnya</option>
								<option value="102" {{isset($kib)&&$kib->kd_pemilik==='102'?'selected':''}}>102 - Aset Rusak Berat</option>
								@endif
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kode Barang</label>
						<div class="col-md-4">
							<div class="input-group">
								<select class="form-control" name="id_kategori">
									@if(isset($kib))
									<?php 
									$kt = $kib->id_kategori;
									$kd = $kt->kd_golongan.'.'.$kt->kd_bidang.'.'.$kt->kd_kelompok.'.'.$kt->kd_subkelompok.'.'.$kt->kd_subsubkelompok;
									?>
									<option value="{{$kt->id}}">{{$kd.' - '.$kt->nama}}</option>
									@endif
								</select>
								<span class="input-group-btn">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mod-kategori" >pilih</button>
								</span>
							</div>
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
						<label class="col-md-3 col-form-label text-right">Kontruksi</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="kontruksi" placeholder="kontruksi" value="{{isset($kib)?$kib->kontruksi:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Panjang</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="panjang" placeholder="panjang" value="{{isset($kib)?$kib->panjang:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Lebar</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="lebar" placeholder="lebar" value="{{isset($kib)?$kib->lebar:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Luas</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="luas" placeholder="luas lantai" value="{{isset($kib)?$kib->luas:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Lokasi</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="lokasi" placeholder="lokasi" value="{{isset($kib)?$kib->lokasi:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tgl.Dokumen</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="dokumen_tgl" placeholder="tanggal dokumen" value="{{isset($kib)?datify($kib->dokumen_tgl, 'Y-m-d'):''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">No.Dokumen</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="dokumen_no" placeholder="nomor dokumen" value="{{isset($kib)?$kib->dokumen_no:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Status Tanah</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="status_tanah" placeholder="status tanah" value="{{isset($kib)?$kib->status_tanah:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kode Tanah</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="kode_tanah" placeholder="kode tanah" value="{{isset($kib)?$kib->kode_tanah:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Perolehan</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_perolehan" placeholder="Tanggal Perolehan" value="{{isset($kib)?datify($kib->tgl_perolehan, 'Y-m-d'):datify($spk->tgl_serah_terima,'Y-m-d')}}" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Pembukuan</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_pembukuan" placeholder="Tanggal pembukuan" value="{{isset($kib)?datify($kib->tgl_pembukuan, 'Y-m-d'):date('Y-m-d')}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Asal Usul</label>
						<div class="col-md-4">
							<select class="form-control" name="asal_usul">
								<option value="Pembelian" {{isset($kib) && $kib->asal_usul == 'pembelian'?'selected':''}}>Pembelian</option>
								<option value="Hibah" {{isset($kib) && $kib->asal_usul == 'hibah'?'selected':''}}>Hibah</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Kondisi</label>
						<div class="col-md-4">
							<select class="form-control" name="kondisi">
								<option value="1" {{isset($kib) && $kib->kondisi === 1?'selected':''}}>1. Baik</option>
								<option value="2" {{isset($kib) && $kib->kondisi === 2?'selected':''}}>2. Kurang Baik</option>
								<option value="3" {{isset($kib) && $kib->kondisi === 3?'selected':''}}>3. Rusak Berat</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Harga Satuan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nilai" placeholder="Nilai" value="{{isset($kib)?monefy($kib->nilai):''}}"  required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Keterangan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="{{isset($kib)?$kib->keterangan:''}}"/>
						</div>
					</div>
					@if(!isset($kib))
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Jumlah Barang*</label>
						<div class="col-md-4">
							<input type="number" min="1" class="form-control" name="kuantitas" value="1" placeholder="Jumlah Barang"/>
							<p class="form-text text-muted">* Banyak data yang diinputkan akan sesuai dengan jumlah kuantitas</p>
						</div>
					</div>
					@endif
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-secondary">Bersihkan</button>
							<a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}" class="btn btn-warning">Kembali</a>
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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pilih Kategori</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<select id="kd2" class="form-control">
							<option>Pilih Bidang</option>
						</select>
					</div>
					<div class="col">
						<select id="kd3" class="form-control">
							<option>Pilih Kelompok</option>
						</select>
					</div>
					<div class="col">
						<select id="kd4" class="form-control">
							<option>Pilih Sub-Kelompok</option>
						</select>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col">
						<select id="kd5" class="form-control">
							<option>Pilih Sub-Subkelompok</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" id="btn-pilih">Pilih</button>
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

		theme.activeMenu('.nav-pengadaan');
		$("[name=nilai]").on("change", fungsiNilai);
		$("[name=kuantitas]").on("change", fungsiNilai);

		function fungsiNilai(e)
		{
			var max = $("[name=nilai]").attr('max');
			var val = $("[name=nilai]").val();
			var qwt	= $("[name=kuantitas]").val();

			if (val * qwt > max) {
				alert('Nilai lebih banyak dari nilai sisa kontrak');
				$(e.currentTarget).val(0);
			}
		}

		// AMBIL kategori awal
		setKategori('#kd2', 4, 2);

		$("#kd2").on('change', function(e){
			setKategori('#kd3', $(e.target).val(), 3);
		});

		$("#kd3").on('change', function(e){
			setKategori('#kd4', $(e.target).val(), 4);
		});

		$("#kd4").on('change', function(e){
			setKategori('#kd5', $(e.target).val(), 5);
		});

		$("#btn-pilih").on('click', function(e){
			$("[name=id_kategori]").empty().append("<option value='"+$('#kd5').val()+"'>"+$('#kd5 option:selected').text()+"</option>");
			$(".modal").modal('hide');
		});

		function setKategori(target, subdari, jenis)
		{
			$.getJSON("{{site_url('kategori/get?sort=nama&order=asc&sub_dari=')}}"+subdari+"&jenis="+jenis, function(result){
				
				if (jenis === 3)
					$('#kd3').empty().append("<option>Pilih Kelompok</option>");
				if (jenis === 3 || jenis === 4)
					$('#kd4').empty().append("<option>Pilih Sub-Kelompok</option>");
				if (jenis === 3 || jenis === 4 || jenis === 5)
					$('#kd5').empty().append("<option>Pilih Sub-Subkelompok</option>");

				$.each(result, function(index, value){
					$(target).append("<option value='"+value.id+"'>"+value.nama+"</option>");
				});
			});
		}

	})();
</script>
@end