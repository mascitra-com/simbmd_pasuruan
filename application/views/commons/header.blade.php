<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<span class="navbar-brand">@yield('title')</span>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<span class="navbar-text ml-auto">{{greetings()}} <strong><a class="text-dark" href="{{site_url('profil')}}">{{ucwords(strtolower($this->session->auth['name']))}}</a></strong></span>
		<span class="navbar-text ml-3">-</span>
		<ul class="navbar-nav ml-2">
			@if($this->session->auth['is_superadmin'] == 1)
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
					<i class="fa fa-bell"></i>
					@if(!empty($notif))
					<i class="fa fa-asterisk badge-notification text-danger pr-0"></i>
					@endif
				</a>
				<div class="dropdown-menu dropdown-notification shadow">
					@if(empty($notif))
					<span class="dropdown-item">
						<p class="text-center">tidak ada notifikasi</p>
					</span>
					@endif

					@foreach($notif AS $key=>$value)
					<a href="{{$value['link']}}" class="dropdown-item d-flex">
						<span class="badge badge-danger mr-2"><i class="fa fa-{{$value['icon']}}"></i></span>
						<p class="text-small">Anda mempunyai <b class="text-danger">{{$value['count']}}</b> pengajuan {{$key}} yang perlu disetujui.</p>
					</a>
					<div class="dropdown-divider"></div>
					@endforeach
				</div>
			</li>
			@endif
			<li class="nav-item"><a class="nav-link" href="{{site_url('profil')}}"><i class="fa fa-user mr-2"></i>Profil</a></li>
			<li class="nav-item"><a class="nav-link" href="{{site_url('keluar')}}"><i class="fa fa-power-off mr-2"></i>Keluar</a></li>
		</ul>
	</div>
</nav>