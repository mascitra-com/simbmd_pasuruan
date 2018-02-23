@layout('commons/index')
@section('title')Pengadaan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item"><a href="{{site_url('pengadaan/index?id_organisasi='.$spk->id_organisasi)}}">Pengadaan</a></li>
<li class="breadcrumb-item active">Rincian</li>
@end

@section('content')
<div class="form-inline">
	<div class="btn-group mb-3">
		<a href="{{site_url('pengadaan/index/detail/'.$spk->id)}}" class="btn btn-primary active">01. Detail Pengadaan</a>
		<a href="{{site_url('pengadaan/sp2d/index/'.$spk->id)}}" class="btn btn-primary">02. SP2D</a>
		<a href="{{site_url('pengadaan/index/rincian/'.$spk->id)}}" class="btn btn-primary">03. Rincian Aset</a>
	</div>
	<div class="btn-group mb-3 ml-auto">
        @if($spk->status_pengajuan === '0' OR $spk->status_pengajuan === '3')
        <a href="{{site_url('pengadaan/index/finish_transaction/'.$spk->id)}}" class="btn btn-success" onclick="return confirm('Anda yakin? Data tidak dapat disunting jika telah diajukan.')"><i class="fa fa-check mr-2"></i>Selesaikan Transaksi</a>
        @elseif($spk->status_pengajuan === '1')
        <a href="{{site_url('pengadaan/index/cancel_transaction/'.$spk->id)}}" class="btn btn-warning" onclick="return confirm('Anda yakin?')"><i class="fa fa-check mr-2"></i>Batalkan Pengajuan</a>
        @endif
    </div>
</div>
<div class="row mb-3">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Kontrak</div>
			<div class="card-body row">
				<div class="col-6">
					<div class="row">
						<?php $nilai_kontrak = ($spk->addendum_nilai != 0) ? $spk->addendum_nilai : $spk->nilai ?>
						<div class="col">Nilai Kontrak</div><div class="col"> : {{monefy($nilai_kontrak)}}</div>
						<div class="w-100"></div>
						<div class="col">Total SP2D</div><div class="col"> : {{monefy($sp2d['total'])}}</div>
						<div class="w-100"></div>
						<div class="col">Sisa Kontrak</div><div class="col"> : {{monefy($nilai_kontrak - $sp2d['total'])}}</div>
						<div class="w-100"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header">Detail Pengadaan</div>
			<div class="card-body">
				<form action="{{site_url('pengadaan/index/update')}}" method="POST">
					<input type="hidden" name="id" value="{{$spk->id}}">
					<input type="hidden" name="id_organisasi" value="{{$spk->id_organisasi}}">
					<div class="row">
						<div class="col">
							<div class="form-row">
								<div class="form-group col">
									<label>No. Kontrak</label>
									<input type="text" class="form-control form-control-sm" name="nomor" value="{{$spk->nomor}}" placeholder="No. SPK/Kontrak/Perjanjian" required/>
								</div>
								<div class="form-group col">
									<label>Tgl. Kontrak</label>
									<input type="date" class="form-control form-control-sm" name="tanggal" value="{{datify($spk->tanggal, 'Y-m-d')}}" placeholder="Tanggal kontrak" required />
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>No. BA Serah Terima</label>
									<input type="text" class="form-control form-control-sm" name="no_serah_terima" value="{{isset($spk->no_serah_terima) ? $spk->no_serah_terima : ''}}" placeholder="No. Berita Acara Serah Terima"/>
								</div>
								<div class="form-group col">
									<label>Tgl. BA Serah Terima</label>
									<input type="date" class="form-control form-control-sm" name="tgl_serah_terima" value="{{isset($spk->tgl_serah_terima) ? datify($spk->tgl_serah_terima, 'Y-m-d') : ''}}" placeholder="Tanggal Berita Acara Serah Terima" />
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>Jangka Waktu</label>
									<input type="number" class="form-control form-control-sm" name="jangka_waktu" value="{{$spk->jangka_waktu}}" placeholder="Jangka waktu"/>
								</div>
								<div class="form-group col">
									<label>Nilai</label>
									<input type="text" class="form-control form-control-sm" name="nilai" placeholder="Nilai" value="{{monefy($spk->nilai)}}" required {{(!empty($sp2d['total']))?'readonly':''}}/>
								</div>
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<textarea class="form-control form-control-sm" rows="5" name="keterangan" value="{{$spk->keterangan}}" placeholder="Keterangan"></textarea>
							</div>
						</div>
						<div class="col">
							<div class="form-row">
								<div class="form-group col">
									<label>Nama Perusahaan</label>
									<input type="text" class="form-control form-control-sm" name="nama_perusahaan" value="{{$spk->nama_perusahaan}}" placeholder="Nama perusahaan"/>
								</div>
								<div class="form-group col">
									<label>Bentuk</label>
									<input type="text" class="form-control form-control-sm" name="bentuk" value="{{$spk->bentuk}}" placeholder="Bentuk"/>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>Alamat</label>
									<input type="text" class="form-control form-control-sm" name="alamat" value="{{$spk->alamat}}" placeholder="Alamat"/>
								</div>
								<div class="form-group col">
									<label>Pimpinan</label>
									<input type="text" class="form-control form-control-sm" name="pimpinan" value="{{$spk->pimpinan}}" placeholder="Pimpinan"/>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>NPWP</label>
									<input type="text" class="form-control form-control-sm" name="npwp" value="{{$spk->npwp}}" placeholder="NPWP"/>
								</div>
								<div class="form-group col">
									<label>Bank</label>
									<input type="text" class="form-control form-control-sm" name="bank" value="{{$spk->bank}}" placeholder="Bank"/>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col">
									<label>Atas Nama</label>
									<input type="text" class="form-control form-control-sm" name="atas_nama" value="{{$spk->atas_nama}}" placeholder="Atas Nama" />
								</div>
								<div class="form-group col">
									<label>No. Rekening</label>
									<input type="text" class="form-control form-control-sm" name="no_rek" value="{{$spk->no_rek}}" placeholder="No. Rekening" />
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col">
							<label>Addendum Nilai</label>
							<input type="number" class="form-control form-control-sm" name="addendum_nilai" value="{{monefy($spk->addendum_nilai)}}" placeholder="Addendum Nilai" {{(!empty($sp2d['total']))?'readonly':''}}/>
						</div>
						<div class="form-group col">
							<label>Kegiatan</label>
							<select name="id_kegiatan" class="form-control form-control-sm">
								<option>Pilih Kegiatan....</option>
								@foreach($kegiatan AS $data)
								<option value="{{$data->id}}" {{$spk->id_kegiatan===$data->id?'selected':''}}>{{$data->kode.' - '.$data->nama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<hr>
					<div class="form-row">
						<div class="col text-right">
							@if($spk->status_pengajuan === '0' OR $spk->status_pengajuan === '3')
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
							@endif
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
    theme.activeMenu('.nav-pengadaan');

    @if($spk->status_pengajuan === '1' OR $spk->status_pengajuan === '2')
    $(':input').prop('disabled', true);
    @endif
</script>
@end