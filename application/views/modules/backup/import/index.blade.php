@layout('commons/index')
@section('title')Beranda@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('backup')}}">Backup</a></li>
<li class="breadcrumb-item active">Import Saldo Awal</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Import Saldo Awal</h4>
				<p class="card-text">Import saldo awal ke SIMBMD Pasuruan.<br>Format data harus sesuai dengan format export excel dari database SQL SIMDA.</p>
				<div class="mb-5"></div>
				<form action="{{site_url('backup/import/upload')}}" method="POST" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Jenis Aset</label>
						<div class="col-md-4">
							<select name="kib" class="form-control">
								<option value="">Pilih Jenis KIB...</option>
								<option value="a">KIB-A</option>
								<option value="b">KIB-B</option>
								<option value="c">KIB-C</option>
								<option value="d">KIB-D</option>
								<option value="e">KIB-E</option>
								<option value="f">KIB-F</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">UPB</label>
						<div class="col-md-4">
							<select class="select-chosen" name="kd_upb">
								<option></option>
								@foreach($organisasi AS $org)
								<option value="{{$org->id}}">{{$org->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih Berkas</label>
						<div class="col-md-4">
							<input type="file" class="form-control" name="berkas" accept=".xls, .xlsx" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right"></label>
						<div class="col-md-4">
							<p class="help-text">* Maksimal ukuran file adalah 1,5MB</p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right"></label>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary"><i class="fa fa-upload mr-2"></i> Unggah</button>
							<button type="reset" class="btn btn-warning"><i class="fa fa-refresh mr-2"></i> Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script>
	var imports = (function(){
		theme.activeMenu('.nav-dashboard');

		var urls = "{{site_url('organisasi/get/')}}";

		$("[name=kd_bidang]").on('change', fungsiBidang);
		$("[name=kd_unit]").on('change', fungsiUnit);
		$("[name=kd_subunit]").on('change', fungsiSubunit);

		function fungsiBidang(e) {
			var id = $(e.currentTarget).find('option:selected').val();
			$.getJSON(urls+id, function(result){
				$("[name=kd_unit]").empty().append("<option value=''>Pilih Unit...</option>");
				$.each(result, function(index,item){
					$("[name=kd_unit]").append("<option value='"+item.id+"'>"+(index+1)+". "+item.nama+"</option>");
				});
			});
		}

		function fungsiUnit(e) {
			var id = $(e.currentTarget).find('option:selected').val();
			$.getJSON(urls+id, function(result){
				$("[name=kd_subunit]").empty().append("<option value=''>Pilih Sub-unit...</option>");
				$.each(result, function(index,item){
					$("[name=kd_subunit]").append("<option value='"+item.id+"'>"+(index+1)+". "+item.nama+"</option>");
				});
			});
		}

		function fungsiSubunit(e) {
			var id = $(e.currentTarget).find('option:selected').val();
			$.getJSON(urls+id, function(result){
				$("[name=kd_upb]").empty().append("<option value=''>Pilih UPB...</option>");
				$.each(result, function(index,item){
					$("[name=kd_upb]").append("<option value='"+item.id+"'>"+(index+1)+". "+item.nama+"</option>");
				});
			});
		}
	})();
</script>
@end