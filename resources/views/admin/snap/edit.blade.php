@extends('layouts.app')

@section('additional_style')
@endsection

@section('additional_js')
@endsection

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li><a href="{{ route('mesin.tabel') }}">Machine</a> <span class="separator"></span></li>
<li>Form Edit Machine</li>
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-list-alt"></span></div>
<div class="pagetitle">
    <h5>Form Edit Machine</h5>
    <h1>Form</h1>
</div>
@endsection

@section('maincontent')
<div class="widgetbox box-inverse">
    <h4 class="widgettitle">Form Edit Machine</h4>
    <div class="widgetcontent">
        {!! Form::model($mesin,['method' => 'PATCH', 'route' => ['mesin.ubah',$mesin->id],'class' => 'stdform']) !!}
        @include ('admin.mesin.form')
        {!! Form::close() !!}
    </div><!--widgetcontent-->
</div>
@endsection