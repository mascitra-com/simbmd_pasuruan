<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Proses Import - SIMBMD</title>
	<link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{base_url('res/plugins/fontawesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{base_url('res/styles/theme.css')}}">
	<style type="text/css">
	.message{font-size: 1.5em;}
</style>
</head>
<body>
	<div class="container mt-4">
		<div class="card">
			<div class="card-body table-responsive table-scroll">
				<h3>Data berikut memiliki kesalahan. Periksa kembali data anda.</h3>
				<table class="table table-bordered table-striped table-sm mt-4">
					@foreach($this->session->temp_import['data_error'] AS $data)
					<tbody>
						<tr>
							<td class="text-nowrap">Baris ke-{{$data['baris_ke']}}</td>
							@foreach($data['data'] AS $index=>$value)
							<td class="text-nowrap">{{$value}}</td>
							@endforeach
						</tr>
					</tbody>
					@endforeach
				</table>
				<a href="{{site_url('backup/import')}}" class="btn btn-warning">Kembali</a>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{{base_url('res/plugins/jquery/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('res/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('res/scripts/theme.js')}}"></script>
</body>
</html>