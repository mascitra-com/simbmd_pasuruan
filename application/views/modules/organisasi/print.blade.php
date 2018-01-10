<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cetak UPB</title>
	<link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
	<style type="text/css">
		td,th{font-size: .8em;}
	</style>
</head>
<body>
	<table class="table table-bordered table-sm">
		<thead>
			<tr>
				<th class="text-center">No.</th>
				<th class="text-center">ID</th>
				<th>NAMA ORGANISASI</th>
			</tr>
		</thead>
		<tbody>
			@foreach($upb AS $no=>$item)
			<tr>
				<td class="text-center">{{zerofy($no+1,3)}}</td>
				<td class="text-center">{{$item->id}}</td>
				<td>{{$item->nama}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<script type="text/javascript">
		window.print();
	</script>
</body>
</html>