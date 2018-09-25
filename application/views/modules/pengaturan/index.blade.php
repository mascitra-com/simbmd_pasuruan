@layout('commons/index')
@section('title')Pengaturan@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Pengaturan</li>
@end

@section('content')
<div class="row">
	<div class="col-lg-3">
		<div class="card">
			<div class="card-body">
				<div class="nav flex-column nav-pills" id="tab" role="tablist">
					<a class="nav-link active" data-toggle="pill" href="#tab-umum" role="tab"><i class="fa fa-info-circle mr-2"></i>Umum</a>
					<a class="nav-link" data-toggle="pill" href="#tab-akses" role="tab"><i class="fa fa-lock mr-2"></i>Akses Aplikasi</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="tab-content" id="tab-content">
			<div class="tab-pane fade show active" id="tab-umum" role="tabpanel">
				<div class="card">
					<div class="card-header">Pengaturan Umum</div>
					<div class="card-body">
						<form action="{{site_url('pengaturan/update')}}" method="POST">
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Nama Website</label>
								<div class="col-lg-6">
									<input type="text" name="web_name" maxlength="10" placeholder="Nama website (wajib diisi)" value="{{isset($pengaturan->web_name)?$pengaturan->web_name:'SIMBMD'}}" class="form-control" required/>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Tagline</label>
								<div class="col-lg-6">
									<input type="text" name="web_desc" value="{{isset($pengaturan->web_desc)?$pengaturan->web_desc:''}}" placeholder="Deskripsi website" class="form-control"/>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Warna Website</label>
								<div class="col-lg-6">
									<input type="color" name="web_color" value="{{isset($pengaturan->web_color)?$pengaturan->web_color:''}}"/>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Tahun Periode</label>
								<div class="col-lg-6">
									<div class="input-group">
										<select name="periode_start" class="form-control">
											<option value="">- Pilih Tahun -</option>
											@for($i=(date('Y')-10); $i<(date('Y')+20); $i++)
											<option value="{{$i}}" {{isset($pengaturan->periode_start) && $pengaturan->periode_start==$i?'selected':''}}>{{$i}}</option>
											@endfor
										</select>
										<span class="input-group-addon">sampai</span>
										<select name="periode_end" class="form-control">
											<option value="">- Pilih Tahun -</option>
											@for($i=(date('Y')-9); $i<(date('Y')+21); $i++)
											<option value="{{$i}}" {{isset($pengaturan->periode_end) && $pengaturan->periode_end==$i?'selected':''}}>{{$i}}</option>
											@endfor
										</select>
									</div>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Pengumuman Berjalan</label>
								<div class="col-lg-6">
									<textarea name="scroll_text" rows="5" class="form-control" placeholder="Pengumuman berjalan">{{isset($pengaturan->scroll_text)?$pengaturan->scroll_text:''}}</textarea>
									<p class="form-text text-secondary">Penguman berjalan akan muncul dibawah header dan akan muncul secara berulang.</p>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right"></label>
								<div class="col-lg-6">
									<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save mr-2"></i>Simpan</button>
									<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-refresh mr-2"></i>Kembalikan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="tab-akses" role="tabpanel">
				<div class="card">
					<div class="card-header">Akses Aplikasi</div>
					<div class="card-body">
						<form action="{{site_url('pengaturan/update')}}" method="POST">
							<input type="hidden" name="lock_menu[]" value="blank">
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Prioritas Akses</label>
								<div class="col-lg-6">
									<select name="access_priority" class="form-control">
										<option value="0" selected>Semua User</option>
										<option value="1" {{$pengaturan->access_priority === '1'?'selected':''}}>Super Admin & Kepala UPB</option>
										<option value="2" {{$pengaturan->access_priority === '2'?'selected':''}}>Hanya Super Admin</option>
									</select>
									<p class="form-text text-secondary">Yang dapat mengakses website.</p>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right">Kunci Fitur</label>
								<div class="col">
									<table class="table table-bordered table-sm">
										<tr>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="saldo_awal" {{in_array('saldo_awal', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Saldo Awal</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="saldo_berjalan" {{in_array('saldo_berjalan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Saldo Berjalan</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="inventarisasi" {{in_array('inventarisasi', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Inventarisasi</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="pengadaan" {{in_array('pengadaan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Pengadaan</td>
										</tr>
										<tr>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="hibah" {{in_array('hibah', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Hibah</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="transfer" {{in_array('transfer', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Transfer</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="koreksi" {{in_array('koreksi', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Koreksi</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="penghapusan" {{in_array('penghapusan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Penghapusan</td>
										</tr>
										<tr>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="pelunasan" {{in_array('pelunasan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Pelunasan KDP</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="persetujuan" {{in_array('persetujuan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Persetujuan</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="report" {{in_array('report', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Laporan</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="ruangan" {{in_array('ruangan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Kamus Ruangan</td>
										</tr>
										<tr>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="kegiatan" {{in_array('kegiatan', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Kamus Kegiatan</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="pegawai" {{in_array('pegawai', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Kamus Pegawai</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="organisasi" {{in_array('organisasi', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Kamus Organisasi</td>
											<td class="text-center"><input type="checkbox" name="lock_menu[]" value="kategori" {{in_array('kategori', $pengaturan->lock_menu)?'checked':''}}></td>
											<td>Kamus Kategori</td>
											<td colspan="2"></td>
										</tr>
									</table>
									<p class="form-text text-secondary">Pilih menu &amp fitur yang ingin dikunci.</p>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-lg-2 col-form-label text-right"></label>
								<div class="col-lg-4">
									<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save mr-2"></i>Simpan</button>
									<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-refresh mr-2"></i>Kembalikan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script type="text/javascript">
	var org = (function(){
		theme.activeMenu('.nav-pengaturan');
	})();
</script>
@end