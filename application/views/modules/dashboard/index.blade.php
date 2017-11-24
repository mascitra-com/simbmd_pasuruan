@layout('commons/index')
@section('title')Beranda@end

@section('breadcrump')
<li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
<li class="breadcrumb-item active">Dashboard</li>
@end

@section('content')
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Selamat Datang</h4>
				<p class="card-text"><p>SIMBMD Online adalah kepanjangan dari Sistem Informasi Manajemen Barang Milik Daerah berbasis Online</p>

<p>Sistem ini dibangun untuk mempermudah, mempercepat proses-proses pengelolaan barang dan aset, memperkecil kesalahan data dan pemrosesan dengan cara mengurangi hal-hal yang bersifat manual, diganti dengan berbasis mesin elektronik.</p>
                <img src="http://pkmpurwosari.pasuruankab.go.id/mod/download/dokumen/logo_kab-pasuruan.jpg"
                             alt="Logo Kabupaten Lumajang" class="img-responsive" width="200px"></br></br>
                <p>Badan Keuangan Daerah (BKD) </br>Pemerintah Kabupaten Pasuruan</br>Jl. Hayam Wuruk No. 14 Pasuruan - Jawa Timur - Indonesia</p>
                </p>
                <p>© Copyright 2017 Badan Keuangan Daerah Pemerintah Kabupaten Pasuruan. Powered by <a href="https://mascitra.com">mascitra.com</a></p>
			</div>
		</div>
	</div>
</div>
@end

@section('script')
<script>theme.activeMenu('.nav-dashboard')</script>
@end
