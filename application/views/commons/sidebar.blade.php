<div id="sidebar">
	<div class="wrapper">
		<div class="title">
			<h3 class="mb-0 text-bolder">SIMBMD</h3>
			<span>Pasuruan</span>
		</div>
		<ul class="sidebar-nav">
			<li class="nav nav-title">UTAMA</li>
			<li class="nav nav-dashboard"><a href="{{site_url()}}"><i class="fa fa-dashboard fa-fw icon"></i>Beranda</a></li>
			<li class="nav nav-profil"><a href="{{site_url('profil')}}"><i class="fa fa-user fa-fw icon"></i>Profil</a></li>
			<li class="nav nav-notifikasi"><a href="{{site_url('notifikasi')}}"><i class="fa fa-bell fa-fw icon"></i>Notifikasi</a></li>
			<li class="nav nav-saldo-awal">
				<a href="#menu-saldo-awal" data-toggle="collapse"><i class="fa fa-cloud-download fa-fw icon"></i>Saldo Awal<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-saldo-awal">
					<li class="nav"><a href="{{site_url('saldo_awal/kiba')}}"><i class="fa fa-cubes fa-fw icon"></i>KIB-A</a></li>
					<li class="nav"><a href="{{site_url('saldo_awal/kibb')}}"><i class="fa fa-car fa-fw icon"></i>KIB-B</a></li>
					<li class="nav"><a href="{{site_url('saldo_awal/kibc')}}"><i class="fa fa-home fa-fw icon"></i>KIB-C</a></li>
					<li class="nav"><a href="{{site_url('saldo_awal/kibd')}}"><i class="fa fa-road fa-fw icon"></i>KIB-D</a></li>
					<li class="nav"><a href="{{site_url('saldo_awal/kibe')}}"><i class="fa fa-book fa-fw icon"></i>KIB-E</a></li>
					<li class="nav"><a href="#"><i class="fa fa-cogs fa-fw icon"></i>Extracomtable</a></li>
				</ul>
			</li>

			<li class="nav nav-title">MUTASI TAMBAH</li>
			<li class="nav nav-invent">
				<a href="#menu-invent" data-toggle="collapse"><i class="fa fa-cloud-upload fa-fw icon"></i>Inventarisasi<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-invent">
					<li class="nav"><a href="{{site_url('inventarisasi/kiba')}}"><i class="fa fa-cubes fa-fw icon"></i>KIB-A</a></li>
					<li class="nav"><a href="{{site_url('inventarisasi/kibb')}}"><i class="fa fa-car fa-fw icon"></i>KIB-B</a></li>
					<li class="nav"><a href="{{site_url('inventarisasi/kibc')}}"><i class="fa fa-home fa-fw icon"></i>KIB-C</a></li>
					<li class="nav"><a href="{{site_url('inventarisasi/kibd')}}"><i class="fa fa-road fa-fw icon"></i>KIB-D</a></li>
					<li class="nav"><a href="{{site_url('inventarisasi/kibe')}}"><i class="fa fa-book fa-fw icon"></i>KIB-E</a></li>
					<li class="nav"><a href="{{site_url('inventarisasi/kibnon')}}"><i class="fa fa-cogs fa-fw icon"></i>Tidak Diakui Aset</a></li>
				</ul>
			</li>
			<li class="nav nav-pengadaan"><a href="{{site_url('pengadaan/index')}}"><i class="fa fa-cart-plus fa-fw icon"></i>Pengadaan</a></li>
			<li class="nav nav-hibah"><a href="{{site_url('hibah/index')}}"><i class="fa fa-cubes fa-fw icon"></i>Hibah</a></li>
			<li class="nav nav-transfer-masuk"><a href="{{ site_url('transfer/index/masuk') }}"><i class="fa fa-exchange fa-fw icon"></i>Transfer Masuk</a></li>
			<li class="nav nav-koreksi-tambah">
				<a href="#menu-koreksi-tambah" data-toggle="collapse"><i class="fa fa-refresh fa-fw icon"></i>Tambah Lainnya<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-koreksi-tambah">
					<li class="nav"><a href="{{site_url('koreksi/nilai')}}"><i class="fa fa-money fa-fw icon"></i>1. Koreksi Nilai</a></li>
					<li class="nav"><a href="{{site_url('koreksi/kepemilikan')}}"><i class="fa fa-user fa-fw icon"></i>2. Koreksi Kepemilikan</a></li>
					<li class="nav"><a href="{{site_url('koreksi/kode')}}"><i class="fa fa-tag fa-fw icon"></i>3. Reklas Kode</a></li>
				</ul>
			</li>

			<li class="nav nav-title">MUTASI KURANG</li>
			<li class="nav nav-transfer-keluar"><a href="{{ site_url('transfer/index/keluar') }}"><i class="fa fa-exchange fa-fw icon"></i>Transfer Keluar</a></li>
			<li class="nav nav-penghapusan"><a href="{{ site_url('penghapusan/index') }}"><i class="fa fa-trash fa-fw icon"></i>Penghapusan Aset</a></li>
			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-koreksi-kurang">
				<a href="#menu-koreksi-kurang" data-toggle="collapse"><i class="fa fa-refresh fa-fw icon"></i>Kurang Lainnya<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-koreksi-kurang">
					<li class="nav"><a href="{{site_url('koreksi/hapus')}}"><i class="fa fa-trash fa-fw icon"></i>4. Koreksi Hapus</a></li>
				</ul>
			</li>
			@endif

			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-title">PERSETUJUAN</li>
			<li class="nav nav-persetujuan-pengadaan nav-persetujuan-hibah">
				<a href="#persetujuan-tambah" data-toggle="collapse"><i class="fa fa-download fa-fw icon"></i>Mutasi Tambah<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="persetujuan-tambah">
					<li class="nav"><a href="{{site_url('persetujuan/pengadaan')}}"><i class="fa fa-check fa-fw icon"></i>Pengadaan</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/hibah')}}"><i class="fa fa-check fa-fw icon"></i>Hibah</a></li>
				</ul>
			</li>
			<li class="nav nav-persetujuan-transfer nav-persetujuan-hapus">
				<a href="#persetujuan-kurang" data-toggle="collapse"><i class="fa fa-upload fa-fw icon"></i>Mutasi Kurang<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="persetujuan-kurang">
					<li class="nav"><a href="{{site_url('persetujuan/transfer')}}"><i class="fa fa-check fa-fw icon"></i>Transfer Keluar</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/penghapusan')}}"><i class="fa fa-check fa-fw icon"></i>Penghapusan Aset</a></li>
				</ul>
			</li>
			<li class="nav nav-persetujuan-koreksi">
				<a href="#persetujuan-koreksi" data-toggle="collapse"><i class="fa fa-refresh fa-fw icon"></i>Koreksi<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="persetujuan-koreksi">
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_nilai')}}"><i class="fa fa-money fa-fw icon"></i>1. Koreksi Nilai</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_kepemilikan')}}"><i class="fa fa-user fa-fw icon"></i>2. Koreksi Kepemilikan</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_kode')}}"><i class="fa fa-tag fa-fw icon"></i>3. Reklas Kode</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_hapus')}}"><i class="fa fa-trash fa-fw icon"></i>4. Koreksi Hapus</a></li>
				</ul>
			</li>
			@endif

			<li class="nav nav-title">LAPORAN</li>
			<li class="nav nav-rekap-aset">
				<a href="#menu-rekap-aset" data-toggle="collapse"><i class="fa fa-file-o fa-fw icon"></i>Rekap Aset Tetap<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-aset">
					<li class="nav"><a href="{{site_url('report/rekap_aset/index/17')}}"><i class="fa fa-file-o fa-fw icon"></i> Permendagri No.17 thn 2007</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_aset/index/13')}}"><i class="fa fa-file-o fa-fw icon"></i> Permendagri No.13 thn 2006</a></li>
				</ul>
			</li>
			<li class="nav nav-rekap-mutasi-tambah">
				<a href="#menu-rekap-mutasi-tambah" data-toggle="collapse"><i class="fa fa-file-o fa-fw icon"></i>Rekap Mutasi Tambah<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-mutasi-tambah">
					<li class="nav"><a href="{{site_url('report/rekap_pengadaan/')}}"><i class="fa fa-file-o fa-fw icon"></i> Pengadaan</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_hibah/')}}"><i class="fa fa-file-o fa-fw icon"></i> Hibah</a></li>
				</ul>
			</li>
			<li class="nav nav-rekap-mutasi-kurang">
				<a href="#menu-rekap-mutasi-kurang" data-toggle="collapse"><i class="fa fa-file-o fa-fw icon"></i>Rekap Mutasi Kurang<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-mutasi-kurang">
					<li class="nav nav-rekap-transfer"><a href="{{site_url('report/rekap_transfer')}}"><i class="fa fa-file-o fa-fw icon"></i>Transfer Keluar</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_penghapusan/')}}"><i class="fa fa-file-o fa-fw icon"></i> Penghapusan</a></li>
				</ul>
			</li>
			<li class="nav nav-rekap-kib"><a href="{{site_url('report/rekap_kib')}}"><i class="fa fa-file-o fa-fw icon"></i>Kartu Inventaris Barang</a></li>
			<li class="nav nav-rekap-ruangan"><a href="{{site_url('report/rekap_ruangan')}}"><i class="fa fa-file-o fa-fw icon"></i>Kartu Inventaris Ruangan</a></li>
			<li class="nav nav-label"><a href="{{site_url('label')}}"><i class="fa fa-file-o fa-fw icon"></i>Labelisasi Barang</a></li>


			@if($this->session->auth['is_admin'] == 1)
			<li class="nav nav-title">KAMUS</li>
			<li class="nav nav-ruangan"><a href="{{site_url('ruangan')}}"><i class="fa fa-cube fa-fw icon"></i>Ruangan</a></li>
			<li class="nav nav-kegiatan"><a href="{{site_url('kegiatan')}}"><i class="fa fa-cart-plus fa-fw icon"></i>Kegiatan</a></li>
			<li class="nav nav-pegawai"><a href="{{site_url('pegawai')}}"><i class="fa fa-users fa-fw icon"></i>Pegawai</a></li>
			@endif

			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-title">KAMUS (PRIVAT)</li>
			<li class="nav nav-organisasi"><a href="{{site_url('organisasi')}}"><i class="fa fa-briefcase fa-fw icon"></i>Organisasi</a></li>
			<li class="nav nav-kategori"><a href="{{site_url('kategori')}}"><i class="fa fa-tag fa-fw icon"></i>Kategori</a></li>
			
			<li class="nav nav-title">PERALATAN</li>
			<li class="nav nav-backup mb-4">
				<a href="#menu-backup" data-toggle="collapse"><i class="fa fa-user fa-fw icon"></i>Manajemen Data<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-backup">
					<li class="nav"><a href="{{site_url('backup/import')}}"><i class="fa fa-download fa-fw icon"></i>Import Saldo Awal</a></li>
					<li class="nav"><a href="{{site_url('peralatan/hapus_data')}}"><i class="fa fa-trash fa-fw icon"></i>Kosongkan Data</a></li>
				</ul>
			</li>
			@endif
		</ul>
	</div>
</div>