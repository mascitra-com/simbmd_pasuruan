@layout('commons/index')
@section('title')Organisasi@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('organisasi')}}">Bidang</a></li>
<li class="breadcrumb-item active">Unit</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header form-inline">
				<div class="card-title mr-auto">Organisasi</div>
				<div class="btn-group">
					<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
					<a href="{{site_url('organisasi/add/2?id='.$induk->id)}}" class="btn btn-primary btn-tambah"><i class="fa fa-plus mr-2"></i>Tambah</a>
				</div>
			</div>
			<div class="card-body table-responsive py-0 px-0">
				<table class="table table-striped table-hover table-bordered table-sm">
					<thead>
						<tr>
							<th colspan="4">KODE</th>
							<th rowspan="2" class="text-left">NAMA</th>
							<th rowspan="2">KEPALA</th>
							<th rowspan="2">PENYIMPAN BARANG</th>
							<th rowspan="2">AKSI</th>
						</tr>
						<tr>
							<th width="5%">BIDANG</th>
							<th width="5%">ORGANISASI</th>
							<th width="5%">SUB</th>
							<th width="5%">UPB</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($organisasi))
						<tr><td colspan="8">tidak ada data</td></tr>
						@endif

						@foreach($organisasi AS $org)
						@if($org->sub_dari === $induk->id)
						<tr>
							<td>{{zerofy($org->kd_bidang)}}</td>
							<td>{{zerofy($org->kd_unit)}}</td>
							<td>-</td>
							<td>-</td>
							<td class="text-left">{{$org->nama}}</td>
							<td>{{$org->kepala_nama}}</td>
							<td>{{$org->pengurus_nama}}</td>
							<td>
								<div class="btn-group btn-group-sm">
									<a href="{{site_url('organisasi/subunit/'.$org->id)}}" class="btn btn-success"><i class="fa fa-eye"></i> Lihat Sub</a>
									<a href="{{site_url('organisasi/edit/'.$org->id)}}" class="btn btn-warning"><i class="fa fa-pencil"></i> Sunting</a>
									<button class="btn btn-danger" data-id="{{$org->id}}" data-nama="{{$org->nama}}"><i class="fa fa-refresh"></i> Lebur</button>
								</div>
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@end

@section('modal')
<div class="modal fade" id="modal-lebur" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Lebur Organisasi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{site_url('organisasi/lebur')}}" method="POST">
					<input type="hidden" name="id_organisasi">
					<input type="hidden" name="ref" value="{{'organisasi/unit/'.$induk->id}}">
					<div class="form-group">
						<label for="">Organisasi Asal</label>
						<input type="text" class="form-control" id="input-organisasi" disabled="">
					</div>
					<div class="form-group">
						<label for="">Organisasi Tujuan</label>
						<select name="id_tujuan" class="form-control" data-placeholder="Pilih organisasi..."></select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Proses</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
td,th{text-align: center}
</style>
@end

@section('script')
<script type="text/javascript">
	var organisasi = (function(){
		theme.activeMenu('.nav-organisasi');

		$("[data-id]").on('click', function(e){
			var id = $(e.currentTarget).data('id');
			var nama = $(e.currentTarget).data('nama');
			$(".modal form #input-organisasi").val(nama);
			$(".modal form [name=id_organisasi]").val(id);

			$.getJSON("{{site_url('organisasi/get?jenis=2&sort=nama&order=asc&sub_dari='.$induk->id)}}", function(result){
				
				if (Object.keys(result.rows).length < 2) {
					$(".modal form :submit").prop('disabled', true);
				}

				$("[name=id_tujuan]").empty();
				$.each(result.rows, function(index, value){
					if (value.id != id) {
						$("[name=id_tujuan]").append("<option value='"+value.id+"'>"+value.nama+"</option>");
					}
				});
			});

			$("#modal-lebur").modal('show');
		});
	})();
</script>
@end