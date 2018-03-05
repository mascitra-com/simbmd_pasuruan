<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Kartu Inventaris Ruangan</title>
    <link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
    <style type="text/css">
        .text-center {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
<table border="3" width="100%" cellpadding="3">
    <!-- CETAK SUB TOTAL-->
    @for($i=0; $i<count($labels)-1; $i+=2)
        <tr>
            <td rowspan="2" width="75px" text-align="center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Lambang_Kabupaten_Pasuruan.png" alt="Logo Kabupaten Pasuruan" class="img-responsive" width="100%">
            </td>
            <td class="text-center"><h5>{{$labels[$i]->kd_pemilik.'.'.$labels[$i]->kd_bidang.'.'.$labels[$i]->kd_unit.'.'.$labels[$i]->kd_subunit.'.'.$labels[$i]->kd_upb.'.'.$labels[$i]->kd_golongan.'.'.$labels[$i]->kd_kelompok.'.'.$labels[$i]->kd_subkelompok.'.'.$labels[$i]->kd_subsubkelompok.'.'.zerofy($labels[$i]->reg_barang,4)}}</h5></td>
            <td rowspan="2" width="75px" text-align="center">
                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Lambang_Kabupaten_Pasuruan.png" alt="Logo Kabupaten Pasuruan" class="img-responsive" width="100%">
            </td>
            <td class="text-center"><h5>{{$labels[$i+1]->kd_pemilik.'.'.$labels[$i+1]->kd_bidang.'.'.$labels[$i+1]->kd_unit.'.'.$labels[$i+1]->kd_subunit.'.'.$labels[$i+1]->kd_upb.'.'.$labels[$i+1]->kd_golongan.'.'.$labels[$i+1]->kd_kelompok.'.'.$labels[$i+1]->kd_subkelompok.'.'.$labels[$i+1]->kd_subsubkelompok.'.'.zerofy($labels[$i+1]->reg_barang,4)}}</h5></td>
        </tr>
        <tr>
            <td class="text-center"><h5>{{$labels[$i]->nama}}</h5></td>
            <td class="text-center"><h5>{{$labels[$i+1]->nama}}</h5></td>
        </tr>
    @endfor
</table>
<script>
    window.print();
</script>
</body>
</html>