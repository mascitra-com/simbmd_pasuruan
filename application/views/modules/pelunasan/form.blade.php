@layout('commons/index')
@section('title')Pelunasan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pelunasan?id_organisasi='.$id_organisasi)}}">Pelunasan</a></li>
<li class="breadcrumb-item active">Tambah</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Tambah Pelunasan</div>
			<div class="card-body">
				<form action="{{site_url('pelunasan/insert')}}" method="POST">
					<input type="hidden" name="id_organisasi" value="{{$id_organisasi}}">
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih Jenis Aset</label>
						<div class="col-md-4">
							<select name="kib" class="form-control">
								<option value="a" selected>01. Jalan</option>
								<option value="c">03. Gedung &amp Bangunan</option>
								<option value="d">04. Jalan, Irigasi &amp Jaringan</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">KDP</label>
						<div class="col-md-4">
							<div class="input-group">
								<select name="id_kdp" class="form-control"></select>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#md-cari-kdp">pilih</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Aset Yang Dilunasi</label>
						<div class="col-md-4">
							<div class="input-group">
								<select name="id_aset" class="form-control"></select>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#md-cari-aset">pilih</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Tanggal Pelunasan</label>
						<div class="col-md-4">
							<input type="date" name="tgl_pelunasan" value="{{date('Y-m-d')}}" class="form-control" placeholder="Tanggal Pelunasan"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right"></label>
						<div class="col-md-4">
							<div class="form-check form-check-inline">
								<label class="form-check-label">
									<input class="form-check-input" type="checkbox" name="akumulasi_kdp" value="1"> Akumulasi nilai KDP
								</label>
							</div>
							<p class="form-text"></p>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right"></label>
						<div class="col-md-4">
							<button class="btn btn-primary" type="submit" onclick="return confirm('Apakah data sudah benar?')"><i class="fa fa-check"></i> Simpan</button>
							<a href="{{site_url('Pelunasan?id_organisasi='.$id_organisasi)}}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="md-cari-aset">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">Pilih Aset Yang Dilunasi</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body table-responsive px-0 py-0">
				<table class="table table-striped table-bordered table-sm" id="tb-cari-aset">
					<thead>
						<tr>
							<th class="text-center">Kode Barang</th>
							<th class="text-left">Nama</th>
							<th class="text-right">Nilai</th>
							<th class="text-left">Keterangan</th>
							<th class="text-center">Aksi</th>
						</tr>
						<tr>
							<th colspan="5">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm" id="in-cari-aset" placeholder="Ketik kode, nama, nilai, atau keterangan">
									<span class="input-group-btn">
										<button class="btn btn-primary btn-sm" id="btn-cari-aset"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="md-cari-kdp">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title">Pilih KDP</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body table-responsive px-0 py-0">
				<table class="table table-striped table-bordered table-sm" id="tb-cari-kdp">
					<thead>
						<tr>
							<th class="text-center">Kode Barang</th>
							<th class="text-left">Nama</th>
							<th class="text-right">Nilai</th>
							<th class="text-left">Keterangan</th>
							<th class="text-center">Aksi</th>
						</tr>
						<tr>
							<th colspan="5">
								<div class="input-group">
									<input type="text" class="form-control form-control-sm" id="in-cari-kdp" placeholder="Ketik kode, nama, nilai, atau keterangan">
									<span class="input-group-btn">
										<button class="btn btn-primary btn-sm" id="btn-cari-kdp"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var site_url = "{{site_url()}}";

	$("#btn-cari-aset").on('click', function(){
		var key = encodeURI($("#in-cari-aset").val());
		var aset = $("[name=kib]").val();
		var id_organisasi = $("[name=id_organisasi]").val();

		// LOADING
		$("#tb-cari-aset > tbody").empty().append("<tr><td colspan='5' class='text-center'>Mengambil data, mohon tunggu....</td></tr>");

		// GET JSON ASET
		var link = site_url+"pelunasan/json?aset="+aset+"&id_organisasi="+id_organisasi+"&key="+key;
		$.getJSON(link, function(result){
			$("#tb-cari-aset > tbody").empty().append("<tr><td colspan='5' class='text-center'>Menampilkan "+result.length+" data teratas</td></tr>");
			$.each(result, function(index, item){
				var html = "<tr>";
				html += "<td class='text-center'>"+item.kode+"</td>";
				html += "<td class='text-left'>"+item.nama+"</td>";
				html += "<td class='text-right'>"+item.nilai+"</td>";
				html += "<td class='text-left'>"+item.keterangan+"</td>";
				html += "<td class='text-center'><button class='btn btn-primary btn-sm' data-id='"+item.id+"' data-kode='"+item.kode+"'><i class='fa fa-plus'></i></button></td>";
				html += "</tr>";

				$("#tb-cari-aset > tbody").append(html);
			});
		});
	});

	$("#tb-cari-aset > tbody").delegate("button[data-id]", "click", function(e){
		var id = $(e.currentTarget).data('id');
		var kode = $(e.currentTarget).data('kode');
		$("[name=id_aset]").empty().append("<option value='"+id+"'>"+kode+"</option>");
		$("#md-cari-aset").modal('hide');
	});

	$("#btn-cari-kdp").on('click', function(){
		var key = encodeURI($("#in-cari-kdp").val());
		var aset = $("[name=kib]").val();
		var id_organisasi = $("[name=id_organisasi]").val();

		// LOADING
		$("#tb-cari-kdp > tbody").empty().append("<tr><td colspan='5' class='text-center'>Mengambil data, mohon tunggu....</td></tr>");

		// GET JSON ASET
		var link = site_url+"pelunasan/json?aset="+aset+"&id_organisasi="+id_organisasi+"&key="+key+"&is_kdp=TRUE";
		$.getJSON(link, function(result){
			$("#tb-cari-kdp > tbody").empty().append("<tr><td colspan='5' class='text-center'>Menampilkan "+result.length+" data teratas</td></tr>");
			$.each(result, function(index, item){
				var html = "<tr>";
				html += "<td class='text-center'>"+item.kode+"</td>";
				html += "<td class='text-left'>"+item.nama+"</td>";
				html += "<td class='text-right'>"+item.nilai+"</td>";
				html += "<td class='text-left'>"+item.keterangan+"</td>";
				html += "<td class='text-center'><button class='btn btn-primary btn-sm' data-id='"+item.id+"' data-kode='"+item.kode+"'><i class='fa fa-plus'></i></button></td>";
				html += "</tr>";

				$("#tb-cari-kdp > tbody").append(html);
			});
		});
	});

	$("#tb-cari-kdp > tbody").delegate("button[data-id]", "click", function(e){
		var id = $(e.currentTarget).data('id');
		var kode = $(e.currentTarget).data('kode');
		$("[name=id_kdp]").empty().append("<option value='"+id+"'>"+kode+"</option>");
		$("#md-cari-kdp").modal('hide');
	});

	$(".modal").on('hide.bs.modal', function(e){
		$(e.currentTarget).find('tbody').empty();
		$(e.currentTarget).find('input').val('');
	});

	$("[name=akumulasi_kdp]").on('click', function(e){
		$(".form-text").empty();
		if($("[name=akumulasi_kdp]:checked").length > 0) {
			$(".form-text").html("Apabila dicentang, maka nilai aset yang dilunasi akan diakumulasikan dengan nilai KDP.");
		}
	});
</script>
@end