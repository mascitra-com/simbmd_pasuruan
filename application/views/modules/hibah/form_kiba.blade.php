@layout('commons/index')
@section('title')Hibah - Tambah Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('hibah?id_organisasi='.$hibah->id_organisasi)}}">Hibah</a></li>
<li class="breadcrumb-item"><a href="{{site_url('hibah/rincian/'.$hibah->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kib)?'Sunting':'Tambah'}} Aset Tanah</div>
			<div class="card-body">
				<form action="{{isset($kib)?site_url('aset/kiba/update_hibah'):site_url('aset/kiba/insert_hibah')}}" method="POST">
					<input type="hidden" name="id" value="{{isset($kib)?$kib->id:''}}">
					<input type="hidden" name="id_organisasi" value="{{$hibah->id_organisasi}}">
					<input type="hidden" name="id_hibah" value="{{$hibah->id}}">
					
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nomor Jurnal Hibah</label>
						<div class="col-md-4">
							<input type="text" class="form-control" value="{{$hibah->no_jurnal}}" disabled />
						</div>
					</div>
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
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mod-kategori">pilih</button>
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
						<label class="col-md-3 col-form-label text-right">Luas</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="luas" placeholder="Luas" value="{{isset($kib)?$kib->luas:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Alamat</label>
						<div class="col-md-4">
							<textarea class="form-control" name="alamat" placeholder="Alamat">{{isset($kib)?$kib->alamat:''}}</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Sertifikat</label>
						<div class="col-md-4 form-row">
							<input type="date" class="form-control col" name="sertifikat_tgl" placeholder="Tanggal Sertifikat" value="{{isset($kib)?datify($kib->sertifikat_tgl, 'Y-m-d'):''}}"/>
							<input type="text" class="form-control col" name="sertifikat_no" placeholder="No Sertifikat" value="{{isset($kib)?$kib->sertifikat_no:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Hak Tanah</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="hak" placeholder="Hak Tanah" value="{{isset($kib)?$kib->hak:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Pengguna</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="pengguna" placeholder="Pengguna" value="{{isset($kib)?$kib->pengguna:''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Serah Terima</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_perolehan" placeholder="Tanggal Perolehan" value="{{isset($kib)?datify($kib->tgl_perolehan, 'Y-m-d'):''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Tanggal Pembukuan</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_pembukuan" placeholder="Tanggal pembukuan" value="{{isset($kib)?datify($kib->tgl_pembukuan, 'Y-m-d'):''}}"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Asal Usul</label>
						<div class="col-md-4">
							<select class="form-control" name="asal_usul">
								<option value="pinjam" {{isset($kib) && $kib->asal_usul === 'pembelian'?'selected':''}}>Pembelian</option>
								<option value="pinjam" {{isset($kib) && $kib->asal_usul === 'hibah'?'selected':''}}>Hibah</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right">Nilai</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="nilai" placeholder="Nilai" value="{{isset($kib)?$kib->nilai:''}}" required/>
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
						<label class="col-md-3 col-form-label text-right">Kuantitas*</label>
						<div class="col-md-4">
							<input type="number" min="1" class="form-control" name="kuantitas" value="1" placeholder="Kuantitas"/>
							<p class="form-text text-muted">* Banyak data yang diinputkan akan sesuai dengan jumlah kuantitas</p>
						</div>
					</div>
					@endif
					<div class="form-group row">
						<label class="col-md-3 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Simpan</button>
							<button type="reset" class="btn btn-secondary">Bersihkan</button>
							<a href="{{site_url('hibah/rincian/'.$hibah->id)}}" class="btn btn-warning">Kembali</a>
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
			<div class="modal-body">
				<div class="row">
					<div class="form-group col">
						<label>Golongan</label>
						<select class="form-control" id="select-golongan">
							<option value="">Pilih Golongan</option>
							<option value="1">01 - Tanah</option>
						</select>
					</div>
					<div class="form-group col">
						<label>Bidang</label>
						<select class="form-control" id="select-bidang"></select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col">
						<label>Kelompok</label>
						<select class="form-control" id="select-kelompok"></select>
					</div>
					<div class="form-group col">
						<label>Sub-Kelompok</label>
						<select class="form-control" id="select-subkelompok"></select>
					</div>
				</div>
				<div class="form-group">
					<label>Sub Sub-Kelompok</label>
					<select class="form-control" id="select-subsubkelompok"></select>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" data-dismiss="modal">Pilih</button>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var form = (function(){

		theme.activeMenu('.nav-hibah');

		$("#select-golongan").on("change", fungsiGolongan);
		$("#select-bidang").on("change", fungsiBidang);
		$("#select-kelompok").on("change", fungsiKelompok);
		$("#select-subkelompok").on("change", fungsiSubKelompok);
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

		function fungsiGolongan(e) {
			var id = $("#select-golongan option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=2", function(result){
				$("#select-bidang").empty().append("<option value=''>Pilih Bidang...</option>");
				$.each(result, function(key, value){
					$("#select-bidang").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		function fungsiBidang(e) {
			var id = $("#select-bidang option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=3", function(result){
				$("#select-kelompok").empty().append("<option value=''>Pilih kelompok...</option>");
				$.each(result, function(key, value){
					$("#select-kelompok").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		function fungsiKelompok(e) {
			var id = $("#select-kelompok option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=4", function(result){
				$("#select-subkelompok").empty().append("<option value=''>Pilih sub-kelompok...</option>");
				$.each(result, function(key, value){
					$("#select-subkelompok").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		function fungsiSubKelompok(e) {
			var id = $("#select-subkelompok option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=5", function(result){
				$("#select-subsubkelompok").empty().append("<option value=''>Pilih sub sub-kelompok...</option>");
				$.each(result, function(key, value){
					$("#select-subsubkelompok").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		$("[data-dismiss]").click(function(){
			var id  = $("#select-subsubkelompok option:selected").val();
			var txt = $("#select-subsubkelompok option:selected").text();
			$("[name=id_kategori]").empty().append("<option value='"+id+"' selected>"+txt+"</option>");
		});
	})();
</script>
@end