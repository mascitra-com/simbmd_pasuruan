@layout('commons/index')
@section('title')Pegawai@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pegawai</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<span>Data Pegawai</span>
		<form action="{{site_url('pegawai/index')}}" method="GET" class="ml-auto">
			<div class="input-group">
				<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $org)
					<option value="{{$org->id}}" {{$org->id === $id_organisasi ? 'selected' : ''}}>{{$org->nama}}</option>
					@endforeach
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary">Pilih</button>
				</span>
			</div>
		</form>
	</div>
	<div class="card-body">
		<div id="toolbar">
			<button class="btn btn-primary" id="btn-tambah"><i class="fa fa-plus mr-2"></i>Tambah</button>
		</div>
		<table class="jq-table table-striped" data-toolbar="#toolbar" data-search="true" data-search-on-enter-key="true" data-pagination="true" data-side-pagination="server" data-url="{{site_url('pegawai/get?id_organisasi='.$id_organisasi)}}">
			<thead>
				<tr>
					<th data-formatter="formatting" data-field="no">No.</th>
					<th data-formatter="formatting" data-field="nip">NIP</th>
					<th data-formatter="formatting" data-field="nama" data-class="text-nowrap">Nama</th>
					<th data-formatter="formatting" data-field="jabatan" data-class="text-nowrap">Jabatan</th>
					<th data-formatter="formatting" data-field="is_superadmin">Super Admin</th>
					<th data-formatter="formatting" data-field="is_admin">Admin</th>
					<th data-formatter="formatting" data-field="is_kepala_upb">Kepala UPB</th>
					<th data-formatter="formatting" data-field="status" data-class="text-center">Status</th>
					<th data-formatter="formatting" data-field="last_login" data-class="text-center">Terakhir Masuk</th>
					<th data-formatter="formatting" data-field="aksi" data-class='text-center'>Aksi</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Data Pegawai</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('pegawai/insert')}}" method="POST">
					<input type="hidden" name="id">
					<input type="hidden" name="id_organisasi" value="{{$id_organisasi}}">
					<div class="form-group row">
						<label class="col-xl-4 col-form-label">NIP</label>
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="nip" placeholder="Isi NIP">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-4 col-form-label">Nama Lengkap</label>
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="nama" placeholder="Isi Nama Lengkap" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-4 col-form-label">Jabatan</label>
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="jabatan" placeholder="Isi Jabatan">
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xl-4 col-form-label">Hak Akses</label>
							<div class="col">
								<div class="form-check">
									<input type="checkbox" name="is_superadmin" value="1">
									<label class="form-check-label">Superadmin</label>
								</div>
								<div class="form-check">
									<input type="checkbox" name="is_admin" value="1">
									<label class="form-check-label">Admin</label>
								</div>
								<div class="form-check">
									<input type="checkbox" name="is_kepala_upb" value="1">
									<label class="form-check-label">Kepala UPB</label>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-4 col-form-label">Status</label>
						<div class="col">
							<div class="form-group">
								<select name="status" class="form-control form-control-sm">
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label class="col-xl-4 col-form-label">Username</label>
						<div class="col">
							<input type="text" class="form-control form-control-sm" name="username" placeholder="Isi Username" required>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xl-4 col-form-label">Password</label>
						<div class="col">
							<input type="password" class="form-control form-control-sm" name="password" placeholder="Isi Password">
							<input type="password" class="form-control form-control-sm" name="re_password" placeholder="Isi Ulang Password">
							<p class="form-text"></p>
						</div>
					</div>
					<hr>
					<div class="form-group text-center">
						<div class="btn-group">
							<button type="submit" class="btn btn-success"><i class="fa fa-save mr-2"></i>Simpan</button>
							<a href="#" class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash mr-2"></i>Hapus Data</a>
							<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times mr-2"></i>Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<link rel="stylesheet" href="{{base_url('res/plugins/bttable/bttable.css')}}">
@end

@section('script')
<script src="{{base_url('res/plugins/bttable/bttable.js')}}"></script>
<script type="text/javascript">
	theme.activeMenu('.nav-pegawai');

	$("#btn-tambah").on('click', function(e){
		$("#modal-form form").attr('action', "{{site_url('pegawai/insert')}}");
		$("#modal-form form input:not([name=id_organisasi]):not([type=checkbox])").val('').prop('checked', false);
		$("#modal-form form [type=checkbox]").prop('checked', 0);
		$("#modal-form form select").val('1');
		$("#modal-form form :submit").prop('disabled', true);
		$("#modal-form").modal('show');
	});

	$("table tbody").delegate('[data-id]', 'click', function(e){
		var id = $(e.currentTarget).data('id');

		$.getJSON("{{site_url('pegawai/get?id=')}}"+id, function(result){
			$("[name=id]").val(result.rows[0].id);
			$("[name=nama]").val(result.rows[0].nama);
			$("[name=nip]").val(result.rows[0].nip);
			$("[name=jabatan]").val(result.rows[0].jabatan);
			$("[name=username]").val(result.rows[0].username);
			$("[name=is_superadmin]").prop('checked', parseInt(result.rows[0].is_superadmin));
			$("[name=is_admin]").prop('checked', parseInt(result.rows[0].is_admin));
			$("[name=is_kepala_upb]").prop('checked', parseInt(result.rows[0].is_kepala_upb));
			$("#modal-form form a").attr('href', "{{site_url('pegawai/delete/')}}"+result.rows[0].id);
		});
		
		$("#modal-form form :submit").prop('disabled', false);
		$("#modal-form form").attr('action', "{{site_url('pegawai/update')}}");
		$("#modal-form").modal('show');
	});

	// PASSWORD
	$("[type=password]").keyup(function(e){
		var pass = $("[name=password]").val();
		var re_pass = $("[name=re_password]").val();
		if (pass != re_pass) {
			$(".form-text").html("Password tidak sama");
		}else{
			$(".form-text").html("Password sama");
		}
		$("#modal-form form :submit").prop('disabled', (pass != re_pass));
	});

	// INIT Datatables
	$(".jq-table").bootstrapTable({
		formatRecordsPerPage: function () {
			return ''
		},
		formatShowingRows: function () {
			return ''
		}
	});

	function formatting(value, row, index, field)
	{
		switch(field){
			case 'no':
			return index + 1;
			case 'is_admin':
			case 'is_superadmin':
			case 'is_kepala_upb':
			return (row[field] == 0 || row[field] == '') ? 'Tidak' : 'Ya';
			case 'status':
			return (row[field] == 0 || row[field] == '') ? "<span class='badge badge-danger'>Tidak Aktif</span>" : "<span class='badge badge-success'>Aktif</span>";
			case 'aksi':
			return "<button class='btn btn-sm btn-warning' data-id='"+row.id+"'>sunting</button>"
			default:
			return row[field];
		}
	}
</script>
@end