@layout('commons/index')
@section('title')Pengadaan - Tambah Nilai Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Nilai Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kpt) ? 'Sunting Penambahan Nilai' : 'Tambah Nilai Aset'}}</div>
			<div class="card-body table-responsive">
				<form action="{{isset($kpt) ? site_url('pengadaan/kapitalisasi/update') : site_url('pengadaan/kapitalisasi/insert')}}" method="POST">
					
					<input type="hidden" name="id" value="{{isset($kpt) ? $kpt->id : ''}}">
					<input type="hidden" name="id_spk" value="{{$spk->id}}">

					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih Kategori</label>
						<div class="col-md-4">
							<div class="input-group">
								<select class="form-control" name="id_kategori" disabled="">
									<option value="">Pilih Kategori</option>
								</select>
								<span class="input-group-btn">
									<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mod-kategori">Pilih</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih Aset Utama</label>
						<div class="col-md-4">
							<div class="input-group">
								<select class="form-control" name="id_aset" disabled="">
									<option value="">Pilih Aset Utama</option>
								</select>
								<span class="input-group-btn">
									<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mod-aset" disabled="">Pilih</button>
								</span>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih SP2D</label>
						<div class="col-md-4">
							<select name="id_sp2d" class="form-control">
								@foreach($sp2d AS $item)
								<option value="{{$item->id}}">{{$item->nomor}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama" placeholder="Nama Barang" value="{{isset($kpt) ? $kpt->nama : ''}}" required/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Merk</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="merk" value="{{isset($kpt) ? $kpt->merk : ''}}" placeholder="Merk" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Alamat</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="alamat" value="{{isset($kpt) ? $kpt->alamat : ''}}" placeholder="Alamat" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Tipe</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="tipe" value="{{isset($kpt) ? $kpt->tipe : ''}}" placeholder="Tipe" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nilai Satuan</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nilai" value="{{isset($kpt) ? monefy($kpt->nilai) : ''}}" placeholder="Nilai Satuan" required />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nilai Penunjang</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nilai_penunjang" value="{{isset($kpt) ? monefy($kpt->nilai_penunjang) : ''}}" placeholder="Nilai Penunjang" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('modal')
<!-- MODAL KATEGORI -->
<div class="modal fade" tabindex="-1" role="dialog" id="mod-kategori">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pilih Kategori</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body px-0 py-0 scroll">
				<table id="tb-cari-kategori" class="table table-hover table-striped table-sm">
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
									<select id="sel-cari-kategori">
										<option value="3" selected>Gedung &amp Bangunan</option>
										<option value="4">Jalan, Irigasi &amp Jaringan</option>
									</select>
									<input type="text" id="in-cari-kategori" class="form-control" placeholder="Ketik nama barang...">
									<span class="input-group-btn">
										<button class="btn btn-primary" id="btn-cari-kategori"><i class="fa fa-search"></i></button>
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
<!-- MODAL ASET -->
<div class="modal fade" tabindex="-1" role="dialog" id="mod-aset">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pilih aset</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body px-0 py-0 scroll">
				<table id="tb-cari-kategori" class="table table-hover table-striped table-sm">
					<thead>
						<tr>
							<th class="text-center">No.</th>
							<th class="text-left">Kode</th>
							<th class="text-left">Nama</th>
							<th class="text-left">Nilai</th>
							<th class="text-left">Asal-Usul</th>
							<th class="text-left">Keterangan</th>
							<th class="text-center">Aksi</th>
						</tr>
						<tr>
							<th colspan="4">
								<div class="input-group">
									<input type="text" id="in-cari-aset" class="form-control" placeholder="Ketik nama barang...">
									<span class="input-group-btn">
										<button class="btn btn-primary" id="btn-cari-aset"><i class="fa fa-search"></i></button>
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

		$("#btn-cari-kategori").on('click', fungsiCari);
		function fungsiCari(e) {
			var g = $("#sel-cari-kategori").val();
			var q = encodeURI($("#in-cari-kategori").val());
			var no = 1;
			var html = "";

			$.getJSON("{{site_url('kategori/get_json?q=')}}"+q+"&g="+g, function(result){
				html += "<tr><td class='text-center' colspan='4'>Menampilkan "+result.length+" data teratas</td></tr>";
				$.each(result, function(index, item){
					html += "<tr class='small'>";
					html += "<td class='text-center'>"+(no++)+"</td>";
					html += "<td class='text-center'>"+item.kode+"</td>";
					html += "<td class='text-left'>"+item.nama+"</td>";
					html += "<td class='text-center'><button class='btn btn-sm btn-primary' data-id-kategori="+item.id+" data-nama='"+item.nama+"'>pilih</button></td>";
					html += "</tr>";
				});
				$("#tb-cari-kategori tbody").empty().append(html);
			});
		}
		
		$("#tb-cari-kategori > tbody").delegate("button[data-id-kategori]", "click", function(e){
			var id   = $(e.currentTarget).data('id');
			var nama = $(e.currentTarget).data('nama');
			$("[name=id_kategori]").empty().append("<option value='"+id+"' selected>"+nama+"</option>");
			$("[data-target='#mod-aset']").prop('disabled', false);
			$(".modal").modal('hide');
		});

		$(".modal").on('hide.bs.modal', function(){
			$("#tb-cari-kategori tbody").empty();
			$("#tb-cari-kategori input").val("");
		});
	})();
</script>
@end