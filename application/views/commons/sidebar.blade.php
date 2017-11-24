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
			

			<li class="nav nav-title">MUTASI TAMBAH</li>
			<li class="nav nav-invent">
				<a href="#menu-invent" data-toggle="collapse"><i class="fa fa-user fa-fw icon"></i>Inventarisasi<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-invent">
					<li class="nav"><a href="{{site_url('aset/kiba')}}"><i class="fa fa-cubes fa-fw icon"></i>KIB-A</a></li>
					<li class="nav"><a href="{{site_url('aset/kibb')}}"><i class="fa fa-car fa-fw icon"></i>KIB-B</a></li>
					<li class="nav"><a href="{{site_url('aset/kibc')}}"><i class="fa fa-home fa-fw icon"></i>KIB-C</a></li>
					<!-- <li class="nav"><a href="{{site_url('aset/kibc/kdp')}}"><i class="fa fa-home fa-fw icon"></i>KIB-C (KDP)</a></li> -->
					<li class="nav"><a href="{{site_url('aset/kibd')}}"><i class="fa fa-road fa-fw icon"></i>KIB-D</a></li>
					<!-- <li class="nav"><a href="{{site_url('aset/kibd/kdp')}}"><i class="fa fa-road fa-fw icon"></i>KIB-D (KDP)</a></li> -->
					<li class="nav"><a href="{{site_url('aset/kibe')}}"><i class="fa fa-book fa-fw icon"></i>KIB-E</a></li>
					<li class="nav"><a href="{{site_url('aset/kib_non')}}"><i class="fa fa-cogs fa-fw icon"></i>Tidak Diakui Aset</a></li>
					<!-- <li class="nav"><a href="{{site_url('aset/kibf')}}"><i class="fa fa-cube fa-fw icon"></i>KIB-F</a></li> -->
				</ul>
			</li>
			<li class="nav nav-pengadaan"><a href="{{site_url('pengadaan')}}"><i class="fa fa-cart-plus fa-fw icon"></i>Pengadaan</a></li>
			<li class="nav nav-sumber"><a href="#"><i class="fa fa-cubes fa-fw icon"></i>Hibah</a></li>
			<li class="nav nav-sumber"><a href="#"><i class="fa fa-exchange fa-fw icon"></i>Transfer Masuk</a></li>
			
			<li class="nav nav-title">MUTASI KURANG</li>
			<li class="nav nav-transfer"><a href="#"><i class="fa fa-exchange fa-fw icon"></i>Transfer Keluar</a></li>
			<li class="nav nav-hapus"><a href="#"><i class="fa fa-trash fa-fw icon"></i>Penghapusan Aset</a></li>
			
			<li class="nav nav-title">LAPORAN</li>
			<li class="nav nav-rekap-aset">
				<a href="#menu-rekap-aset" data-toggle="collapse"><i class="fa fa-file-o fa-fw icon"></i>Rekap Aset Tetap<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-aset">
					<li class="nav"><a href="{{site_url('report/rekap_aset/index/17')}}"><i class="fa fa-file-o fa-fw icon"></i> Permendagri No.17 thn 2007</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_aset/index/13')}}"><i class="fa fa-file-o fa-fw icon"></i> Permendagri No.13 thn 2006</a></li>
				</ul>
			</li>
			<li class="nav nav-report2"><a href="#"><i class="fa fa-file-o fa-fw icon"></i>Rekap Mutasi Barang</a></li>
			<li class="nav nav-report1"><a href="{{site_url('report/rekap_aset')}}"><i class="fa fa-file-o fa-fw icon"></i>Kartu Inventaris Barang</a></li>


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
			<li class="nav nav-backup">
				<a href="#menu-backup" data-toggle="collapse"><i class="fa fa-user fa-fw icon"></i>Manajemen Data<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-backup">
					<li class="nav"><a href="{{site_url('backup/import')}}"><i class="fa fa-download fa-fw icon"></i>Import Saldo Awal</a></li>
				</ul>
			</li>
			@endif
		</ul>
	</div>
</div>