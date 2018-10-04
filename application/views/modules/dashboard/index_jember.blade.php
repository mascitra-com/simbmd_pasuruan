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
                <div class="row">
                    <div class="col"></div>
                    <div class="col col-xl-8 text-center">
                        <h4 class="card-title">Selamat Datang</h4>
                        <p class="card-text">Master Jember ialah manajemen aset terpadu pemerintah Kabupaten Jember yang dirancang untuk memudahkan pengelolaan barang milik daerah khususnya dalam hal penetausahaan aset agar efektif dan efisien.</p>
                    </div>
                    <div class="col"></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col"></div>
                    <div class="col col-xl-8 text-center">
                        <img src="{{base_url('res/img/logo_'.$this->config->item('mode').'.png')}}" alt="Logo Kabupaten Pasuruan" class="img-responsive" width="200px">
                    </div>
                    <div class="col"></div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col col-xl-8 text-center">
                        <p>Badan Pengelolaan Keuangan Dan Aset Daerah (BPKAD) </br>Pemerintah Kabupaten Jember
                        © Copyright {{date('Y')}} Badan Keuangan Daerah Pemerintah Kabupaten Jember.</p>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@end

@section('script')
<script>theme.activeMenu('.nav-dashboard')</script>
@end