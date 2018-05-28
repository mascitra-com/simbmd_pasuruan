<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<span class="navbar-brand">@yield('title')</span>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<span class="navbar-text ml-auto">{{greetings()}} <strong><a class="text-dark" href="{{site_url('profil')}}">{{$this->session->auth['name']}}</a></strong></span>
		<span class="navbar-text ml-2">|</span>
		<ul class="navbar-nav ml-2">
			<!-- NOTIF HERE -->
			<!-- <li class="nav-item dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Notification (<b>2</b>)</a>
				<ul class="dropdown-menu notify-drop">
					<div class="notify-drop-title">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-6">Bildirimler (<b>2</b>)</div>
							<div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="tümü okundu."><i class="fa fa-dot-circle-o"></i></a></div>
						</div>
					</div> -->
					<!-- end notify title -->
					<!-- notify content -->
					<!-- <div class="drop-content">
						<li>
							<div class="col-md-3 col-sm-3 col-xs-3"><div class="notify-img"><img src="http://placehold.it/45x45" alt=""></div></div>
							<div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="">Ahmet</a> yorumladı. <a href="">Çicek bahçeleri...</a> <a href="" class="rIcon"><i class="fa fa-dot-circle-o"></i></a>

								<hr>
								<p class="time">Şimdi</p>
							</div>
						</li>
						<li>
							<div class="col-md-3 col-sm-3 col-xs-3"><div class="notify-img"><img src="http://placehold.it/45x45" alt=""></div></div>
							<div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="">Ahmet</a> yorumladı. <a href="">Çicek bahçeleri...</a> <a href="" class="rIcon"><i class="fa fa-dot-circle-o"></i></a>
								<p>Lorem ipsum sit dolor amet consilium.</p>
								<p class="time">1 Saat önce</p>
							</div>
						</li>
						<li>
							<div class="col-md-3 col-sm-3 col-xs-3"><div class="notify-img"><img src="http://placehold.it/45x45" alt=""></div></div>
							<div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="">Ahmet</a> yorumladı. <a href="">Çicek bahçeleri...</a> <a href="" class="rIcon"><i class="fa fa-dot-circle-o"></i></a>
								<p>Lorem ipsum sit dolor amet consilium.</p>
								<p class="time">29 Dakika önce</p>
							</div>
						</li>
						<li>
							<div class="col-md-3 col-sm-3 col-xs-3"><div class="notify-img"><img src="http://placehold.it/45x45" alt=""></div></div>
							<div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="">Ahmet</a> yorumladı. <a href="">Çicek bahçeleri...</a> <a href="" class="rIcon"><i class="fa fa-dot-circle-o"></i></a>
								<p>Lorem ipsum sit dolor amet consilium.</p>
								<p class="time">Dün 13:18</p>
							</div>
						</li>
						<li>
							<div class="col-md-3 col-sm-3 col-xs-3"><div class="notify-img"><img src="http://placehold.it/45x45" alt=""></div></div>
							<div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="">Ahmet</a> yorumladı. <a href="">Çicek bahçeleri...</a> <a href="" class="rIcon"><i class="fa fa-dot-circle-o"></i></a>
								<p>Lorem ipsum sit dolor amet consilium.</p>
								<p class="time">2 Hafta önce</p>
							</div>
						</li>
					</div>
					<div class="notify-drop-footer text-center">
						<a href=""><i class="fa fa-eye"></i> Tümünü Göster</a>
					</div>
				</ul>
			</li> -->
			<!-- END NOTIF -->
			<li class="nav-item"><a class="nav-link" href="{{site_url('profil')}}"><i class="fa fa-user mr-2"></i>Profil</a></li>
			<li class="nav-item"><a class="nav-link" href="{{site_url('keluar')}}"><i class="fa fa-power-off mr-2"></i>Keluar</a></li>
		</ul>
	</div>
</nav>