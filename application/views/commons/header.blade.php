<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<span class="navbar-brand">@yield('title')</span>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<span class="navbar-text ml-auto">{{greetings()}} <strong>{{$this->session->auth['name']}}</strong></span>
		<span class="navbar-text ml-3">|</span>
		<ul class="navbar-nav ml-3">
			<li class="nav-item"><a class="nav-link" href="{{site_url('profil')}}"><i class="fa fa-user mr-2"></i>Profil</a></li>
			<li class="nav-item"><a class="nav-link" href="{{site_url('keluar')}}"><i class="fa fa-power-off mr-2"></i>Keluar</a></li>
		</ul>
	</div>
</nav>