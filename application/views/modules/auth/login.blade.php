<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SIMBMD KABUPATEN PASURUAN - LOGIN</title>
	<link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{base_url('res/plugins/fontawesome/css/font-awesome.min.css')}}">
	<style>
		html, body {
			background-color: #f7f7f9;
		}

		.container, .row {
			height: 100vh;
			max-height: 100vh;
			overflow-y: hidden;
		}

		.text-bolder { font-weight: 700; }
		.text-bigger { font-size: 2.3em; }
	</style>
</head>
<body>
	<?php $message = $this->session->flashdata('message'); ?>
	@if(!empty($message))
	<div class="alert alert-{{$message[1]}} fade show fixed-top text-center" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
		<strong>Pesan!</strong> {{$message[0]}}
	</div>
	@endif
	<div class="container">
		<div class="row justify-content-center align-items-center">
			<div class="col-md-5">
				<div class="card">
					<div class="card-body">
						<form action="{{site_url('authentication/do_login')}}" method="POST">
						    <div class="mb-4 text-bigger text-center">
						    <img src="http://pkmpurwosari.pasuruankab.go.id/mod/download/dokumen/logo_kab-pasuruan.jpg"
                             alt="Logo Kabupaten Lumajang" class="img-responsive" width="100px">
                            </div>
							<div class="mb-4 text-bigger text-center">
								<span class="text-bolder">SIMBMD</span><span>PASURUAN</span>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input type="text" name="username" class="form-control form-control-lg" placeholder="username" />
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
									<input type="password" name="password" class="form-control form-control-lg" placeholder="password" />
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-lg btn-primary btn-block">Masuk</button>
							</div>
							<div class="form-group mt-0">
								<a href="#">Lupa password? klik disini</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>	
	</div>

	<script src="{{base_url('res/plugins/jquery/jquery.min.js')}}"></script>
	<script src="{{base_url('res/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
	<script>
		$(".alert").fadeTo(2000, 500).fadeOut(500, function(){
			$(".alert").fadeOut(500);
		});
	</script>
</body>
</html>