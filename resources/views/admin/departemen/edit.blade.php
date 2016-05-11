@extends('layouts.app')

@section('additional_style')
@endsection

@section('additional_js')
@endsection

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li><a href="{{ route('departemen.tabel') }}">Departemen</a> <span class="separator"></span></li>
<li>Form Edit Departemen</li>
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-list-alt"></span></div>
<div class="pagetitle">
    <h5>Form Edit Departemen</h5>
    <h1>Form</h1>
</div>
@endsection

@section('maincontent')
<div class="widgetbox box-inverse">
    <h4 class="widgettitle">Form Edit Departemen</h4>
    <div class="widgetcontent">
        {!! Form::model($departemen,['method' => 'PATCH', 'route' => ['departemen.ubah',$departemen->id],'class' => 'stdform']) !!}
        @include ('admin.departemen.form')
        {!! Form::close() !!}
    </div><!--widgetcontent-->
</div>
@endsection