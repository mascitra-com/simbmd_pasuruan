@layout('commons/index')
@section('title')Hibah@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('hibah')}}">Hibah</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="btn-group mb-3">
	<a href="#" class="btn btn-primary active">01. Detail Hibah</a>
	<a href="{{site_url('hibah/rincian/'.$hibah->id)}}" class="btn btn-primary">02. Rincian Aset</a>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Hibah</div>
			<div class="card-body">
				<form action="{{ site_url('hibah/update_hibah') }}" method="POST">
					<input type="hidden" name="id" value="{{ $hibah->id }}">
					<div class="row">
						<div class="col">
							<div class="form-row">
								<div class="form-group col">
									<label>No. Jurnal</label>
									<input type="number" class="form-control form-control-sm" value="{{ $hibah->no_jurnal }}" name="no_jurnal" placeholder="Nomor Jurnal" />
								</div>
								<div class="form-group col">
									<label>Tgl. Jurnal</label>
									<input type="date" class="form-control form-control-sm" value="{{ datify($hibah->tgl_jurnal, 'Y-m-d') }}" name="tgl_jurnal" placeholder="Tanggal Jurnal" />
								</div>
							</div>
							<div class="form-group">
								<label>Asal Penerimaan</label>
								<input type="text" class="form-control form-control-sm" value="{{ $hibah->asal_penerimaan }}" name="asal_penerimaan" placeholder="Asal Penerimaan Hibah" required/>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>No. BA Serah Terima</label>
							<input type="number" class="form-control form-control-sm" value="{{ $hibah->no_serah_terima }}" name="no_serah_terima" placeholder="No. BA Serah Terima" />
						</div>
						<div class="form-group col">
							<label>Tanggal BA Serah Terima</label>
							<input type="date" class="form-control form-control-sm" value="{{ datify($hibah->tgl_serah_terima, 'Y-m-d') }}" name="tgl_serah_terima" placeholder="Tanggal BA Serah Terima" />
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>Keterangan</label>
							<input type="text" class="form-control form-control-sm" value="{{ $hibah->keterangan }}" name="keterangan" placeholder="Keterangan" required/>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="col text-right">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
							<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
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
	theme.activeMenu('.nav-hibah')
</script>
@end