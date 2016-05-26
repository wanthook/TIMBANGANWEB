@extends('layouts.app')

@section('additional_style')
<link href="{{ asset('/assets/css/select2.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
@endsection

@section('additional_js')
@include('admin.snap.script')
@endsection

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li><a href="{{ route('snap.tabel') }}">Snap</a> <span class="separator"></span></li>
<li>Form Edit Snap</li>
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-list-alt"></span></div>
<div class="pagetitle">
    <h5>Form Edit Snap</h5>
    <h1>Form</h1>
</div>
@endsection

@section('maincontent')
<div class="widgetbox box-inverse">
    <h4 class="widgettitle">Form Edit Snap</h4>
    <div class="widgetcontent">
        {!! Form::model($snap,['method' => 'PATCH', 'route' => ['snap.ubah',$snap->id],'class' => 'stdform']) !!}
        @include ('admin.snap.form')
        {!! Form::close() !!}
    </div><!--widgetcontent-->
</div>
@endsection