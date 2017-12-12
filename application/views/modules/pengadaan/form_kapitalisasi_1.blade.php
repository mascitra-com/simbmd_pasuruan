@layout('commons/index')
@section('title')Pengadaan - Tambah Nilai Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/rincian/'.$spk->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Nilai Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Tambah Nilai Aset (Langkah 1)</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						<form action="{{site_url('kapitalisasi/add_pengadaan/langkah_2/'.$spk->id)}}" method="GET" class="form-row">
							<div class="form-group col-6">
								<label>01. Golongan</label>
								<select class="form-control" name="golongan" id="golongan">
									<option value="">Pilih Golongan. . .</option>
									<option value="3">03. Gedung &amp Bangunan</option>
									<option value="4">04. Jalan, Irigasi, &amp Jaringan</option>
								</select>
							</div>
							<div class="form-group col-6">
								<label>02. Bidang</label>
								<select class="form-control" id="bidang"></select>
							</div>
							<div class="form-group col-6">
								<label>03. Kelompok</label>
								<select class="form-control" id="kelompok"></select>
							</div>
							<div class="form-group col-6">
								<label>04. Sub-Kelompok</label>
								<select class="form-control" id="subkelompok"></select>
							</div>
							<div class="form-group col-12">
								<label>05. Sub Sub-Kelompok</label>
								<select class="form-control" id="subsubkelompok" name="subsubkelompok"></select>
							</div>
							<div class="form-group col-12">
								<a href="" class="btn btn-warning">Kembali</a>
								<button class="btn btn-primary">Lanjut</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var form = (function(){
		theme.activeMenu('.nav-pengadaan');

		$("#golongan").on("change", fungsiGolongan);
		$("#bidang").on("change", fungsiBidang);
		$("#kelompok").on("change", fungsiKelompok);
		$("#subkelompok").on("change", fungsiSubKelompok);

		function fungsiGolongan(e) {
			var id = $("#golongan option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=2", function(result){
				$("#bidang").empty().append("<option value=''>Pilih Bidang...</option>");
				$.each(result, function(key, value){
					$("#bidang").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		function fungsiBidang(e) {
			var id = $("#bidang option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=3", function(result){
				$("#kelompok").empty().append("<option value=''>Pilih kelompok...</option>");
				$.each(result, function(key, value){
					$("#kelompok").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		function fungsiKelompok(e) {
			var id = $("#kelompok option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=4", function(result){
				$("#subkelompok").empty().append("<option value=''>Pilih sub-kelompok...</option>");
				$.each(result, function(key, value){
					$("#subkelompok").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}

		function fungsiSubKelompok(e) {
			var id = $("#subkelompok option:selected").val();
			$.getJSON("{{site_url('kategori/get_by?')}}"+"sub_dari="+id+"&jenis=5", function(result){
				$("#subsubkelompok").empty().append("<option value=''>Pilih sub sub-kelompok...</option>");
				$.each(result, function(key, value){
					$("#subsubkelompok").append("<option value='"+value.id+"'>"+value.kode+" - "+value.nama+"</option>");
				});
			});
		}
	})();
</script>
@end