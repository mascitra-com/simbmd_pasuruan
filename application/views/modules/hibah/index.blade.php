@layout('commons/index')
@section('title')Hibah@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Hibah</li>
@endsection

@section('content')
<div class="card">
	<div class="card-header form-inline">
		<form action="{{site_url('hibah')}}" method="GET" class="mr-auto">
			<div class="input-group">
				<select name="id_organisasi" class="select-chosen" data-placeholder="Pilih UPB...">
					<option></option>
					@foreach($organisasi AS $org)
					<option value="{{$org->id}}" {{isset($filter['id_organisasi']) && $org->id === $filter['id_organisasi'] ? 'selected' : ''}}>{{$org->nama}}</option>
					@endforeach
				</select>
				<span class="input-group-btn">
					<button class="btn btn-primary">Pilih</button>
				</span>
			</div>
		</form>
		<div class="btn-group">
			<button class="btn btn-primary" data-toggle="modal" data-target="#modal-spk"><i class="fa fa-plus mr-2"></i>Baru</button>
			<!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modal-filter"><i class="fa fa-filter mr-2"></i>Filter</button> -->
			<button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
		</div>
	</div>
	<div class="card-body table-responsive px-0 py-0">
		<table class="table table-hover table-striped table-bordered">
			<thead>
				<thead>
					<tr>
						<th class="text-center">No. Hibah</th>
						<th>No. Lokasi</th>
						<th>No. Jurnal</th>
						<th class="text-nowrap">Tanggal Jurnal</th>
						<th>Asal Penerimaan</th>
						<th class="text-nowrap">No Serah Terima</th>
						<th class="text-nowrap">Tanggal Serah Terima</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody>
				@if($hibah)
                    @foreach($hibah as $list)
					<tr>
						<td class="text-center">{{ $list->id }}</td>
						<td>{{ $list->no_lokasi }}</td>
						<td>{{ $list->no_jurnal }}</td>
						<td class="text-nowrap">{{ datify($list->tgl_jurnal, 'd-m-Y') }}</td>
						<td class="text-sm">{{ $list->asal_penerimaan }}</td>
						<td class="text-nowrap">{{ $list->no_serah_terima }}</td>
						<td class="text-nowrap">{{ datify($list->tgl_serah_terima, 'd-m-Y') }}</td>
						<td class="text-center">
							<div class="btn-group btn-group-sm">
								<a href="{{ base_url('hibah/detail/'.$list->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i> Rincian</a>
								<button class="btn btn-danger"><i class="fa fa-trash"></i></button>
							</div>
						</td>
					</tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="8">Tidak Ditemukan Data</td>
                    </tr>
                @endif
                </tbody>
			</thead>
		</table>
	</div>
	<div class="card-footer"></div>
</div>
@end

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="modal-spk">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Hibah</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{ site_url('hibah/insert_hibah') }}" method="POST">
					<input type="hidden" name="id_organisasi" value="{{isset($filter['id_organisasi'])?$filter['id_organisasi']:''}}">
					<div class="row">
						<div class="col">
							<div class="form-row">
								<div class="form-group col">
									<label>No. Lokasi</label>
									<input type="text" class="form-control form-control-sm" name="no_lokasi" placeholder="Nomor Lokasi" required/>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>No. Jurnal</label>
									<input type="number" class="form-control form-control-sm" name="no_jurnal" placeholder="Nomor Jurnal" />
								</div>
                                <div class="form-group col">
                                    <label>Tgl. Jurnal</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_jurnal" placeholder="Tanggal Jurnal" />
                                </div>
							</div>
							<div class="form-group">
                                <label>Asal Penerimaan</label>
                                <input type="text" class="form-control form-control-sm" name="asal_penerimaan" placeholder="Asal Penerimaan Hibah" required/>
                            </div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>No. BA Serah Terima</label>
							<input type="number" class="form-control form-control-sm" name="no_serah_terima" placeholder="No. BA Serah Terima" />
						</div>
						<div class="form-group col">
							<label>Tanggal BA Serah Terima</label>
                            <input type="date" class="form-control form-control-sm" name="tgl_serah_terima" placeholder="Tanggal BA Serah Terima" />
                        </div>
					</div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Keterangan</label>
                            <input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Keterangan" required/>
                        </div>
                    </div>
					<hr>
					<div class="form-row">
						<div class="col text-right">
							<button type="submit" class="btn btn-primary" {{empty($filter['id_organisasi'])?'disabled':''}}><i class="fa fa-save"></i> {{empty($filter['id_organisasi'])?'Pilih organisasi terlebih dahulu':'Simpan'}}</button>
							<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@end

@section('style')
<style>
.text-sm {font-size: smaller;}
</style>
@endsection

@section('script')
<script>
	theme.activeMenu('.nav-hibah')
</script>
@end