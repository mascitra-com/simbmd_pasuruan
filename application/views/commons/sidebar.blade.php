<?php $locked = $this->setting->get('lock_menu'); ?>
<div id="sidebar" {{$this->config->item('mode')==='jember'?"style='background-color:".$this->setting->get('web_color')."'":""}}>
	<div class="wrapper">
		<div class="title">
			<h3 class="mb-0 text-bolder">{{$this->setting->get('web_name')}}</h3>
			<span>{{$this->setting->get('web_desc')}}</span>
		</div>
		<ul class="sidebar-nav pb-5">
			<li class="nav nav-title">UTAMA</li>
			<li class="nav nav-dashboard"><a href="{{site_url()}}"><i class="fa fa-dashboard fa-fw icon"></i>Beranda</a></li>
			<li class="nav nav-profil"><a href="{{site_url('profil')}}"><i class="fa fa-user fa-fw icon"></i>Profil</a></li>
			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-pengaturan"><a href="{{site_url('pengaturan')}}"><i class="fa fa-cog fa-fw icon"></i>Pengaturan</a></li>
			@endif

			<li class="nav nav-title">ASET</li>
			<li class="nav nav-saldo-awal">
				<a href="{{set_lock_link($locked,'saldo_awal','#menu-saldo-awal')}}" data-toggle="collapse"><i class="fa fa-cloud-download fa-fw icon"></i>Saldo Awal{{set_lock_icon($locked,'saldo_awal')}}<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-saldo-awal">
					<li class="nav"><a href="{{site_url('aset/kiba?source=saldo')}}"><i class="fa fa-cubes fa-fw icon"></i>A. Tanah</a></li>
					<li class="nav"><a href="{{site_url('aset/kibb?source=saldo')}}"><i class="fa fa-car fa-fw icon"></i>B. Peralatan &amp Mesin</a></li>
					<li class="nav"><a href="{{site_url('aset/kibc?source=saldo')}}"><i class="fa fa-home fa-fw icon"></i>C. Gedung &amp Bangunan</a></li>
					<li class="nav"><a href="{{site_url('aset/kibd?source=saldo')}}"><i class="fa fa-road fa-fw icon"></i>D. Jalan, Irigasi &amp Jaringan</a></li>
					<li class="nav"><a href="{{site_url('aset/kibe?source=saldo')}}"><i class="fa fa-book fa-fw icon"></i>E. Buku, Barang &amp Kebudayaan</a></li>
					<li class="nav"><a href="{{site_url('aset/kibg?source=saldo')}}"><i class="fa fa-window-restore fa-fw icon"></i>G. Aset Lainnya</a></li>
				</ul>
			</li>
			<li class="nav nav-saldo-berjalan">
				<a href="{{set_lock_link($locked,'saldo_berjalan','#menu-saldo-berjalan')}}" data-toggle="collapse"><i class="fa fa-cloud-upload fa-fw icon"></i>Saldo Berjalan{{set_lock_icon($locked,'saldo_berjalan')}}<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-saldo-berjalan">
					<li class="nav"><a href="{{site_url('aset/kiba?source=berjalan')}}"><i class="fa fa-cubes fa-fw icon"></i>A. Tanah</a></li>
					<li class="nav"><a href="{{site_url('aset/kibb?source=berjalan')}}"><i class="fa fa-car fa-fw icon"></i>B. Peralatan &amp Mesin</a></li>
					<li class="nav"><a href="{{site_url('aset/kibc?source=berjalan')}}"><i class="fa fa-home fa-fw icon"></i>C. Gedung &amp Bangunan</a></li>
					<li class="nav"><a href="{{site_url('aset/kibd?source=berjalan')}}"><i class="fa fa-road fa-fw icon"></i>D. Jalan, Irigasi &amp Jaringan</a></li>
					<li class="nav"><a href="{{site_url('aset/kibe?source=berjalan')}}"><i class="fa fa-book fa-fw icon"></i>E. Buku, Barang &amp Kebudayaan</a></li>
					<li class="nav"><a href="{{site_url('aset/kibg?source=berjalan')}}"><i class="fa fa-window-restore fa-fw icon"></i>G. Aset Lainnya</a></li>
				</ul>
			</li>

			<li class="nav nav-title">MUTASI TAMBAH</li>
			<li class="nav nav-invent">
				<a href="{{set_lock_link($locked,'inventarisasi',site_url('inventarisasi/index'))}}"><i class="fa fa-archive fa-fw icon"></i>Inventarisasi{{set_lock_icon($locked,'inventarisasi')}}<span class="badge badge-warning text-dark ml-2 mt-1">baru</span></a>
			</li>
			<!--PENGADAAN -->
			<li class="nav nav-pengadaan">
				<a href="{{set_lock_link($locked,'pengadaan',site_url('pengadaan/index'))}}"><i class="fa fa-cart-plus fa-fw icon"></i>Pengadaan{{set_lock_icon($locked,'pengadaan')}}</a>
			</li>
			<!-- HIBAH -->
			<li class="nav nav-hibah">
				<a href="{{set_lock_link($locked,'hibah',site_url('hibah/index'))}}"><i class="fa fa-cubes fa-fw icon"></i>Hibah{{set_lock_icon($locked,'hibah')}}</a>
			</li>
			<!-- TRANSFER MASUK -->
			<li class="nav nav-transfer-masuk">
				<a href="{{set_lock_link($locked,'transfer',site_url('transfer/index/masuk'))}}"><i class="fa fa-exchange fa-fw icon"></i>Transfer Masuk{{set_lock_icon($locked,'transfer')}}</a>
			</li>
			<!-- KOREKSI -->
			<li class="nav nav-koreksi-tambah">
				<a href="{{set_lock_link($locked,'koreksi','#menu-koreksi-tambah')}}" data-toggle="collapse">
					<i class="fa fa-refresh fa-fw icon"></i>Tambah Lainnya{{set_lock_icon($locked,'koreksi')}}<i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-koreksi-tambah">
					<li class="nav"><a href="{{site_url('koreksi/nilai')}}"><i class="fa fa-money fa-fw icon"></i>1. Koreksi Nilai</a></li>
					<li class="nav"><a href="{{site_url('koreksi/kepemilikan')}}"><i class="fa fa-user fa-fw icon"></i>2. Koreksi Kepemilikan</a></li>
					<li class="nav"><a href="{{site_url('koreksi/kode')}}"><i class="fa fa-tag fa-fw icon"></i>3. Reklas Kode</a></li>
				</ul>
			</li>

			<li class="nav nav-title">MUTASI KURANG</li>
			<!-- TRANSFER KELUAR -->
			<li class="nav nav-transfer-keluar">
				<a href="{{set_lock_link($locked,'transfer',site_url('transfer/index/keluar'))}}"><i class="fa fa-exchange fa-fw icon"></i>Transfer Keluar{{set_lock_icon($locked,'transfer')}}</a>
			</li>
			<!-- PENGHAPUSAN -->
			<li class="nav nav-penghapusan">
				<a href="{{set_lock_link($locked,'penghapusan',site_url('penghapusan/index'))}}"><i class="fa fa-trash fa-fw icon"></i>Penghapusan Aset{{set_lock_icon($locked,'penghapusan')}}</a>
			</li>
			<!-- KOREKSI HAPUS -->
			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-koreksi-kurang">
				<a href="{{set_lock_link($locked,'koreksi','#menu-koreksi-kurang')}}" data-toggle="collapse">
					<i class="fa fa-refresh fa-fw icon"></i>Kurang Lainnya{{set_lock_icon($locked,'koreksi')}}<i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-koreksi-kurang">
					<li class="nav"><a href="{{site_url('koreksi/hapus')}}"><i class="fa fa-trash fa-fw icon"></i>4. Koreksi Hapus</a></li>
				</ul>
			</li>
			@endif

			<li class="nav nav-title">LAINNYA</li>
			<li class="nav nav-pelunasan">
				<a href="{{set_lock_link($locked,'pelunasan',site_url('pelunasan/index'))}}"><i class="fa fa-dollar fa-fw icon"></i>Pelunasan KDP{{set_lock_icon($locked,'pelunasan')}}</a>
			</li>
			<li class="nav nav-koreksi-atribut">
				<a href="{{set_lock_link($locked,'koreksi_atribut',site_url('koreksi/atribut/index'))}}"><i class="fa fa-puzzle-piece fa-fw icon"></i>Koreksi Atribut{{set_lock_icon($locked,'koreksi_atribut')}}<span class="badge badge-warning text-dark ml-2 mt-1">baru</span></a>
			</li>

			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-title">PERSETUJUAN</li>
			<li class="nav nav-persetujuan-pengadaan nav-persetujuan-hibah nav-invent">
				<a href="{{set_lock_link($locked,'persetujuan','#menu-persetujuan-tambah')}}" data-toggle="collapse">
					<i class="fa fa-download fa-fw icon"></i>Mutasi Tambah{{set_lock_icon($locked,'persetujuan')}}<i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-persetujuan-tambah">
					<li class="nav"><a href="{{site_url('persetujuan/inventarisasi')}}"><i class="fa fa-check fa-fw icon"></i>Inventarisasi</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/pengadaan')}}"><i class="fa fa-check fa-fw icon"></i>Pengadaan</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/hibah')}}"><i class="fa fa-check fa-fw icon"></i>Hibah</a></li>
				</ul>
			</li>
			<li class="nav nav-persetujuan-transfer nav-persetujuan-hapus">
				<a href="{{set_lock_link($locked,'persetujuan','#menu-persetujuan-kurang')}}" data-toggle="collapse">
					<i class="fa fa-upload fa-fw icon"></i>Mutasi Kurang{{set_lock_icon($locked,'persetujuan')}}<i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-persetujuan-kurang">
					<li class="nav"><a href="{{site_url('persetujuan/transfer')}}"><i class="fa fa-check fa-fw icon"></i>Transfer Keluar</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/penghapusan')}}"><i class="fa fa-check fa-fw icon"></i>Penghapusan Aset</a></li>
				</ul>
			</li>
			<li class="nav nav-persetujuan-koreksi">
				<a href="{{set_lock_link($locked,'persetujuan','#menu-persetujuan-koreksi')}}" data-toggle="collapse">
					<i class="fa fa-refresh fa-fw icon"></i>Koreksi{{set_lock_icon($locked,'persetujuan')}}<i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-persetujuan-koreksi">
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_nilai')}}"><i class="fa fa-money fa-fw icon"></i>1. Koreksi Nilai</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_kepemilikan')}}"><i class="fa fa-user fa-fw icon"></i>2. Koreksi Kepemilikan</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_kode')}}"><i class="fa fa-tag fa-fw icon"></i>3. Reklas Kode</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_hapus')}}"><i class="fa fa-trash fa-fw icon"></i>4. Koreksi Hapus</a></li>
					<li class="nav"><a href="{{site_url('persetujuan/koreksi_atribut')}}"><i class="fa fa-puzzle-piece fa-fw icon"></i>5. Koreksi Atribut</a></li>
				</ul>
			</li>
			@endif

			<li class="nav nav-title">LAPORAN</li>
			<li class="nav nav-rekap-aset">
				<a href="{{set_lock_link($locked,'report','#menu-rekap-aset')}}" data-toggle="collapse">
					<i class="fa fa-cubes fa-fw icon"></i>Aset Tetap{{set_lock_icon($locked,'report')}}<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-aset">
					<li class="nav"><a href="{{site_url('report/rekap_aset/index/17')}}"><i class="fa fa-file-o fa-fw icon"></i> Permendagri No.17 thn 2007</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_aset/index/13')}}"><i class="fa fa-file-o fa-fw icon"></i> Permendagri No.13 thn 2006</a></li>
				</ul>
			</li>
			<li class="nav nav-rekap-mutasi">
				<a href="{{set_lock_link($locked,'report','#menu-rekap-mutasi-tambah')}}" data-toggle="collapse">
					<i class="fa fa-download fa-fw icon"></i>Mutasi{{set_lock_icon($locked,'report')}}
					<span class="badge badge-warning text-dark ml-2 mt-1">baru</span><i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-mutasi-tambah">
					<li class="nav"><a href="{{site_url('report/rekap_inventarisasi/')}}"><i class="fa fa-file-o fa-fw icon"></i> Inventarisasi</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_pengadaan/')}}"><i class="fa fa-file-o fa-fw icon"></i> Pengadaan</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_hibah/')}}"><i class="fa fa-file-o fa-fw icon"></i> Hibah</a></li>
					<li class="nav nav-rekap-transfer"><a href="{{site_url('report/rekap_transfer')}}"><i class="fa fa-file-o fa-fw icon"></i>Transfer</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_penghapusan/')}}"><i class="fa fa-file-o fa-fw icon"></i> Penghapusan</a></li>
				</ul>
			</li>
			<li class="nav nav-rekap-lainnya">
				<a href="{{set_lock_link($locked,'report','#menu-rekap-lainnya')}}" data-toggle="collapse">
					<i class="fa fa-file-o fa-fw icon"></i>Lainnya{{set_lock_icon($locked,'report')}}<i class="fa fa-angle-down ml-auto"></i>
				</a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-rekap-lainnya">
					<li class="nav"><a href="{{site_url('report/rekap_kib_non')}}"><i class="fa fa-file-o fa-fw icon"></i>Rekap Non-Aset</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_ekstrakomtabel')}}"><i class="fa fa-file-o fa-fw icon"></i>Rekap Ekstrakomtabel</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_kib')}}"><i class="fa fa-file-o fa-fw icon"></i>Kartu Inventaris Barang</a></li>
					<li class="nav"><a href="{{site_url('report/rekap_ruangan')}}"><i class="fa fa-file-o fa-fw icon"></i>Kartu Inventaris Ruangan</a></li>
					<li class="nav"><a href="{{site_url('label')}}"><i class="fa fa-file-o fa-fw icon"></i>Labelisasi Barang</a></li>
				</ul>
			</li>
			@if($this->session->auth['is_admin'] == 1)
			<li class="nav nav-title">KAMUS</li>
			<li class="nav nav-ruangan">
				<a href="{{set_lock_link($locked,'ruangan',site_url('ruangan/index'))}}"><i class="fa fa-cube fa-fw icon"></i>Ruangan{{set_lock_icon($locked,'ruangan')}}</a>
			</li>
			<li class="nav nav-kegiatan">
				<a href="{{set_lock_link($locked,'kegiatan',site_url('kegiatan/index'))}}"><i class="fa fa-cart-plus fa-fw icon"></i>Kegiatan{{set_lock_icon($locked,'kegiatan')}}</a>
			</li>
			<li class="nav nav-pegawai">
				<a href="{{set_lock_link($locked,'pegawai',site_url('pegawai/index'))}}"><i class="fa fa-users fa-fw icon"></i>Pegawai{{set_lock_icon($locked,'pegawai')}}</a>
			</li>
			@endif

			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav nav-title">KAMUS (SUPERADMIN)</li>
			<li class="nav nav-organisasi">
				<a href="{{set_lock_link($locked,'organisasi',site_url('organisasi/index'))}}"><i class="fa fa-briefcase fa-fw icon"></i>Organisasi{{set_lock_icon($locked,'organisasi')}}</a>
			</li>
			<li class="nav nav-kategori">
				<a href="{{set_lock_link($locked,'kategori',site_url('kategori/index'))}}"><i class="fa fa-tag fa-fw icon"></i>Kategori{{set_lock_icon($locked,'kategori')}}</a>
			</li>
			
			<li class="nav nav-title">PERALATAN</li>
			<li class="nav nav-backup mb-4">
				<a href="#menu-backup" data-toggle="collapse"><i class="fa fa-user fa-fw icon"></i>Manajemen Data<i class="fa fa-angle-down ml-auto"></i></a>
				<ul class="sidebar-nav sidebar-child collapse collapseable" id="menu-backup">
					<li class="nav"><a href="{{site_url('backup/import')}}"><i class="fa fa-download fa-fw icon"></i>Import Saldo Awal</a></li>
					<!-- <li class="nav"><a href="{{site_url('peralatan/hapus_data')}}"><i class="fa fa-trash fa-fw icon"></i>Kosongkan Data</a></li> -->
				</ul>
			</li>
			@endif
		</ul>
	</div>
</div>