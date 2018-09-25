<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Proses Import - SIMBMD</title>
	<link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{base_url('res/plugins/fontawesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{base_url('res/styles/theme.css')}}">
	<style type="text/css">
	html,body{max-height: 100vh;overflow: hidden;}
	.card {height: 90vh;}
	.message{font-size: 1.5em;}
</style>
</head>
<body>
	<div class="container mt-4">
		<div class="card d-flex align-items-center">
			<div class="card-body text-center d-flex align-items-center">
				<p>
					<i class="fa fa-5x fa-spinner fa-spin mb-4"></i>
					<br>
					<span class="message">Mengekstrak data, mohon tunggu....</span>
				</p>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="{{base_url('res/plugins/jquery/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('res/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{base_url('res/scripts/theme.js')}}"></script>
	<script type="text/javascript">
		$.getJSON("{{site_url('backup/import/do_import')}}", function(result){
			if (result.status === 'success') {
				var url = "{{site_url('backup/import')}}";
				$(".fa").removeClass('fa-spinner fa-spin').addClass('fa-check');
				$(".message").empty().html("data berhasil diimport.<br><a href='"+url+"'>Kembali</a>");
			}
		});
	</script>
</body>
</html>