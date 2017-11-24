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
		var loading = (function(){
			init();

			function init() {
				$.ajax({
					url:"{{site_url('backup/import/do_process')}}",
					success:function(result){
						if (result==='true') {
							window.location.replace("{{site_url('backup/import/insert')}}")					
						} else {
							$(".fa-spinner").addClass('fa-exclamation-triangle text-danger').removeClass('fa-spinner fa-spin');
							$(".message").html("<span class='text-danger'>Terjadi kesalahan. Terdapat data yang salah atau data kosong atau data terlalu besar. Periksa kembali data anda atau pecah kembali data jika data melebihi kapasitas yang ditentukan.</span>");
						}
					},
					error:function(xhr,status,error){
						$(".fa-spinner").addClass('fa-exclamation-triangle text-danger').removeClass('fa-spinner fa-spin');
						$(".message").html("<span class='text-danger'>Terjadi kesalahan. Terdapat data yang salah atau data kosong atau data terlalu besar. Periksa kembali data anda atau pecah kembali data jika data melebihi kapasitas yang ditentukan.</span>");
					},
					dataType:'html'
				});
			}	
		})();
	</script>
</body>
</html>