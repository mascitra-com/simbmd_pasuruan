@layout('commons/index')
@section('title')Inventarisasi - Tambah Nilai Aset@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('inventarisasi/index?id_organisasi='.$inventarisasi->id_organisasi)}}">Inventarisasi</a></li>
<li class="breadcrumb-item"><a href="{{site_url('inventarisasi/index/rincian/'.$inventarisasi->id)}}">Rincian</a></li>
<li class="breadcrumb-item active">Tambah Nilai Aset</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">{{isset($kpt) ? 'Sunting Penambahan Nilai' : 'Tambah Nilai Aset'}}</div>
			<div class="card-body table-responsive">
				<form action="{{isset($kpt) ? site_url('inventarisasi/kapitalisasi/update') : site_url('inventarisasi/kapitalisasi/insert')}}" method="POST">
					
					<input type="hidden" name="id" value="{{isset($kpt) ? $kpt->id : ''}}">
					<input type="hidden" name="id_inventarisasi" value="{{$inventarisasi->id}}">
					<input type="hidden" name="golongan" value="{{isset($kpt) ? $kpt->golongan : ''}}">

					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Pilih Kategori</label>
						<div class="col-md-4">
							<div class="input-group">
								<select class="form-control" name="id_kategori">
									@if($kpt)
									<option value="{{$kpt->id_kategori->id}}">{{$kpt->id_kategori->nama}}</option>
									@else
									<option value="">Pilih Kategori</option>
									@endif
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
								<select class="form-control" name="id_aset">
									@if($kpt)
									<option value="{{$kpt->id_aset->id}}">{{monefy($kpt->id_aset->nilai).' - '.$kpt->id_aset->asal_usul}}</option>
									@else
									<option value="">Pilih Aset Utama</option>
									@endif
								</select>
								<span class="input-group-btn">
									<button type="button" class="btn btn-secondary btn-aset" disabled="">Pilih</button>
								</span>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Nama</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang" value="{{isset($kpt) ? $kpt->nama_barang : ''}}" required/>
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
						<label class="col-md-2 col-form-label text-right">Tgl. Perolehan</label>
						<div class="col-md-4">
							<input type="date" class="form-control" name="tgl_perolehan" value="{{isset($kpt) ? datify($kpt->tgl_perolehan, 'Y-m-d') : date('Y-m-d')}}" placeholder="Tgl. Perolehan" />
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
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right">Keterangan</label>
						<div class="col-md-4">
							<textarea name="keterangan" class="form-control" placeholder="keterangan">{{isset($kpt)?$kpt->keterangan:''}}</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-form-label text-right"></label>
						<div class="col-md-4">
							<button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
							<a href="{{site_url('inventarisasi/index/rincian/'.$inventarisasi->id)}}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pilih aset</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body scroll">
				<table class="jq-table table-striped table-sm" data-search="true"data-show-columns="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="">
					<thead>
						<tr>
							<th data-class='text-nowrap' data-formatter='format' data-field='aksi' class='text-nowrap'>Aksi</th>
							<th data-class='text-nowrap' data-formatter='format' data-field="kode">Kode Barang</th>
							<th data-class='text-nowrap' data-formatter='format' data-field="id_kategori">Kategori</th>
							<th data-class='text-nowrap' data-field="nilai">Nilai</th>
							<th data-class='text-nowrap' data-field="tgl_perolehan">Tgl. Perolehan</th>
							<th data-class='text-nowrap' data-field="tgl_pembukuan">Tgl. Pembukuan</th>
							<th data-class='text-nowrap' data-field="asal_usul">Asal Usul</th>
							<th data-class='text-nowrap' data-field="keterangan">Keterangan</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
@end

@section('style')
<link rel="stylesheet" href="{{base_url('res/plugins/bttable/bttable.css')}}">
<style>
.small{font-size: .9em}
.scroll{
	max-height: 80vh!important;
	overflow-y: auto;!important;
}

@media (min-width: 992px){
	.modal-lg {
		max-width: 85%!important;
	}
}
</style>
@end

@section('script')
<script src="{{base_url('res/plugins/bttable/bttable.js')}}"></script>
<script type="text/javascript">
	theme.activeMenu('.nav-invent');

	$(".jq-table").bootstrapTable({
		formatRecordsPerPage: function () {
			return ''
		},
		formatShowingRows: function () {
			return ''
		}
	});

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
		var id   = $(e.currentTarget).data('id-kategori');
		var nama = $(e.currentTarget).data('nama');
		$("[name=id_kategori]").empty().append("<option value='"+id+"' selected>"+nama+"</option>");
		$("[name=golongan]").val($("#sel-cari-kategori").val());
		$("[name=id_aset]").empty();
		$(".btn-aset").prop('disabled', false);
		$(".modal").modal('hide');
	});

	$(".modal").on('hide.bs.modal', function(){
		$("#tb-cari-kategori tbody").empty();
		$("#tb-cari-kategori input").val("");
	});

	$(".btn-aset").on('click', function(e){
		var kib = $("[name=golongan]").val() == 3?'kibc':'kibd';
		var idKategori = $("[name=id_kategori]").val();
		var url = 'inventarisasi/'+kib+'/get?id_organisasi={{$inventarisasi->id_organisasi}}&id_kategori='+idKategori;
		$('.jq-table').bootstrapTable('refresh', {'url':"{{site_url()}}"+url});
		$("#mod-aset").modal('show');
	});

	function format(value, row, index, field){
		switch(field){
			case 'id_kategori':
			return row.id_kategori.nama;
			case 'kode':
			return row.id_kategori.kd_golongan+'.'+row.id_kategori.kd_bidang+'.'+row.id_kategori.kd_kelompok+'.'+row.id_kategori.kd_subkelompok+'.'+row.id_kategori.kd_subsubkelompok;
			return;
			case 'aksi':
			return "<button class='btn btn-primary btn-sm' data-id-aset='"+row.id+"' data-nama='"+row.nilai+" - "+row.asal_usul+"'><i class='fa fa-plus'></i></button>";
		}
	}

	$("#mod-aset table > tbody").delegate('[data-id-aset]', 'click', function(e){
		var id = $(e.currentTarget).data('id-aset');
		var nama = $(e.currentTarget).data('nama');
		$("[name=id_aset]").empty().append("<option value='"+id+"'>"+nama+"</option>");
		$("#mod-aset").modal('hide');
	});

</script>
@end