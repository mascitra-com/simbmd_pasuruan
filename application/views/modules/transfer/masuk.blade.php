@layout('commons/index')
@section('title')Transfer Masuk@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Transfer Masuk</li>
@end

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="" method="GET" class="mr-auto">
			<div class="input-group">
				<select name="id_tujuan" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $org)
						<option value="{{$org->id}}" {{isset($filter['id_tujuan']) && $org->id === $filter['id_tujuan'] ? 'selected' : ''}}>{{$org->nama}}</option>
					@endforeach
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary">Pilih</button>
				</span>
			</div>
		</form>
		<div class="btn-group">
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th class="text-center">No. Transfer</th>
						<th>Asal</th>
						<th class="text-nowrap">No. SK</th>
						<th class="text-center">Tanggal SK</th>
						<th class="text-center">No Serah Terima</th>
						<th class="text-center">Tanggal Serah Terima</th>
                        <th class="text-center">Tanggal Verifikasi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
				</thead>
				<tbody>
					@if(empty($transfer))
					<tr><td colspan="10" class="text-center">Tidak ada data</td></tr>
					@endif
					
					@foreach($transfer AS $item)
					<tr class="small">
						<td class="text-center">{{$item->id}}</td>
						<td>{{$item->id_organisasi->nama}}</td>
						<td class="text-center">{{$item->surat_no}}</td>
						<td class="text-center">{{datify($item->surat_tgl)}}</td>
						<td class="text-center">{{$item->serah_terima_no}}</td>
						<td class="text-center">{{datify($item->serah_terima_tgl)}}</td>
						<td class="text-center">{{datify($item->tanggal_verifikasi)}}</td>
						<td class="text-center">
							<div class="btn-group">
								<a href="{{ site_url('transfer/index/masuk_detail/'.$item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Rincian</a>
							</div>
						</td>
					</tr>
					@endforeach
                </tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer">{{$pagination}}</div>
</div>
@end

@section('style')
<style>
.text-sm {font-size: smaller;}
</style>
@end

@section('script')
<script>
	theme.activeMenu('.nav-transfer-masuk');
</script>
@end