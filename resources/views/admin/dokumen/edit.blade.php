@extends('layouts.app')

@section('additional_style')
<link href="{{ asset('/assets/css/select2.css') }}" rel="stylesheet">
@endsection

@push('additional_js')
@include('admin.dokumen.script')
@endpush

@section('navigator')
<li><a href="{{ route('home.root') }}"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
<li><a href="{{ route('dokumen.tabel') }}">Dokumen</a> <span class="separator"></span></li>
<li>Form Edit Dokumen</li>
@endsection

@section('pageheader')
<div class="pageicon"><span class="iconfa-list-alt"></span></div>
<div class="pagetitle">
    <h5>Form Edit Dokumen</h5>
    <h1>Form</h1>
</div>
@endsection

@section('maincontent')
<div class="widgetbox box-inverse">
    <h4 class="widgettitle">Form Edit Dokumen</h4>
    <div class="widgetcontent">
        {!! Form::model($dokumen,['method' => 'PATCH', 'route' => ['dokumen.ubah',$dokumen->id],'class' => 'stdform','files'=> true]) !!}
        @include ('admin.dokumen.form')
        {!! Form::close() !!}
    </div><!--widgetcontent-->
</div>
@endsection