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
    <div class="alert alert-{{$message[1]}} fade show fixed-top text-center" style="border-radius: 0">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
        <strong>Pesan!</strong> {{$message[0]}}
    </div>
@endif

<div class="container-fluid wrapper">
    @if($this->config->item('mode')==='jember')
    @include('commons/sidebar_jember')
    @else
    @include('commons/sidebar')
    @endif
    <div id="content">
    @include('commons/header')
        <!-- BREADCRUMP -->
        <nav class="navbar navbar-light mb-4" style="background-color: #e8e8e8;">
            <ol class="breadcrumb px-0 py-0 mx-0 my-0 navbar-text" style="background-color: initial;">
                @yield('breadcrump')
            </ol>
            <div class="navbar-text ml-auto marquee py-0" style="max-width: 50%;overflow: hidden;white-space: nowrap;">{{$this->setting->get('scroll_text')}}</div>
            <span class="navbar-text ml-2 px-2 py-1 font-weight-bold clock-placeholder" style="background-color: #bab8b8"></span>
        </nav>
        <!-- CONTENT -->
        <div class="container-fluid pb-5">
            @yield('widget')
            @yield('content')
        </div>
    </div>
</div>

@yield('modal')

<script type="text/javascript" src="{{base_url('res/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/numeral/numeral.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/chosen/chosen.jquery.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/marquee/marquee.min.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/plugins/clock/clock.js')}}"></script>
<script type="text/javascript" src="{{base_url('res/scripts/theme.js')}}"></script>
@yield('script')
<script type="text/javascript" src="{{base_url('res/scripts/app.js')}}"></script>
</body>
</html>