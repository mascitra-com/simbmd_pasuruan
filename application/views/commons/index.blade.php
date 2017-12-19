<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - SIMBMD</title>
    <link rel="stylesheet" href="{{base_url('res/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{base_url('res/plugins/fontawesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{base_url('res/plugins/chosen/chosen.min.css')}}">
    <link rel="stylesheet" href="{{base_url('res/styles/theme.css')}}">
    @yield('style')
</head>
<body>
<?php $message = $this->session->flashdata('message'); ?>
@if(!empty($message))
    <div class="alert alert-{{$message[1]}} fade show fixed-top text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
        <strong>Pesan!</strong> {{$message[0]}}
    </div>
@endif

<div class="container-fluid wrapper">
    @include('commons/sidebar')
    <div id="content">
    @include('commons/header')

    <!-- BREADCRUMP -->
        <ol class="breadcrumb">
            @yield('breadcrump')
        </ol>

        <!-- CONTENT -->
        <div class="container-fluid">
            @yield('widget')
            @yield('content')
        </div>
    </div>
</div>

@yield('modal')

<script type="text/javascript" src="{{base_url('res/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/jquery/jquery.number.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/chosen/chosen.jquery.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/scripts/theme.js')}}"></script>
@yield('script')
<script>
    $(document).ready(function() {
        $("input[name^='nilai'], input[name^='addendum_nilai']").attr('type', 'text');
        @if(isset($kib->nilai))
        $("input[name='nilai']").val($.number({{ $kib->nilai }}, 2, ',', '.'));
        @endif
        @if(isset($kib->nilai_sisa))
        $("input[name='nilai_sisa']").val($.number({{ $kib->nilai_sisa }}, 2, ',', '.'));
        @endif
        @if(isset($kib->nilai_tambah))
        $("input[name='nilai_tambah']").val($.number({{ $kib->nilai_tambah }}, 2, ',', '.'));
        @endif
        @if(isset($kpt->nilai_penunjang))
        $("input[name='nilai_penunjang']").val($.number({{ $kpt->nilai_penunjang }}, 2, ',', '.'));
        @endif
        @if(isset($spk->nilai))
        $("input[name='nilai']").val($.number({{ $spk->nilai }}, 2, ',', '.'));
        @endif
        @if(isset($spk->addendum_nilai))
        $("input[name='addendum_nilai']").val($.number({{ $spk->addendum_nilai }}, 2, ',', '.'));
        @endif
        $("input[name^='nilai'], input[name^='addendum_nilai']").number(true, 2, ',', '.');
    });
</script>
</body>
</html>