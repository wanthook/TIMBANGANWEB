@extends('layouts.app')

@section('additional_style')
@endsection

@section('additional_js')
@endsection

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li><a href="{{ route('mesin.tabel') }}">Machine</a> <span class="separator"></span></li>
<li>Form Add Machine</li>
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-list-alt"></span></div>
<div class="pagetitle">
    <h5>Form Add Machine</h5>
    <h1>Form</h1>
</div>
@endsection

@section('maincontent')
<div class="widgetbox box-inverse">
    <h4 class="widgettitle">Form Add Machine</h4>
    <div class="widgetcontent">
        {!! Form::open(array('url' => route('mesin.tambah'),'class' => 'stdform')) !!}
        @include ('admin.mesin.form')
        {!! Form::close() !!}
    </div><!--widgetcontent-->
</div>
@endsection